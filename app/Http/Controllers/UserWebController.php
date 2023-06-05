<?php

namespace App\Http\Controllers;

use App\Models\InstantOffer;
use App\Models\Lead;
use App\Models\Lists;
use App\Models\ListsPropertiesAssoc;
use App\Models\Properties;
use App\Models\User;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Str;
use Twilio\Rest\Client;
use xmlapi;

class UserWebController extends Controller
{
    public function userIndex(Request $request)
    {
        // dd($_SERVER['HTTP_HOST']);
        // $Lead_Id = $_SERVER->key;
        $DynamicData = Lead::where('domain', $_SERVER['HTTP_HOST'])->get();
        $Lead_Id = $DynamicData[0]->id;
        return view('user_web.step1', compact('DynamicData','Lead_Id'));
    }

    public function saveCounter(Request $request, $id) {
        // dd($request);
        $offer = InstantOffer::find($id);
        $offer->counter = $request->code;
        $offer->status = "counter";
        $offer->save();
        $DynamicData = Lead::where('id', $offer->lead_id)->get();
        return view('user_web.counter', compact('DynamicData'));
    }

    public function saveAddress(Request $request)
    {
        // dd($request['lead_id']);
        // dd($request['address']);
        $query = new InstantOffer;
        $query->lead_id = $request['lead_id'];
        if(isset($request->code)) {
            $prop = Properties::where('prop_code', $request->code)->first();
            // dd($request->code);
            if(empty($prop)) {
                return redirect()->back()->withErrors(['msg' => 'Invalid Code.']);
            }
            $query->code = $request->code;
            $query->address = $prop->PropertyAddress;
            $query->name = $prop->OwnerName;
            $query->email = $prop->OwnerEmailAddress;
            $query->phone = $prop->OwnerPhoneNumber;
            $query->offer_price = $prop->insta_offer;
            $query->arv = $prop->insta_price;

            $query->save();

            return redirect()->route('user_web_step3',$query->id);
        }
        else {
            // dd("123");
            $query->address = $request['address'];
        }
        // dd(1234);
        if ($query->save()) {
            $Id = $query->id;
            return redirect()->route('user_web_step2', $Id);
        }
    }

    public function getOffer(Request $request)
    {
        $OfferData = InstantOffer::where('id', $request['instant_id'])->first();
        $GetUserData = Lead::where('id', $OfferData->lead_id)->first();
        $GetDetails = User::where('id', $GetUserData->user_id)->first();
        $GetArv = $GetDetails->offer / 100;

        $query = InstantOffer::where('id', $request['instant_id'])->update([
            'name' => $request['user_name'],
            'email' => $request['user_email'],
            'phone' => $request['user_phone'],
        ]);
        $GetAddress = InstantOffer::where('id', $request['instant_id'])->first();
        if(!($OfferData->code != null && $OfferData->code != '')){
            //Realty Mole Api

            $dash = new DashboardController;

            $geo = $dash->getLatLng($GetAddress->address);
            // dd($geo );

            $params = array(
                'address' => $GetAddress->address,
                'latitude' => $geo['lat'],
                'longitude' => $geo['lng'],
                // 'propertyType' => '',
                //Single Family, Condo, Townhouse, Manufactured, Duplex-Triplex, Apartment, Land
                // 'bedrooms' => '',
                // 'bathrooms' => '',
                // 'squareFootage' => '',
                // 'maxRadius' => '',
                // 'daysOld' => '',
                'compCount' => 5
            );
            $curl = curl_init();

            curl_setopt_array($curl, [
                CURLOPT_URL => "https://realty-mole-property-api.p.rapidapi.com/salePrice" . '?' . http_build_query($params),
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_HTTPHEADER => [
                    'X-RapidAPI-Host: realty-mole-property-api.p.rapidapi.com',
                    'X-RapidAPI-Key: 8646e26f46msh91e77a2256b72c3p1d1ee2jsn7ed8c23a6451'
                ],
            ]);

            $response = curl_exec($curl);
            // dd($response);
            $err = curl_error($curl);

            curl_close($curl);

            if ($err) {
                echo "cURL Error #:" . $err;
            } else {
                // echo $response;
            }
            $response = json_decode($response, true);
            // dd($response);
            $OfferPrice = round($response['price'] * $GetArv);
            //Insert Offer Price
            $query2 = InstantOffer::where('id', $request['instant_id'])->update([
                'offer_price' => $OfferPrice,
                'arv' => $response['price'],
            ]);

            $this->uploadProp($request['instant_id']);

        }
        else {
            $prop = Properties::where('prop_code', $OfferData->code)->first();
            InstantOffer::where('id', $request['instant_id'])->update([
                'offer_price' => $prop->insta_price,
                'arv' => $prop->insta_offer,
            ]);
        }


        return redirect()->route('user_web_step3', $request['instant_id']);

    }

    public function uploadProp($i_id) {
        $offer = InstantOffer::find($i_id);
        $lead = Lead::where('id', $offer->lead_id)->first();
        $addedProperty = new Properties;
        $addedProperty->userid = $lead->user_id;
        $addedProperty->PropertyAddress = $offer->address;
        $addedProperty->PropertyState = "N/A";
        $addedProperty->PropertyCity = "N/A";
        $addedProperty->PropertyZipCode = "N/A";
        $addedProperty->OwnerName = $offer->name;
        $addedProperty->MailingAddress = $offer->email;
        $addedProperty->MailingCity = "N/A";
        $addedProperty->MailingState = "N/A";
        $addedProperty->MailingZipCode = "N/A";
        $addedProperty->OwnerPhoneNumber = $offer->phone;
        $addedProperty->OwnerEmailAddress = $offer->email;
        $addedProperty->DateAddedToList = now();
        $addedProperty->insta_price = 	$offer->offer_price;
        $addedProperty->insta_offer = $offer->arv;

        $addedProperty->save();
        $insertedRowCount = 0;
        $propertyId = $addedProperty->id;
        foreach($lead->list_id as $lis) {
            if ($propertyId === 0) {
                // $postFilterRejects = $postFilterRejects + 1;
            } else {
                // insert property to list associations
                $dupCheck = ListsPropertiesAssoc::where('list_id', $lis)->where('property_id', $propertyId)->get();
                if (!$dupCheck || count($dupCheck) < 1) {
                    ListsPropertiesAssoc::create(['list_id' => $lis, 'property_id' => $propertyId]);
                    $insertedRowCount = $insertedRowCount + 1;
                }
            }

            $l = Lists::find($lis);
            $l->properties_count = $l->properties_count + 1;
            $l->save();
        }



    }

    public function step2($id)
    {
        $OfferData = InstantOffer::where('id', $id)->first();
        $LeadId = $OfferData->lead_id;
        $DynamicData = Lead::where('id', $LeadId)->get();
        return view('user_web.step2', compact('DynamicData', 'id', 'OfferData'));
    }

    public function step3($id)
    {
        $InstantData = InstantOffer::where('id', $id)->first();
        $DynamicData = Lead::where('id', $InstantData->lead_id)->get();
        return view('user_web.step3', compact('DynamicData', 'InstantData'));
    }

    public function denyOffer($id)
    {
        $Query = InstantOffer::where('id', $id)->update([
            'status' => 'denied'
        ]);
        $GetData = InstantOffer::where('id', $id)->first();
        $DynamicData = Lead::where('id', $GetData->lead_id)->get();

        // $receiverNumber = $DynamicData[0]->sms_number;
        // $message = 'Address:' . $GetData->address . PHP_EOL . 'Name:' . $GetData->name . PHP_EOL . 'Phone:' . $GetData->phone . PHP_EOL . 'Status:' . $GetData->status;

        // try {

        //     $account_sid = 'AC5c5d195aebb5bcbe117ecc05305f903d';
        //     $auth_token = '180681f5fd4caa8c6237dcca43dec68c';
        //     $twilio_number = '+18336011434';

        //     $client = new Client($account_sid, $auth_token);
        //     $client->messages->create($receiverNumber, [
        //         'from' => 'Deal Hunter',
        //         'body' => $message]);


        // } catch (Exception $e) {
        //     // dd("Error: " . $e->getMessage());
        // }
        return view('user_web.deny', compact('DynamicData'));
    }

    public function acceptOffer($id)
    {
        $Query = InstantOffer::where('id', $id)->update([
            'status' => 'accepted'
        ]);
        $GetData = InstantOffer::where('id', $id)->first();
        $DynamicData = Lead::where('id', $GetData->lead_id)->get();

        $receiverNumber = $DynamicData[0]->sms_number;
        $message = 'Address:' . $GetData->address . PHP_EOL . 'Name:' . $GetData->name . PHP_EOL . 'Phone:' . $GetData->phone . PHP_EOL . 'Status:' . $GetData->status;

        try {

            $account_sid = 'AC5c5d195aebb5bcbe117ecc05305f903d';
            $auth_token = '180681f5fd4caa8c6237dcca43dec68c';
            $twilio_number = '+18336011434';

            $client = new Client($account_sid, $auth_token);
            $client->messages->create($receiverNumber, [
                'from' => 'Deal Hunter',
                'body' => $message]);


        } catch (Exception $e) {
            // dd("Error: " . $e->getMessage());
        }
        return view('user_web.accept', compact('DynamicData'));
    }

    public function cpanel()
    {
//        $WHM = new xmlapi('162.240.232.154');
//        $WHM->set_output('json');
//        $WHM->set_debug();
//        $WHM->password_auth('root', 'Deals33$$$');


//        $response = $WHM->createacct([
//            'username' => 'user001',
//            'password' => '3xyOuV9KAj',
//            'domain' => 'greatinall.com',
//            'contactemail' => 'user@gmail.com',
//        ]);

//        dd($response);
        $cpanel = new xmlapi('162.240.232.154');
        $cpanel->set_output('json');
        $cpanel->set_port('2083');
        $cpanel->set_debug();
        $cpanel->password_auth('user001', '3xyOuV9KAj');
        $response = $cpanel->api1_query('user001', "Dns", "addpop", []);
        dd(json_decode($response));
    }
}

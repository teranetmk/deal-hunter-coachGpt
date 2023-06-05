<?php

namespace App\Http\Controllers;

use App\Models\DirectCompaign;
use App\Models\Lead;
use App\Models\Lists;
use App\Models\Properties;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Inertia\Response;

use GuzzleHttp;

use \Exception\GuzzleException;
use GuzzleHttp\Client;

class DashboardController extends Controller
{
    protected $autocomepleteEndpoint = 'https://maps.googleapis.com/maps/api/place/autocomplete/json';
    protected $detailsEndpoint = 'https://maps.googleapis.com/maps/api/place/details/json';
    public function index()
    {
        $user = Auth::user();
        // get tagIds used by user
        $allTags = DB::select("select lta.tag_id as tag_id, mt.tag_name as tag_name, count(*) as property_count
from lists_properties_assocs lpa
    join lists_tags_assocs lta on lpa.list_id=lta.list_id
    join motivation_tags mt on lta.tag_id=mt.id
    join lists l on lta.list_id=l.id
where l.userid=?
group by lta.tag_id;", [$user->id]);


        return ['status' => 'success', 'tags' => $allTags];
    }


    public function sendMails(Request $request) {
            $priceInsta = 0;
            $priceEst = 0;
            $sent = 0;
            $lead = Lead::where('domain', $request->domain['domain'])->first();

            if(empty($lead->from_contact)) {
                $fromdata = [
                    'firstName' => $lead->company_name,
                    'companyName' => $lead->company_name,
                    'addressLine1' => $lead->buisness_address,
                    'city' => $lead->city,
                    'provinceOrState' => $lead->state,
                    'email' => $lead->email,
                    'phoneNumber' => $lead->phone,
                    'postalOrZip' => $lead->zip_code,
                    'country' => 'US',
                    'countryCode' => 'US',
                    'description' => $lead->buisness_address,
                    'metadata[friend]' => 'no',
                    'skipVerification' => 'false',
                ];

                $from = $this->createContact(json_encode($fromdata));

                $from = json_decode($from, true);

                $lead->from_contact = $from['id'];
                $lead->save();
            }
            foreach($request->list as $list) {
                $list = Lists::where('id', $list['id'])->with("properties")->first();
                foreach($list->properties as $property) {

                    if(empty($property->insta_offer)) {
                        $priceInsta = $this->rapidapi(["address" => $property->PropertyAddress]);
                        $priceEst = $priceInsta * (auth()->user()->offer/100);

                        $property->insta_offer = $priceEst;
                        $property->insta_price = $priceInsta;
                        $property->update();
                    }
                    else {
                        $priceEst = $property->insta_offer * (auth()->user()->offer/100);
                        $priceInsta = $property->insta_price;
                    }

                    $geo = $this->getLatLng($property->PropertyAddress);



                    $img = "https://maps.googleapis.com/maps/api/streetview?size=600x300&location=".$geo['lat'].",".$geo['lng']."&heading=151.78&pitch=-0.76&key=".env('GOOGLE_MAP_API');

                    if(empty($property->to_address)) {
                        $todata = [
                            'firstName' => $property->OwnerName,
                            'companyName' => 'PostGrid',
                            'addressLine1' => $property->MailingAddress,
                            'city' => $property->MailingAddress,
                            'provinceOrState' => $property->MailingState,
                            'email' => $property->OwnerEmailAddress,
                            'phoneNumber' => $property->OwnerPhoneNumber,
                            'postalOrZip' => $property->MailingZipCode,
                            'country' => 'US',
                            'countryCode' => 'US',
                            'description' => $property->PropertyAddress,
                            'metadata[friend]' => 'no',
                            'skipVerification' => 'false',
                        ];

                        $to = $this->createContact(json_encode($todata));

                        $to = json_decode($to, true);

                        $property->to_address = $to['id'];
                        $property->save();
                    }

                    if(empty($property->prop_code)) {
                        $code = $this->getCode();
                        $property->prop_code = $code;
                        $property->save();
                    }

                    $to = $property->to_address;

                    $data = ['price' => $priceInsta, 'domain' => $request->domain['domain'], 'phone' => $request->phone, 'img' => $img, 'from' => $lead->from_contact, 'to' => $to, 'name' => $property->OwnerName, 'code' => $property->prop_code];

                    $card = $this->sendPostCard($data);

                    $card = json_decode($card, true);

                    if(isset($card['id'])) {
                        $sent = $sent + 1;
                    }
                }
            }

            $direct = new DirectCompaign;
            $direct->name = $request->name;
            $direct->user_id = auth()->user()->id;
            $direct->date_sent = now();
            $direct->sent_count = $sent;
            $direct->total_count = $sent;
            $direct->save();

            $coms = DirectCompaign::where('user_id', auth()->user()->id)->get();

            return ['status' => 'success', 'message' => $sent.' postcards sent', 'coms' => $coms];
    }

    public function createContact($data) {
        // return $json_data;
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api.postgrid.com/print-mail/v1/contacts',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => $data,
        CURLOPT_HTTPHEADER => array(
            'x-api-key: test_sk_pq6UpmNuFHSyKRYVgVgHMB',
            'Content-Type: application/json'
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return  $response;
    }

    public function sendPostCard($data) {

        $json_data = json_encode([
            'to' => $data['to'],
            'from' => $data['from'],
            'size' => '11x6',
            'frontHTML' => view('post_template_iframe_1')->with('domain', $data['domain'])->with('phone', $data['phone'])->with('img', $data['img'])->with('price', $data['price'])->with('name', $data['name'])->with('code', $data['code'])->render(),
            'backHTML' => 'Hello',
            'sendDate' => \Carbon\Carbon::parse(now())->addDays(1),
            'express' => 'false',
            'description' => $data['domain'],
            'mailingClass' => 'first_class',
            'mergeVariables[language]' => 'english',
            'metadata[company]' => 'PostGrid',
        ]);

        // return $json_data;
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api.postgrid.com/print-mail/v1/postcards',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => $json_data,
        CURLOPT_HTTPHEADER => array(
            'x-api-key: test_sk_pq6UpmNuFHSyKRYVgVgHMB',
            'Content-Type: application/json'
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return  $response;
    }


    public function getPropertiesDataSingleLead($lead) {
        $property = Properties::with(["list"])->find($lead);
        $priceInsta = 0;
        $priceEst = 0;
        if(empty($property->insta_offer)) {
            $priceInsta = $this->rapidapi(["address" => $property->PropertyAddress]);
            $priceEst = $priceInsta * (auth()->user()->offer/100);

            $property->insta_offer = $priceEst;
            $property->insta_price = $priceInsta;
            $property->update();
        }
        else {
            $priceEst = $property->insta_offer * (auth()->user()->offer/100);
            $priceInsta = $property->insta_price;
        }

        $list = $property->list()->first();
        $geo = $this->getLatLng($property->PropertyAddress);
        if(empty($property->prop_code)) {
            $code = $this->getCode();
            $property->prop_code = $code;
            $property->save();
        }
        return Inertia::render('Clients/NewLeadPage', ['property' => $property->toArray(), 'list' => $list->toArray(), "geo" => $geo, "disbaled" => true ]);
    }

    public function getLatLng($address) {

        $client = new \GuzzleHttp\Client();

        $payload = [
            'query' => [
                'key' => "AIzaSyCXdWIB0il6Qzu4oEU0g6aUzXDfb1jLZ6g",
                'input' => $address,
                'components' =>'country:usa'
            ],
        ];
        $response = $client->request('GET', $this->autocomepleteEndpoint, $payload);


        $responseDecoded = json_decode($response->getBody());
        // dd($responseDecoded);
        $matches = [];
        if (isset($responseDecoded->predictions)) {
            foreach ($responseDecoded->predictions as $key => $prediction) {
                array_push($matches, ['id' => $prediction->place_id, 'text' => $prediction->description]);
            }
        }

        return $this->searchPlaceById($matches[0]["id"]);

    }
    function getCityState($zip, $blnUSA = true) {
        $url = "https://maps.googleapis.com/maps/api/geocode/json?address=".$zip."&sensor=true&key=".env('GOOGLE_MAP_API');

        $address_info = file_get_contents($url);
        // return $address_info;
        $json = json_decode($address_info);
        $city = "";
        $state = "";
        $country = "";
        if (count($json->results) > 0) {
            //break up the components
            $arrComponents = $json->results[0]->address_components;

            foreach($arrComponents as $index=>$component) {
                $type = $component->types[0];

                if ($city == "" && ($type == "sublocality_level_1" || $type == "locality") ) {
                    $city = trim($component->short_name);
                }
                if ($state == "" && $type=="administrative_area_level_1") {
                    $state = trim($component->short_name);
                }
                if ($country == "" && $type=="country") {
                    $country = trim($component->short_name);

                    if ($blnUSA && $country!="US") {
                        $city = "";
                        $state = "";
                        break;
                    }
                }
                if ($city != "" && $state != "" && $country != "") {
                    //we're done
                    break;
                }
            }
        }
        if(empty($city)){
            return ['status' => 'error', 'message' => 'invalid zipcode'];
        }
        $arrReturn = ['status'=>'success','list' => array("zip" => $zip,"city"=>$city, "state"=>$state, "country"=>$country)];
        return json_encode($arrReturn);
    }

    public function getCodeData() {
        return $this->getCityState(request()->address);
    }

    public function searchPlaceById($id)
    {
        $itemToReturn = null;
        $client = new \GuzzleHttp\Client();

        $payload = [
            'query' => [
                'key' => "AIzaSyCXdWIB0il6Qzu4oEU0g6aUzXDfb1jLZ6g",
                'place_id' => $id,
            ],
        ];

        $client = new \GuzzleHttp\Client();
        $response = $client->request('GET', $this->detailsEndpoint, $payload);

        if ($response->getStatusCode() !== 200) {
            //return $itemToReturn;
            return null;
        }

        $responseDecoded = json_decode($response->getBody());



        if (isset($responseDecoded->result)) {
            $itemToReturn['town'] = '';
            $itemToReturn['postal_code'] = '';
            foreach($responseDecoded->result->address_components as $comp) {
                if(in_array('postal_town', $comp->types)) {
                    $itemToReturn['town'] = $comp->short_name;
                }
                if(in_array('postal_code', $comp->types)) {
                    $itemToReturn['postal_code'] = $comp->short_name;
                }
            }
            $itemToReturn['google_place_id'] = $id;

            //Find the lat and lng
            $itemToReturn['lat'] = $responseDecoded->result->geometry->location->lat;
            $itemToReturn['lng'] = $responseDecoded->result->geometry->location->lng;

            //name
            $itemToReturn['name'] = $responseDecoded->result->name;

            //return $itemToReturn;
            return $itemToReturn;
        } else {
            //return null;
            return [];
        }
    }

    public function getPropertiesDataSingle($list) {
        $user = Auth::user();
        $userId = Auth::user()->id;
        $properties = Lists::with("properties")->where('id',$list)->first();
        $property = $properties->toArray();
        $finalResult = [];
        foreach ($properties->properties as $row) {
            $finalResult[] = [
                'id'                => $row->id,
                'PropertyAddress'   => $row->PropertyAddress,
                'PropertyCity'      => $row->PropertyCity,
                'PropertyState'     => $row->PropertyState,
                'PropertyZipCode'   => $row->PropertyZipCode,
                'OwnerName'         => $row->OwnerName,
                'OwnerPhoneNumber'  => $row->OwnerPhoneNumber,
                'OwnerEmailAddress' => $row->OwnerEmailAddress,
                'MailingAddress'    => $row->MailingAddress,
                'MailingCity'       => $row->MailingCity,
                'MailingState'      => $row->MailingState,
                'MailingZipCode'    => $row->MailingZipCode,
                'DateAddedToList'   => date_format(date_create($row->DateAddedToList), 'm/d/y'),
                'uniqueTagCount'    => 10
            ];
        }

        return Inertia::render('Clients/LeadsLists', ['propertiesData' => $finalResult, 'propertyData' => $property, ]);
    }

    public function rapidapi($data) {
        $geo = $this->getLatLng($data['address']);
        $params = array(
            'address' => $data['address'],
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
            CURLOPT_URL => "https://realty-mole-property-api.p.rapidapi.com/salePrice". '?' . http_build_query($params),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => [
                env('RAPID_API_HOST'),
                env('RAPID_API_KEY')
            ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            // echo $response;
        }

        $response = json_decode($response, true);
        // dd($response['price']);

        return $response['price'];
    }

    public function getPropertiesData(Request $request)
    {
        $user = Auth::user();
        $requiredTags = $request->requiredTags;
        $requiredTagsId = [];
        foreach ($requiredTags as $rt) {
            $requiredTagsId[] = $rt['tag_id'];
        }

        $propertyData = $this->getData($user->id, $requiredTagsId);
        return ['status' => 'success', 'propertyData' => $propertyData];


    }

    public function getData($userId, $requiredTagsId)
    {
        //todo implement lazy load and pagination
        $rows = [];

        $rows = DB::select("SELECT lpa.list_id as list_id, lpa.property_id as property_id, lta.tag_id as tag_id
FROM lists_properties_assocs lpa
    join properties p on lpa.property_id=p.id
    inner join lists_tags_assocs lta on lpa.list_id=lta.list_id
where p.userid=?
order by lpa.property_id", [$userId]);

        $propertyUsage = [];
        foreach ($rows as $row) {
            if (in_array($row->tag_id, $requiredTagsId)) {
                $propertyId = $row->property_id;

                if (isset($propertyUsage[$propertyId])) {
                    // add list_id if unique - will avoid same file duplicates
                    if (!in_array($row->list_id, $propertyUsage[$propertyId]['list_ids'])) {
                        $propertyUsage[$propertyId]['list_ids'][] = $row->list_id;
                    }

                    // add tag_ids if unique
                    if (!in_array($row->tag_id, $propertyUsage[$propertyId]['tag_ids'])) {
                        $propertyUsage[$propertyId]['tag_ids'][] = $row->tag_id;
                    }
                } else {
                    $propertyUsage[$row->property_id] = ['tag_ids' => [$row->tag_id], 'list_ids' => [$row->list_id]];
                }
            }
        }

        $allPropertyIds = array_keys($propertyUsage);
        if (empty($allPropertyIds) || count($allPropertyIds) <= 0) {
            return [];
        }
        $allPropertyIdsString = implode(",", $allPropertyIds);


        $propertyRows = DB::select("select id, PropertyAddress, PropertyCity, PropertyState, PropertyZipCode, OwnerName, OwnerPhoneNumber, OwnerEmailAddress, MailingAddress, MailingCity, MailingState, MailingZipCode, DateAddedToList
from properties where id in " . sprintf('(%s)', $allPropertyIdsString));

        $finalResult = [];
        foreach ($propertyRows as $row) {
            $finalResult[] = [
                'id'                => $row->id,
                'PropertyAddress'   => $row->PropertyAddress,
                'PropertyCity'      => $row->PropertyCity,
                'PropertyState'     => $row->PropertyState,
                'PropertyZipCode'   => $row->PropertyZipCode,
                'OwnerName'         => $row->OwnerName,
                'OwnerPhoneNumber'  => $row->OwnerPhoneNumber,
                'OwnerEmailAddress' => $row->OwnerEmailAddress,
                'MailingAddress'    => $row->MailingAddress,
                'MailingCity'       => $row->MailingCity,
                'MailingState'      => $row->MailingState,
                'MailingZipCode'    => $row->MailingZipCode,
                'DateAddedToList'   => date_format(date_create($row->DateAddedToList), 'm/d/y'),
                'tag_ids'           => $propertyUsage[$row->id]['tag_ids'],
                'list_ids'          => $propertyUsage[$row->id]['list_ids'],
                'uniqueTagCount'    => count($propertyUsage[$row->id]['tag_ids'])
            ];
        }

        return $finalResult;
    }
}

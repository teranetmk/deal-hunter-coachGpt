<?php

namespace App\Http\Controllers;

use App\Models\Compaign;
use App\Models\CompaignLog;
use App\Models\User;
use Aws\Exception\AwsException;
use Aws\Polly\PollyClient;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Http;

class VoiceMailController extends Controller
{

    public function sendForm() {
        return view("sendform");
    }

    public function status_voice(Request $request) {
        \Log::info($request);
        if($request["dial status"] == "Failure") {
            \Log::info("faisal");
        }

        if($request["dial status"] == "OK") {
            $com = CompaignLog::where('compaign_board_id', $request["campaign id"])->first();
            $conDB = Compaign::where('id', $com->compaign_id)->first();
            $user = User::where('id', $conDB->user_id)->first();
            $conDB->sent = $conDB->sent + 1;
            $conDB->unsent = $conDB->unsent - 1;
            $conDB->save();
            $user->total_credits = $user->total_credits - 1;
            $user->save();
        }


    }

    public function status_voice1() {
        $request = $_GET;
        dd($request);
        \Log::info($request);
        if($request["dial status"] == "Failure") {
            \Log::info("faisal");
        }

        if($request["dial status"] == "OK") {
            $com = CompaignLog::where('compaign_board_id', $request["campaign id"])->first();
            $conDB = Compaign::where('id', $com->compaign_id)->first();
            $conDB->sent = $conDB->sent + 1;
            $conDB->unsent = $conDB->unsent - 1;
            $conDB->save();
            $user = User::where('id', $conDB->user_id)->first();
            $user->total_credits = $user->total_credits - 1;
            $user->save();
        }


    }


    public function send() {

        $config = [
            'version' => env("AWS_POLLY_VERSION"),
            'region' => env("AWS_POLLY_REGION"),
            'credentials' => [
                'key' => env("AWS_POLLY_KEY"),
                'secret' => env("AWS_POLLY_SECRET"),
            ],
        ];

        $client = new PollyClient($config);

        $first_name = 'Fasil ';
        $address = "5500 Grand Lake Drive, San Antonio, TX, 78244";

        $data['address'] = $address;

        $price = $this->rapidapi($data);
        $raw = '
        Hey '.$first_name.', this is Jack with WeBuyHouses!

        I’m a local investor in the area and saw your property at '.$address.'.

        I would be willing to give cash offer on the home for '.$price.'

        We can purchase as-is no renovations required and would be able to close by the end of this week saving you realtor commissions.

        Let me know if you are interested, you can call or text me at 123-456-7890

        Talk Soon!
        ';


        $text = "<speak>
        <prosody rate='medium'>".$raw." </prosody>
        </speak>";
        $args = [
            'OutputFormat' => 'mp3',
            'Text' => $text,
            'TextType' => 'ssml',
            'VoiceId' => 'Matthew', //pass preferred voice id here
        ];

        $result = $client->synthesizeSpeech($args);

        $resultData = $result->get('AudioStream')->getContents();

        $name = 'voicemails/voice_'.time().'.mp3';

        // \Storage::disk('s3')->put($name, $resultData);

        // $url = \Storage::disk('s3')->url( $name);

        \Storage::disk('local')->put("public/".$name, $resultData);

        $url = \Storage::disk('local')->url( $name);



        // return $url;

         $this->sendVoicemail([
            'url' => $url,
            'name' => $name
         ]);
    }

    public function sendVoicemail($data) {
        // dd("https://33c6-182-191-130-8.in.ngrok.io".$data["url"]);


        $client = new \GuzzleHttp\Client();
        $response = $client->request('POST', 'https://www.slybroadcast.com/gateway/vmb.adv.json.php', [
            'form_params' => [
                'c_uid' => env("SLYBROADCASTER_EMAIL"),
                'c_password' => env("SLYBROADCASTER_PASSWORD"),
                "c_callerID" => "6173999982",
                'c_phone' => '7047758234',
                // 'c_phone' => '5853638799',

                'c_url' => "https://33c6-182-191-130-8.in.ngrok.io".$data["url"],
                'c_audio' => 'mp3',
                'c_date' => 'now',
                'c_method' => 'new_campaign',
                'mobile_only' => '1',
                'c_dispo_url' => "https://33c6-182-191-130-8.in.ngrok.io/status_voice"
            ]
        ]);
        $responseBody = json_decode($response->getBody(), true);

        // if(\Storage::disk('s3')->exists($data['name'])) {
        //     \Storage::disk('s3')->delete($data['name']);
        // }

        dd($responseBody);

    }

    public function rapidapi($data) {

        $params = array(
            'address' => $data['address'],
            'latitude' => '',
            'longitude' => '',
            'propertyType' => '',
            //Single Family, Condo, Townhouse, Manufactured, Duplex-Triplex, Apartment, Land
            'bedrooms' => '',
            'bathrooms' => '',
            'squareFootage' => '',
            'maxRadius' => '',
            'daysOld' => '',
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

        // dd($response);

        return $response['price'];
    }
}

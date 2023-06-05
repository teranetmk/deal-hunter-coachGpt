<?php

namespace App\Http\Controllers;

use App\Jobs\SendMails​;
use App\Models\Compaign;
use App\Models\CompaignLog;
use App\Models\Lists;
use App\Models\ListsPropertiesAssoc;
use App\Models\ListsTagsAssoc;
use App\Models\MotivationTags;
use App\Models\Properties;
use Barryvdh\Debugbar\Twig\Extension\Debug;
use DebugBar\DebugBar;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Inertia\Response;
use Spatie\SimpleExcel\SimpleExcelReader;
use Illuminate\Support\Facades\DB;
use Aws\Exception\AwsException;
use Aws\Polly\PollyClient;


use Illuminate\Support\Facades\Http;

use Illuminate\Http\Request;

class CompaignController extends Controller
{
    public function compaignDelete(Request $request, $id) {
         // delete tag Associations
         DB::delete('delete from compaign_lists where compaign_id=?', [$request->listId]);

         // delete list
         DB::delete('delete from compaign_logs where compaign_id=?', [$request->listId]);


         DB::delete('delete from compaigns where id=?', [$request->listId]);

         $compaignsData = Compaign::with(['lists', 'logs'])->where('user_id', auth()->user()->id)->get();
         return ['status' => 'success', 'message' => 'Compaign deleted successfully', "compaigns" => $compaignsData];
    }
    public function status_voice(Request $request) {
        \Log::info($request);
        \Log::info($_POST);
    }

    public function testJob($data) {
        \Log::info("message");
        \Log::info($data);
    }
    public function sendVoice(Request $request) {
        $compaign = new Compaign;

        $compaign->user_id = auth()->user()->id;
        $compaign->compaign_name = $request->compaignName;
        $compaign->callback_number = $request->callbackNumber;
        $compaign->date_sent = now();

        $compaign->save();

        foreach($request["lists_input"] as $list) {
            $lists[] = $list['id'];
        }

        $compaign->lists()->sync($lists);
        SendMails​::dispatch($request->all(), auth()->user(), $compaign->id);
        // return 123;
        return ["status" => "success", "message" => "RoboDrop has been sent out!"];
        // $first_name = 'Fasil ';
        // $address = "5500 Grand Lake Drive, San Antonio, TX, 78244";

        // $data['address'] = $address;

        // // $price = $this->rapidapi($data);

        $tags = $this->extractVariables($request->message);
        $lists = [];
        foreach($request->lists_input as $list) {
            $lists[] = $list['id'];
        }

        $compaign = new Compaign;

        $compaign->user_id = auth()->user()->id;
        $compaign->compaign_name = $request->compaignName;
        $compaign->callback_number = $request->callbackNumber;
        $compaign->date_sent = now();

        $compaign->save();

        $compaign->lists()->sync($lists);

        // $compaign = Compaign::find(1);

        $lists = Lists::whereIn('id', $lists)->with("properties")->get();

        // return $lists;

        $message = $request->message;
        $data["callback"] = $request->callbackNumber;
        $data["compaign_id"] = $compaign->id;

        $dataRes = [];
        foreach($lists as $list) {
            foreach($list->properties as $lead) {
                foreach($tags as $tag) {
                    $message = str_replace('{'.$tag.'}', $lead->$tag, $message);
                }
                $url = $this->generateVoice($message);
                $data["phone"] = $lead->OwnerPhoneNumber;
                $data["url"] = $url;
                $data["back_url"] = env('LIVE_BACK_URL');

                $dataRes = $this->sendVoicemail($data);
                // return $dataRes;

                $dataLog = [
                    "compaign_board_id" => $dataRes["session_id"],
                    "compaign_id" => $data["compaign_id"],
                    "list_id" => $list->id,
                    "property_id" => $lead->id,
                    "message" => $message,
                    "status" => 0,
                ];

                CompaignLog::create($dataLog);
                $compaign->unsent = $compaign->unsent + 1;
                $compaign->save();

            }
        }

        return ["status" => "success", "message" => "Data has been sent."];
    }
    public function verifyVoice(Request $request) {
        if (empty($request->message) ) {
            return ["status" => "error", "message" => "Please Provide Message."];
        }
        $url = $this->generateVoice($request->message);

        return ["status" => "success", "message" => "Now sound will be played.", "url" => $url];

    }

    public function generateVoice($message) {
        $config = [
            'version' => env("AWS_POLLY_VERSION"),
            'region' => env("AWS_POLLY_REGION"),
            'credentials' => [
                'key' => env("AWS_POLLY_KEY"),
                'secret' => env("AWS_POLLY_SECRET"),
            ],
        ];

        $client = new PollyClient($config);

        $text = "<speak>
        <prosody rate='medium'>".$message." </prosody>
        </speak>";
        $args = [
            'OutputFormat' => 'mp3',
            'Text' => $text,
            'TextType' => 'ssml',
            'VoiceId' => 'Matthew', //pass preferred voice id here
        ];

        $result = $client->synthesizeSpeech($args);

        $resultData = $result->get('AudioStream')->getContents();

        $name = 'voice_'.time().'.mp3';



        // \Storage::disk('s3')->put($name, $resultData);

        // $url = \Storage::disk('s3')->url( $name);

        \Storage::disk('local')->put("public/".$name, $resultData);

        $url = \Storage::disk('local')->url( $name);

        // $resultData = file_get_contents($url);

        // $resultData->move(public_path('/uploadednotes'), $name);

        return $url;
    }

    public function extractVariables($s) {
        $variablesFound = collect();

        for ($startIndex = 0; $startIndex < strlen($s); $startIndex++) {
            if ($s[$startIndex] == '{') {
                // We found a '<'. Now find the matching '>'
                $endIndex = $startIndex + 1;
                while($endIndex < strlen($s) && $s[$endIndex] != '}') {
                    $endIndex++;
                }
                // We found a matching '>'.
                $length = $endIndex - $startIndex;
                // Remember we do not want the '<' or '>' at the ends.
                $variableName = substr($s, $startIndex + 1, $length - 1);
                $variablesFound->push($variableName);
            }
        }

        return $variablesFound;
    }
    public function sendVoicemail($data) {


        $client = new \GuzzleHttp\Client();
        $response = $client->request('POST', 'https://www.slybroadcast.com/gateway/vmb.adv.json.php', [
            'form_params' => [
                'c_uid' => env("SLYBROADCASTER_EMAIL"),
                'c_password' => env("SLYBROADCASTER_PASSWORD"),
                // "c_callerID" => "6173999982",
                "c_callerID" => $data["callback"],
                // 'c_phone' => '7047758234',
                'c_phone' => $data["phone"],
                'c_url' => "https://valentinos-rotherham.co.uk/voice.mp3",
                'c_audio' => 'mp3',
                'c_date' => 'now',
                'c_method' => 'new_campaign',
                'mobile_only' => '1',
                'c_dispo_url' => "https://840c-116-71-183-148.in.ngrok.io/status_voice"
            ]
        ]);
        $responseBody = json_decode($response->getBody(), true);

        // if(\Storage::disk('s3')->exists($data['name'])) {
        //     \Storage::disk('s3')->delete($data['name']);
        // }

        return $responseBody;

    }

    public function verifyStep1(Request $request) {

        if (empty($request->compaignName) ) {
            return ["status" => "error", "message" => "Please Provide Compaign Name."];
        }


        if (empty($request->callbackNumber) ) {
            return ["status" => "error", "message" => "Please provide call back number."];
        }

        if (empty($request->lists_input) || count($request->lists_input) < 1) {
            return ["status" => "error", "message" => "Please provide at least one list"];
        }

        return ["status" => "success", "message" => "Step 1 completed."];


    }
    public function index() {
        // dd(env('LIVE_BACK_URL'));
        $user = Auth::user();
        $allTags = (new MotivationTagsController)->getAllAvailableTagsForUser($user->id);
        $listToSend = $this->getListRowsForDisplay($user->id);
        $lists = Lists::where('userid' , auth()->user()->id)->get();

        $compaignsData = Compaign::has('lists', '>', 0)->with(['lists', 'logs'])->where('user_id', auth()->user()->id)->get();
        // return $compaignsData;
        // dd($compaignsData);
        $personalizedTags = [['name' => 'PropertyAddress'], ['name' => 'PropertyState'], ['name' => 'PropertyZipCode'], ['name' => 'OwnerName'], ['name' => 'OwnerEmailAddress'], ['name' => 'OwnerPhoneNumber'], ['name' => 'MailingAddress'], ['name' => 'MailingCity'], ['name' => 'MailingState'], ['name' => 'MailingZipCode'], ['name' => 'InstaOffer']];
        return Inertia::render('Clients/Compaigns', ['allMotivationTags' => $allTags, 'allLists' => $listToSend, 'lists' => $lists, 'personalizedTags' => $personalizedTags, 'compaignsData' => $compaignsData]);
    }

    public function newIndex() {
        $compaignsData = Compaign::with('lists')->where('user_id', auth()->user()->id)->get();
        return $compaignsData;
    }

    public function getListRowsForDisplay($userId)
    {
        $allLists = DB::select(
            "SELECT l.id as listid, l.filename as filename, l.properties_count as properties_count, l.created_at as import_time, mt.tag_name as tag_name
            FROM `lists` l
                right join lists_tags_assocs lta on l.id=lta.list_id
                left join motivation_tags mt on lta.tag_id=mt.id
            where l.userid=?", [$userId]);

        $listCondensed = [];
        //$allLists = Lists::where('userid', $user->id)->get();
        foreach ($allLists as $list) {
            $listId = $list->listid;
            if (isset($listCondensed[$listId])) {
                $listCondensed[$listId]['tags'][] = $list->tag_name;
            } else {
                $listCondensed[$listId] = ['listId'           => $list->listid,
                                           'fileName'         => $list->filename,
                                           'properties_count' => $list->properties_count,
                                           'import_time'      => date_format(date_create($list->import_time), 'm/d/y'),
                                           'tags'             => [$list->tag_name]];
            }
        }

        // remove indexes
        $listToSend = [];
        foreach ($listCondensed as $lRow) {
            $listToSend[] = $lRow;
        }

        return $listToSend;
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

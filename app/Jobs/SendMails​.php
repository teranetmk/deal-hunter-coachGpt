<?php

namespace App\Jobs;

use App\Http\Controllers\CompaignController;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Http\Request;
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

class SendMails​ implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $request, $user, $compaign;

    /**
     * Create a new job instance.
     *
     * @return void
     */

    public function __construct( $request, $user, $compaign)
    {
        $this->request = $request;
        $this->user = $user;
        $this->compaign = $compaign;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->sendVoice($this->request, $this->user, $this->compaign);
    }

    public function sendVoice( $request, $user, $compaign) {

        $compaign = Compaign::find($compaign);

        // $first_name = 'Fasil ';
        // $address = "5500 Grand Lake Drive, San Antonio, TX, 78244";

        // $data['address'] = $address;

        // // $price = $this->rapidapi($data);

        $tags = $this->extractVariables($request["message"]);
        $lists = [];
        foreach($request["lists_input"] as $list) {
            $lists[] = $list['id'];
        }

        // $compaign = new Compaign;

        // $compaign->user_id = $user["id"];
        // $compaign->compaign_name = $request["compaignName"];
        // $compaign->callback_number = $request["callbackNumber"];
        // $compaign->date_sent = now();

        // $compaign->save();

        // $compaign->lists()->sync($lists);

        // $compaign = Compaign::find(1);

        $lists = Lists::whereIn('id', $lists)->with("properties")->get();

        $message = $request["message"];
        $data["callback"] = $request["callbackNumber"];
        $data["compaign_id"] = $compaign->id;

        $dataRes = [];
        foreach($lists as $list) {
            foreach($list->properties as $lead) {
                foreach($tags as $tag) {
                    $message = str_replace('{'.$tag.'}', $lead->$tag, $message);
                }
                $url = $this->generateVoice($message);

                $data["phone"] = $lead->OwnerPhoneNumber;
                $data["url"] = asset($url);
                $data["back_url"] = env('LIVE_BACK_URL');

                $compaign->unsent = $compaign->unsent + 1;
                $compaign->save();

                $dataRes = $this->sendVoicemail($data);
                \Log::info($dataRes);
                // return $dataRes;

                try {
                    $dataLog = [
                        "compaign_board_id" => $dataRes["session_id"],
                        "compaign_id" => $data["compaign_id"],
                        "list_id" => $list->id,
                        "property_id" => $lead->id,
                        "message" => $message,
                        "status" => 0,
                    ];

                    CompaignLog::create($dataLog);
                }

                catch(\Throwable $t) {

                }


            }
        }

        return ["status" => "success", "message" => "Data has been sent."];
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
                'c_url' => $data["url"],
                'c_audio' => 'mp3',
                'c_date' => 'now',
                'c_method' => 'new_campaign',
                'mobile_only' => '1',
                'c_dispo_url' => $data["back_url"],
            ]
        ]);
        $responseBody = json_decode($response->getBody(), true);

        // if(\Storage::disk('s3')->exists($data['name'])) {
        //     \Storage::disk('s3')->delete($data['name']);
        // }

        return $responseBody;

    }
}

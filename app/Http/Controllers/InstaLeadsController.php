<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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

class InstaLeadsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public $basic_list = [
        [
            "desc" => "An absentee motivated seller is someone who owns a property but doesn't live in it. This could be a landlord or someone who has inherited property. These sellers may be motivated to sell their property quickly and at a discounted price, as they may not be actively using the property and may be looking to avoid additional expenses or hassles.",
            "id"
         => "absentee-owner", "value" => "Absentee Owners",
         "name" => "Absentee Owner",
         "count" => 0
        ],
        [
            "desc" => "A bankruptcy motivated seller is someone who has filed for bankruptcy and may be looking to sell their property as part of the bankruptcy process. These sellers may be motivated to sell their property quickly and at a discounted price in order to satisfy creditors and other obligations.",
            "id"
         => "bankruptcy", "value" => "Bankruptcy",
         "name" => "Bankruptcy",
         "count" => 0
        ],
        [
            "desc" => "A divorce motivated seller is someone who is going through a divorce and may be looking to sell their property quickly and at a discounted price in order to divide assets and move on from the marriage.",
            "id"
         => "divorce", "value" => "Divorce",
         "name" => "Divorce",
         "count" => 0
        ],
        [
            "desc" => "A high equity motivated seller is someone who owns a property with a significant amount of equity. These sellers may be motivated to sell their property quickly and at a discounted price, as they may be looking to cash out their equity for personal reasons or financial gain.",
            "id"
         => "high-equity", "value" => "High Equity",
         "name" => "High Equity",
         "count" => 0
        ],
        [
            "desc" => "A vacant motivated seller is someone who owns a property but doesn't live in it or have it rented out to tenants. These sellers may be motivated to sell their property quickly and at a discounted price due to the expenses and challenges associated with maintaining a vacant property.",
            "id"
         => "vacant", "value" => "Vacant",
         "name" => "Vacant",
         "count" => 0
        ],
        [
            "desc" => "A pre-foreclosure motivated seller is someone who has fallen behind on their mortgage payments and is at risk of having their property foreclosed upon by the lender. These sellers may be motivated to sell their property quickly and at a discounted price in order to avoid foreclosure and its associated negative impact on their credit score.",
            "id"
         => "preforeclosure", "value" => "Pre-Foreclosure",
         "name" => "Preforeclosure",
         "count" => 0
        ],
        [
            "desc" => "An out of state motivated seller is someone who owns a property in a state different from where they live. These sellers may be motivated to sell their property quickly and at a discounted price due to distance, property management challenges, or other reasons.",
            "id"
         => "out-of-state-owner", "value" => "Out-Of-State Owners",
         "name" => "Out of State Owner",
         "count" => 0
        ],
        [
            "desc" => "A tax delinquent motivated seller is someone who has fallen behind on their property taxes and may be at risk of having their property sold at a tax auction. These sellers may be motivated to sell their property quickly and at a discounted price in order to avoid losing their property and its equity.",
            "id"
         => "tax-default", "value" => "Tax Delinquent",
         "name" => "Tax Default",
         "count" => 0
        ],
    ];

    public $pre_list = [
        [
            "desc" => "This pre-stacked motivated seller list targets property owners who don't live in their property and have a high level of equity in their property. These motivated sellers may be more willing to sell quickly and at a discounted price to unlock their equity and cash out on their investment.",
            "id"
         => "absentee-owner AND high-equity", "value" => "Absentee Owner/High Equity"],
        [
            "desc" => "This pre-stacked motivated seller list targets property owners who don't live in their property and the property is currently vacant. These motivated sellers may be more willing to sell quickly and at a discounted price to avoid the financial burden of owning a vacant property from afar.",
            "id"
         => "absentee-owner AND vacant", "value" => "Absentee Owner/Vacant"],
        [
            "desc" => "This pre-stacked motivated seller list targets property owners who are absentee and going through a divorce. Divorce proceedings often require the sale of property, and absentee ownership may add an additional layer of complication.",
            "id"
         => "absentee-owner AND divorce", "value" => "Absentee Owner/Divorce"],
        [
            "desc" => "This pre-stacked motivated seller list targets absentee property owners who are also behind on property taxes. These motivated sellers may be looking to sell quickly in order to avoid foreclosure or other legal consequences of delinquent property taxes.",
            "id"
         => "absentee-owner AND tax-default", "value" => "Absentee Owner/Tax Delinquent"],
        [
            "desc" => "This pre-stacked motivated seller list targets property owners who don't live in their property and the property is currently vacant. Out-of-state owners may find it difficult to manage a property from afar and may be motivated to sell quickly in order to avoid the financial burden of owning a vacant property from a distance.",
            "id"
         => "out-of-state-owner AND vacant", "value" => "Out-Of-State Owners/Vacant"],
        [
            "desc" => "This pre-stacked motivated seller list targets property owners who are behind on property taxes and the property is currently vacant. These motivated sellers may be looking to sell quickly in order to avoid foreclosure or other legal consequences of delinquent property taxes.",
            "id"
         => "tax-default AND vacant", "value" => "Tax Delinquent/Vacant"],
        [
            "desc" => "This pre-stacked motivated seller list targets property owners who are in pre-foreclosure and the property is currently vacant. These motivated sellers may be looking to sell quickly in order to avoid foreclosure or other legal consequences of delinquent mortgage payments.",
            "id"
         => "preforeclosure AND vacant", "value" => "Pre-Foreclosure/Vacant"],
        [
            "desc" => "This pre-stacked motivated seller list targets property owners who are in pre-foreclosure and don't live in their property. Pre-foreclosure proceedings can be complicated, and out-of-state ownership may add an additional layer of difficulty.",
            "id"
         => "preforeclosure AND out-of-state-owner", "value" => "Pre-Foreclosure/Out-Of-State Owners"],
    ];

    public function getProjections() {
        $quickLists = [];
        $data = [
            // "searchCriteria" => [
            //     "query" => "New Carlisle, OH",
            //     "quickLists" => $quickLists
            //     // "building" => $building,
            //     // "sale" => $buildingSale,
            // ],

            "searchCriteria" => [
                "query" => "Kansas City, Mo",
                "quickLists" => $quickLists
            ],
            "options" => [
                "skip" => 0,
                "take" => 0,

                "quicklistCounts" => true,
                // "skipTrace" => ($request->skip)? true : false,
            ]
        ];
        $jsonData = json_encode($data);

        // $batch_data = session('lis');
        $batch_data = $this->batchData($jsonData);
        dd($batch_data);
    }

    // Function that prints
    // the required sequence
    function split($x, $n)
    {
        $res = [];
        // If we cannot split the
        // number into exactly 'N' parts
        if($x < $n)
            $res[] = -1;

        // If x % n == 0 then the minimum
        // difference is 0 and all
        // numbers are x / n
        else if ($x % $n == 0)
        {
            for($i = 0; $i < $n; $i++)
            {
                $res[] =  ($x / $n);
            }
        }

        else
        {
            // upto n-(x % n) the values
            // will be x / n
            // after that the values
            // will be x / n + 1
            $zp = $n - ($x % $n);
            $pp = $x / $n;
            for ($i = 0; $i < $n; $i++)
            {
                if($i >= $zp)
                {
                    $res[] = (int)$pp + 1;
                }
                else
                {
                    $res[] =  (int)$pp;
                }
            }
        }

        return $res;
    }

    function generateProjections(Request $request) {
        $building = [];
        $buildingSale = [];
        if($request->filters["sqftmin"] != null && $request->filters["sqftmin"] != '') {
            $building["totalBuildingAreaSquareFeet"] = [
                "min" => (Float)$request->filters["sqftmin"],
                "max" => (Float)$request->filters["sqftmax"],
            ];
        }
        if($request->filters["bedmin"] != null && $request->filters["bedmin"] != '') {
            $building["bedroomCount"] = [
                "min" => (Int)$request->filters["bedmin"],
                "max" => (Int)$request->filters["bedmax"],
            ];
        }

        if($request->filters["bathmin"] != null && $request->filters["bathmin"] != '') {
            $building["bathroomCount"] = [
                "min" => (Int)$request->filters["bathmin"],
                "max" => (Int)$request->filters["bathmax"],
            ];
        }

        if($request->filters["yearmin"] != null && $request->filters["yearmin"] != '') {
            $building["yearBuilt"] = [
                "min" => (Int)$request->filters["yearmin"],
                "max" => (Int)$request->filters["yearmax"],
            ];
        }

        if($request->filters["sdatemin"] != null && $request->filters["sdatemin"] != '') {
            $buildingSale["lastSaleDate"] = [
                "minDate" => $request->filters["sdatemin"],
                "maxDate" => $request->filters["sdatemax"],
            ];
        }

        $quickLists = [];

        foreach($this->basic_list as $lis) {
            $quickLists[] = $lis["id"];
        }

        $data = [
            "searchCriteria" => [
                "query" => "New Carlisle, OH",
                // "quickLists" => $quickLists,
                // "quickLists"=> [
                //     "absentee-owner AND vacant",
                // ],
                "building" => $building,
                "sale" => $buildingSale,
            ],
            "options" => [
                "skip" => 0,
                "take" => 0,

                "quicklistCounts" => true,
            ]
        ];
        $jsonData = json_encode($data);

        // $batch_data = session('lis');
        $batch_data = $this->batchData($jsonData);

        // return $batch_data;

        $re_count = [];

        $newList = [];

        foreach($this->basic_list as $lis) {
            foreach($batch_data["results"]["quicklistCounts"] as $ql) {
                // return $ql["name"];
                if($ql["name"] == $lis["name"]) {
                    $lis['count'] =  $ql["count"];
                    $newList[] = $lis;
                }
            }

        }

        return $newList;

    }
    public function generateList(Request $request) {
        $building = [];
        $buildingSale = [];
        if($request->filters["sqftmin"] != null && $request->filters["sqftmin"] != '') {
            $building["totalBuildingAreaSquareFeet"] = [
                "min" => (Float)$request->filters["sqftmin"],
                "max" => (Float)$request->filters["sqftmax"],
            ];
        }
        if($request->filters["bedmin"] != null && $request->filters["bedmin"] != '') {
            $building["bedroomCount"] = [
                "min" => (Int)$request->filters["bedmin"],
                "max" => (Int)$request->filters["bedmax"],
            ];
        }

        if($request->filters["bathmin"] != null && $request->filters["bathmin"] != '') {
            $building["bathroomCount"] = [
                "min" => (Int)$request->filters["bathmin"],
                "max" => (Int)$request->filters["bathmax"],
            ];
        }

        if($request->filters["yearmin"] != null && $request->filters["yearmin"] != '') {
            $building["yearBuilt"] = [
                "min" => (Int)$request->filters["yearmin"],
                "max" => (Int)$request->filters["yearmax"],
            ];
        }

        if($request->filters["sdatemin"] != null && $request->filters["sdatemin"] != '') {
            $buildingSale["lastSaleDate"] = [
                "minDate" => $request->filters["sdatemin"],
                "maxDate" => $request->filters["sdatemax"],
            ];
        }

        $quickLists = explode("AND", $request->selectedTag);

        $listCreated = Lists::create([
            'userid'           => auth()->user()->id,
            'filename'         => $request->listName,
            'list_type'        => 1,
            'list_type_name' => $request->selectedTag,
            'properties_count' => -1
        ]);
        $listId = $listCreated->id;

        foreach ($quickLists as $tagRow) {
            foreach($this->basic_list as $ln) {
                if($ln['id'] == $tagRow) {
                    $tagRow = $ln['value'];
                }
            }
            $motivation = MotivationTags::where("tag_name", $tagRow)->first();
            if(!empty($motivation)) {
                ListsTagsAssoc::create(['list_id' => $listId, 'tag_id' => $motivation->id]);
            }

        }

        $cou = count($request->codes);
        $gcode = $this->split(request()->quantity, $cou);

        while($gcode[0] == -1) {
            $gcode = $this->split(request()->quantity, $cou);
        }

        $rcodes = collect($request->codes)->take(count($gcode));
        $ik = 0;
        foreach($rcodes->toArray() as $code) {
            $taking = $gcode[$ik];
            $ik = $ik + 1;
            $data = [
                "searchCriteria" => [
                    "query" => $code["city"].", ".$code["state"],
                    "quickLists" => $quickLists,
                    "building" => $building,
                    "sale" => $buildingSale,
                ],
                "options" => [
                    "skip" => 0,
                    "take" => $taking,

                    // "quicklistCounts" => true,
                    "skipTrace" => ($request->skip)? true : false,
                ]
            ];
            $jsonData = json_encode($data);

            // $batch_data = session('lis');
            $batch_data = $this->batchData($jsonData);

            // return $batch_data ;

            // request()->session()->put('lis', $batch_data);

            // return $batch_data;

            foreach($batch_data["results"]["properties"] as $prop) {
                $dataProp = [];
                $dataProp["userid"] = auth()->user()->id;
                $dataProp["PropertyAddress"] = $prop["address"]["street"] .", ".$prop["address"]["city"].", ".$prop["address"]["zip"];
                $dataProp["PropertyCity"] = $prop["address"]["city"];
                $dataProp["PropertyState"] = $prop["address"]["state"];
                $dataProp["PropertyZipCode"] = $prop["address"]["zip"];
                $dataProp["OwnerName"] = $prop["owner"]["fullName"];
                $dataProp["MailingAddress"] = $prop["owner"]["mailingAddress"]["street"] .", ".$prop["owner"]["mailingAddress"]["city"].", ".$prop["owner"]["mailingAddress"]["zip"] ?? "---";
                $dataProp["MailingCity"] = $prop["owner"]["mailingAddress"]["city"] ?? "---";
                $dataProp["MailingState"] = $prop["owner"]["mailingAddress"]["state"] ?? "---";
                $dataProp["MailingZipCode"] = $prop["owner"]["mailingAddress"]["zip"] ?? "---";
                $dataProp["OwnerPhoneNumber"] = $prop["owner"]["phoneNumbers"][0]["number"] ?? '---';
                $dataProp["OwnerEmailAddress"] = $prop["owner"]["emails"][0] ?? '---';
                $dataProp["DateAddedToList"] = $prop["dateModified"] ?? '---';

                // $addedProperty = Properties::create($dataProp);

                $addedProperty = new Properties;
                $addedProperty->userid = $dataProp["userid"];
                $addedProperty->PropertyAddress = $dataProp["PropertyAddress"];
                $addedProperty->PropertyState = $dataProp["PropertyState"];
                $addedProperty->PropertyCity = $dataProp["PropertyCity"];
                $addedProperty->PropertyZipCode = $dataProp["PropertyZipCode"];
                $addedProperty->OwnerName = $dataProp["OwnerName"];
                $addedProperty->MailingAddress = $dataProp["MailingAddress"];
                $addedProperty->MailingCity = $dataProp["MailingCity"];
                $addedProperty->MailingState = $dataProp["MailingState"];
                $addedProperty->MailingZipCode = $dataProp["MailingZipCode"];
                $addedProperty->OwnerPhoneNumber = $dataProp["OwnerPhoneNumber"];
                $addedProperty->OwnerEmailAddress = $dataProp["OwnerEmailAddress"];
                $addedProperty->DateAddedToList = $dataProp["DateAddedToList"];

                $addedProperty->save();
                $propertyId = $addedProperty->id;
                $insertedRowCount = 0;
                if ($propertyId === 0) {
                    // $postFilterRejects = $postFilterRejects + 1;
                } else {
                    // insert property to list associations
                    $dupCheck = ListsPropertiesAssoc::where('list_id', $listId)->where('property_id', $propertyId)->get();
                    if (!$dupCheck || count($dupCheck) < 1) {
                        ListsPropertiesAssoc::create(['list_id' => $listId, 'property_id' => $propertyId]);
                        $insertedRowCount = $insertedRowCount + 1;
                    }
                }
            }
        }


        $propertyCountRes = DB::select('select count(*) as c from lists_properties_assocs where list_id=?', [$listId]);

        // return $propertyCountRes;
        if (empty($propertyCountRes) || count($propertyCountRes) <= 0) {
            $lists = Lists::where('userid' , auth()->user()->id)->where('list_type', 1)->get();
            return ['status' => 'error', 'message' => "Sorry! There is not enough property leads available for your filtering settings.", 'lists' => $lists];
        } else {

            $propertyCount = $propertyCountRes[0]->c;

            Lists::where('id', $listId)->update(['properties_count' => $propertyCount]);
            $lists = Lists::where('userid' , auth()->user()->id)->where('list_type', 1)->get();
            if($propertyCount < 1) {
                return ['status' => 'error', 'message' => "Sorry! There is not enough property leads available for your filtering settings.", 'lists' => $lists];
            }

            $user = auth()->user();
            $user->total_credits = $user->total_credits - ($propertyCount * 0.5);
            $user->save();
            return ['status'              => 'success',
                    'insertedRowCount'    => $propertyCount,
                    'message' => $propertyCount." records added",
                    'lists' => $lists,
                    'credits' => auth()->user()->total_credits
            ];
        }
    }

    function batchData($jsonData) {
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api.batchdata.com/api/v1/property/search',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS =>$jsonData,
        CURLOPT_HTTPHEADER => array(
            'Accept: application/json',
            'Authorization: Bearer '.env('BATCH_TOKEN'),
            'Content-Type: application/json'
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return json_decode($response, true);
    }
    public function index() {
        // dd(env('LIVE_BACK_URL'));
        $user = Auth::user();

        $lists = Lists::where('userid' , auth()->user()->id)->where('list_type', 1)->get();



        $compaignsData = Compaign::with(['lists', 'logs'])->where('user_id', auth()->user()->id)->get();
        // return $compaignsData;
        $personalizedTags = [['name' => 'PropertyAddress'], ['name' => 'PropertyState'], ['name' => 'PropertyZipCode'], ['name' => 'OwnerName'], ['name' => 'OwnerEmailAddress'], ['name' => 'OwnerPhoneNumber'], ['name' => 'MailingAddress'], ['name' => 'MailingCity'], ['name' => 'MailingState'], ['name' => 'MailingZipCode'], ['name' => 'InstaOffer']];
        return Inertia::render('Insta/Index', [ 'lists' => $lists, 'personalizedTags' => $personalizedTags, 'compaignsData' => $compaignsData, 'basic_list' => $this->basic_list, 'pre_list' => $this->pre_list]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function instalistDelete(Request $request)
    {
        if (empty($request->listId) || $request->listId <= 0) {
            return ['status' => 'error', 'message' => 'List not found'];
        }


        $numberOfPropertiesDeleted = 0;




        $ids = DB::table('lists_properties_assocs')->where('list_id', $request->listId)->pluck('property_id');

        DB::table('lists_properties_assocs')->where('list_id', $request->listId)->delete();
        DB::table('properties')->whereIn('id', $ids)->delete();
        DB::table('lists_tags_assocs')->where('list_id', $request->listId)->delete();

        // return $ids;

        // DB::delete('delete from lists_properties_assocs where property_id=? and list_id=?', [$propertyListAssoc->property_id, $request->listId]);

        // DB::delete('delete from properties where id=?', [$propertyListAssoc->property_id]);
        // delete tag Associations
        // DB::delete('delete from lists_tags_assocs where list_id=?', [$request->listId]);

        // delete list
        DB::delete('delete from lists where id=?', [$request->listId]);

        $lists = Lists::where('userid' , auth()->user()->id)->where('list_type', 1)->get();
        return ['status' => 'success', 'message' => 'List deleted successfully', 'lists' => $lists];

    }
}

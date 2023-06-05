<?php

namespace App\Http\Controllers;

use App\Models\DirectCompaign;
use App\Models\InstantOffer;
use App\Models\Lead;
use App\Models\Lists;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;

class InstaController extends Controller
{
    public function singleList($id) {

    }

    public function get_dm_filter_data(Request $request) {
        $Leadcount = 0;
        $LeadId = 0;
        $AccptedOffer =  0;
        $DeniedOffer =  0;
        $AllOffer =  0;
        $direct_coms = DirectCompaign::where('user_id', auth()->user()->id)->whereBetween('date_sent',[$request->start, $request->end])->get();

        $Leadcount = Lead::where('user_id',Auth::user()->id)->whereBetween('created_at',[$request->start, $request->end])->count();
        if ($Leadcount > 0){
            $LeadId = Lead::where('user_id',Auth::user()->id)->first();
            $AccptedOffer =  InstantOffer::where('lead_id',$LeadId->id)->whereBetween('created_at',[$request->start, $request->end])->where('status','accepted')->count();
            $DeniedOffer =  InstantOffer::where('lead_id',$LeadId->id)->whereBetween('created_at',[$request->start, $request->end])->where('status','denied')->count();
            $AllOffer =  InstantOffer::where('lead_id',$LeadId->id)->whereBetween('created_at',[$request->start, $request->end])->count();
        }

        return ['coms' => $direct_coms, 'ao' => $AccptedOffer, 'do' => $DeniedOffer, 'ao' => $AllOffer];
    }


    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function InstaIndex(): Response
    {
        // get all lists for the user
        // get all tags for the user
        $user = Auth::user();
        $allTags = (new MotivationTagsController)->getAllAvailableTagsForUser($user->id);
        $listToSend =$lists = Lists::where('userid' , auth()->user()->id)->get();
        $Leadcount = Lead::where('user_id',Auth::user()->id)->count();
        if ($Leadcount > 0){
            $LeadId = Lead::where('user_id',Auth::user()->id)->first();
            $AccptedOffer =  InstantOffer::where('lead_id',$LeadId->id)->where('status','accepted')->count();
            $DeniedOffer =  InstantOffer::where('lead_id',$LeadId->id)->where('status','denied')->count();
            $AllOffer =  InstantOffer::where('lead_id',$LeadId->id)->count();
            $counterOffers = InstantOffer::where('lead_id',$LeadId->id)->where('status','counter')->count();
        }else{
            $Leadcount = 0;
            $LeadId = 0;
            $AccptedOffer =  0;
            $DeniedOffer =  0;
            $AllOffer =  0;
            $counterOffers = 0;

        }

        $domains = Lead::where('user_id',Auth::user()->id)->get();

        $direct_coms = DirectCompaign::where('user_id', auth()->user()->id)->get();

        return Inertia::render('Leads/insta-index', ['allMotivationTags' => $allTags, 'allLists' => $listToSend, 'accepted' => $AccptedOffer,'denied' => $DeniedOffer,'allOffers' => $AllOffer, 'domains' => $domains, 'direct_coms' => $direct_coms,'counterOffers' => $counterOffers]);
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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Lists $lists
     * @return \Illuminate\Http\Response
     */
    public function show(Lists $lists)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Lists $lists
     * @return \Illuminate\Http\Response
     */
    public function edit(Lists $lists)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Lists $lists
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Lists $lists)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Lists $lists
     * @return \Illuminate\Http\Response
     */
}

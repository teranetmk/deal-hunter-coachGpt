<?php

namespace App\Http\Controllers;

use App\Models\InstantOffer;
use App\Models\Lead;
use App\Models\Lists;
use App\Models\ListsPropertiesAssoc;
use App\Models\ListsTagsAssoc;
use App\Models\MotivationTags;
use App\Models\Properties;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;
use Spatie\SimpleExcel\SimpleExcelReader;
use Twilio\Rest\Client;

class LeadsController extends Controller
{
    public function singleList($id) {

    }

    public function get_io_filter_data(Request $request) {
        $Leadcount = 0;
        $LeadId = 0;
        $AccptedOffer =  0;
        $DeniedOffer =  0;
        $AllOffer =  0;
        $LeadId = Lead::where('user_id',Auth::user()->id)->first();

        $direct_coms = InstantOffer::where('lead_id', $LeadId->id)->whereBetween('created_at',[$request->start, $request->end])->get();

        // return $direct_coms;

        $Leadcount = Lead::where('user_id',Auth::user()->id)->count();

        if ($Leadcount > 0){

            $AccptedOffer =  InstantOffer::where('lead_id',$LeadId->id)->whereBetween('created_at',[$request->start, $request->end])->where('status','accepted')->count();
            $DeniedOffer =  InstantOffer::where('lead_id',$LeadId->id)->whereBetween('created_at',[$request->start, $request->end])->where('status','denied')->count();
            $AllOffer =  InstantOffer::where('lead_id',$LeadId->id)->whereBetween('created_at',[$request->start, $request->end])->count();
        }

        return ['coms' => $direct_coms, 'ao' => $AccptedOffer, 'do' => $DeniedOffer, 'alo' => $AllOffer];
    }
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(): Response
    {
        // get all lists for the user
        // get all tags for the user
        $user = Auth::user();
        $listToSend = $this->getListRowsForDisplay($user->id);
        $lists = Lists::where('userid' , auth()->user()->id)->get();
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

        return Inertia::render('Leads/index', ['allLists' => $listToSend,'accepted' => $AccptedOffer,'denied' => $DeniedOffer,'allOffers' => $AllOffer, 'LeadId' => $LeadId, 'lists' => $lists, 'LeadCount' => $Leadcount, 'counterOffers' => $counterOffers]);
    }



    public function getListRowsForDisplay($userId)
    {
        $allLeads = DB::select(
            "SELECT I.id as Iid, I.lead_id as leadId, I.address as address, I.name as name, I.email as email, I.phone as phone, I.status as status, I.created_at as created_at, I.offer_price as offer_price, I.arv as arv
            FROM `instant_offers` I
                join leads lea on I.lead_id=lea.id
            where lea.user_id=?", [$userId]);
        return $allLeads;
    }


    public function verifyStep1(Request $request) {

        if (empty($request->companyName) ) {
            return ["status" => "error", "message" => "Please Provide Company Name."];
        }

        if (empty($request->logoImage) ) {
            return ["status" => "error", "message" => "Please provide logo."];
        }



        if (empty($request->phoneNo) ) {
            return ["status" => "error", "message" => "Please provide Phone No."];
        }
        if (empty($request->email) ) {
            return ["status" => "error", "message" => "Please provide Email."];
        }

        if (!filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
            return ["status" => "error", "message" => "Email Format Is Invalid."];
        }

        if (empty($request->buisnessAddress) ) {
            return ["status" => "error", "message" => "Please provide Buisness Address."];
        }

        if (empty($request->zipCode) ) {
            return ["status" => "error", "message" => "Please provide Zip Code."];
        }

        if (empty($request->state) ) {
            return ["status" => "error", "message" => "Please provide State Name."];
        }

        if (empty($request->city) ) {
            return ["status" => "error", "message" => "Please provide City Name."];
        }

        return ["status" => "success", "message" => "Branding completed successfully."];


    }

    public function verifyStep2(Request $request) {

        if (empty($request->headline) ) {
            return ["status" => "error", "message" => "Please Provide Headline."];
        }

        if (empty($request->subHeadline) ) {
            return ["status" => "error", "message" => "Please provide Sub-Headline."];
        }

        return ["status" => "success", "message" => "Customization completed successfully."];

    }

    public function verifyStep3(Request $request) {

        $Query = null;
        if (empty($request->domain) ) {
            return ["status" => "error", "message" => "Please Provide Domain."];
        }

        // if (empty($request->msgPhone) ) {
        //     return ["status" => "error", "message" => "Please Provide Phone No."];
        // }

        $Phone = $request->phone_country_code.$request->phoneNo;
        // $MessagePhone = $request->msgphone_country_code.$request->msgPhone;


        $FileName = time() . '.' . $request->logoImage->extension();

        $request->logoImage->storeAs('public/logo', $FileName);
        $FileName = 'storage/logo/' . $FileName;

        $lists = [];
        if(!empty($request->lists_input)) {
            foreach($request->lists_input as $list) {
                $lists = $list['id'];
            }
        }

        $Query = Lead::create([
            'user_id' => Auth::user()->id,
            'company_name' => $request->companyName,
            'logo' => $FileName,
            'phone' => $Phone,
            'email' => $request->email,
            'buisness_address' => $request->buisnessAddress,
            'city' => $request->city,
            'state' => $request->state,
            'zip_code' => $request->zipCode,
            'color' => $request->color ?? "",
            'headline' => $request->headline,
            'sub_headline' => $request->subHeadline,
            'domain' => $request->domain,
            'sms_number' => $MessagePhone ?? "",
            'list_id' => $lists,

        ]) ;
        return ["status" => "success", "message" => "Website Setup Successfully."];

    }

    public function deleteInstant(Request $request){
        if (empty($request->InstantId) || $request->InstantId <= 0) {
            return ['status' => 'error', 'message' => 'Record not found'];
        }
        $Query = InstantOffer::where('id',$request->InstantId)->delete();
        return ['status' => 'success', 'message' => 'Entry deleted successfully', 'alllists' => $this->getListRowsForDisplay(auth()->user()->id)];
    }

    public function updateLead(Request $request){
        $lists = [];
        foreach($request->lists_input as $list) {
            $lists[] = $list['id'];
        }

        $FileName = Lead::where('user_id',auth()->user()->id)->first()->logo ?? '---';
        // return  $request;
        $Query = null;

        $Phone = $request->phone_country_code.$request->phone;
        // $MessagePhone = $request->msgphone_country_code.$request->sms_number;
        // return $request->hasFile('logo');
        if($request->hasFile('logo')){
            $FileName = time() . '.' . $request->logo->extension();
            $request->logo->storeAs('public/logo', $FileName);
            $FileName = 'storage/logo/' . $FileName;
        }



        $enable_offer_code = 0;
        $enable_counter_offer = 0;
        $enable_ad_pixel = 0;

        if($request->enable_offer_code == true) {
            $enable_offer_code = 1;
        }

        if($request->enable_counter_offer == true) {
            $enable_counter_offer = 1;
        }

        if($request->enable_ad_pixel == true) {
            $enable_ad_pixel = 1;
        }

        $updata = [
            'company_name' => $request->company_name,
            'logo' => $FileName,
            'phone' => $Phone,
            'email' => $request->email,
            'buisness_address' => $request->buisnessAddress,
            'city' => $request->city,
            'state' => $request->state,
            'zip_code' => $request->zipCode,
            'headline' => $request->headline,
            'sub_headline' => $request->sub_headline,
            'domain' => $request->domain,
            'sms_number' => $MessagePhone ?? "",
            "enable_offer_code" => $enable_offer_code,
            "enable_counter_offer" => $enable_counter_offer,
            "enable_ad_pixel" => $enable_ad_pixel,
            "pixel_code" => $request->pixel_code,
            "list_id" => $lists,
            'color' => $request->color,

        ];

        $Query = Lead::where('user_id',auth()->user()->id)->update($updata) ;
        $lead = Lead::where('user_id',auth()->user()->id)->first();
        if ($Query){
            return ["status" => "success", "message" => "Website Setup Edited Successfully.", "lead" => $lead];
        }else{
            return ["status" => "error", "message" => "An Error occured."];
        }
    }

}

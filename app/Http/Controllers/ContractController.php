<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\SocialSharing;



class ContractController extends Controller
{
    public function index(): Response
    {
        $sharing_count = SocialSharing::where('sharing_type','contracts_index')->first();
        $sharing_count = $sharing_count ? $sharing_count->count : 0;
        return Inertia::render('ContractGenerator/index', [
            'count' => $sharing_count
        ]);
    }

    public function closing(): Response
    {
        $sharing_count = SocialSharing::where('sharing_type','closing')->first();
        $sharing_count = $sharing_count ? $sharing_count->count : 0;
        return Inertia::render('ContractGenerator/ClosingAgreement', [
            'count' => $sharing_count
        ]);
    }

    public function purchase_sale(): Response
    {
        $sharing_count = SocialSharing::where('sharing_type','purchase_sale_agreement')->first();
        $sharing_count = $sharing_count ? $sharing_count->count : 0;
        return Inertia::render('ContractGenerator/PurchaseSaleAgreement', [
            'count' => $sharing_count
        ]);
    }

    public function land_sale(): Response
    {
        $sharing_count = SocialSharing::where('sharing_type','land_sale_agreement')->first();
        $sharing_count = $sharing_count ? $sharing_count->count : 0;
        return Inertia::render('ContractGenerator/LandSaleAgreement', [
            'count' => $sharing_count
        ]);
    }

    public function closing_pdf(Request $request) {
        $data = $request->all();
        $fileName = 'closing_pdf_'.time().'.pdf';
        $pdf = Pdf::loadView('pdf.closing', $data)->setPaper('a4', 'landscape');
        return $pdf->download($fileName);
    }

    public function purchase_sale_pdf(Request $request) {
        $data = $request->all();
        $fileName = 'purchase_sale_pdf_'.time().'.pdf';
        $pdf = Pdf::loadView('pdf.purchase_sale', $data)->setPaper('a4', 'landscape');
        return $pdf->download($fileName);
    }

    public function land_sale_pdf(Request $request) {
        $data = $request->all();
        $fileName = 'land_sale_pdf_'.time().'.pdf';
        $pdf = Pdf::loadView('pdf.land_sale', $data)->setPaper('a4', 'landscape');
        return $pdf->download($fileName);
    }

    public function add_share_count(Request $request) {
        $request->validate([
            'type' => 'required|in:closing,purchase_sale_agreement,land_sale_agreement,contracts_index,calculators_index,calculator_brrrr_profit_analysis,calculator_comparative_market_analysis,calculator_max_allowable_offer,calculator_profit_analysis,calculator_renovation'
        ]);

        $sharing_instance = SocialSharing::where('sharing_type',$request->type)->first();
        if(!$sharing_instance) {
            $sharing_instance = new SocialSharing;
            $sharing_instance->sharing_type = $request->type;
        }
        $sharing_instance->count += 1;
        $sharing_instance->save();
        return response()->json(['success' => true, 'Post share updated successfully.']);
    }
}


//DEBUGGING
// Storage::put("public/pdf/$fileName", $pdf->output());
// $pdf = Pdf::setOption(['isFontSubsettingEnabled' => true, 'defaultFont' => 'sans-serif', 'debugCss' => true, 'debugLayout' => true])
// ->loadView('pdf.purchase_sale', $data)->setPaper('a4', 'portrait');
// return response()->json(['success' => true, 'pdf_path' => asset('public/pdf/'.$fileName)]);

<?php

namespace App\Http\Controllers;

use App\Models\ComparativeMarketAnalysis;
use App\Models\MaxAllowableOffer;
use App\Models\ProfitAnalysis;
use App\Models\Renovation;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\SocialSharing;


class CalculatorController extends Controller
{
    public function index(): Response
    {
        $sharing_count = SocialSharing::where('sharing_type','calculators_index')->first();
        $sharing_count = $sharing_count ? $sharing_count->count : 0;
        return Inertia::render('Calculator/Index', [
            'count' => $sharing_count
        ]);
    }

    public function maxAllowableOffer()
    {
        if(request()->has('sheet') and request()->get('sheet') === "new") {

            $data = [];
            $count = auth()->user()->maxAllowableOffers()->where('title', 'like', '%Untitled%')->count()+1;
            $data['title'] = "Untitled $count";

            $maxAllowableOffer = auth()->user()->maxAllowableOffers()->create( $data );
            return redirect()->route('users.calculator.max-allowable-offer.edit', $maxAllowableOffer);
        }

        $sharing_count = SocialSharing::where('sharing_type','calculator_max_allowable_offer')->first();
        $sharing_count = $sharing_count ? $sharing_count->count : 0;

        return Inertia::render('Calculator/MaxAllowableOffer/Create', [
            'offers' => auth()->user()->maxAllowableOffers,
            'count' => $sharing_count
        ]);
    }

    public function storeMaxAllowableOffer(Request $request, $id = null)
    {
        $data = $request->only(['title', 'arv', 'rule', 'rehab', 'wholesale']);
        \Log::info($data);
        if($id) {

            $maxAllowableOffer = MaxAllowableOffer::find($id);
            if($maxAllowableOffer->user_id != auth()->id()) abort(403);

            $maxAllowableOffer->update($data);
        } else {

            $count = auth()->user()->maxAllowableOffers()->where('title', 'like', '%Untitled%')->count()+1;
            $data['title'] = "Untitled $count";

            $maxAllowableOffer = auth()->user()->maxAllowableOffers()->create( $data );
        }

        $maxAllowableOffer->offers = auth()->user()->maxAllowableOffers;
        return response()->json($maxAllowableOffer);
    }

    public function editMaxAllowableOffer(MaxAllowableOffer $maxAllowableOffer)
    {
        if($maxAllowableOffer->user_id != auth()->id()) abort(403);

        return Inertia::render('Calculator/MaxAllowableOffer/Edit', [
            'offers' => auth()->user()->maxAllowableOffers,
            'offer' => $maxAllowableOffer
        ]);
    }
    public function destroyMaxAllowableOffer(MaxAllowableOffer $maxAllowableOffer)
    {
        if($maxAllowableOffer->user_id != auth()->id()) abort(403);

        $maxAllowableOffer->delete();
        return ['status' => 'success', 'message' => 'Successfully deleted', 'offers' => auth()->user()->maxAllowableOffers];
    }

    public function profitAnalysis()
    {
        if(request()->has('sheet') and request()->get('sheet') === "new") {

            $data = [];
            $count = auth()->user()->profitAnalyses()->where('title', 'like', '%Untitled%')->count()+1;
            $data['title'] = "Untitled $count";

            $profitAnalysis = auth()->user()->profitAnalyses()->create( $data );
            return redirect()->route('users.calculator.profit-analysis.edit', $profitAnalysis);
        }

        $sharing_count = SocialSharing::where('sharing_type','calculator_profit_analysis')->first();
        $sharing_count = $sharing_count ? $sharing_count->count : 0;

        return Inertia::render('Calculator/ProfitAnalysis/Create', [
            'analyses' => auth()->user()->profitAnalyses()->where('is_brrrr', 0)->get(),
            'count' => $sharing_count
        ]);
    }

    public function storeProfitAnalysis(Request $request, $id = null)
    {
        $data = $request->only([
            'arv',
            'title',
            'estimated_hold_time',
            'purchase_price',
            'reinstatement',
            'delinquent_taxes',
            'closing_cost',
            'interior_repairs',
            'exterior_repairs',
            'landscaping',
            'miscellaneous',
            'contingency_percentage',
            'purchase_price_financed',
            'renovation_financed',
            'down_payment_interest_rate',
            'down_payment_points',
            'down_payment_lender_underwriting_fee',
            'down_payment_appraisal_fee',
            'down_payment_title_fees',
            'down_payment_tax_prepaid',
            'down_payment_insurance_prepaid',
            'holding_costs_load_payments',
            'holding_costs_property_taxes',
            'holding_costs_insurance',
            'holding_costs_utilities',
            'holding_costs_lender_draw_fee',
            'holding_costs_number_draws',
            'selling_cost_closing_cost',
            'selling_cost_staging',
            'selling_cost_concessions_and_other',
            'selling_cost_seller_credit_to_buyer',
            'selling_cost_listing_agent_commission',
            'selling_cost_buyers_agent_commission',
            'gap_funding_cash_due_at_closing',
            'gap_funding_total_holding_cost',
            'gap_funding_contribution',
            'gap_funding_interest_rate_and_payments',
            'gap_funding_profit_share',
        ]);

        if($id) {

            $profitAnalysis = ProfitAnalysis::find($id);
            if($profitAnalysis->user_id != auth()->id()) abort(403);

            $profitAnalysis->update( $data );
        } else {

            $count = auth()->user()->profitAnalyses()->where('title', 'like', '%Untitled%')->count()+1;
            $data['title'] = "Untitled $count";

            $profitAnalysis = auth()->user()->profitAnalyses()->create( $data );
        }

        $profitAnalysis->analyses = auth()->user()->profitAnalyses;
        return response()->json($profitAnalysis);
    }

    public function destroyProfitAnalysis(ProfitAnalysis $profitAnalysis)
    {
        if($profitAnalysis->user_id != auth()->id()) abort(403);

        $profitAnalysis->delete();
        return ['status' => 'success', 'message' => 'Successfully deleted', 'analyses' => auth()->user()->profitAnalyses];
    }

    public function editProfitAnalysis(ProfitAnalysis $profitAnalysis)
    {
        if($profitAnalysis->user_id != auth()->id()) abort(403);

        return Inertia::render('Calculator/ProfitAnalysis/Edit', [
            'analyses' => auth()->user()->profitAnalyses()->where('is_brrrr', 0)->get(),
            'analysis' => $profitAnalysis
        ]);
    }
    public function brrrrProfitAnalysis()
    {
        if(request()->has('sheet') and request()->get('sheet') === "new") {

            $data = ['is_brrrr' => 1];
            $count = auth()->user()->profitAnalyses()->where('title', 'like', '%Untitled%')->count()+1;
            $data['title'] = "Untitled $count";

            $profitAnalysis = auth()->user()->profitAnalyses()->create( $data );

            return redirect()->route('users.calculator.brrrr-profit-analysis.edit', $profitAnalysis);
        }

        $sharing_count = SocialSharing::where('sharing_type','calculator_brrrr_profit_analysis')->first();
        $sharing_count = $sharing_count ? $sharing_count->count : 0;

        return Inertia::render('Calculator/BrrrrProfitAnalysis/Create', [
            'analyses' => auth()->user()->profitAnalyses()->where('is_brrrr', 1)->get(),
            'count' => $sharing_count
        ]);
    }

    public function storeBrrrrProfitAnalysis(Request $request, $id = null)
    {
        $data = $request->only([
            'arv',
            'title',
            'estimated_hold_time',
            'refinance_loan_to_value',
            'refinance_interest_rate',
            'refinance_mortgage_term',
            'refinance_closing_cost',
            'gross_scheduled_income',
            'vacancy_and_concession_percentage',
            'leasing_fees',
            'property_management_fees',
            'maintenance_repairs',
            'property_annual_tax',
            'property_annual_insurance',
            'hoa_annual_fees',
            'water_and_sewer_annual_fees',
            'gas_annual_fees',
            'electric_annual_fees',
            'trash_annual_fees',
            'other_annual_fees',
            'purchase_price',
            'reinstatement',
            'delinquent_taxes',
            'closing_cost',
            'interior_repairs',
            'exterior_repairs',
            'landscaping',
            'miscellaneous',
            'contingency_percentage',
            'purchase_price_financed',
            'renovation_financed',
            'down_payment_interest_rate',
            'down_payment_points',
            'down_payment_lender_underwriting_fee',
            'down_payment_appraisal_fee',
            'down_payment_title_fees',
            'down_payment_tax_prepaid',
            'down_payment_insurance_prepaid',
            'holding_costs_load_payments',
            'holding_costs_property_taxes',
            'holding_costs_insurance',
            'holding_costs_utilities',
            'holding_costs_lender_draw_fee',
            'holding_costs_number_draws',
            'selling_cost_closing_cost',
            'selling_cost_staging',
            'selling_cost_concessions_and_other',
            'selling_cost_seller_credit_to_buyer',
            'selling_cost_listing_agent_commission',
            'selling_cost_buyers_agent_commission',
            'gap_funding_cash_due_at_closing',
            'gap_funding_total_holding_cost',
            'gap_funding_contribution',
            'gap_funding_interest_rate_and_payments',
            'gap_funding_profit_share',
        ]);

        $data['is_brrrr'] = 1;
        if($id) {

            $profitAnalysis = ProfitAnalysis::find($id);
            if($profitAnalysis->user_id != auth()->id()) abort(403);

            $profitAnalysis->update( $data );
        } else {

            $count = auth()->user()->profitAnalyses()->where('title', 'like', '%Untitled%')->count()+1;
            $data['title'] = "Untitled $count";

            $profitAnalysis = auth()->user()->profitAnalyses()->create( $data );
        }

        $profitAnalysis->analyses = auth()->user()->profitAnalyses;
        return response()->json($profitAnalysis);
    }

    public function editBrrrrProfitAnalysis(ProfitAnalysis $profitAnalysis)
    {
        if($profitAnalysis->user_id != auth()->id()) abort(403);

        return Inertia::render('Calculator/BrrrrProfitAnalysis/Edit', [
            'analyses' => auth()->user()->profitAnalyses()->where('is_brrrr', 1)->get(),
            'analysis' => $profitAnalysis
        ]);
    }

    public function destroyBrrrrProfitAnalysis(ProfitAnalysis $profitAnalysis)
    {
        if($profitAnalysis->user_id != auth()->id()) abort(403);

        $profitAnalysis->delete();
        return ['status' => 'success', 'message' => 'Successfully deleted', 'analyses' => auth()->user()->profitAnalyses()->where('is_brrrr', 1)->get()];
    }

    public function renovation()
    {
        if(request()->has('sheet') and request()->get('sheet') === "new") {

            $data = [];
            $count = auth()->user()->renovations()->where('title', 'like', '%Untitled%')->count()+1;
            $data['title'] = "Untitled $count";

            $renovation = auth()->user()->renovations()->create( $data );
            return redirect()->route('users.calculator.renovation.edit', $renovation);
        }

        $sharing_count = SocialSharing::where('sharing_type','calculator_renovation')->first();
        $sharing_count = $sharing_count ? $sharing_count->count : 0;

        return Inertia::render('Calculator/Renovation/Create', [
            'renovations' => auth()->user()->renovations,
            'count' => $sharing_count
        ]);
    }

    public function storeRenovation (Request $request, $id = null)
    {
        $data = $request->only([
            'title',
            'enable_new_flooring',
            'new_flooring_qty',
            'new_flooring_price',
            'enable_hardwood_refinishing',
            'hardwood_refinishing_qty',
            'hardwood_refinishing_price',
            'enable_new_carpet_and_padding',
            'new_carpet_and_padding_qty',
            'new_carpet_and_padding_price',
            'enable_drywall_patch',
            'drywall_patch_qty',
            'drywall_patch_price',
            'enable_plumber_work',
            'plumber_work_qty',
            'plumber_work_price',
            'enable_electrician_work',
            'electrician_work_qty',
            'electrician_work_price',
            'enable_carpenter_work',
            'carpenter_work_qty',
            'carpenter_work_price',
            'enable_interior_paint',
            'interior_paint_qty',
            'interior_paint_price',
            'enable_insulation',
            'insulation_qty',
            'insulation_price',
            'enable_furance',
            'furance_qty',
            'furance_price',
            'enable_hvac',
            'hvac_qty',
            'hvac_price',
            'enable_water_heater',
            'water_heater_qty',
            'water_heater_price',
            'enable_boiler',
            'boiler_qty',
            'boiler_price',
            'enable_refrigerator',
            'refrigerator_qty',
            'refrigerator_price',
            'enable_oven',
            'oven_qty',
            'oven_price',
            'enable_dishwasher',
            'dishwasher_qty',
            'dishwasher_price',
            'enable_microwave',
            'microwave_qty',
            'microwave_price',
            'enable_kitchen_cabinet_and_hardware',
            'kitchen_cabinet_and_hardware_qty',
            'kitchen_cabinet_and_hardware_price',
            'enable_kitchen_countertops',
            'kitchen_countertops_qty',
            'kitchen_countertops_price',
            'enable_kitchen_backsplash',
            'kitchen_backsplash_qty',
            'kitchen_backsplash_price',
            'enable_garbage_disposal',
            'garbage_disposal_qty',
            'garbage_disposal_price',
            'enable_bathroom_vanity',
            'bathroom_vanity_qty',
            'bathroom_vanity_price',
            'enable_toilet',
            'toilet_qty',
            'toilet_price',
            'enable_tub_reglazing',
            'tub_reglazing_qty',
            'tub_reglazing_price',
            'enable_shower_tile',
            'shower_tile_qty',
            'shower_tile_price',
            'enable_mold_remediation',
            'mold_remediation_qty',
            'mold_remediation_price',
            'enable_electrical_fixture',
            'electrical_fixture_qty',
            'electrical_fixture_price',
            'enable_water_fixture',
            'water_fixture_qty',
            'water_fixture_price',
            'enable_doors',
            'doors_qty',
            'doors_price',
            'enable_roof_asphalt',
            'roof_asphalt_qty',
            'roof_asphalt_price',
            'enable_chimney_repair',
            'chimney_repair_qty',
            'chimney_repair_price',
            'enable_gutters',
            'gutters_qty',
            'gutters_price',
            'enable_siding',
            'siding_qty',
            'siding_price',
            'enable_paint',
            'paint_qty',
            'paint_price',
            'enable_windows',
            'windows_qty',
            'windows_price',
            'enable_deck',
            'deck_qty',
            'deck_price',
            'enable_shed_repair',
            'shed_repair_qty',
            'shed_repair_price',
            'enable_seal_coat',
            'seal_coat_qty',
            'seal_coat_price',
            'enable_garage_door',
            'garage_door_qty',
            'garage_door_price',
            'enable_pool_or_spa_repair',
            'pool_or_spa_repair_qty',
            'pool_or_spa_repair_price',
            'enable_fencing',
            'fencing_qty',
            'fencing_price',
            'enable_dumpster_rental',
            'dumpster_rental_qty',
            'dumpster_rental_price',
            'enable_foundation_repair',
            'foundation_repair_qty',
            'foundation_repair_price',
            'enable_drainage',
            'drainage_qty',
            'drainage_price',
            'enable_port_o_potty_rental',
            'port_o_potty_rental_qty',
            'port_o_potty_rental_price',
            'enable_yard_cleanup',
            'yard_cleanup_qty',
            'yard_cleanup_price',
            'enable_tree_removing',
            'tree_removing_qty',
            'tree_removing_price',
            'enable_new_grass_sod',
            'new_grass_sod_qty',
            'new_grass_sod_price',
            'enable_new_plants',
            'new_plants_qty',
            'new_plants_price',
            'enable_hardscape',
            'hardscape_qty',
            'hardscape_price',
            'enable_mulch',
            'mulch_qty',
            'mulch_price',
            'enable_fire_pit',
            'fire_pit_qty',
            'fire_pit_price',
            'enable_patio',
            'patio_qty',
            'patio_price',
        ]);

        if($id) {

            $renovation = Renovation::find($id);
            if($renovation->user_id != auth()->id()) abort(403);

            $renovation->update( $data );
        } else {

            $count = auth()->user()->renovations()->where('title', 'like', '%Untitled%')->count()+1;
            $data['title'] = "Untitled $count";

            $renovation = auth()->user()->renovations()->create( $data );
        }

        $renovation->renovations = auth()->user()->renovations;
        return response()->json($renovation);
    }

    public function editRenovation(Renovation $renovation)
    {
        if($renovation->user_id != auth()->id()) abort(403);

        return Inertia::render('Calculator/Renovation/Edit', [
            'renovations' => auth()->user()->renovations,
            'renovation' => $renovation
        ]);
    }

    public function destroyRenovation(Renovation $renovation)
    {
        if($renovation->user_id != auth()->id()) abort(403);

        $renovation->delete();
        return ['status' => 'success', 'message' => 'Successfully deleted'];
    }
    public function comparativeMarketAnalysis()
    {
        if(request()->has('sheet') and request()->get('sheet') === "new") {

            $data = [];
            $count = auth()->user()->comparatives()->where('title', 'like', '%Untitled%')->count()+1;
            $data['title'] = "Untitled $count";

            $comparative = auth()->user()->comparatives()->create( $data );
            return redirect()->route('users.calculator.comparative-market-analysis.edit', $comparative);
        }

        $sharing_count = SocialSharing::where('sharing_type','calculator_comparative_market_analysis')->first();
        $sharing_count = $sharing_count ? $sharing_count->count : 0;

        return Inertia::render('Calculator/ComparativeMarketAnalysis/Create', [
            'comparatives' => auth()->user()->comparatives,
            'count' => $sharing_count
        ]);
    }

    public function storeComparativeMarketAnalysis(Request $request, $id = null)
    {
        $data = $request->only([
            'title',
            'subject_property_address',
            'property_address_1',
            'property_address_2',
            'property_address_3',
            'property_address_4',
            'subject_property_include_analysis',
            'property_include_analysis_1',
            'property_include_analysis_2',
            'property_include_analysis_3',
            'property_include_analysis_4',
            'subject_property_style',
            'property_style_1',
            'property_style_2',
            'property_style_3',
            'property_style_4',
            'subject_property_square_footage',
            'property_square_footage_1',
            'property_square_footage_2',
            'property_square_footage_3',
            'property_square_footage_4',
            'subject_property_beds',
            'property_beds_1',
            'property_beds_2',
            'property_beds_3',
            'property_beds_4',
            'subject_property_baths',
            'property_baths_1',
            'property_baths_2',
            'property_baths_3',
            'property_baths_4',
            'subject_property_lot_size',
            'property_lot_size_1',
            'property_lot_size_2',
            'property_lot_size_3',
            'property_lot_size_4',
            'subject_property_year_built',
            'property_year_built_1',
            'property_year_built_2',
            'property_year_built_3',
            'property_year_built_4',
            'subject_property_garage',
            'property_garage_1',
            'property_garage_2',
            'property_garage_3',
            'property_garage_4',
            'subject_property_pool',
            'property_pool_1',
            'property_pool_2',
            'property_pool_3',
            'property_pool_4',
            'subject_property_proximity',
            'property_proximity_1',
            'property_proximity_2',
            'property_proximity_3',
            'property_proximity_4',
            'subject_property_date_sold',
            'property_date_sold_1',
            'property_date_sold_2',
            'property_date_sold_3',
            'property_date_sold_4',
            'subject_property_last_sold_price',
            'property_last_sold_price_1',
            'property_last_sold_price_2',
            'property_last_sold_price_3',
            'property_last_sold_price_4',
            'subject_property_second_last_sold_price',
            'property_second_last_sold_price_1',
            'property_second_last_sold_price_2',
            'property_second_last_sold_price_3',
            'property_second_last_sold_price_4',
            'subject_property_second_curb_appeal',
            'property_second_curb_appeal_1',
            'property_second_curb_appeal_2',
            'property_second_curb_appeal_3',
            'property_second_curb_appeal_4',
            'subject_property_curb_appeal',
            'property_curb_appeal_1',
            'property_curb_appeal_2',
            'property_curb_appeal_3',
            'property_curb_appeal_4',
            'subject_property_interior',
            'property_interior_1',
            'property_interior_2',
            'property_interior_3',
            'property_interior_4',
            'subject_property_fixtures',
            'property_fixtures_1',
            'property_fixtures_2',
            'property_fixtures_3',
            'property_fixtures_4',
            'square_footage',
            'min_square_footage',
            'max_square_footage',
            'property_age',
            'min_year_built',
            'max_year_built',
            'proximity_to_subject',
            'max_days_since_sale',
            'avg_sale_price',
            'lowest_sqft',
            'average_sqft',
            'highest_sqft',
            'range',
            'suggested_sqft',
            'subject_property_sqft',
            'subject_property_sqft_x',
        ]);

        if($id) {

            $comparative = ComparativeMarketAnalysis::find($id);
            if($comparative->user_id != auth()->id()) abort(403);

            $comparative->update( $data );
        } else {

            $count = auth()->user()->comparatives()->where('title', 'like', '%Untitled%')->count()+1;
            $data['title'] = "Untitled $count";

            $comparative = auth()->user()->comparatives()->create( $data );
        }

        $comparative->comparatives = auth()->user()->comparatives;
        return response()->json($comparative);
    }

    public function editComparativeMarketAnalysis(ComparativeMarketAnalysis $comparativeMarketAnalysis)
    {
        if($comparativeMarketAnalysis->user_id != auth()->id()) abort(403);

        return Inertia::render('Calculator/ComparativeMarketAnalysis/Edit', [
            'comparatives' => auth()->user()->comparatives,
            'comparative' => $comparativeMarketAnalysis
        ]);
    }

    public function destroyComparativeMarketAnalysis(ComparativeMarketAnalysis $comparativeMarketAnalysis)
    {
        if($comparativeMarketAnalysis->user_id != auth()->id()) abort(403);

        $comparativeMarketAnalysis->delete();
        return ['status' => 'success', 'message' => 'Successfully deleted', 'comparatives' => auth()->user()->comparatives];
    }
}


<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfitAnalysis extends Model
{
    protected $fillable = [
        'arv',
        'is_brrrr',
        'title',
        'estimated_hold_time',
        'purchase_price',
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
    ];
}

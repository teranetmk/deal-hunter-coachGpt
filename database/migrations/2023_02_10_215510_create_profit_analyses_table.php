<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profit_analyses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');

            $table->string('title')->default('Untitled');
            $table->string('arv', 20)->default(0);

            //buying
            $table->string('estimated_hold_time', 20)->default(0);
            $table->string('purchase_price', 20)->default(0);
            $table->string('reinstatement', 20)->default(0);
            $table->string('delinquent_taxes', 20)->default(0);
            $table->string('closing_cost', 20)->default(0);

            //renovation
            $table->string('interior_repairs', 20)->default(0);
            $table->string('exterior_repairs', 20)->default(0);
            $table->string('landscaping', 20)->default(0);
            $table->string('miscellaneous', 20)->default(0);
            $table->string('contingency_percentage', 20)->default(0);

            //financing
            $table->string('purchase_price_financed', 20)->default(0);
            $table->string('renovation_financed', 20)->default(0);
            $table->string('down_payment_interest_rate', 20)->default(0);
            $table->string('down_payment_points', 20)->default(0);
            $table->string('down_payment_lender_underwriting_fee', 20)->default(0);
            $table->string('down_payment_appraisal_fee', 20)->default(0);
            $table->string('down_payment_title_fees', 20)->default(0);
            $table->string('down_payment_tax_prepaid', 20)->default(0);
            $table->string('down_payment_insurance_prepaid', 20)->default(0);

            //holding cost
            $table->string('holding_costs_load_payments', 20)->default(0);
            $table->string('holding_costs_property_taxes', 20)->default(0);
            $table->string('holding_costs_insurance', 20)->default(0);
            $table->string('holding_costs_utilities', 20)->default(0);
            $table->string('holding_costs_lender_draw_fee', 20)->default(0);
            $table->string('holding_costs_number_draws', 20)->default(0);

            //selling cost
            $table->string('selling_cost_closing_cost', 20)->default(0);
            $table->string('selling_cost_staging', 20)->default(0);
            $table->string('selling_cost_concessions_and_other', 20)->default(0);
            $table->string('selling_cost_seller_credit_to_buyer', 20)->default(0);
            $table->string('selling_cost_listing_agent_commission', 20)->default(0);
            $table->string('selling_cost_buyers_agent_commission', 20)->default(0);

            //gap funding
            $table->string('gap_funding_cash_due_at_closing', 20)->default(0);
            $table->string('gap_funding_total_holding_cost', 20)->default(0);
            $table->string('gap_funding_contribution', 20)->default(0);
            $table->string('gap_funding_interest_rate_and_payments', 20)->default(0);
            $table->string('gap_funding_profit_share', 20)->default(0);

            $table->string('refinance_loan_to_value', 20)->default(0);
            $table->string('refinance_interest_rate', 20)->default(0);
            $table->string('refinance_mortgage_term', 20)->default(0);
            $table->string('refinance_closing_cost', 20)->default(0);

            $table->string('gross_scheduled_income', 20)->default(0);
            $table->string('vacancy_and_concession_percentage', 20)->default(0);
            $table->string('leasing_fees', 20)->default(0);
            $table->string('property_management_fees', 20)->default(0);
            $table->string('maintenance_repairs', 20)->default(0);
            $table->string('property_annual_tax', 20)->default(0);
            $table->string('property_annual_insurance', 20)->default(0);
            $table->string('hoa_annual_fees', 20)->default(0);
            $table->string('water_and_sewer_annual_fees', 20)->default(0);
            $table->string('gas_annual_fees', 20)->default(0);
            $table->string('electric_annual_fees', 20)->default(0);
            $table->string('trash_annual_fees', 20)->default(0);
            $table->string('other_annual_fees', 20)->default(0);

            $table->boolean('is_brrrr')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('profit_analyses');
    }
};

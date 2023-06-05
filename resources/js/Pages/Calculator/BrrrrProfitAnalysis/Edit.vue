<script>
import AuthenticatedLayout from "../../../Layouts/AuthenticatedLayout.vue";
import Buttons from "./Partials/Buttons.vue";
import {useForm, usePage, Link, Head} from '@inertiajs/inertia-vue3';
import Form from "./Partials/Form.vue"

export default {
    props: ['analyses', 'analysis'],
    data() {
        return {
            form: useForm({
                id: this.analysis.id,
                arv: this.analysis.arv,

                refinance_loan_to_value: this.analysis.refinance_loan_to_value,
                refinance_interest_rate: this.analysis.refinance_interest_rate,
                refinance_mortgage_term: this.analysis.refinance_mortgage_term,
                refinance_closing_cost: this.analysis.refinance_closing_cost,

                gross_scheduled_income: this.analysis.gross_scheduled_income,
                vacancy_and_concession_percentage: this.analysis.vacancy_and_concession_percentage,
                leasing_fees: this.analysis.leasing_fees,
                property_management_fees: this.analysis.property_management_fees,
                maintenance_repairs: this.analysis.maintenance_repairs,
                property_annual_tax: this.analysis.property_annual_tax,
                property_annual_insurance: this.analysis.property_annual_insurance,
                hoa_annual_fees: this.analysis.hoa_annual_fees,
                water_and_sewer_annual_fees: this.analysis.water_and_sewer_annual_fees,
                gas_annual_fees: this.analysis.gas_annual_fees,
                electric_annual_fees: this.analysis.electric_annual_fees,
                trash_annual_fees: this.analysis.trash_annual_fees,
                other_annual_fees: this.analysis.other_annual_fees,

                estimated_hold_time: this.analysis.estimated_hold_time,
                purchase_price: this.analysis.purchase_price,
                reinstatement: this.analysis.reinstatement,
                delinquent_taxes: this.analysis.delinquent_taxes,
                closing_cost: this.analysis.closing_cost,
                interior_repairs: this.analysis.interior_repairs,
                exterior_repairs: this.analysis.exterior_repairs,
                landscaping: this.analysis.landscaping,
                miscellaneous: this.analysis.miscellaneous,
                contingency_percentage: this.analysis.contingency_percentage,
                purchase_price_financed: this.analysis.purchase_price_financed,
                renovation_financed: this.analysis.renovation_financed,
                down_payment_interest_rate: this.analysis.down_payment_interest_rate,
                down_payment_points: this.analysis.down_payment_points,
                down_payment_lender_underwriting_fee: this.analysis.down_payment_lender_underwriting_fee,
                down_payment_appraisal_fee: this.analysis.down_payment_appraisal_fee,
                down_payment_title_fees: this.analysis.down_payment_title_fees,
                down_payment_tax_prepaid: this.analysis.down_payment_tax_prepaid,
                down_payment_insurance_prepaid: this.analysis.down_payment_insurance_prepaid,
                holding_costs_load_payments: this.analysis.holding_costs_load_payments,
                holding_costs_property_taxes: this.analysis.holding_costs_property_taxes,
                holding_costs_insurance: this.analysis.holding_costs_insurance,
                holding_costs_utilities: this.analysis.holding_costs_utilities,
                holding_costs_lender_draw_fee: this.analysis.holding_costs_lender_draw_fee,
                holding_costs_number_draws: this.analysis.holding_costs_number_draws,
                selling_cost_closing_cost: this.analysis.selling_cost_closing_cost,
                selling_cost_staging: this.analysis.selling_cost_staging,
                selling_cost_concessions_and_other: this.analysis.selling_cost_concessions_and_other,
                selling_cost_seller_credit_to_buyer: this.analysis.selling_cost_seller_credit_to_buyer,
                selling_cost_listing_agent_commission: this.analysis.selling_cost_listing_agent_commission,
                selling_cost_buyers_agent_commission: this.analysis.selling_cost_buyers_agent_commission,
                gap_funding_cash_due_at_closing: this.analysis.gap_funding_cash_due_at_closing,
                gap_funding_total_holding_cost: this.analysis.gap_funding_total_holding_cost,
                gap_funding_contribution: this.analysis.gap_funding_contribution,
                gap_funding_interest_rate_and_payments: this.analysis.gap_funding_interest_rate_and_payments,
                gap_funding_profit_share: this.analysis.gap_funding_profit_share,
            }),
            controller: null
        }
    },
    methods: {

        saveOrUpdate() {

            if(this.controller) this.controller.abort()
            this.controller = new AbortController()
            axios.post(route('users.calculator.brrrr-profit-analysis.store', {id: this.form.id}), {...this.form}, {signal: this.controller.signal})
        }
    },
    watch: {
        "form.arv"(newValue) {
            this.form.arv = add_commas(newValue)
            this.saveOrUpdate()
        },
        "form.estimated_hold_time"(newValue) {
            this.form.estimated_hold_time = add_commas(newValue)
            this.saveOrUpdate()
        },
        "form.purchase_price"(newValue) {
            this.form.purchase_price = add_commas(newValue)
            this.saveOrUpdate()
        },
        "form.refinance_loan_to_value"(newValue) {
            this.form.refinance_loan_to_value = add_commas(newValue)
            this.saveOrUpdate()
        },
        "form.refinance_interest_rate"(newValue) {
            this.form.refinance_interest_rate = add_commas(newValue)
            this.saveOrUpdate()
        },
        "form.refinance_mortgage_term"(newValue) {
            this.form.refinance_mortgage_term = add_commas(newValue)
            this.saveOrUpdate()
        },
        "form.refinance_closing_cost"(newValue) {
            this.form.refinance_closing_cost = add_commas(newValue)
            this.saveOrUpdate()
        },
        "form.gross_scheduled_income"(newValue) {
            this.form.gross_scheduled_income = add_commas(newValue)
            this.saveOrUpdate()
        },
        "form.vacancy_and_concession_percentage"(newValue) {
            this.form.vacancy_and_concession_percentage = add_commas(newValue)
            this.saveOrUpdate()
        },
        "form.leasing_fees"(newValue) {
            this.form.leasing_fees = add_commas(newValue)
            this.saveOrUpdate()
        },
        "form.property_management_fees"(newValue) {
            this.form.property_management_fees = add_commas(newValue)
            this.saveOrUpdate()
        },
        "form.maintenance_repairs"(newValue) {
            this.form.maintenance_repairs = add_commas(newValue)
            this.saveOrUpdate()
        },
        "form.property_annual_tax"(newValue) {
            this.form.property_annual_tax = add_commas(newValue)
            this.saveOrUpdate()
        },
        "form.property_annual_insurance"(newValue) {
            this.form.property_annual_insurance = add_commas(newValue)
            this.saveOrUpdate()
        },
        "form.hoa_annual_fees"(newValue) {
            this.form.hoa_annual_fees = add_commas(newValue)
            this.saveOrUpdate()
        },
        "form.water_and_sewer_annual_fees"(newValue) {
            this.form.water_and_sewer_annual_fees = add_commas(newValue)
            this.saveOrUpdate()
        },
        "form.gas_annual_fees"(newValue) {
            this.form.gas_annual_fees = add_commas(newValue)
            this.saveOrUpdate()
        },
        "form.electric_annual_fees"(newValue) {
            this.form.electric_annual_fees = add_commas(newValue)
            this.saveOrUpdate()
        },
        "form.trash_annual_fees"(newValue) {
            this.form.trash_annual_fees = add_commas(newValue)
            this.saveOrUpdate()
        },
        "form.other_annual_fees"(newValue) {
            this.form.other_annual_fees = add_commas(newValue)
            this.saveOrUpdate()
        },
        "form.reinstatement"(newValue) {
            this.form.reinstatement = add_commas(newValue)
            this.saveOrUpdate()
        },
        "form.delinquent_taxes"(newValue) {
            this.form.delinquent_taxes = add_commas(newValue)
            this.saveOrUpdate()
        },
        "form.closing_cost"(newValue) {
            this.form.closing_cost = add_commas(newValue)
            this.saveOrUpdate()
        },
        "form.interior_repairs"(newValue) {
            this.form.interior_repairs = add_commas(newValue)
            this.saveOrUpdate()
        },
        "form.exterior_repairs"(newValue) {
            this.form.exterior_repairs = add_commas(newValue)
            this.saveOrUpdate()
        },
        "form.landscaping"(newValue) {
            this.form.landscaping = add_commas(newValue)
            this.saveOrUpdate()
        },
        "form.miscellaneous"(newValue) {
            this.form.miscellaneous = add_commas(newValue)
            this.saveOrUpdate()
        },
        "form.contingency_percentage"(newValue) {
            this.form.contingency_percentage = add_commas(newValue)
            this.saveOrUpdate()
        },
        "form.purchase_price_financed"(newValue) {
            this.form.purchase_price_financed = add_commas(newValue)
            this.saveOrUpdate()
        },
        "form.renovation_financed"(newValue) {
            this.form.renovation_financed = add_commas(newValue)
            this.saveOrUpdate()
        },
        "form.down_payment_interest_rate"(newValue) {
            this.form.down_payment_interest_rate = add_commas(newValue)
            this.saveOrUpdate()
        },
        "form.down_payment_points"(newValue) {
            this.form.down_payment_points = add_commas(newValue)
            this.saveOrUpdate()
        },
        "form.down_payment_lender_underwriting_fee"(newValue) {
            this.form.down_payment_lender_underwriting_fee = add_commas(newValue)
            this.saveOrUpdate()
        },
        "form.down_payment_appraisal_fee"(newValue) {
            this.form.down_payment_appraisal_fee = add_commas(newValue)
            this.saveOrUpdate()
        },
        "form.down_payment_title_fees"(newValue) {
            this.form.down_payment_title_fees = add_commas(newValue)
            this.saveOrUpdate()
        },
        "form.down_payment_tax_prepaid"(newValue) {
            this.form.down_payment_tax_prepaid = add_commas(newValue)
            this.saveOrUpdate()
        },
        "form.down_payment_insurance_prepaid"(newValue) {
            this.form.down_payment_insurance_prepaid = add_commas(newValue)
            this.saveOrUpdate()
        },
        "form.holding_costs_load_payments"(newValue) {
            this.form.holding_costs_load_payments = add_commas(newValue)
            this.saveOrUpdate()
        },
        "form.holding_costs_property_taxes"(newValue) {
            this.form.holding_costs_property_taxes = add_commas(newValue)
            this.saveOrUpdate()
        },
        "form.holding_costs_insurance"(newValue) {
            this.form.holding_costs_insurance = add_commas(newValue)
            this.saveOrUpdate()
        },
        "form.holding_costs_utilities"(newValue) {
            this.form.holding_costs_utilities = add_commas(newValue)
            this.saveOrUpdate()
        },
        "form.holding_costs_lender_draw_fee"(newValue) {
            this.form.holding_costs_lender_draw_fee = add_commas(newValue)
            this.saveOrUpdate()
        },
        "form.holding_costs_number_draws"(newValue) {
            this.form.holding_costs_number_draws = add_commas(newValue)
            this.saveOrUpdate()
        },
        "form.selling_cost_closing_cost"(newValue) {
            this.form.selling_cost_closing_cost = add_commas(newValue)
            this.saveOrUpdate()
        },
        "form.selling_cost_staging"(newValue) {
            this.form.selling_cost_staging = add_commas(newValue)
            this.saveOrUpdate()
        },
        "form.selling_cost_concessions_and_other"(newValue) {
            this.form.selling_cost_concessions_and_other = add_commas(newValue)
            this.saveOrUpdate()
        },
        "form.selling_cost_seller_credit_to_buyer"(newValue) {
            this.form.selling_cost_seller_credit_to_buyer = add_commas(newValue)
            this.saveOrUpdate()
        },
        "form.selling_cost_listing_agent_commission"(newValue) {
            this.form.selling_cost_listing_agent_commission = add_commas(newValue)
            this.saveOrUpdate()
        },
        "form.selling_cost_buyers_agent_commission"(newValue) {
            this.form.selling_cost_buyers_agent_commission = add_commas(newValue)
            this.saveOrUpdate()
        },
        "form.gap_funding_cash_due_at_closing"(newValue) {
            this.form.gap_funding_cash_due_at_closing = add_commas(newValue)
            this.saveOrUpdate()
        },
        "form.gap_funding_total_holding_cost"(newValue) {
            this.form.gap_funding_total_holding_cost = add_commas(newValue)
            this.saveOrUpdate()
        },
        "form.gap_funding_contribution"(newValue) {
            this.form.gap_funding_contribution = add_commas(newValue)
            this.saveOrUpdate()
        },
        "form.gap_funding_interest_rate_and_payments"(newValue) {
            this.form.gap_funding_interest_rate_and_payments = add_commas(newValue)
            this.saveOrUpdate()
        },
        "form.gap_funding_profit_share"(newValue) {
            this.form.gap_funding_profit_share = add_commas(newValue)
            this.saveOrUpdate()
        },
    },
    components: {AuthenticatedLayout, Head, Link, Form, Buttons}
}
</script>

<template>
    <AuthenticatedLayout>
        <Head title="BRRRR Profit Analysis Calculator" />
        <template #pageHeading>
            <Buttons :analyses="analyses" />
        </template>

        <Form :form="form" />

    </AuthenticatedLayout>
</template>

<style>
.p-button-secondary {
    color: #6c757d!important;
}
</style>

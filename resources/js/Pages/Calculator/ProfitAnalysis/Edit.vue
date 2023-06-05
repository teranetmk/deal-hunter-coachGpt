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

        update() {

            if(this.controller) this.controller.abort()
            this.controller = new AbortController()

            axios.post(route('users.calculator.profit-analysis.store', {id: this.form.id}), {...this.form}, {signal: this.controller.signal})
        }
    },
    watch: {
        "form.arv"(newValue) {
            this.form.arv = add_commas(newValue)
            this.update()
        },
        "form.estimated_hold_time"() { this.update() },
        "form.purchase_price"(newValue) {
            this.form.purchase_price = add_commas(newValue)
            this.update()
        },
        "form.reinstatement"(newValue) {
            this.form.reinstatement = add_commas(newValue)
            this.update()
        },
        "form.delinquent_taxes"(newValue) {
            this.form.delinquent_taxes = add_commas(newValue)
            this.update()
        },
        "form.closing_cost"(newValue) {this.update()},
        "form.interior_repairs"(newValue) {
            this.form.interior_repairs = add_commas(newValue)
            this.update()
        },
        "form.exterior_repairs"(newValue) {
            this.form.exterior_repairs = add_commas(newValue)
            this.update()
        },
        "form.landscaping"(newValue) {
            this.form.landscaping = add_commas(newValue)
            this.update()
        },
        "form.miscellaneous"(newValue) {
            this.form.miscellaneous = add_commas(newValue)
            this.update()
        },
        "form.contingency_percentage"(newValue) {
            this.form.contingency_percentage = add_commas(newValue)
            this.update()
        },
        "form.purchase_price_financed"(newValue) {
            this.form.purchase_price_financed = add_commas(newValue)
            this.update()
        },
        "form.renovation_financed"(newValue) {
            this.form.renovation_financed = add_commas(newValue)
            this.update()
        },
        "form.down_payment_interest_rate"(newValue) {
            this.form.down_payment_interest_rate = add_commas(newValue)
            this.update()
        },
        "form.down_payment_points"(newValue) {
            this.form.down_payment_points = add_commas(newValue)
            this.update()
        },
        "form.down_payment_lender_underwriting_fee"(newValue) {
            this.form.down_payment_lender_underwriting_fee = add_commas(newValue)
            this.update()
        },
        "form.down_payment_appraisal_fee"(newValue) {
            this.form.down_payment_appraisal_fee = add_commas(newValue)
            this.update()
        },
        "form.down_payment_title_fees"(newValue) {
            this.form.down_payment_title_fees = add_commas(newValue)
            this.update()
        },
        "form.down_payment_tax_prepaid"(newValue) {
            this.form.down_payment_tax_prepaid = add_commas(newValue)
            this.update()
        },
        "form.down_payment_insurance_prepaid"(newValue) {
            this.form.down_payment_insurance_prepaid = add_commas(newValue)
            this.update()
        },
        "form.holding_costs_load_payments"(newValue) {
            this.form.holding_costs_load_payments = add_commas(newValue)
            this.update()
        },
        "form.holding_costs_property_taxes"(newValue) {
            this.form.holding_costs_property_taxes = add_commas(newValue)
            this.update()
        },
        "form.holding_costs_insurance"(newValue) {
            this.form.holding_costs_insurance = add_commas(newValue)
            this.update()
        },
        "form.holding_costs_utilities"(newValue) {
            this.form.holding_costs_utilities = add_commas(newValue)
            this.update()
        },
        "form.holding_costs_lender_draw_fee"(newValue) {
            this.form.holding_costs_lender_draw_fee = add_commas(newValue)
            this.update()
        },
        "form.holding_costs_number_draws"(newValue) {
            this.form.holding_costs_number_draws = add_commas(newValue)
            this.update()
        },
        "form.selling_cost_closing_cost"(newValue) {
            this.form.selling_cost_closing_cost = add_commas(newValue)
            this.update()
        },
        "form.selling_cost_staging"(newValue) {
            this.form.selling_cost_staging = add_commas(newValue)
            this.update()
        },
        "form.selling_cost_concessions_and_other"(newValue) {
            this.form.selling_cost_concessions_and_other = add_commas(newValue)
            this.update()
        },
        "form.selling_cost_seller_credit_to_buyer"(newValue) {
            this.form.selling_cost_seller_credit_to_buyer = add_commas(newValue)
            this.update()
        },
        "form.selling_cost_listing_agent_commission"(newValue) {
            this.form.selling_cost_listing_agent_commission = add_commas(newValue)
            this.update()
        },
        "form.selling_cost_buyers_agent_commission"(newValue) {
            this.form.selling_cost_buyers_agent_commission = add_commas(newValue)
            this.update()
        },
        "form.gap_funding_cash_due_at_closing"(newValue) {
            this.form.gap_funding_cash_due_at_closing = add_commas(newValue)
            this.update()
        },
        "form.gap_funding_total_holding_cost"(newValue) {
            this.form.gap_funding_total_holding_cost = add_commas(newValue)
            this.update()
        },
        "form.gap_funding_contribution"(newValue) {
            this.form.gap_funding_contribution = add_commas(newValue)
            this.update()
        },
        "form.gap_funding_interest_rate_and_payments"(newValue) {
            this.form.gap_funding_interest_rate_and_payments = add_commas(newValue)
            this.update()
        },
        "form.gap_funding_profit_share"(newValue) {
            this.form.gap_funding_profit_share = add_commas(newValue)
            this.update()
        },
    },
    components: {AuthenticatedLayout, Head, Link, Form, Buttons}
}
</script>

<template>
    <AuthenticatedLayout>
        <Head title="Fix & Flip Profit Analysis Calculator" />
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

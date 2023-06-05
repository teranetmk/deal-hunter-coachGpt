<script>
import AuthenticatedLayout from "../../../Layouts/AuthenticatedLayout.vue";
import Buttons from "./Partials/Buttons.vue";
import {useForm, usePage, Link, Head} from '@inertiajs/inertia-vue3';
import Form from "./Partials/Form.vue"

export default {
    props: ['analyses', 'count'],
    data() {
        return {
            form: useForm({
                id: '',
                arv: 0,
                estimated_hold_time: 0,
                purchase_price: 0,
                reinstatement: 0,
                delinquent_taxes: 0,
                closing_cost: 0,
                interior_repairs: 0,
                exterior_repairs: 0,
                landscaping: 0,
                miscellaneous: 0,
                contingency_percentage: 0,
                purchase_price_financed: 0,
                renovation_financed: 0,
                down_payment_interest_rate: 0,
                down_payment_points: 0,
                down_payment_lender_underwriting_fee: 0,
                down_payment_appraisal_fee: 0,
                down_payment_title_fees: 0,
                down_payment_tax_prepaid: 0,
                down_payment_insurance_prepaid: 0,
                holding_costs_load_payments: 0,
                holding_costs_property_taxes: 0,
                holding_costs_insurance: 0,
                holding_costs_utilities: 0,
                holding_costs_lender_draw_fee: 0,
                holding_costs_number_draws: 0,
                selling_cost_closing_cost: 0,
                selling_cost_staging: 0,
                selling_cost_concessions_and_other: 0,
                selling_cost_seller_credit_to_buyer: 0,
                selling_cost_listing_agent_commission: 0,
                selling_cost_buyers_agent_commission: 0,
                gap_funding_cash_due_at_closing: 0,
                gap_funding_total_holding_cost: 0,
                gap_funding_contribution: 0,
                gap_funding_interest_rate_and_payments: 0,
                gap_funding_profit_share: 0,
            }),
            buttons: this.analyses,
            controller: null
        }
    },
    methods: {

        saveOrUpdate() {

            if(!this.form.processing) {

                this.form.processing = true;
                if(this.form.id) {

                    if(this.controller) this.controller.abort()
                    this.controller = new AbortController()

                    axios.post(route('users.calculator.profit-analysis.store', {id: this.form.id}), {...this.form}, {signal: this.controller.signal})
                        .then(r => { this.form.processing = false; })
                } else {

                    if(this.controller) this.controller.abort()
                    this.controller = new AbortController()

                    const self = this;
                    axios.post(route('users.calculator.profit-analysis.store'), {...this.form}, {signal: this.controller.signal})
                        .then(r => r.data)
                        .then(data => {

                            self.form.id = data.id
                            this.form.processing = false
                            this.buttons = data.analyses
                            window.history.replaceState({}, '', route('users.calculator.profit-analysis.edit', {id: data.id}))
                        })
                }
            }
        }
    },
    watch: {
        "form.arv"(newValue) {
            this.form.arv = add_commas(newValue)
            this.saveOrUpdate()
        },
        "form.estimated_hold_time"() { this.saveOrUpdate() },
        "form.purchase_price"(newValue) {
            this.form.purchase_price = add_commas(newValue)
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
        "form.closing_cost"(newValue) {this.saveOrUpdate()},
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
    <Head>
        <title>Fix & Flip Profit Analysis Calculator</title>
        <meta property="og:site_name" content="DealHunter">
        <meta property="og:title" content="Fix & Flip Profit Analysis Calculator">
        <meta property="og:description" content="Try Out Our Fix & Flip Profit Analysis Calculator">
        <meta property="og:image" content="/images/fix_flip_profit.png">
        <meta property="og:url" content="{{route('users.calculator.profit-analysis')}}">
    </Head>
    <AuthenticatedLayout>
        <template #pageHeading>
            <Buttons :analyses="buttons" />
        </template>

        <Form :form="form" :count="this.count" />

    </AuthenticatedLayout>
</template>

<style>
.p-button-secondary {
    color: #6c757d!important;
}
</style>

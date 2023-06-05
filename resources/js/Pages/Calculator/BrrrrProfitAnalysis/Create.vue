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

                refinance_loan_to_value: 0,
                refinance_interest_rate: 0,
                refinance_mortgage_term: 0,
                refinance_closing_cost: 0,

                gross_scheduled_income: 0,
                vacancy_and_concession_percentage: 0,
                leasing_fees: 0,
                property_management_fees: 0,
                maintenance_repairs: 0,
                property_annual_tax: 0,
                property_annual_insurance: 0,
                hoa_annual_fees: 0,
                water_and_sewer_annual_fees: 0,
                gas_annual_fees: 0,
                electric_annual_fees: 0,
                trash_annual_fees: 0,
                other_annual_fees: 0,

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
                if(this.controller) this.controller.abort()
                this.controller = new AbortController()

                if (this.form.id) {

                    axios.post(route('users.calculator.brrrr-profit-analysis.store', {id: this.form.id}), {...this.form}, {signal: this.controller.signal})
                        .then(() => {

                            this.form.processing = false
                        })
                } else {

                    const self = this;
                    axios.post(route('users.calculator.brrrr-profit-analysis.store'), {...this.form}, {signal: this.controller.signal})
                        .then(r => r.data)
                        .then(data => {

                            self.form.id = data.id
                            this.form.processing = false
                            this.buttons = data.analyses

                            window.history.replaceState({}, '', route('users.calculator.brrrr-profit-analysis.edit', {id: data.id}))
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
    <Head>
        <title>BRRRR Profit Analysis Calculator</title>
        <meta property="og:site_name" content="DealHunter">
        <meta property="og:title" content="BRRRR Profit Analysis Calculator">
        <meta property="og:description" content="Try Out Our BRRRR Profit Analysis Calculator">
        <meta property="og:image" content="/images/brrr_profit_analysis.png">
        <meta property="og:url" content="{{route('users.calculator.brrrr-profit-analysis')}}">
    </Head>
    <AuthenticatedLayout>
        <template #pageHeading>
            <Buttons :analyses="buttons" />
        </template>

        <Form :form="form" :count="this.count"/>

    </AuthenticatedLayout>
</template>

<style>
.p-button-secondary {
    color: #6c757d!important;
}

</style>

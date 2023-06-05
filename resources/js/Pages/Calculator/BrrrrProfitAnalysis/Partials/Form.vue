<script>
export default {
    props: ['form', 'count'],
    methods: {
        async saveCount() {
            await axios.post(route('contracts.add.share.count'), {type: 'calculator_brrrr_profit_analysis'});
            this.sharing_count += 1;
        },
        add_commas(...params) { return window.add_commas(...params)},
        remove_commas(...params) { return window.remove_commas(...params)},
    },
    data() {
        return {
            sharing_count: this.count
        }
    },
    computed: {

        closing_cost_percentage() { return Number(remove_commas(this.form.closing_cost))/100 },
        refinance_loan_to_value_percentage() { return Number(remove_commas(this.form.refinance_loan_to_value))/100 },
        refinance_closing_cost_percentage() { return Number(remove_commas(this.form.refinance_closing_cost))/100 },

        gap_funding_profit_share_percentage() { return Number(remove_commas(this.form.gap_funding_profit_share))/100 },
        leasing_fees_percentage() { return Number(remove_commas(this.form.leasing_fees))/100 },
        property_management_fees_percentage() { return Number(remove_commas(this.form.property_management_fees))/100 },
        maintenance_repairs_percentage() { return Number(remove_commas(this.form.maintenance_repairs))/100 },

        vacancy_and_concession_percentage() { return Number(remove_commas(this.form.vacancy_and_concession_percentage))/100 },

        purchase_price_financed_percentage() { return Number(remove_commas(this.form.purchase_price_financed)) / 100 },

        fund_interest_percentage() { return Number(remove_commas(this.form.gap_funding_interest_rate_and_payments)) / 100 },

        down_payment_interest_rate_percentage() { return Number(remove_commas(this.form.down_payment_interest_rate)) / 100 },

        points_percentage() { return Number(remove_commas(this.form.down_payment_points)) / 100 },

        selling_cost_listing_agent_commission_percentage() { return Number(remove_commas(this.form.selling_cost_listing_agent_commission)) / 100 },

        selling_cost_buyers_agent_commission_percentage() { return Number(remove_commas(this.form.selling_cost_buyers_agent_commission)) / 100 },

        renovation_financed_percentage() { return Number(remove_commas(this.form.renovation_financed)) / 100 },

        _contingency_percentage() { return remove_commas(this.form.contingency_percentage) / 100},

        buying_cost_total() { return this.closing_cost_percentage * remove_commas(this.form.purchase_price) },

        total_acquisition_cost() { return this.buying_cost_total + +remove_commas(this.form.delinquent_taxes) + +remove_commas(this.form.reinstatement) + +remove_commas(this.form.purchase_price) },

        vacancy_and_concession_cost() { return Number(this.vacancy_and_concession_percentage) * Number(remove_commas(this.form.gross_scheduled_income)) },

        gross_operating_income() { return Number(remove_commas(this.form.gross_scheduled_income)) - Number(this.vacancy_and_concession_cost) },
        gross_operating_income_other() { return this.gross_operating_income / (this.total_acquisition_cost + this.total_renovation_cost) * 100 },

        contingency_total() {

            return (Number(remove_commas(this.form.interior_repairs)) + Number(remove_commas(this.form.exterior_repairs)) + Number(remove_commas(this.form.landscaping)) + Number(remove_commas(this.form.miscellaneous))) * Number(remove_commas(this.form.contingency_percentage)) / 100;
        },

        total_renovation_cost() {

            return Number(this.contingency_total) + Number(remove_commas(this.form.interior_repairs)) + Number(remove_commas(this.form.exterior_repairs)) +
                Number(remove_commas(this.form.landscaping)) + Number(remove_commas(this.form.miscellaneous))
        },

        purchase_plus_rehab() { return Number(remove_commas(this.total_renovation_cost)) + Number(remove_commas(this.total_acquisition_cost)) },

        purchase_price_financed_total() { return Number(remove_commas(this.form.purchase_price)) * Number(remove_commas(this.purchase_price_financed_percentage)) },

        renovation_financed_total() { return Number(remove_commas(this.total_renovation_cost)) * Number(remove_commas(this.renovation_financed_percentage)) },

        total_load_amount() { return Number(remove_commas(this.renovation_financed_total)) + Number(remove_commas(this.purchase_price_financed_total)) },

        down_payment() {

            let purchase_price_adjustment = 0;
            if(remove_commas(this.form.purchase_price_financed) > 0) { purchase_price_adjustment = 1; }

            let renovation_financed_adjustment = 0;
            if(remove_commas(this.form.renovation_financed) > 0) { renovation_financed_adjustment = 1; }

            return Number(Number(this.total_acquisition_cost) * ( 1 - Number(this.purchase_price_financed_percentage) ) * purchase_price_adjustment +
                ( Number(this.renovation_financed_total) * ( 1 - Number(this.renovation_financed_percentage) )* renovation_financed_adjustment )).toFixed();
        },

        monthly_interest() { return Number(Number(this.down_payment_interest_rate_percentage) * Number(this.total_load_amount) / 12).toFixed(2)},
        points_total() { return Math.round(Number(this.points_percentage) * Number(this.total_load_amount))},
        total_closing_cost() {

            return Number(this.points_total) + Number(remove_commas(this.form.down_payment_lender_underwriting_fee)) + Number(remove_commas(this.form.down_payment_appraisal_fee))+  Number(remove_commas(this.form.down_payment_title_fees))+
                Number(remove_commas(this.form.down_payment_tax_prepaid))+ Number(remove_commas(this.form.down_payment_insurance_prepaid));
        },

        total_closing_cost_percentage() {

            if(this.total_load_amount == "0") return this.total_load_amount;
            return Number(Number(remove_commas(this.total_closing_cost)) / Number(remove_commas(this.total_load_amount)) * 100).toFixed(1);
        },
        cash_due_at_closing() { return Number(remove_commas(this.total_closing_cost)) +  Number(remove_commas(this.down_payment))},
        listing_agent_commission() { return Number(this.selling_cost_listing_agent_commission_percentage) * Number(remove_commas(this.form.arv)); },
        buyer_agent_commission() { return Number(this.selling_cost_buyers_agent_commission_percentage) * Number(remove_commas(this.form.arv)); },
        total_selling_cost() {

            return Number(remove_commas(this.buyer_agent_commission)) + Number(remove_commas(this.listing_agent_commission)) + Number(remove_commas(this.form.selling_cost_closing_cost)) +
                Number(remove_commas(this.form.selling_cost_staging)) + Number(remove_commas(this.form.selling_cost_concessions_and_other)) + Number(remove_commas(this.form.selling_cost_seller_credit_to_buyer))
        },

        increase_in_property_value() { return Number(remove_commas(this.form.arv))+Number(remove_commas(this.form.purchase_price))},
        cash_out_of_pocket() { return Number(this.cash_due_at_closing) + Number(this.total_holding_cost) + Number(this.total_selling_cost_out_of_pocket)},
        total_selling_cost_out_of_pocket() { return Number(remove_commas(this.form.selling_cost_staging)) + Number(remove_commas(this.form.selling_cost_concessions_and_other)) },

        total_draws() { return remove_commas(this.form.holding_costs_number_draws) * remove_commas(this.form.holding_costs_lender_draw_fee) },
        payments_total () { return Number(remove_commas(this.monthly_interest)) * Number(remove_commas(this.form.estimated_hold_time)) },
        utilities_total () { return Number(remove_commas(this.form.holding_costs_utilities)) * Number(remove_commas(this.form.estimated_hold_time))},
        insurance_total () { return Number(remove_commas(this.form.holding_costs_insurance)) * Number(remove_commas(this.form.estimated_hold_time))},
        property_tax_total () { return Math.round(Number(remove_commas(this.form.holding_costs_property_taxes)) / 12 * Number(remove_commas(this.form.estimated_hold_time))) },
        total_holding_cost() {

            return Number(remove_commas(this.property_tax_total)) + Number(this.insurance_total)
                + Number(remove_commas(this.utilities_total)) + Number(remove_commas(this.payments_total)) + Number(remove_commas(this.total_draws));
        },
        out_of_pocket_cash() { return Number(remove_commas(this.total_holding_cost)) + Number(remove_commas(this.cash_due_at_closing)) },
        contribution_interest_payment() {

            if(remove_commas(this.form.gap_funding_contribution) <= 0) return 0;

            return Number(remove_commas(this.fund_interest_percentage)) * Number(remove_commas(this.form.estimated_hold_time)) * Number(remove_commas(this.form.gap_funding_contribution)) / 12
        },

        contribution_profit_share() {

            if(remove_commas(this.form.gap_funding_contribution) <= 0) return 0;

            return Number(remove_commas(this.gap_funding_profit_share_percentage)) * Number(remove_commas(this.refinancing_cash_out_at_closing))
        },

        total_due_to_funder() { return Number(remove_commas(this.contribution_profit_share)) + Number(this.contribution_interest_payment) + Number(remove_commas(this.form.gap_funding_contribution)) },
        funder_total_profit() { return Number(remove_commas(this.contribution_profit_share)) + Number(this.contribution_interest_payment) },
        funder_effective_roi() {

            if(remove_commas(this.form.gap_funding_contribution) == "0") return remove_commas(this.form.gap_funding_contribution);
            try {
                return remove_commas(this.funder_total_profit) / remove_commas(this.form.gap_funding_contribution) * 100;
            } catch({}) {return 0}
        },
        total_purchase_and_other() {

            return Number(remove_commas(this.total_acquisition_cost)) + Number(remove_commas(this.total_renovation_cost))
                + Number(remove_commas(this.total_closing_cost)) + Number(remove_commas(this.total_holding_cost))
                + Number(remove_commas(this.total_selling_cost))
        },
        total_estimated_profit() { return Number(remove_commas(this.form.arv)) - Number(this.total_purchase_and_other) },
        your_share_of_the_profit() { return Number(remove_commas(this.total_estimated_profit)) + Number(remove_commas(this.total_due_to_funder)) },
        profit_per_month_held() { return Number(remove_commas(this.your_share_of_the_profit)) + Number(remove_commas(this.form.estimated_hold_time)) },
        deal_profit_margin() {

            if(remove_commas(this.form.arv) == "0") return remove_commas(this.form.arv);

            return Number(this.total_estimated_profit) / Number(remove_commas(this.form.arv))
        },
        leasing_fees() { return Number(this.gross_operating_income) * Number(this.leasing_fees_percentage) },
        property_management_fees() { return Number(this.gross_operating_income) * Number(this.property_management_fees_percentage) },
        maintenance_repairs() { return Number(this.gross_operating_income) * Number(this.maintenance_repairs_percentage) },
        property_annual_tax() { return Number(remove_commas(this.form.property_annual_tax)) / 12 },
        property_annual_insurance() {

            if(remove_commas(this.form.property_annual_insurance) && remove_commas(this.form.property_annual_insurance) != '0') return Number(remove_commas(this.form.property_annual_insurance)) / 12

            return 0
        },
        hoa_annual_fees() {

            if(remove_commas(this.form.hoa_annual_fees) && remove_commas(this.form.hoa_annual_fees) != '0')  return Number(remove_commas(this.form.hoa_annual_fees)) / 12

            return 0;
        },
        total_operating_expenses() {

            return Number(remove_commas(this.form.other_annual_fees))
                + Number(remove_commas(this.form.trash_annual_fees))
                + Number(remove_commas(this.form.electric_annual_fees))
                + Number(remove_commas(this.form.gas_annual_fees))
                + Number(remove_commas(this.form.water_and_sewer_annual_fees))
                + Number(remove_commas(this.hoa_annual_fees))
                + Number(remove_commas(this.property_annual_insurance))
                + Number(remove_commas(this.property_annual_tax))
                + Number(remove_commas(this.maintenance_repairs))
                + Number(remove_commas(this.property_management_fees))
                + Number(remove_commas(this.leasing_fees))
        },
        total_operating_expenses_other() { return Number(remove_commas(this.total_operating_expenses)) / Number(remove_commas(this.gross_operating_income)) * 100  },
        net_operating_income() { return Number(remove_commas(this.gross_operating_income)) - Number(remove_commas(this.total_operating_expenses)) },
        debit_service_payment() { return Number(remove_commas(this.mortgage_payment_principal)) },
        net_cash_flow_monthly() { return Number(remove_commas(this.net_operating_income)) - Number(remove_commas(this.debit_service_payment))},
        refinance_loan_to_value() { return Number(remove_commas(this.refinance_loan_to_value_percentage)) * Number(remove_commas(this.form.arv)) },
        refinance_closing_cost() { return Number(remove_commas(this.refinance_closing_cost_percentage)) * Number(remove_commas(this.refinance_loan_to_value)) },
        mortgage_payment_principal() {

            const rate = remove_commas(this.form.refinance_interest_rate) / 100 /12;
            const nper = remove_commas(this.form.refinance_mortgage_term) * 12;
            const pv = this.refinance_loan_to_value;

            return (pv * rate) / (1 - Math.pow(1 + rate, -nper))
        },
        refinancing_cash_out_at_closing() {

            return Number(this.refinance_loan_to_value) - Number(this.total_load_amount) - Number(this.refinance_closing_cost);
        },
        total_purchase_reno_holding_closing_cost() { return Number(this.total_purchase_and_other) + Number(this.refinance_closing_cost); },
        cash_out_or_in_deal() { return Number(this.total_purchase_reno_holding_closing_cost) - Number(this.refinance_loan_to_value)},
        cash_out_for_refi() { return Number(this.refinancing_cash_out_at_closing)},
        cash_required_to_purchase_renovate() { return Number(this.out_of_pocket_cash) + Number(this.funder_total_profit)},
        net_cash_after_refi() { return Number(this.cash_out_for_refi) - Number(this.cash_required_to_purchase_renovate)},
        occ_roi() {

            if(this.net_cash_after_refi > 0) return "Infinite";

            return - Number(this.net_cash_flow_monthly) *12 / Number(this.net_cash_after_refi) * 100
        },
        cap_rate() {return Number(this.total_operating_expenses)*12 / Number(remove_commas(this.form.arv)) * 100;},
        increase_in_property_value_from_reno() { return Number(remove_commas(this.form.arv))-Number(remove_commas(this.form.purchase_price))},
        rehab_to_value_add() { return Number(this.increase_in_property_value_from_reno) / Number(this.total_renovation_cost)},
    }
}
</script>

<template>
        <div>
            <div class="col-12">
                <div class="row align-items-center">
                    <div class="col text-left">
                        <div class="u_frm_hdng">
                            <i class="text-xl pi pi-calculator"></i>
                            BRRRR  Profit Analysis Calculator
                        </div>
                    </div>
                    <div class="col">
                        <div class="d-flex justify-content-end">
                            <ShareNetwork
                                @close="saveCount"
                                network="facebook"
                                url="http://dealhunter.ai/calculator/brrrr-profit-analysis"
                                title="BRRRR Profit Analysis Calculator"
                                description="Try Out Our BRRRR Profit Analysis Calculator"
                                quote="Try Out Our BRRRR Profit Analysis Calculator"
                                hashtags="calculators"
                            >
                                <Button class="rounded-3 u_hdr_btn me-3">
                                    <!-- Facebook Icon Start -->
                                    <svg width="11" height="21" viewBox="0 0 11 21" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M7 12H9.5L10.5 8H7V6C7 4.97 7 4 9 4H10.5V0.64C10.174 0.597 8.943 0.5 7.643 0.5C4.928 0.5 3 2.157 3 5.2V8H0V12H3V20.5H7V12Z"
                                            fill="white" />
                                    </svg> &nbsp;
                                    <!-- Facebook Icon End -->
                                    Share With Real Estate Friends!
                                </Button>

                            </ShareNetwork>
                            <p class="u_fb_like border-1 rounded w-fit-content p-2">
                                {{this.sharing_count}}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        <!-- Header End -->

            <div class="row mt-4">

                <div class="col-md-12">
                    <div class="card shadow-none">
                        <div class="card-body">
                            <div class="row mb-4">
                                <div class="col-md-8 d-flex" style="align-items: center;">
                                    <span class="text-lg">After Repair Value(ARV)</span>
                                </div>

                                <div class="col-md-2">
                                    <div class="position-relative">
                                        <i style="top: 38%;left: 20px;" class="position-absolute pi pi-dollar"></i>
                                        <InputText v-model="form.arv" class="w-full text-right" />
                                    </div>
                                </div>

                                <div class="col-md-2 d-flex justify-content-center align-items-center">
                                    <span class="text-lg text-dark"><i class="pi pi-dollar"></i>{{add_commas(form.arv)}}</span>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-8 d-flex" style="align-items: center;">
                                    <span class="text-lg">Estimated Hold Time (months)</span>
                                </div>

                                <div class="col-md-2">
                                    <InputText v-model="form.estimated_hold_time" class="w-full text-right" />
                                </div>

                                <div class="col-md-2 d-flex justify-content-center align-items-center">
                                    <span class="text-lg text-dark"><i class="pi pi-dollar"></i>{{add_commas(form.estimated_hold_time)}}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="card overflow-hidden p-0">
                        <div class="card-header py-3 pl-3">
                            <div class="card-title">
                                <h2 class="text-2xl d-flex gap-2 mb-0" style="align-items: center;">
                                    <svg width="17" height="17" viewBox="0 0 17 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M8.5 17C3.80534 17 0 13.1947 0 8.5C0 3.80534 3.80534 0 8.5 0C13.1947 0 17 3.80534 17 8.5C17 13.1947 13.1947 17 8.5 17ZM11.9531 10.1756C11.9531 8.83522 11.1159 8.07819 9.15716 7.60644V5.24769C9.76278 5.372 10.3424 5.63284 10.9092 6.04244L11.6312 4.87581C10.9201 4.35494 10.0848 4.02962 9.20869 3.93231V3.1875H8.08775V3.90734C6.477 4.03166 5.38209 4.95019 5.38209 6.29053C5.38209 7.69303 6.25813 8.37569 8.13928 8.84744V11.2806C7.3015 11.1562 6.60609 10.7838 5.87138 10.2128L5.04688 11.3422C5.92943 12.0216 6.98099 12.4467 8.08775 12.5715V13.8125H9.20869V12.5837C10.8449 12.4472 11.9531 11.5409 11.9531 10.1756ZM8.13875 7.34559C7.14691 7.06031 6.90253 6.72509 6.90253 6.20341C6.90253 5.65781 7.32753 5.22325 8.13928 5.16109L8.13875 7.34559ZM10.4327 10.2622C10.4327 10.8582 9.96891 11.2678 9.15716 11.33V9.08331C10.1623 9.36912 10.4327 9.70381 10.4327 10.2627V10.2622Z" fill="#101136"/>
                                    </svg> Buying
                                </h2>
                            </div>
                        </div>

                        <div class="card-body" style="padding: 1.5rem;">
                            <div class="row mb-4">
                                <div class="col-md-8 d-flex" style="align-items: center;">
                                    <span class="text-lg text-dark">Purchase Price</span>
                                </div>

                                <div class="col-md-2">
                                    <div class="position-relative">
                                        <i style="top: 38%;left: 20px;" class="position-absolute pi pi-dollar"></i>
                                        <InputText v-model="form.purchase_price" class="w-full text-right" />
                                    </div>
                                </div>

                                <div class="col-md-2 d-flex justify-content-center align-items-center">
                                    <span class="text-lg text-dark"><i class="pi pi-dollar"></i>{{add_commas(form.purchase_price)}}</span>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-8 d-flex" style="align-items: center;">
                                    <span class="text-lg text-dark">Reinstatement</span>
                                </div>

                                <div class="col-md-2">
                                    <div class="position-relative">
                                        <i style="top: 38%;left: 20px;" class="position-absolute pi pi-dollar"></i>
                                        <InputText v-model="form.reinstatement" class="w-full text-right" />
                                    </div>
                                </div>

                                <div class="col-md-2 d-flex justify-content-center align-items-center">
                                    <span class="text-lg text-dark"><i class="pi pi-dollar"></i>{{add_commas(form.reinstatement)}}</span>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-8 d-flex" style="align-items: center;">
                                    <span class="text-lg text-dark">Payoff Delinquent Taxes and other Leins</span>
                                </div>

                                <div class="col-md-2">
                                    <div class="position-relative">
                                        <i style="top: 38%;left: 20px;" class="position-absolute pi pi-dollar"></i>
                                        <InputText v-model="form.delinquent_taxes" class="w-full text-right" />
                                    </div>
                                </div>

                                <div class="col-md-2 d-flex justify-content-center align-items-center">
                                    <span class="text-lg text-dark"><i class="pi pi-dollar"></i>{{add_commas(form.delinquent_taxes)}}</span>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-8 d-flex" style="align-items: center;">
                                    <span class="text-lg text-dark">Closing Costs / Title Insurance (If buying cash)</span>
                                </div>

                                <div class="col-md-2">
                                    <div class="position-relative">
                                        <i style="top: 25%;right: 18px;" class="position-absolute">%</i>
                                        <InputText max="100" min="0" v-model="form.closing_cost" class="w-full text-right pr-5" />
                                    </div>
                                </div>

                                <div class="col-md-2 d-flex justify-content-center align-items-center">
                                    <span class="text-lg text-dark"><i class="pi pi-dollar"></i>{{add_commas(buying_cost_total)}}</span>
                                </div>
                            </div>

                            <div class="card-footer pl-0" style="background: none;padding-right:0;">
                                <div class="row">
                                    <div class="col-md-10">
                                        <strong class="text-lg text-dark">TOTAL ACQUISITION COST</strong>
                                    </div>

                                    <div class="col-md-2 d-flex justify-content-center align-items-center">
                                        <strong class="text-lg text-dark"><i class="pi pi-dollar"></i>{{add_commas(total_acquisition_cost)}}</strong>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="card overflow-hidden p-0">
                        <div class="card-header py-3 pl-3">
                            <div class="card-title">
                                <h2 class="text-2xl d-flex gap-2 mb-0" style="align-items: center;">
                                    <svg width="18" height="15" viewBox="0 0 18 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M7.87611 0.809933L0.571903 5.19717C0.393799 5.30497 0.162126 5.24789 0.0545019 5.06978C-0.0532978 4.89168 0.00378178 4.66 0.181889 4.55238L7.68107 0.0528716C7.80209 -0.0154266 7.95007 -0.0154266 8.0711 0.0528716L15.5703 4.55238C15.7161 4.63875 15.7857 4.81251 15.74 4.97572C15.6943 5.13909 15.5448 5.25141 15.3753 5.24974C15.3066 5.25124 15.239 5.233 15.1803 5.19717L7.87611 0.809933ZM7.87611 10.4989C7.37893 10.4989 6.90207 10.6964 6.55034 11.0479C6.19881 11.3996 6.00131 11.8765 6.00131 12.3737V14.9984H9.7509V12.3737C9.7509 11.8765 9.55338 11.3996 9.20187 11.0479C8.85018 10.6964 8.37328 10.4989 7.87611 10.4989ZM17.625 7.4992H16.5002V8.62408C16.5002 8.83114 16.3323 8.99904 16.1252 8.99904C15.9181 8.99904 15.7502 8.83114 15.7502 8.62408V7.4992H15.0003V8.62408C15.0003 8.83114 14.8324 8.99904 14.6254 8.99904C14.4183 8.99904 14.2504 8.83114 14.2504 8.62408V7.4992H13.1255C12.9185 7.4992 12.7506 7.6671 12.7506 7.87416V10.4989H18V7.87416C18 7.77473 17.9605 7.67932 17.8902 7.60901C17.8199 7.53871 17.7245 7.4992 17.625 7.4992ZM12.7506 11.2488V11.6238C12.7506 11.7232 12.7901 11.8186 12.8604 11.8889C12.9307 11.9592 13.0261 11.9987 13.1255 11.9987H14.2504V13.8735C14.2504 14.2754 14.4648 14.6467 14.8128 14.8477C15.1609 15.0486 15.5897 15.0486 15.9377 14.8477C16.2857 14.6467 16.5002 14.2754 16.5002 13.8735V11.9987H17.625C17.7245 11.9987 17.8199 11.9592 17.8902 11.8889C17.9605 11.8186 18 11.7232 18 11.6238V11.2488H12.7506ZM15.7502 11.9987H15.0003V13.8735C15.0003 14.0806 15.1682 14.2485 15.3753 14.2485C15.5823 14.2485 15.7502 14.0806 15.7502 13.8735V11.9987ZM12.0007 11.6238V7.87416C12.0007 7.57587 12.1192 7.28961 12.3301 7.07873C12.541 6.86786 12.8273 6.74931 13.1255 6.74931H14.2504V5.51194L7.87608 1.68736L1.50178 5.51194V13.1234C1.50178 13.6206 1.6993 14.0974 2.05081 14.4492C2.4025 14.8007 2.8794 14.9982 3.37657 14.9982H5.25137V12.3735C5.25137 11.4357 5.75172 10.5693 6.56373 10.1005C7.37574 9.63161 8.37643 9.63161 9.18844 10.1005C10.0005 10.5693 10.5008 11.4357 10.5008 12.3735V14.9982H13.5005V12.7484H13.1255C12.8272 12.7484 12.541 12.6299 12.3301 12.419C12.1192 12.2081 12.0007 11.9218 12.0007 11.6236V11.6238Z" fill="#101136"/>
                                    </svg> Renovation
                                </h2>
                            </div>
                        </div>

                        <section class="card-body p-0 overflow-hidden">
                            <section style="padding: 1.5rem;">
                                <div class="row mb-4">
                                    <div class="col-md-8 d-flex" style="align-items: center;">
                                        <span class="text-lg text-dark">Interior Repairs</span>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="position-relative">
                                            <i style="top: 38%;left: 20px;" class="position-absolute pi pi-dollar"></i>
                                            <InputText v-model="form.interior_repairs" class="w-full text-right" />
                                        </div>
                                    </div>

                                    <div class="col-md-2 d-flex justify-content-center align-items-center">
                                        <span class="text-lg text-dark"><i class="pi pi-dollar"></i>{{add_commas(form.interior_repairs)}}</span>
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-md-8 d-flex" style="align-items: center;">
                                        <span class="text-lg text-dark">Exterior Repairs</span>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="position-relative">
                                            <i style="top: 38%;left: 20px;" class="position-absolute pi pi-dollar"></i>
                                            <InputText v-model="form.exterior_repairs" class="w-full text-right" />
                                        </div>
                                    </div>

                                    <div class="col-md-2 d-flex justify-content-center align-items-center">
                                        <span class="text-lg text-dark"><i class="pi pi-dollar"></i>{{add_commas(form.exterior_repairs)}}</span>
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-md-8 d-flex" style="align-items: center;">
                                        <span class="text-lg text-dark">Landscaping</span>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="position-relative">
                                            <i style="top: 38%;left: 20px;" class="position-absolute pi pi-dollar"></i>
                                            <InputText v-model="form.landscaping" class="w-full text-right" />
                                        </div>
                                    </div>

                                    <div class="col-md-2 d-flex justify-content-center align-items-center">
                                        <span class="text-lg text-dark"><i class="pi pi-dollar"></i>{{add_commas(form.landscaping)}}</span>
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-md-8 d-flex" style="align-items: center;">
                                        <span class="text-lg text-dark">Miscellaneous</span>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="position-relative">
                                            <i style="top: 38%;left: 20px;" class="position-absolute pi pi-dollar"></i>
                                            <InputText v-model="form.miscellaneous" class="w-full text-right" />
                                        </div>
                                    </div>

                                    <div class="col-md-2 d-flex justify-content-center align-items-center">
                                        <span class="text-lg text-dark"><i class="pi pi-dollar"></i>{{add_commas(form.miscellaneous)}}</span>
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-md-8 d-flex" style="align-items: center;">
                                        <span class="text-lg text-dark">Contingency %</span>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="position-relative">
                                            <span style="top: 25%;right: 15px;" class="position-absolute">%</span>
                                            <InputText v-model="form.contingency_percentage" min="0" max="100" class="w-full text-right pr-5" />
                                        </div>
                                    </div>

                                    <div class="col-md-2 d-flex justify-content-center align-items-center">
                                        <span class="text-lg text-dark"><i class="pi pi-dollar"></i>{{add_commas(contingency_total)}}</span>
                                    </div>
                                </div>
                            </section>

                            <div class="card-footer" style="background: none;padding: 1.5rem;">
                                <div class="row">
                                    <div class="col-md-10">
                                        <strong class="text-lg text-dark">TOTAL RENOVATION COST</strong>
                                    </div>

                                    <div class="col-md-2 d-flex justify-content-center align-items-center">
                                        <strong class="text-lg"><i class="pi pi-dollar"></i>{{add_commas(total_renovation_cost)}}</strong>
                                    </div>
                                </div>
                            </div>
                        </section>

                        <section class="p-2 pl-3 mt-0 mb-5" style="background: rgba(219,15,25,0.1);padding-right: 1.5rem!important;">
                            <div class="row">
                                <div class="col-md-10">
                                    <strong class="text-danger">TOTAL PURCHASE + REHAB</strong>
                                </div>

                                <div class="col-md-2 d-flex justify-content-center align-items-center">
                                    <strong class="text-danger text-lg"><i class="pi pi-dollar"></i>{{add_commas(purchase_plus_rehab)}}</strong>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="card overflow-hidden p-0">
                        <div class="card-header py-3 pl-3">
                            <div class="card-title">
                                <h2 class="text-2xl d-flex gap-2 mb-0" style="align-items: center;">
                                    <svg width="18" height="19" viewBox="0 0 18 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M15.75 12.6073V13.625C15.75 14.2355 15.4643 14.7575 15.0675 15.1677C14.6753 15.5742 14.1428 15.9058 13.5435 16.1683C12.342 16.6933 10.7355 17 9 17C7.2645 17 5.658 16.694 4.4565 16.1683C3.85725 15.9058 3.32475 15.5742 2.9325 15.1677C2.56875 14.7927 2.29875 14.3217 2.256 13.7758L2.25 13.625V12.6073C2.59875 12.8053 2.9715 12.9807 3.3705 13.1285C4.893 13.6917 6.88425 14.006 9 14.006C11.1158 14.006 13.107 13.6917 14.6295 13.1285C14.9288 13.0175 15.213 12.8915 15.4838 12.7512L15.75 12.6073ZM2.25 8.48225C2.59875 8.68025 2.9715 8.85575 3.3705 9.0035C4.893 9.56675 6.88425 9.881 9 9.881C11.1158 9.881 13.107 9.56675 14.6295 9.0035C15.0166 8.86062 15.3914 8.68629 15.75 8.48225V10.811C15.252 11.1954 14.6987 11.5024 14.109 11.7215C12.7928 12.209 10.986 12.5068 9 12.5068C7.01475 12.5068 5.208 12.209 3.891 11.7215C3.30127 11.5024 2.74802 11.1954 2.25 10.811V8.48225ZM9 2.75C10.7355 2.75 12.342 3.056 13.5435 3.58175C14.1428 3.84425 14.6753 4.17575 15.0675 4.58225C15.4313 4.95725 15.7013 5.42825 15.744 5.97425L15.75 6.125V6.686C15.252 7.07043 14.6987 7.3774 14.109 7.5965C12.7928 8.084 10.986 8.38175 9 8.38175C7.01475 8.38175 5.208 8.084 3.891 7.5965C3.38388 7.4084 2.90355 7.15474 2.46225 6.842L2.25 6.686V6.125C2.25 5.5145 2.53575 4.9925 2.9325 4.58225C3.32475 4.17575 3.85725 3.84425 4.4565 3.58175C5.658 3.05675 7.2645 2.75 9 2.75Z" fill="#101136"/>
                                    </svg> Financing
                                </h2>
                            </div>
                        </div>

                        <div class="card-body" style="padding: 1.5rem;">
                            <div class="row mb-4">
                                <div class="col-md-8 d-flex" style="align-items: center;">
                                    <span class="text-lg">Amount of Purchase Price Financed (%)</span>
                                </div>

                                <div class="col-md-2">
                                    <div class="position-relative">
                                        <span style="top: 25%;right: 15px;" class="position-absolute">%</span>
                                        <InputText min="0" max="100" v-model="form.purchase_price_financed" class="w-full text-right pr-5" />
                                    </div>
                                </div>

                                <div class="col-md-2 d-flex justify-content-center align-items-center">
                                    <span class="text-lg text-dark"><i class="pi pi-dollar"></i>{{add_commas(purchase_price_financed_total)}}</span>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-8 d-flex" style="align-items: center;">
                                    <span class="text-lg">Amount of Renovation Financed (%)</span>
                                </div>

                                <div class="col-md-2">
                                    <div class="position-relative">
                                        <span style="top: 25%;right: 15px;" class="position-absolute">%</span>
                                        <InputText min="0" max="100" v-model="form.renovation_financed" class="w-full text-right pr-5" />
                                    </div>
                                </div>

                                <div class="col-md-2 d-flex justify-content-center align-items-center">
                                    <span class="text-lg text-dark"><i class="pi pi-dollar"></i>{{add_commas(renovation_financed_total)}}</span>
                                </div>
                            </div>

                            <hr />
                            <div class="row mb-2">
                                <div class="col-md-10">
                                    <h3>TOTAL LOAN AMOUNT</h3>
                                </div>

                                <div class="col-md-2 text-center">
                                    <strong class="text-lg text-dark"><i class="pi pi-dollar"></i>{{add_commas(total_load_amount)}}</strong>
                                </div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-md-10">
                                    <h3>DOWNPAYMENT</h3>
                                </div>

                                <div class="col-md-2 text-center">
                                    <strong class="text-lg text-dark"><i class="pi pi-dollar"></i>{{add_commas(down_payment)}}</strong>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-8 d-flex" style="align-items: center;">
                                    <span class="text-lg">Interest Rate & Interest-Only Payment (Monthly)</span>
                                </div>

                                <div class="col-md-2">
                                    <div class="position-relative">
                                        <span style="top: 25%;right: 15px;" class="position-absolute">%</span>
                                        <InputText v-model="form.down_payment_interest_rate" class="w-full text-right pr-5" />
                                    </div>
                                </div>

                                <div class="col-md-2 d-flex justify-content-center align-items-center">
                                    <span class="text-lg text-dark"><i class="pi pi-dollar"></i>{{add_commas(Math.round(monthly_interest))}}</span>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <h3>Closing Costs:</h3>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-8 d-flex" style="align-items: center;">
                                    <span class="text-lg">Points</span>
                                </div>

                                <div class="col-md-2">
                                    <div class="position-relative">
                                        <span style="top: 25%;right: 15px;" class="position-absolute">%</span>
                                        <InputText v-model="form.down_payment_points" class="w-full text-right pr-5" />
                                    </div>
                                </div>

                                <div class="col-md-2 d-flex justify-content-center align-items-center">
                                    <span class="text-lg text-dark"><i class="pi pi-dollar"></i>{{add_commas(points_total)}}</span>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-8 d-flex" style="align-items: center;">
                                    <span class="text-lg">Lender Underwriting Fee</span>
                                </div>

                                <div class="col-md-2">
                                    <div class="position-relative">
                                        <i style="top: 38%;left: 20px;" class="position-absolute pi pi-dollar"></i>
                                        <InputText v-model="form.down_payment_lender_underwriting_fee" class="w-full text-right" />
                                    </div>
                                </div>

                                <div class="col-md-2 d-flex justify-content-center align-items-center">
                                    <span class="text-lg text-dark"><i class="pi pi-dollar"></i>{{add_commas(form.down_payment_lender_underwriting_fee)}}</span>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-8 d-flex" style="align-items: center;">
                                    <span class="text-lg">Appraisal Fee</span>
                                </div>

                                <div class="col-md-2">
                                    <div class="position-relative">
                                        <i style="top: 38%;left: 20px;" class="position-absolute pi pi-dollar"></i>
                                        <InputText v-model="form.down_payment_appraisal_fee" class="w-full text-right" />
                                    </div>
                                </div>

                                <div class="col-md-2 d-flex justify-content-center align-items-center">
                                    <span class="text-lg text-dark"><i class="pi pi-dollar"></i>{{add_commas(form.down_payment_appraisal_fee)}}</span>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-8 d-flex" style="align-items: center;">
                                    <span class="text-lg">Title Fees</span>
                                </div>

                                <div class="col-md-2">
                                    <div class="position-relative">
                                        <i style="top: 38%;left: 20px;" class="position-absolute pi pi-dollar"></i>
                                        <InputText v-model="form.down_payment_title_fees" class="w-full text-right" />
                                    </div>
                                </div>

                                <div class="col-md-2 d-flex justify-content-center align-items-center">
                                    <span class="text-lg text-dark"><i class="pi pi-dollar"></i>{{add_commas(form.down_payment_title_fees)}}</span>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-8 d-flex" style="align-items: center;">
                                    <span class="text-lg">Tax Prepaid</span>
                                </div>

                                <div class="col-md-2">
                                    <div class="position-relative">
                                        <i style="top: 38%;left: 20px;" class="position-absolute pi pi-dollar"></i>
                                        <InputText v-model="form.down_payment_tax_prepaid" class="w-full text-right" />
                                    </div>
                                </div>

                                <div class="col-md-2 d-flex justify-content-center align-items-center">
                                    <span class="text-lg text-dark"><i class="pi pi-dollar"></i>{{add_commas(form.down_payment_tax_prepaid)}}</span>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-8 d-flex" style="align-items: center;">
                                    <span class="text-lg">Insurance Prepaid</span>
                                </div>

                                <div class="col-md-2">
                                    <div class="position-relative">
                                        <i style="top: 38%;left: 20px;" class="position-absolute pi pi-dollar"></i>
                                        <InputText v-model="form.down_payment_insurance_prepaid" class="w-full text-right" />
                                    </div>
                                </div>

                                <div class="col-md-2 d-flex justify-content-center align-items-center">
                                    <span class="text-lg text-dark"><i class="pi pi-dollar"></i>{{add_commas(form.down_payment_insurance_prepaid)}}</span>
                                </div>
                            </div>

                            <div class="card-footer" style="background: none;padding-right: 0!important;">
                                <div class="row">
                                    <div class="col-md-8">
                                        <strong class="text-lg text-dark">Total Closing Costs</strong>
                                    </div>

                                    <div class="col-md-2 d-flex justify-content-center align-items-center">
                                        <strong class="text-lg text-dark">{{add_commas(total_closing_cost_percentage)}} %</strong>
                                    </div>

                                    <div class="col-md-2 d-flex justify-content-center align-items-center">
                                        <strong class="text-lg text-dark"><i class="pi pi-dollar"></i>{{add_commas(total_closing_cost)}}</strong>
                                    </div>
                                </div>

                                <div class="row mt-3">
                                    <div class="col-md-10">
                                        <strong class="text-lg text-dark">CASH DUE AT CLOSING</strong>
                                    </div>

                                    <div class="col-md-2 d-flex justify-content-center align-items-center">
                                        <strong class="text-lg text-dark"><i class="pi pi-dollar"></i>{{add_commas(cash_due_at_closing)}}</strong>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="card p-0">
                        <div class="card-header py-3 pl-3">
                            <div class="card-title">
                                <h2 class="text-2xl d-flex gap-2 mb-0" style="align-items: center;">
                                    <svg width="18" height="15" viewBox="0 0 18 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M10.7673 6.19098L6.67636 3.27008C6.10364 2.86098 5.34273 2.86098 4.77818 3.27008L0.687273 6.19098C0.253636 6.50189 0 6.9928 0 7.52462V14.0455C0 14.4955 0.368182 14.8637 0.818182 14.8637H4.09091V9.95462H7.36364V14.8637H10.6364C11.0864 14.8637 11.4545 14.4955 11.4545 14.0455V7.52462C11.4545 6.9928 11.2009 6.50189 10.7673 6.19098Z" fill="#101136"/>
                                        <path d="M16.3883 0.136353H8.97559C8.08377 0.136353 7.36377 0.856352 7.36377 1.74817L7.43741 1.82181C7.50286 1.86272 7.56831 1.89544 7.63377 1.93635L11.7247 4.85726C12.3465 5.29908 12.7883 5.95363 12.9847 6.68181H14.7274V8.31817H13.091V9.95453H14.7274V11.5909H13.091V14.8636H16.3883C17.2801 14.8636 18.0001 14.1436 18.0001 13.2518V1.74817C18.0001 0.856352 17.2801 0.136353 16.3883 0.136353ZM14.7274 5.04544H13.091V3.40908H14.7274V5.04544Z" fill="#101136"/>
                                    </svg> Holding Cost
                                </h2>
                            </div>
                        </div>

                        <div class="card-body" style="padding: 1.5rem;">
                            <div class="row mb-4">
                                <div class="col-md-8 d-flex" style="align-items: center;">
                                    <span class="text-lg">Loan Payments (<span class="text-danger">6 months</span>)</span>
                                </div>

                                <div class="col-md-2">
                                    <div class="position-relative">
                                        <i style="top: 38%;left: 20px;" class="position-absolute pi pi-dollar"></i>
                                        <InputText disabled v-bind:value="monthly_interest" class="w-full text-right" />
                                    </div>
                                </div>

                                <div class="col-md-2 d-flex justify-content-center align-items-center">
                                    <span class="text-lg text-dark"><i class="pi pi-dollar"></i>{{add_commas(Math.round(payments_total))}}</span>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-8 d-flex" style="align-items: center;">
                                    <span class="text-lg">Property Taxes (<span class="text-muted">Annual</span>)</span>
                                </div>

                                <div class="col-md-2">
                                    <div class="position-relative">
                                        <i style="top: 38%;left: 20px;" class="position-absolute pi pi-dollar"></i>
                                        <InputText v-model="form.holding_costs_property_taxes" class="w-full text-right" />
                                    </div>
                                </div>

                                <div class="col-md-2 d-flex justify-content-center align-items-center">
                                    <span class="text-lg text-dark"><i class="pi pi-dollar"></i>{{add_commas(property_tax_total)}}</span>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-8 d-flex" style="align-items: center;">
                                    <span class="text-lg">Insurance (<span class="text-muted">Annual</span>)</span>
                                </div>

                                <div class="col-md-2">
                                    <div class="position-relative">
                                        <i style="top: 38%;left: 20px;" class="position-absolute pi pi-dollar"></i>
                                        <InputText v-model="form.holding_costs_insurance" class="w-full text-right" />
                                    </div>
                                </div>

                                <div class="col-md-2 d-flex justify-content-center align-items-center">
                                    <span class="text-lg text-dark"><i class="pi pi-dollar"></i>{{add_commas(insurance_total)}}</span>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-8 d-flex" style="align-items: center;">
                                    <span class="text-lg">Utilities (<span class="text-muted">Annual</span>)</span>
                                </div>

                                <div class="col-md-2">
                                    <div class="position-relative">
                                        <i style="top: 38%;left: 20px;" class="position-absolute pi pi-dollar"></i>
                                        <InputText v-model="form.holding_costs_utilities" class="w-full text-right" />
                                    </div>
                                </div>

                                <div class="col-md-2 d-flex justify-content-center align-items-center">
                                    <span class="text-lg text-dark"><i class="pi pi-dollar"></i>{{add_commas(utilities_total)}}</span>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-8 d-flex" style="align-items: center;">
                                    <span class="text-lg">Lender Draw Fee (<span class="text-muted">Per draw</span>)</span>
                                </div>

                                <div class="col-md-2">
                                    <div class="position-relative">
                                        <i style="top: 38%;left: 20px;" class="position-absolute pi pi-dollar"></i>
                                        <InputText v-model="form.holding_costs_lender_draw_fee" class="w-full text-right" />
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-8 d-flex" style="align-items: center;">
                                    <span class="text-lg">Number of Draws : Total Draw Fees</span>
                                </div>

                                <div class="col-md-2">
                                    <div class="position-relative">
                                        <i style="top: 38%;left: 20px;" class="position-absolute pi pi-dollar"></i>
                                        <InputText v-model="form.holding_costs_number_draws" class="w-full text-right" />
                                    </div>
                                </div>

                                <div class="col-md-2 d-flex justify-content-center align-items-center">
                                    <span class="text-lg text-dark"><i class="pi pi-dollar"></i>{{add_commas(total_draws)}}</span>
                                </div>
                            </div>

                            <div class="card-footer pl-0" style="background: none;padding-right: 0!important;">
                                <div class="row">
                                    <div class="col-md-10">
                                        <strong class="text-lg text-dark">TOTAL HOLDING COSTS</strong>
                                    </div>

                                    <div class="col-md-2 d-flex justify-content-center align-items-center">
                                        <strong class="text-lg text-dark"><i class="pi pi-dollar"></i>{{add_commas(Math.round(total_holding_cost))}}</strong>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="card overflow-hidden p-0">
                        <div class="card-header py-3 pl-3">
                            <div class="card-title">
                                <h2 class="text-2xl d-flex gap-2 mb-0" style="align-items: center;">
                                    <svg width="18" height="19" viewBox="0 0 18 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M6.9612 17.9819C7.30663 18.3273 7.73467 18.5 8.24531 18.5C8.75595 18.5 9.18398 18.3273 9.52941 17.9819L17.4593 10.0519C17.6245 9.88673 17.7558 9.69149 17.8531 9.46621C17.951 9.24093 18 9.00063 18 8.74531V2.30225C18 1.80663 17.8234 1.3822 17.4701 1.02896C17.1175 0.67632 16.6934 0.5 16.1977 0.5H9.75469C9.49937 0.5 9.25907 0.548661 9.03379 0.645982C8.80851 0.743905 8.61327 0.875469 8.44806 1.04068L0.518148 8.99312C0.172716 9.33855 0 9.76268 0 10.2655C0 10.7689 0.172716 11.1934 0.518148 11.5388L6.9612 17.9819ZM13.9449 5.90676C13.5695 5.90676 13.2505 5.77519 12.9879 5.51206C12.7248 5.24954 12.5932 4.93054 12.5932 4.55507C12.5932 4.1796 12.7248 3.8606 12.9879 3.59807C13.2505 3.33494 13.5695 3.20338 13.9449 3.20338C14.3204 3.20338 14.6394 3.33494 14.9019 3.59807C15.1651 3.8606 15.2966 4.1796 15.2966 4.55507C15.2966 4.93054 15.1651 5.24954 14.9019 5.51206C14.6394 5.77519 14.3204 5.90676 13.9449 5.90676Z" fill="#101136"/>
                                    </svg> GAP Funding (Optional)
                                </h2>
                            </div>
                        </div>

                        <div class="card-body">
                            <section style="padding: 1.5rem;">
                                <div class="row mb-4">
                                    <div class="col-md-10">
                                        <span class="text-lg">Cash Due at Closing</span>
                                    </div>

                                    <div class="col-md-2 d-flex justify-content-center align-items-center">
                                        <span class="text-lg text-dark"><i class="pi pi-dollar"></i>{{add_commas(cash_due_at_closing)}}</span>
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-md-10">
                                        <span class="text-lg">Total Holding Cost</span>
                                    </div>

                                    <div class="col-md-2 d-flex justify-content-center align-items-center">
                                        <strong class="text-lg text-dark"><i class="pi pi-dollar"></i>{{add_commas(Math.round(total_holding_cost))}}</strong>
                                    </div>
                                </div>

                                <hr />
                                <div class="row mb-4">
                                    <div class="col-md-10">
                                        <strong class="text-lg">TOTAL OUT-OF-POCKET CASH REQUIRED</strong>
                                    </div>

                                    <div class="col-md-2 d-flex justify-content-center align-items-center">
                                        <strong class="text-lg text-dark"><i class="pi pi-dollar"></i> {{add_commas(Math.round(out_of_pocket_cash))}}</strong>
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-md-8">
                                        <span class="text-lg">GAP Funder Contribution</span>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="position-relative">
                                            <i style="top: 38%;left: 20px;" class="position-absolute pi pi-dollar"></i>
                                            <InputText v-model="form.gap_funding_contribution" class="w-full text-right" />
                                        </div>
                                    </div>

                                    <div class="col-md-2 d-flex justify-content-center align-items-center">
                                        <span class="text-lg text-dark"><i class="pi pi-dollar"></i> {{add_commas(form.gap_funding_contribution)}}</span>
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-md-8">
                                        <span class="text-lg">GAP Funder Interest Rate & Payments (6 months)</span>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="position-relative">
                                            <span style="top: 25%;right: 15px;" class="position-absolute">%</span>
                                            <InputText v-model="form.gap_funding_interest_rate_and_payments" class="w-full text-right pr-5" />
                                        </div>
                                    </div>

                                    <div class="col-md-2 d-flex justify-content-center align-items-center">
                                        <span class="text-lg text-dark"><i class="pi pi-dollar"></i> {{add_commas(contribution_interest_payment)}}</span>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-8">
                                        <span class="text-lg">Gap Funder Profit Share %</span>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="position-relative">
                                            <span style="top: 25%;right: 15px;" class="position-absolute">%</span>
                                            <InputText v-model="form.gap_funding_profit_share" class="w-full text-right pr-5" />
                                        </div>
                                    </div>

                                    <div class="col-md-2 d-flex justify-content-center align-items-center">
                                        <span class="text-lg text-dark"><i class="pi pi-dollar"></i> {{add_commas(Math.round(contribution_profit_share))}}</span>
                                    </div>
                                </div>

                                <hr />
                                <div class="row">
                                    <div class="col-md-10">
                                        <h3>TOTAL DUE TO GAP FUNDER AT EXIT</h3>
                                    </div>

                                    <div class="col-md-2 d-flex justify-content-center align-items-center">
                                        <strong class="text-lg text-dark"><i class="pi pi-dollar"></i> {{add_commas(Math.round(total_due_to_funder))}}</strong>
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-md-10">
                                        <span class="text-lg">Gap Funder's Total Profit</span>
                                    </div>

                                    <div class="col-md-2 d-flex justify-content-center align-items-center">
                                        <span class="text-lg text-dark"><i class="pi pi-dollar"></i> {{add_commas(Math.round(funder_total_profit))}}</span>
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-md-10">
                                        <span class="text-lg text-dark">Gap Funder's Effective ROI</span>
                                    </div>

                                    <div class="col-md-2 d-flex justify-content-center align-items-center">
                                        <span class="text-lg text-dark">
                                            <span v-if="funder_effective_roi != 0">{{add_commas(funder_effective_roi, 1)}}%</span>
                                        </span>
                                    </div>
                                </div>
                            </section>

                            <section class="p-2 pl-3 mt-0 mb-5" style="background: rgba(219,15,25,0.1)">
                                <div class="row">
                                    <div class="col-md-10">
                                        <strong class="text-danger">TOTAL PURCHASE, FINANCE, RENO, HOLDING & SELLING COST</strong>
                                    </div>

                                    <div class="col-md-2 d-flex justify-content-center align-items-center">
                                        <strong class="text-lg text-dark"><i class="pi pi-dollar"></i> {{add_commas(total_purchase_and_other)}}</strong>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="card overflow-hidden p-0">
                        <div class="card-header py-3 pl-3">
                            <div class="card-title">
                                <h2 class="text-2xl d-flex gap-2 mb-0" style="align-items: center;">
                                    <svg width="18" height="19" viewBox="0 0 18 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M6.9612 17.9821C7.30663 18.3275 7.73467 18.5002 8.24531 18.5002C8.75595 18.5002 9.18398 18.3275 9.52941 17.9821L17.4593 10.0522C17.6245 9.88698 17.7558 9.69173 17.8531 9.46645C17.951 9.24117 18 9.00087 18 8.74555V2.3025C18 1.80688 17.8234 1.38245 17.4701 1.02921C17.1175 0.676564 16.6934 0.500244 16.1977 0.500244H9.75469C9.49937 0.500244 9.25907 0.548905 9.03379 0.646227C8.80851 0.744149 8.61327 0.875713 8.44806 1.04092L0.518148 8.99336C0.172716 9.33879 0 9.76292 0 10.2658C0 10.7692 0.172716 11.1936 0.518148 11.539L6.9612 17.9821ZM13.9449 5.907C13.5695 5.907 13.2505 5.77544 12.9879 5.51231C12.7248 5.24978 12.5932 4.93078 12.5932 4.55531C12.5932 4.17984 12.7248 3.86085 12.9879 3.59832C13.2505 3.33519 13.5695 3.20362 13.9449 3.20362C14.3204 3.20362 14.6394 3.33519 14.9019 3.59832C15.1651 3.86085 15.2966 4.17984 15.2966 4.55531C15.2966 4.93078 15.1651 5.24978 14.9019 5.51231C14.6394 5.77544 14.3204 5.907 13.9449 5.907Z" fill="#101136"/>
                                    </svg> CASH OUT REFINANCE
                                </h2>
                            </div>
                        </div>

                        <div class="card-body" style="padding: 1.5rem;">
                            <div class="row mb-4">
                                <div class="col-md-8 d-flex" style="align-items: center;">
                                    <span class="text-lg">Loan-to-Value (LTV); Loan Amount</span>
                                </div>

                                <div class="col-md-2">
                                    <div class="position-relative">
                                        <span style="top: 25%;right: 15px;" class="position-absolute">%</span>
                                        <InputText v-model="form.refinance_loan_to_value" class="w-full text-right pr-5" />
                                    </div>
                                </div>

                                <div class="col-md-2 d-flex justify-content-center align-items-center">
                                    <span class="text-lg text-dark"><i class="pi pi-dollar"></i>{{add_commas(refinance_loan_to_value)}}</span>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-8 d-flex" style="align-items: center;">
                                    <span class="text-lg">Interest Rate</span>
                                </div>

                                <div class="col-md-2">
                                    <div class="position-relative">
                                        <span style="top: 25%;right: 15px;" class="position-absolute">%</span>
                                        <InputText v-model="form.refinance_interest_rate" class="w-full text-right pr-5" />
                                    </div>
                                </div>

                                <div class="col-md-2 d-flex justify-content-center align-items-center">
                                    <span class="text-lg text-dark">{{add_commas(form.refinance_interest_rate, 2)}}%</span>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-8 d-flex" style="align-items: center;">
                                    <span class="text-lg">Mortgage Term (years)</span>
                                </div>

                                <div class="col-md-2">
                                    <div class="position-relative">
                                        <!-- <i style="top: 38%;left: 20px;" class="position-absolute pi pi-dollar"></i> -->
                                        <InputText v-model="form.refinance_mortgage_term" class="w-full text-right" />
                                    </div>
                                </div>

                                <div class="col-md-2 d-flex justify-content-center align-items-center">
                                    <span class="text-lg text-dark">{{add_commas(Math.round(remove_commas(form.refinance_mortgage_term)))}}</span>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-8 d-flex" style="align-items: center;">
                                    <span class="text-lg">Closing Costs</span>
                                </div>

                                <div class="col-md-2">
                                    <div class="position-relative">
                                        <span style="top: 25%;right: 15px;" class="position-absolute">%</span>
                                        <InputText v-model="form.refinance_closing_cost" class="w-full text-right pr-5" />
                                    </div>
                                </div>

                                <div class="col-md-2 d-flex justify-content-center align-items-center">
                                    <span class="text-lg text-dark"><i class="pi pi-dollar"></i>{{add_commas(refinance_closing_cost)}}</span>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-10 d-flex" style="align-items: center;">
                                    <span class="text-lg">Mortgage Payment (Principal & Interest)</span>
                                </div>

                                <div class="col-md-2 d-flex justify-content-center align-items-center">
                                    <span class="text-lg text-dark"><i class="pi pi-dollar"></i>{{add_commas(Math.round(mortgage_payment_principal))}}</span>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-10 d-flex" style="align-items: center;">
                                    <strong class="text-lg">CASH OUT AT CLOSING</strong>
                                </div>

                                <div class="col-md-2 d-flex justify-content-center align-items-center">
                                    <strong class="text-lg text-dark"><i class="pi pi-dollar"></i>{{add_commas(Math.round(refinancing_cash_out_at_closing))}}</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="card overflow-hidden p-0">
                        <div class="card-header py-3 pl-3">
                            <div class="card-title">
                                <h2 class="text-2xl d-flex gap-2 mb-0" style="align-items: center;">
                                    <svg width="18" height="19" viewBox="0 0 18 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M6.9612 17.9821C7.30663 18.3275 7.73467 18.5002 8.24531 18.5002C8.75595 18.5002 9.18398 18.3275 9.52941 17.9821L17.4593 10.0522C17.6245 9.88698 17.7558 9.69173 17.8531 9.46645C17.951 9.24117 18 9.00087 18 8.74555V2.3025C18 1.80688 17.8234 1.38245 17.4701 1.02921C17.1175 0.676564 16.6934 0.500244 16.1977 0.500244H9.75469C9.49937 0.500244 9.25907 0.548905 9.03379 0.646227C8.80851 0.744149 8.61327 0.875713 8.44806 1.04092L0.518148 8.99336C0.172716 9.33879 0 9.76292 0 10.2658C0 10.7692 0.172716 11.1936 0.518148 11.539L6.9612 17.9821ZM13.9449 5.907C13.5695 5.907 13.2505 5.77544 12.9879 5.51231C12.7248 5.24978 12.5932 4.93078 12.5932 4.55531C12.5932 4.17984 12.7248 3.86085 12.9879 3.59832C13.2505 3.33519 13.5695 3.20362 13.9449 3.20362C14.3204 3.20362 14.6394 3.33519 14.9019 3.59832C15.1651 3.86085 15.2966 4.17984 15.2966 4.55531C15.2966 4.93078 15.1651 5.24978 14.9019 5.51231C14.6394 5.77544 14.3204 5.907 13.9449 5.907Z" fill="#101136"/>
                                    </svg> RENTAL CASH FLOW(Monthly)
                                </h2>
                            </div>
                        </div>

                        <div class="card-body" style="padding: 1.5rem;">
                            <div class="row mb-4">
                                <div class="col-md-8 d-flex" style="align-items: center;">
                                    <span class="text-lg">Gross Scheduled Income (GSI)(Rent, storage, etc.)</span>
                                </div>

                                <div class="col-md-2">
                                    <div class="position-relative">
                                        <i style="top: 38%;left: 20px;" class="position-absolute pi pi-dollar"></i>
                                        <InputText v-model="form.gross_scheduled_income" class="w-full text-right" />
                                    </div>
                                </div>

                                <div class="col-md-2 d-flex justify-content-center align-items-center">
                                    <span class="text-lg text-dark"><i class="pi pi-dollar"></i>{{add_commas(form.gross_scheduled_income)}}</span>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-8 d-flex" style="align-items: center;">
                                    <span class="text-lg">Less: Vacancy & Concessions(% GSI)</span>
                                </div>

                                <div class="col-md-2">
                                    <div class="position-relative">
                                        <span style="top: 25%;right: 15px;" class="position-absolute">%</span>
                                        <InputText v-model="form.vacancy_and_concession_percentage" class="w-full text-right pr-5" />
                                    </div>
                                </div>

                                <div class="col-md-2 d-flex justify-content-center align-items-center">
                                    <span class="text-lg text-dark">
                                        <i class="pi pi-dollar"></i>{{add_commas(vacancy_and_concession_cost)}}
                                    </span>
                                </div>
                            </div>

                            <hr />
                            <div class="row mb-4">
                                <div class="col-md-10">
                                    <strong class="text-lg">Gross Operating Income (GOI)</strong>
                                </div>

                                <div class="col-md-2 d-flex justify-content-center align-items-center">
                                    <strong class="text-lg text-dark">
                                        <i class="pi pi-dollar"></i>{{add_commas(gross_operating_income)}} ({{Number(gross_operating_income_other).toFixed(1)}}%)
                                    </strong>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-12">
                                    <h3>Operating Expenses:</h3>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-8 d-flex" style="align-items: center;">
                                    <span class="text-lg">Leasing Fees (%)(% GOI)</span>
                                </div>

                                <div class="col-md-2">
                                    <div class="position-relative">
                                        <span style="top: 25%;right: 15px;" class="position-absolute">%</span>
                                        <InputText v-model="form.leasing_fees" class="w-full text-right pr-5" />
                                    </div>
                                </div>

                                <div class="col-md-2 d-flex justify-content-center align-items-center">
                                    <span class="text-lg text-dark"><i class="pi pi-dollar"></i>{{add_commas(Math.round(leasing_fees))}}</span>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-8 d-flex" style="align-items: center;">
                                    <span class="text-lg">Property Management Fee (%)(% GOI)</span>
                                </div>

                                <div class="col-md-2">
                                    <div class="position-relative">
                                        <span style="top: 25%;right: 15px;" class="position-absolute">%</span>
                                        <InputText v-model="form.property_management_fees" class="w-full text-right pr-5" />
                                    </div>
                                </div>

                                <div class="col-md-2 d-flex justify-content-center align-items-center">
                                    <span class="text-lg text-dark"><i class="pi pi-dollar"></i>{{add_commas(Math.round(property_management_fees))}}</span>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-8 d-flex" style="align-items: center;">
                                    <span class="text-lg">Maintenance & Repairs (%)(% GOI)</span>
                                </div>

                                <div class="col-md-2">
                                    <div class="position-relative">
                                        <span style="top: 25%;right: 15px;" class="position-absolute">%</span>
                                        <InputText v-model="form.maintenance_repairs" class="w-full text-right pr-5" />
                                    </div>
                                </div>

                                <div class="col-md-2 d-flex justify-content-center align-items-center">
                                    <span class="text-lg text-dark"><i class="pi pi-dollar"></i>{{add_commas(Math.round(maintenance_repairs))}}</span>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-8 d-flex" style="align-items: center;">
                                    <span class="text-lg">Property Tax(Annual)</span>
                                </div>

                                <div class="col-md-2">
                                    <div class="position-relative">
                                        <i style="top: 38%;left: 20px;" class="position-absolute pi pi-dollar"></i>
                                        <InputText v-model="form.property_annual_tax" class="w-full text-right" />
                                    </div>
                                </div>

                                <div class="col-md-2 d-flex justify-content-center align-items-center">
                                    <span class="text-lg text-dark"><i class="pi pi-dollar"></i>{{add_commas(Math.round(property_annual_tax))}}</span>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-8 d-flex" style="align-items: center;">
                                    <span class="text-lg">Property Insurance(Annual)</span>
                                </div>

                                <div class="col-md-2">
                                    <div class="position-relative">
                                        <i style="top: 38%;left: 20px;" class="position-absolute pi pi-dollar"></i>
                                        <InputText v-model="form.property_annual_insurance" class="w-full text-right" />
                                    </div>
                                </div>

                                <div class="col-md-2 d-flex justify-content-center align-items-center">
                                    <span class="text-lg text-dark"><i class="pi pi-dollar"></i>{{add_commas(Math.round(property_annual_insurance))}}</span>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-8 d-flex" style="align-items: center;">
                                    <span class="text-lg">HOA fee(Annual)</span>
                                </div>

                                <div class="col-md-2">
                                    <div class="position-relative">
                                        <i style="top: 38%;left: 20px;" class="position-absolute pi pi-dollar"></i>
                                        <InputText v-model="form.hoa_annual_fees" class="w-full text-right" />
                                    </div>
                                </div>

                                <div class="col-md-2 d-flex justify-content-center align-items-center">
                                    <span class="text-lg text-dark"><i class="pi pi-dollar"></i>{{add_commas(Math.round(hoa_annual_fees))}}</span>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-8 d-flex" style="align-items: center;">
                                    <span class="text-lg">Water & Sewer(Annual)</span>
                                </div>

                                <div class="col-md-2">
                                    <div class="position-relative">
                                        <i style="top: 38%;left: 20px;" class="position-absolute pi pi-dollar"></i>
                                        <InputText v-model="form.water_and_sewer_annual_fees" class="w-full text-right" />
                                    </div>
                                </div>

                                <div class="col-md-2 d-flex justify-content-center align-items-center">
                                    <span class="text-lg text-dark"><i class="pi pi-dollar"></i>{{add_commas(Math.round(remove_commas(form.water_and_sewer_annual_fees)))}}</span>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-8 d-flex" style="align-items: center;">
                                    <span class="text-lg">Gas(Annual)</span>
                                </div>

                                <div class="col-md-2">
                                    <div class="position-relative">
                                        <i style="top: 38%;left: 20px;" class="position-absolute pi pi-dollar"></i>
                                        <InputText v-model="form.gas_annual_fees" class="w-full text-right" />
                                    </div>
                                </div>

                                <div class="col-md-2 d-flex justify-content-center align-items-center">
                                    <span class="text-lg text-dark"><i class="pi pi-dollar"></i>{{add_commas(Math.round(remove_commas(form.gas_annual_fees)))}}</span>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-8 d-flex" style="align-items: center;">
                                    <span class="text-lg">Electric(Annual)</span>
                                </div>

                                <div class="col-md-2">
                                    <div class="position-relative">
                                        <i style="top: 38%;left: 20px;" class="position-absolute pi pi-dollar"></i>
                                        <InputText v-model="form.electric_annual_fees" class="w-full text-right" />
                                    </div>
                                </div>

                                <div class="col-md-2 d-flex justify-content-center align-items-center">
                                    <span class="text-lg text-dark"><i class="pi pi-dollar"></i>{{add_commas(Math.round(remove_commas(form.electric_annual_fees)))}}</span>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-8 d-flex" style="align-items: center;">
                                    <span class="text-lg">Trash(Annual)</span>
                                </div>

                                <div class="col-md-2">
                                    <div class="position-relative">
                                        <i style="top: 38%;left: 20px;" class="position-absolute pi pi-dollar"></i>
                                        <InputText v-model="form.trash_annual_fees" class="w-full text-right" />
                                    </div>
                                </div>

                                <div class="col-md-2 d-flex justify-content-center align-items-center">
                                    <span class="text-lg text-dark"><i class="pi pi-dollar"></i>{{add_commas(Math.round(remove_commas(form.trash_annual_fees)))}}</span>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-8 d-flex" style="align-items: center;">
                                    <span class="text-lg">Other(Annual)</span>
                                </div>

                                <div class="col-md-2">
                                    <div class="position-relative">
                                        <i style="top: 38%;left: 20px;" class="position-absolute pi pi-dollar"></i>
                                        <InputText v-model="form.other_annual_fees" class="w-full text-right" />
                                    </div>
                                </div>

                                <div class="col-md-2 d-flex justify-content-center align-items-center">
                                    <span class="text-lg text-dark"><i class="pi pi-dollar"></i>{{add_commas(Math.round(remove_commas(form.other_annual_fees)))}}</span>
                                </div>
                            </div>

                            <hr />
                            <div class="row mb-4">
                                <div class="col-md-10">
                                    <strong class="text-lg">Total Operating Expenses</strong>
                                </div>

                                <div class="col-md-2 d-flex justify-content-center align-items-center">
                                    <strong class="text-lg text-dark">
                                        <i class="pi pi-dollar"></i>{{add_commas(Math.round(total_operating_expenses))}} ({{Math.round(total_operating_expenses_other)}}%)
                                    </strong>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-10">
                                    <strong class="text-lg">Net Operating Income (NOI)</strong>
                                </div>

                                <div class="col-md-2 d-flex justify-content-center align-items-center">
                                    <strong class="text-lg text-dark"><i class="pi pi-dollar"></i>{{add_commas(Math.round(net_operating_income))}}</strong>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-10">
                                    <span class="text-md pl-2">Debit Payment Service</span>
                                </div>

                                <div class="col-md-2 d-flex justify-content-center align-items-center">
                                    <strong class="text-lg text-dark">- <i class="pi pi-dollar"></i>{{add_commas(Math.round(debit_service_payment))}}</strong>
                                </div>
                            </div>

                            <hr />
                            <div class="row mb-4">
                                <div class="col-md-10">
                                    <strong class="text-lg">NET CASH FLOW (MONTHLY)</strong>
                                </div>

                                <div class="col-md-2 d-flex justify-content-center align-items-center">
                                    <strong class="text-lg text-dark"><i class="pi pi-dollar"></i>{{add_commas(Math.round(net_cash_flow_monthly))}}</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="col-md-12">
                    <div class="card overflow-hidden p-0">
                        <div class="card-header pt-3 pb-1 pl-3" style="background: rgba(219,15,25,0.1)!important;">
                            <div class="card-title">
                                <div class="row">
                                    <div class="col-md-10">
                                        <h2 class="text-2xl mb-0 d-flex text-center text-danger align-items-center gap-2">
                                            <svg width="17" height="17" viewBox="0 0 17 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M8.5 17C3.80534 17 0 13.1947 0 8.5C0 3.80534 3.80534 0 8.5 0C13.1947 0 17 3.80534 17 8.5C17 13.1947 13.1947 17 8.5 17ZM11.9531 10.1756C11.9531 8.83522 11.1159 8.07819 9.15716 7.60644V5.24769C9.76278 5.372 10.3424 5.63284 10.9092 6.04244L11.6312 4.87581C10.9201 4.35494 10.0848 4.02962 9.20869 3.93231V3.1875H8.08775V3.90734C6.477 4.03166 5.38209 4.95019 5.38209 6.29053C5.38209 7.69303 6.25813 8.37569 8.13928 8.84744V11.2806C7.3015 11.1562 6.60609 10.7838 5.87138 10.2128L5.04688 11.3422C5.92943 12.0216 6.98099 12.4467 8.08775 12.5715V13.8125H9.20869V12.5837C10.8449 12.4472 11.9531 11.5409 11.9531 10.1756ZM8.13875 7.34559C7.14691 7.06031 6.90253 6.72509 6.90253 6.20341C6.90253 5.65781 7.32753 5.22325 8.13928 5.16109L8.13875 7.34559ZM10.4327 10.2622C10.4327 10.8582 9.96891 11.2678 9.15716 11.33V9.08331C10.1623 9.36912 10.4327 9.70381 10.4327 10.2627V10.2622Z" fill="#DB0F19"/>
                                            </svg> RESULTS
                                        </h2>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-body" style="padding: 1.5rem;">
                            <div class="row mb-4">
                                <div class="col-md-10">
                                    <strong class="text-lg text-success">REFINANCE LOAN AMOUNT ({{form.refinance_loan_to_value}}% LTV)</strong>
                                </div>

                                <div class="col-md-2 text-center">
                                    <strong class="text-lg text-success"><i class="pi pi-dollar"></i>{{add_commas(refinance_loan_to_value)}}</strong>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-10">
                                    <strong class="text-lg text-danger">TOTAL PURCHASE, RENO, HOLDING & CLOSING COSTS</strong>
                                </div>

                                <div class="col-md-2 text-center">
                                    <strong class="text-lg text-danger"><i class="pi pi-dollar"></i>{{add_commas(Math.round(total_purchase_reno_holding_closing_cost))}}</strong>
                                </div>
                            </div>

                            <hr />
                            <div class="row mb-7">
                                <div class="col-md-10">
                                    <strong class="text-lg text-primary">CASH OUT (OR IN) DEAL</strong>
                                </div>

                                <div class="col-md-2 text-center">
                                    <strong class="text-lg text-primary"><i class="pi pi-dollar"></i>{{add_commas(Math.round(cash_out_or_in_deal))}}</strong>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-10">
                                    <span class="text-lg text-dark">CASH OUT FOR REFI</span>
                                </div>

                                <div class="col-md-2 text-center">
                                    <span class="text-lg text-dark"><i class="pi pi-dollar"></i>{{add_commas(Math.round(cash_out_for_refi))}}</span>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-10">
                                    <span class="text-lg text-dark">CASH REQUIRED TO PURCHASE, RENOVATE & HOLD</span>
                                </div>

                                <div class="col-md-2 text-center">
                                    <span class="text-lg text-dark"><i class="pi pi-dollar"></i>{{add_commas(Math.round(cash_required_to_purchase_renovate))}}</span>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-10">
                                    <strong class="text-lg text-dark">NET CASH BALANCE AFTER REFI  (NEGATIVE = MONEY LEFT IN THE DEAL)</strong>
                                </div>

                                <div class="col-md-2 text-center">
                                    <strong class="text-lg text-dark"><i class="pi pi-dollar"></i>{{add_commas(Math.round(net_cash_after_refi))}}</strong>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-10">
                                    <span class="text-lg text-dark">CASH ON CASH RETURN ON INVESTMENT (COC ROI)</span>
                                </div>

                                <div class="col-md-2 text-center">
                                    <span class="text-lg text-dark">{{add_commas(occ_roi, 1)}}%</span>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-10">
                                    <span class="text-lg text-dark">CAPITALIZATION RATE (CAP RATE)</span>
                                </div>

                                <div class="col-md-2 text-center">
                                    <span class="text-lg text-dark">{{add_commas(cap_rate, 1)}}%</span>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-10">
                                    <span class="text-lg text-dark">INCREASE IN PROPERTY VALUE (FROM RENO)</span>
                                </div>

                                <div class="col-md-2 text-center">
                                    <span class="text-lg text-dark"><i class="pi pi-dollar"></i>{{add_commas(increase_in_property_value_from_reno)}}</span>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-10">
                                    <span class="text-lg text-dark">REHAB TO VALUE-ADD MULTIPLIER</span>
                                </div>

                                <div class="col-md-2 text-center">
                                    <span class="text-lg text-dark">{{add_commas(rehab_to_value_add, 2)}}</span>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
</template>

<style>
.p-button-secondary {
    color: #6c757d!important;
}

.card {
    box-shadow: none!important;
    border-color: #EBEBEB!important;
}
.card-body {
    padding: 0;
    overflow: hidden;
}
.card-header {
    background: #FAFAFA!important;
    border-color: #EBEBEB;
}
.text-dark { color: #101136!important; }
.p-inputtext {
    border-color: rgba(145,158,171,0.32)!important;
}
.u_hdr_btn {
    font-size: 13px;
    font-weight: 500;
    font-family: "Nunito";
    letter-spacing: 2px;
}

p.u_fb_like::before {
    transform: rotate(45deg);
    content: "";
    border-radius: 1px;
    box-sizing: border-box;
    position: absolute;
    width: 10px;
    height: 10px;
    top: 13px;
    left: -6px;
    background: #FFFFFF;
    border: 1px solid #E6EAED;
    z-index: -1;
    border-right: 0;
    border-top: 0;
}

p.u_fb_like {
    width: fit-content;
    position: relative;
    z-index: 999999999999;
    font-size: 14px;
    border-color: #E6EAED;
}

.u_frm_hdng {
    font-size: 24px;
}
</style>


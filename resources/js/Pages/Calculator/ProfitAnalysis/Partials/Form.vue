<script>
export default {
    props: ['form','count'],
    data() {
        return {
            sharing_count: this.count
        }
    },
    methods: {
        async saveCount() {
            await axios.post(route('contracts.add.share.count'), {type: 'calculator_profit_analysis'});
            this.sharing_count += 1;
        },
        add_commas(value) { return window.add_commas(value)},
        remove_commas(value) { return window.remove_commas(value)},
    },
    computed: {
        closing_cost_percentage() { return Number(remove_commas(this.form.closing_cost))/100 },

        fund_interest_percentage() { return Number(remove_commas(this.form.gap_funding_interest_rate_and_payments)) / 100 },

        purchase_price_financed_percentage() { return Number(remove_commas(this.form.purchase_price_financed)) / 100 },

        down_payment_interest_rate_percentage() { return Number(remove_commas(this.form.down_payment_interest_rate)) / 100 },

        points_percentage() { return Number(remove_commas(this.form.down_payment_points)) / 100 },

        selling_cost_listing_agent_commission_percentage() { return Number(remove_commas(this.form.selling_cost_listing_agent_commission)) / 100 },

        selling_cost_buyers_agent_commission_percentage() { return Number(remove_commas(this.form.selling_cost_buyers_agent_commission)) / 100 },

        renovation_financed_percentage() { return Number(remove_commas(this.form.renovation_financed)) / 100 },

        _contingency_percentage() { return remove_commas(this.form.contingency_percentage) / 100},

        buying_cost_total() { return this.closing_cost_percentage * remove_commas(this.form.purchase_price) },

        total_acquisition_cost() { return this.buying_cost_total + +remove_commas(this.form.delinquent_taxes) + +remove_commas(this.form.reinstatement) + +remove_commas(this.form.purchase_price) },

        contingency_total() {

            return (Number(remove_commas(this.form.interior_repairs)) + Number(remove_commas(this.form.exterior_repairs)) + Number(remove_commas(this.form.landscaping)) + Number(remove_commas(this.form.miscellaneous))) * Number(remove_commas(this.form.contingency_percentage));
        },

        total_renovation_cost() {

            return Number(this.contingency_total) + Number(remove_commas(this.form.interior_repairs)) + Number(remove_commas(this.form.exterior_repairs)) +
                Number(remove_commas(this.form.landscaping)) + Number(remove_commas(this.form.miscellaneous))
        },

        purchase_plus_rehab() { return Number(this.total_renovation_cost) + Number(this.total_acquisition_cost) },

        purchase_price_financed_total() { return Number(remove_commas(this.form.purchase_price)) * Number(this.purchase_price_financed_percentage) },

        renovation_financed_total() { return Number(this.total_renovation_cost) * Number(this.renovation_financed_percentage) },

        total_load_amount() { return Number(this.renovation_financed_total) + Number(this.purchase_price_financed_total) },

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

            return Number(Number(this.total_closing_cost) / Number(this.total_load_amount) * 100).toFixed(1);
        },
        cash_due_at_closing() { return Number(this.total_closing_cost) +  Number(this.down_payment)},
        listing_agent_commission() { return Number(this.selling_cost_listing_agent_commission_percentage) * Number(remove_commas(this.form.arv)); },
        buyer_agent_commission() { return Number(this.selling_cost_buyers_agent_commission_percentage) * Number(remove_commas(this.form.arv)); },
        total_selling_cost() {

            return Number(this.buyer_agent_commission) + Number(this.listing_agent_commission) + Number(remove_commas(this.form.selling_cost_closing_cost)) +
                Number(remove_commas(this.form.selling_cost_staging)) + Number(remove_commas(this.form.selling_cost_concessions_and_other)) + Number(remove_commas(this.form.selling_cost_seller_credit_to_buyer))
        },

        increase_in_property_value() { return Number(remove_commas(this.form.arv))+Number(remove_commas(this.form.purchase_price))},
        cash_out_of_pocket() { return Number(this.cash_due_at_closing) + Number(this.total_holding_cost) + Number(this.total_selling_cost_out_of_pocket)},

        total_draws() { return remove_commas(this.form.holding_costs_number_draws) * remove_commas(this.form.holding_costs_lender_draw_fee) },
        payments_total () { return Number(this.monthly_interest) * Number(remove_commas(this.form.estimated_hold_time)) },
        utilities_total () { return Number(remove_commas(this.form.holding_costs_utilities)) * Number(remove_commas(this.form.estimated_hold_time))},
        insurance_total () { return Number(remove_commas(this.form.holding_costs_insurance)) * Number(remove_commas(this.form.estimated_hold_time))},
        property_tax_total () { return Math.round(Number(remove_commas(this.form.holding_costs_property_taxes)) / 12 * Number(remove_commas(this.form.estimated_hold_time))) },
        total_holding_cost() {

            return Number(this.property_tax_total) + Number(this.insurance_total) + Number(this.utilities_total) + Number(this.payments_total) + Number(this.total_draws);
        },

        out_of_pocket_cash() { return Number(this.total_holding_cost) + Number(this.cash_due_at_closing) },
        total_selling_cost_out_of_pocket() { return Number(remove_commas(this.form.selling_cost_staging)) + Number(remove_commas(this.form.selling_cost_concessions_and_other)) },
        contribution_interest_payment() {

            if(remove_commas(this.form.gap_funding_contribution) <= 0) return 0;

            return Number(this.fund_interest_percentage) * Number(remove_commas(this.form.estimated_hold_time)) * Number(remove_commas(this.form.gap_funding_contribution)) / 12
        },

        gap_funding_profit_share_percentage() { return Number(remove_commas(this.form.gap_funding_profit_share))/ 100},
        contribution_profit_share() {

            if(remove_commas(this.form.gap_funding_contribution) <= 0) return 0;

            //return Number(this.fund_interest_percentage) * Number(remove_commas(this.form.estimated_hold_time)) * Number(remove_commas(this.form.gap_funding_contribution)) / 12
            return Number(remove_commas(this.gap_funding_profit_share_percentage)) * Number(remove_commas(this.total_estimated_profit))
        },
        total_due_to_funder() { return Number(this.contribution_profit_share) + Number(this.contribution_interest_payment) + Number(remove_commas(this.form.gap_funding_contribution)) },
        your_share_of_the_profit() { return Number(this.total_estimated_profit) + Number(this.total_due_to_funder) },
        profit_per_month_held() { return Number(this.your_share_of_the_profit) + Number(remove_commas(this.form.estimated_hold_time)) },
        deal_profit_margin() {

            if(remove_commas(this.form.arv) == "0") return remove_commas(this.form.arv);

            return Number(remove_commas(this.total_estimated_profit)) / Number(remove_commas(this.form.arv)) * 100
        },

        funder_total_profit() { return Number(remove_commas(this.contribution_profit_share)) + Number(remove_commas(this.contribution_interest_payment)) },
        funder_effective_roi() {

            if(remove_commas(this.form.gap_funding_contribution) == "0") return remove_commas(this.form.gap_funding_contribution);
            try {
                return Number(this.funder_total_profit / remove_commas(this.form.gap_funding_contribution) * 100).toFixed(1);
            } catch({}) {return 0}
        },
        total_purchase_and_other() {

            return Number(remove_commas(this.total_acquisition_cost)) + Number(remove_commas(this.total_renovation_cost))
                + Number(remove_commas(this.total_closing_cost)) + Number(remove_commas(this.total_holding_cost))
                + Number(remove_commas(this.total_selling_cost))
        },
        total_estimated_profit() { return Number(remove_commas(this.form.arv)) - Number(remove_commas(this.total_purchase_and_other)) }
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
                            Fix & Flip Profit Analysis Calculator
                        </div>
                    </div>
                    <div class="col">
                        <div class="d-flex justify-content-end">
                            <ShareNetwork
                                @close="saveCount"
                                network="facebook"
                                url="http://dealhunter.ai/calculator/profit-analysis"
                                title="Fix & Flip Profit Analysis Calculator"
                                description="Try Out Our Fix & Flip Profit Analysis Calculator"
                                quote="Try Out Our Fix & Flip Profit Analysis Calculator"
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

            <div class="row mt-4">

                <div class="col-md-12">
                    <div class="card overflow-hidden shadow-none" style="border-color: #EBEBEB;">
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
                                    <strong class="text-lg text-dark"><i class="pi pi-dollar"></i>{{add_commas(form.arv)}}</strong>
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
                                    <strong class="text-lg text-dark">{{add_commas(form.estimated_hold_time)}}</strong>
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
                                    <strong class="text-lg text-dark">Purchase Price</strong>
                                </div>

                                <div class="col-md-2">
                                    <div class="position-relative">
                                        <i style="top: 38%;left: 20px;" class="position-absolute pi pi-dollar"></i>
                                        <InputText v-model="form.purchase_price" class="w-full text-right" />
                                    </div>
                                </div>

                                <div class="col-md-2 d-flex justify-content-center align-items-center">
                                    <strong class="text-lg text-dark"><i class="pi pi-dollar"></i>{{add_commas(form.purchase_price)}}</strong>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-8 d-flex" style="align-items: center;">
                                    <strong class="text-lg text-dark">Reinstatement</strong>
                                </div>

                                <div class="col-md-2">
                                    <div class="position-relative">
                                        <i style="top: 38%;left: 20px;" class="position-absolute pi pi-dollar"></i>
                                        <InputText v-model="form.reinstatement" class="w-full text-right" />
                                    </div>
                                </div>

                                <div class="col-md-2 d-flex justify-content-center align-items-center">
                                    <strong class="text-lg text-dark"><i class="pi pi-dollar"></i>{{add_commas(form.reinstatement)}}</strong>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-8 d-flex" style="align-items: center;">
                                    <strong class="text-lg text-dark">Payoff Delinquent Taxes and other Leins</strong>
                                </div>

                                <div class="col-md-2">
                                    <div class="position-relative">
                                        <i style="top: 38%;left: 20px;" class="position-absolute pi pi-dollar"></i>
                                        <InputText v-model="form.delinquent_taxes" class="w-full text-right" />
                                    </div>
                                </div>

                                <div class="col-md-2 d-flex justify-content-center align-items-center">
                                    <strong class="text-lg text-dark"><i class="pi pi-dollar"></i>{{add_commas(form.delinquent_taxes)}}</strong>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-8 d-flex" style="align-items: center;">
                                    <strong class="text-lg text-dark">Closing Costs / Title Insurance (If buying cash)</strong>
                                </div>

                                <div class="col-md-2">
                                    <div class="position-relative">
                                        <i style="top: 25%;right: 18px;" class="position-absolute">%</i>
                                        <InputText max="100" min="0" v-model="form.closing_cost" class="w-full text-right pr-5" />
                                    </div>
                                </div>

                                <div class="col-md-2 d-flex justify-content-center align-items-center">
                                    <strong class="text-lg text-dark"><i class="pi pi-dollar"></i>{{add_commas(buying_cost_total)}}</strong>
                                </div>
                            </div>

                            <div class="card-footer pl-0" style="background: none;">
                                <div class="row">
                                    <div class="col-md-10">
                                        <strong class="text-lg text-dark">TOTAL ACQUISITION COST</strong>
                                    </div>

                                    <div class="col-md-2 d-flex justify-content-center align-items-center pr-0 pl-5">
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
                                        <strong class="text-lg text-dark">Interior Repairs</strong>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="position-relative">
                                            <i style="top: 38%;left: 20px;" class="position-absolute pi pi-dollar"></i>
                                            <InputText v-model="form.interior_repairs" class="w-full text-right" />
                                        </div>
                                    </div>

                                    <div class="col-md-2 d-flex justify-content-center align-items-center">
                                        <strong class="text-lg text-dark"><i class="pi pi-dollar"></i>{{add_commas(form.interior_repairs)}}</strong>
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-md-8 d-flex" style="align-items: center;">
                                        <strong class="text-lg text-dark">Exterior Repairs</strong>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="position-relative">
                                            <i style="top: 38%;left: 20px;" class="position-absolute pi pi-dollar"></i>
                                            <InputText v-model="form.exterior_repairs" class="w-full text-right" />
                                        </div>
                                    </div>

                                    <div class="col-md-2 d-flex justify-content-center align-items-center">
                                        <strong class="text-lg text-dark"><i class="pi pi-dollar"></i>{{add_commas(form.exterior_repairs)}}</strong>
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-md-8 d-flex" style="align-items: center;">
                                        <strong class="text-lg text-dark">Landscaping</strong>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="position-relative">
                                            <i style="top: 38%;left: 20px;" class="position-absolute pi pi-dollar"></i>
                                            <InputText v-model="form.landscaping" class="w-full text-right" />
                                        </div>
                                    </div>

                                    <div class="col-md-2 d-flex justify-content-center align-items-center">
                                        <strong class="text-lg text-dark"><i class="pi pi-dollar"></i>{{add_commas(form.landscaping)}}</strong>
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-md-8 d-flex" style="align-items: center;">
                                        <strong class="text-lg text-dark">Miscellaneous</strong>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="position-relative">
                                            <i style="top: 38%;left: 20px;" class="position-absolute pi pi-dollar"></i>
                                            <InputText v-model="form.miscellaneous" class="w-full text-right" />
                                        </div>
                                    </div>

                                    <div class="col-md-2 d-flex justify-content-center align-items-center">
                                        <strong class="text-lg text-dark"><i class="pi pi-dollar"></i>{{add_commas(form.miscellaneous)}}</strong>
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-md-8 d-flex" style="align-items: center;">
                                        <strong class="text-lg text-dark">Contingency %</strong>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="position-relative">
                                            <i style="top: 38%;left: 20px;" class="position-absolute pi pi-dollar"></i>
                                            <InputText v-model="form.contingency_percentage" min="0" max="100" class="w-full text-right" />
                                        </div>
                                    </div>

                                    <div class="col-md-2 d-flex justify-content-center align-items-center">
                                        <strong class="text-lg text-dark"><i class="pi pi-dollar"></i>{{add_commas(contingency_total)}}</strong>
                                    </div>
                                </div>
                            </section>

                            <div class="card-footer" style="background: none;padding: 1.5rem;">
                                <div class="row">
                                    <div class="col-md-10">
                                        <strong class="text-lg text-dark">TOTAL RENOVATION COST</strong>
                                    </div>

                                    <div class="col-md-2 d-flex justify-content-center align-items-center">
                                        <strong><i class="pi pi-dollar"></i>{{add_commas(total_renovation_cost)}}</strong>
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
                                    <strong class="text-danger"><i class="pi pi-dollar"></i>{{add_commas(purchase_plus_rehab)}}</strong>
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
                                    <strong class="text-lg text-dark">Amount of Purchase Price Financed (%)</strong>
                                </div>

                                <div class="col-md-2">
                                    <div class="position-relative">
                                        <span style="top: 25%;right: 15px;" class="position-absolute">%</span>
                                        <InputText min="0" max="100" v-model="form.purchase_price_financed" class="w-full text-right pr-5" />
                                    </div>
                                </div>

                                <div class="col-md-2 d-flex justify-content-center align-items-center">
                                    <strong class="text-lg text-dark"><i class="pi pi-dollar"></i>{{add_commas(purchase_price_financed_total)}}</strong>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-8 d-flex" style="align-items: center;">
                                    <strong class="text-lg text-dark">Amount of Renovation Financed (%)</strong>
                                </div>

                                <div class="col-md-2">
                                    <div class="position-relative">
                                        <span style="top: 25%;right: 15px;" class="position-absolute">%</span>
                                        <InputText min="0" max="100" v-model="form.renovation_financed" class="w-full text-right pr-5" />
                                    </div>
                                </div>

                                <div class="col-md-2 d-flex justify-content-center align-items-center">
                                    <strong class="text-lg text-dark"><i class="pi pi-dollar"></i>{{add_commas(renovation_financed_total)}}</strong>
                                </div>
                            </div>

                            <hr />
                            <div class="row mb-2">
                                <div class="col-md-10">
                                    <h3>TOTAL LOAN AMOUNT</h3>
                                </div>

                                <div class="col-md-2 text-center">
                                    <strong class="text-lg text-dark"><i class="pi pi-dollar"></i> {{add_commas(total_load_amount)}}</strong>
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
                                    <strong class="text-lg text-dark">Interest Rate & Interest-Only Payment (Monthly)</strong>
                                </div>

                                <div class="col-md-2">
                                    <div class="position-relative">
                                        <span style="top: 25%;right: 15px;" class="position-absolute">%</span>
                                        <InputText v-model="form.down_payment_interest_rate" class="w-full text-right pr-5" />
                                    </div>
                                </div>

                                <div class="col-md-2 d-flex justify-content-center align-items-center">
                                    <strong class="text-lg text-dark"><i class="pi pi-dollar"></i>{{add_commas(Math.round(monthly_interest))}}</strong>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <h3>Closing Costs:</h3>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-8 d-flex" style="align-items: center;">
                                    <strong class="text-lg text-dark">Points</strong>
                                </div>

                                <div class="col-md-2">
                                    <div class="position-relative">
                                        <span style="top: 25%;right: 15px;" class="position-absolute">%</span>
                                        <InputText v-model="form.down_payment_points" class="w-full text-right pr-5" />
                                    </div>
                                </div>

                                <div class="col-md-2 d-flex justify-content-center align-items-center">
                                    <strong class="text-lg text-dark"><i class="pi pi-dollar"></i>{{add_commas(points_total)}}</strong>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-8 d-flex" style="align-items: center;">
                                    <strong class="text-lg text-dark">Lender Underwriting Fee</strong>
                                </div>

                                <div class="col-md-2">
                                    <div class="position-relative">
                                        <i style="top: 38%;left: 20px;" class="position-absolute pi pi-dollar"></i>
                                        <InputText v-model="form.down_payment_lender_underwriting_fee" class="w-full text-right" />
                                    </div>
                                </div>

                                <div class="col-md-2 d-flex justify-content-center align-items-center">
                                    <strong class="text-lg text-dark"><i class="pi pi-dollar"></i>{{add_commas(form.down_payment_lender_underwriting_fee)}}</strong>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-8 d-flex" style="align-items: center;">
                                    <strong class="text-lg text-dark">Appraisal Fee</strong>
                                </div>

                                <div class="col-md-2">
                                    <div class="position-relative">
                                        <i style="top: 38%;left: 20px;" class="position-absolute pi pi-dollar"></i>
                                        <InputText v-model="form.down_payment_appraisal_fee" class="w-full text-right" />
                                    </div>
                                </div>

                                <div class="col-md-2 d-flex justify-content-center align-items-center">
                                    <strong class="text-lg text-dark"><i class="pi pi-dollar"></i>{{add_commas(form.down_payment_appraisal_fee)}}</strong>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-8 d-flex" style="align-items: center;">
                                    <strong class="text-lg text-dark">Title Fees</strong>
                                </div>

                                <div class="col-md-2">
                                    <div class="position-relative">
                                        <i style="top: 38%;left: 20px;" class="position-absolute pi pi-dollar"></i>
                                        <InputText v-model="form.down_payment_title_fees" class="w-full text-right" />
                                    </div>
                                </div>

                                <div class="col-md-2 d-flex justify-content-center align-items-center">
                                    <strong class="text-lg text-dark"><i class="pi pi-dollar"></i>{{add_commas(form.down_payment_title_fees)}}</strong>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-8 d-flex" style="align-items: center;">
                                    <strong class="text-lg text-dark">Tax Prepaid</strong>
                                </div>

                                <div class="col-md-2">
                                    <div class="position-relative">
                                        <i style="top: 38%;left: 20px;" class="position-absolute pi pi-dollar"></i>
                                        <InputText v-model="form.down_payment_tax_prepaid" class="w-full text-right" />
                                    </div>
                                </div>

                                <div class="col-md-2 d-flex justify-content-center align-items-center">
                                    <strong class="text-lg text-dark"><i class="pi pi-dollar"></i>{{add_commas(form.down_payment_tax_prepaid)}}</strong>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-8 d-flex" style="align-items: center;">
                                    <strong class="text-lg text-dark">Insurance Prepaid</strong>
                                </div>

                                <div class="col-md-2">
                                    <div class="position-relative">
                                        <i style="top: 38%;left: 20px;" class="position-absolute pi pi-dollar"></i>
                                        <InputText v-model="form.down_payment_insurance_prepaid" class="w-full text-right" />
                                    </div>
                                </div>

                                <div class="col-md-2 d-flex justify-content-center align-items-center">
                                    <strong class="text-lg text-dark"><i class="pi pi-dollar"></i>{{add_commas(form.down_payment_insurance_prepaid)}}</strong>
                                </div>
                            </div>

                            <div class="card-footer" style="background: none;padding-right:0!important;">
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
                    <div class="card overflow-hidden p-0">
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
                                    <strong class="text-lg text-dark">Loan Payments (<span class="text-danger">6 months</span>)</strong>
                                </div>

                                <div class="col-md-2">
                                    <div class="position-relative">
                                        <i style="top: 38%;left: 20px;" class="position-absolute pi pi-dollar"></i>
                                        <InputText disabled v-bind:value="monthly_interest" class="w-full text-right" />
                                    </div>
                                </div>

                                <div class="col-md-2 d-flex justify-content-center align-items-center">
                                    <strong class="text-lg text-dark"><i class="pi pi-dollar"></i>{{add_commas(Math.round(payments_total))}}</strong>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-8 d-flex" style="align-items: center;">
                                    <strong class="text-lg text-dark">Property Taxes (<span class="text-muted">Annual</span>)</strong>
                                </div>

                                <div class="col-md-2">
                                    <div class="position-relative">
                                        <i style="top: 38%;left: 20px;" class="position-absolute pi pi-dollar"></i>
                                        <InputText v-model="form.holding_costs_property_taxes" class="w-full text-right" />
                                    </div>
                                </div>

                                <div class="col-md-2 d-flex justify-content-center align-items-center">
                                    <strong class="text-lg text-dark"><i class="pi pi-dollar"></i>{{add_commas(property_tax_total)}}</strong>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-8 d-flex" style="align-items: center;">
                                    <strong class="text-lg text-dark">Insurance (<span class="text-muted">Annual</span>)</strong>
                                </div>

                                <div class="col-md-2">
                                    <div class="position-relative">
                                        <i style="top: 38%;left: 20px;" class="position-absolute pi pi-dollar"></i>
                                        <InputText v-model="form.holding_costs_insurance" class="w-full text-right" />
                                    </div>
                                </div>

                                <div class="col-md-2 d-flex justify-content-center align-items-center">
                                    <strong class="text-lg text-dark"><i class="pi pi-dollar"></i>{{add_commas(insurance_total)}}</strong>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-8 d-flex" style="align-items: center;">
                                    <strong class="text-lg text-dark">Utilities (<span class="text-muted">Annual</span>)</strong>
                                </div>

                                <div class="col-md-2">
                                    <div class="position-relative">
                                        <i style="top: 38%;left: 20px;" class="position-absolute pi pi-dollar"></i>
                                        <InputText v-model="form.holding_costs_utilities" class="w-full text-right" />
                                    </div>
                                </div>

                                <div class="col-md-2 d-flex justify-content-center align-items-center">
                                    <strong class="text-lg text-dark"><i class="pi pi-dollar"></i>{{add_commas(utilities_total)}}</strong>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-8 d-flex" style="align-items: center;">
                                    <strong class="text-lg text-dark">Lender Draw Fee (<span class="text-muted">Per draw</span>)</strong>
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
                                    <strong class="text-lg text-dark">Number of Draws : Total Draw Fees</strong>
                                </div>

                                <div class="col-md-2">
                                    <div class="position-relative">
                                        <i style="top: 38%;left: 20px;" class="position-absolute pi pi-dollar"></i>
                                        <InputText v-model="form.holding_costs_number_draws" class="w-full text-right" />
                                    </div>
                                </div>

                                <div class="col-md-2 d-flex justify-content-center align-items-center">
                                    <strong class="text-lg text-dark"><i class="pi pi-dollar"></i>{{add_commas(total_draws)}}</strong>
                                </div>
                            </div>

                            <div class="card-footer pl-0" style="background: none;padding-right: 0;">
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
                                        <path d="M17.9338 13.6625C17.8406 13.3629 17.6537 13.101 17.4005 12.9158C17.1472 12.7307 16.8412 12.6316 16.5275 12.6337C16.3932 12.6317 16.2593 12.651 16.1309 12.6903L14.0356 13.285V13.2848C14.0394 12.927 13.9087 12.5809 13.669 12.315C13.4295 12.0493 13.0987 11.8833 12.7425 11.8502L9.60883 11.6425H9.60867C8.75867 10.9304 7.80349 10.3541 6.77706 9.93408C5.5852 9.67994 4.35019 9.7089 3.17151 10.019H2.83161V8.54668C2.83161 8.42142 2.7819 8.30143 2.69352 8.21287C2.60496 8.12431 2.48497 8.07461 2.35971 8.07461H0V17.5134H2.35971C2.48497 17.5134 2.60496 17.4637 2.69352 17.3753C2.78191 17.2868 2.83161 17.1668 2.83161 17.0415V16.6546H3.14304C3.77544 16.8434 8.25897 18.1741 9.38193 18.3629H9.53303C10.4768 18.3629 13.0349 17.3719 17.1785 15.4275C17.4934 15.2708 17.7422 15.0072 17.8805 14.6838C18.0189 14.3605 18.0377 13.9984 17.9337 13.6625L17.9338 13.6625ZM16.754 14.6063C12.3649 16.6733 9.958 17.5323 9.50502 17.4379C8.3818 17.2585 3.36978 15.7578 3.32259 15.7389H3.18103L2.83158 15.739V11.0196H3.20918C3.25592 11.0287 3.30399 11.0287 3.35073 11.0196C4.38163 10.7363 5.46436 10.6977 6.51287 10.9064C7.4613 11.318 8.34501 11.8648 9.13678 12.5298C9.21183 12.5912 9.30434 12.6276 9.40112 12.6337L12.6764 12.8508V12.8506C12.944 12.8756 13.1418 13.1113 13.1199 13.3793C13.1211 13.4728 13.0948 13.5647 13.0445 13.6435C12.9514 13.7702 12.8052 13.8468 12.648 13.8512H6.98473C6.72614 13.8562 6.51776 14.0646 6.51283 14.3231C6.51283 14.4484 6.56254 14.5684 6.65093 14.6569C6.73948 14.7453 6.85947 14.795 6.98474 14.795H12.648C13.0009 14.7843 13.3372 14.6431 13.592 14.3987H13.6959L16.3953 13.6341C16.6601 13.5822 16.9248 13.7245 17.0277 13.9738C17.0911 14.2076 16.9906 14.4548 16.7823 14.5779L16.754 14.6063ZM10.7321 9.13174L10.7319 9.13191C11.8584 9.13191 12.9389 8.68436 13.7353 7.88788C14.5318 7.09139 14.9794 6.01094 14.9794 4.88443C14.9794 3.75793 14.5318 2.67765 13.7353 1.88099C12.9389 1.08451 11.8584 0.636963 10.7319 0.636963C9.6054 0.636963 8.52511 1.08451 7.72863 1.88099C6.93198 2.67765 6.4846 3.75793 6.4846 4.88443C6.49448 6.01014 6.94993 7.08612 7.75134 7.87688C8.55263 8.66763 9.63451 9.10856 10.7602 9.10363L10.7321 9.13174ZM10.2789 2.84565V2.49653C10.2839 2.23795 10.4922 2.02956 10.7508 2.02463C10.8759 2.02463 10.9961 2.07434 11.0845 2.1629C11.173 2.25129 11.2227 2.37144 11.2227 2.49654V2.80796H11.506C11.6311 2.80796 11.7511 2.85784 11.8397 2.94623C11.9282 3.03478 11.9779 3.15477 11.9779 3.28004C11.9779 3.40513 11.9282 3.52512 11.8397 3.61368C11.7511 3.70224 11.6311 3.75194 11.506 3.75194H10.3828C10.2091 3.75705 10.0712 3.89926 10.0712 4.07291C10.0712 4.24492 10.2106 4.38434 10.3828 4.38434H11.138H11.1378C11.5864 4.36409 12.0115 4.58465 12.2533 4.96289C12.4951 5.3413 12.5167 5.8198 12.3099 6.21829C12.1032 6.61679 11.6996 6.87471 11.2511 6.89498V7.21595C11.2511 7.34121 11.2014 7.4612 11.1128 7.54976C11.0244 7.63815 10.9043 7.68786 10.7792 7.68786C10.5186 7.68786 10.3073 7.47668 10.3073 7.21596V6.90454H9.99568C9.73511 6.90454 9.52378 6.69319 9.52378 6.43264C9.52888 6.17405 9.73726 5.96567 9.99568 5.96057H11.1378C11.3113 5.95547 11.4494 5.81325 11.4492 5.63976C11.4492 5.46776 11.3098 5.32818 11.1378 5.32818H10.3828C9.93424 5.34167 9.51257 5.11485 9.27668 4.73332C9.04081 4.35161 9.02632 3.87312 9.23899 3.47791C9.45149 3.08271 9.85871 2.83102 10.3073 2.81753L10.2789 2.84565Z" fill="#101136"/>
                                    </svg> Selling Cost
                                </h2>
                            </div>
                        </div>

                        <div class="card-body" style="padding: 1.5rem;">
                            <div class="row mb-4">
                                <div class="col-md-8 d-flex" style="align-items: center;">
                                    <strong class="text-lg text-dark">Closing Cost</strong>
                                </div>

                                <div class="col-md-2">
                                    <div class="position-relative">
                                        <i style="top: 38%;left: 20px;" class="position-absolute pi pi-dollar"></i>
                                        <InputText v-model="form.selling_cost_closing_cost" class="w-full text-right" />
                                    </div>
                                </div>

                                <div class="col-md-2 d-flex justify-content-center align-items-center">
                                    <strong class="text-lg text-dark"><i class="pi pi-dollar"></i>{{add_commas(form.selling_cost_closing_cost)}}</strong>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-8 d-flex" style="align-items: center;">
                                    <strong class="text-lg text-dark">Staging/Marketing/Photos/etc. **</strong>
                                </div>

                                <div class="col-md-2">
                                    <div class="position-relative">
                                        <i style="top: 38%;left: 20px;" class="position-absolute pi pi-dollar"></i>
                                        <InputText v-model="form.selling_cost_staging" class="w-full text-right" />
                                    </div>
                                </div>

                                <div class="col-md-2 d-flex justify-content-center align-items-center">
                                    <strong class="text-lg text-dark"><i class="pi pi-dollar"></i>{{add_commas(form.selling_cost_staging)}}</strong>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-8 d-flex" style="align-items: center;">
                                    <strong class="text-lg text-dark">Concessions, added repairs, etc. **</strong>
                                </div>

                                <div class="col-md-2">
                                    <div class="position-relative">
                                        <i style="top: 38%;left: 20px;" class="position-absolute pi pi-dollar"></i>
                                        <InputText v-model="form.selling_cost_concessions_and_other" class="w-full text-right" />
                                    </div>
                                </div>

                                <div class="col-md-2 d-flex justify-content-center align-items-center">
                                    <strong class="text-lg text-dark"><i class="pi pi-dollar"></i>{{add_commas(form.selling_cost_concessions_and_other)}}</strong>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-8 d-flex" style="align-items: center;">
                                    <strong class="text-lg text-dark">Seller Credit To Buyer</strong>
                                </div>

                                <div class="col-md-2">
                                    <div class="position-relative">
                                        <i style="top: 38%;left: 20px;" class="position-absolute pi pi-dollar"></i>
                                        <InputText v-model="form.selling_cost_seller_credit_to_buyer" class="w-full text-right" />
                                    </div>
                                </div>

                                <div class="col-md-2 d-flex justify-content-center align-items-center">
                                    <strong class="text-lg text-dark"><i class="pi pi-dollar"></i>{{add_commas(form.selling_cost_seller_credit_to_buyer)}}</strong>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-8 d-flex" style="align-items: center;">
                                    <strong class="text-lg text-dark">Sales Commission - Listing Agent</strong>
                                </div>

                                <div class="col-md-2">
                                    <div class="position-relative">
                                        <span style="top: 25%;right: 15px;" class="position-absolute">%</span>
                                        <InputText min="0" max="100" step="0.1" v-model="form.selling_cost_listing_agent_commission" class="w-full text-right pr-5" />
                                    </div>
                                </div>

                                <div class="col-md-2 d-flex justify-content-center align-items-center">
                                    <strong class="text-lg text-dark"><i class="pi pi-dollar"></i>{{add_commas(listing_agent_commission)}}</strong>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-8 d-flex" style="align-items: center;">
                                    <strong class="text-lg text-dark">Sales Commission - Buyers Agent</strong>
                                </div>

                                <div class="col-md-2">
                                    <div class="position-relative">
                                        <span style="top: 25%;right: 15px;" class="position-absolute">%</span>
                                        <InputText v-model="form.selling_cost_buyers_agent_commission" class="w-full text-right pr-5" />
                                    </div>
                                </div>

                                <div class="col-md-2 d-flex justify-content-center align-items-center">
                                    <strong class="text-lg text-dark"><i class="pi pi-dollar"></i>{{add_commas(buyer_agent_commission)}}</strong>
                                </div>
                            </div>

                            <div class="card-footer pl-0" style="background: none;padding-right: 0;">
                                <div class="row">
                                    <div class="col-md-10">
                                        <strong class="text-lg text-dark">TOTAL SELLING COSTS</strong>
                                    </div>

                                    <div class="col-md-2 d-flex justify-content-center align-items-center">
                                        <strong class="text-lg text-dark"><i class="pi pi-dollar"></i>{{add_commas(total_selling_cost)}}</strong>
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
                                        <strong class="text-lg text-dark">Cash Due at Closing</strong>
                                    </div>

                                    <div class="col-md-2 d-flex justify-content-center align-items-center">
                                        <strong class="text-lg text-dark"><i class="pi pi-dollar"></i>{{add_commas(cash_due_at_closing)}}</strong>
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-md-10">
                                        <strong class="text-lg text-dark">Total Holding Cost</strong>
                                    </div>

                                    <div class="col-md-2 d-flex justify-content-center align-items-center">
                                        <strong class="text-lg text-dark"><i class="pi pi-dollar"></i>{{add_commas(Math.round(total_holding_cost))}}</strong>
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-md-10">
                                        <strong class="text-lg text-dark">Total Selling Cost (**Out-of-Pocket Costs Only)</strong>
                                    </div>

                                    <div class="col-md-2 d-flex justify-content-center align-items-center">
                                        <strong class="text-lg text-dark"><i class="pi pi-dollar"></i> {{add_commas(total_selling_cost_out_of_pocket)}}</strong>
                                    </div>
                                </div>

                                <hr />
                                <div class="row mb-4">
                                    <div class="col-md-10">
                                        <strong class="text-lg text-dark">TOTAL OUT-OF-POCKET CASH REQUIRED</strong>
                                    </div>

                                    <div class="col-md-2 d-flex justify-content-center align-items-center">
                                        <strong class="text-lg text-dark"><i class="pi pi-dollar"></i> {{add_commas(Math.round(out_of_pocket_cash))}}</strong>
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-md-8">
                                        <strong class="text-lg text-dark">GAP Funder Contribution</strong>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="position-relative">
                                            <i style="top: 38%;left: 20px;" class="position-absolute pi pi-dollar"></i>
                                            <InputText v-model="form.gap_funding_contribution" class="w-full text-right" />
                                        </div>
                                    </div>

                                    <div class="col-md-2 d-flex justify-content-center align-items-center">
                                        <strong class="text-lg text-dark"><i class="pi pi-dollar"></i> {{add_commas(form.gap_funding_contribution)}}</strong>
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-md-8">
                                        <strong class="text-lg text-dark">GAP Funder Interest Rate & Payments (6 months)</strong>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="position-relative">
                                            <span style="top: 25%;right: 15px;" class="position-absolute">%</span>
                                            <InputText v-model="form.gap_funding_interest_rate_and_payments" class="w-full text-right pr-5" />
                                        </div>
                                    </div>

                                    <div class="col-md-2 d-flex justify-content-center align-items-center">
                                        <strong class="text-lg text-dark"><i class="pi pi-dollar"></i> {{add_commas(contribution_interest_payment)}}</strong>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-8">
                                        <strong class="text-lg text-dark">Gap Funder Profit Share %</strong>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="position-relative">
                                            <span style="top: 25%;right: 15px;" class="position-absolute">%</span>
                                            <InputText v-model="form.gap_funding_profit_share" class="w-full text-right pr-5" />
                                        </div>
                                    </div>

                                    <div class="col-md-2 d-flex justify-content-center align-items-center">
                                        <strong class="text-lg text-dark"><i class="pi pi-dollar"></i> {{add_commas(contribution_profit_share)}}</strong>
                                    </div>
                                </div>

                                <hr />
                                <div class="row">
                                    <div class="col-md-10">
                                        <h3>TOTAL DUE TO GAP FUNDER AT EXIT</h3>
                                    </div>

                                    <div class="col-md-2 d-flex justify-content-center align-items-center">
                                        <strong class="text-lg text-dark"><i class="pi pi-dollar"></i> {{add_commas(total_due_to_funder)}}</strong>
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-md-10">
                                        <strong class="text-lg text-dark">Gap Funder's Total Profit</strong>
                                    </div>

                                    <div class="col-md-2 d-flex justify-content-center align-items-center">
                                        <strong class="text-lg text-dark"><i class="pi pi-dollar"></i> {{add_commas(funder_total_profit)}}</strong>
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-md-10">
                                        <strong class="text-lg text-dark">Gap Funder's Effective ROI</strong>
                                    </div>

                                    <div class="col-md-2 d-flex justify-content-center align-items-center pr-0">
                                        <strong class="text-lg text-dark">{{add_commas(funder_effective_roi)}}%</strong>
                                    </div>
                                </div>
                            </section>

                            <section class="p-2 pl-3 mt-0 mb-5" style="background: rgba(219,15,25,0.1);padding-right: 1.5rem!important;">
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
                        <div class="card-header pt-3 pb-1 pl-3" style="background: rgba(219,15,25,0.1)!important;">
                            <div class="card-title">
                                <div class="row">
                                    <div class="col-md-10">
                                        <h2 class="text-2xl mb-0 d-flex text-center text-danger align-items-center gap-2">
                                            <svg width="17" height="17" viewBox="0 0 17 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M8.5 17C3.80534 17 0 13.1947 0 8.5C0 3.80534 3.80534 0 8.5 0C13.1947 0 17 3.80534 17 8.5C17 13.1947 13.1947 17 8.5 17ZM11.9531 10.1756C11.9531 8.83522 11.1159 8.07819 9.15716 7.60644V5.24769C9.76278 5.372 10.3424 5.63284 10.9092 6.04244L11.6312 4.87581C10.9201 4.35494 10.0848 4.02962 9.20869 3.93231V3.1875H8.08775V3.90734C6.477 4.03166 5.38209 4.95019 5.38209 6.29053C5.38209 7.69303 6.25813 8.37569 8.13928 8.84744V11.2806C7.3015 11.1562 6.60609 10.7838 5.87138 10.2128L5.04688 11.3422C5.92943 12.0216 6.98099 12.4467 8.08775 12.5715V13.8125H9.20869V12.5837C10.8449 12.4472 11.9531 11.5409 11.9531 10.1756ZM8.13875 7.34559C7.14691 7.06031 6.90253 6.72509 6.90253 6.20341C6.90253 5.65781 7.32753 5.22325 8.13928 5.16109L8.13875 7.34559ZM10.4327 10.2622C10.4327 10.8582 9.96891 11.2678 9.15716 11.33V9.08331C10.1623 9.36912 10.4327 9.70381 10.4327 10.2627V10.2622Z" fill="#DB0F19"/>
                                            </svg> TOTAL ESTIMATED PROFIT
                                        </h2>
                                    </div>

                                    <div class="col-md-2 text-danger text-center">
                                        <strong class="text-lg text-dark"><i class="pi pi-dollar"></i>{{add_commas(total_estimated_profit)}}</strong>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-body" style="padding: 1.5rem;">
                            <div class="row mb-4">
                                <div class="col-md-10">
                                    <strong class="text-lg text-dark">YOUR SHARE OF THE PROFITS</strong>
                                </div>

                                <div class="col-md-2 text-center pr-0">
                                    <strong class="text-lg text-dark"><i class="pi pi-dollar"></i>{{add_commas(your_share_of_the_profit)}}</strong>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-10">
                                    <strong class="text-lg text-dark">PROFIT PER MONTH HELD</strong>
                                </div>

                                <div class="col-md-2 text-center pr-0">
                                    <strong class="text-lg text-dark"><i class="pi pi-dollar"></i>{{add_commas(profit_per_month_held)}}</strong>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-10">
                                    <strong class="text-lg text-dark">DEAL PROFIT MARGIN</strong>
                                </div>

                                <div class="col-md-2 text-center">
                                    <strong class="text-lg text-dark">{{add_commas(Math.round(deal_profit_margin))}}%</strong>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-10">
                                    <strong class="text-lg text-dark">CASH OUT OF POCKET</strong>
                                </div>

                                <div class="col-md-2 text-center pr-0">
                                    <strong class="text-lg text-dark"><i class="pi pi-dollar"></i>{{add_commas(cash_out_of_pocket)}}</strong>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-10">
                                    <strong class="text-lg text-dark">INCREASE IN PROPERTY VALUE</strong>
                                </div>

                                <div class="col-md-2 text-center pr-0">
                                    <strong class="text-lg text-dark"><i class="pi pi-dollar"></i>{{add_commas(increase_in_property_value)}}</strong>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-10">
                                    <strong class="text-lg text-dark">REHAB TO VALUE-ADD MULTIPLIER</strong>
                                </div>

                                <div class="col-md-2 text-center pr-0">
                                    <strong class="text-lg text-dark">{{total_renovation_cost != "0" ? add_commas(increase_in_property_value/total_renovation_cost) : total_renovation_cost}}</strong>
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

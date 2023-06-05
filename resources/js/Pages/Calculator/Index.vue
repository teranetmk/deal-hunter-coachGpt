<script>
    import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
    import {Link, Head, useForm, usePage} from '@inertiajs/inertia-vue3';
    export default {
    name: "Calculators",
    props: ['count'],
    data() {
        return {
            sharing_count: 0
        }
    },
    mounted: function () {
        let vm = this;

        vm.$nextTick(function () {
            this.sharing_count = vm.count;
        });
    },
    methods: {
        async saveCount() {
            await axios.post(route('contracts.add.share.count'), {type: 'calculators_index'});
            this.sharing_count += 1;
        }
    },

    components: {
        AuthenticatedLayout, Head, Link
    }
};
</script>

<template>

    <Head>
        <title>Calculators</title>
        <meta property="og:site_name" content="DealHunter">
        <meta property="og:title" content="Calculators">
        <meta property="og:description" content="Try Out Our Calculators">
        <meta property="og:image" content="/images/calculators.jpg">
        <meta property="og:url" content="{{route('users.calculator.index')}}">
    </Head>
    <AuthenticatedLayout>
        <!-- Header Start -->
        <template #pageHeading>
            <div class="col-12">
                <div class="row align-items-center">
                    <div class="col text-left">
                        <div class="u_frm_hdng">
                            <svg width="17" height="17" viewBox="0 0 17 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M16.7156 3.27562H14.0648C13.9218 3.27562 13.8003 3.16445 13.8003 3.01111V0.339119C13.8003 0.196198 13.6838 0.074606 13.5357 0.074606L5.34567 0.0693359C4.86421 0.0693359 4.45676 0.392075 4.32451 0.831261L4.28223 15.9419C4.28223 16.5239 4.75842 17.0001 5.34039 17.0001H15.922C16.504 17.0001 16.9802 16.5239 16.9802 15.9419V3.54019C16.9802 3.39727 16.8637 3.27568 16.7157 3.27568L16.7156 3.27562ZM6.86408 4.27558H10.0386C10.3296 4.27558 10.5676 4.51888 10.5676 4.80461C10.5676 5.0956 10.3296 5.33364 10.0386 5.33364H6.86408C6.5731 5.33364 6.33505 5.0956 6.33505 4.80461C6.33505 4.51889 6.57309 4.27558 6.86408 4.27558ZM14.2871 11.6667H6.87982C6.58884 11.6667 6.35079 11.4287 6.35079 11.1377C6.35079 10.8467 6.58883 10.6087 6.87982 10.6087H14.2871C14.578 10.6087 14.8161 10.8467 14.8161 11.1377C14.8162 11.4287 14.5781 11.6667 14.2871 11.6667ZM14.2977 9.55566H6.89049C6.5995 9.55566 6.36146 9.32289 6.36146 9.02663C6.36146 8.73564 6.59949 8.49759 6.89049 8.49759H14.2977C14.5887 8.49759 14.8268 8.73563 14.8268 9.02663C14.8268 9.32289 14.5887 9.55566 14.2977 9.55566ZM14.303 7.44997H6.89576C6.60477 7.44997 6.36673 7.21193 6.36673 6.92093C6.36673 6.63522 6.60476 6.3919 6.89576 6.3919H14.303C14.5993 6.3919 14.832 6.63521 14.832 6.92093C14.832 7.2118 14.5993 7.44997 14.303 7.44997Z"
                                    fill="#101136" />
                                <path
                                    d="M14.9924 2.18093H16.787C16.9131 2.18093 16.9765 2.02872 16.8878 1.93913L15.0931 0.129197C15.0039 0.0392267 14.8506 0.102344 14.8506 0.22908V2.03902C14.8505 2.11732 14.914 2.18093 14.9924 2.18093Z"
                                    fill="#101136" />
                                <path
                                    d="M2.00859 5.32272L0.0868639 5.31934C0.0431959 5.31921 0.0078125 5.35472 0.0078125 5.39851L0.0226192 13.738C0.0227447 13.7819 0.0582565 13.8174 0.101924 13.8175L2.02365 13.821C2.06732 13.8211 2.1027 13.7856 2.1027 13.7418L2.08789 5.40241C2.08777 5.35861 2.05226 5.32297 2.00859 5.32285V5.32272Z"
                                    fill="#101136" />
                                <path
                                    d="M1.97883 14.8988L0.151192 14.8955C0.09322 14.8954 0.0555751 14.9579 0.081675 15.0111L0.998818 16.8868C1.02768 16.9457 1.10962 16.9459 1.13835 16.887L2.04885 15.0146C2.07457 14.9617 2.0368 14.8989 1.97883 14.8988Z"
                                    fill="#101136" />
                                <path
                                    d="M2.65504 1.54692L2.08084 1.54592L2.07996 1.04451C2.07896 0.468065 1.61305 0.00102955 1.03821 1.61696e-06H1.03809C0.464403 -0.00100223 -0.00102624 0.465528 1.69943e-06 1.04085L0.00552308 4.16407C0.00564855 4.20698 0.0402801 4.24174 0.0830711 4.24187L2.0082 4.24526C2.05086 4.24538 2.08562 4.21062 2.08549 4.16783L2.08273 2.61238L2.65693 2.61338L2.66358 6.34607C2.66408 6.64057 2.8971 6.8796 3.18458 6.88024C3.47193 6.88074 3.70421 6.64246 3.70356 6.34796L3.69691 2.61527C3.69591 2.02713 3.22837 1.54792 2.65504 1.54692Z"
                                    fill="#101136" />
                            </svg>
                            Calculators
                        </div>
                    </div>
                    <div class="col">
                        <div class="d-flex justify-content-end">
                            <ShareNetwork
                                @close="saveCount"
                                network="facebook"
                                url="http://dealhunter.ai/calculator"
                                title="Calculators"
                                description="Try Out Our Calculators"
                                quote="Try Out Our Calculators"
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
        </template>
        <br>
        <!-- Header End -->
        <div class="row">
            <div class="col-md-4 col-sm-12 col-lg-3">
                <Link class="card" style="border-top-right-radius: 5%; border-top-left-radius: 5%;" :href="route('users.calculator.max-allowable-offer',)">
                    <img class="card-img-top" src="/images/max_allowable_offer_calculator.png" alt="Card image cap" />
                    <div class="card-body">
                        <h5 class="card-title">Maximum Allowable Offer Calculator</h5>
                        <p class="card-text">Our Maximum Allowable Offer (MAO) Calculator is a tool for real estate investors to determine the maximum price they should offer for a property based on the desired return on investment. The calculator takes into account the property's potential rental income, operating expenses, and target cap rate to estimate the maximum offer amount for a profitable investment.</p>
                    </div>
                </Link>
            </div>

            <div class="col-md-4 col-sm-12 col-lg-3">
                <Link class="card" style="border-top-right-radius: 5%; border-top-left-radius: 5%;" :href="route('users.calculator.profit-analysis',)">
                    <img class="card-img-top" src="/images/fix_flip_profit.png" alt="Card image cap" />
                    <div class="card-body">
                        <h5 class="card-title">FIX & FLIP PROFIT ANALYSIS SHEET</h5>
                        <p class="card-text"> Our Fix & Flip Profit Analysis Sheet is a tool for real estate investors to evaluate the potential profitability of a fix-and-flip investment. The sheet considers the purchase price, renovation costs, estimated resale value, and other expenses to calculate the projected profit and ROI for a fix-and-flip project.</p>
                    </div>
                </Link>
            </div>

            <div class="col-md-4 col-sm-12 col-lg-3">
                <Link class="card" style="border-top-right-radius: 5%; border-top-left-radius: 5%;" :href="route('users.calculator.brrrr-profit-analysis',)">
                    <img class="card-img-top" src="/images/brrr_profit_analysis.png" alt="Card image cap" />
                    <div class="card-body">
                        <h5 class="card-title">BRRR Profit Analysis</h5>
                        <p class="card-text">Our BRRR Calculator helps real estate investors calculate returns on investment properties by considering purchase price, rehab costs, rental income, expenses, and refinance options to estimate cash flow and ROI.</p>
                    </div>
                </Link>
            </div>

            <div class="col-md-4 col-sm-12 col-lg-3">
                <Link class="card" style="border-top-right-radius: 5%; border-top-left-radius: 5%;" :href="route('users.calculator.renovation',)">
                    <img class="card-img-top" src="/images/renovation_project_estimator.png" alt="Card image cap" />
                    <div class="card-body">
                        <h5 class="card-title">RENOVATION PROJECT ESTIMATE</h5>
                        <p class="card-text">Our Renovation Project Estimate is a tool to help real estate investors calculate the cost of a renovation project. The estimate takes into account the scope of work, materials, labor, and other expenses to provide a comprehensive budget for a renovation project.</p>
                    </div>
                </Link>
            </div>

            <div class="col-md-4 col-sm-12 col-lg-3">
                <Link class="card" style="border-top-right-radius: 5%; border-top-left-radius: 5%;" :href="route('users.calculator.comparative-market-analysis',)">
                    <img class="card-img-top" src="/images/comparitive_market_analysis.png" alt="Card image cap" />
                    <div class="card-body">
                        <h5 class="card-title">COMPARATIVE MARKET ARV ANALYSIS</h5>
                        <p class="card-text">Our Comparative Market ARV (After Repair Value) Analysis is a tool to help real estate investors estimate the potential resale value of a property after a renovation. The analysis compares the subject property with similar recently sold properties in the same area to determine the estimated market value after the renovation is complete.</p>
                    </div>
                </Link>
            </div>
        </div>

        </AuthenticatedLayout>
 </template>


<style scoped>
.card {
    --bs-card-spacer-y: 1rem;
    --bs-card-spacer-x: 1rem;
    --bs-card-title-spacer-y: 0.5rem;
    --bs-card-border-width: 1px;
    --bs-card-border-color: rgba(0,0,0,0.175);
    --bs-card-border-radius: 0.375rem;
    --bs-card-inner-border-radius: calc(0.375rem - (1px));
    --bs-card-cap-padding-y: 0.5rem;
    --bs-card-cap-padding-x: 1rem;
    --bs-card-cap-bg: #F5F5F5;
    --bs-card-bg: #fff;
    --bs-card-img-overlay-padding: 1rem;
    --bs-card-group-margin: 0.75rem;
    position: relative;
    display: flex;
    flex-direction: column;
    min-width: 0;
    word-wrap: break-word;
    background-color: var(--bs-card-bg);
    background-clip: border-box;
    border: var(--bs-card-border-width) solid var(--bs-card-border-color);
    border-radius: var(--bs-card-border-radius);
    padding: 0;
}
.card-img, .card-img-top {
    border-top-left-radius: calc(0.375rem - 1px);
    border-top-right-radius: calc(0.375rem - 1px);
}
.card-body {
    flex: 1 1 auto;
    padding: 1rem 1rem;
}

.card-title {
    margin-bottom: 0.5rem;
    font-size: 21px;
}
.card-text {
    font-size: 14px;
    color: #575A7B;
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

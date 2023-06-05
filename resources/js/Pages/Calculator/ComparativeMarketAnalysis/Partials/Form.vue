<script>
import TextInput from "@/Components/TextInput.vue";
import { differenceInDays, toDate, parseISO } from 'date-fns'
import CascadeSelect from "primevue/cascadeselect";
import {collect} from "collect.js";

export default {
    components: {TextInput, CascadeSelect},
    props: ['form', 'count'],
    methods: {
        async saveCount() {
            await axios.post(route('contracts.add.share.count'), {type: 'calculator_comparative_market_analysis'});
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
        square_footage_percentage() { return Number(remove_commas(this.form.square_footage)) / 100 },
        days_since_sale_1() {

            if(this.form.property_date_sold_1 && this.form.property_date_sold_1 !== "") { return differenceInDays(new Date(), parseISO(this.form.property_date_sold_1)) }

            return '-'
        },
        days_since_sale_2() {

            if(this.form.property_date_sold_2 && this.form.property_date_sold_2 !== "") { return differenceInDays(new Date(), parseISO(this.form.property_date_sold_2)) }

            return '-'
        },
        days_since_sale_3() {

            if(this.form.property_date_sold_3 && this.form.property_date_sold_3 !== "") { return differenceInDays(new Date(), parseISO(this.form.property_date_sold_3)) }

            return '-'
        },
        days_since_sale_4() {

            if(this.form.property_date_sold_4 && this.form.property_date_sold_4 !== "") { return differenceInDays(new Date(), parseISO(this.form.property_date_sold_4)) }

            return '-'
        },
        price_per_sqrt_1() {

            if(this.form.property_square_footage_1 && this.form.property_last_sold_price_1) { return add_commas(remove_commas(this.form.property_last_sold_price_1) / remove_commas(this.form.property_square_footage_1), 2) }
            return '-';
        },
        price_per_sqrt_2() {

            if(this.form.property_square_footage_2 && this.form.property_last_sold_price_2) { return add_commas(remove_commas(this.form.property_last_sold_price_2) / remove_commas(this.form.property_square_footage_2), 2) }
            return '-';
        },
        price_per_sqrt_3() {

            if(this.form.property_square_footage_3 && this.form.property_last_sold_price_3) { return add_commas(remove_commas(this.form.property_last_sold_price_3) / remove_commas(this.form.property_square_footage_3), 2) }
            return '-';
        },
        price_per_sqrt_4() {

            if(this.form.property_square_footage_4 && this.form.property_last_sold_price_4) { return add_commas(remove_commas(this.form.property_last_sold_price_4) / remove_commas(this.form.property_square_footage_4), 2) }
            return '-';
        },
        subject_property_likeness() { return remove_commas(this.form.subject_property_curb_appeal) + remove_commas(this.form.subject_property_interior) + remove_commas(this.form.subject_property_fixtures) },
        property_likeness_1() { return remove_commas(this.form.property_curb_appeal_1) + remove_commas(this.form.property_interior_1) + remove_commas(this.form.property_fixtures_1) },
        property_likeness_2() { return remove_commas(this.form.property_curb_appeal_2) + remove_commas(this.form.property_interior_2) + remove_commas(this.form.property_fixtures_2) },
        property_likeness_3() { return remove_commas(this.form.property_curb_appeal_3) + remove_commas(this.form.property_interior_3) + remove_commas(this.form.property_fixtures_3) },
        property_likeness_4() { return remove_commas(this.form.property_curb_appeal_4) + remove_commas(this.form.property_interior_4) + remove_commas(this.form.property_fixtures_4) },

        property_delta_1() { return remove_commas(this.property_likeness_1) - remove_commas(this.subject_property_likeness) },
        property_delta_2() { return remove_commas(this.property_likeness_2) - remove_commas(this.subject_property_likeness) },
        property_delta_3() { return remove_commas(this.property_likeness_3) - remove_commas(this.subject_property_likeness) },
        property_delta_4() { return remove_commas(this.property_likeness_4) - remove_commas(this.subject_property_likeness) },

        min_square_footage() {

            if(this.form.subject_property_square_footage && this.form.square_footage) return  add_commas(Math.round(remove_commas(this.form.subject_property_square_footage) * (1 - remove_commas(this.square_footage_percentage))))

            return ''
        },
        max_square_footage() {

            if(this.form.subject_property_square_footage && this.form.square_footage) return  add_commas(Math.round(remove_commas(this.form.subject_property_square_footage) * (1 + remove_commas(this.square_footage_percentage))))

            return ''
        },
        min_year_built() {

            if(this.form.property_age && this.form.subject_property_year_built) return Number(remove_commas(this.form.subject_property_year_built)) - Number(remove_commas(this.form.property_age))
            return ''
        },
        max_year_built() {

            if(this.form.property_age && this.form.subject_property_year_built) return Number(remove_commas(this.form.subject_property_year_built)) + Number(remove_commas(this.form.property_age))
            return ''
        },

        average_sale_price() {

            let prices = [];
            if(this.form.property_include_analysis_1 === "Yes"){

                prices.push(remove_commas(this.form.property_last_sold_price_1));
            }

            if(this.form.property_include_analysis_2 === "Yes"){

                prices.push(remove_commas(this.form.property_last_sold_price_2));
            }

            if(this.form.property_include_analysis_3 === "Yes"){

                prices.push(remove_commas(this.form.property_last_sold_price_3));
            }

            if(this.form.property_include_analysis_4 === "Yes"){

                prices.push(remove_commas(this.form.property_last_sold_price_4));
            }

            return collect(prices).sum() / (prices.length+1);
        },
        min_price_sqft() {

            let prices = [];
            if(this.form.property_include_analysis_1 === "Yes"){

                prices.push(remove_commas(this.price_per_sqrt_1));
            }

            if(this.form.property_include_analysis_2 === "Yes"){

                prices.push(remove_commas(this.price_per_sqrt_2));
            }

            if(this.form.property_include_analysis_3 === "Yes"){

                prices.push(remove_commas(this.price_per_sqrt_3));
            }

            if(this.form.property_include_analysis_4 === "Yes"){

                prices.push(remove_commas(this.price_per_sqrt_4));
            }

            return Math.min(...prices);
        },
        highest_price_sqft() {

            let prices = [];
            if(this.form.property_include_analysis_1 === "Yes"){

                prices.push(remove_commas(this.price_per_sqrt_1));
            }

            if(this.form.property_include_analysis_2 === "Yes"){

                prices.push(remove_commas(this.price_per_sqrt_2));
            }

            if(this.form.property_include_analysis_3 === "Yes"){

                prices.push(remove_commas(this.price_per_sqrt_3));
            }

            if(this.form.property_include_analysis_4 === "Yes"){

                prices.push(remove_commas(this.price_per_sqrt_4));
            }

            return Math.max(...prices);
        },
        average_price_sqft() {

            let prices = [];
            if(this.form.property_include_analysis_1 === "Yes"){

                prices.push(remove_commas(this.price_per_sqrt_1));
            }

            if(this.form.property_include_analysis_2 === "Yes"){

                prices.push(remove_commas(this.price_per_sqrt_2));
            }

            if(this.form.property_include_analysis_3 === "Yes"){

                prices.push(remove_commas(this.price_per_sqrt_3));
            }

            if(this.form.property_include_analysis_4 === "Yes"){

                prices.push(remove_commas(this.price_per_sqrt_4));
            }

            return collect(prices).sum() / prices.length;
        },
        price_sqft_range(){ return Number(this.highest_price_sqft) - Number(this.min_price_sqft) },
        highest_likeness() {

            let prices = [];
            if(this.form.property_include_analysis_1 === "Yes"){

                prices.push(remove_commas(this.property_likeness_1));
            }

            if(this.form.property_include_analysis_2 === "Yes"){

                prices.push(remove_commas(this.property_likeness_2));
            }

            if(this.form.property_include_analysis_3 === "Yes"){

                prices.push(remove_commas(this.property_likeness_3));
            }

            if(this.form.property_include_analysis_4 === "Yes"){

                prices.push(remove_commas(this.property_likeness_4));
            }

            return Math.max(...prices);
        },
        suggested_sqft_price() { return remove_commas(this.min_price_sqft) + (this.subject_property_likeness / this.highest_likeness * remove_commas(this.price_sqft_range)); },
        avr_estimate() { return remove_commas(this.form.subject_property_square_footage) * remove_commas(this.form.subject_property_sqft) }
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
                            ARV
                        </div>
                    </div>
                    <div class="col">
                        <div class="d-flex justify-content-end">
                            <ShareNetwork
                                @close="saveCount"
                                network="facebook"
                                url="http://dealhunter.ai/calculator/comparative-market-analysis"
                                title="Comparative Market Analysis Calculator"
                                description="Try Out Our Comparative Market Analysis Calculator"
                                quote="Try Out Our Comparative Market Analysis Calculator"
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

            <div class="row mt-5">
                <div class="col-md-12">
                    <div class="card p-0" style="overflow: hidden;">
                        <div class="card-header">
                            <h2 class="card-title text-2xl"> COMPARATIVE MARKET ANALYSIS</h2>
                        </div>

                        <div class="card-body px-3 pb-3">
                            <div class="row my-3">
                                <div class="col-md-4">&nbsp;</div>
                                <div class="col-md-8">
                                    <div class="row">
                                        <div class="col-md-2"><strong>Subject Property</strong></div>
                                        <div class="col-md-2"><strong>Comp 1</strong></div>
                                        <div class="col-md-2"><strong>Comp 2</strong></div>
                                        <div class="col-md-2"><strong>Comp 3</strong></div>
                                        <div class="col-md-2"><strong>Comp 4</strong></div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-4">Address</div>
                                <div class="col-md-8">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <InputText class="w-full text-center" style="border-radius: 1rem !important;" v-model="form.subject_property_address" />
                                        </div>
                                        <div class="col-md-2">
                                            <InputText class="w-full text-center" style="border-radius: 1rem !important;" v-model="form.property_address_1" />
                                        </div>
                                        <div class="col-md-2">
                                            <InputText class="w-full text-center" style="border-radius: 1rem !important;" v-model="form.property_address_2" />
                                        </div>
                                        <div class="col-md-2">
                                            <InputText class="w-full text-center" style="border-radius: 1rem !important;" v-model="form.property_address_3" />
                                        </div>
                                        <div class="col-md-2">
                                            <InputText class="w-full text-center" style="border-radius: 1rem !important;" v-model="form.property_address_4" />
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-4">Include in Analysis?</div>
                                <div class="col-md-8">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <select class="p-inputtext p-component p-filled w-full text-center" style="border-radius: 1rem !important;" v-model="form.subject_property_include_analysis">
                                                <option value="Yes">Yes</option>
                                                <option value="No">No</option>
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <select class="p-inputtext p-component p-filled w-full text-center" style="border-radius: 1rem !important;" v-model="form.property_include_analysis_1">
                                                <option value="Yes">Yes</option>
                                                <option value="No">No</option>
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <select class="p-inputtext p-component p-filled w-full text-center" style="border-radius: 1rem !important;" v-model="form.property_include_analysis_2">
                                                <option value="Yes">Yes</option>
                                                <option value="No">No</option>
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <select class="p-inputtext p-component p-filled w-full text-center" style="border-radius: 1rem !important;" v-model="form.property_include_analysis_3">
                                                <option value="Yes">Yes</option>
                                                <option value="No">No</option>
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <select class="p-inputtext p-component p-filled w-full text-center" style="border-radius: 1rem !important;" v-model="form.property_include_analysis_4">
                                                <option value="Yes">Yes</option>
                                                <option value="No">No</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-4">Style</div>
                                <div class="col-md-8">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <InputText class="w-full text-center" style="border-radius: 1rem !important;" v-model="form.subject_property_style" />
                                        </div>
                                        <div class="col-md-2">
                                            <InputText class="w-full text-center" style="border-radius: 1rem !important;" v-model="form.property_style_1" />
                                        </div>
                                        <div class="col-md-2">
                                            <InputText class="w-full text-center" style="border-radius: 1rem !important;" v-model="form.property_style_2" />
                                        </div>
                                        <div class="col-md-2">
                                            <InputText class="w-full text-center" style="border-radius: 1rem !important;" v-model="form.property_style_3" />
                                        </div>
                                        <div class="col-md-2">
                                            <InputText class="w-full text-center" style="border-radius: 1rem !important;" v-model="form.property_style_4" />
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-4">Square Footage</div>
                                <div class="col-md-8">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <InputText class="w-full text-center" style="border-radius: 1rem !important;" v-model="form.subject_property_square_footage" />
                                        </div>
                                        <div class="col-md-2">
                                            <InputText class="w-full text-center" style="border-radius: 1rem !important;" v-model="form.property_square_footage_1" />
                                        </div>
                                        <div class="col-md-2">
                                            <InputText class="w-full text-center" style="border-radius: 1rem !important;" v-model="form.property_square_footage_2" />
                                        </div>
                                        <div class="col-md-2">
                                            <InputText class="w-full text-center" style="border-radius: 1rem !important;" v-model="form.property_square_footage_3" />
                                        </div>
                                        <div class="col-md-2">
                                            <InputText class="w-full text-center" style="border-radius: 1rem !important;" v-model="form.property_square_footage_4" />
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-4">Beds</div>
                                <div class="col-md-8">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <InputText class="w-full text-center" style="border-radius: 1rem !important;" v-model="form.subject_property_beds" />
                                        </div>
                                        <div class="col-md-2">
                                            <InputText class="w-full text-center" style="border-radius: 1rem !important;" v-model="form.property_beds_1" />
                                        </div>
                                        <div class="col-md-2">
                                            <InputText class="w-full text-center" style="border-radius: 1rem !important;" v-model="form.property_beds_2" />
                                        </div>
                                        <div class="col-md-2">
                                            <InputText class="w-full text-center" style="border-radius: 1rem !important;" v-model="form.property_beds_3" />
                                        </div>
                                        <div class="col-md-2">
                                            <InputText class="w-full text-center" style="border-radius: 1rem !important;" v-model="form.property_beds_4" />
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-4">Baths</div>
                                <div class="col-md-8">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <InputText class="w-full text-center" style="border-radius: 1rem !important;" v-model="form.subject_property_baths" />
                                        </div>
                                        <div class="col-md-2">
                                            <InputText class="w-full text-center" style="border-radius: 1rem !important;" v-model="form.property_baths_1" />
                                        </div>
                                        <div class="col-md-2">
                                            <InputText class="w-full text-center" style="border-radius: 1rem !important;" v-model="form.property_baths_2" />
                                        </div>
                                        <div class="col-md-2">
                                            <InputText class="w-full text-center" style="border-radius: 1rem !important;" v-model="form.property_baths_3" />
                                        </div>
                                        <div class="col-md-2">
                                            <InputText class="w-full text-center" style="border-radius: 1rem !important;" v-model="form.property_baths_4" />
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-4">Lot Size</div>
                                <div class="col-md-8">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <InputText class="w-full text-center" style="border-radius: 1rem !important;" v-model="form.subject_property_lot_size" />
                                        </div>
                                        <div class="col-md-2">
                                            <InputText class="w-full text-center" style="border-radius: 1rem !important;" v-model="form.property_lot_size_1" />
                                        </div>
                                        <div class="col-md-2">
                                            <InputText class="w-full text-center" style="border-radius: 1rem !important;" v-model="form.property_lot_size_2" />
                                        </div>
                                        <div class="col-md-2">
                                            <InputText class="w-full text-center" style="border-radius: 1rem !important;" v-model="form.property_lot_size_3" />
                                        </div>
                                        <div class="col-md-2">
                                            <InputText class="w-full text-center" style="border-radius: 1rem !important;" v-model="form.property_lot_size_4" />
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-4">Year Built</div>
                                <div class="col-md-8">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <InputText class="w-full text-center" style="border-radius: 1rem !important;" v-model="form.subject_property_year_built" />
                                        </div>
                                        <div class="col-md-2">
                                            <InputText class="w-full text-center" style="border-radius: 1rem !important;" v-model="form.property_year_built_1" />
                                        </div>
                                        <div class="col-md-2">
                                            <InputText class="w-full text-center" style="border-radius: 1rem !important;" v-model="form.property_year_built_2" />
                                        </div>
                                        <div class="col-md-2">
                                            <InputText class="w-full text-center" style="border-radius: 1rem !important;" v-model="form.property_year_built_3" />
                                        </div>
                                        <div class="col-md-2">
                                            <InputText class="w-full text-center" style="border-radius: 1rem !important;" v-model="form.property_year_built_4" />
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-4">Garage</div>
                                <div class="col-md-8">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <InputText class="w-full text-center" style="border-radius: 1rem !important;" v-model="form.subject_property_garage" />
                                        </div>
                                        <div class="col-md-2">
                                            <InputText class="w-full text-center" style="border-radius: 1rem !important;" v-model="form.property_garage_1" />
                                        </div>
                                        <div class="col-md-2">
                                            <InputText class="w-full text-center" style="border-radius: 1rem !important;" v-model="form.property_garage_2" />
                                        </div>
                                        <div class="col-md-2">
                                            <InputText class="w-full text-center" style="border-radius: 1rem !important;" v-model="form.property_garage_3" />
                                        </div>
                                        <div class="col-md-2">
                                            <InputText class="w-full text-center" style="border-radius: 1rem !important;" v-model="form.property_garage_4" />
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-4">Pool</div>
                                <div class="col-md-8">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <select class="p-inputtext p-component p-filled w-full text-center" style="border-radius: 1rem !important;" v-model="form.subject_property_pool">
                                                <option value="Yes">Yes</option>
                                                <option value="No">No</option>
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <select class="p-inputtext p-component p-filled w-full text-center" style="border-radius: 1rem !important;" v-model="form.property_pool_1">
                                                <option value="Yes">Yes</option>
                                                <option value="No">No</option>
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <select class="p-inputtext p-component p-filled w-full text-center" style="border-radius: 1rem !important;" v-model="form.property_pool_2">
                                                <option value="Yes">Yes</option>
                                                <option value="No">No</option>
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <select class="p-inputtext p-component p-filled w-full text-center" style="border-radius: 1rem !important;" v-model="form.property_pool_3">
                                                <option value="Yes">Yes</option>
                                                <option value="No">No</option>
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <select class="p-inputtext p-component p-filled w-full text-center" style="border-radius: 1rem !important;" v-model="form.property_pool_4">
                                                <option value="Yes">Yes</option>
                                                <option value="No">No</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-4">Proximity to Subject (miles)</div>
                                <div class="col-md-8">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <InputText class="w-full text-center" style="border-radius: 1rem !important;" v-model="form.subject_property_proximity" readonly />
                                        </div>
                                        <div class="col-md-2">
                                            <InputText class="w-full text-center" style="border-radius: 1rem !important;" v-model="form.property_proximity_1" />
                                        </div>
                                        <div class="col-md-2">
                                            <InputText class="w-full text-center" style="border-radius: 1rem !important;" v-model="form.property_proximity_2" />
                                        </div>
                                        <div class="col-md-2">
                                            <InputText class="w-full text-center" style="border-radius: 1rem !important;" v-model="form.property_proximity_3" />
                                        </div>
                                        <div class="col-md-2">
                                            <InputText class="w-full text-center" style="border-radius: 1rem !important;" v-model="form.property_proximity_4" />
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-4">Date Sold</div>
                                <div class="col-md-8">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <InputText class="w-full" style="border-radius: 1rem !important;" v-model="form.subject_property_date_sold" readonly />
                                        </div>
                                        <div class="col-md-2">
                                            <InputText type="date" class="w-full" style="border-radius: 1rem !important;" v-model="form.property_date_sold_1" />
                                        </div>
                                        <div class="col-md-2">
                                            <InputText type="date" class="w-full" style="border-radius: 1rem !important;" v-model="form.property_date_sold_2" />
                                        </div>
                                        <div class="col-md-2">
                                            <InputText type="date" class="w-full" style="border-radius: 1rem !important;" v-model="form.property_date_sold_3" />
                                        </div>
                                        <div class="col-md-2">
                                            <InputText type="date" class="w-full" style="border-radius: 1rem !important;" v-model="form.property_date_sold_4" />
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-4">Last Sold Price</div>
                                <div class="col-md-8">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <div class="position-relative">
                                                <i style="top: 38%;left: 20px;" class="position-absolute pi pi-dollar"></i>
                                                <InputText class="w-full text-center" style="border-radius: 1rem !important;" v-model="form.subject_property_last_sold_price" readonly />
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="position-relative">
                                                <i style="top: 38%;left: 20px;" class="position-absolute pi pi-dollar"></i>
                                                <InputText class="w-full text-center" style="border-radius: 1rem !important;" v-model="form.property_last_sold_price_1" />
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="position-relative">
                                                <i style="top: 38%;left: 20px;" class="position-absolute pi pi-dollar"></i>
                                                <InputText class="w-full text-center" style="border-radius: 1rem !important;" v-model="form.property_last_sold_price_2" />
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="position-relative">
                                                <i style="top: 38%;left: 20px;" class="position-absolute pi pi-dollar"></i>
                                                <InputText class="w-full text-center" style="border-radius: 1rem !important;" v-model="form.property_last_sold_price_3" />
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="position-relative">
                                                <i style="top: 38%;left: 20px;" class="position-absolute pi pi-dollar"></i>
                                                <InputText class="w-full text-center" style="border-radius: 1rem !important;" v-model="form.property_last_sold_price_4" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

<!--                            <div class="row mb-3">-->
<!--                                <div class="col-md-4">Last Sold Price</div>-->
<!--                                <div class="col-md-8">-->
<!--                                    <div class="row">-->
<!--                                        <div class="col-md-2">-->
<!--                                            <InputText class="w-full text-center" style="border-radius: 1rem !important;" v-model="form.subject_property_second_last_sold_price" readonly />-->
<!--                                        </div>-->
<!--                                        <div class="col-md-2">-->
<!--                                            <InputText class="w-full text-center" style="border-radius: 1rem !important;" v-model="form.property_second_last_sold_price_1" />-->
<!--                                        </div>-->
<!--                                        <div class="col-md-2">-->
<!--                                            <InputText class="w-full text-center" style="border-radius: 1rem !important;" v-model="form.property_second_last_sold_price_2" />-->
<!--                                        </div>-->
<!--                                        <div class="col-md-2">-->
<!--                                            <InputText class="w-full text-center" style="border-radius: 1rem !important;" v-model="form.property_second_last_sold_price_3" />-->
<!--                                        </div>-->
<!--                                        <div class="col-md-2">-->
<!--                                            <InputText class="w-full text-center" style="border-radius: 1rem !important;" v-model="form.property_second_last_sold_price_4" />-->
<!--                                        </div>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                            </div>-->

                            <div class="row mb-3">
                                <div class="col-md-4">Days Since Sale</div>
                                <div class="col-md-8">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <strong class="text-xl">-</strong>
                                        </div>
                                        <div class="col-md-2">
                                            <strong class="text-xl">{{days_since_sale_1}}</strong>
                                        </div>
                                        <div class="col-md-2">
                                            <strong class="text-xl">{{days_since_sale_2}}</strong>
                                        </div>
                                        <div class="col-md-2">
                                            <strong class="text-xl">{{days_since_sale_3}}</strong>
                                        </div>
                                        <div class="col-md-2">
                                            <strong class="text-xl">{{days_since_sale_4}}</strong>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-4">Price per Sqft.</div>
                                <div class="col-md-8">
                                    <div class="row">
                                        <div class="col-md-2"> <strong>-</strong> </div>
                                        <div class="col-md-2">
                                            <strong class="text-xl"><i v-if="price_per_sqrt_1 !== '-'" class="pi pi-dollar"></i>{{price_per_sqrt_1}}</strong>
                                        </div>
                                        <div class="col-md-2">
                                            <strong class="text-xl"><i v-if="price_per_sqrt_2 !== '-'" class="pi pi-dollar"></i>{{price_per_sqrt_2}}</strong>
                                        </div>
                                        <div class="col-md-2">
                                            <strong class="text-xl"><i v-if="price_per_sqrt_3 !== '-'" class="pi pi-dollar"></i>{{price_per_sqrt_3}}</strong>
                                        </div>
                                        <div class="col-md-2">
                                            <strong class="text-xl"><i v-if="price_per_sqrt_4 !== '-'" class="pi pi-dollar"></i>{{price_per_sqrt_4}}</strong>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-12 bg-gray">
                                    <h2>AFTER REPAIRS</h2>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-4">Curb Appeal (1= Distress, 5= Upscale)</div>
                                <div class="col-md-8">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <InputText class="w-full text-center" style="border-radius: 1rem !important;" v-model="form.subject_property_curb_appeal" />
                                        </div>
                                        <div class="col-md-2">
                                            <InputText class="w-full text-center" style="border-radius: 1rem !important;" v-model="form.property_curb_appeal_1" />
                                        </div>
                                        <div class="col-md-2">
                                            <InputText class="w-full text-center" style="border-radius: 1rem !important;" v-model="form.property_curb_appeal_2" />
                                        </div>
                                        <div class="col-md-2">
                                            <InputText class="w-full text-center" style="border-radius: 1rem !important;" v-model="form.property_curb_appeal_3" />
                                        </div>
                                        <div class="col-md-2">
                                            <InputText class="w-full text-center" style="border-radius: 1rem !important;" v-model="form.property_curb_appeal_4" />
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-4">Interior (1= Dated, 5= Luxury)</div>
                                <div class="col-md-8">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <InputText class="w-full text-center" style="border-radius: 1rem !important;" v-model="form.subject_property_interior" />
                                        </div>
                                        <div class="col-md-2">
                                            <InputText class="w-full text-center" style="border-radius: 1rem !important;" v-model="form.property_interior_1" />
                                        </div>
                                        <div class="col-md-2">
                                            <InputText class="w-full text-center" style="border-radius: 1rem !important;" v-model="form.property_interior_2" />
                                        </div>
                                        <div class="col-md-2">
                                            <InputText class="w-full text-center" style="border-radius: 1rem !important;" v-model="form.property_interior_3" />
                                        </div>
                                        <div class="col-md-2">
                                            <InputText class="w-full text-center" style="border-radius: 1rem !important;" v-model="form.property_interior_4" />
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-4">Fixtures (1= Dated, 5= Like new)</div>
                                <div class="col-md-8">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <InputText class="w-full text-center" style="border-radius: 1rem !important;" v-model="form.subject_property_fixtures" />
                                        </div>
                                        <div class="col-md-2">
                                            <InputText class="w-full text-center" style="border-radius: 1rem !important;" v-model="form.property_fixtures_1" />
                                        </div>
                                        <div class="col-md-2">
                                            <InputText class="w-full text-center" style="border-radius: 1rem !important;" v-model="form.property_fixtures_2" />
                                        </div>
                                        <div class="col-md-2">
                                            <InputText class="w-full text-center" style="border-radius: 1rem !important;" v-model="form.property_fixtures_3" />
                                        </div>
                                        <div class="col-md-2">
                                            <InputText class="w-full text-center" style="border-radius: 1rem !important;" v-model="form.property_fixtures_4" />
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-4">Likeness Score</div>
                                <div class="col-md-8">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <strong>{{subject_property_likeness}}</strong>
                                        </div>
                                        <div class="col-md-2">
                                            <strong>{{property_likeness_1}}</strong>
                                        </div>
                                        <div class="col-md-2">
                                            <strong>{{property_likeness_2}}</strong>
                                        </div>
                                        <div class="col-md-2">
                                            <strong>{{property_likeness_3}}</strong>
                                        </div>
                                        <div class="col-md-2">
                                            <strong>{{property_likeness_4}}</strong>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-4">Delta</div>
                                <div class="col-md-8">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <strong>-</strong>
                                        </div>
                                        <div class="col-md-2">
                                            <strong>{{property_delta_1}}</strong>
                                        </div>
                                        <div class="col-md-2">
                                            <strong>{{property_delta_2}}</strong>
                                        </div>
                                        <div class="col-md-2">
                                            <strong>{{property_delta_3}}</strong>
                                        </div>
                                        <div class="col-md-2">
                                            <strong>{{property_delta_4}}</strong>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="card p-0">
                                                <div class="card-header">
                                                    <h2 class="card-title text-2xl">CRITERIA FOR COMPS</h2>
                                                </div>

                                                <div class="card-body p-4">
                                                    <div class="row mb-3">
                                                        <div class="col-md-8">Square Footage +/-</div>
                                                        <div class="col-md-4">
                                                            <div class="position-relative">
                                                                <span style="top: 30%;right: 15px;" class="position-absolute">%</span>
                                                                <InputText class="w-full text-center" style="border-radius: 1rem !important;" v-model="form.square_footage" />
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row mb-3">
                                                        <div class="col-md-8">Minimum Square Footage</div>
                                                        <div class="col-md-4">
                                                            <InputText class="w-full text-center" style="border-radius: 1rem !important;" v-model="min_square_footage" readonly />
                                                        </div>
                                                    </div>

                                                    <div class="row mb-3">
                                                        <div class="col-md-8">Maximum Square Footage</div>
                                                        <div class="col-md-4">
                                                            <InputText class="w-full text-center" style="border-radius: 1rem !important;" v-model="max_square_footage" />
                                                        </div>
                                                    </div>

                                                    <div class="row mb-3">
                                                        <div class="col-md-8">Property Age +/- (years)</div>
                                                        <div class="col-md-4">
                                                            <InputText class="w-full text-center" style="border-radius: 1rem !important;" v-model="form.property_age" />
                                                        </div>
                                                    </div>

                                                    <div class="row mb-3">
                                                        <div class="col-md-8">Year Built (Minimum)</div>
                                                        <div class="col-md-4">
                                                            <InputText class="w-full text-center" style="border-radius: 1rem !important;" v-model="min_year_built" />
                                                        </div>
                                                    </div>

                                                    <div class="row mb-3">
                                                        <div class="col-md-8">Year Built (Maximum)</div>
                                                        <div class="col-md-4">
                                                            <InputText class="w-full text-center" style="border-radius: 1rem !important;" v-model="max_year_built" />
                                                        </div>
                                                    </div>

                                                    <div class="row mb-3">
                                                        <div class="col-md-8">Proximity to Subject (miles)</div>
                                                        <div class="col-md-4">
                                                            <InputText class="w-full text-center" style="border-radius: 1rem !important;" v-model="form.proximity_to_subject" />
                                                        </div>
                                                    </div>

                                                    <div class="row mb-3">
                                                        <div class="col-md-8">Max Day Since Sale</div>
                                                        <div class="col-md-4">
                                                            <InputText class="w-full text-center" style="border-radius: 1rem !important;" v-model="form.max_days_since_sale" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="card p-0">
                                                <div class="card-header">
                                                    <h2 class="card-title text-2xl">SUMMARY</h2>
                                                </div>

                                                <div class="card-body p-4">
                                                    <div class="row mb-3">
                                                        <div class="col-md-8">Average Sale Price</div>
                                                        <div class="col-md-4">
                                                            <InputText class="w-full text-center" style="border-radius: 1rem !important;" readonly :value="'$'+add_commas(average_sale_price,2)" />
                                                        </div>
                                                    </div>

                                                    <div class="row mb-3">
                                                        <div class="col-md-8">Lowest $/Sqft.</div>
                                                        <div class="col-md-4">
                                                            <InputText class="w-full text-center" style="border-radius: 1rem !important;" readonly :value="'$'+add_commas(min_price_sqft,2)" />
                                                        </div>
                                                    </div>

                                                    <div class="row mb-3">
                                                        <div class="col-md-8">Average $/Sqft.</div>
                                                        <div class="col-md-4">
                                                            <InputText class="w-full text-center" style="border-radius: 1rem !important;" readonly :value="'$'+add_commas(average_price_sqft,2)" />
                                                        </div>
                                                    </div>

                                                    <div class="row mb-3">
                                                        <div class="col-md-8">Highest $/Sqft.</div>
                                                        <div class="col-md-4">
                                                            <InputText class="w-full text-center" style="border-radius: 1rem !important;" readonly :value="'$'+add_commas(highest_price_sqft,2)" />
                                                        </div>
                                                    </div>

                                                    <div class="row mb-3">
                                                        <div class="col-md-8">Range</div>
                                                        <div class="col-md-4">
                                                            <InputText class="w-full text-center" style="border-radius: 1rem !important;" readonly :value="'$'+add_commas(price_sqft_range,2)" />
                                                        </div>
                                                    </div>

                                                    <div class="row mb-3">
                                                        <div class="col-md-8">Suggested $/Sqft.</div>
                                                        <div class="col-md-4">
                                                            <InputText class="w-full text-center" style="border-radius: 1rem !important;"  :value="'$'+add_commas(suggested_sqft_price,2)" />
                                                        </div>
                                                    </div>

                                                    <div class="row mb-3">
                                                        <div class="col-md-8">Subject Prop. $/Sqft</div>
                                                        <div class="col-md-4">
                                                            <div class="position-relative">
                                                                <i style="top: 38%;left: 20px;" class="position-absolute pi pi-dollar"></i>
                                                                <InputText class="w-full text-center" style="border-radius: 1rem !important;" v-model="form.subject_property_sqft" />
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row mb-3">
                                                        <div class="col-md-8">Subject Prop. Sqft. x</div>
                                                        <div class="col-md-4">
                                                            <InputText class="w-full text-center" style="border-radius: 1rem !important;" readonly v-model="form.subject_property_square_footage" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <section class="w-100 d-block">
                            <div class="row p-2 mb-3" style="background: rgba(219,15,25,0.1)!important;">
                                <div class="col-md-10 pl-2">
                                    <strong class="text-danger ml-3">ARV Estimate:</strong>
                                </div>

                                <div class="col-md-2">
                                    <strong class="text-danger">
                                        <i class="pi pi-dollar"></i> {{Number(Math.round((avr_estimate / 1000))* 1000).toLocaleString()}}
                                    </strong>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>
</template>


<style scoped>
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


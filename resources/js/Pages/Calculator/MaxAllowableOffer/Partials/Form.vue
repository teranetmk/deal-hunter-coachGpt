<script>
export default {
    props: ['form', 'count'],
    data() {
        return {
            sharing_count: this.count
        }
    },
    methods: {
        async saveCount() {
            await axios.post(route('contracts.add.share.count'), {type: 'calculator_max_allowable_offer'});
            this.sharing_count += 1;
        }
    },
    computed: {
        rule_percentage() { return remove_commas(this.form.rule)/100 },
        total1() { return remove_commas(this.form.arv) * this.rule_percentage },
        total2() {

            if(remove_commas(this.form.arv) == "0") return 0;
            return Math.round(remove_commas(this.form.arv) ? remove_commas(this.form.rehab)/remove_commas(this.form.arv)*100: '0')
        },

        wholesale_arv_percentage() {

            if(remove_commas(this.form.arv) == "0") return 0;

            return Math.round(remove_commas(this.form.arv) ? remove_commas(this.form.wholesale)/remove_commas(this.form.arv)*100: '0')
        },

        maximum_allowable_offer() {

            return (remove_commas(this.form.arv) * this.rule_percentage) - remove_commas(this.form.rehab) - remove_commas(this.form.wholesale)
        },

        maximum_allowable_offer_arv() {

            if(remove_commas(this.form.arv) == "0") return 0;

            return Math.round(this.maximum_allowable_offer / remove_commas(this.form.arv) * 100)
        }
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
                            Max Allowable Offer (MAO) Calculator
                        </div>
                    </div>
                    <div class="col">
                        <div class="d-flex justify-content-end">
                            <ShareNetwork
                                @close="saveCount"
                                network="facebook"
                                url="http://dealhunter.ai/calculator/comparative-market-analysis"
                                title="Max Allowable Offer (MAO) Calculator"
                                description="Try Out Our Max Allowable Offer (MAO) Calculator"
                                quote="Try Out Our Max Allowable Offer (MAO) Calculator"
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
                    <table class="w-100">
                        <tbody>
                            <tr>
                                <td class="p-2">
                                    <table class="w-100">
                                        <tr>
                                            <td>
                                                <div class="position-relative">
                                                    <i v-if="form.arv" style="top: 32%;left: 10px;z-index: 999" class="position-absolute pi pi-dollar text-xl"></i>
                                                    <span class="p-float-label">
                                                        <InputText class="w-full pl-5 text-2xl" style="border-radius: 1rem !important;" id="name" v-model="form.arv" />
                                                        <label for="arv">Estimated ARV</label>
                                                    </span>
                                                </div>
                                            </td>
                                            <td class="px-5"><i class="pi pi-times text-xl"></i></td>
                                            <td>
                                                <span class="p-float-label">
                                                    <InputText class="w-full text-2xl" style="border-radius: 1rem !important;" v-model="form.rule" />
                                                    <label for="rule">Rule %</label>
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="3" class="text-center">
                                                <div class="w-full text-center mt-4" style="display: flex;flex-direction: column;gap: 1rem;">
                                                    <div class="w-100">
                                                        <ul class="position-relative w-100 single-line mt-3">
                                                            <li></li>
                                                        </ul>
                                                    </div>

                                                    <strong class="line-total"><i class="text-sm pi pi-dollar"></i> {{Number(Math.round(total1)).toLocaleString()}}</strong>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                </td>

                                <td class="px-5" style="vertical-align: initial;">
                                    <table class="mt-5">
                                        <tr>
                                            <td><i class="text-xl pi pi-minus"></i></td>
                                        </tr>
                                    </table>
                                </td>

                                <td class="p-2">
                                    <table class="w-100">
                                        <tr>
                                            <td>
                                                <div class="position-relative">
                                                    <i v-if="form.rehab" style="top: 32%;left: 10px;z-index: 999" class="position-absolute pi pi-dollar text-xl"></i>
                                                    <span class="p-float-label">
                                                        <InputText class="w-full text-2xl pl-5" style="border-radius: 1rem !important;" id="rehab" v-model="form.rehab" />
                                                        <label for="rehab">Rehab Cost</label>
                                                    </span>
                                                </div>

                                                <div class="w-full text-center mt-4" style="display: flex;flex-direction: column;gap: 1rem;">
                                                    <div class="w-100">
                                                        <ul class="position-relative w-100 single-line mt-3">
                                                            <li></li>
                                                        </ul>
                                                    </div>

                                                    <strong class="line-total">{{Number(total2).toLocaleString()}} % ARV</strong>
                                                </div>
                                            </td>

                                            <td class="px-5" style="vertical-align: initial;">
                                                <table class="mt-4">
                                                    <tr>
                                                        <td><i class="pi pi-times text-xl"></i></td>
                                                    </tr>
                                                </table>
                                            </td>

                                            <td>
                                                <div class="position-relative">
                                                    <i v-if="form.wholesale" style="top: 32%;left: 10px;z-index: 999" class="position-absolute pi pi-dollar text-xl"></i>
                                                    <span class="p-float-label">
                                                        <InputText class="w-full text-2xl pl-5" style="border-radius: 1rem !important;" v-model="form.wholesale" />
                                                        <label for="wholesale">Wholesale Fee</label>
                                                    </span>
                                                </div>

                                                <div class="w-full text-center mt-4" style="display: flex;flex-direction: column;gap: 1rem;">
                                                    <div class="w-100">
                                                        <ul class="position-relative w-100 single-line mt-3">
                                                            <li></li>
                                                        </ul>
                                                    </div>

                                                    <strong class="line-total">{{Number(wholesale_arv_percentage).toLocaleString()}} % ARV</strong>
                                                </div>
                                            </td>

                                            <td class="px-5" style="vertical-align: initial;">
                                                <table class="mt-4">
                                                    <tr>
                                                        <td><i class="text-xl fa-solid fa-equals"></i></td>
                                                    </tr>
                                                </table>
                                            </td>

                                            <td>
                                                <span class="p-float-label">
                                                    <InputText class="w-full text-2xl text-center p-inputwrapper-filled" style="border-radius: 1rem !important;" id="max_allowable_offer" readonly :value="'$'+Number(maximum_allowable_offer).toLocaleString()" />
                                                    <label for="max_allowable_offer">Max Allowable Offer</label>
                                                </span>

                                                <div class="w-full text-center mt-4" style="display: flex;flex-direction: column;gap: 1rem;">
                                                    <div class="w-100">
                                                        <ul class="position-relative w-100 single-line mt-3">
                                                            <li></li>
                                                        </ul>
                                                    </div>

                                                    <strong class="line-total">{{Number(maximum_allowable_offer_arv).toLocaleString()}} % ARV</strong>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
</template>

<style scoped>
.p-button-secondary {
    color: #6c757d!important;
}
.p-inputtext {
    border-color: rgba(145,158,171,0.32)!important;
}
ul {list-style: none; }
.single-line::before {
    content: '';
    position: absolute;
    top: 0;
    left: 5%;
    border-bottom: 2px solid #E6EAED;
    width: 90%;
    height: 1px;
}

.single-line li::before {
    content: '';
    position: absolute;
    top: -10px;
    left: 5%;
    border-left: 2px solid #E6EAED;
    height: 10px;
}

.single-line li::after {
    content: '';
    position: absolute;
    top: -10px;
    right: 5%;
    border-left: 2px solid #E6EAED;
    height: 10px;
}

.line-total {
    font-size: 16px;
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

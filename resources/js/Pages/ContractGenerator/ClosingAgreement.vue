<template>
    <Head>
        <title>Closing Agreement</title>
        <meta property="og:site_name" content="DealHunter">
        <meta property="og:title" content="Closing Agreement">
        <meta property="og:description" content="Try Out Our Closing Agreement">
        <meta property="og:image" content="/images/closing_agreement.jpg">
        <meta property="og:url" content="{{route('contracts.closing')}}">
    </Head>

    <AuthenticatedLayout class="px-0">
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
                            Closing Agreement
                        </div>
                    </div>
                    <div class="col">
                        <div class="d-flex justify-content-end">
                            <ShareNetwork
                                @close="saveCount"
                                network="facebook"
                                url="http://dealhunter.ai/contracts/closing-agreement"
                                title="Closing Agreement"
                                description="Try Out Our Closing Agreement"
                                quote="Try Out Our Closing Agreement"
                                hashtags="real_estate,closing_agreement"
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
        <!-- Header End -->

        <div class="col-12 my-5 px-0">
            <form>
                <div class="row mx-auto">
                    <!-- Date Picker -->
                    <div class="col-4 mx-auto mb-4">
                        <span class="u_input_label w-100">
                            <input
                                :class="{'p-invalid': form.errors.date}"
                                v-model="form.date"
                                required
                                name="date"
                                type="date"
                                class="w-full py-3 rounded border-grey border-1 px-3 text-2xl u_input_text"
                                data-placeholder="mm/dd/yyyy" aria-required="true" />
                            <label for="date">Date</label>
                        </span>
                    </div>
                    <!-- Date Picker -->
                    <!-- Time -->
                    <div class="col-4 mx-auto mb-4">
                        <span class="u_input_label w-100">
                            <input type="time"
                                :class="{'p-invalid': form.errors.time}"
                                v-model="form.time"
                                required
                            class="w-full py-3 rounded border-grey border-1 px-3 text-2xl" autofocus />
                            <label for="time">Time</label>
                        </span>
                    </div>
                    <!-- Time -->
                    <!-- Location -->
                    <div class="col-4 mx-auto mb-4">
                        <span class="u_input_label w-100">
                            <input

                                :class="{'p-invalid': form.errors.location}"
                                v-model="form.location"
                                required
                                type="text" class="w-full py-3 rounded border-grey border-1 px-3 text-2xl"
                                placeholder="Title Co or Attorney" autofocus />
                            <label for="text">Location</label>
                        </span>
                    </div>
                    <!-- Location -->
                    <!-- Propert Address -->
                    <div class="col-12 mb-4">
                        <span class="u_input_label w-100">
                            <input
                                :class="{'p-invalid': form.errors.property_address}"
                                v-model="form.property_address"
                                required
                                type="text" name="address" class="w-full py-3 rounded border-1 px-3 text-2xl"
                                placeholder="123 Main St, Jackson, AL 2334435" />
                            <label for="address">Property Address</label>
                        </span>
                    </div>
                    <!-- Propert Address -->
                    <!-- Sales Price -->
                    <div class="col-4 mb-4">
                        <span class="u_input_label sale_prc_input position-relative w-100">
                            <input
                                type="number"
                                :class="{'p-invalid': form.errors.sale_price}"
                                v-model="form.sale_price"
                                required
                                name="" class="w-full py-3 rounded border-1 ps-5 pe-3 text-2xl"
                                placeholder="105,000.00" />
                            <label for="address">Sales Price</label>
                        </span>
                    </div>
                    <!-- Sales Price -->

                    <!-- Parties Section Start -->
                    <h4>Parties</h4>
                    <!-- Seller Name -->
                    <div class="col-12 mb-4">
                        <span class="u_input_label w-100">
                            <input
                                :class="{'p-invalid': form.errors.seller_name}"
                                v-model="form.seller_name"
                                type="text" name="seller_name" class="w-full py-3 rounded border-1 px-3 text-2xl"
                                placeholder="Seller Name" required />
                            <label for="seller_name">
                                Name on Seller’s Contract
                            </label>
                        </span>
                    </div>
                    <!-- Seller Name -->
                    <!-- Buyer Name -->
                    <div class="col-12 mb-4">
                        <span class="u_input_label w-100">
                            <input
                                :class="{'p-invalid': form.errors.buyer_name}"
                                v-model="form.buyer_name"
                                type="text" name="buyer_name" class="w-full py-3 rounded border-1 px-3 text-2xl"
                                placeholder="Seller Name" required />
                            <label for="seller_name">
                                Name on Buyer's Contract
                            </label>
                        </span>
                    </div>
                    <!-- Buyer Name -->
                    <!-- Parties Section Start -->

                    <!-- Assignment Fee Section Start -->
                    <h4>Assignment Fee</h4>
                    <!-- Sales Price -->
                    <div class="row" v-for="(index) in form.assignment_fee.length" v-bind:key="index">
                        <div class="col-4 mb-4">
                            <span class="u_input_label sale_prc_input position-relative w-100">
                                <input
                                    :class="{'p-invalid': form.errors.assignment_fee}"
                                    v-model="form.assignment_fee[index-1]"
                                    type="number" name="salesprice" class="w-full py-3 rounded border-1 ps-5 pe-3 text-2xl"
                                    placeholder="12,000.00"  required />
                                <label for="salespricet">Sales Price</label>
                            </span>
                        </div>
                    </div>
                    <!-- <div class="col-4 mb-4">
                        <span class="u_input_label sale_prc_input position-relative w-100">
                            <input
                                :class="{'p-invalid': form.errors.assignment_fee}"
                                v-model="form.assignment_fee"
                                type="number" name="salesprice" class="w-full py-3 rounded border-1 ps-5 pe-3 text-2xl"
                                placeholder="12,000.00"  required />
                            <label for="salespricet">Sales Price</label>
                        </span>
                    </div> -->
                    <!-- Sales Price -->
                    <!-- Add & Remove Button -->
                    <div class="d-flex mb-4">
                        <Button @click="addAssignmentRow" class="bg-transparent border border-danger text-danger u_ad_rm_btn me-3">
                            <svg width="14" height="13" viewBox="0 0 14 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M7 0.5V12.5M13 6.5H1" stroke="#DB0F19" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg> &nbsp;
                            Add
                        </Button>
                        <Button @click="deleteAssignmentRow" v-if="form.assignment_fee.length > 1" class="bg-transparent border border-danger text-danger u_ad_rm_btn">
                            <svg width="14" height="1" viewBox="0 0 14 1" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M13 0.5H1" stroke="#DB0F19" stroke-linecap="round" stroke-linejoin="round" />
                            </svg> &nbsp;
                            Remove
                        </Button>
                    </div>
                    <!-- Add & Remove Button -->
                    <!-- Earnest Deposit -->
                    <div class="col-4 mb-4">
                        <span class="u_input_label sale_prc_input position-relative w-100">
                            <input :class="{'p-invalid': form.errors.earnest_deposit}"
                                v-model="form.earnest_deposit" type="number" name="earnest_deposit"
                                class="w-full py-3 rounded border-1 ps-5 pe-3 text-2xl" placeholder="1,000.00"
                                 required />
                            <label for="earnest_deposit">Earnest Deposit</label>
                        </span>
                    </div>
                    <!-- Earnest Deposit -->
                    <!-- Closing Cost -->
                    <div class="col-12 mb-4">
                        <span class="u_input_label w-100">
                            <input :class="{'p-invalid': form.errors.closing_cost}"
                                v-model="form.closing_cost" type="text" name="closing_cost" class="w-full py-3 rounded border-1 px-3 text-2xl"
                                placeholder="Buyer will pay all 100% closing cost minus any unpaid taxes, mortgages or liens"
                                 required />
                            <label for="seller_name">
                                Closing Cost
                            </label>
                        </span>
                    </div>
                    <!-- Closing Cost -->
                    <!-- Additional Instructions -->
                    <div class="col-12 mb-4">
                        <span class="u_input_label w-100">
                            <input :class="{'p-invalid': form.errors.additional_instructions}"
                                v-model="form.additional_instructions" type="text" name="additional_instructions" class="w-full py-3 rounded border-1 px-3 text-2xl"
                                placeholder="Contact me with any questions or concerns 205-XXX-XXXX" required />
                            <label for="seller_name">
                                Additional Instructions
                            </label>
                        </span>
                    </div>
                    <!-- Additional Instructions -->
                    <!-- Assignment Fee Section End -->

                    <!-- Generate Closing Agreement -->
                    <div>
                        <Button
                            :disabled="form.processing" @click="generatePdf"
                            class="bg-transparent border border-danger text-danger u_ad_rm_btn">
                            <svg width="14" height="15" viewBox="0 0 14 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path
                                d="M13.7656 3.19711H11.5826C11.4649 3.19711 11.3647 3.10556 11.3647 2.97928V0.778815C11.3647 0.661115 11.2688 0.560981 11.1469 0.560981L4.40214 0.556641C4.00565 0.556641 3.6701 0.822426 3.56119 1.18411L3.52637 13.6282C3.52637 14.1074 3.91852 14.4996 4.3978 14.4996H13.1121C13.5913 14.4996 13.9835 14.1074 13.9835 13.6282V3.41499C13.9835 3.29729 13.8876 3.19716 13.7657 3.19716L13.7656 3.19711ZM5.6526 4.0206H8.26691C8.50655 4.0206 8.70259 4.22097 8.70259 4.45628C8.70259 4.69592 8.50656 4.89195 8.26691 4.89195H5.6526C5.41296 4.89195 5.21693 4.69592 5.21693 4.45628C5.21693 4.22098 5.41296 4.0206 5.6526 4.0206ZM11.7656 10.1075H5.66557C5.42593 10.1075 5.22989 9.91142 5.22989 9.67178C5.22989 9.43214 5.42592 9.2361 5.66557 9.2361H11.7656C12.0053 9.2361 12.2013 9.43213 12.2013 9.67178C12.2014 9.91141 12.0053 10.1075 11.7656 10.1075ZM11.7744 8.36891H5.67435C5.43471 8.36891 5.23867 8.17722 5.23867 7.93323C5.23867 7.69359 5.43471 7.49756 5.67435 7.49756H11.7744C12.0141 7.49756 12.2101 7.69359 12.2101 7.93323C12.2101 8.17721 12.0141 8.36891 11.7744 8.36891ZM11.7788 6.63481H5.67869C5.43905 6.63481 5.24301 6.43878 5.24301 6.19913C5.24301 5.96384 5.43905 5.76346 5.67869 5.76346H11.7788C12.0227 5.76346 12.2144 5.96383 12.2144 6.19913C12.2144 6.43867 12.0227 6.63481 11.7788 6.63481Z"
                                fill="#DB0F19" />
                                <path
                                d="M12.3463 2.29577H13.8242C13.928 2.29577 13.9802 2.17043 13.9072 2.09665L12.4292 0.60611C12.3558 0.532017 12.2295 0.583996 12.2295 0.688367V2.1789C12.2294 2.24338 12.2817 2.29577 12.3463 2.29577Z"
                                fill="#DB0F19" />
                                <path
                                d="M1.65453 4.88365L0.0719371 4.88086C0.0359752 4.88076 0.00683594 4.91 0.00683594 4.94606L0.0190297 11.8138C0.019133 11.85 0.0483781 11.8793 0.0843399 11.8794L1.66694 11.8822C1.7029 11.8824 1.73204 11.8531 1.73204 11.817L1.71984 4.94927C1.71974 4.9132 1.6905 4.88386 1.65453 4.88375V4.88365Z"
                                fill="#DB0F19" />
                                <path
                                d="M1.62985 12.7693L0.124741 12.7666C0.0769992 12.7665 0.0459975 12.818 0.0674916 12.8618L0.822786 14.4065C0.846553 14.455 0.914031 14.4551 0.937697 14.4067L1.68752 12.8647C1.7087 12.8211 1.6776 12.7694 1.62985 12.7693Z"
                                fill="#DB0F19" />
                                <path
                                d="M2.1865 1.77394L1.71363 1.77311L1.71291 1.36019C1.71208 0.885466 1.3284 0.500848 0.854999 0.500001H0.854895C0.38245 0.499175 -0.000845135 0.883376 1.39953e-06 1.35717L0.00454842 3.92923C0.00465175 3.96457 0.0331719 3.9932 0.0684115 3.9933L1.65381 3.99609C1.68895 3.9962 1.71757 3.96757 1.71747 3.93233L1.71519 2.65137L2.18806 2.65219L2.19354 5.72617C2.19395 5.96871 2.38585 6.16555 2.6226 6.16608C2.85924 6.16649 3.05052 5.97026 3.04999 5.72773L3.04452 2.65376C3.04369 2.16941 2.65866 1.77476 2.1865 1.77394Z"
                                fill="#DB0F19" />
                            </svg>
                            &nbsp;
                            Generate Closing Agreement
                        </Button>
                    </div>
                    <!-- Generate Closing Agreement -->
                </div>
            </form>
        </div>

    </AuthenticatedLayout>
</template>

<script>
import AuthenticatedLayout from "../../Layouts/AuthenticatedLayout.vue"
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';
import axios from 'axios';
import "flag-icons/css/flag-icons.min.css";

export default {
    name: "ClosingAgreement",
    props: ['count'],
    data() {
        return {
            agreeTerms: false,
            sharing_count: 0,
            form: useForm({
                date: null,
                time: null,
                location: null,
                property_address: null,
                sale_price: null,
                seller_name: null,
                buyer_name: null,
                assignment_fee: [0],
                earnest_deposit: null,
                closing_cost: null,
                additional_instructions: null
            }),
        }
    },
    mounted: function () {
        let vm = this;

        vm.$nextTick(function () {
            this.sharing_count = vm.count;
        });
    },
    methods: {
        async generatePdf() {
            this.form.clearErrors()
            const res = await axios.post(route('contracts.closing.pdf'), this.form);
            this.form.reset();
            if (res.status) {
                this.$toast.add({severity: 'success', summary: 'Success', detail: 'PDF generated successfully', life: 3000});
                window.open(res.pdf_path, '_blank');
            }
        },
        async saveCount() {
            await axios.post(route('contracts.add.share.count'), {type: 'closing'});
            this.sharing_count += 1;
        },
        addAssignmentRow () {
            this.form.assignment_fee.push(0);
        },
        deleteAssignmentRow () {
            this.form.assignment_fee.pop();
        }
    },

    components: {
        AuthenticatedLayout, Head, Link
    }
};
</script>

<style>
/* Usman's CSS Start */

.u_hdr_btn {
    font-size: 13px;
    font-weight: 500;
    font-family: "Nunito";
    letter-spacing: 2px;
}

input[type="date"]::before {
    content: attr(data-placeholder);
    width: 100%;
    font-size: 14px;
    font-weight: 400;
}

input[type="date"]:focus::before,
input[type="date"]:valid::before {
    display: none
}

.u_input_label {
    position: relative;
}

.u_input_label input~label {
    top: -2rem !important;
    background-color: #ffffff;
    padding: 2px 4px;
    margin-left: -4px;
    margin-top: 0;
    position: absolute;
    left: 1rem;
}

.u_input_label input::placeholder,
.u_input_label input,
.u_ad_rm_btn {
    font-size: 14px !important;
    font-weight: 400;
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

span.sale_prc_input::before {
    content: "$";
    position: absolute;
    padding: 12.5px 14px;
    width: auto;
    height: auto;
    background: #FAFAFA;
    border-radius: 7px 0px 0px 7px;
    z-index: 0;
    font-family: 'Nunito';
    font-style: normal;
    font-weight: 400;
    font-size: 16px;
    left: 1px;
    color: #101136;
    order: 0;
    top: -15px;
}

/* Usman's CSS End */

.coun .p-dropdown {
    width: 5rem !important;
    flex-grow: 0;
}

.p-float-label input:focus~label.move-left,
.p-float-label input.p-filled~label.move-left {
    margin-left: -5rem;
}

.agreeTerms {
    height: 20px;
    width: 20px;
    border: 1px solid #DB0F19;
}

.agreeTerms:checked {
    background-color: #DB0F19;
    border: 1px solid #DB0F19;
}

.com-title {
    font-family: 'Nunito';
    font-style: normal;
    font-weight: 500;
    font-size: 18px;
    line-height: 12px;
    /* identical to box height, or 67% */


    /* Text 1 */

    color: #000000;
}

.com-sub-title {
    font-family: 'Nunito';
    font-style: normal;
    font-weight: 400;
    font-size: 16px;
    line-height: 24px;
    /* identical to box height, or 150% */


    /* Text 1 */

    color: #000000;
}

.list-button {
    width: fit-content;
    /* Gray */

    background: #f1eeee;
    border-radius: 5px;
    font-family: 'Nunito';
    font-style: normal;
    font-weight: 600;
    font-size: 10px;
    line-height: 14px;
    /* identical to box height */


    /* Text 1 */

    color: #000000;
}

.list-button:hover {
    background: #f1eeee;
    border-radius: 5px;
    font-family: 'Nunito';
    font-style: normal;
    font-weight: 600;
    font-size: 10px;
    line-height: 14px;
    /* identical to box height */
    /* Text 1 */

    color: #000000;
}


textarea:not(:placeholder-shown)~label {
    top: -7px;
    background: white;
}




.p-button-danger-shadow {
    background: rgba(219, 15, 25, 0.1);
    border-radius: 8px;
    /* Primary */

    color: #DB0F19 !important;

}

.textlabel:not(:focus)::placeholder {
    color: transparent;
}



.p-float-label .p-dropdown .p-placeholder {
    opacity: 1 !important;
}




.cred-text {
    padding: 10px 28px;
    font-family: 'Nunito';
    font-style: normal;
    font-weight: 400;
    font-size: 12px;
    line-height: 16px;

    /* Text 2 */

    color: #575A7B;

    text-align: center;
}

.topup-label {
    /* Primary */

    background: #db0f1924;
    /* opacity: 0.1; */
    border-radius: 8px;
    padding: 10px 28px;

}

.topup-label span {
    font-family: 'Nunito';
    font-style: normal;
    font-weight: 500;
    font-size: 14px;
    line-height: 19px;
    /* identical to box height */


    /* Primary */

    color: #DB0F19;
}

.cred-con {
    background: #FFFFFF;
    border: 1px solid #EBEBEB;
    border-radius: 10px;
    padding: 7px;
    /* margin-left: auto; */
}
.cred-con a{
    font-weight: 700;
}
.p-paginator .p-paginator-pages .p-paginator-page.p-highlight {
    background: rgba(219, 15, 25, 0.12);
    border-color: rgba(219, 15, 25, 0.12);
    color: rgba(219, 15, 25, 1);
    font-weight: bold;
}

.p-dropdown-panel .p-dropdown-items .p-dropdown-item.p-highlight {
    color: rgba(219, 15, 25, 1);
    background: rgba(219, 15, 25, 0.12);
}

.p-dialog-header {
    padding-bottom: 0.5rem !important;
}

.no-left-border {
    border-left: 0 !important;
}

.no-right-border {
    border-right: 0 !important;
}

.s-border-cu {
    border-top: 1px solid !important;
}

.p-button.p-button-grey.p-button-outlined {
    background-color: transparent;
    color: #575A7B;
    border: 0 none;
    box-shadow: inset 0 0 0 1px var(--surface-border) !important;
}

.p-divider.p-divider-horizontal:before {
    border-top: 1px rgba(0, 0, 0, 0.38) !important;
    position: absolute;
    display: block;
    top: 50%;
    left: 0;
    width: 100%;
    content: '';
}

.p-fileupload-choose.p-button-danger:hover {
    background-color: #D32F2F;
}

.p-multiselect-panel .p-multiselect-items .p-multiselect-item.p-highlight {
    color: inherit;
    background: rgba(219, 15, 25, 0.12);
}

.p-multiselect-item>.p-checkbox {
    display: none;
}

.p-checkbox .p-checkbox-box.p-highlight:not(.p-disabled).p-focus {
    border-color: rgba(219, 15, 25, 1);
    background: rgba(219, 15, 25, 1);
}

.hover-links:hover {
    cursor: pointer;
    color: rgba(219, 15, 25, 1);
}

.p-paginator {
    position: relative;
    justify-content: end !important;
}

.p-paginator-current {
    position: absolute !important;
    left: 0;
}

.top-bar-container-c {
    margin-top: 0;
    padding-top: 15px;
    padding-bottom: 10px !important;
}

</style>

<template>
    <Head>
        <title>Closing Agreement</title>
        <meta property="og:site_name" content="DealHunter">
        <meta property="og:title" content="Purchase Sale Agreement">
        <meta property="og:description" content="Try Out Our Purchase Sale Agreement">
        <meta property="og:image" content="/images/purchase_sale_agreement.jpg">
        <meta property="og:url" content="{{route('contracts.purchase.sale')}}">
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
                            Purchase & Sale Agreement
                        </div>
                    </div>
                    <div class="col">
                        <div class="d-flex justify-content-end">
                            <ShareNetwork
                                @close="saveCount"
                                network="facebook"
                                url="http://dealhunter.ai/contracts/purchase-sale-agreement"
                                title="Purchase Sale Agreement"
                                description="Try Out Our Purchase Sale Agreement"
                                quote="Try Out Our Purchase Sale Agreement"
                                hashtags="real_estate,purchase_sale_agreement"
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
                <div class="row mx-auto align-items-center">
                    <h4>
                        This Agreement is Made On The Date Of:
                    </h4>
                    <!-- Day  Dropdown -->
                    <div class="col-4 mx-auto mb-4">
                        <span class="u_input_label w-100">
                            <input
                                type="number"
                                :class="{'p-invalid': form.errors.day}"
                                v-model="form.day"
                                required
                                class="w-full py-3 rounded border-grey border-1 px-3 text-2xl u_input_text"
                                data-placeholder="" />
                            <label for="day">
                                Day
                            </label>
                        </span>
                    </div>
                    <!-- Day Dropdown -->
                    <!-- Month  Dropdown -->
                    <div class="col-4 mx-auto mb-4">
                        <span class="u_input_label w-100">
                            <input
                                type="number"
                                :class="{'p-invalid': form.errors.month}"
                                v-model="form.month"
                                required
                                class="w-full py-3 rounded border-grey border-1 px-3 text-2xl u_input_text"
                                data-placeholder="" name="month" />
                            <label for="month">
                                Month
                            </label>
                        </span>
                    </div>
                    <!-- Month Dropdown -->
                    <!-- Year  Dropdown -->
                    <div class="col-4 mx-auto mb-4">
                        <span class="u_input_label w-100">
                            <input
                                :class="{'p-invalid': form.errors.year}"
                                v-model="form.year"
                                required
                                class="w-full py-3 rounded border-grey border-1 px-3 text-2xl u_input_text"
                                data-placeholder="" name="year"
                            />
                            <label for="ee">
                                Year
                            </label>
                        </span>
                    </div>
                    <!-- Year Dropdown -->

                    <!-- Between Sellers Section -->
                    <h4>
                        Between Seller(s)
                    </h4>

                    <div class="col-6 mx-auto mb-4">
                        <span class="u_input_label w-100">
                            <input
                                :class="{'p-invalid': form.errors.between_seller}"
                                v-model="form.between_seller"
                                type="text" name="between_seller"
                                class="w-full py-3 rounded border-grey border-1 px-3 text-2xl" placeholder="Seller" required autofocus />
                            <label for="between_seller">Between Seller(s)</label>
                        </span>
                    </div>
                    <div class="col-6 mx-auto mb-4">
                        <span class="u_input_label w-100">
                            <input
                                :class="{'p-invalid': form.errors.social_security_number}"
                                v-model="form.social_security_number"
                                type="text" name="socialsecurity"
                                class="w-full py-3 rounded border-grey border-1 px-3 text-2xl" placeholder="Social Security"
                                required autofocus />
                            <label for="socialsecurity">Social Security #</label>
                        </span>
                    </div>
                    <div class="col-12 mx-auto mb-4">
                        <span class="u_input_label w-100">
                            <input
                                :class="{'p-invalid': form.errors.between_buyer}"
                                v-model="form.between_buyer"
                                type="text" name="andbuyer"
                                class="w-full py-3 rounded border-grey border-1 px-3 text-2xl" placeholder="Buyer"
                                 required autofocus />
                            <label for="andbuyer">And Buyer</label>
                        </span>
                    </div>
                    <p class="col-12 u_btw_slr_cntnt">
                        And or assignees. Seller agrees to sell and buyer agrees to buy the following described real
                        property together with all improvements and fixtures and the personal property described below:
                    </p>

                    <!-- Year  Dropdown -->
                    <div class="col-12 mx-auto mb-4">
                        <span class="u_input_label w-100">
                            <input
                                :class="{'p-invalid': form.errors.street_address}"
                                v-model="form.street_address"
                                required
                                class="w-full py-3 rounded border-grey border-1 px-3 text-2xl u_input_text"
                                data-placeholder="" name="streetaddress" />

                            <label for="streetaddress">
                                Street Address
                            </label>
                        </span>
                    </div>
                    <!-- Year Dropdown -->
                    <!-- Between Sellers Section -->

                    <!-- City -->
                    <div class="col-4 mx-auto mb-4">
                        <span class="u_input_label w-100">
                            <input
                                :class="{'p-invalid': form.errors.city}"
                                v-model="form.city"
                                required
                                type="text" class="w-full py-3 rounded border-grey border-1 px-3 text-2xl"
                                placeholder="City" autofocus />
                            <label for="city">City*</label>
                        </span>
                    </div>
                    <!-- City -->
                    <!-- State -->
                    <div class="col-4 mx-auto mb-4">
                        <span class="u_input_label w-100">
                            <input
                                :class="{'p-invalid': form.errors.state}"
                                v-model="form.state"
                                required
                                type="text" class="w-full py-3 rounded border-grey border-1 px-3 text-2xl"
                                placeholder="State" autofocus />
                            <label for="state">State*</label>
                        </span>
                    </div>
                    <!-- State -->
                    <!-- Zip -->
                    <div class="col-4 mx-auto mb-4">
                        <span class="u_input_label w-100">
                            <input
                                :class="{'p-invalid': form.errors.zip}"
                                v-model="form.zip"
                                required
                                type="text" class="w-full py-3 rounded border-grey border-1 px-3 text-2xl"
                                placeholder="Zip" autofocus />
                            <label for="zip">Zip*</label>
                        </span>
                    </div>
                    <!-- Zip -->
                    <!-- Country -->
                    <div class="col-12 mb-4">
                        <span class="u_input_label w-100">
                            <input
                                :class="{'p-invalid': form.errors.country}"
                                v-model="form.country"
                                required
                                type="text" name="Country" class="w-full py-3 rounded border-1 px-3 text-2xl"
                                placeholder="Country" />
                            <label for="country">Country</label>
                        </span>
                    </div>
                    <!-- Country -->
                    <!-- Personal Property Included -->
                    <div class="col-12 mb-4">
                        <span class="u_input_label w-100">
                            <input
                                :class="{'p-invalid': form.errors.personal_property_included}"
                                v-model="form.personal_property_included"
                                required
                                type="text" name="personal_property" class="w-full py-3 rounded border-1 px-3 text-2xl"
                                placeholder="Personal Property" />
                            <label for="personal_property">Personal Property Included</label>
                        </span>
                    </div>
                    <!-- Personal Property Included -->
                    <!-- Earn Money Deposit $ -->
                    <div class="col-12 mb-4">
                        <span class="u_input_label w-100">
                            <input
                                :class="{'p-invalid': form.errors.earn_money_deposit}"
                                v-model="form.earn_money_deposit"
                                required
                                type="text" name="earn_money" class="w-full py-3 rounded border-1 px-3 text-2xl"
                                placeholder="Earnest Money Deposit" />
                            <label for="earn_money">Earn Money Deposit $</label>
                        </span>
                    </div>

                    <div class="col-12 mb-4">
                        <span class="u_input_label w-100">
                            <input
                                :class="{'p-invalid': form.errors.cash_to_seller}"
                                v-model="form.cash_to_seller"
                                required
                                type="text" name="earn_money" class="w-full py-3 rounded border-1 px-3 text-2xl"
                                placeholder="Cash to Seller At Closing" />
                            <label for="earn_money">Earn Money Deposit $</label>
                        </span>
                    </div>
                    <!-- Earn Money Deposit $ -->
                    <!-- Existing Loans & Liens $ -->
                    <div class="col-12 mb-4">
                        <span class="u_input_label w-100">
                            <input
                                :class="{'p-invalid': form.errors.existing_loans}"
                                v-model="form.existing_loans"
                                required
                                type="text" name="exist_loans" class="w-full py-3 rounded border-1 px-3 text-2xl"
                                placeholder="Existing Loans & Liens" />
                            <label for="exist_loan">Existing Loans & Liens $</label>
                        </span>
                    </div>
                    <!-- Existing Loans & Liens $ -->
                    <!-- New Loans To Seller At Closing $ -->
                    <div class="col-12 mb-4">
                        <span class="u_input_label w-100">
                            <input
                                :class="{'p-invalid': form.errors.new_loans_to_seller}"
                                v-model="form.new_loans_to_seller"
                                required
                                type="text" name="new_loans" class="w-full py-3 rounded border-1 px-3 text-2xl"
                                placeholder="New Loans To Seller At Closing" />
                            <label for="new_loan">New Loans To Seller At Closing $</label>
                        </span>
                    </div>
                    <!-- New Loans To Seller At Closing $ -->
                    <!-- Purchase Price -->
                    <div class="col-12 mb-4">
                        <span class="u_input_label sale_prc_input position-relative w-100">
                            <input
                                :class="{'p-invalid': form.errors.sale_price}"
                                v-model="form.sale_price"
                                required
                                type="text" name="purchase_price" class="w-full py-3 rounded border-1 ps-5 pe-3 text-2xl"
                                placeholder="Purchase Price" />
                            <label for="purchase_price">Sales Price</label>
                        </span>
                    </div>
                    <!-- Purchase Price -->
                    <p class="col-12 u_btw_slr_cntnt">
                        The purchase price to be paid as follows:
                    </p>

                    <p class="col-12 u_btw_slr_cntnt">
                        <strong>
                            1. EARNEST MONEY
                        </strong> is not refundable.
                    </p>

                    <p class="col-4 u_btw_slr_cntnt align-items-center">
                        <strong>
                            2. THE BALANCE DUE SELLER
                        </strong>
                    </p>
                    <!-- In Amount Of -->
                    <div class="col-4 mb-4">
                        <span class="u_input_label sale_prc_input position-relative w-100">
                            <input
                                :class="{'p-invalid': form.errors.balace_due_seller}"
                                v-model="form.balace_due_seller"
                                required
                                type="text" name="Balance_Due" class="w-full py-3 rounded border-1 ps-5 pe-3 text-2xl"
                                placeholder="Balance Due Seller" />
                            <label for="Balance_Due">In Amount Of</label>
                        </span>
                    </div>
                    <!-- In Amount Of -->

                    <!-- Shall be Paid as Follows: -->
                    <div class="col-4 mb-4">
                        <span class="u_input_label sale_prc_input position-relative w-100">
                            <input
                                :class="{'p-invalid': form.errors.amount_to_be_paid}"
                                v-model="form.amount_to_be_paid"
                                required
                                type="text" name="Paid_as_Follows"
                                class="w-full py-3 rounded border-1 ps-5 pe-3 text-2xl" placeholder="Amount"
                                />
                            <label for="Paid_as_Follows">Shall be Paid as Follows:</label>
                        </span>
                    </div>
                    <!-- Shall be Paid as Follows: -->

                    <p class="col-12 u_btw_slr_cntnt">
                        <strong>
                            3. PRORATIONS, IMPOUNDS & SECURITY DEPOSITS:
                        </strong> Loan interest, property taxes, insurance, and rents
                        shall be prorated as of the date of closing. All security deposits shall be transferred to buyer
                        at closing. All impound accounts for taxes and insurance are included in the purchase price and
                        shall be transferred to buyer at closing. Any shortage in these accounts shall be charged to
                        seller at closing.
                    </p>

                    <p class="col-12 u_btw_slr_cntnt">
                        <strong>
                            4. BUYER WILL PAY ALL CLOSING COST MINUS ANY UNPAID TAXES, MORTGAGES OR LIENS
                        </strong>
                    </p>

                    <p class="col-4 u_btw_slr_cntnt">
                        <strong>
                            5. CLOSING DATE AND TRANSFER OF TITLE:
                        </strong>
                    </p>

                    <!-- This transaction shall close on or before -->
                    <div class="col-4 mb-4">
                        <span class="u_input_label w-100">
                            <input
                                :class="{'p-invalid': form.errors.close_day_month}"
                                v-model="form.close_day_month"
                                required
                                type="text" name="close_day_month" class="w-full py-3 rounded border-1 px-3 text-2xl"
                                placeholder="Day & Month" />
                            <label for="close_day_month">
                                This transaction shall close on or before
                            </label>
                        </span>
                    </div>
                    <!-- This transaction shall close on or before -->

                    <!-- Losing Year -->
                    <div class="col-4 mb-4">
                        <span class="u_input_label w-100">
                            <input
                                :class="{'p-invalid': form.errors.losing_year}"
                                v-model="form.losing_year"
                                required
                                type="text" name="losing_year" class="w-full py-3 rounded border-1 px-3 text-2xl"
                                placeholder="2024" />
                            <label for="losing_year">
                                Losing Year
                            </label>
                        </span>
                    </div>
                    <!-- Losing Year -->

                    <!-- Closing Will Be Held At -->
                    <div class="col-4 mb-4">
                        <span class="u_input_label w-100">
                            <input
                                :class="{'p-invalid': form.errors.closing_held}"
                                v-model="form.closing_held"
                                required
                                type="text" name="closing_held" class="w-full py-3 rounded border-1 px-3 text-2xl"
                                placeholder="2024" />
                            <label for="closing_held">
                                Closing Will Be Held At
                            </label>
                        </span>
                    </div>
                    <!-- Closing Will Be Held At -->

                    <p class="col-8 u_btw_slr_cntnt">
                        and Seller(s) agree to transfer marketable title free and clear of all encumbrances except
                    </p>

                    <p class="col-12 u_btw_slr_cntnt">
                        those listed and pay any required state taxes or stamps required to record deed and mortgage. Seller
                        agrees to furnish title insurance in the amount of the purchase price, showing no encumbrances or
                        exceptions other than previously noted.
                    </p>

                    <p class="col-12 u_btw_slr_cntnt">
                        <strong>
                            6. DAMAGE TO PROPERTY:
                        </strong> Seller shall maintain property in its current condition and keep it
                        insured against all loss until closing in the event of destruction covered by insurance, buyer
                        may elect to close and collect the insurance proceeds.
                    </p>

                    <p class="col-12 u_btw_slr_cntnt">
                        <strong>
                            7. DEFAULTS:
                        </strong> If buyer defaults under this contract, any and all monies deposited by
                        buyers shall be retained by seller as full liquidated damages. If seller defaults, buyer may pursue
                        all remedies allowed by law and sellers default.
                    </p>

                    <p class="col-12 u_btw_slr_cntnt">
                        <strong>
                            8. SUCCESSORS AND ASSIGNEES:
                        </strong> The terms and conditions of this contract shall bind all
                        successors, heirs, administrators, trustees, executors and assignees of the respective parties.
                    </p>

                    <p class="col-12 u_btw_slr_cntnt">
                        <strong>
                            9. ACCESS ADVERTISING AND REPAIRS MADE BY BUYERS:
                        </strong> Sellers agree that buyers may advertise
                        property and have access during reasonable hours to show property to others. If the property is
                        vacant and in need of repairs, buyers at their expense may make repairs and improvements, and any
                        improvements made shall become the property of the seller should the buyer default,
                    </p>

                    <p class="col-12 u_btw_slr_cntnt">
                        10. The Liability shall be limited to the property itself and shall not extend beyond.
                    </p>

                    <p class="col-12 u_btw_slr_cntnt">
                        11. This contract constitutes the entire agreement between Purchaser and Seller regarding the
                        property and supercedes all prior discussions, negotiations and agreements whether oral or written.
                    </p>

                    <p class="col-12 u_btw_slr_cntnt">
                        <strong>
                            THIS IS INTENDED TO BE A LEGALLY BINDING CONTRACT, IF YOU DO NOT UNDERSTAND THE LEGAL EFFECT OF
                            ANY PART OF THIS CONTRACT, SEEK LEGAL ADVICE BEFORE SIGNING.
                        </strong>
                    </p>

                    <p class="col-2 u_btw_slr_cntnt">
                        <strong>
                            Buyer will have a
                        </strong>
                    </p>

                    <div class="col-4 mb-4">
                        <span class="u_input_label w-100">
                            <input
                                :class="{'p-invalid': form.errors.buyer_days}"
                                v-model="form.buyer_days"
                                required
                                type="text" name="Number_of_Days" class="w-full py-3 rounded border-1 px-3 text-2xl"
                                placeholder="5" />
                            <label for="Number_of_Days">
                                Number of Days
                            </label>
                        </span>
                    </div>

                    <p class="col-6 u_btw_slr_cntnt">
                        <strong>
                            day inspection period and has the right to cancel this agreement with written notice to the
                            seller
                        </strong>
                    </p>

                    <p class="col-12 u_btw_slr_cntnt">
                        <strong>
                            within the inspection period. Inspection period starts when the last party has signed this
                            agreement.
                        </strong>
                    </p>

                    <!-- Assignment Fee Section Start -->
                    <h4 class="mb-2 px-0">SELLERS:</h4>
                    <hr class="col-7 mb-5" />
                    <hr class="col-7 mb-5" />

                    <h4 class="mb-2 px-0">BUYERS:</h4>
                    <hr class="col-7 mb-5" />
                    <hr class="col-7" />

                    <!-- Generate Closing Agreement -->
                    <div class="px-0">
                        <Button :disabled="form.processing" @click="generatePdf" class="bg-transparent border rounded-2 border-danger text-danger u_ad_rm_btn">
                            <svg width="14" height="13" viewBox="0 0 14 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M7 0.5V12.5M13 6.5H1" stroke="#DB0F19" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>
                            &nbsp;
                            Generate Purchase & Sale Agreement
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
    name: "PurchaseSaleAgreement",
    props: ['count'],
    data() {
        return {
            agreeTerms: false,
            sharing_count: 0,
            form: useForm({
                day: null,
                month: null,
                year: null,
                between_seller: null,
                social_security_number: null,
                cash_to_seller: null,
                between_buyer: null,
                password_confirmation: null,
                street_address: null,
                city: null,
                state: null,
                zip: null,
                country: null,
                personal_property_included: null,
                earn_money_deposit: null,
                existing_loans: null,
                new_loans_to_seller: null,
                sale_price: null,
                balace_due_seller: null,
                amount_to_be_paid: null,
                close_day_month: null,
                losing_year: null,
                closing_held: null,
                buyer_days: null
            }),
        }
    },
    mounted: function () {
        let vm = this;

        vm.$nextTick(function () {
            console.log(vm.count)
            this.sharing_count = vm.count;
        });
    },
    methods: {
        async generatePdf() {
            this.form.clearErrors()
            const res = await axios.post(route('contracts.purchase.sale.pdf'), this.form);
            this.form.reset();
            if (res.status) {
                this.$toast.add({severity: 'success', summary: 'Success', detail: 'PDF generated successfully', life: 3000});
                window.open(res.pdf_path, '_blank');
            }
        },

        async saveCount() {
            await axios.post(route('contracts.add.share.count'), {type: 'purchase_sale_agreement'});
            this.sharing_count += 1;
        }
    },

    components: {
        AuthenticatedLayout, Head, Link
    }
};
</script>

<style>
/* Usman's CSS Start */

.u_btw_slr_cntnt {
    font-size: 18px;
    font-weight: 500;
}

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

.u_input_label select~label {
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
.u_ad_rm_btn,
.u_input_label select::placeholder,
.u_input_label select {
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

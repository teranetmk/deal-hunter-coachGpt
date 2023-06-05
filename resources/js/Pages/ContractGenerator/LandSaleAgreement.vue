<template>
    <Head>
        <title>Closing Agreement</title>
        <meta property="og:site_name" content="DealHunter">
        <meta property="og:title" content="Land Sale Agreement">
        <meta property="og:description" content="Try Out Our Land Sale Agreement">
        <meta property="og:image" content="/images/land_sale_agreement.jpg">
        <meta property="og:url" content="{{route('contracts.land.sale')}}">
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
                            Land Sale Agreement
                        </div>
                    </div>
                    <div class="col">
                        <div class="d-flex justify-content-end">
                            <ShareNetwork
                                @close="saveCount"
                                network="facebook"
                                url="http://dealhunter.ai/contracts/land-sale-agreement"
                                title="Land Sale Agreement"
                                description="Try Out Our Land Sale Agreement"
                                quote="Try Out Our Land Sale Agreement"
                                hashtags="real_estate,land_sale_agreement"
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
                    <div class="col-12 mx-auto mb-4">
                        <span class="u_input_label w-100">
                            <input
                                :class="{'p-invalid': form.errors.seller}"
                                v-model="form.seller"
                                required
                                type="text" name="seller"
                                class="w-full py-3 rounded border-grey border-1 px-3 text-2xl" placeholder="Sellers"
                                 autofocus />
                            <label for="Sellers">Seller(S)</label>
                        </span>
                    </div>
                    <div class="col-12 mx-auto mb-4">
                        <span class="u_input_label w-100">
                            <input
                                :class="{'p-invalid': form.errors.buyer}"
                                v-model="form.buyer"
                                required
                                type="text" name="buyer"
                                class="w-full py-3 rounded border-grey border-1 px-3 text-2xl" placeholder="Buyers"
                                autofocus />
                            <label for="Buyers">Buyer(S)</label>
                        </span>
                    </div>
                    <p class="col-12 u_btw_slr_cntnt">
                        The Seller and Buyer above agree to sell and buy on the terms and conditions specified below,
                    </p>

                    <p class="col-4 u_btw_slr_cntnt">
                        the properties located in the County of
                    </p>

                    <!-- Country  Dropdown -->
                    <div class="col-3 mx-auto mb-4">
                        <span class="u_input_label w-100">
                            <input
                                type="text"
                                :class="{'p-invalid': form.errors.country}"
                                v-model="form.country"
                                required
                                class="w-full py-3 rounded border-grey border-1 px-3 text-2xl u_input_text"
                                data-placeholder="Country" name="country"
                            />
                            <label for="Country">
                                Country
                            </label>
                        </span>
                    </div>
                    <!-- Country Dropdown -->

                    <!-- State  Dropdown -->
                    <div class="col-3 mx-auto mb-4">
                        <span class="u_input_label w-100">
                            <input
                                :class="{'p-invalid': form.errors.state}"
                                v-model="form.state"
                                required
                                class="w-full py-3 rounded border-grey border-1 px-3 text-2xl u_input_text"
                                data-placeholder="" name="state"
                            />
                            <label for="state">
                                State
                            </label>
                        </span>
                    </div>
                    <!-- State Dropdown -->

                    <p class="col-2 u_btw_slr_cntnt align-items-center">
                        , described as:
                    </p>

                    <p class="col-3 u_btw_slr_cntnt align-items-center">
                        ASSESSOR'S PARCEL NUMBER:
                    </p>

                    <!-- ACREAGE SIZE : -->
                    <div class="col-4 mb-4">
                        <span class="u_input_label w-100">
                            <input
                                :class="{'p-invalid': form.errors.assesstor_parcel_no}"
                                v-model="form.assesstor_parcel_no"
                                required
                                type="text" name="assessor_parcel_number"
                                class="w-full py-3 rounded border-1 px-3 text-2xl" placeholder="ASSESSOR'S PARCEL NUMBER:"
                            />
                            <label for="Assessor_Parcel_Number">ASSESSOR'S PARCEL NUMBER:</label>
                        </span>
                    </div>
                    <!-- ACREAGE SIZE : -->
                    <p class="col-2 u_btw_slr_cntnt align-items-center">
                        ACREAGE SIZE :
                    </p>

                    <!-- ACREAGE SIZE : -->
                    <div class="col-3 mb-4">
                        <span class="u_input_label w-100">
                            <input
                                :class="{'p-invalid': form.errors.acreage_size}"
                                v-model="form.acreage_size"
                                required
                                type="text" name="acreage_size" class="w-full py-3 rounded border-1 px-3 text-2xl"
                                placeholder="Acreage Size" />
                            <label for="Acreage_Size">CREAGE SIZE :</label>
                        </span>
                    </div>
                    <!-- ACREAGE SIZE : -->
                    <p class="col-3 u_btw_slr_cntnt align-items-center">
                        LEGAL DESCRIPTION:
                    </p>

                    <!-- Legal_Description -->
                    <div class="col-9 mb-4">
                        <span class="u_input_label w-100">
                            <input
                                :class="{'p-invalid': form.errors.legal_description}"
                                v-model="form.legal_description"
                                required
                                type="text" name="legal_description" class="w-full py-3 rounded border-1 px-3 text-2xl"
                                placeholder="Legal Descriptions" />
                            <label for="Legal_Description">LEGAL DESCRIPTION:</label>
                        </span>
                    </div>
                    <!-- Legal_Description -->
                    <p class="col-3 u_btw_slr_cntnt align-items-center">
                        Propery Address
                    </p>

                    <!-- Country -->
                    <div class="col-9 mb-4">
                        <span class="u_input_label w-100">
                            <input
                                :class="{'p-invalid': form.errors.property_address}"
                                v-model="form.property_address"
                                required
                                type="text" name="property_address" class="w-full py-3 rounded border-1 px-3 text-2xl"
                                placeholder="if there is an address available"/>
                            <label for="country">PROPERTY ADDRESS:</label>
                        </span>
                    </div>
                    <!-- Country -->

                    <p class="col-4 u_btw_slr_cntnt align-items-center">
                        <strong>
                            PURCHASE PRICE:
                        </strong> Buyer will pay the purchase price of
                    </p>

                    <div class="col-3 mb-4">
                        <span class="u_input_label sale_prc_input position-relative w-100">
                            <input
                                :class="{'p-invalid': form.errors.shall_be_paid_amount}"
                                v-model="form.shall_be_paid_amount"
                                required
                                type="text" name="paid_amount"
                                class="w-full py-3 rounded border-1 ps-5 pe-3 text-2xl" placeholder="Amount"
                            />
                            <label for="Paid_as_Follows">Shall be Paid as Follows:</label>
                        </span>
                    </div>

                    <p class="col-4 u_btw_slr_cntnt align-items-center">
                        to the Seller. Earnest money deposit Of
                    </p>

                    <div class="col-2 mb-4">
                        <span class="u_input_label w-100">
                            <input
                                :class="{'p-invalid': form.errors.deposit}"
                                v-model="form.deposit"
                                required
                                type="text" name="deposit" class="w-full py-3 rounded border-1 px-3 text-2xl"
                                placeholder="Deposit"/>
                        </span>
                    </div>

                    <p class="col-4 u_btw_slr_cntnt align-items-center">
                        will be deposit with title company within
                    </p>

                    <div class="col-2 mb-4">
                        <span class="u_input_label w-100">
                            <input
                                :class="{'p-invalid': form.errors.days}"
                                v-model="form.days"
                                required
                                type="text" name="days" class="w-full py-3 rounded border-1 px-3 text-2xl"
                                placeholder="Days"/>
                        </span>
                    </div>

                    <p class="col-4 u_btw_slr_cntnt align-items-center">
                        business days of contract execution.
                    </p>

                    <p class="col-12 u_btw_slr_cntnt align-items-center">
                        <strong>UTILITIES:</strong>
                        The present condition of all utility access to the property is accepted by Buyer.
                    </p>

                    <p class="col-12 u_btw_slr_cntnt align-items-center">
                        <strong>PROPERTY CONDITION:</strong>
                        Seller knows of no hazardous substances or petroleum products having been
                        placed, stored, or released from or on the real property by any person in violation of any law, nor
                        of any underground storage tanks having been located on the real property at any time.
                    </p>

                    <p class="col-6 u_btw_slr_cntnt align-items-center">
                        <strong>CLOSING, TITLE AND CONVEYANCE:</strong>
                        Closing to take place at:
                    </p>

                    <!-- New Loans To Seller At Closing $ -->
                    <div class="col-6 mb-4">
                        <span class="u_input_label w-100">
                            <input
                                :class="{'p-invalid': form.errors.place}"
                                v-model="form.place"
                                required
                                type="text" name="place" class="w-full py-3 rounded border-1 px-3 text-2xl"
                                placeholder="Place"/>
                        </span>
                    </div>
                    <!-- New Loans To Seller At Closing $ -->
                    <!-- Purchase Price -->
                    <div class="col-12 mb-4">
                        <span class="u_input_label position-relative w-100">
                            <input
                                :class="{'p-invalid': form.errors.title}"
                                v-model="form.title"
                                required
                                type="text" name="title" class="w-full py-3 rounded border-1 px-3 text-2xl"
                                placeholder="Title company name, address:"/>
                            <label for="title">Title company name, address:</label>
                        </span>
                    </div>

                    <p class="col-6 u_btw_slr_cntnt align-items-center">
                        Seller is to convey title to Buyer by Warranty Deed. Buyer to pay
                    </p>

                    <!-- Shall be Paid as Follows: -->
                    <div class="col-2 mb-4">
                        <span class="u_input_label position-relative w-100">
                            <input
                                :class="{'p-invalid': form.errors.percentage}"
                                v-model="form.percentage"
                                required
                                type="text" name="percentage" class="w-full py-3 rounded border-1 px-3 text-2xl"
                                placeholder="Percentage"/>
                            <label for="Percentage">Percentage</label>
                        </span>
                    </div>
                    <!-- Shall be Paid as Follows: -->

                    <p class="col-4 u_btw_slr_cntnt">
                        % of closing cost . While the seller
                    </p>

                    <p class="col-12 u_btw_slr_cntnt">
                        shall, prior to or at closing, satisfy all outstanding mortgages, deeds of trust and liens affecting
                        the subject property which are not specifically assumed by Buyer herein. Title shall be good and
                        marketable, subject only to (a) covenants, conditions and restrictions of record, (b) public,
                        private utility easements and roads and rights-of-way, (c) applicable zoning ordinances, protective
                        covenants and prior mineral reservations, (d) special and other assessments on the property, if any,
                        (e) general taxes for the year owed and subsequent years. Buyer reserves the right to market the
                        property before closing to investors, partners, MLS, or other parties. Seller represents that the
                        property may be legally used as zoned and that no government agency has served any notice to Seller
                        requiring repairs, alterations or corrections of any existing condition except as stated herein.
                    </p>

                    <p class="col-8 u_btw_slr_cntnt">
                        <strong>
                            CLOSING DATE AND TRANSFER OF TITLE:
                        </strong> This transaction shall close on or before
                    </p>

                    <!-- This transaction shall close on or before -->
                    <div class="col-2 mb-4">
                        <span class="u_input_label w-100">
                            <input
                                :class="{'p-invalid': form.errors.day_and_month}"
                                v-model="form.day_and_month"
                                required
                                type="text" name="transaction" class="w-full py-3 rounded border-1 px-3 text-2xl"
                                placeholder="Day & Month"/>
                            <label for="transaction">
                                Day & Month
                            </label>
                        </span>
                    </div>
                    <!-- This transaction shall close on or before -->

                    <!-- Losing Year -->
                    <div class="col-2 mb-4">
                        <span class="u_input_label w-100">
                            <input
                                :class="{'p-invalid': form.errors.year}"
                                v-model="form.year"
                                required
                                type="text" name="year" class="w-full py-3 rounded border-1 px-3 text-2xl"
                                placeholder="2024"/>
                            <label for="year">
                                Year
                            </label>
                        </span>
                    </div>
                    <!-- Losing Year -->

                    <p class="col-12 u_btw_slr_cntnt">
                        <strong>
                            APPRAISAL, SURVEY AND TERMITE INSPECTION:
                        </strong> Any appraisal of the property shall be the
                        responsibility of Buyer. A survey is not required.
                    </p>

                    <p class="col-12 u_btw_slr_cntnt">
                        <strong>
                            POSSESSION AND TITLE:
                        </strong> Prior to closing the property shall remain in the possession of Seller.
                    </p>

                    <p class="col-12 u_btw_slr_cntnt">
                        <strong>ACCESS & INSPECTION:</strong> Seller shall make the Property reasonably accessible to Buyer,
                        Buyer's
                        partners, contractors, surveyors, and appraisers prior to Closing. This agreement is subject to a
                        satisfactory inspection of the property by Buyer. Should the property not pass satisfactory
                        inspection said contract is null and void.
                    </p>


                    <p class="col-12 u_btw_slr_cntnt">
                        <strong>
                            NO BROKER OR AGENTS:
                        </strong>
                        The parties represent that neither party has employed the services of a
                        real estate broker or agent in connection with the property, or that if such agents have been
                        employed, that the party employing said agent shall pay any and all expenses outside the closing
                        of this agreement.
                    </p>

                    <p class="col-2 u_btw_slr_cntnt">
                        Buyer will have a
                    </p>

                    <div class="col-3 mb-4">
                        <span class="u_input_label w-100">
                            <input
                                :class="{'p-invalid': form.errors.number_of_days}"
                                v-model="form.number_of_days"
                                required
                                type="text" name="number_of_days" class="w-full py-3 rounded border-1 px-3 text-2xl"
                                placeholder="5"/>
                            <label for="number_of_days">
                                Number of Days
                            </label>
                        </span>
                    </div>

                    <p class="col-7 u_btw_slr_cntnt">
                        day inspection period and has the right to cancel this agreement with written notice to the
                    </p>

                    <p class="col-12 u_btw_slr_cntnt">
                        seller within the inspection period. Inspection period starts when the last party has signed this
                        agreement.
                    </p>

                    <p class="col-12 u_btw_slr_cntnt">
                        This agreement is binding on the heirs, administrators, executors, personal representatives, and
                        assigns of Buyer and Seller. By signing, each party accepts this offer.
                    </p>

                    <div class="col-6">
                        <h4 class="mb-2 px-0"><strong>Seller:</strong></h4>
                    </div>
                    <div class="col-6">
                        <h4 class="mb-2 px-0"><strong>Date:</strong></h4>
                    </div>
                    <div class="col-6">
                        <h4 class="mb-2 px-0"><strong>Seller:</strong></h4>
                    </div>
                    <div class="col-6">
                        <h4 class="mb-2 px-0"><strong>Date:</strong></h4>
                    </div>
                    <div class="col-6 mb-3">
                        <h4 class="mb-2 px-0"><strong>Seller:</strong></h4>
                    </div>
                    <div class="col-6">
                        <h4 class="mb-2 px-0"><strong>Date:</strong></h4>
                    </div>

                    <!-- Generate Closing Agreement -->
                    <div class="px-0">
                        <Button :disabled="form.processing" @click="generatePdf" class="bg-transparent border rounded-2 border-danger text-danger u_ad_rm_btn">
                            <svg width="12" height="13" viewBox="0 0 12 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M11.7989 2.81209H9.92778C9.8269 2.81209 9.74107 2.73361 9.74107 2.62537V0.739263C9.74107 0.638378 9.65887 0.552548 9.55435 0.552548L3.77313 0.548828C3.43327 0.548828 3.14566 0.776644 3.05231 1.08666L3.02246 11.753C3.02246 12.1638 3.3586 12.4999 3.7694 12.4999H11.2388C11.6496 12.4999 11.9857 12.1638 11.9857 11.753V2.99884C11.9857 2.89796 11.9035 2.81213 11.799 2.81213L11.7989 2.81209ZM4.84495 3.51794H7.08579C7.29119 3.51794 7.45922 3.68968 7.45922 3.89137C7.45922 4.09678 7.29119 4.26481 7.08579 4.26481H4.84495C4.63954 4.26481 4.47151 4.09678 4.47151 3.89137C4.47151 3.68969 4.63954 3.51794 4.84495 3.51794ZM10.0847 8.73524H4.85606C4.65066 8.73524 4.48262 8.56721 4.48262 8.3618C4.48262 8.1564 4.65065 7.98837 4.85606 7.98837H10.0847C10.2901 7.98837 10.4581 8.15639 10.4581 8.3618C10.4582 8.56721 10.2901 8.73524 10.0847 8.73524ZM10.0922 7.24506H4.86359C4.65818 7.24506 4.49015 7.08075 4.49015 6.87162C4.49015 6.66622 4.65818 6.49819 4.86359 6.49819H10.0922C10.2976 6.49819 10.4657 6.66621 10.4657 6.87162C10.4657 7.08075 10.2976 7.24506 10.0922 7.24506ZM10.0959 5.75869H4.86731C4.6619 5.75869 4.49387 5.59066 4.49387 5.38525C4.49387 5.18357 4.6619 5.01182 4.86731 5.01182H10.0959C10.3051 5.01182 10.4694 5.18356 10.4694 5.38525C10.4694 5.59057 10.3051 5.75869 10.0959 5.75869Z"
                                    fill="#DB0F19" />
                                <path
                                    d="M10.5825 2.03965H11.8493C11.9383 2.03965 11.983 1.93221 11.9204 1.86897L10.6536 0.59137C10.5907 0.527862 10.4824 0.572415 10.4824 0.661876V1.93948C10.4823 1.99475 10.5272 2.03965 10.5825 2.03965Z"
                                    fill="#DB0F19" />
                                <path
                                    d="M1.41817 4.25727L0.0616603 4.25488C0.0308359 4.25479 0.00585938 4.27986 0.00585938 4.31077L0.0163111 10.1974C0.0163997 10.2284 0.0414669 10.2535 0.0722913 10.2536L1.4288 10.2561C1.45963 10.2562 1.4846 10.2311 1.4846 10.2002L1.47415 4.31352C1.47406 4.28261 1.449 4.25745 1.41817 4.25736V4.25727Z"
                                    fill="#DB0F19" />
                                <path
                                    d="M1.39688 11.016L0.106781 11.0137C0.0658598 11.0136 0.0392869 11.0577 0.0577104 11.0953L0.705105 12.4193C0.725477 12.4609 0.783316 12.461 0.803601 12.4194L1.4463 11.0977C1.46446 11.0604 1.4378 11.0161 1.39688 11.016Z"
                                    fill="#DB0F19" />
                                <path
                                    d="M1.87414 1.59195L1.46883 1.59124L1.46821 1.2373C1.4675 0.830399 1.13863 0.500727 0.732856 0.500001H0.732768C0.327814 0.499293 -0.000724401 0.828608 1.1996e-06 1.23472L0.00389864 3.43934C0.00398721 3.46963 0.028433 3.49417 0.0586385 3.49426L1.41755 3.49665C1.44767 3.49674 1.4722 3.47221 1.47211 3.442L1.47017 2.34403L1.87548 2.34474L1.88018 4.97958C1.88053 5.18746 2.04501 5.35619 2.24794 5.35664C2.45078 5.35699 2.61473 5.18879 2.61428 4.98092L2.60959 2.34608C2.60888 1.93092 2.27885 1.59265 1.87414 1.59195Z"
                                    fill="#DB0F19" />
                            </svg>
                            &nbsp;
                            Generate Land Sale Agreement
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
import {Head, useForm} from '@inertiajs/inertia-vue3';
import axios from 'axios';
import { Link } from "@inertiajs/inertia-vue3";
import "flag-icons/css/flag-icons.min.css";

export default {
    name: "LandSaleAgreement",
    props: ['count'],
    data() {
        return {
            agreeTerms: false,
            sharing_count: 0,
            form: useForm({
                seller: null,
                buyer: null,
                country: null,
                state: null,
                assesstor_parcel_no: null,
                acreage_size: null,
                legal_description: null,
                property_address: null,
                shall_be_paid_amount: null,
                deposit: null,
                days: null,
                place: null,
                title: null,
                percentage: null,
                day_and_month: null,
                year: null,
                number_of_days: null,
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
            const res = await axios.post(route('contracts.land.sale.pdf'), this.form);
            if (res.status) {
                this.$toast.add({severity: 'success', summary: 'Success', detail: 'PDF generated successfully', life: 3000});
                window.open(res.pdf_path, '_blank');
            }
        },
        async saveCount() {
            await axios.post(route('contracts.add.share.count'), {type: 'land_sale_agreement'});
            this.sharing_count += 1;
        }
        // generatePdf() {
        //     this.form.post(route('contracts.land.sale.pdf'), {
        //         onFinish: () => {
        //             this.form.reset();
        //             this.$toast.add({severity: 'success', summary: 'Success', detail: 'PDF generated successfully', life: 3000});
        //         },
        //     });
        // },
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



textarea:not(:placeholder-shown)~label {
    top: -7px;
    background: white;
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
.top-bar-container-c {
    margin-top: 0;
    padding-top: 15px;
    padding-bottom: 10px !important;
}

</style>

<script setup>
import InputError from '@/Components/InputError.vue';
import {Link, useForm, usePage} from '@inertiajs/inertia-vue3';

const props = defineProps({
    mustVerifyEmail: Boolean,
    status         : String,
    property: Array,
    list: Array,
    disbaled: Boolean,
});



const user = usePage().props.value.auth.user;




const form = useForm({
    PropertyAddress: props.property.PropertyAddress,
    PropertyCity: props.property.PropertyCity,
    PropertyState: props.property.PropertyState,
    PropertyZipCode: props.property.PropertyZipCode,
    Beds: null,
    Baths: null,
    YearBuilt: null,
    SquareFeet: null,
    insta_price:  "k",
    insta_offer: props.property.insta_offer.toLocaleString("en-US"),
    MailingAddress: props.property.MailingAddress,
    MailingCity: props.property.MailingCity,
    MailingState: props.property.MailingState,
    MailingZipCode: props.property.MailingZipCode,
    OwnerEmailAddress: props.property.OwnerEmailAddress,
    OwnerPhoneNumber: props.property.OwnerPhoneNumber,

    name : user.name,
    email: user.email,
});

const doSomething = () => {
    console.log('Im batman')
}

function updateUser (){
    form.delete(route('profile.destroy'), {
        preserveScroll: true,
        onSuccess: () => closeModal(),
        onError: () => passwordInput.value.focus(),
        onFinish: () => form.reset(),
    });
};


</script>

<style>
    .justify-content {
        justify-content: space-between;
    }

    .titles-cards {
        font-family: 'Nunito';
        font-style: normal;
        font-weight: 600;
        font-size: 24px;
        line-height: 33px;
        /* identical to box height */


        /* Text 1 */

        color: #101136;
    }

    .tab-box {
        padding: 15px 25px;
        text-align: center;
        align-items: center;
        background: #FAFAFA;
        border-radius: 44px;
        width: fit-content;
        font-family: 'Nunito';
        font-style: normal;
        font-weight: 400;
        font-size: 14px;
        line-height: 24px;
        /* identical to box height, or 171% */


        /* Text 1 */

        color: #101136;
    }
</style>

<template>
    <div>
    <form id="updateCust" method="post" action="/lead/update/{{ props.property.id }}">
        <div class="row">
            <div class="col-md-6">
                <div>
                    <div id="map"></div>
                </div>

                <div class="card mt-5">

                    <div class="titles-cards">
                        <span>
                        <i class="pi pi-home text-2xl mr-2 font-bold"/>
                        <span class="text-2xl mr-3"><strong>Property Info </strong></span>
                    </span>
                    </div>
                    <!-- Name-->
                    <div class="field grid mt-5 ">
                        <span class="p-float-label w-full">
                            <InputText class="w-full py-4 text-2xl"
                                    :class="{'p-invalid': form.errors.PropertyAddress}"
                                    style="border-radius: 1rem !important;"
                                    :disabled="props.disbaled"
                                    id="PropertyAddress"
                                    type="text"
                                    v-model="form.PropertyAddress"
                                    required
                                    autofocus
                                    autocomplete="PropertyAddress"/>
                            <label for="PropertyAddress">Street Address</label>
                        </span>
                        <InputError class="mt-2" :message="form.errors.name"/>
                    </div>

                    <div class="row justify-content">
                        <div class="field grid mt-5 col-md-4">
                            <span class="p-float-label ">
                                <InputText class="w-full py-4 text-2xl"
                                        :class="{'p-invalid': form.errors.PropertyCity}"
                                        style="border-radius: 1rem !important;"
                                        id="PropertyCity"
                                        :disabled="props.disbaled"
                                        type="text"
                                        v-model="form.PropertyCity"
                                        required
                                        autofocus
                                        autocomplete="PropertyCity"/>
                                <label for="PropertyCity">City</label>
                            </span>
                            <InputError class="mt-2" :message="form.errors.PropertyCity"/>
                        </div>

                        <div class="field grid mt-5 col-md-4">
                            <span class="p-float-label ">
                                <InputText class="w-full py-4 text-2xl"
                                        :class="{'p-invalid': form.errors.PropertyState}"
                                        style="border-radius: 1rem !important;"
                                        id="PropertyState"
                                        type="text"
                                        :disabled="props.disbaled"
                                        v-model="form.PropertyState"
                                        required
                                        autofocus
                                        autocomplete="PropertyState"/>
                                <label for="PropertyState">State</label>
                            </span>
                            <InputError class="mt-2" :message="form.errors.PropertyState"/>
                        </div>

                        <div class="field grid mt-5 col-md-4">
                            <span class="p-float-label ">
                                <InputText class="w-full py-4 text-2xl"
                                        :class="{'p-invalid': form.errors.PropertyZipCode}"
                                        style="border-radius: 1rem !important;"
                                        id="PropertyZipCode"
                                        type="text"
                                        v-model="form.PropertyZipCode"
                                        :disabled="props.disbaled"
                                        required
                                        autofocus
                                        autocomplete="PropertyZipCode"/>
                                <label for="PropertyZipCode">Zip Code</label>
                            </span>
                            <InputError class="mt-2" :message="form.errors.PropertyZipCode"/>
                        </div>
                    </div>

                    <div class="row justify-content">
                        <div class="field grid mt-5 col-md-6">
                            <span class="p-float-label w-full">
                                <InputText class="w-full py-4 text-2xl"
                                        :class="{'p-invalid': form.errors.Beds}"
                                        style="border-radius: 1rem !important;"
                                        id="Beds"
                                        type="text"
                                        v-model="form.Beds"
                                        :disabled="props.disbaled"
                                        required
                                        autofocus
                                        autocomplete="Beds"/>
                                <label for="Beds">Beds</label>
                            </span>
                            <InputError class="mt-2" :message="form.errors.Beds"/>
                        </div>

                        <div class="field grid mt-5 col-md-6">
                            <span class="p-float-label w-full">
                                <InputText class="w-full py-4 text-2xl"
                                        :class="{'p-invalid': form.errors.Baths}"
                                        style="border-radius: 1rem !important;"
                                        id="Baths"
                                        type="text"
                                        v-model="form.Baths"
                                        :disabled="props.disbaled"
                                        required
                                        autofocus
                                        autocomplete="Baths"/>
                                <label for="Baths">Bath</label>
                            </span>
                            <InputError class="mt-2" :message="form.errors.Baths"/>
                        </div>

                    </div>

                    <div class="row justify-content">
                        <div class="field grid mt-5 col-md-6">
                            <span class="p-float-label w-full">
                                <InputText class="w-full py-4 text-2xl"
                                        :class="{'p-invalid': form.errors.YearBuilt}"
                                        style="border-radius: 1rem !important;"
                                        id="YearBuilt"
                                        type="text"
                                        :disabled="props.disbaled"
                                        v-model="form.YearBuilt"
                                        required
                                        autofocus
                                        autocomplete="YearBuilt"/>
                                <label for="YearBuilt">Year Built</label>
                            </span>
                            <InputError class="mt-2" :message="form.errors.YearBuilt"/>
                        </div>

                        <div class="field grid mt-5 col-md-6">
                            <span class="p-float-label w-full">
                                <InputText class="w-full py-4 text-2xl"
                                        :class="{'p-invalid': form.errors.SquareFeet}"
                                        style="border-radius: 1rem !important;"
                                        id="SquareFeet"
                                        type="text"
                                        :disabled="props.disbaled"
                                        v-model="form.SquareFeet"
                                        required
                                        autofocus
                                        autocomplete="SquareFeet"/>
                                <label for="SquareFeet">Bldg Sq. Ft</label>
                            </span>
                            <InputError class="mt-2" :message="form.errors.SquareFeet"/>
                        </div>

                    </div>
                </div>

                <div class="card mt-5">

                    <div class="titles-cards">
                        <span>
                        <i class="pi pi-volume-down text-2xl mr-2 font-bold"/>
                        <span class="text-2xl mr-3"><strong>Offer Estimation </strong></span>
                    </span>
                    </div>
                    <!-- Name-->
                    <div class="field grid mt-5 ">
                        <span class="p-float-label w-full">
                            <InputText class="w-full py-4 text-2xl"
                                    :class="{'p-invalid': form.errors.insta_price}"
                                    style="border-radius: 1rem !important;"
                                    id="insta_price"
                                    type="number"
                                    :disabled="props.disbaled"
                                    v-model="form.insta_price"
                                    required
                                    autofocus
                                    autocomplete="insta_price"/>
                            <label for="insta_price">Price Estimate</label>
                        </span>
                        <InputError class="mt-2" :message="form.errors.insta_price"/>
                    </div>

                    <div class="field grid mt-5 ">
                        <span class="p-float-label w-full">
                            <InputText class="w-full py-4 text-2xl"
                                    :class="{'p-invalid': form.errors.insta_offer}"
                                    style="border-radius: 1rem !important;"
                                    id="insta_offer"
                                    type="text"
                                    :disabled="props.disbaled"
                                    v-model="(form.insta_offer)"
                                    required
                                    autofocus
                                    autocomplete="insta_offer"/>
                            <label for="insta_offer">Estimated "Insta-Offer" Price</label>
                        </span>
                        <InputError class="mt-2" :message="form.errors.insta_offer"/>
                    </div>

                </div>

            </div>
            <div class="col-md-6">
                <div class="card ">

                    <div class="titles-cards">
                        <span>
                        <i class="pi pi-user text-2xl mr-2 font-bold"/>
                        <span class="text-2xl mr-3"><strong>Owner Info </strong></span>
                    </span>
                    </div>
                    <!-- Name-->
                    <div class="field grid mt-5 ">
                        <span class="p-float-label w-full">
                            <InputText class="w-full py-4 text-2xl"
                                    :class="{'p-invalid': form.errors.MailingAddress}"
                                    style="border-radius: 1rem !important;"
                                    id="MailingAddress"
                                    type="text"
                                    :disabled="props.disbaled"
                                    v-model="form.MailingAddress"
                                    required
                                    autofocus
                                    autocomplete="MailingAddress"/>
                            <label for="MailingAddress">Mailing Address</label>
                        </span>
                        <InputError class="mt-2" :message="form.errors.MailingAddress"/>
                    </div>

                    <div class="row justify-content">
                        <div class="field grid mt-5 col-md-4">
                            <span class="p-float-label ">
                                <InputText class="w-full py-4 text-2xl"
                                        :class="{'p-invalid': form.errors.MailingCity}"
                                        style="border-radius: 1rem !important;"
                                        id="MailingCity"
                                        type="text"
                                        :disabled="props.disbaled"
                                        v-model="form.MailingCity"
                                        required
                                        autofocus
                                        autocomplete="MailingCity"/>
                                <label for="MailingCity">City</label>
                            </span>
                            <InputError class="mt-2" :message="form.errors.MailingCity"/>
                        </div>

                        <div class="field grid mt-5 col-md-4">
                            <span class="p-float-label ">
                                <InputText class="w-full py-4 text-2xl"
                                        :class="{'p-invalid': form.errors.MailingState}"
                                        style="border-radius: 1rem !important;"
                                        id="MailingState"
                                        type="text"
                                        :disabled="props.disbaled"
                                        v-model="form.MailingState"
                                        required
                                        autofocus
                                        autocomplete="MailingState"/>
                                <label for="MailingState">State</label>
                            </span>
                            <InputError class="mt-2" :message="form.errors.MailingState"/>
                        </div>

                        <div class="field grid mt-5 col-md-4">
                            <span class="p-float-label ">
                                <InputText class="w-full py-4 text-2xl"
                                        :class="{'p-invalid': form.errors.MailingZipCode}"
                                        style="border-radius: 1rem !important;"
                                        id="MailingZipCode"
                                        type="text"
                                        :disabled="props.disbaled"
                                        v-model="form.MailingZipCode"
                                        required
                                        autofocus
                                        autocomplete="MailingZipCode"/>
                                <label for="MailingZipCode">Zip Code</label>
                            </span>
                            <InputError class="mt-2" :message="form.errors.MailingZipCode"/>
                        </div>
                    </div>

                    <div class="field grid mt-5 ">
                        <span class="p-float-label w-full">
                            <InputText class="w-full py-4 text-2xl"
                                    :class="{'p-invalid': form.errors.OwnerEmailAddress}"
                                    style="border-radius: 1rem !important;"
                                    id="OwnerEmailAddress"
                                    type="text"
                                    :disabled="props.disbaled"
                                    v-model="form.OwnerEmailAddress"
                                    required
                                    autofocus
                                    autocomplete="OwnerEmailAddress"/>
                            <label for="OwnerEmailAddress">Email Address</label>
                        </span>
                        <InputError class="mt-2" :message="form.errors.OwnerEmailAddress"/>
                    </div>

                    <div class="field grid mt-5 ">
                        <span class="p-float-label w-full">
                            <InputText class="w-full py-4 text-2xl"
                                    :class="{'p-invalid': form.errors.OwnerPhoneNumber}"
                                    style="border-radius: 1rem !important;"
                                    id="OwnerPhoneNumber"
                                    type="text"
                                    :disabled="props.disbaled"
                                    v-model="form.OwnerPhoneNumber"
                                    required
                                    autofocus
                                    autocomplete="OwnerPhoneNumber"/>
                            <label for="OwnerPhoneNumber">Phone Number</label>
                        </span>
                        <InputError class="mt-2" :message="form.errors.OwnerPhoneNumber"/>
                    </div>

                </div>

                <div class="card mt-5">

                    <div class="mb-3">
                        <div class="titles-cards">
                            <span>
                                <i class="pi pi-book text-2xl mr-2 font-bold"/>
                                <!-- <span class="mr-3 text-2xl mr-2 font-bold"><img src="/BullsEyeIcon.svg"/></span> -->
                                <span class="text-2xl mr-3"><strong>Lists </strong></span>
                            </span>
                        </div>
                        <div>
                            <div class="tab-box mt-2">
                                {{ props.list.filename }}
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="titles-cards">
                            <span>
                                <!-- <i class="pi pi-volume-down text-2xl mr-2 font-bold"/> -->
                                <span class="mr-3 text-2xl mr-2 font-bold"><img src="/BullsEyeIcon.svg"/></span>
                                <span class="text-2xl mr-3"><strong>Motivation Tags </strong></span>
                            </span>
                        </div>
                        <div class="d-flex">
                            <div class="tab-box mt-2" v-for="tag in props.list.tags" :key="tag.id">
                                {{ tag.tag_name }}
                            </div>
                        </div>
                    </div>




                </div>
            </div>
        </div>
    </form>
</div>
</template>

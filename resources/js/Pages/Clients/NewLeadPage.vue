

<template>
    <Head title="Lead" />
    <form @submit.prevent="updateUser">
        <AuthenticatedLayout>
            <template #pageHeading>

                <div class="d-flex w-100">
                    <Link :href="route('properties-data.list', list.id)"
                        :class="[ 'p-ripple']"
                        method="get"
                        exact
                        class="hover-links my-auto round-border p-2 mr-2 d-flex"
                        role="menuitem" v-ripple
                        >
                        <!-- <i class="pi pi-sign-out text-xl"></i> -->
                        <i class="pi pi-arrow-left text-2xl  font-bold my-auto"/>
                    </Link>
                    <span class="text-2xl mr-3 my-auto"><strong>{{property.PropertyAddress}} </strong></span>

                    <span class="tag-t my-auto d-flex p-2 round-border">
                        <img class="tag-i my-auto mr-2" src="/BullsEyeIcon.svg"/>
                        <strong class="my-auto">{{ list.tags.length ?? 0 }}</strong>
                    </span>

                    <div class="ms-auto" v-if="state.disabled">
                        <Button class="p-button p-button-outlined p-button-danger "
                                    style="border-radius: 0.5rem !important; display: inline-block !important"
                                    icon="pi pi-pencil"
                                    @click="state.disabled = false"
                                    label="Edit Info"/>
                    </div>

                    <div class="ms-auto" v-if="!state.disabled">
                        <Button class="p-button p-button-outlined p-button-danger "
                                    style="border-radius: 0.5rem !important; display: inline-block !important"
                                    icon="pi pi-save"
                                    type="submit"
                                    label="Save Info"/>
                    </div>
                </div>

            </template>
            <div class="row" id="fasil">
                <div class="col-md-6">
                    <div>
                        <!-- <div id="map"></div> -->
                        <!-- <div id="pano"></div> -->
                        <img id="map" style="height: 236px;" class="w-100" :src="state.img" alt="" srcset="">


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
                                        :disabled="state.disabled"
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
                                            :disabled="state.disabled"
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
                                            :disabled="state.disabled"
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
                                            :disabled="state.disabled"
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
                                            :disabled="state.disabled"
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
                                            :disabled="state.disabled"
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
                                            :disabled="state.disabled"
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
                                            :disabled="state.disabled"
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
                            <span class="text-2xl" style="float: right;">
                                Offer Code: {{ form.prop_code }}
                            </span>
                        </div>
                        <!-- Name-->
                        <!-- <InputNumber v-model="form.insta_price"  /> -->
                        <div class="field grid mt-5 ">
                            <span class="p-float-label w-full">
                                <InputText class="w-full py-4 text-2xl"
                                        :class="{'p-invalid': form.errors.insta_price}"
                                        style="border-radius: 1rem !important;"
                                        id="insta_price"
                                        type="text"
                                        :disabled="state.disabled"
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
                                        :disabled="state.disabled"
                                        v-model="form.insta_offer"
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
                        <div class="row justify-content">
                            <div class="field grid mt-5 col-md-6">
                                    <span class="p-float-label w-full">
                                        <InputText class="w-full py-4 text-2xl"
                                                :class="{'p-invalid': form.errors.OwnerName}"
                                                style="border-radius: 1rem !important;"
                                                id="MailingAddress"
                                                type="text"
                                                :disabled="state.disabled"
                                                v-model="form.OwnerName"
                                                required
                                                autofocus
                                                autocomplete="MailingAddress"/>
                                        <label for="MailingAddress">Owner Name</label>
                                    </span>
                                    <InputError class="mt-2" :message="form.errors.OwnerName"/>
                            </div>
                            <div class="field grid mt-5 col-md-6">
                                    <span class="p-float-label w-full">
                                        <InputText class="w-full py-4 text-2xl"
                                                :class="{'p-invalid': form.errors.MailingAddress}"
                                                style="border-radius: 1rem !important;"
                                                id="MailingAddress"
                                                type="text"
                                                :disabled="state.disabled"
                                                v-model="form.MailingAddress"
                                                required
                                                autofocus
                                                autocomplete="MailingAddress"/>
                                        <label for="MailingAddress">Mailing Address</label>
                                    </span>
                                    <InputError class="mt-2" :message="form.errors.MailingAddress"/>
                            </div>
                        </div>

                        <div class="row justify-content">
                            <div class="field grid mt-5 col-md-4">
                                <span class="p-float-label ">
                                    <InputText class="w-full py-4 text-2xl"
                                            :class="{'p-invalid': form.errors.MailingCity}"
                                            style="border-radius: 1rem !important;"
                                            id="MailingCity"
                                            type="text"
                                            :disabled="state.disabled"
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
                                            :disabled="state.disabled"
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
                                            :disabled="state.disabled"
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
                                        :disabled="state.disabled"
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
                                        :disabled="state.disabled"
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


        </AuthenticatedLayout>
    </form>

    <!-- <img :src="state.img"> -->

    <Toast/>
    <ConfirmDialog/>
</template>

<script setup>

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import HeaderMenu from '../Profile/HeaderMenu.vue';

import {Head} from '@inertiajs/inertia-vue3';
import axios from 'axios';

import DangerButton from '@/Components/DangerButton.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import Modal from '@/Components/Modal.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import {Link, useForm, usePage} from '@inertiajs/inertia-vue3';
import { defineProps, reactive } from "vue";
import { onMounted } from "vue";
import InputNumber from 'primevue/inputnumber';

import html2canvas from 'html2canvas';
onMounted(async () => {
    state.img = "https://maps.googleapis.com/maps/api/streetview?size=600x300&location="+props.geo.lat+","+props.geo.lng+"&heading=151.78&pitch=-0.76&key="+usePage().props.value.MAP_KEY;
    setTimeout(async() =>  {
        // var img1 = (await html2canvas(document.getElementById("fasil"))).toDataURL();
        // console.log(img1)
        // state.img = img1;
    }, 10000);
});

const props = defineProps({
    mustVerifyEmail: Boolean,
    status         : String,
    property: Array,
    list: Array,
    disbaled: Boolean,
    geo: Array,
    // img: String
});

const state = reactive({
  disabled: true,
  img: null,

})

// setTimeout(function() {
//     var lat = props.geo.lat;
//     var lng = props.geo.lng;
//     // The location of Uluru
//     const uluru =  {lat: lat, lng: lng};
//     // The map, centered at Uluru
//     const map = new google.maps.Map(document.getElementById("map"), {
//     zoom: 15,
//     center: uluru,
//     });
//     // The marker, positioned at Uluru
//     const marker = new google.maps.Marker({
//     position: uluru,
//     map: map,
//     });

//     window.initMap = initMap;
// }, 3000);

setTimeout(function(){
    var lat = props.geo.lat;
    var lng = props.geo.lng;
    // The location of Uluru
    const uluru =  {lat: lat, lng: lng};
    // const fenway = { lat: 42.345573, lng: -71.098326 };
    // const map = new google.maps.Map(document.getElementById("map"), {
    //   center: fenway,
    //   zoom: 14,
    // });
    // const panorama = new google.maps.StreetViewPanorama(
    //   document.getElementById("pano"),
    //   {
    //     position: uluru,
    //     disableDefaultUI: true,
    //     linksControl: false,
    //     panControl: false,
    //     enableCloseButton: false,
    //     pov: {
    //       heading: 34,
    //       pitch: 5,

    //     },
    //   }
    // );

    // map.setStreetView(panorama);

    // window.initMap = initMap;
}, 10);

function loadMap() {
    var lat = props.geo.lat;
    var lng = props.geo.lng;
    // The location of Uluru
    const uluru =  {lat: lat, lng: lng};
    // The map, centered at Uluru
    const map = new google.maps.Map(document.getElementById("map"), {
    zoom: 15,
    center: uluru,
    });
    // The marker, positioned at Uluru
    const marker = new google.maps.Marker({
    position: uluru,
    map: map,
    });

    window.initMap = initMap;
}



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
    insta_price: props.property.insta_price,
    insta_offer: props.property.insta_offer,
    MailingAddress: props.property.MailingAddress,
    MailingCity: props.property.MailingCity,
    MailingState: props.property.MailingState,
    MailingZipCode: props.property.MailingZipCode,
    OwnerEmailAddress: props.property.OwnerEmailAddress,
    OwnerPhoneNumber: props.property.OwnerPhoneNumber,
    OwnerName: props.property.OwnerName,
    prop_code: props.property.prop_code,

    name : user.name,
    email: user.email,
});

 const updateUser = async () => {
    const res = await axios.post(route('lead.update.new', props.property.id), {data: form})
    alert("data saved successfully");
    // location.reload();
    state.disabled = true;
    if(res.data.status == "success") {
        state.disabled = true;
        // props.property = res.data.property;

        // state.disabled = true;
        // this.$toast.add({
        //     severity: 'success',
        //     summary : 'Success',
        //     detail  : res.data.message ?? "Action Successful",
        //     life    : 3000
        // });
    }
    // this.handleResponse(res.data);
    // if (res.data.status === 'success') {
    //     const listToEdit = this.allListsArr.findIndex((rw) => rw.listId === this.listBeingEdited.listId);
    //     this.allListsArr.splice(listToEdit, 1);
    // }
}

 const fff = () => {

    console.log(form)
    form.post(route('lead.update', props.property.id), {
        // preserveScroll: true,
        onSuccess     : (res) => {
            console.log(res);

            if(res.data.status == "success") {
                // props.property = res.data.property;
                // this.$toast.add({
                //     severity: 'success',
                //     summary : 'Success',
                //     detail  : res.data.message ?? "Action Successful",
                //     life    : 3000
                // });
            }


        },
        onError       : () => {
            if (form.errors.offer) {
                // form.reset('password', 'password_confirmation');
                // passwordInput.value.focus();
            }
            if (form.errors.offer) {
                form.reset('offer');
                // currentPasswordInput.value.focus();
            }
        },
    });
}
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

    #map, #pano {
        height: 240px;
        border-radius: 15px;
    }
</style>

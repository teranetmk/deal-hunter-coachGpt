<script setup>

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import HeaderMenu from '../Profile/HeaderMenu.vue';

import { Head } from '@inertiajs/inertia-vue3';

import DangerButton from '@/Components/DangerButton.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import Modal from '@/Components/Modal.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import {Link, useForm, usePage} from '@inertiajs/inertia-vue3';

defineProps({
    mustVerifyEmail: Boolean,
    status: String,
});

const user = usePage().props.value.auth.user;

const form = useForm({
    offer: user.offer,
});

const updateoffer = () => {
    form.offer = form.offer;
    form.post(route('offer.update'), {
        preserveScroll: true,
        onSuccess     : (res) => {

            // form.reset();
            // form.offer = res;
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

<template>
    <Head title="Profile" />

    <AuthenticatedLayout>
        <template #pageHeading>
            <HeaderMenu />
        </template>
        <div class="grid">
            <span class="p-texts">
                <i class="pi pi-home text-3xl mr-2 font-bold"/>
                <span class=" mr-3"><strong>Insta-Offer Settings</strong></span>
            </span>
            <div class="col-12">
                <p>Set the % below a property's ARV you want the A.I. to make offer in RoboDrop</p>
            </div>
        </div>

        <form @submit.prevent="updateoffer">
            <div class="grid mt-3 d-flex">
                <h4 class="my-auto"><strong>ARV</strong></h4>

                <h4 class="ms-3 my-auto"><strong>X</strong></h4>

                <div class="field  offer-input ms-3">
                        <span class="p-float-label">
                            <InputText class="w-100"
                                    :class="{'p-invalid': form.errors.offer}"
                                    style="border-radius: 1rem !important;"
                                    id="offer"
                                    type="text"
                                    v-model="form.offer"
                                    required
                                    autofocus
                                    autocomplete="offer"/>
                            <label for="offer">%</label>
                        </span>
                        <InputError class="mt-2" :message="form.errors.name"/>
                </div>

                <h4 class="ms-3 my-auto"><strong> = </strong></h4>
                <h4 class="ms-3 my-auto"><strong> Insta-Offer </strong></h4>
            </div>

            <Button label="Update"
                type="submit"
                :class="{ 'opacity-25': form.processing }"
                :disabled="form.processing"
                class="p-button-danger p-button-outlined px-5 "
                style="border-radius: 1rem;"/>
        </form>


    </AuthenticatedLayout>
</template>


<style>
.offer-input input{
    border: none;
    width: 100%;

}

.offer-input input:focus {
    border: none;
    outline: none;
}
.p-texts {
    font-family: 'Nunito';
    font-style: normal;
    font-weight: 500;
    font-size: 24px;
    line-height: 33px;
    /* identical to box height */


    /* Text 1 */

    color: #101136;

}

.offer-input {
    /* Stroke */

    border: 1px solid #E6EAED;
    border-radius: 5px;
    width: 55px;
}
</style>

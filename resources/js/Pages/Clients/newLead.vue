<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';




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


    </AuthenticatedLayout>
</template>


<style>
    #map {
        height: 236px;
        border-radius: 15px;
    }
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

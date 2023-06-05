<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import DeleteUserForm from "./Partials/DeleteUserForm.vue";
import UpdatePasswordForm from "./Partials/UpdatePasswordForm.vue";

import HeaderMenu from "./HeaderMenu.vue";
import UpdateProfileInformationForm from "./Partials/UpdateProfileInformationForm.vue";
import { Head } from "@inertiajs/inertia-vue3";

defineProps({
    mustVerifyEmail: Boolean,
    status: String,
});
</script>

<template>
    <Head title="Profile" />

    <AuthenticatedLayout>
        <template #pageHeading>
            <HeaderMenu />
        </template>
        <div class="grid">
            <span>
                <i class="pi pi-cog text-3xl mr-2 font-bold" />
                <span class="text-3xl mr-3"
                    ><strong>Account Settings</strong></span
                >
            </span>
            <div class="col-12">
                <UpdateProfileInformationForm
                    :must-verify-email="mustVerifyEmail"
                    :status="status"
                    class="max-w-xl"
                />
            </div>
        </div>
        <div class="">
            <UpdatePasswordForm />
        </div>
        <div class="py-12" v-if="'we' === 'awesome'">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <DeleteUserForm class="max-w-xl" />
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

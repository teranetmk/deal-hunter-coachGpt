<script setup>
import InputError from "@/Components/InputError.vue";
import { Link, useForm, usePage } from "@inertiajs/inertia-vue3";

const props = defineProps({
    mustVerifyEmail: Boolean,
    status: String,
});

const user = usePage().props.value.auth.user;

const form = useForm({
    name: user.name,
    email: user.email,
});
</script>
<style>
.p-invalid {
    color: red !important;
}
</style>

<template>
    <section>
        <div class="grid mt-4">
            <div class="">
                <span class=""><strong>Profile Information</strong></span>
            </div>
        </div>
        <form @submit.prevent="form.patch(route('profile.update'))">
            <!-- Name-->
            <div class="field col-md-5 mt-5">
                <span class="p-float-label">
                    <InputText
                        class="w-full py-3"
                        :class="{ 'p-invalid': form.errors.name }"
                        style="border-radius: 1rem !important"
                        id="name"
                        type="text"
                        v-model="form.name"
                        required
                        autofocus
                        autocomplete="name"
                    />
                    <label for="email">Name</label>
                </span>
                <InputError class="mt-2" :message="form.errors.name" />
            </div>

            <div class="field col-md-5 mt-5">
                <span class="p-float-label">
                    <InputText
                        class="w-full py-3"
                        :class="{ 'p-invalid': form.errors.email }"
                        style="border-radius: 1rem !important"
                        id="email"
                        type="email"
                        v-model="form.email"
                        required
                        autocomplete="email"
                    />
                    <label for="email">Email Address</label>
                </span>
                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div
                v-if="props.mustVerifyEmail && user.email_verified_at === null"
            >
                <!--Todo Not updated - not required-->
                <p class="text-sm mt-2 text-gray-800">
                    Your email address is unverified.
                    <Link
                        :href="route('verification.send')"
                        method="post"
                        as="button"
                        class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    >
                        Click here to re-send the verification email.
                    </Link>
                </p>

                <div
                    v-show="props.status === 'verification-link-sent'"
                    class="mt-2 font-medium text-sm text-green-600"
                >
                    A new verification link has been sent to your email address.
                </div>
            </div>

            <!--Submit button-->
            <div class="field col-md-5 mt-5">
                <div class="">
                    <Button
                        label="Update"
                        type="submit"
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing"
                        class="p-button-danger p-button-outlined py-3 px-4"
                        style="border-radius: 1rem"
                    />

                    <Transition
                        enter-from-class="opacity-0"
                        leave-to-class="opacity-0"
                        class="transition ease-in-out"
                    >
                        <InlineMessage
                            v-if="form.recentlySuccessful"
                            class="ml-2"
                            severity="success"
                            >Profile Saved</InlineMessage
                        >
                    </Transition>
                </div>
            </div>
        </form>
    </section>
</template>

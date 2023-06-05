<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import {Head, useForm} from '@inertiajs/inertia-vue3';

defineProps({
    status: String,
});

const form = useForm({
    email: '',
});

const submit = () => {
    form.post(route('password.email'));
};
</script>

<template>
    <GuestLayout>
        <Head><title>Forgot Password</title>></Head>

        <div class="grid flex justify-content-center align-content-center"
             style="margin-top:-7rem; height: 96vh !important; ">
            <div class="col-12 sm:col-10 md:col-8 lg:col-6 xl:col-6 border-1 border-400 border-round"
                 style="border-radius: 2rem !important; max-width: 600px;">
                <div class="p-5">
                    <div class="grid">
                        <div class="col">
                            <a :href="route('login')"><i class="pi pi-arrow-left text-2xl"></i></a>
                        </div>
                    </div>

                    <div class="flex justify-content-center text-4xl">
                        <strong>Forgot Password?</strong>
                    </div>

                    <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
                        {{ status }}
                    </div>

                    <form @submit.prevent="submit">
                        <!--Email Address -->
                        <div class="field grid mt-5">
                            <div class="col-12">
                                <span class="p-float-label">
                                    <InputText class="w-full py-4 text-2xl"
                                               :class="{'p-invalid': form.errors.email}"
                                               style="border-radius: 1rem !important;"
                                               id="email"
                                               type="email"
                                               v-model="form.email"
                                               required
                                               autofocus
                                               autocomplete="username"/>
                                    <label for="email">Email Address</label>
                                </span>
                                <InputError class="mt-2" :message="form.errors.email"/>
                            </div>
                        </div>

                        <!--Submit button-->
                        <div class="field grid mt-5">
                            <div class="col-12">
                                <Button label="Reset Password"
                                        type="submit"
                                        :class="{ 'opacity-25': form.processing }"
                                        :disabled="form.processing"
                                        class="p-button-danger w-full p-button-lg py-4"
                                        style="border-radius: 1rem;"/>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </GuestLayout>
</template>

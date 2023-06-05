<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import {Head, useForm} from '@inertiajs/inertia-vue3';

const props = defineProps({
    email: String,
    token: String,
});

const form = useForm({
    token                : props.token,
    email                : props.email,
    password             : '',
    password_confirmation: '',
});

const submit = () => {
    form.password_confirmation = form.password;
    form.post(route('password.store'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Reset Password"/>


        <div class="grid flex justify-content-center align-content-center"
             style="margin-top:-7rem; height: 96vh !important; ">
            <div class="col-12 sm:col-10 md:col-8 lg:col-6 xl:col-6 border-1 border-400 border-round"
                 style="border-radius: 2rem !important; max-width: 600px;">
                <div class="p-5">
                    <div class="flex justify-content-center text-4xl">
                        <strong>Reset Password</strong>
                    </div>

                    <form @submit.prevent="submit">

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

                        <div class="field grid mt-5">
                            <div class="col-12">
                                <span class="p-float-label">
                                    <Password class="w-full"
                                              id="password"
                                              :inputClass="form.errors.password? 'w-full py-4 text-2xl p-invalid' : 'w-full py-4 text-2xl'"
                                              inputStyle="border-radius: 1rem !important;"
                                              showIcon="pi pi-eye text-2xl font-bold text-black-alpha-90"
                                              hideIcon="pi pi-eye-slash text-2xl font-bold text-black-alpha-90"
                                              toggleMask
                                              v-model="form.password"
                                              :feedback="false"
                                              required
                                              autocomplete="new-password"
                                              style="width:100%"/>
                                    <label for="password">Password</label>
                                </span>
                                <InputError class="mt-2" :message="form.errors.password"/>
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

<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import {Head, useForm} from '@inertiajs/inertia-vue3';
import {onMounted} from "vue";

defineProps({
    canResetPassword: Boolean,
    status          : String,
});


const form = useForm({
    email   : '',
    password: '',
    remember: false,
});

onMounted(() => {
    window.UserId = null;
})

const submit = () => {
    form.post(route('login'), {
        onFinish: () => {
            form.reset('password')
        },
    });
};
</script>

<style>
.p-invalid {
    color: red !important;
}
</style>

<template>
    <GuestLayout>
        <Head title="Log in"/>

        <div class="grid flex justify-content-center align-content-center"
             style="margin-top:-7rem; height: 96vh !important; ">
            <div class="col-12 sm:col-10 md:col-8 lg:col-6 xl:col-6 border-1 border-400 border-round"
                 style="border-radius: 2rem !important; max-width: 600px;">
                <div class="p-5">
                    <div class="flex justify-content-center text-4xl">
                        <strong>Log In</strong>
                    </div>
                    <div class="flex justify-content-center text-2xl mt-4 text-center">
                        Sign into your account to access DealHunter
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
                                <!--                                <InputError class="mt-2" :message="form.errors.email"/>-->
                            </div>
                        </div>

                        <!--Password-->
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
                                          autocomplete="current-password"
                                          style="width:100%"/>
                                <label for="password">Password</label>
                            </span>
                                <!--                                <InputError class="mt-2" :message="form.errors.password"/>-->
                            </div>
                        </div>

                        <div>
                            <a
                                :href="route('password.request')"
                                class="p-text-danger"
                            >
                                <strong>Forgot password?</strong>
                            </a>
                        </div>

                        <!--Submit button-->
                        <div class="field grid mt-5">
                            <div class="col-12">
                                <Button label="Sign In"
                                        type="submit"
                                        :class="{ 'opacity-25': form.processing }"
                                        :disabled="form.processing"
                                        class="p-button-danger w-full p-button-lg py-4"
                                        style="border-radius: 1rem;"/>
                            </div>
                        </div>

                        <!-- Create Account -->
                        <div class="field grid mt-5">
                            <div class="col-12 flex justify-content-center text-2xl">
                                <div>Don't have an account? <a :href="route('register')" class="p-text-danger">
                                    <strong>Create account here</strong></a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </GuestLayout>
</template>

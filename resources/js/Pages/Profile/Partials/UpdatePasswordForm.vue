<script setup>
import InputError from "@/Components/InputError.vue";
import { useForm } from "@inertiajs/inertia-vue3";
import { ref } from "vue";

const passwordInput = ref(null);
const currentPasswordInput = ref(null);

const form = useForm({
    current_password: "",
    password: "",
    password_confirmation: "",
});

const updatePassword = () => {
    form.password_confirmation = form.password;
    form.put(route("password.update"), {
        preserveScroll: true,
        onSuccess: () => form.reset(),
        onError: () => {
            if (form.errors.password) {
                form.reset("password", "password_confirmation");
                passwordInput.value.focus();
            }
            if (form.errors.current_password) {
                form.reset("current_password");
                currentPasswordInput.value.focus();
            }
        },
    });
};
</script>

<template>
    <section>
        <div class="mt-4">
            <div class="">
                <span><strong>Password</strong></span>
            </div>
        </div>

        <form @submit.prevent="updatePassword">
            <div class="field col-md-5 mt-5 mb-0">
                <div class="">
                    <span class="p-float-label">
                        <Password
                            class="w-full"
                            id="current_password"
                            ref="currentPasswordInput"
                            :inputClass="
                                form.errors.current_password
                                    ? 'w-full py-3 p-invalid'
                                    : 'w-full py-3'
                            "
                            inputStyle="border-radius: 1rem !important;"
                            showIcon="pi pi-eye text-2xl font-bold text-black-alpha-90"
                            hideIcon="pi pi-eye-slash text-2xl font-bold text-black-alpha-90"
                            toggleMask
                            v-model="form.current_password"
                            :feedback="false"
                            required
                            autocomplete="current-password"
                            style="width: 100%"
                        />
                        <label for="password">Current Password</label>
                    </span>
                    <InputError
                        :message="form.errors.current_password"
                        class="mt-2"
                    />
                </div>
            </div>

            <div class="field col-md-5 mt-5">
                <div class="">
                    <span class="p-float-label">
                        <Password
                            class="w-full"
                            id="password"
                            ref="passwordInput"
                            :inputClass="
                                form.errors.password
                                    ? 'w-full py-3 p-invalid'
                                    : 'w-full py-3'
                            "
                            inputStyle="border-radius: 1rem !important;"
                            showIcon="pi pi-eye text-2xl font-bold text-black-alpha-90"
                            hideIcon="pi pi-eye-slash text-2xl font-bold text-black-alpha-90"
                            toggleMask
                            v-model="form.password"
                            :feedback="false"
                            required
                            autocomplete="new-password"
                            style="width: 100%"
                        />
                        <label for="password">New Password</label>
                    </span>
                    <InputError :message="form.errors.password" class="mt-2" />
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
                            >New Password Saved</InlineMessage
                        >
                    </Transition>
                </div>
            </div>
        </form>
    </section>
</template>

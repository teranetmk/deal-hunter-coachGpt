<template>
    <Head><title>Admin: Users</title></Head>

    <AdminLayout>
        <template #header> All Users </template>

        <DataTable
            :value="users"
            :paginator="true"
            :rows="10"
            showGridlines
            dataKey="id"
            :rowHover="true"
            v-model:filters="filters"
            filterDisplay="menu"
            :loading="loading"
            paginatorTemplate="CurrentPageReport FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink"
            :rowsPerPageOptions="[10, 25, 50, 100]"
            currentPageReportTemplate="Showing {first} to {last} of {totalRecords} entries"
            :globalFilterFields="['id', 'name', 'email', 'phone']"
            responsiveLayout="scroll"
        >
            <template #header>
                <div class="flex justify-content-between align-items-center">
                    <span>
                        <Button
                            type="button"
                            icon="pi pi-filter-slash"
                            label="Clear"
                            class="p-button p-component p-button p-button-outlined p-button-danger"
                            @click="clearFilter()"
                        />

                        <Button
                            type="button"
                            icon="pi pi-user-plus"
                            label="Add New User"
                            class="p-button p-component p-button p-button-outlined p-button-danger mr-3 ml-3"
                            @click="displayAddUserModal = true"
                        />
                    </span>
                    <span class="p-input-icon-left">
                        <i class="pi pi-search" />
                        <InputText
                            v-model="filters['global'].value"
                            placeholder="Search"
                        />
                    </span>
                </div>
            </template>

            <template #empty> No Users found. </template>
            <template #loading> Loading User data. Please wait. </template>
            <Column field="id" header="ID" style="min-width: 3rem" />
            <Column field="name" header="Name" style="min-width: 12rem" />
            <Column field="email" header="Email" style="min-width: 12rem" />
            <Column field="phone" header="Phone" style="min-width: 12rem">
                <template #body="{ data }">
                    <span :class="'fi fi-' + data.phone_country_code" />
                    <span class="ml-2">{{ data.phone }}</span>
                </template>
            </Column>
            <Column
                field="total_credits"
                header="Current Credits"
                style="min-width: 12rem"
            >
                <template #body="slotProps">
                    {{ Number(slotProps.data.total_credits).toLocaleString() }}
                </template>
            </Column>
            <Column
                field="last_login"
                header="Last Login"
                style="min-width: 12rem"
            />
            <Column
                field="is_premium"
                header="Upgrades"
                style="min-width: 12rem"
            >
                <template #body="slotProps">
                    <div class="form-check form-switch">
                        <input
                            :checked="slotProps.data.is_premium"
                            @change="updateUserUnlock($event, slotProps.data)"
                            class="form-check-input"
                            type="checkbox"
                            role="switch"
                            id="flexSwitchCheckDefault"
                        />
                    </div>
                </template>
            </Column>
            <Column field="id" header="Actions" style="min-width: 12rem">
                <template #body="{ data }">
                    <!-- <button class="edit-del mr-2" @click="showBuyerDetail(slotProps.data)"><i class="pi pi-money-bill"/></button> -->

                    <button
                        :disabled="
                            userIdBeingDeleted.includes(data.id) ||
                            data.id === 1
                        "
                        @click="showBuyerDetail(data)"
                        class="edit-del"
                    >
                        <i class="pi pi-money-bill" />
                    </button>
                    <button
                        :disabled="
                            userIdBeingDeleted.includes(data.id) ||
                            data.id === 1
                        "
                        @click="deleteUserConfirm(data.id)"
                        class="edit-del"
                    >
                        <i class="pi pi-trash" />
                    </button>

                    <!-- <Button type="button"
                            icon="pi pi-money-bill"
                            label="Add Credit"
                            class="p-button-sm p-button-outlined mr-2"
                            :disabled="userIdBeingDeleted.includes(data.id) || data.id === 1"
                            @click="showBuyerDetail(data)"/>
                    <Button type="button"
                            icon="pi pi-trash"
                            label="Delete"
                            class="p-button-sm p-button-outlined p-button-danger"
                            :disabled="userIdBeingDeleted.includes(data.id) || data.id === 1"
                            @click="deleteUserConfirm(data.id)"/> -->
                </template>
            </Column>
        </DataTable>

        <Dialog
            header="Add New User"
            v-model:visible="displayAddUserModal"
            :style="{ width: '30vw' }"
            :modal="true"
        >
            <!--Name-->
            <div class="field grid mt-3">
                <label class="col-2" for="name">Name</label>
                <div class="col-10">
                    <InputText class="w-full" id="name" v-model="form.name" />
                    <InputError class="mt-2" :message="form.errors.name" />
                </div>
            </div>

            <!--Email-->
            <div class="field grid">
                <label class="col-2" for="email">Email Address</label>
                <div class="col-10">
                    <InputText class="w-full" id="email" v-model="form.email" />
                    <InputError class="mt-2" :message="form.errors.email" />
                </div>
            </div>

            <!-- Phone -->
            <div class="field grid">
                <label class="col-2" for="email">Phone Number</label>
                <div class="col-10">
                    <div class="p-inputgroup">
                        <Dropdown
                            v-model="form.phone_country_code"
                            :options="countries"
                            style="border-right: none; min-width: 6rem"
                            optionLabel="name"
                            optionValue="code"
                        >
                            <template #value="slotProps">
                                <div
                                    class="flex align-items-center"
                                    style="height: 100%"
                                >
                                    <div v-if="slotProps.value">
                                        <span
                                            :class="'fi fi-' + slotProps.value"
                                        />
                                    </div>
                                    <span v-else>
                                        <span :class="'fi fi-us'" />
                                    </span>
                                </div>
                            </template>
                            <template #option="slotProps">
                                <div class="" style="display: inline">
                                    <span
                                        :class="
                                            'fi fi-' + slotProps.option.code
                                        "
                                    ></span>
                                    <div class="ml-3" style="display: inline">
                                        {{ slotProps.option.name }}
                                    </div>
                                </div>
                            </template>
                        </Dropdown>
                        <InputText
                            class="w-full"
                            id="phone-number"
                            v-model="form.phone"
                        />
                    </div>
                    <InputError class="mt-2" :message="form.errors.phone" />
                </div>
            </div>

            <!--Password -->
            <div class="field grid">
                <label class="col-2" for="email">Password</label>
                <div class="col-10">
                    <Password
                        class="w-full"
                        inputClass="w-full"
                        inputStyle="width: 100%"
                        v-model="form.password"
                        toggleMask
                    />
                    <InputError class="mt-2" :message="form.errors.password" />
                </div>
            </div>

            <template #footer>
                <Button
                    label="Cancel"
                    icon="pi pi-times"
                    @click="displayAddUserModal = false"
                    class="p-button p-component p-button p-component p-button p-button-outlined p-button-danger p-button-sm"
                />
                <Button
                    class="p-button p-component p-button p-component p-button p-button-outlined p-button-danger p-button-sm"
                    label="Add User"
                    icon="pi pi-check"
                    :disabled="form.processing"
                    @click="addNewUser"
                />
            </template>
        </Dialog>

        <Toast />
        <ConfirmDialog />

        <Dialog
            header="Add Credits"
            v-model:visible="displayBasic"
            :style="{ width: '20vw' }"
        >
            <div class="desc">
                <div class="mb-3 mt-3">
                    <label for="exampleFormControlInput1" class="form-label"
                        >Amount to credit</label
                    >
                    <input
                        v-model="amountCredit"
                        type="number"
                        class="form-control"
                        id="exampleFormControlInput1"
                    />
                    <Button
                        class="p-button p-component p-button p-component p-button p-button-outlined p-button-danger p-button-sm mr-3 mt-3"
                        label="Add Credit"
                        icon="pi pi-check"
                        :disabled="form.processing"
                        @click="addCredit"
                        autofocus
                    />
                </div>
            </div>
        </Dialog>
    </AdminLayout>
</template>

<script>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { Head, useForm } from "@inertiajs/inertia-vue3";
import { FilterMatchMode, FilterOperator } from "primevue/api";
import "flag-icons/css/flag-icons.min.css";
import countries from "../country.json" assert { type: "json" };
import InputError from "@/Components/InputError.vue";
import InputNumber from "primevue/inputnumber";

export default {
    name: "Users",
    props: ["users"],
    data() {
        return {
            loading: false,
            amountCredit: 0,
            filters: null,
            countries: countries,
            displayAddUserModal: false,
            selectedUser: null,
            displayBasic: false,
            form: useForm({
                name: null,
                email: null,
                phone_country_code: "us",
                phone: null,
                password: null,
                password_confirmation: null,
            }),
            userIdBeingDeleted: [],
        };
    },
    created() {
        this.initFilters();
    },
    methods: {
        addNewUser() {
            this.form.password_confirmation = this.form.password;
            this.form.post(route("admin.new-user"), {
                onFinish: () => {
                    //this.form.reset('password', 'password_confirmation')
                    this.form.reset();
                    if (
                        !(
                            this.form.errors &&
                            Object.keys(this.form.errors).length > 0
                        )
                    ) {
                        this.$toast.add({
                            severity: "success",
                            summary: "Success",
                            detail: "User Added",
                            life: 3000,
                        });
                    }
                },
            });
        },
        addCredit() {
            const updateCredit = useForm({
                id: this.selectedUser.id,
                amount: this.amountCredit,
            });
            updateCredit.post(route("admin.user.credit_update"), {
                onFinish: () => {
                    if (!updateCredit.hasErrors) {
                        this.$toast.add({
                            severity: "success",
                            summary: "Success",
                            detail: "User credits updated",
                            life: 3000,
                        });
                        // window.location.reload
                    }
                },
            });
            this.amountCredit = 0;
            this.displayBasic = false;
        },
        showBuyerDetail(cashBuyer) {
            this.selectedUser = cashBuyer;
            this.displayBasic = true;
        },
        updateUserUnlock(e, data) {
            const updatePremium = useForm({
                id: data.id,
                status: e.target.checked,
            });
            updatePremium.post(route("admin.user.premium_update"), {
                onFinish: () => {
                    if (!updatePremium.hasErrors) {
                        this.$toast.add({
                            severity: "success",
                            summary: "Success",
                            detail: "User premium status updated",
                            life: 3000,
                        });
                    }
                },
            });
        },
        deleteUserConfirm(userId) {
            this.$confirm.require({
                message: `Do you want to delete User #${userId}?`,
                header: "Delete Confirmation",
                icon: "pi pi-info-circle",
                acceptClass: "p-button-danger",
                accept: () => {
                    this.deleteUser(userId);
                },
                reject: () => {},
            });
        },
        deleteUser(userId) {
            this.userIdBeingDeleted.push(userId);
            const del = useForm({ id: userId });

            del.post(route("admin.delete-user"), {
                onFinish: () => {
                    if (!del.hasErrors) {
                        this.$toast.add({
                            severity: "success",
                            summary: "Success",
                            detail: "User Deleted",
                            life: 3000,
                        });
                    }
                },
            });
        },
        clearFilter() {
            this.initFilters();
        },
        initFilters() {
            this.filters = {
                global: { value: null, matchMode: FilterMatchMode.CONTAINS },
                id: {
                    operator: FilterOperator.AND,
                    constraints: [
                        { value: null, matchMode: FilterMatchMode.EQUALS },
                    ],
                },
                name: {
                    operator: FilterOperator.AND,
                    constraints: [
                        { value: null, matchMode: FilterMatchMode.STARTS_WITH },
                    ],
                },
                email: {
                    operator: FilterOperator.AND,
                    constraints: [
                        { value: null, matchMode: FilterMatchMode.STARTS_WITH },
                    ],
                },
                phone: {
                    operator: FilterOperator.AND,
                    constraints: [
                        { value: null, matchMode: FilterMatchMode.STARTS_WITH },
                    ],
                },
                created_at: {
                    operator: FilterOperator.AND,
                    constraints: [
                        { value: null, matchMode: FilterMatchMode.DATE_IS },
                    ],
                },
            };
        },
    },
    components: { InputError, Head, AdminLayout },
};
</script>

<style scoped>
.form-switch .form-check-input:checked {
    background-color: #d32f2f;
    border-color: #d32f2f;
    border: none;
    background-image: url("data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='-4 -4 8 8'%3e%3ccircle r='3' fill='rgba(255,255,255,1.0)'/></svg>");
}
</style>

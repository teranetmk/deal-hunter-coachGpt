<template>
    <Head><title>Admin: Users</title></Head>

    <AdminLayout>
        <template #pageHeading>
            <div class="flex align-items-center">
                <Button
                    class="p-button p-button-outlined p-button-danger mr-3"
                    style="border-radius: 0.5rem !important"
                    icon="pi pi-bars"
                    label="Filter"
                ></Button>
                <span class="p-input-icon-left">
                    <i class="pi pi-search" />
                    <InputText
                        v-model="filters['global'].value"
                        placeholder="Search"
                    />
                </span>
            </div>
            <span>
                <Button
                    @click="uploadFile()"
                    class="p-button p-button-outlined p-button-danger mr-2"
                    style="border-radius: 0.5rem !important"
                    icon="pi pi-database"
                    label="Import Cash Buyers"
                >
                    <!-- <input type="file" @change="handleFileUpload($event)"> -->
                </Button>
                <Button
                    class="p-button p-button-outlined p-button-danger"
                    style="border-radius: 0.5rem !important"
                    icon="pi pi-dollar"
                    label="Create Cash Buyer"
                    @click="newCashBuyer()"
                >
                </Button>
            </span>
            <input
                id="uploadExcel"
                accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel"
                style="display: none"
                type="file"
                @change="handleFileUpload($event)"
            />
        </template>

        <div class="grid">
            <div class="col-12">
                <Chip
                    v-for="tagAr in selectedUserTags"
                    :key="tagAr.tag_id"
                    class="text-xs mr-1 mb-1"
                    @remove="removedUserTag(tagAr.tag_id)"
                    :label="tagAr.tag_name + ' (' + tagAr.property_count + ')'"
                    removable
                />
            </div>
        </div>

        <DataTable
            :value="cashBuyers"
            ref="dt"
            :paginator="true"
            :rows="10"
            dataKey="id"
            v-model:filters="filters"
            filterDisplay="menu"
            v-model:selection="selectedProperties"
            :rowHover="true"
            :loading="loadingProperties"
            :globalFilterFields="[
                'name',
                'min_price_range',
                'state',
                'min_profit_deal',
                'action',
            ]"
            paginatorTemplate="CurrentPageReport FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink"
            :rowsPerPageOptions="[10, 25, 50]"
            currentPageReportTemplate="Showing {first} to {last} of {totalRecords} entries"
            responsiveLayout="scroll"
        >
            <!-- <template #header>
                <div class="flex justify-content-between align-items-center">
                    <span>
                        <i class="pi pi-home text-2xl mr-2 font-bold"/>
                        <span class="text-2xl mr-3"><strong>Properties ( {{
                                propertiesToDisplay.length ?? 0
                            }} )</strong></span>
                    </span>
                    <span class="flex-grow-1"></span>
                    <span class="mr-3 align-self-end"><img src="BullsEyeIcon.svg"/></span>
                    <span class="mr-4 ml-2" style="width:240px;">
                        <vue-slider :height="8"
                                    :adsorb="true"
                                    :marks="true"
                                    @change="motivationSliderChange"
                                    :min="0"
                                    :max="10"
                                    :step="1"
                                    v-model="tagCount"/>
                        </span>
                    <span>
                        <Button class="p-button p-button-outlined p-button-danger"
                                style="border-radius: 0.5rem !important; display: inline-block !important"
                                icon="pi pi-download"
                                @click="exportCSV($event)"
                                label="Download List"/>
                    </span>


                </div>
            </template> -->
            <template #empty> No Cash buyers found. </template>
            <template #loading>
                Loading Cash buyers data. Please wait.
            </template>
            <Column
                field="name"
                class="buyer-name-img"
                header="Cash Buyer Name"
                exportFooter="Cash Buyer Name"
                style="min-width: 14rem"
            >
                <template #body="slotProps">
                    <img
                        class="profile-img"
                        :src="
                            slotProps.data.profile_pic
                                ? '/uploads/' + slotProps.data.profile_pic
                                : '/images/user-img.svg'
                        "
                    />{{ slotProps.data.name }}
                </template>
            </Column>
            <Column
                field="state"
                header="Target Market"
                exportFooter="Target Market"
                style="min-width: 12rem"
            />
            <Column
                field="min_price_range"
                header="Price Range"
                exportFooter="Price Range"
                style="min-width: 10rem"
            >
                <template #body="slotProps">
                    ${{
                        Number(slotProps.data.min_price_range).toLocaleString()
                    }}
                    - ${{
                        Number(slotProps.data.max_price_range).toLocaleString()
                    }}
                </template>
            </Column>
            <Column
                field="min_profit_deal"
                header="Minimum Profit"
                exportFooter="Minimum Profit"
                style="min-width: 14rem"
            >
                <template #body="slotProps">
                    ${{
                        Number(slotProps.data.min_profit_deal).toLocaleString()
                    }}
                </template>
            </Column>
            <Column
                field="action"
                header="Action"
                exportFooter="Action"
                style="min-width: 14rem"
            >
                <template #body="slotProps">
                    <button
                        class="edit-del"
                        @click="editCashBuyer(slotProps.data.id)"
                    >
                        <i class="pi pi-pencil" />
                    </button>
                    <button
                        class="edit-del"
                        @click="this.deleteCashBuyerConfirm(slotProps.data.id)"
                    >
                        <i class="pi pi-trash" />
                    </button>
                </template>
            </Column>
        </DataTable>

        <!--Add Tags-->
        <Dialog
            header="Profile"
            v-model:visible="displayBasic"
            :style="{ width: '50vw' }"
        >
            <div class="buyer-profile">
                <div class="flex align-items-center">
                    <img
                        class="user-img"
                        src="../../../../public/images/user-img.svg"
                        alt="user_img"
                    />
                    <div class="user-info">
                        <h4>John Smith</h4>
                        <p>
                            <img
                                src="../../../../public/images/call.svg"
                                alt="call"
                            />
                            +1 212 653 0333
                        </p>
                        <p>
                            <img
                                src="../../../../public/images/mail.svg"
                                alt="mail"
                            />
                            example@gmail.com
                        </p>
                    </div>
                </div>
            </div>
            <div class="desc">
                <p>
                    Lorem ipsum dolor sit amet consectetur. Scelerisque sem nunc
                    elementum varius ultricies id. At imperdiet sit leo ultrices
                    quam sit tortor egestas. Et in lectus amet semper
                </p>
            </div>
            <div class="cash-buyer">
                <div class="flex align-items-center">
                    <img
                        src="../../../../public/images/buyer.svg"
                        alt="buyer"
                    />
                    <h4>Cash Buyer Criteria</h4>
                </div>
                <p>Single-Family</p>
                <p>$200,000 - $400,000</p>
                <p>3 Beds & 4 Baths</p>
                <div class="flex align-items-center">
                    <img
                        src="../../../../public/images/target.svg"
                        alt="target"
                    />
                    <h4>Target Market</h4>
                </div>
                <p>Clifornia, Spring Mills, 44040</p>
                <div class="flex align-items-center">
                    <img
                        src="../../../../public/images/profit.svg"
                        alt="profit"
                    />
                    <h4>Minimum Profit Per Deal</h4>
                </div>
                <p>$10,500</p>
            </div>
            <div class="field grid mt-5">
                <div class="col-12">
                    <Button
                        class="p-button-outlined p-button-danger w-full"
                        style="border-radius: 1rem !important"
                        label="Send Message"
                    />
                </div>
            </div>
        </Dialog>

        <Toast />
        <ConfirmDialog />
    </AdminLayout>
</template>

<script>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { Head, useForm } from "@inertiajs/inertia-vue3";
import { FilterMatchMode, FilterOperator } from "primevue/api";
import "flag-icons/css/flag-icons.min.css";
import countries from "../country.json" assert { type: "json" };
import InputError from "@/Components/InputError.vue";

export default {
    name: "Dashboard",
    props: ["cashBuyers"],
    data() {
        return {
            file: "",
            displayBasic: false,
            selectedCashBuyer: null,
            filters: null,
        };
    },
    created() {
        this.initFilters();
    },
    methods: {
        uploadFile() {
            document.getElementById("uploadExcel").click();
        },
        async handleFileUpload(event) {
            this.file = event.target.files[0];
            let formData = new FormData();
            formData.append("file", this.file);
            const res = await axios.post(route("import.cash.buyer"), formData, {
                headers: {
                    "Content-Type": "multipart/form-data",
                },
            });
            this.$toast.add({
                severity: "success",
                summary: "Success",
                detail: res.data.message ?? "Action Successful",
                life: 3000,
            });

            setTimeout(location.reload(), 3000);
        },
        newCashBuyer() {
            location.href = "/cash-buyers-settings";
        },
        editCashBuyer(id) {
            location.href = "/cash-buyers-settings/" + id;
        },
        deleteCashBuyer(cashBuyerId) {
            const del = useForm({ id: cashBuyerId });
            del.post(route("admin.cashbuyer.delete"), {
                onFinish: () => {
                    if (!del.hasErrors) {
                        this.$toast.add({
                            severity: "success",
                            summary: "Success",
                            detail: "Cash Buyer Deleted",
                            life: 3000,
                        });
                    }
                },
            });
        },

        deleteCashBuyerConfirm(cashBuyerId) {
            // this.deleteCashBuyer(cashBuyerId)
            this.$confirm.require({
                message: `Do you want to delete Cash Buyer #${cashBuyerId}?`,
                header: "Delete Confirmation",
                icon: "pi pi-info-circle",
                acceptClass: "p-button-danger",
                accept: () => {
                    this.deleteCashBuyer(cashBuyerId);
                },
                reject: () => {},
            });
        },
        openBasic() {
            this.displayBasic = true;
        },
        closeBasic() {
            this.displayBasic = false;
        },
        removedUserTag(tagId) {
            const left = this.selectedUserTags.filter((sut) => {
                if (sut.tag_id !== tagId) {
                    return true;
                }
                return false;
            });
            this.selectedUserTags = left;
        },
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
        deleteUserConfirm(userId) {
            this.$confirm.require({
                message: `Do you want to delete Cash Buyer #${userId}?`,
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
                name: {
                    operator: FilterOperator.AND,
                    constraints: [
                        { value: null, matchMode: FilterMatchMode.EQUALS },
                    ],
                },
                min_price_range: {
                    operator: FilterOperator.AND,
                    constraints: [
                        { value: null, matchMode: FilterMatchMode.STARTS_WITH },
                    ],
                },
                state: {
                    operator: FilterOperator.AND,
                    constraints: [
                        { value: null, matchMode: FilterMatchMode.STARTS_WITH },
                    ],
                },
                min_profit_deal: {
                    operator: FilterOperator.AND,
                    constraints: [
                        { value: null, matchMode: FilterMatchMode.STARTS_WITH },
                    ],
                },
                action: {
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

<style>
.p-multiselect-panel .p-multiselect-items .p-multiselect-item.p-highlight {
    color: inherit;
    background: rgba(219, 15, 25, 0.12);
}

.p-multiselect-item > .p-checkbox {
    display: none;
}

.p-checkbox .p-checkbox-box.p-highlight:not(.p-disabled).p-focus {
    border-color: rgba(219, 15, 25, 1);
    background: rgba(219, 15, 25, 1);
}

.p-paginator .p-paginator-pages .p-paginator-page.p-highlight {
    background: rgba(219, 15, 25, 0.12);
    border-color: rgba(219, 15, 25, 0.12);
    color: rgba(219, 15, 25, 1);
    font-weight: bold;
}

.p-dropdown-panel .p-dropdown-items .p-dropdown-item.p-highlight {
    color: rgba(219, 15, 25, 1);
    background: rgba(219, 15, 25, 0.12);
}

.vue-slider-process {
    background-color: rgba(219, 15, 25, 1) !important;
}

.vue-slider-dot-tooltip-inner {
    background-color: rgba(219, 15, 25, 1) !important;
    border-color: rgba(219, 15, 25, 1) !important;
}

.vue-slider-rail {
    background-color: rgba(219, 15, 25, 0.2) !important;
}

.vue-slider-mark-step {
    background-color: rgba(219, 15, 25, 0) !important;
}

.vue-slider-dot-handle {
    background: rgba(219, 15, 25, 1);
}

.p-datatable .p-datatable-tbody > tr.p-highlight {
    color: inherit;
    background: rgba(219, 15, 25, 0.12);
}

.p-checkbox:not(.p-checkbox-disabled) .p-checkbox-box.p-highlight:hover {
    border-color: rgba(219, 15, 29, 1);
    background: rgba(219, 15, 29, 1);
    color: #ffffff;
}

.p-checkbox .p-checkbox-box.p-highlight {
    border-color: rgba(219, 15, 29, 1);
    background: rgba(219, 15, 29, 1) !important;
}
</style>

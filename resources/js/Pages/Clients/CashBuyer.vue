<script>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/inertia-vue3";
import Slider from "primevue/slider";
import VueSlider from "vue-slider-component";
import "vue-slider-component/theme/default.css";
import { FilterMatchMode, FilterOperator } from "primevue/api";
import { DomHandler } from "primevue/utils";
import { useForm } from "@inertiajs/inertia-vue3";

export default {
    name: "CashBuyer",
    props: ["cashBuyers"],
    data() {
        return {
            displayBasic: false,
            selectedCashBuyer: null,
            filters: null,
        };
    },
    created() {
        this.initFilters();
    },
    watch: {
        selectedUserTags() {
            this.getProperties();
        },
    },
    computed: {
        propertiesToDisplay() {
            return this.properties.filter(
                (property) => property.uniqueTagCount >= this.tagCount
            );
        },
    },

    methods: {
        openCashBuyer() {
            location.href = "/cash-buyers-settings";
        },
        editCashBuyer() {
            location.href = route("cash.buyer.settings");
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
            this.deleteCashBuyer(cashBuyerId);
        },

        showBuyerDetail(cashBuyer) {
            this.selectedCashBuyer = cashBuyer;
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
        sendMail(email) {
            let mail = document.createElement("a");
            mail.href = `mailto:${email}`;
            mail.click();
        },
        exportCSV() {
            const dataToExport = this.propertiesToDisplay;
            const colToFieldNames = {
                PropertyAddress: "Cash Buyer Name",
                PropertyCity: "Target Market",
                PropertyState: "Price Range",
                PropertyZipCode: "Minimum Profit",
                OwnerName1: "Action",
            };
            const columnNames = Object.values(colToFieldNames);
            const colProperties = Object.keys(colToFieldNames);

            // console.log(columnNames);
            let csv = "\ufeff";
            csv += '"' + columnNames.join('","') + '"';
            if (dataToExport) {
                dataToExport.forEach((row) => {
                    // row
                    csv += "\n";
                    let rowInitiated = false;
                    const rowString = "";

                    // Cols
                    for (let i = 0; i < colProperties.length; i++) {
                        if (rowInitiated) csv += ",";
                        else rowInitiated = true;

                        let column = colProperties[i];
                        let cellData = row[column];

                        if (cellData !== null) {
                            cellData = String(cellData).replace(/"/g, '""');
                        } else {
                            cellData = "";
                        }

                        csv += '"' + cellData + '"';
                    }
                });
            }

            DomHandler.exportCSV(csv, "DealHunterProperties");

            // this.$refs.dt.exportCSV({selectionOnly: false}, this.propertiesToDisplay);
        },
        motivationSliderChange() {
            //console.log(this.tagCount);
        },
        addSelectedMotivationTags() {
            this.selectedUserTags = this.selectedUserTagsModal;
            this.showAddTagsModal = false;
        },
        async getProperties() {
            if (this.getPropertyInterval)
                clearInterval(this.getPropertyInterval);
            this.getPropertyInterval = setInterval(async () => {
                this.loadingProperties = true;
                const res = await axios.post(
                    route("dashboard.properties-data"),
                    { requiredTags: this.selectedUserTags }
                );
                this.properties = res.data.propertyData;
                this.loadingProperties = false;
                clearInterval(this.getPropertyInterval);
            }, 500);
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
    components: { AuthenticatedLayout, Head, Slider, VueSlider },
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

.p-paginator .p-paginator-pages .p-paginator-page.p-highlight {
    background: rgba(63, 81, 181, 0.12) !important;
    color: rgba(0, 0, 0, 0.6);
}
</style>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
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
            <Button
                class="p-button p-button-outlined p-button-danger"
                style="border-radius: 0.5rem !important"
                icon="pi pi-dollar"
                label="Become Cash Buyer"
                @click="this.openCashBuyer()"
            ></Button>
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
                        @click="showBuyerDetail(slotProps.data)"
                    >
                        <i class="pi pi-eye" />
                    </button>
                    <button
                        @click="sendMail(slotProps.data.email)"
                        class="edit-del"
                    >
                        <i class="pi pi-comment" />
                    </button>
                    <!-- <button @click="this.deleteCashBuyerConfirm(slotProps.data.id)">Delete</button> -->
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
                        :src="
                            selectedCashBuyer?.profile_pic
                                ? '/uploads/' + selectedCashBuyer?.profile_pic
                                : '/images/user-img.svg'
                        "
                        alt="user_img"
                    />
                    <div class="user-info">
                        <h4>{{ selectedCashBuyer?.name }}</h4>
                        <p>
                            <img
                                src="../../../../public/images/call.svg"
                                alt="call"
                            />
                            {{ selectedCashBuyer?.contact_no }}
                        </p>
                        <p>
                            <img
                                src="../../../../public/images/mail.svg"
                                alt="mail"
                            />
                            {{ selectedCashBuyer?.email }}
                        </p>
                    </div>
                </div>
            </div>
            <div class="desc">
                <p>{{ selectedCashBuyer?.description }}</p>
            </div>
            <div class="cash-buyer">
                <div class="flex align-items-center">
                    <img
                        src="../../../../public/images/buyer.svg"
                        alt="buyer"
                    />
                    <h4>Cash Buyer Criteria</h4>
                </div>
                <p>{{ selectedCashBuyer?.property_type }}</p>
                <p>
                    ${{ selectedCashBuyer?.min_price_range }} - ${{
                        selectedCashBuyer?.max_price_range
                    }}
                </p>
                <p>3 Beds & 4 Baths</p>
                <div class="flex align-items-center">
                    <img
                        src="../../../../public/images/target.svg"
                        alt="target"
                    />
                    <h4>Target Market</h4>
                </div>
                <p>
                    {{ selectedCashBuyer?.state }},
                    {{ selectedCashBuyer?.city }}, {{ selectedCashBuyer?.zip }}
                </p>
                <div class="flex align-items-center">
                    <img
                        src="../../../../public/images/profit.svg"
                        alt="profit"
                    />
                    <h4>Minimum Profit Per Deal</h4>
                </div>
                <p>${{ selectedCashBuyer?.min_profit_deal }}</p>
            </div>
            <div class="field grid mt-5">
                <div class="col-12">
                    <Button
                        @click="sendMail(selectedCashBuyer?.email)"
                        class="p-button-outlined p-button-danger w-full"
                        style="border-radius: 1rem !important"
                        label="Send Message"
                    />
                </div>
            </div>
        </Dialog>
    </AuthenticatedLayout>
</template>

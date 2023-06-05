<script>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/inertia-vue3";
import Slider from "primevue/slider";
import VueSlider from "vue-slider-component";
import "vue-slider-component/theme/default.css";
import { DomHandler } from "primevue/utils";
import { useForm } from "@inertiajs/inertia-vue3";

export default {
    name: "CashBuyer",
    props: ["cashBuyer"],
    data() {
        return {
            property_types: [
                { name: "Single Family", code: "NY" },
                { name: "Multi Family", code: "RM" },
            ],
            form: useForm({
                name: this.cashBuyer?.name ?? null,
                description: this.cashBuyer?.description ?? null,
                profile_pic: null,
                email: this.cashBuyer?.email ?? null,
                contact_no: this.cashBuyer?.contact_no ?? null,
                min_price_range: this.cashBuyer?.min_price_range ?? null,
                max_price_range: this.cashBuyer?.max_price_range ?? null,
                min_profit_deal: this.cashBuyer?.min_profit_deal ?? null,
                state: this.cashBuyer?.state ?? null,
                city: this.cashBuyer?.city ?? null,
                zip: this.cashBuyer?.zip ?? null,
                property_type: this.cashBuyer?.property_type ?? null,
                beds: this.cashBuyer?.beds ?? null,
                baths: this.cashBuyer?.baths ?? null,
            }),
        };
    },
    methods: {
        addNewCashBuyer() {
            this.form.post(route("save.cash.buyer"), {
                onFinish: () => {
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
                            detail: "Cash buyer saved",
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
                forceFormData: true,
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
</style>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #pageHeading>
            <div class="flex align-items-center">
                <Button
                    class="p-button p-button-outlined p-button-plain mr-3"
                    style="border-radius: 0.5rem !important"
                    icon="pi pi-bars"
                    label="Account"
                ></Button>
                <Button
                    class="p-button p-button-outlined p-button-plain mr-3"
                    style="border-radius: 0.5rem !important"
                    icon="pi pi-home"
                    label="Insta-Offer"
                ></Button>
                <Button
                    class="p-button p-button-outlined p-button-plain mr-3"
                    style="border-radius: 0.5rem !important"
                    icon="pi pi-credit-card"
                    label="Credits"
                ></Button>
                <Button
                    class="p-button p-button-outlined p-button-danger mr-3"
                    style="border-radius: 0.5rem !important"
                    icon="pi pi-dollar"
                    label="Cash Buyer"
                ></Button>
            </div>
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
        <div class="cash-buyer">
            <div class="flex align-items-center mt-0">
                <img src="../../../public/images/profit.svg" alt="profit" />
                <h4>Cash Buyer Settings</h4>
            </div>
        </div>
        <div class="field grid mt-5">
            <div class="col-7 p-0">
                <span class="p-float-label">
                    <InputText
                        id="editpublicName"
                        autofocus
                        class="w-full py-3"
                        type="text"
                        v-model="form.name"
                    />
                    <label for="inputtext">Public Name</label>
                </span>
            </div>
            <div class="col-7 p-0 mt-3">
                <span class="p-float-label">
                    <InputText
                        id="editdescription"
                        autofocus
                        class="w-full py-3"
                        type="text"
                        v-model="form.description"
                    />
                    <label for="inputtext">Short Description</label>
                </span>
            </div>
        </div>
        <div class="buyer-profile">
            <input
                id="imgupload"
                hidden
                type="file"
                @input="form.profile_pic = $event.target.files[0]"
            />
            <div class="flex align-items-center">
                <img
                    class="user-img"
                    accept="image/png, image/gif, image/jpeg"
                    src="../../../public/images/user-img.svg"
                    alt="user_img"
                />
                <div class="user-info">
                    <label for="imgupload">Edit Profile Photo</label>
                </div>
            </div>
        </div>
        <div class="col-7 p-0 mt-3">
            <span class="p-float-label">
                <InputText
                    id="editemail"
                    autofocus
                    class="w-full py-3"
                    type="email"
                    v-model="form.email"
                />
                <label for="inputtext">Email address</label>
            </span>
        </div>
        <div class="col-7 p-0 mt-3">
            <span class="p-float-label">
                <InputText
                    id="editphone"
                    autofocus
                    class="w-full py-3"
                    type="number"
                    v-model="form.contact_no"
                />
                <label for="inputtext">Phone Number (Optional)</label>
            </span>
        </div>
        <div class="cash-buyer">
            <div class="flex align-items-center">
                <img src="../../../public/images/buyer.svg" alt="buyer" />
                <h4>Buyer Criteria</h4>
            </div>
        </div>
        <div class="col-7 p-0 p-0 mt-3">
            <div class="flex align-items-center">
                <div class="col-6 py-0 pl-0">
                    <span class="p-float-label">
                        <InputText
                            id="editminimum"
                            autofocus
                            class="w-full py-3"
                            type="number"
                            v-model="form.min_price_range"
                        />
                        <label for="inputtext">Minimum Price Range</label>
                    </span>
                </div>
                -
                <div class="col-6 py-0 pr-0">
                    <span class="p-float-label">
                        <InputText
                            id="editmaximum"
                            autofocus
                            class="w-full py-3"
                            type="number"
                            v-model="form.max_price_range"
                        />
                        <label for="inputtext">Maximum Price Range</label>
                    </span>
                </div>
            </div>
        </div>
        <div class="col-7 p-0 mt-3">
            <span class="p-float-label">
                <InputText
                    id="editprofit"
                    autofocus
                    class="w-full py-3"
                    type="number"
                    v-model="form.min_profit_deal"
                />
                <label for="inputtext">Minimum Profit Per Deal</label>
            </span>
        </div>
        <div class="cash-buyer">
            <div class="flex align-items-center">
                <img src="../../../public/images/target.svg" alt="target" />
                <h4>Target Market</h4>
            </div>
        </div>
        <div class="col-7 p-0 p-0 mt-3">
            <div class="flex align-items-center">
                <div class="col-4 py-0 pl-0">
                    <span class="p-float-label">
                        <InputText
                            id="editstate"
                            autofocus
                            class="w-full py-3"
                            type="text"
                            v-model="form.state"
                        />
                        <label for="inputtext">State</label>
                    </span>
                </div>
                <div class="col-4 py-0 p-0">
                    <span class="p-float-label">
                        <InputText
                            id="editcity"
                            autofocus
                            class="w-full py-3"
                            type="text"
                            v-model="form.city"
                        />
                        <label for="inputtext">City</label>
                    </span>
                </div>
                <div class="col-4 py-0 pr-0">
                    <span class="p-float-label">
                        <InputText
                            id="editzipcode"
                            autofocus
                            class="w-full py-3"
                            type="number"
                            v-model="form.zip"
                        />
                        <label for="inputtext">Zip Code</label>
                    </span>
                </div>
            </div>
        </div>
        <div class="col-7 p-0 mt-3">
            <Dropdown
                v-model="form.property_type"
                class="w-full py-2"
                :options="property_types"
                optionLabel="name"
                optionValue="code"
                placeholder="Select a Property Type"
            />
        </div>
        <div class="col-7 p-0 p-0 mt-3">
            <div class="flex align-items-center">
                <div class="col-6 py-0 pl-0">
                    <span class="p-float-label">
                        <InputText
                            id="editbed"
                            autofocus
                            class="w-full py-3"
                            type="number"
                            v-model="form.beds"
                        />
                        <label for="inputtext">Beds</label>
                    </span>
                </div>
                -
                <div class="col-6 py-0 pr-0">
                    <span class="p-float-label">
                        <InputText
                            id="editbath"
                            autofocus
                            class="w-full py-3"
                            type="number"
                            v-model="form.baths"
                        />
                        <label for="inputtext">Baths</label>
                    </span>
                </div>
            </div>

            <button
                class="p-button p-component p-button p-button-outlined p-button-danger mr-3 mt-3"
                :disabled="form.processing"
                @click="addNewCashBuyer"
                autofocus
                aria-label="Cash Buyer"
                style="border-radius: 0.5rem !important"
            >
                <!----><span class="p-button-label">Save</span
                ><!----><span
                    class="p-ink"
                    role="presentation"
                    aria-hidden="true"
                ></span>
            </button>
        </div>

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
                        src="../../../public/images/user-img.svg"
                        alt="user_img"
                    />
                    <div class="user-info">
                        <h4>John Smith</h4>
                        <p>
                            <img
                                src="../../../public/images/call.svg"
                                alt="call"
                            />
                            +1 212 653 0333
                        </p>
                        <p>
                            <img
                                src="../../../public/images/mail.svg"
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
                    <img src="../../../public/images/buyer.svg" alt="buyer" />
                    <h4>Cash Buyer Criteria</h4>
                </div>
                <p>Single-Family</p>
                <p>$200,000 - $400,000</p>
                <p>3 Beds & 4 Baths</p>
                <div class="flex align-items-center">
                    <img src="../../../public/images/target.svg" alt="target" />
                    <h4>Target Market</h4>
                </div>
                <p>Clifornia, Spring Mills, 44040</p>
                <div class="flex align-items-center">
                    <img src="../../../public/images/profit.svg" alt="profit" />
                    <h4>Minimum Profit Per Deal</h4>
                </div>
                <p>$10,500</p>
            </div>
            <div class="field grid mt-5">
                <div class="col-12">
                    <Button
                        class="p-button-outlined p-button-danger w-full"
                        label="Send Message"
                    />
                </div>
            </div>
        </Dialog>
    </AuthenticatedLayout>
</template>

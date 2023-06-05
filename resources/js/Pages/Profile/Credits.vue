<script>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/inertia-vue3";
import Slider from "primevue/slider";
import VueSlider from "vue-slider-component";
import "vue-slider-component/theme/default.css";
import { DomHandler } from "primevue/utils";
import { useForm, usePage } from "@inertiajs/inertia-vue3";
import { Link } from "@inertiajs/inertia-vue3";

import HeaderMenu from "./HeaderMenu.vue";

var stripe;
var card, elements;
export default {
    name: "Dashboard",
    props: ["addedCard", "plansList", "purchases"],
    async mounted() {
        const user = usePage().props.value.auth.user;
        this.credits = user.total_credits;
        const form = useForm({});
        stripe = Stripe(usePage().props.value.STRIPE_KEY);
        if (user.stripe_id != null && user.stripe_id != "") {
            this.card = "Update Card";
            this.updateMode = true;
        }
    },
    data() {
        return {
            plan_sel: null,
            displayCard: false,
            stripeToken: null,
            stripe: null,
            card: "Add Card",
            addedCardList: this.addedCard,
            updateMode: false,
            credits: 0,
            plans: this.plansList,
            purchaseLogs: this.purchases,
        };
    },
    watch: {},
    computed: {},
    methods: {
        displayStripe() {
            this.displayCard = true;
            setTimeout(this.processStripe, 50);
        },
        processStripe() {
            elements = stripe.elements();

            card = elements.create("card", {
                hidePostalCode: true,
                style: {
                    base: {
                        iconColor: "#666EE8",
                        color: "#31325F",
                        lineHeight: "40px",
                        fontWeight: 300,
                        fontFamily: "Helvetica Neue",
                        fontSize: "15px",

                        "::placeholder": {
                            color: "#CFD7E0",
                        },
                    },
                },
            });
            card.mount("#card-element");

            async function setOutcome(result) {
                var successElement = document.querySelector(".success");
                var errorElement = document.querySelector(".error");
                successElement.classList.remove("visible");
                errorElement.classList.remove("visible");
            }

            card.on("change", function (event) {
                setOutcome(event);
            });
        },
        async submitToken(result) {
            if (result.token) {
                var token = result.token.id;
                $("#stripeToken").val(token);
                const res = await axios({
                    url: "/add_card",
                    method: "POST",
                    data: { token: token },
                    headers: {
                        "content-type": "multipart/form-data",
                    },
                });
                if (res.data.status === "success") {
                    this.updateMode = true;
                    // this.displayCard = false;
                    this.addedCardList = res.data.card;
                    this.$toast.add({
                        severity: "success",
                        summary: "Success",
                        detail: res.data.message ?? "Action Successful",
                        life: 3000,
                    });
                }
            } else if (result.error) {
                errorElement.textContent = result.error.message;
                errorElement.classList.add("visible");
            }
        },
        async saveCard() {
            var result = stripe.createToken(card, {}).then(this.submitToken);
        },
        async selectPlan($id) {
            this.plan_sel = $id;
            this.confirm();
        },
        async purchase() {
            const res = await axios({
                url: "/credit_topup",
                method: "POST",
                data: { plan: this.plan_sel },
                headers: {
                    "content-type": "multipart/form-data",
                },
            });
            if (res.data.status === "success") {
                this.credits = res.data.credits;
                this.purchaseLogs = res.data.purchases;
                // this.updateMode = true;
                // this.displayCard = false;
                // this.addedCardList = res.data.card;
                this.$toast.add({
                    severity: "success",
                    summary: "Success",
                    detail: res.data.message ?? "Action Successful",
                    life: 3000,
                });
            }
            if (res.data.status === "error") {
                this.updateMode = true;
                // this.displayCard = false;
                this.$toast.add({
                    severity: "error",
                    summary: "Error",
                    detail: res.data.message ?? "Action unSuccessful",
                    life: 3000,
                });
            }
        },
        confirm() {
            this.$confirm.require({
                message: "Are you sure you want to proceed?",
                header: "Confirmation",
                icon: "pi pi-exclamation-triangle",
                accept: () => {
                    this.purchase();
                },
                reject: () => {
                    this.plan_sel = null;
                },
                onShow: () => {
                    //callback to execute when dialog is shown
                },
                onHide: () => {
                    //callback to execute when dialog is hidden
                },
            });
        },
    },
    components: { AuthenticatedLayout, Head, Slider, VueSlider, Link },
};
</script>
<style>
.navbuttons {
    /* Stroke */

    background: #ffffff;
    /* Stroke */

    border: 1px solid #e6eaed;
    border-radius: 8px;
    border-radius: 8px;
    font-family: "Nunito";
    font-style: normal;
    font-weight: 400;
    font-size: 14px;
    line-height: 19px;
    /* identical to box height */

    /* Text 2 */

    color: #575a7b;
}

.navbuttons:hover {
    border-color: transparent;
    background: rgba(219, 15, 25, 0.1) !important;
    border-radius: 8px;
    font-family: "Nunito";
    font-style: normal;
    font-weight: 400;
    font-size: 14px;
    line-height: 19px;
    /* identical to box height */

    /* Primary */

    color: #db0f19 !important;
}

.table {
    /* border-radius: 10px;
        border: 1px solid #f1efef; */
}

.thead-light th {
    padding-top: 15px;
    padding-bottom: 15px;
}

.thead-light {
    background: #f1efef;
    font-family: "Nunito";
    font-style: normal;
    font-weight: 400;
    font-size: 14px;
    line-height: 19px;
    /* identical to box height */

    text-transform: uppercase;

    /* Text 2 */

    color: #575a7b;
}
.success,
.error {
    visibility: hidden;
}

#card-element {
    border: 1px solid #cdcaca;
    padding: 5px;
    border-radius: 8px;
}

.cred-con-c {
    background: #ffffff;
    border: 1px solid #ebebeb;

    text-align: center;
    height: 50px;
    width: 116px;
}
.cred-con-c a {
    font-weight: 700;
}

.cred-con-ba {
    border-radius: 10px;
}

.cred-con-bl {
    border-top-left-radius: 10px;
    border-bottom-left-radius: 10px;
}

.cred-con-br {
    border-top-right-radius: 10px;
    border-bottom-right-radius: 10px;
}

.pkg-box {
    background: #ffffff;
    border: 1px solid #ebebeb;
    border-radius: 15px;
}

.pkg-box h6 {
    font-family: "Nunito";
    font-style: normal;
    font-weight: 600;
    font-size: 28px;
    line-height: 38px;
    text-align: center;
    background: #fafafa;
    border-radius: 14px 14px 0px 0px;
    color: #000000;
}
.offer-input input {
    border: none;
    width: 100%;
}

.offer-input input:focus {
    border: none;
    outline: none;
}
.p-texts {
    font-family: "Nunito";
    font-style: normal;
    font-weight: 500;
    font-size: 24px;
    line-height: 33px;
    /* identical to box height */

    /* Text 1 */

    color: #101136;
}

.offer-input {
    /* Stroke */

    border: 1px solid #e6eaed;
    border-radius: 5px;
    width: 55px;
}

table {
    width: 100%;
    border-spacing: 0;
    border-collapse: separate;
}

table tr:last-child td:last-child {
    border-bottom-right-radius: 10px;
}

table tr:last-child td:first-child {
    border-bottom-left-radius: 10px;
}

table th:first-child,
table td:first-child {
    border-top-left-radius: 10px;
}

table th:last-child,
table td:last-child {
    border-top-right-radius: 10px;
}

table tr th:first-child,
table tr td:first-child {
    /* border-left: 2px solid #B2DBF4; */
}
table tr:first-child th,
table tr:first-child td {
    /* border-top: 2px solid #B2DBF4; */
}
</style>

<template>
    <Head title="Profile" />

    <AuthenticatedLayout>
        <template #pageHeading>
            <div class="d-flex">
                <Link
                    :href="route('profile.edit')"
                    :class="['p-ripple']"
                    class="navbuttons py-3 mr-3 px-3"
                    exact
                    role="menuitem"
                    v-ripple
                >
                    <div class="w-100" style="align-items: center">
                        <i class="pi pi-user mr-2"></i>
                        <span> Account</span>
                    </div>
                </Link>

                <Link
                    :href="route('profile.insta')"
                    :class="['p-ripple']"
                    class="navbuttons py-3 mr-3 px-3"
                    exact
                    role="menuitem"
                    v-ripple
                >
                    <div class="w-100" style="align-items: center">
                        <i class="pi pi-home mr-2"></i>
                        <span> Insta-Offer</span>
                    </div>
                </Link>

                <Link
                    :href="route('credits')"
                    :class="['p-ripple']"
                    class="navbuttons py-3 mr-3 px-3"
                    exact
                    role="menuitem"
                    v-ripple
                >
                    <div class="w-100" style="align-items: center">
                        <i class="pi pi-credit-card mr-2"></i>
                        <span> Credits</span>
                    </div>
                </Link>
            </div>
        </template>
        <div class="">
            <span class="p-texts">
                <i class="pi pi-credit-card text-3xl mr-2 font-bold" />
                <span class="mr-3"><strong>Credit Card</strong></span>
            </span>
        </div>

        <div class="mt-3">
            <Button
                :label="card"
                @click="displayStripe"
                class="p-button-danger p-button-outlined px-5"
                style="border-radius: 8px"
            />
        </div>

        <div class="mt-4 d-flex">
            <div class="d-flex mr-5">
                <span class="p-texts my-auto me-2">
                    <i class="pi pi-credit-card text-3xl mr-2 font-bold" />
                    <span class="mr-3"><strong>Buy Credits</strong></span>
                </span>
                <div class="cred-con-c my-auto cred-con-ba">
                    <div class="h-100 p-1 cred-text">
                        <span class="creditBalance">{{
                            credits.toLocaleString("en-US")
                        }}</span>
                        <br />
                        <span>Credit Balance</span>
                    </div>
                </div>
            </div>

            <div class="ms-2 cred-con-c my-auto cred-con-bl">
                <div class="p-1 cred-text d-flex h-100">
                    <span class="m-auto creditBalance">Price Chart</span>
                </div>
            </div>

            <div class="cred-con-c my-auto">
                <div class="h-100 p-1 cred-text">
                    <span class="creditBalance">$0.20</span>
                    <br />
                    <span>Per Credit</span>
                </div>
            </div>

            <div class="cred-con-c my-auto">
                <div class="h-100 p-1 cred-text">
                    <span class="creditBalance">1 Credit</span>
                    <br />
                    <span>Per RoboDrop</span>
                </div>
            </div>

            <div class="cred-con-c my-auto">
                <div class="h-100 p-1 cred-text">
                    <span class="creditBalance">3 Credit</span>
                    <br />
                    <span>Per DirectMail</span>
                </div>
            </div>

            <div class="cred-con-c my-auto cred-con-br">
                <div class="h-100 p-1 cred-text">
                    <span class="creditBalance">0.5 Credit</span>
                    <br />
                    <span>Per Insta-Lead</span>
                </div>
            </div>

            <!-- <div class=" cred-con-c my-auto" >
                <div class="h-100 p-1 cred-text">
                    <span class="creditBalance">0.5 Credit</span>
                    <span>Per Skip Trace</span>
                </div>
            </div>

            <div class=" cred-con-c my-auto" >
                <div class="h-100 p-1 cred-text">
                    <span class="creditBalance">0.1 Credit</span>
                    <span>Per Website Optin</span>
                </div>
            </div> -->
        </div>

        <div class="row mt-4">
            <div class="col-md-4 mt-3" v-for="plan in plans" :key="plan.id">
                <div class="pkg-box text-center">
                    <h6 class="p-3">{{ plan.name }}</h6>

                    <div class="m-3">
                        <Button
                            :data-plan_id="plan.id"
                            @click="selectPlan(plan.id)"
                            class="p-button-danger p-button-outlined px-5 w-100 d-flex"
                            style="border-radius: 8px"
                        >
                            <span class="m-auto">Pay ${{ plan.price }}</span>
                        </Button>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-4 d-flex">
            <span class="p-texts my-auto">
                <i class="pi pi-history text-3xl mr-2 font-bold" />
                <span class="mr-3"><strong>Purchase History</strong></span>
            </span>
        </div>

        <div>
            <table class="table mt-4 pb-5">
                <thead class="thead-light">
                    <tr>
                        <th class="px-4">Date Purchased</th>
                        <th>Credits</th>
                        <th>Price</th>
                        <th>Card</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="pur in purchaseLogs" :key="pur.id">
                        <td class="px-4">
                            <i class="pi pi-calendar mr-2"></i>
                            {{ pur.created_at }}
                        </td>
                        <td>{{ pur.credits }}</td>
                        <td>{{ pur.price }}</td>
                        <td>{{ pur.card }}</td>
                    </tr>
                </tbody>
            </table>
            <!-- <DataTable :value="purchaseLogs"
                   ref="dt"
                   :paginator="true"
                   :rows="10"
                   dataKey="id"
                   v-model:selection="purchaseLogs"
                   :rowHover="true"
                   paginatorTemplate="CurrentPageReport FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink"
                   :rowsPerPageOptions="[10,25,50]"
                   currentPageReportTemplate="Showing {first} to {last} of {totalRecords} entries"
                   responsiveLayout="scroll">

                    <Column field="created_at"
                            header="Date Purchased"
                            exportFooter="Date Purchased"
                            style="min-width: 14rem"/>
                    <Column field="PropertyCity" header="Credits" exportFooter="Credits" style="min-width: 10rem"/>
                    <Column field="PropertyState"
                            header="Price"
                            exportFooter="Price"
                            style="min-width: 12rem"/>
                    <Column field="PropertyZipCode" header="Card" exportFooter="Card" style="min-width: 10rem"/>

        </DataTable> -->
        </div>

        <Dialog
            header=""
            :draggable="false"
            v-model:visible="this.displayCard"
            :style="{ width: '32vw' }"
            :modal="true"
        >
            <template #header>
                <div
                    class="flex justify-content-between align-items-center"
                    style="width: 90%"
                >
                    <span class="p-dialog-title">{{ card }}</span>
                    <!-- <a :href="route('downloadTemplate')"
                    class="p-button p-button-danger p-button-text underline text-sm">
                        <i class="pi pi-download mr-2"></i>Download Template
                    </a> -->
                </div>
            </template>
            <form @submit.prevent="saveCard">
                <div class="">
                    <div class="field col-12 px-0 mb-0 mt-3">
                        <div class="success"></div>
                        <div class="error"></div>
                        <div id="card-element" class="field mb-0"></div>
                        <input type="hidden" id="stripeToken" />
                    </div>

                    <div v-if="this.addedCardList != null">
                        <h6 class="p-dialog-title mt-3">Existing Card</h6>

                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Type</th>
                                    <th>Last 4 card #</th>
                                    <th>Date Added</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ addedCardList.brand }}</td>
                                    <td>{{ addedCardList.card_number }}</td>
                                    <td>{{ addedCardList.created_at }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!--Upload Button -->
                    <div class="d-flex">
                        <div class="field col-6 mt-2 mb-0">
                            <Button
                                class="p-button p-button-outlined p-button-danger w-full py-3"
                                style="border-radius: 0.5rem !important"
                                @click="displayCard = false"
                            >
                                <div class="w-100" style="align-items: center">
                                    <span>Close</span>
                                </div>
                            </Button>
                        </div>

                        <div class="field col-6 mt-2 mb-0">
                            <Button
                                class="p-button p-button-outlined p-button-danger w-full py-3"
                                style="border-radius: 0.5rem !important"
                                @click="saveCard"
                            >
                                <div class="w-100" style="align-items: center">
                                    <span>{{ card }}</span>
                                </div>
                            </Button>
                        </div>
                    </div>
                </div>
            </form>
        </Dialog>
    </AuthenticatedLayout>

    <Toast />
    <ConfirmDialog />
</template>

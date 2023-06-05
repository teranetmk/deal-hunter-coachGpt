<script setup>
import { useSlots } from "vue";

// this const will be avaiable on template
const slots = useSlots();
</script>
<script>
import AppMenu from "./AppMenu.vue";
import AppFooter from "./AppFooter.vue";

import { Link, useForm, usePage } from "@inertiajs/inertia-vue3";
var stripe;
var card, elements;
var url = "compaigns.list";
export default {
    data() {
        return {
            paymentProcessing: false,
            isNotPremium: false,
            plan_sel: null,
            displayCard: false,
            stripeToken: null,
            stripe: null,
            card: "Upgrade membership",
            addedCardList: this.addedCard,
            updateMode: false,
            user: null,
            layoutMode: "static",
            staticMenuInactive: false,
            overlayMenuActive: false,
            mobileMenuActive: false,
            robo: "compaigns.list",
            menu: [
                {
                    label: "Main",
                    icon: "",
                    items: [
                        {
                            label: "Dashboard",
                            icon: "pi pi-th-large",
                            to: "dashboard",
                        },
                        {
                            label: "Lists",
                            icon: "pi pi-book",
                            to: "users.lists.get",
                        },
                        {
                            label: "Calculators",
                            icon: "pi pi-calculator",
                            to: "users.calculator.index",
                        },
                        {
                            label: "Contracts",
                            icon: "pi pi-book",
                            to: "contracts.index",
                        },
                        {
                            label: "Calendar",
                            icon: "pi pi-calendar",
                            to: "calendar.index",
                        },
                        {
                            label: "Pipeline",
                            img: "/images/icons/pipeline.png",
                            to: usePage().props.value.auth.user.is_premium
                                ? "pipelines.list"
                                : "",
                            upgrade: usePage().props.value.auth.user.is_premium
                                ? false
                                : true,
                        },
                        {
                            label: "INSTA-LEADS™",
                            to: usePage().props.value.auth.user.is_premium
                                ? "insta_leads.index"
                                : "",
                            icon: "pi pi-home",
                            upgrade: usePage().props.value.auth.user.is_premium
                                ? false
                                : true,
                        },
                        {
                            label: "Lead Machine",
                            to: usePage().props.value.auth.user.is_premium
                                ? "leads.list"
                                : "",
                            img: "/images/icons/world.png",
                            upgrade: usePage().props.value.auth.user.is_premium
                                ? false
                                : true,
                        },

                        {
                            label: "Direct Mail",
                            to: usePage().props.value.auth.user.is_premium
                                ? "insta.list"
                                : "",
                            img: "/images/icons/home.png",
                            upgrade: usePage().props.value.auth.user.is_premium
                                ? false
                                : true,
                        },

                        // {label: 'A.I. RoboDrop', img: "/images/icons/sound.svg", to: "compaigns.list", upgrade: true},
                        // {label: 'Cash Buyers', img: "/images/icons/cash.svg", to: "users.lists.get", upgrade: true},

                        {
                            label: "A.I. RoboDrop",
                            img: "/images/icons/sound.svg",
                            to: usePage().props.value.auth.user.is_premium
                                ? "compaigns.list"
                                : "",
                            upgrade: usePage().props.value.auth.user.is_premium
                                ? false
                                : true,
                        },
                        {
                            label: "Cash Buyers",
                            img: "/images/icons/cash.svg",
                            to: usePage().props.value.auth.user.is_premium
                                ? "cash.buyers"
                                : "",
                            upgrade: usePage().props.value.auth.user.is_premium
                                ? false
                                : true,
                        },
                        // {label: 'Cash Buyers', icon: "pi pi-th-large", to: "cash.buyers"},
                        {
                            label: "Settings",
                            icon: "pi pi-cog",
                            to: "profile.edit",
                        },
                    ],
                },
                // {
                //     label: 'IMG', icon: "", items: [
                //         {label: 'share', icon: "pi pi-sign-out", to: "dashboard"},
                //     ]
                // },
                {
                    label: "SO",
                    icon: "",
                    items: [
                        {
                            label: "Logout",
                            icon: "pi pi-sign-out",
                            to: "signout",
                        },
                    ],
                },
                {
                    label: "RSCG",
                    icon: "",
                    items: [
                        {
                            label: "Real Estate CoachGPT",
                            img: "/images/icons/cash.svg",
                            to: "coach-gpt.index",
                        },
                    ],
                },
            ],
        };
    },
    watch: {
        $route() {
            this.menuActive = false;
            this.$toast.removeAllGroups();
        },
    },
    mounted() {
        const usr = usePage().props.value.auth.user;

        if (usr.total_credits < 1) {
            url = "credits";
        }

        this.isNotPremium = !usr.is_premium;

        const form = useForm({});
        stripe = Stripe(usePage().props.value.STRIPE_KEY);
        // if(user.stripe_id != null && user.stripe_id != "") {
        // this.card = "Upgrade membership";
        this.updateMode = false;
        // }
        // this.displayStripe();
    },
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
                this.paymentProcessing = true;
                var token = result.token.id;
                $("#stripeToken").val(token);
                const res = await axios({
                    url: "/upgrade-membership",
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

                    setTimeout(location.reload(), 3000);
                }
            } else if (result.error) {
                errorElement.textContent = result.error.message;
                errorElement.classList.add("visible");
            }
        },
        async saveCard() {
            var result = stripe.createToken(card, {}).then(this.submitToken);
        },
        onWrapperClick() {
            if (!this.menuClick) {
                this.overlayMenuActive = false;
                this.mobileMenuActive = false;
            }

            this.menuClick = false;
        },
        onMenuToggle() {
            this.menuClick = true;

            if (this.isDesktop()) {
                if (this.layoutMode === "overlay") {
                    if (this.mobileMenuActive === true) {
                        this.overlayMenuActive = true;
                    }

                    this.overlayMenuActive = !this.overlayMenuActive;
                    this.mobileMenuActive = false;
                } else if (this.layoutMode === "static") {
                    this.staticMenuInactive = !this.staticMenuInactive;
                }
            } else {
                this.mobileMenuActive = !this.mobileMenuActive;
            }

            event.preventDefault();
        },
        onSidebarClick() {
            this.menuClick = true;
        },
        onMenuItemClick(event) {
            if (event.item && !event.item.items) {
                this.overlayMenuActive = false;
                this.mobileMenuActive = false;
            }
        },
        onLayoutChange(layoutMode) {
            this.layoutMode = layoutMode;
        },
        addClass(element, className) {
            if (element.classList) element.classList.add(className);
            else element.className += " " + className;
        },
        removeClass(element, className) {
            if (element.classList) element.classList.remove(className);
            else
                element.className = element.className.replace(
                    new RegExp(
                        "(^|\\b)" + className.split(" ").join("|") + "(\\b|$)",
                        "gi"
                    ),
                    " "
                );
        },
        isDesktop() {
            return window.innerWidth >= 992;
        },
        isSidebarVisible() {
            if (this.isDesktop()) {
                if (this.layoutMode === "static")
                    return !this.staticMenuInactive;
                else if (this.layoutMode === "overlay")
                    return this.overlayMenuActive;
            }

            return true;
        },
    },
    computed: {
        containerClass() {
            return [
                "layout-wrapper",
                {
                    "layout-overlay": this.layoutMode === "overlay",
                    "layout-static": this.layoutMode === "static",
                    "layout-static-sidebar-inactive":
                        this.staticMenuInactive && this.layoutMode === "static",
                    "layout-overlay-sidebar-active":
                        this.overlayMenuActive && this.layoutMode === "overlay",
                    "layout-mobile-sidebar-active": this.mobileMenuActive,
                    "p-input-filled":
                        this.$primevue.config.inputStyle === "filled",
                    "p-ripple-disabled": this.$primevue.config.ripple === false,
                },
            ];
        },
        logo() {
            return this.$appState.darkTheme
                ? "images/logo-white.png"
                : "images/logo.png";
        },
    },
    beforeUpdate() {
        if (this.mobileMenuActive)
            this.addClass(document.body, "body-overflow-hidden");
        else this.removeClass(document.body, "body-overflow-hidden");
    },
    components: {
        AppMenu: AppMenu,
        AppFooter: AppFooter,
    },
};
</script>
<style lang="scss">
@import "./App.scss";

body.p-overflow-hidden {
    overflow: auto !important;
}

.p-confirm-dialog-reject .p-button-label {
    color: #000000 !important;
}

.p-confirm-dialog-accept {
    background: #000000 !important;
}

.layout-menuitem-root-text {
    display: none !important;
}

.card {
    box-shadow: none !important;
    border: 1px solid #ebebeb !important;
    border-radius: 10px !important;
}

.d-flex {
    flex-wrap: wrap;
}

a,
label {
    color: #000000 !important;
}

.layout-sidebar {
    top: 0;
    left: 0;
    width: 240px;
    height: 100vh;
}

.layout-wrapper .layout-sidebar {
    transform: none !important;
    left: 0;
    top: 0;
    height: 100vh;
    border-top-left-radius: 0;
    border-bottom-left-radius: 0;
}

.layout-wrapper.layout-static .layout-main-container {
    margin-left: 240px !important;
}
.layout-wrapper.layout-static .layout-main-container.coach-gpt-layout {
    margin-left: 180px !important;
    padding: 7rem 0 2rem 4rem !important;
}
.top-bar-container-c {
    position: fixed;
    height: 5rem;
    z-index: 997;
    left: 240px;
    top: 0;
    width: calc(100% - 240px) !important;
    padding: 0 2rem;
    background-color: var(--surface-card);
    transition: left 0.2s;
    display: flex;
    // margin-top:25px;
    justify-content: space-between !important;
    align-items: center;
    box-shadow: 0 3px 5px #00000005, 0 0 2px #0000000d, 0 1px 4px #00000014;
}

.share-card {
    border: 1px solid #ebebeb;
    border-radius: 15px;
}

.share-heading {
    font-family: "Nunito";
    font-style: normal;
    font-weight: 600;
    font-size: 16px;
    line-height: 25px;
    /* identical to box height */

    /* Text 1 */

    color: #101136;
    text-align: center;
}

.share-heading-inner {
    font-family: "Nunito";
    font-style: normal;
    font-weight: 400;
    font-size: 12px;
    line-height: 16px;

    /* Text 1 */

    color: #101136;
    text-align: center;
}

.d-flex {
    display: flex;
}

.shares-number {
    font-family: "Nunito";
    font-style: normal;
    font-weight: 400;
    font-size: 20px;
    line-height: 27px;

    /* Text 1 */

    color: #101136;
    margin-left: 12px;
}

.justtify-between {
    justify-content: space-between;
}

.btn-fb {
    width: 62px;
    height: 40px;
    background: #3b5998;
    border-radius: 8px;
    border: none;
    outline: none;
}

.btn-mail {
    width: 62px;
    height: 40px;
    background: #0cb427;
    border-radius: 8px;
    border: none;
    outline: none;
}

.upgrade-container {
    display: flex;
    flex-direction: row;
    align-items: center;
    padding: 3px 10px;
    gap: 5px;
    border: 1px solid #db0f19;
    border-radius: 22px;
    width: 117.33px;
    font-family: "Nunito";
    font-style: normal;
    font-weight: 500;
    font-size: 9px;
    line-height: 14px;
    /* identical to box height */

    /* Primary */

    color: #db0f19;
}

.tag-t {
    font-size: 16px;
}

.tag-i {
    width: 16px;
}

.round-border {
    border: 1px solid #e6eaed;
    border-radius: 5px;
}
.u_ndnddn .p-dialog-header .p-dialog-header-icons {
    order: -1;
}

.p-dialog.u_ndnddn .p-dialog-header {
    position: absolute;
    padding: 0;
    top: 3%;
}

.u_fnt-22 {
    font-size: 22px;
    font-weight: 500;
    font-family: Nunito;
}

.u_ndnddn {
    background-color: #fff;
    border-radius: 10px;
    padding: 20px 10px;
}

.u_mdl_fnt_14px {
    font-size: 14px;
}

.u_ndnddn .p-dialog-content::-webkit-scrollbar,
.u_ndnddn .p-dialog-content::-webkit-scrollbar-thumb,
.u_ndnddn .p-dialog-content::-webkit-scrollbar-track {
    display: none;
}

.u_ndnddn .p-dialog-content {
    -ms-overflow-style: none;
    /* IE and Edge */
    scrollbar-width: none;
}
.btn-unlock:hover {
    // background-color: #D32F2F;
    background: rgba(211, 47, 47, 0.04);
}
.layout-menu li a{
    padding: 0.75rem 10px;
}
</style>

<template>
    <div :class="containerClass" @click="onWrapperClick">
        <div class="layout-sidebar" @click="onSidebarClick">
            <AppMenu :model="menu" @menuitem-click="onMenuItemClick" />
        </div>

        <div
            class="layout-main-container"
            v-bind:class="[{'layout-main-container-leads' : !slots.pageHeading}, {'coach-gpt-layout' : slots.coachGPT}]"

        >
            <div v-if="slots.pageHeading" class="top-bar-container-c">
                <slot name="pageHeading" />
                <slot name="coachGPT"/>
            </div>
            <div class="layout-main">
                <slot />
            </div>
        </div>
    </div>

    <Dialog
        header=""
        :draggable="false"
        v-model:visible="displayCard"
        :style="{ width: '32vw' }"
        :modal="true"
    >
        <template #header>
            <div
                class="flex justify-content-between align-items-center"
                style="width: 90%"
            >
                <span class="p-dialog-title font-bold">{{ this.card }}</span>
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

                <!--Upload Button -->
                <div class="d-flex">
                    <div class="field col-6 mt-2">
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

                    <div class="field col-6 mt-2">
                        <Button
                            :disabled="paymentProcessing"
                            class="p-button p-button-outlined p-button-danger w-full py-3"
                            style="border-radius: 0.5rem !important"
                            @click="saveCard"
                        >
                            <div class="w-100" style="align-items: center">
                                <span>Pay 997$</span>
                            </div>
                        </Button>
                    </div>
                </div>
            </div>
        </form>
    </Dialog>

    <!--Load Modal-->
    <Dialog
        class="u_ndnddn"
        v-model:visible="isNotPremium"
        :draggable="false"
        :modal="true"
    >
        <h3 class="text-center mt-0 u_fnt-22 font-bold">
            Upgrade To DealHunter.ai 360 And Try Out <br />
            Our NEW A.I. Powered INSTA-OFFER&#8482; <br />
            Technology Suite RISK FREE For 90 Days!
        </h3>

        <p class="text-center u_mdl_fnt_14px">
            Our Cutting-Edge Technology Leverages The Power Of A.I. To AUTOMATE
            <br />
            Your Wholesaling/Flipping Business Down To Just A Couple Clicks A
            Day!
        </p>
        <div>
            <!-- <video width="520px" height="240px" poster="">
                        <source src="" type="video/mp4">
                        <source src="" type="video/ogg">
                        <source src="" type="video/webm">
                    </video> -->
            <div
                class="wistia_responsive_padding"
                style="padding: 56.25% 0 0 0; position: relative"
            >
                <div
                    class="wistia_responsive_wrapper"
                    style="
                        height: 100%;
                        left: 0;
                        position: absolute;
                        top: 0;
                        width: 100%;
                    "
                >
                    <div
                        class="wistia_embed wistia_async_n2nr5pvma4 videoFoam=true"
                        style="height: 100%; position: relative; width: 100%"
                    >
                        <div
                            class="wistia_swatch"
                            style="
                                height: 100%;
                                left: 0;
                                opacity: 0;
                                overflow: hidden;
                                position: absolute;
                                top: 0;
                                transition: opacity 200ms;
                                width: 100%;
                            "
                        >
                            <img
                                src="https://fast.wistia.com/embed/medias/n2nr5pvma4/swatch"
                                style="
                                    filter: blur(5px);
                                    height: 100%;
                                    object-fit: contain;
                                    width: 100%;
                                "
                                alt=""
                                aria-hidden="true"
                                onload="this.parentNode.style.opacity=1;"
                            />
                        </div>
                    </div>
                </div>
            </div>

            <!-- <img src="../../../public/assets/images/Rectangle_2.png" style="width:100%" /> -->
        </div>
        <div class="justify-content-center my-4">
            <img
                src="../../../public/assets/images/Rectangle_3.png"
                style="width: 100%"
            />
        </div>

        <div
            @click="displayStripe()"
            class="btn-unlock border border-danger text-danger text-center rounded p-3"
            style="cursor: pointer"
        >
            <h6 class="mb-0 font-bold">
                YES! Upgrade To DealHunter.ai 360 Now!
            </h6>
            <p class="u_mdl_fnt_14px">
                Get Instant Lifetime Access To Our Entire INSTA-OFFER&#8482;
                Technology Suite!
            </p>
        </div>
    </Dialog>
    <Toast />
</template>

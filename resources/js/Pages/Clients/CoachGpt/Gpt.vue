<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import HeaderMenu from "./Partials/HeaderMenu.vue";
import Home from "./Partials/Home.vue";

import { Head } from "@inertiajs/inertia-vue3";

</script>

<template>
    <Head title="Real Estate CoachGPT" />

    <AuthenticatedLayout>
        <Head><title>Real Estate CoachGPT</title></Head>
        <template v-if="hasAnswers" #coachGPT />
        <template #pageHeading>
            <div style="display: flex;">
                <img alt="Logo" class="mr-1 mb-2" src="../../../../../public/images/icons/robot.png"/>
                <span class="text-2xl mr-3" style="margin-bottom: 1px;"><strong
                >Real Estate CoachGPT</strong
                ></span
                >
            </div>
            <!-- nav start here -->
            <HeaderMenu :user="user" />
        </template>
        <Home :user="user" @updateBalance="setUserBalance" @setHasAnswers="hasAnswersMethod"/>
    </AuthenticatedLayout>
</template>

<script>

import {plainObjToProxyObj} from "../Calendar/helper";
export default {
    name: "CoachGptPage",
    props: {
        auth : Object,
    },

    data() {
        return {
            user : this.auth.user,
            hasAnswers: false,
        }
    },
    mounted() {
        this.hasAnswers = true;
        this.user = plainObjToProxyObj(this.auth.user)
    },

    created() {

    },
    methods: {
        setUserBalance(balance) {
            this.user.total_credits = balance;
        },
        hasAnswersMethod(hasAnswers) {
            this.hasAnswers = true;
        }
    }
}
</script>

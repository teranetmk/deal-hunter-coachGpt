<template>

    <div class="nav__right d-flex align-items-center">
        <div class="top_up">
            <div class="text-center">
                <h6>{{ user.total_credits }}</h6>
                <p>Credit Balance</p>
            </div>
<!--            add button as link-->
            <button @click="this.openTopUp()" >
                Top Up
            </button>

        </div>
    </div>

</template>

<script>

export default {
    name: "RealStateHeader",
    props: {
        user : Object,
    },
    data() {
        return {

        };
    },
    created() {

    },
    methods: {
        openTopUp() {
            this.$inertia.visit(route('credits'));
        },
    },
};
</script>

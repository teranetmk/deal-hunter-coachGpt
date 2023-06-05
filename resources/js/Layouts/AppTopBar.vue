<template>
    <div class="layout-topbar">
        <Link :href="route('dashboard')" class="layout-topbar-logo">
            <img alt="Logo" :src="topbarImage()"/>
        </Link>

        <button class="p-link layout-menu-button layout-topbar-button" @click="onMenuToggle">
            <i class="pi pi-bars"></i>
        </button>

        <button class="p-link layout-topbar-menu-button layout-topbar-button"
                v-styleclass="{ selector: '@next', enterClass: 'hidden', enterActiveClass: 'scalein',
			leaveToClass: 'hidden', leaveActiveClass: 'fadeout', hideOnOutsideClick: true}">
            <i class="pi pi-ellipsis-v"></i>
        </button>
<!--        <ul class="layout-topbar-menu hidden lg:flex origin-top">
            <li>
                <Link :href="route('logout')" method="post" as="button" class="p-link layout-topbar-button"
                      v-tooltip.top="'Sign Out'">
                    <i class="pi pi-sign-out"></i>
                    <span>Sign Out</span>
                </Link>
            </li>
        </ul>-->
    </div>
</template>

<script>
import {Link} from '@inertiajs/inertia-vue3';

export default {
    name    : "AppTopBar",
    computed: {
        darkTheme() {
            return this.$appState.darkTheme;
        }
    },
    data() {
        return {
            switchValue: false
        }
    },
    methods   : {
        onMenuToggle(event) {
            this.$emit('menu-toggle', event);
        },
        onTopbarMenuToggle(event) {
            this.$emit('topbar-menu-toggle', event);
        },
        topbarImage() {
            return this.$appState.darkTheme ? 'images/logo-white.png' : 'images/logo-dark.png';
        }
    },
    components: {Link}
}
</script>

<style>
.layout-topbar{
    width: 300px !important;
}
</style>

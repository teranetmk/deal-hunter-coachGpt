<template>
    <div class="flex w-full justify-content-center">
        <div style="margin-bottom: 3rem; width:175px; height:32px;">
            <Link :href="route('dashboard')" class="layout-topbar-logo">
                <img alt="Logo" style="width: 100%" :src="topbarImage()"/>
            </Link>
        </div>
    </div>
    <div class="layout-menu-container">
        <AppSubmenu :items="model"
                    class="layout-menu"
                    :root="true"
                    @menuitem-click="onMenuItemClick"
                    />
    </div>
</template>

<script>
import AppSubmenu from './AppSubmenu.vue';
import {Link} from "@inertiajs/inertia-vue3";

export default {
    props: {
        model: Array
    },
    data() {
        return {
            switchValue       : false,
            changeDisplayTheme: false,
        }
    },
    methods   : {
        topbarImage() {
            return this.$appState.darkTheme ? '/images/logo-white.png' : '/images/logo-dark.png';
        },
        onMenuItemClick(event) {
            this.$emit('menuitem-click', event);
        },
        onKeyDown(event) {
            const nodeElement = event.target;
            if (event.code === 'Enter' || event.code === 'Space') {
                nodeElement.click();
                event.preventDefault();
            }
        },
        bannerImage() {
            return this.$appState.darkTheme ? '/images/banner-primeblocks-dark.png' : 'images/banner-primeblocks.png';
        }
    },
    computed  : {
        darkTheme() {
            return this.$appState.darkTheme;
        }
    },
    components: {
        'AppSubmenu': AppSubmenu,
        'Link'      : Link
    }
}
</script>

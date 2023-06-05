<script>
import AppFooter from './AppFooter.vue';

export default {
    data() {
        return {
            layoutMode        : 'overlay',
            staticMenuInactive: false,
            overlayMenuActive : false,
            mobileMenuActive  : false,
        }
    },
    methods: {


        onLayoutChange(layoutMode) {
            this.layoutMode = layoutMode;
        },
        addClass(element, className) {
            if (element.classList)
                element.classList.add(className);
            else
                element.className += ' ' + className;
        },
        removeClass(element, className) {
            if (element.classList)
                element.classList.remove(className);
            else
                element.className = element.className.replace(new RegExp('(^|\\b)' + className.split(' ').join('|') + '(\\b|$)', 'gi'), ' ');
        },
        isDesktop() {
            return window.innerWidth >= 992;
        }
    },
    computed:{
        containerClass() {
            return ['layout-wrapper', {
                'layout-overlay'                : this.layoutMode === 'overlay',
                'layout-static'                 : this.layoutMode === 'static',
                'layout-static-sidebar-inactive': this.staticMenuInactive && this.layoutMode === 'static',
                'layout-overlay-sidebar-active' : this.overlayMenuActive && this.layoutMode === 'overlay',
                'layout-mobile-sidebar-active'  : this.mobileMenuActive,
                'p-input-filled'                : this.$primevue.config.inputStyle === 'filled',
                'p-ripple-disabled'             : this.$primevue.config.ripple === false
            }];
        },
        logo() {
            return (this.$appState.darkTheme) ? "images/logo-white.png" : "images/logo.png";
        }
    },
    beforeUpdate() {
        if (this.mobileMenuActive)
            this.addClass(document.body, 'body-overflow-hidden');
        else
            this.removeClass(document.body, 'body-overflow-hidden');
    },
    components: {
        'AppFooter': AppFooter,
    }
}

</script>
<style lang="scss">
@import './App.scss';
</style>
<template>
    <div :class="containerClass">
        <div class="layout-main-container mt-0 pt-0">
            <div class="grid">
                <div class="col-12 flex justify-content-center mt-5">
                    <div style="margin-bottom: 3rem; width:175px; height:32px;">
                        <img alt="Logo" style="width: 175px;" src="images/logo-dark.png" class="">
                    </div>
                </div>
            </div>
            <div class="layout-main">
                <slot/>
            </div>
        </div>

        <transition name="layout-mask">
            <div class="layout-mask p-component-overlay" v-if="mobileMenuActive"></div>
        </transition>
    </div>

</template>

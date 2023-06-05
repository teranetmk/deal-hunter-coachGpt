<script>
import AppMenu from './AppMenu.vue';
import AppFooter from './AppFooter.vue';

export default {
    data() {
        return {
            layoutMode        : 'static',
            staticMenuInactive: false,
            overlayMenuActive : false,
            mobileMenuActive  : false,
            menu              : [
                {
                    label: 'Main', icon: "", items: [
                        {label: 'Users', icon: "pi pi-users", to: "all-users"},
                    ]
                },
                {
                    label: 'Main', icon: "", items: [
                        {label: 'Cash Buyer', icon: "pi pi-users", to: "cash.buyers"},
                    ]
                },
                {
                    label: 'SO', icon: "", items: [
                        {label: 'Sign Out', icon: "pi pi-sign-out", to: "dashboard"},
                    ]
                },
            ]
        }
    },
    watch   : {
        $route() {
            this.menuActive = false;
            this.$toast.removeAllGroups();
        }
    },
    methods : {
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
                if (this.layoutMode === 'overlay') {
                    if (this.mobileMenuActive === true) {
                        this.overlayMenuActive = true;
                    }

                    this.overlayMenuActive = !this.overlayMenuActive;
                    this.mobileMenuActive = false;
                } else if (this.layoutMode === 'static') {
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
        },
        isSidebarVisible() {
            if (this.isDesktop()) {
                if (this.layoutMode === 'static')
                    return !this.staticMenuInactive;
                else if (this.layoutMode === 'overlay')
                    return this.overlayMenuActive;
            }

            return true;
        }
    },
    computed: {
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
        'AppMenu'  : AppMenu,
        'AppFooter': AppFooter,
    }
}
</script>
<style lang="scss">
@import './App.scss';

.layout-menuitem-root-text {
    display: none !important;
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

.top-bar-container-c {
    position: fixed;
    height: 5rem;
    z-index: 997;
    left: 240px;
    top: 0;
    width: calc(100% - 240px) !important;
    padding: 0 2rem;
    background-color: var(--surface-card);
    transition: left .2s;
    display: flex;
    justify-content: space-between !important;
    align-items: center;
    box-shadow: 0 3px 5px #00000005, 0 0 2px #0000000d, 0 1px 4px #00000014;
}
</style>

<template>
    <div :class="containerClass" @click="onWrapperClick">
        <div class="layout-sidebar" @click="onSidebarClick">
            <AppMenu :model="menu" @menuitem-click="onMenuItemClick"/>
        </div>

        <div class="layout-main-container">
            <div class="top-bar-container-c">
                <slot name="pageHeading"/>
            </div>
            <div class="layout-main">
                <slot/>
            </div>

        </div>

    </div>
</template>

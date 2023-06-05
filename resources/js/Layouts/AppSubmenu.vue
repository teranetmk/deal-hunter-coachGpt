<template>
    <ul v-if="items">
        <template v-for="(item,i) of items">
            <li v-if="visible(item) && !item.separator" :key="item.label || i"
                :class="[{'layout-menuitem-category': root,
                'active-menuitem': activeIndex === i && !item.to && !item.disabled,
                'coach-gtp': item.label === 'Real Estate CoachGPT'
                }]"
                class="mt-1"
                role="none">

                <template v-if="root">
                    <div class="layout-menuitem-root-text" :aria-label="item.label">{{ item.label }}</div>
                    <appsubmenu :items="visible(item) && item.items"
                                @menuitem-click="$emit('menuitem-click', $event)"></appsubmenu>
                </template>
                <template v-else-if="item.label === 'Sign Out'">
                    <!-- <Divider /> -->
                    <Link :href="route('logout')"
                          :class="[item.class, 'p-ripple', {'p-disabled': item.disabled}]"
                          :style="item.style"
                          method="post"
                          exact
                          class="text-xl"
                          role="menuitem" v-ripple
                          v-tooltip.top="'Sign Out'">
                        <i class="pi pi-sign-out text-xl"></i>
                        <span>Sign Out</span>
                    </Link>
                </template>
                <template v-else-if="item.label === 'Real Estate CoachGPT'">
                    <div class="sidebar_real_state">
                        <div class="header">
                            <img class="margin-right:0px" src="../../../public/images/icons/robot.png" alt="">
                            <p>Real Estate CoachGPT</p>
                        </div>
                        <div class="body">
                            <p>Your Own Personal A.I. Real Estate Coach !</p>
                            <Link :href="route(item.to) "> <button>
                                <img id="gpt" src="../../../public/images/icons/messages-2.svg" alt="">
                                Ask Question
                            </button>
                            </Link>
                        </div>
                    </div>
                </template>
                <template v-else>

                    <Link v-if="item.to"
                          :href="route(item.to)"
                          :class="[item.class, 'p-ripple'+( ((route(item.to)).substring((route(item.to)).lastIndexOf('/') + 1)) == this.path ? ' active' : ''  ), {'p-disabled': item.disabled}]"
                          :style="item.style"
                          @click="onMenuItemClick($event,item,i)"
                          :target="item.target" :aria-label="item.label"
                          class="text-xl"
                          exact
                          role="menuitem" v-ripple>
                        <i class="text-xl" :class="item.icon"></i>
                        <img v-if="item.img" class="svg-black" style="height: 17.5px" alt="icon" :src="item.img"/>
                        <span>{{ item.label }}</span>
                        <i v-if="item.items" class="pi pi-fw pi-angle-down menuitem-toggle-icon"></i>

                        <Badge v-if="item.badge" :value="item.badge"></Badge>


                    </Link>
                    <!-- <div v-if="item.upgrade" class="ml-3 d-flex upgrade-container">
                        <i class="pi pi-lock"></i>
                        Upgrade to Unlock
                    </div> -->

                    <a v-if="!item.to" :href="item.url||'#'" :style="item.style"
                       :class="[item.class, 'p-ripple', {'p-disabled': item.disabled}]"
                       @click="onMenuItemClick($event,item,i)" :target="item.target" :aria-label="item.label"
                       role="menuitem" v-ripple>
                        <i :class="item.icon"></i>
                        <img v-if="item.img" class="svg-black" style="height: 17.5px" alt="icon" :src="item.img"/>
                        <span>{{ item.label }}</span>
                        <i v-if="item.items" class="pi pi-fw pi-angle-down menuitem-toggle-icon"></i>
                        <Badge v-if="item.badge" :value="item.badge"></Badge>
                    </a>
                    <div v-if="item.upgrade" class="ml-3 d-flex upgrade-container">
                        <i class="pi pi-lock"></i>
                        Upgrade to Unlock
                    </div>
                    <transition name="layout-submenu-wrapper">
                        <appsubmenu v-show="activeIndex === i" :items="visible(item) && item.items"
                                    @menuitem-click="$emit('menuitem-click', $event)"></appsubmenu>
                    </transition>
                </template>
            </li>
            <li class="p-menu-separator" :style="item.style" v-if="visible(item) && item.separator"
                :key="'separator' + i" role="separator"></li>
        </template>

    </ul>
</template>

<script>
import {Link} from "@inertiajs/inertia-vue3";
import { useForm, usePage} from '@inertiajs/inertia-vue3';

export default {
    // eslint-disable-next-line vue/multi-word-component-names
    name : 'appsubmenu',
    props: {
        items: Array,
        root : {
            type   : Boolean,
            default: false
        }
    },
    data() {
        return {
            activeIndex: null,
            userNav: null,
            disabledRobo : false,
            path: (window.location.pathname).substring(1)
        }
    },
    mounted() {
        this.userNav = usePage().props.value.auth.user;
        if(this.userNav.total_credits < 1) {
            this.disabledRobo = true;
        }
    }
    ,
    methods   : {
        onMenuItemClick(event, item, index) {
            if (item.disabled) {
                event.preventDefault();
                return;
            }

            if (!item.to && !item.url) {
                event.preventDefault();
            }

            //execute command
            /*if (item.command) {
                item.command({originalEvent: event, item: item});
            }*/

            this.activeIndex = index === this.activeIndex ? null : index;

            this.$emit('menuitem-click', {
                originalEvent: event,
                item         : item
            });
        },
        visible(item) {
            return (typeof item.visible === 'function' ? item.visible() : item.visible !== false);
        }
    },
    components: {Link}
}
</script>
<style scoped>
    .coach-gtp{
        margin-top: 60px !important;
        padding: 0 0px;
    }
</style>

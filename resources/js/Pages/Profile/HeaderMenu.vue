<script setup>
import {Link} from "@inertiajs/inertia-vue3";
</script>

<template>
    <div class="d-flex">
        <Link
                :href="route('profile.edit')"
                :class="[ 'p-ripple']"


                class=" navbuttons   py-3 mr-3 px-3"
                exact
                role="menuitem" v-ripple>
                <div class="w-100" style="align-items: center;">
                <i class="pi pi-user mr-2"></i>
                <span >  Account</span>

            </div>
        </Link>

        <Link
                :href="route('profile.insta')"
                :class="[ 'p-ripple']"


                class=" navbuttons   py-3 mr-3 px-3"
                exact
                role="menuitem" v-ripple>
                <div class="w-100" style="align-items: center;">
                    <i class="pi pi-home mr-2"></i>
                    <span >  Insta-Offer</span>

                </div>
        </Link>

        <Link
                :href="route('credits')"
                :class="[ 'p-ripple']"


                class=" navbuttons   py-3 mr-3 px-3"
                exact
                role="menuitem" v-ripple>
                <div class="w-100" style="align-items: center;">
                    <i class="pi pi-credit-card mr-2"></i>
                    <span >  Credits</span>

                </div>
        </Link>



    </div>
</template>

<style>
    .navbuttons {
        /* Stroke */

        background: #FFFFFF;
        /* Stroke */

        border: 1px solid #E6EAED;
        border-radius: 8px;
        border-radius: 8px;
        font-family: 'Nunito';
        font-style: normal;
        font-weight: 400;
        font-size: 14px;
        line-height: 19px;
        /* identical to box height */


        /* Text 2 */

        color: #575A7B;
    }

    .navbuttons:hover {
        border-color: transparent;
        background: rgba(219, 15, 25, 0.1)!important;
        border-radius: 8px;
        font-family: 'Nunito';
        font-style: normal;
        font-weight: 400;
        font-size: 14px;
        line-height: 19px;
        /* identical to box height */


        /* Primary */

        color: #DB0F19!important;
    }
</style>

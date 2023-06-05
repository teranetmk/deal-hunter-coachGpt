<script>
import AuthenticatedLayout from "../../../Layouts/AuthenticatedLayout.vue";
import Buttons from "./Partials/Buttons.vue";
import {useForm, usePage, Link, Head} from '@inertiajs/inertia-vue3';
import Form from "./Partials/Form.vue"

export default {
    props: ['offers', 'count'],
    data() {
        return {
            form: useForm({
                id: '',
                arv : 0,
                rule: 0,
                rehab: 0,
                wholesale: 0
            }),
            buttons: this.offers,
            controller: null
        }
    },
    methods: {

        saveOrUpdate() {

            if(!this.form.processing) {

                this.form.processing = true;
                if (this.form.id) {

                    if(this.controller) this.controller.abort()
                    this.controller = new AbortController()

                    axios.post(route('users.calculator.max-allowable-offer.store', {id: this.form.id}), {...this.form}, {signal: this.controller.signal})
                        .then(() => {

                            this.form.processing = false
                        })
                } else {

                    if(this.controller) this.controller.abort()
                    this.controller = new AbortController()

                    const self = this;
                    axios.post(route('users.calculator.max-allowable-offer.store'), {...this.form}, {signal: this.controller.signal})
                        .then(r => r.data)
                        .then(data => {

                            this.form.processing = false
                            self.form.id = data.id
                            this.buttons = data.offers
                            window.history.replaceState({}, '', route('users.calculator.max-allowable-offer.edit', {id: data.id}))
                        })
                }
            }
        }
    },
    watch: {
        "form.arv"(newVal, oldVal) {

            if(newVal !== oldVal) { this.saveOrUpdate() }
            this.form.arv = add_commas(this.form.arv)
        },
        "form.rule"(newVal, oldVal) {

            if(newVal !== oldVal) { this.saveOrUpdate() }
            this.form.rule = add_commas(this.form.rule)
        },
        "form.rehab"(newVal, oldVal) {

            if(newVal !== oldVal) { this.saveOrUpdate() }
            this.form.rehab = add_commas(this.form.rehab)
        },
        "form.wholesale"(newVal, oldVal) {

            if(newVal !== oldVal) { this.saveOrUpdate() }
            this.form.wholesale = add_commas(this.form.wholesale)
        }
    },
    components: {AuthenticatedLayout, Head, Link, Form, Buttons}
}
</script>

<template>
    <Head>
        <title>Max Allowable Offer (MAO) Calculator</title>
        <meta property="og:site_name" content="DealHunter">
        <meta property="og:title" content="Max Allowable Offer (MAO) Calculator">
        <meta property="og:description" content="Try Out Our Max Allowable Offer (MAO) Calculator">
        <meta property="og:image" content="/images/max_allowable_offer_calculator.png">
        <meta property="og:url" content="{{route('users.calculator.max-allowable-offer')}}">
    </Head>
    <AuthenticatedLayout>
        <template #pageHeading>
            <Buttons :offers="buttons" />
        </template>

        <Form :form="form" :count="this.count" />

    </AuthenticatedLayout>
</template>

<style>
.p-button-secondary {
    color: #6c757d!important;
}
</style>

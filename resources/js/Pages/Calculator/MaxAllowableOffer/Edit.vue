<script>
import AuthenticatedLayout from "../../../Layouts/AuthenticatedLayout.vue";
import Buttons from "./Partials/Buttons.vue";
import {useForm, usePage, Link, Head} from '@inertiajs/inertia-vue3';
import Form from "./Partials/Form.vue"

export default {
    props: ['offers', 'offer'],
    data() {
        return {
            form: useForm({
                id: this.offer.id,
                arv : this.offer.arv,
                rule: this.offer.rule,
                rehab: this.offer.rehab,
                wholesale: this.offer.wholesale
            }),
            controller: null
        }
    },
    methods: {

        saveOrUpdate() {

            if(this.form.id) {

                if(this.controller) this.controller.abort()
                this.controller = new AbortController()

                axios.post(route('users.calculator.max-allowable-offer.store', {id: this.form.id}), {...this.form}, {signal: this.controller.signal})
            } else {

                if(this.controller) this.controller.abort()
                this.controller = new AbortController()

                const self = this;
                axios.post(route('users.calculator.max-allowable-offer.store'), {...this.form}, {signal: this.controller.signal})
                    .then(r => r.data)
                    .then(data => {

                        self.form.id = data.id
                    })
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
    <AuthenticatedLayout>
        <Head title="Max Allowable Offer (MAO) Calculator" />
        <template #pageHeading>
            <Buttons :offers="offers" />
        </template>

        <Form :form="form" />

    </AuthenticatedLayout>
</template>

<style>
.p-button-secondary {
    color: #6c757d!important;
}
</style>

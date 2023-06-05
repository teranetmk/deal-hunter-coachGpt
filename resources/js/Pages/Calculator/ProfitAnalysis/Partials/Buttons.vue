<script>
import {Link} from '@inertiajs/inertia-vue3'
import {Inertia} from "@inertiajs/inertia";

export default {
    components: {Link},
    props: ["analyses"],
    data() {
        return {
            analysesProp: this.analyses,
            controller: null,
            processing: false,
            buttons: this.analyses
        }
    },
    // computed: {
    //     buttons() { return this.analysesProp },
    // },
    methods: {
        async deleteEntry (row) {

            this.$confirm.require({
                message    : `Do you want to delete '${row.title}' ?`,
                header     : 'Delete Confirmation',
                icon       : 'pi pi-info-circle',
                acceptClass: 'p-button-danger',
                accept     : () => {

                    axios.post(route('users.calculator.profit-analysis.destroy', {profitAnalysis: row.id}), {_method: 'delete'})
                        .then(r => r.data)
                        .then(data => {

                            this.analysesProp = data.analyses
                            if(route().current() === "users.calculator.profit-analysis.edit" && route().current('users.calculator.profit-analysis.edit', {profitAnalysis: row.id})) {

                                Inertia.replace(route('users.calculator.profit-analysis'))
                            }
                        })
                },
                reject     : () => {
                }
            });
        },
        update(e, row) {

            if(this.controller) this.controller.abort()
            this.controller = new AbortController()
            this.processing = true

            axios.post(route('users.calculator.profit-analysis.store', {id: row.id}), {...row, title: e.target.textContent}, {
                signal: this.controller.signal
            })
                .then(r => r.data)
                .then(() => {
                    this.processing = false
                })
        }
    }
}
</script>

<template>
    <div class="w-full">
        <div class="grid grid-cols-12 gap-2">
            <Link :href="route('users.calculator.profit-analysis', {sheet: 'new'})" class="p-button p-component p-button p-button-outlined p-button-danger" style="border-radius: 0.5rem !important;color: #D32F2F !important">
                <i class="pi pi-plus"></i>&nbsp;Add New
            </Link>

            <div v-for="row in buttons" class="p-button p-component p-button p-button-outlined p-button-danger" style="border-radius: 0.5rem !important;color: #D32F2F !important">
                <Link v-if="!route().current('users.calculator.profit-analysis.edit', {profitAnalysis: row.id})" class="text-muted" style="color: #D32F2F !important" :href="route('users.calculator.profit-analysis.edit', {profitAnalysis: row.id})">{{row.title}}</Link>
                <span contenteditable="true" :style="{border: 'none', minWidth: '4rem'}"  v-else @input="(e) => update(e, row)">{{row.title}}</span>

                &nbsp; <div v-if="processing" class="spinner-border spinner-border-sm" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <i v-else @click="() => deleteEntry(row)" class="pi pi-times cursor-pointer"></i>
            </div>
        </div>

        <Toast/>
        <ConfirmDialog/>
    </div>
</template>


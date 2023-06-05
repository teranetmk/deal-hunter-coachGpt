<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

import HeaderMenu from "./Partials/HeaderMenu.vue";
import SinglePipeline from "./Partials/SinglePipeline.vue";
import { Head } from "@inertiajs/inertia-vue3";

</script>

<template>
    <Head title="Pipleline" />

    <AuthenticatedLayout>
        <Head><title>Pipeline</title></Head>
        <template #pageHeading>
            <div>
                <img class="pipeline-img" src="../../../../../public/images/icons/nav1.png" alt="img" />
                <span class="text-2xl mr-3"
                ><strong
                > Pipeline</strong></span>

                <span class="p-input-icon-left">
                    <i class="pi pi-search" />
                    <InputText
                        v-model="search"
                        placeholder="Search"
                    />
                </span>
            </div>
            <!-- pipeline nav start here -->
            <HeaderMenu :lists="listArray" :pipelines="pipelineArray" @updatePipeline="updatePipelines" @saveList="updateList"/>

        </template>
        <SinglePipeline :pipelines="pipelineArray" @updateParentPipeline="updatePipelines" :searchKey="search"/>

    </AuthenticatedLayout>
</template>

<script>
export default {
    name : "PipelinePage",
    props: ['lists','pipelines'],
    data() {
        return {
            phone_country_code   : '',
            pipelineArray        : [],
            listArray            : [],
            search               : '',
        }
    },
    created() {
        this.pipelineArray = _.cloneDeep(this.pipelines);
        this.listArray = _.cloneDeep(this.lists);
    },
    watch: {
        lists: function (newVal, oldVal) {
            this.listArray = newVal;
        },
        pipelines: function (newVal, oldVal) {
            this.pipelineArray = newVal;
        },
        pipelineArray: function (newVal, oldVal) {
            this.pipelineArray = newVal;
        },
    },
    methods: {
        updatePipelines(pipelineArray) {
            this.pipelineArray = pipelineArray;
            this.search = '';
        },
        updateList(listArray) {
            this.listArray = listArray;
        },

    },
};

</script>
<style>
.p-dropdown{
    min-width: 100%;
}
.pipeline-img{
    width: 18px;
    height: 18px;
    margin-bottom: 5px;
}
</style>

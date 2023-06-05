<template>

    <div class="nav__right d-flex align-items-center">

        <!-- partial:index.partial.html -->
        <!-- First modal dialog -->
        <EditPipeline :pipelines="pipelines" @savePipeline="savePipeline"/>

        <!-- Second modal dialog -->
        <ImportLeadModal :lists="lists" :pipelines="pipelines" @savePipeline="savePipeline" @saveList="saveList"/>
    </div>

</template>

<script>
import EditPipeline from "./EditPipeline.vue";
import ImportLeadModal from "./ImportLeadModal.vue";

export default {
    name: "PipelineHeader",
    components: {
        EditPipeline, ImportLeadModal
    },
    props: {
        lists: {
            type: Array,
            required: true,
        },
        pipelines: {
            type: Array,
            required: true,
        },
    },
    data() {
        return {
            importListModal : false,
            editPipelineModal : false,
        };
    },
    methods: {
        handleModal(modalName) {
            if (modalName === 'editPipelineModal') {
                this.editPipelineModal = !this.editPipelineModal;
            } else if (modalName === 'importListModal') {
                this.importListModal = !this.importListModal;
            }
        },
        savePipeline(pipelineArray) {
            this.$emit('updatePipeline', pipelineArray);
        },
        saveList(listArray) {
            this.$emit('saveList', listArray);
        },
    },
};
</script>

<style >
.ic-left{
    width:64%;
}
.ic-remove-btn{
    flex:1;
}
/*.p-dialog-content{*/
/*    overflow:hidden!important;*/
/*}*/
.edit__modal button{
    margin-left:15px;
}
.pipeline__nav{
    width:100%;
}
</style>

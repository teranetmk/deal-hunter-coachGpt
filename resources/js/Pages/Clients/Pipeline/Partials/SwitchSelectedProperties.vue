<template>
    <div>
        <Dialog header=""
                :draggable="false"
                v-model:visible="showModal"

                :style="{width: '32vw'}"
                :modal="true">
            <template #header>
                <div class="modal-footer justify-content-between">
                    <h3 class="m-0">
                        <i class="pi pi-sync" style="font-size: 1.5rem"></i>
                        Switch Stage
                    </h3>
                </div>
            </template>
            <div class="">
                <hr class="mt-0">
                <div class="field grid mt-3 mb-5">
                    <span class="col-12">
                        <div class="p-float-label">
                            <Dropdown
                                :filter="true"
                                inputId="dd-list"
                                v-model="form.pipeline_id"
                                optionValue="id"
                                optionLabel="name"
                                :options="pipelineArray"
                                style="
                                      border-radius: 1rem !important;
                                      width: 100% !important;
                                  "
                                placeholder="Select List" class="w-full py-2 w-100" />
                            <label for="dd-list">Select Pipeline Stage</label>
                        </div>
                    </span>
                    <span v-if="pipeline_error">
                        <img src="../../../../../../public/images/icons/denied.png" alt="img" />
                        Please select a pipeline stage
                    </span>
                </div>
                <div class="field grid">
                    <div class="col-12">
                        <Button
                            class="p-button-outlined p-button-danger py-4 w-full switch-lead-button"
                            style="border-radius: 1rem !important"
                            @click="switchSelected()"
                            label="Switch"
                        />
                    </div>
                </div>
            </div>
        </Dialog>
        <button @click="handleModal()" class="ic-remove-selected">
            <img src="../../../../../../public/images/icons/Resc.png" alt="img" />Switch Stage
        </button>
    </div>
</template>

<script>

export default {
    name: "SwitchSelectedProperties",
    props: {
        properties: {
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
            showModal: false,
            form: {
                pipeline_id: "",
            },
            pipeline_error: false,
            pipelineArray: [],
        };
    },
    created() {
        this.pipelineArray = [...this.pipelines];
    },
    watch: {
        pipelines: function (val) {
            this.pipelineArray = [...val];
        },
    },
    methods: {
        handleModal() {
            this.showModal = !this.showModal;
        },
        switchSelected() {
            this.pipeline_error = this.form.pipeline_id == '' ? true : false;

            if (this.pipeline_error) return;

            this.$emit("switchSelected", this.form.pipeline_id);
        }
    },
};

</script>
<style>
.ic-remove-selected{
    color: #101136 !important;
    border: 1px solid #101136 !important;
}
.switch-image{
    font-size: 16px;
}
</style>

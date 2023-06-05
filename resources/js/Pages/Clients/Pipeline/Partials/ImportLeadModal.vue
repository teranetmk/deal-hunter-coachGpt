<template>
    <div>
        <Dialog
            :draggable="false"
            v-model:visible="showModal"

            :style="{width: '32vw'}"
            :modal="true"
        >
            <template #header>
                <div
                    class="flex justify-content-between align-items-center"
                    style="width: 90%"
                >
                    <span class="p-dialog-title"><span class="pi pi-cloud-upload"></span> Import Leads</span>
                </div>
            </template>
            <div class="">
                <div class="field grid mt-3">
                    <span class="col-12">
                        <div class="p-float-label">
                            <Dropdown
                                :filter="true"
                                inputId="dd-list"
                                v-model="form.list_id"
                                optionLabel="filename"
                                optionValue="id"
                                :options="listArray"
                                style="
                                      border-radius: 1rem !important;
                                      width: 100% !important;
                                  "
                                placeholder="Select List" class="w-full py-2 w-100" />
                            <label for="dd-list">Select List</label>
                        </div>
                    </span>
                    <span v-if="list_error">
                        <img src="../../../../../../public/images/icons/denied.png" alt="img" />
                        Please select a list
                    </span>
                </div>
                <div class="field grid mt-3">
                    <span class="col-12">
                        <div class="p-float-label">
                            <Dropdown
                                :filter="true"
                                inputId="dd-pipeline"
                                v-model="form.pipeline_id"
                                optionLabel="name"
                                optionValue="id"
                                :options="pipelineArray"
                                style="
                                      border-radius: 1rem !important;
                                      width: 100% !important;
                                  "
                                placeholder="Select Pipeline" class="w-full py-2 w-100" />
                            <label for="dd-pipeline">Select Pipeline</label>
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
                            class="p-button-outlined p-button-danger py-4 w-full import-lead-button"
                            style="border-radius: 1rem !important"
                            @click="importLeads()"
                            label="Import Leads"
                        />
                    </div>
                </div>
            </div>
        </Dialog>
        <Button
            class="p-button p-button-outlined p-button-danger"
            style="border-radius: 0.5rem !important"
            icon="pi pi-cloud-upload"
            @click="handleModal()"
            label="Import Leads"
        ></Button>
    </div>
</template>

<script>
import axios from "axios";

export default {
    name: "ImportLeadModal",
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
            showModal : false,
            listArray : [],
            pipelineArray : [],

            // form data
            form : {
                list_id : '',
                pipeline_id : '',
            },
            list_error : false,
            pipeline_error: false,
        };
    },
    created() {
        this.listArray = [...this.lists];
        this.pipelineArray = [...this.pipelines];
    },
    watch: {
        lists: function (val) {
            this.listArray = [...val];
        },
        pipelines: function (val) {
            this.pipelineArray = [...val];
        },
    },

    methods: {
        handleModal() {
            this.showModal = !this.showModal;
        },
        async importLeads(){
            this.list_error = this.form.list_id == '' ? true : false;
            this.pipeline_error = this.form.pipeline_id == '' ? true : false;

            if(this.list_error || this.pipeline_error){
                return;
            }

            let button = document.querySelector('.import-lead-button');
            button.disabled = true;
            button.innerHTML = 'Importing...';

            const res = await axios({
                url: route("pipelines.importLead"),
                method: "POST",
                data: {
                    pipeline_id: this.form.pipeline_id,
                    list_id: this.form.list_id,
                },
            });

            this.handleResponse(res.data);

            if (res.data.status === "success") {
                this.showModal = false;
                this.$emit('saveList', res.data.lists);
                this.$emit('savePipeline', res.data.pipelines);

                // reset add stage
                this.form = {
                    list_id: '',
                    pipeline_id: '',
                }
            }

            button.disabled = false;
            button.innerHTML = 'Import Leads';
        },
        handleResponse(response) {
            switch (response.status) {
                case "success":
                    this.$toast.add({
                        severity: "success",
                        summary: "Success",
                        detail: response.message,
                        life: 3000,
                    });
                    break;
                case "error":
                    this.$toast.add({
                        severity: "error",
                        summary: "Error",
                        detail: response.message,
                        life: 3000,
                    });
                    break;
            }
        },
    },
};
</script>
<style>
.import-lead-button {
    display: flow-root !important;
}
</style>

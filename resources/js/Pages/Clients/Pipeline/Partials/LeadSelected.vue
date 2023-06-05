<template>
    <!--  -->
    <div
        class="nav__head d-flex justify-content-between align-items-center mb-4"
    >
        <div class="head__left">
            <h2>
                <img src="../../../../../../public/images/icons/Home-1.png" alt="img" /> Leads Selected
                <span>
                    {{ propertyArray.length }}
                </span>
            </h2>
        </div>

        <div class="head__right">
            <button @click="confirmRemove" class="ic-remove-button">
                <img src="../../../../../../public/images/icons/redCross.png" alt="img" />Remove
            </button>
            <SwitchSelectedProperties :properties="propertyArray" :pipelines="pipelines" @switchSelected="switchSelected"/>
        </div>
    </div>

    <ConfirmDialog/>
    <!--  -->
</template>

<script>
import axios from "axios";
import SwitchSelectedProperties from "./SwitchSelectedProperties.vue";
import "flag-icons/css/flag-icons.min.css";

export default {
    name: "LeadSelected",
    components: {
        SwitchSelectedProperties,
    },
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
            propertyArray: [],
        };
    },

    created() {
        this.propertyArray = [...this.properties];
    },
    watch: {
        properties: function (val) {
            this.propertyArray = [...val];
        },
    },
    methods: {
        async removeSelected() {
            const res = await axios.post(route('pipelines.propertyRemove'), {properties: this.propertyArray})
            this.handleResponse(res.data);
            if (res.data.status === 'success') {
                this.$emit('removeSelected', res.data.pipelines);
            }
        },
        confirmRemove() {
            this.$confirm.require({
                message    : `This will remove all the properties from the pipeline. Proceed?`,
                header     : `Remove Selected Properties`,
                icon       : 'pi pi-info-circle',
                acceptClass: 'p-button-danger',
                accept     : () => {
                    this.removeSelected();
                },
                reject     : () => {
                }
            });
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
        async switchSelected(pipeline_id) {
            let button = document.querySelector('.switch-lead-button');
            button.disabled = true;
            button.innerHTML = 'Switching...';

            const res = await axios.post(route('pipelines.propertyStageSwitch'), {
                properties: this.propertyArray,
                pipeline_id: pipeline_id
            })
            this.handleResponse(res.data);
            if (res.data.status === 'success') {
                this.$emit('switchSelected', res.data.pipelines);
            }

            button.disabled = false;
            button.innerHTML = 'Switch';

        }
    }
};
</script>
<style>
.ic-remove-button{
    color: #db0f19;
    border: 1px solid #db0f19;
}
.switch-lead-button {
    display: flow-root !important;
}
</style>

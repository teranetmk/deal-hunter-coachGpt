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
                    <span class="p-dialog-title"><span class="pi pi-pencil"></span> Edit Pipeline</span>
                </div>
            </template>
            <div class="">
                <hr class="mt-0">
                <div class="modal__ant edit-pipeline">
                    <Container @drop="onDrop"
                               group-name="columns"
                               drag-handle-selector=".ic-left"
                               drag-class="opacity-ghost" drop-class="opacity-ghost-drop"
                               :drop-placeholder="{
                                  className: `ic-drop-placeholder`,
                                  animationDuration: '200',
                                }"
                               :get-ghost-parent="getGhostParent" :remove-on-drop-out="false" @drop-ready="onDropReady"
                    >
                        <Draggable v-for="item in pipelineArray" :key="item.id">
                            <div class="ic-item-dragable-wrap" id="editListDrag">
                                <div class="edit__modal d-flex align-items-center">
                                    <div class="ic-left">
                                        <div class="input-wrap">
                                            <img class="me-2"
                                                 src="../../../../../../public/images/icons/extt.png"
                                                 alt="img"
                                            />
                                            <input type="text" class="form-control" :value="item.name"
                                                   @change="updatePipelineName(item.id, $event.target.value)"
                                            >
                                        </div>
                                    </div>
                                    <button class="ic-remove-btn edit-pipeline-button" @click="removeStage(item.id)">Remove</button>
                                </div>
                            </div>
                        </Draggable>
                    </Container>
                    <div class="ic-add-stage-input mb-3"
                         :hidden="!addStage"
                    >
                        <div class="d-flex">
                            <input type="text" v-model="name" class="form-control" />
                            <span v-if="name_error">
                                <img src="../../../../../../public/images/icons/denied.png" alt="img" />
                                Please enter a name
                            </span>
                        </div>
                        <button class="add-btn" @click="addStageHandle">Add</button>
                    </div>
                    <button class="modalAdd__btn d-flex align-items-center" @click="manageAddStage">
                        <span v-if="addStage">
                            <img src="../../../../../../public/images/icons/redCross.png" alt="img" />
                            Cancel
                        </span>
                        <span v-else>
                            <img src="../../../../../../public/images/icons/add.png" alt="img" />
                            Add Pipeline Stage
                        </span>
                    </button>

                    <button class="w-100 fnlBtn" @click="savePipeline">Save Pipeline</button>
                </div>
            </div>
        </Dialog>
        <Button
            class="p-button p-button-outlined p-button-danger"
            style="border-radius: 0.5rem !important"
            icon="pi pi-pencil"
            @click="handleModal()"
            label="Edit Pipeline"
        ></Button>
<!--        <button-->
<!--            class="nav__btn"-->
<!--            data-bs-toggle="modal"-->
<!--            href="#modal2"-->
<!--            role="button"-->
<!--            @click="handleModal()"-->
<!--        >-->
<!--            <img src="../../../../../../public/images/icons/edit-2.png" alt="img" /> Edit Pipeline-->
<!--        </button>-->
    </div>
</template>

<script>
import {Container, Draggable} from 'vue3-smooth-dnd'
import axios from "axios";

export default {
    name: "EditPipelineModal",
    components: {Container, Draggable},
    props: {
        pipelines: {
            type: Array,
            required: true,
        },
    },
    data() {
        return {
            showModal : false,
            pipelineArray : [],
            addStage: false,
            name: '',
            name_error: false,
            dragged: false,
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
        manageAddStage(){
            this.addStage = !this.addStage;
            if (this.addStage) {
                this.name_error = false;
            }
        },
        updatePipelineName(id, name){
            let pipelines = [...this.pipelineArray];
            pipelines = pipelines.map(item => {
                if (item.id === id) {
                    item.name = name;
                }
                return item;
            });

            this.pipelineArray = pipelines;
        },
        addStageHandle(){
            if(this.name == ''){
                this.name_error = true;
                return;
            } else {
                this.name_error = false;
            }

            // add item to array and reset name  and don't update the props pipeline
            this.pipelineArray = [...this.pipelineArray, {name: this.name}];

            this.name = '';
            this.addStage = false;

        },
        removeStage(id){
            this.pipelineArray = this.pipelineArray.filter(item => item.id != id);
        },
        async savePipeline(){
            // make the button disabled and text to saving
            let button = document.querySelector('.fnlBtn');
            button.disabled = true;
            button.innerHTML = 'Saving...';

            const res = await axios.post('/pipeline/update', {
                pipelines: this.pipelineArray,
            }).then(res => {
                this.handleResponse(res.data);
                if (res.data.status === "success") {
                    this.showModal = false;
                    if (!this.dragged) {
                        this.$emit('savePipeline', res.data.pipelines);
                    } else {
                        window.location.reload();
                    }

                    // reset add stage
                    this.addStage = false;
                    this.name = '';
                }
            }).catch(err => {
                this.handleResponse(err.response.data);
            });

            // make the button enabled and text to save
            button.disabled = false;
            button.innerHTML = 'Save Pipeline';
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
        applyDrag  (arr, dragResult)  {
            const { removedIndex, addedIndex, payload } = dragResult
            if (removedIndex === null && addedIndex === null) return arr

            const result = [...arr]
            let itemToAdd = payload

            if (removedIndex !== null) {
                itemToAdd = result.splice(removedIndex, 1)[0]
            }

            if (addedIndex !== null) {
                result.splice(addedIndex, 0, itemToAdd)
            }

            return result
        },
        onDrop (dropResult) {
            this.dragged = true;
            this.pipelineArray = this.applyDrag(this.pipelineArray, dropResult)
        },
        getGhostParent(){
            return document.body;
        },
        onDropReady(dropResult){
            console.log('drop ready', dropResult);
        },
    },
};
</script>
<style>
.opacity-ghost {
    transition: all .18s ease;
    opacity: 0.8;
    /*transform: rotateZ(5deg);*/
    position:relative;
    z-index: 9999;
}

.opacity-ghost-drop {
    opacity: 1;
    /*transform: rotateZ(0deg);*/
}
.p-dialog-mask.p-component-overlay.p-component-overlay-enter{
    z-index: 999 !important;
}
.ic-left{
    padding:0px;
}
.ic-left .input-wrap{
    position: relative;
}
.ic-left .input-wrap img{
    position: absolute;
    top: 50%;
    left: 10px;
    transform: translateY(-50%);
    cursor:grabbing;
}
.ic-left .form-control{
    height:45px;
    padding-left:30px;
}
.edit__modal div{
    padding:0px;
}
.edit__modal{
    margin:0px;
    padding:10px 0px;
}
.edit-pipeline{
    padding: 0px 25px 25px !important;
}
</style>

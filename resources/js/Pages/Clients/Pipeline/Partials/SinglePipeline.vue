<template>
    <LeadSelected v-if="selected_properties.length"
                  :pipelines="pipelines"
                  :properties="selected_properties"
                  @removeSelected="removeSelected"
                  @switchSelected="switchSelected"
    />

    <div class="pipeline__body" id="pipeline__body">
        <div class="pBody__inner d-flex" :class="pipelineArray.length == 1 ? 'one-pipeline' : ''">
            <div v-for="(pipeline, idx) in pipelineArray" class="bodyPart" :class="{'one-pipeline' : pipelineArray.length == 1} + ' bodyPart'+(idx+1)">
                <div class="part__top d-flex justify-content-between align-items-center" :class="pipelineArray.length == 1 ? 'one-pipeline' : ''">
                    <form action="/action_page.php">
                        <input
                            type="checkbox"
                            :id="'allselected'+pipeline.id"
                            :checked="pipeline.checked === true"
                            @click="toggleSelectAll(pipeline.id)"
                            class="form-check-input"
                        />
                        <label :for="'allselected'+pipeline.id">{{ pipeline.name }}</label>
                    </form>
                    <span>
                        {{ pipeline.properties.length }}
                    </span>
                </div>
                <Container
                    group-name="col"
                    @drop="(e) => onCardDrop(pipeline.id, e)"
                    :get-child-payload="getCardPayload(pipeline.id)"
                    drag-class="card-ghost"
                    drop-class="card-ghost-drop"
                    :drop-placeholder="dropPlaceholderOptions"
                    :animation-duration="10"
                    @mousedown="onMouseDown"
                    @mouseup="onMouseUp"
                    @mousemove="onMouseMove"
                >
                    <Draggable v-for="(property,index) in pipeline.properties" :key="property.id">
                        <div class="inn__box">
                            <form @submit.prevent="true" class="d-flex">
                                <div class="demo2">
                                    <div class="demo2">
                                        <input type="checkbox"
                                               :id="'checkbox-2-1'+pipeline.id+index"
                                               :checked="property.checked"
                                               @click="toggleSelect(property, pipeline)"
                                               class="regular-checkbox big-checkbox">
                                        <label :for="'checkbox-2-1'+pipeline.id+index"></label>
                                    </div>
                                </div>
                                <label for="vehicle3"
                                >{{ property.PropertyAddress }}</label
                                >
                            </form>
                            <div class="inn__info d-flex justify-content-center">
                                <ul>
                                    <li class="d-flex align-items-center">
                                        <img
                                            class="me-2"
                                            src="../../../../../../public/images/icons/profile.svg"
                                            alt="img"
                                        />
                                        {{ property.OwnerName }}
                                    </li>
                                    <li class="d-flex align-items-center">
                                        <img
                                            class="me-2"
                                            src="../../../../../../public/images/icons/mail.svg"
                                            alt="img"
                                        />
                                        {{ property.OwnerEmailAddress }}
                                    </li>
                                    <li class="d-flex align-items-center">
                                        <img
                                            class="me-2"
                                            src="../../../../../../public/images/icons/call.png"
                                            alt="img"
                                        />
                                        {{ property.OwnerPhoneNumber }}
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </Draggable>
                </Container>
            </div>
        </div>
    </div>
</template>

<script>
import { Container, Draggable } from 'vue3-smooth-dnd'
import axios from "axios";
import LeadSelected from "./LeadSelected.vue";

export default {
    name: 'PipelineStage',
    components: {Container, Draggable, LeadSelected},
    props: {
        pipelines: {
            type: Array,
            required: true
        },
        searchKey: {
            type: String,
            required: false,
            default: ''
        },

    },
    data () {
        return {
            pipelineArray: [],
            selected_properties: [],
            dropPlaceholderOptions: {
                className: 'cards-drop-preview',
                animationDuration: '150',
                showOnTop: true
            },
        }
    },
    // watch props change
    created() {
        this.pipelineArray = [...this.pipelines];
    },
    watch: {
        pipelines: function (val) {
            this.pipelineArray = [...val];
        },
        searchKey: function (val) {
            let value = [];
            for(let i = 0; i < this.pipelines.length; i++) {
                let properties = [];
                for(let j = 0; j < this.pipelines[i].properties.length; j++) {
                    if(this.pipelines[i].properties[j].PropertyAddress.toLowerCase().includes(val.toLowerCase()) ||
                        this.pipelines[i].properties[j].OwnerName.toLowerCase().includes(val.toLowerCase()) ||
                        this.pipelines[i].properties[j].OwnerEmailAddress.toLowerCase().includes(val.toLowerCase()) ||
                        this.pipelines[i].properties[j].OwnerPhoneNumber.toLowerCase().includes(val.toLowerCase())
                    ) {
                        properties.push(this.pipelines[i].properties[j]);
                    }
                }
                value.push({
                    id: this.pipelines[i].id,
                    name: this.pipelines[i].name,
                    properties: properties
                });
            }

            this.pipelineArray = value;

        }

    },
    methods: {
        onCardDrop (columnId, dropResult) {
            const pipelines = [...this.pipelineArray]
            // re-order cards in column and update state and prevent updefined error
            if (dropResult.removedIndex !== null || dropResult.addedIndex !== null) {
                pipelines.forEach(pipeline => {
                    if (pipeline.id === columnId) {
                        pipeline.properties = this.applyDrag(pipeline.properties, dropResult)
                    }
                })
            }

            // check when re-ordering cards in column completed
            this.debounce(() => {
                this.updatePipeline();
            }, 600)();

        },

        getCardPayload (columnId) {
            return (index) => {
                return this.pipelineArray.find(pipeline => pipeline.id === columnId).properties[index]
            }
        },
        applyDrag  (arr, dragResult) {
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
        async updatePipeline () {
            const res = await axios({
                url: route("pipelines.orderUpdate"),
                method: "POST",
                data: {
                    pipelines: this.pipelineArray,
                },
            });

            if (res.data.status === "success") {
                this.showModal = false;
                this.$emit('updatePipeline', res.data.pipelines);

                this.selected_properties = []
            }
        },
        toggleSelectAll (id) {
            const pipelines = [...this.pipelineArray]
            pipelines.forEach(pipeline => {
                if (pipeline.id === id) {
                    pipeline.checked = !pipeline.checked
                    pipeline.properties.forEach(property => {
                        property.checked = pipeline.checked
                    })
                }
                this.manageAllSelected(pipeline)
            })

            // select allSelected checkbox if all the child checkboxes are checked

            this.pipelineArray = pipelines
            this.updateSelectedProperties()
        },
        toggleSelect(property, pipeline) {
            property.checked = !property.checked
            this.updateSelectedProperties()
            this.manageAllSelected(pipeline)
        },
        manageAllSelected(pipeline) {
            let checked = true
            pipeline.properties.forEach(property => {
                if (!property.checked) {
                    checked = false
                }
            })
            pipeline.checked = checked
        },
        removeSelected(pipelines) {
            this.selected_properties.forEach(property => {
                this.pipelineArray.forEach(pipeline => {
                    pipeline.properties = pipeline.properties.filter(p => p.id !== property.id)
                })
            })
            this.updateSelectedProperties()
            this.$emit('updateParentPipeline', pipelines);
        },
        switchSelected(pipelines) {
            this.selected_properties = []
            this.$emit('updateParentPipeline', pipelines);
        },
        updateSelectedProperties () {
            this.selected_properties = []
            this.pipelineArray.forEach(pipeline => {
                pipeline.properties.forEach(property => {
                    if (property.checked) {
                        this.selected_properties.push(property)
                    }
                })
            })
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
        onMouseDown (e) {

            if (this.searchKey !== '' || this.selected_properties.length > 0) {
                e.stopPropagation();
            }
        },
        onMouseUp (e) {
            if (this.searchKey !== '' || this.selected_properties.length > 0) {
                e.stopPropagation();
            }
        },

        //add a debounce to prevent multiple requests
        debounce(func, wait, immediate) {
            let timeout;
            return function executedFunction() {
                let context = this;
                let args = arguments;

                let later = function() {
                    timeout = null;
                    if (!immediate) func.apply(context, args);
                };

                let callNow = immediate && !timeout;

                clearTimeout(timeout);

                timeout = setTimeout(later, wait);

                if (callNow) func.apply(context, args);
            };
        },
    }
}
</script>

<style lang="css" scoped>
.pBody__inner .bodyPart .inn__box form label {
    font-size: 14px;
    color: #575a7b !important;
    font-weight: 700;
    text-transform: uppercase;
}
.pBody__inner .bodyPart form {
    font-size: 16px;
    color: #575a7b;
}
.pBody__inner .bodyPart form label  {
    font-size: 14px;
    color: #575a7b;
    flex:1;
}
.pBody__inner .bodyPart form label{
    font-size: 16px;
    color: #575a7b !important;
}
.smooth-dnd-container{
    height: 100%;
    overflow: auto;
}
/*.card-ghost {*/
/*    transition: transform 0.18s ease;*/
/*    !*transform: rotateZ(5deg)*!*/
/*}*/

/*.card-ghost-drop {*/
/*    transition: transform 0.18s ease-in-out !important;*/
/*    !*transform: rotateZ(0deg)*!*/
/*}*/

.opacity-ghost {
    /*transition: all .18s ease;*/
    opacity: 0.8;
    /* transform: rotateZ(5deg); */
    background-color: cornflowerblue;
    box-shadow: 3px 3px 10px 3px rgba(0, 0, 0, 0.3) !important;
}

.opacity-ghost-drop {
    opacity: 1;
    /* transform: rotateZ(0deg); */
    background-color: white;
    box-shadow: 3px 3px 10px 3px rgba(0, 0, 0, 0.0) !important;
}

.drop-preview {
    background-color: rgba(150, 150, 200, 0.1) !important;
    border: 1px dashed #abc;
    margin: 5px;
}

.cards-drop-preview {
    background-color: rgba(150, 150, 200, 0.1) !important;
    border: 1px dashed #abc;
    margin: 5px 45px 5px 5px;
}

.demo2 .regular-checkbox + label{
    background: #fff;
    border:1px solid;
}
.demo2 .regular-checkbox:checked + label{
    background:#db0f19;
    border:1px solid #db0f19;
}
.one-pipeline{
    border-radius: 15px 15px 0 0 !important;
}
.part__top .form-check-input:checked{
    background-color:#db0f19;
    border:#db0f19;
}
.part__top .form-check-input:focus{
    outline:none;
    box-shadow:none;
}
</style>

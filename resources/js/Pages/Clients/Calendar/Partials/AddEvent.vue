<template>
    <Dialog
        :draggable="true"
        v-model:visible="showModal"
        :style="{width: '32vw'}"
        :modal="true"
    >
        <template #header>
            <div
                class="flex justify-content-between align-items-center"
                style="width: 90%"
            >
                <span class="p-dialog-title">Create Event</span>
            </div>
        </template>
        <div class="">
            <hr class="mt-0">
            <div class="modal-body">
                <div class="view_modal_body">
                    <div class="view_modal_body_title mt-2 dflex align-items-center">
                        <div class="form-group modal_create parentform">
                            <p>Title</p>
                            <input class="form-control create-view_model"
                                   v-model="form.title"
                                   @focusout="checkErrors('title')"
                                   type="text"
                                   placeholder="Title">
                            <span v-if="errors.title">
                                <img src="../../../../../../public/images/icons/denied.png" alt="img" />
                                Please enter a event title
                            </span>
                        </div>
                        <input type="color" class="ic-event-color-picker"  v-model="form.color">
                    </div>
                    <div class="timeline">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group modal_create parentform">
                                    <p>Month</p>
                                    <select v-model="form.month"
                                            @focusout="checkErrors('month')"
                                            class="create-view_model" @change="getDays">
                                        <option v-for="month in monthOptions" :value="month.value">
                                           {{ month.label }}
                                        </option>
                                    </select>
                                    <span v-if="errors.month">
                                        <img src="../../../../../../public/images/icons/denied.png" alt="img" />
                                        Please select a month
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group modal_create parentform">
                                    <p>Day</p>
                                    <select v-model="form.day"
                                            @focusout="checkErrors('day')"
                                            class="create-view_model">
                                        <option v-for="day in dayOptions" :value="day">
                                            {{ day }}
                                        </option>
                                    </select>
                                    <span v-if="errors.day">
                                        <img src="../../../../../../public/images/icons/denied.png" alt="img" />
                                        Please select a month
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group modal_create parentform">
                                    <p>Year</p>
                                    <select v-model="form.year"
                                            @focusout="checkErrors('year')"
                                            class="create-view_model" @change="getDays">
                                        <option v-for="year in yearOptions" :value="year">
                                            {{ year }}
                                        </option>
                                    </select>
                                    <span v-if="errors.year">
                                        <img src="../../../../../../public/images/icons/denied.png" alt="img" />
                                        Please select a year
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="timeline">
                        <div class="row align-items-center">
                            <div class="col-md-5">
                                <div class="form-group modal_create parentform">
                                    <p>Time</p>
                                    <select v-model="form.start_time"
                                            @focusout="checkErrors('start_time')"
                                            @change="getAvailableEndTime"
                                            class="create-view_model">
                                        <option v-for="time in startTimeOptions" :value="time.value">
                                            {{ time.label }}
                                        </option>
                                    </select>
                                    <span v-if="errors.start_time">
                                        <img src="../../../../../../public/images/icons/denied.png" alt="img" />
                                        Please select a start time
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <h2 class="time_to">To</h2>
                            </div>
                            <div class="col-md-5">
                                <div class="form-group modal_create parentform">
                                    <p>Time</p>
                                    <select v-model="form.end_time"
                                            @focusout="checkErrors('end_time')"
                                            class="create-view_model">
                                        <option v-for="time in endTimeOptions" :value="time.value">
                                            {{ time.label }}
                                        </option>
                                    </select>
                                    <span v-if="errors.end_time">
                                        <img src="../../../../../../public/images/icons/denied.png" alt="img" />
                                        Please select a end time
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="timeline">
                        <div class="form-group modal_create parentform">
                            <p>Description </p>
                            <textarea class="model_textarea" v-model="form.description" cols="30" rows="5"></textarea>
                        </div>
                    </div>
                    <Button
                        class="p-button-outlined p-button-danger py-4 w-full add-event-button"
                        style="border-radius: 1rem !important"
                        @click="addEvent()"
                        label="Create Event"
                    />
                </div>
            </div>
        </div>
    </Dialog>
    <Button
        class="p-button p-button-outlined p-button-danger"
        style="border-radius: 0.5rem !important"
        icon="pi pi-plus"
        @click="handleModal()"
        label="Add Event"
    ></Button>
</template>

<script>

import axios from "axios";
import {proxyArrayToPlainArray} from "./../helper.js";

export default {
    name: "AddCalendarEvent",
    props: {
        yearArrayData: {
            type: Array,
            required: true,
        },
        monthArrayData: {
            type: Array,
            required: true,
        },
        startTimeArray: {
            type: Array,
        },

    },
    data() {
        return {
            showModal: false,
            yearOptions: [],
            monthOptions: [],
            dayOptions: [],
            startTimeOptions: [],
            endTimeOptions: [],

            errors: {
                title: false,
                color: false,
                month: false,
                day: false,
                year: false,
                start_time: false,
                end_time: false,
            },

            form: {
                title: "",
                color: "#DB0F19",
                description: "",
                month: "",
                day: "",
                year: "",
                start_time: "",
                end_time: "",
            },
        };
    },
    mounted() {
        this.yearOptions = this.yearArrayData;
        this.monthOptions = this.monthArrayData;
        this.startTimeOptions = this.startTimeArray;
        this.getCurrent();
        this.getDays();
    },
    watch: {
        yearArrayData: function (val) {
            this.yearOptions = val;
        },
        monthArrayData: function (val) {
            this.monthOptions = val;
        },
        startTimeArray: function (val) {
            this.startTimeOptions = val;
        },
        showModal: function (val) {
            if (!val) {
                this.resetForm()
            }
        },
    },
    methods: {
        handleModal() {
            this.showModal = !this.showModal;

            if (this.showModal)
                this.getAvailableEndTime();
        },
        async addEvent() {
            const error = this.checkErrors();

            if (error) {
                return false;
            }

            let button = document.querySelector('.add-event-button');
            button.disabled = true;
            button.innerHTML = 'Creating...';

            const res = await axios({
                url: route("calendar.addEvent"),
                method: "POST",
                data: {
                    title: this.form.title,
                    color: this.form.color,
                    description: this.form.description,
                    month: this.form.month,
                    day: this.form.day,
                    year: this.form.year,
                    start_time: this.form.start_time,
                    end_time: this.form.end_time,
                },
            });

            this.handleResponse(res.data);

            if (res.data.status === "success") {
                this.handleModal();
                this.$emit("updateParentEvents", res.data.month_events_by_day);

                const currentMonth = this.form.month;
                const currentYear = this.form.year;

                const date = new Date(currentYear+'-'+currentMonth);
                const year = date.getFullYear();
                const month = date.getMonth() + 1;
                let monthYear = '';
                if (month < 10) {
                    monthYear = year + '-0' + month;
                } else {
                    monthYear = year + '-' + month;
                }

                this.$emit("updateParentMonth", monthYear);

                this.resetForm();
            }

            button.disabled = false;
            button.innerHTML = 'Create Event';
        },
        resetForm() {
            for (let key in this.form){
                if (key !== 'color')
                    this.form[key] = '';
                else
                    this.form[key] = '#DB0F19';

                this.getCurrent();
            }
            for(let key in this.errors){
                this.errors[key] = false;
            }
        },
        getCurrent(){
            const date = new Date();
            const year = date.getFullYear();
            const month = date.getMonth() < 12 ? date.getMonth() + 1 : 1;
            const day = date.getDate();
            this.form.year = year;
            this.form.month = month;
            this.form.day = day;
        },
        getDays() {
            const year = this.form.year;
            const month = this.form.month;
            const days = new Date(year, month, 0).getDate();

            this.dayOptions = [];
            for (let i = 1; i <= days; i++) {
                this.dayOptions.push(i);
            }
        },
        getAvailableEndTime() {
            const originalArray = proxyArrayToPlainArray(this.startTimeOptions)

            const indexToRemove = originalArray.findIndex(obj => obj.value === this.form.start_time);

            if (indexToRemove >= 0) {
                const newArray = originalArray.slice(indexToRemove);
                this.endTimeOptions = newArray;
            } else {
                this.endTimeOptions = originalArray;
            }
        },
        checkErrors(field = null) {
            if (field && this.form[field] === ""){
                this.errors[field] = true;
            } else if(field && this.form[field] !== ""){
                this.errors[field] = false;
            } else {
                // key except description
                for (let key in this.form) {
                    if (key !== "description") {
                        this.errors[key] = this.form[key] === ""
                    }
                }
            }

            return Object.values(this.errors).includes(true);
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
}
</script>
<style>
.add-event-button {
    display: flow-root !important;
}
</style>

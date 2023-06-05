<template>
    <Dialog
        :draggable="false"
        v-model:visible="showModal"
        :style="{width: '32vw'}"
        :modal="true"
    >
        <template #header>
            <div
                class="flex justify-content-between align-items-center"
                style="width: 95%"
            >
                <span class="p-dialog-title">Event Details</span>
                <div class="view_modal_title_right view-edit-event" @click="handleEditModal">
                    <i class="pi pi-pencil icon"></i>
                </div>
            </div>
        </template>
        <div class="">
            <hr class="mt-0">
            <div class="modal-body">
                <div class="view_modal_body">
                    <div class="view_modal_body_title d-flex align-items-center">
                        <h2>{{ event.title }}</h2> <span class="box" :style="{ background: event.color }"></span>
                    </div>
                    <div class="view_time_section">
                        <span class="view_modal_date">
                            <i class="pi pi-calendar" />
                            {{ formatDate(event.date) }}
                        </span>
                        <span class="view_modal_time">
                            <i class="pi pi-clock" />
                            {{ event.start_time +' - '+ event.end_time }}
                        </span>
                    </div>
                    <p class="view_modal_pera">{{ event.description }}</p>
                </div>
            </div>
        </div>
    </Dialog>
    <button type="button"
            @click="handleModal"
            class="calendar_box_btn">
        <div class="calendar_box" :style="{ background: event.color }">
            <h6>{{ event.start_time +' - '+ event.end_time }}</h6>
            <p>{{ event.title }}</p>
        </div>
    </button>

    <Dialog
        :draggable="false"
        v-model:visible="showEditModal"
        :style="{width: '32vw'}"
        :modal="true"
    >
        <template #header>
            <div
                class="flex justify-content-between align-items-center"
                style="width: 90%"
            >
                <span class="p-dialog-title">Edit Event</span>
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
                    <div class="model_view_event_btn_group">
                        <div class="btn_left">
                            <Button
                                class="p-button-outlined p-button-danger py-4 pe-2 w-full add-event-button"
                                style="border-radius: 1rem !important"
                                @click="handleEditModal"
                                label="Cancel"
                            />
                        </div>
                        <div class="btn_right">
                            <Button
                                class="p-button-outlined p-button-danger py-4 ps-2 w-full update-event-button"
                                style="border-radius: 1rem !important"
                                @click="updateEvent"
                                label="Save Event"
                            />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </Dialog>

</template>

<script>

import axios from "axios";
import {proxyArrayToPlainArray} from "@/Pages/Clients/Calendar/helper";

export default {
    name: "EditCalendarEvent",
    props: {
        event: {
            type: Object
        },
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
            yearOptions: [],
            monthOptions: [],
            dayOptions: [],
            startTimeOptions: [],
            endTimeOptions: [],

            eventData: {
                'id' : '',
                'calendar_month_day_id' : '',
                'title': '',
                'date': '',
                'color': '',
                'start_time': '',
                'end_time': '',
                'total_time' : '',
                'description': '',
            },
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
            showModal: false,
            showEditModal: false,
        };
    },

    mounted() {
        this.yearOptions = this.yearArrayData;
        this.monthOptions = this.monthArrayData;
        this.startTimeOptions = this.startTimeArray;

        this.getDays();

        this.eventData = {
            'id' : this.event.id,
            'calendar_month_day_id' : this.event.calendar_month_day_id,
            'title': this.event.title,
            'date': new Date(this.event.date).getMonth() < 12 ? new Date(this.event.date).getMonth() + 1 : 1,
            'color': this.event.time,
            'start_time': this.event.start_time,
            'end_time': this.event.end_time,
            'total_time' : this.event.total_time,
            'description': this.event.description,

        }
        this.form = {
            title: this.event.title,
            color: this.event.color,
            description: this.event.description,
            month: new Date(this.event.date).getMonth() < 12 ? new Date(this.event.date).getMonth() + 1 : 1,
            day: new Date(this.event.date).getDate(),
            year: new Date(this.event.date).getFullYear(),
            start_time: this.event.start_time,
            end_time: this.event.end_time,
        }

        this.getAvailableEndTime();
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
    },

    methods: {
        handleModal() {
            this.showModal = !this.showModal;
        },
        handleEditModal() {
            this.showModal = !this.showModal;
            this.showEditModal = !this.showEditModal;
        },
        formatDate(dateString) {
            const date = new Date(dateString);
            return date.toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' });
        },
        getCurrent(){
            const date = new Date(this.form.year, this.form.month, this.form.day);
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

        async updateEvent() {
            const error = this.checkErrors();

            if (error) {
                return false;
            }

            let button = document.querySelector('.update-event-button');
            button.disabled = true;
            button.innerHTML = 'Saving...';

            const res = await axios({
                url: route("calendar.updateEvent"),
                method: "POST",
                data: {
                    id: this.eventData.id,
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
                this.showEditModal = false;

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
            }

            button.disabled = false;
            button.innerHTML = 'Save Event';
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
.update-event-button {
    display: flow-root !important;
}
</style>

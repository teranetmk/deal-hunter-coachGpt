<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

import HeaderMenu from "./Partials/HeaderMenu.vue";
import CalendarView from "./Partials/CalendarView.vue";
import { Head } from "@inertiajs/inertia-vue3";

</script>

<template>
    <Head title="Calendar" />

    <AuthenticatedLayout>
        <Head><title>Calendar</title></Head>
        <template #pageHeading>
            <div>
                <i class="pi pi-calendar mr-2 text-2xl font-bold" />
                <span class="text-2xl mr-3"
                ><strong
                >Calendar</strong
                ></span
                >
            </div>
            <!-- pipeline nav start here -->
            <HeaderMenu :availableMonthYear="availableMonthYear"
                        :monthYear="monthYear"
                        :yearArray="yearArray"
                        :monthArray="monthArray"
                        :startTimes="startTimes"
                        @getEvents="updateEvents"
                        @updateEventChild="updateEventFromChild"
                        @setSelectedMonthYear="setMonthYearFromChild"
            />

        </template>
        <CalendarView :availableMonthYear="availableMonthYear"
                      :yearArray="yearArray"
                      :monthArray="monthArray"
                      :startTimes="startTimes"
                      :monthEventsByDay="monthEventsByDay"
                      @updateEventChild="updateEventFromChild"
                      @setSelectedMonthYear="setMonthYearFromChild"
        />

    </AuthenticatedLayout>
</template>

<script>
import {plainObjToProxyObj, proxyArrayToPlainArray} from "./helper.js"
import axios from "axios";

export default {
    name: "CalendarPage",
    props: {
        month_year: {
            type: String,
        },
        available_month_year: {
            type: Array,
        },
        years: {
            type: Array,
        }
    },

    data() {
        return {
            availableMonthYear: '',
            monthEventsByDay: [],
            yearArray: [],
            monthArray: [],
            monthYear: '',
            startTimes: [],
        }
    },
    mounted() {
        this.monthYear = this.month_year;
        this.availableMonthYear = proxyArrayToPlainArray(this.available_month_year);
        this.yearArray = this.years

        this.setMonths();
        this.getAvailableStartTime();
    },

    created() {
        this.monthYear = this.month_year;
        // this.availableMonthYear = proxyArrayToPlainArray(this.available_month_year);
        // this.yearArray = this.years

        this.updateEvents(this.month_year);
    },
    methods: {
        setMonths() {
            this.monthArray = [
                {value: '1', label: 'January'},
                {value: '2', label: 'February'},
                {value: '3', label: 'March'},
                {value: '4', label: 'April'},
                {value: '5', label: 'May'},
                {value: '6', label: 'June'},
                {value: '7', label: 'July'},
                {value: '8', label: 'August'},
                {value: '9', label: 'September'},
                {value: '10', label: 'October'},
                {value: '11', label: 'November'},
                {value: '12', label: 'December'},
            ] ;
        },
        async updateEvents(monthYear) {
            this.monthYear = monthYear;

            const res = await axios({
                url: route("calendar.getEventsByMonth"),
                method: "POST",
                data: {
                    month_year: monthYear,
                },
            });

            if (res.data.status === "success") {
                this.monthEventsByDay = plainObjToProxyObj(res.data.month_events_by_day);
            }
        },
        async updateEventFromChild(events) {
            this.monthEventsByDay = events;
        },
        async getAvailableStartTime(){
            const intervals = [];
            const startDate = new Date().setHours(0, 0, 0, 0); // Set start date to midnight

            for (let i = 0; i < 96; i++) { // 48 intervals for 24 hours
                const time = new Date(startDate + (i * 15 * 60 * 1000));
                const options = { hour: 'numeric', minute: '2-digit' };
                const value = time.toLocaleTimeString(['en-us'], options);
                const interval = {
                    value: value,
                    label: value,
                };
                intervals.push(interval);
            }
            this.startTimes = intervals;
        },
        setMonthYearFromChild(monthYear) {
            this.monthYear = monthYear;

        }
    }
}
</script>

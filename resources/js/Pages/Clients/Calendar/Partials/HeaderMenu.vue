<template>

    <div class="nav__right d-flex align-items-center">

        <!-- partial:index.partial.html -->
        <!-- First modal dialog -->
        <div class="nav__inner d-flex justify-content-between align-items-center">
            <div class="nav__right d-flex align-items-center">
                <form class="nav__select calender_nav_select" @submit.prevent="true">
                    <div class="calendar_image">
                        <img src="../../../../../../public/images/icons/Calendar.png" alt="">
                    </div>
                    <select v-model="form.month_year" @change="getEvents">
                        <option v-for="month in availableMonthYear" :value="month.value" >{{month.label}}</option>
                    </select>
                </form>
                <AddEvent :yearArrayData="yearArrayData"
                          :monthArrayData="monthArrayData"
                          :startTimeArray="startTimeArray"
                          @updateParentEvents="updateParentEvent"
                          @updateParentMonth="setSelectedMonthYear"
                />

            </div>
        </div>
    </div>

</template>

<script>
import AddEvent from "./AddEvent.vue";

export default {
    name: "CalendarHeader",
    components: {
        AddEvent
    },
    props: {
        availableMonthYear: {
            type: Array,
            required: true,
        },
        monthYear: {
            type: String,
            required: true,
        },
        yearArray: {
            type: Array,
            required: true,
        },
        monthArray: {
            type: Array,
            required: true,
        },
        startTimes: {
            type: Array,
        },
    },
    data() {
        return {
            form: {
                month_year: this.monthYear,
            },
            yearArrayData: [],
            monthArrayData: [],
            startTimeArray: [],
        };
    },
    watch: {
        monthYear: function (val) {
            this.form.month_year = val;
        },
        yearArray: function (val) {
            this.yearArrayData = val;
        },
        monthArray: function (val) {
            this.monthArrayData = val;
        },
        startTimes: function (val) {
            this.startTimeArray = val;
        },
    },
    methods: {
        getEvents() {
            this.$emit('getEvents', this.form.month_year);
        },
        updateParentEvent(events) {
            this.$emit('updateEventChild', events);
        },
        setSelectedMonthYear(monthYear) {
            this.$emit('setSelectedMonthYear', monthYear);
        },
    }
}
</script>

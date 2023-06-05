<template>
    <div class="calendar">
        <div class="calendar_table">
            <table class="table table-bordered rounded">
                <thead>
                <tr>
                    <th scope="col" v-for="(day, index) in weekDays" :key="index">
                        {{ day }}
                    </th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(week, index) in monthEventsByDay" :key="index">
                    <td v-for="(weekDay, index) in week" :key="index" :class="weekDay.events?.length > 3 ? 'ic-event' : ''">
<!--                        check event day_name if match with header than show     -->
                        <span :class="today === weekDay.date ? 'td-text': ''">
                            {{ weekDay.day }}
                        </span>

                        <div v-if="weekDay.day_name === weekDays[index]">

                            <div class="ic-events" :class="weekDay.events?.length > 3 ? 'event' : ''">
                                <div v-for="(event, index) in weekDay.events" :key="index" >
                                    <ViewEvent :event="event"
                                               :yearArrayData="yearArrayData"
                                               :monthArrayData="monthArrayData"
                                               :startTimeArray="startTimeArray"
                                               @updateParentEvents="updateParentEvent"
                                               @updateParentMonth="setSelectedMonthYear"
                                    />
                                </div>
                            </div>
                        </div>

                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
import ViewEvent from "./ViewEvent.vue";

export default {
    name: "CalendarViewPage",
    components: {
        ViewEvent
    },
    props: {
        availableMonthYear: {
            type: Array,
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
        monthEventsByDay: {
            type: Object,
        },
    },

    data() {
        return {
            weekDays: {
                0: 'Sunday',
                1: 'Monday',
                2: 'Tuesday',
                3: 'Wednesday',
                4: 'Thursday',
                5: 'Friday',
                6: 'Saturday',
            },
            yearArrayData: [],
            monthArrayData: [],
            startTimeArray: [],
            today: '',
        }
    },
    created(){
        this.today = this.getCurrentDate();
    },
    watch: {
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

        updateParentEvent(events) {
            this.$emit('updateEventChild', events);
        },

        setSelectedMonthYear(monthYear) {
            this.$emit('setSelectedMonthYear', monthYear);
        },
        getCurrentDate(){
            let date = new Date();
            const year = date.getFullYear();
            const month = date.getMonth() + 1;
            let monthYear = '';
            if (month < 10) {
                monthYear = year + '-0' + month;
            } else {
                monthYear = year + '-' + month;
            }
            const day = date.getDate();


            date = monthYear + '-' + day;

            console.log(date)
            return date;
        },
    }
}
</script>

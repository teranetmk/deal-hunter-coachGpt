<?php

namespace App\Http\Controllers;

use App\Models\CalendarMonth;
use App\Models\CalendarMonthDay;
use App\Models\CalendarMonthDayEvent;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CalendarController extends Controller
{
    public function index(): \Inertia\Response
    {
        $month_year = date('Y-m');
        if (request()->has('month_year')) {
            $month_year = request()->get('month_year');
        }
        $variables = $this->getVariables($month_year);

        return Inertia::render('Clients/Calendar/Calendar', $variables);
    }

    private function getVariables($month_year): array
    {
        $variables = [];

        $available_month_year = $this->getAvailableMonthYear();

        $variables['month_year'] = $month_year;
        $variables['available_month_year'] = $available_month_year;
        $variables['years'] = $this->getYears();

        return $variables;

    }

    public function getAvailableMonthYear(): array
    {
        $available_month_year = [];

        $current_year = date('Y');

        for ($i = 1; $i <= 12; $i++) {
            $month_year = date('F, Y', strtotime("$current_year-$i"));
            $date = date('Y-m', strtotime("$current_year-$i"));
            $available_month_year[] = [
                'value' => $date,
                'label' => $month_year
            ];
        }

        $next_year = $current_year + 1;
        for ($i = 1; $i <= 12; $i++) {
            $month_year = date('F, Y', strtotime("$next_year-$i"));
            $date = date('Y-m', strtotime("$next_year-$i"));
            $available_month_year[] = [
                'value' => $date,
                'label' => $month_year
            ];
        }

        return $available_month_year;
    }

    public function getMonthEventByDay(Request $request, $month_year = '', $after_add = false): array
    {
        try {
            if ($request->ajax()) {
                $month_year = $request->get('month_year');
            }

            $events = [];

            $month = date('m', strtotime($month_year));
            $year = date('Y', strtotime($month_year));
            $day_count = date('t', strtotime($month_year));

            // separate events by weekly basis starting from sunday
            $week = 0;
            for ($i = 1; $i <= $day_count; $i++) {
                $day = date('l', strtotime("$year-$month-$i"));
                if ($week == 0 && $i == 1 && $day != 'Sunday') {
                    // if day is not sunday, add empty days starting from sunday
                    // get the count of days to add empty days
                    $days_to_add = array_search($day, CalendarMonthDay::DAYS);

                    for ($j = 0; $j < $days_to_add; $j++) {
                        $events[$week][] = [
                            'day' => '',
                            'date' => '',
                            'day_name' => '',
                            'events' => [],
                        ];
                    }
                }
                if ($day == 'Sunday') {
                    $week++;
                }

                $month_day = CalendarMonthDay::where('date', date('Y-m-d', strtotime("$year-$month-$i")))
                    ->with('events:id,calendar_month_day_id,title,date,start_time,end_time,color,description')
                    ->whereHas('events', function ($query) {
                        $query->where('user_id', auth()->id());
                    })
                    ->first();

                $events[$week][] = [
                    'day' => date('d', strtotime("$year-$month-$i")),
                    'date' => date('Y-m-d', strtotime("$year-$month-$i")),
                    'day_name' => $day,
                    'events' => $month_day ? $month_day->events->toArray() : [],
                ];
            }

            if (!$after_add && $request->ajax()) {
                return [
                    'status' => 'success',
                    'message' => 'Events fetched successfully',
                    'month_events_by_day' => $events,
                ];
            }

            return $events;
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => $e->getMessage(),
            ];
        }
    }

    public function addEvent(Request $request)
    {
        try {
            $request->validate([
                'title' => 'required',
                'start_time' => 'required',
                'end_time' => 'required',
                'color' => 'required',
                'year' => 'required',
                'month' => 'required',
                'day' => 'required',
                'description' => 'nullable|string',
            ]);

            $calendar = $this->checkIfCalendarMonthExists($request->get('month'), $request->get('year'));

            $day = $calendar->days()->where('day', $request->get('day'))->first();

            $date = date('Y-m-d', strtotime("$request->year-$request->month-$request->day"));

            if (!$day) {
                $day = $calendar->days()->create([
                    'day' => $request->get('day'),
                    'date' => $date,
                ]);
            }

            $total_time = $this->getTotalTime($request->get('start_time'), $request->get('end_time'));

            $day->events()->create([
                'title' => $request->get('title'),
                'user_id' => auth()->id(),
                'date' => $date,
                'start_time' => $request->get('start_time'),
                'end_time' => $request->get('end_time'),
                'total_time' => $total_time,
                'color' => $request->get('color'),
                'description' => $request->get('description'),
            ]);

            $month_year = date('Y-m', strtotime("$request->year-$request->month"));

            //add month year to request
            $request->request->add(['month_year' => $month_year]);

            return [
                'status' => 'success',
                'message' => 'Event created successfully',
                'month_events_by_day' => $this->getMonthEventByDay(request(), $month_year, true),
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => $e->getMessage(),
            ];
        }
    }

    public function updateEvent(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'title' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
            'color' => 'required',
            'year' => 'required',
            'month' => 'required',
            'day' => 'required',
            'description' => 'nullable|string',
        ]);

        $calendar = $this->checkIfCalendarMonthExists($request->get('month'), $request->get('year'));

        $day = $calendar->days()->where('day', $request->get('day'))->first();

        $date = date('Y-m-d', strtotime("$request->year-$request->month-$request->day"));

        if (!$day) {
            $day = $calendar->days()->create([
                'day' => $request->get('day'),
                'date' => $date,
            ]);
        }

        $total_time = $this->getTotalTime($request->get('start_time'), $request->get('end_time'));

        $event = CalendarMonthDayEvent::find($request->get('id'));

        if (!$event){
            return [
                'status' => 'error',
                'message' => 'Event not found',
            ];
        } else {
            $event->update([
                'title' => $request->get('title'),
                'calendar_month_day_id' => $day->id,
                'date' => $date,
                'start_time' => $request->get('start_time'),
                'end_time' => $request->get('end_time'),
                'total_time' => $total_time,
                'color' => $request->get('color'),
                'description' => $request->get('description'),
            ]);
        }

        $month_year = date('Y-m', strtotime("$request->year-$request->month"));

        //add month year to request
        $request->request->add(['month_year' => $month_year]);

        return [
            'status' => 'success',
            'message' => 'Event updated successfully',
            'month_events_by_day' => $this->getMonthEventByDay(request(), $month_year, true),
        ];

    }


    private function getYears(): array
    {
        $current_year = date('Y');
        $next_year = $current_year + 1;

        return [
            $current_year => $current_year,
            $next_year => $next_year,
        ];
    }

    private function checkIfCalendarMonthExists($month, $year)
    {
        $calendar = CalendarMonth::where('month', $month)
            ->where('year', $year)
            ->first();

        if (!$calendar) {
            $calendar = CalendarMonth::create([
                'month' => $month,
                'year' => $year,
            ]);

        }

        return $calendar;
    }

    private function getTotalTime($start_time, $end_time)
    {
        $start_time = strtotime($start_time);
        $end_time = strtotime($end_time);
        $total_time = $end_time - $start_time;
        $total_time = date('H:i', $total_time);

        return $total_time;
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CalendarMonthDay extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    const DAYS = [
        'Sunday',
        'Monday',
        'Tuesday',
        'Wednesday',
        'Thursday',
        'Friday',
        'Saturday'
    ];

    public function events(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(CalendarMonthDayEvent::class)
            ->orderBy(DB::raw("STR_TO_DATE(start_time, '%h:%i %p')"))
            ->orderBy(DB::raw("STR_TO_DATE(end_time, '%h:%i %p')"));
    }
}

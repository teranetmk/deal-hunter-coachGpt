<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CalendarMonth extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function days(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(CalendarMonthDay::class);
    }
}

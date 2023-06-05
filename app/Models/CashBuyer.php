<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CashBuyer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'profile_pic',
        'email',
        'contact_no',
        'min_price_range',
        'max_price_range',
        'min_profit_deal',
        'state',
        'city',
        'zip',
        'property_type',
        'beds',
        'baths',
        'user_id'
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListsPropertiesAssoc extends Model
{
    use HasFactory;

    protected $fillable = [
        'list_id',
        'property_id'
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MotivationTags extends Model
{
    use HasFactory;

    protected $fillable = [
        'userid',
        'tag_name',
        'tag_type'
    ];


}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compaign extends Model
{
    use HasFactory;

    protected $guarded = [];

    // protected $appends  = ["unsent"];


    public function lists() {
        return $this->belongsToMany(Lists::class, 'compaign_lists', 'compaign_id', 'list_id');
    }

    public function logs() {
        return $this->hasMany(CompaignLog::class, 'compaign_id', 'id');
    }

    public function getCreatedAtAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->format("d/m/Y H:i A");
    }



    // public function getUnsentAttribute()
    // {

    //     return CompaignLog::where('compaign_id', $this->id)->where('status', 0)->count();

    // }
}

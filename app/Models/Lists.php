<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lists extends Model
{
    use HasFactory;

    protected $fillable = [
        'userid',
        'filename',
        'properties_count',
        'list_type',
        'list_type_name'
    ];

    function properties() {
        return $this->belongsToMany(Properties::class, 'lists_properties_assocs','list_id', 'property_id');
    }

    function tags() {
        return $this->belongsToMany(MotivationTags::class, 'lists_tags_assocs', 'list_id', 'tag_id');
    }

    public function getCreatedAtAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->format("d/m/Y");
    }


}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Properties extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $fillable = [
        'userid',
        'PropertyAddress',
        'PropertyCity',
        'PropertyState',
        'PropertyZipCode',
        'OwnerName',
        'OwnerEmailAddress',
        'OwnerPhoneNumber',
        'MailingAddress',
        'MailingCity',
        'MailingState',
        'MailingZipCode',
        'DateAddedToList',
        'insta_offer',
        'insta_price',
    ];

    public function list() {
       return $this->belongsToMany(Lists::class, 'lists_properties_assocs', 'property_id', 'list_id')->with('tags');
    }

    public function pipeline(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Pipeline::class, 'pipeline_property', 'property_id', 'pipeline_id')->withPivot('sort_order');
    }


}

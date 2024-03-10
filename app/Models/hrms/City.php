<?php

namespace App\Models\hrms;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class City extends Model {

    use SoftDeletes;

    protected $table = 'common_cities';
    protected $fillable = [
        'country_id',
        'state_id',
        'city_name',
        'Name',
        'location',
        'latitude',
        'longitude',
        'is_active',
        
    ];
    protected $dates = ['deleted_at'];

}

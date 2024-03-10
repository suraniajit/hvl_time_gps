<?php

namespace App\Models\hrms;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Country extends Model {

    use SoftDeletes;

    protected $table = 'common_countries';
    
    protected $fillable = [
        'id',
        'country_name',
        'is_active',
    ];
    protected $dates = ['deleted_at'];

}

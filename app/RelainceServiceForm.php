<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RelainceServiceForm extends Model
{
    
    protected $table='reliance_service_form_main';
    protected $fillable=[
        'activity_id',
        'store_name',
        'store_code',
        'forment',
        'state',
        'carpet_area',
        'vendor_name',
        'month',
        'year'
    ];
    
}

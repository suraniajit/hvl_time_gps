<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RelainceServiceFifthForm extends Model
{
    
    protected $table='reliance_service_form_5';
    protected $fillable=[
        'main_form_id',
        'vender_name',
        'employee_name',
        'mobile',
        'week',
        'vender_sign',
        'store_manager_name',
        'store_manager_sign'
    ];
    
}

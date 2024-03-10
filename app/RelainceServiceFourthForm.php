<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RelainceServiceFourthForm extends Model
{
    
    protected $table='reliance_service_form_4';
    protected $fillable=[
        'main_form_id',
        'pest_control_service',
        'frequency',
        'date_of_service',
        'service_type',
        'dilution',
        'application_method',
        'pco_sign',
        'remark',
    ];
    
}

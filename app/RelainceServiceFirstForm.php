<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RelainceServiceFirstForm extends Model
{
    
    protected $table='reliance_service_form_1';
    protected $fillable=[
        'main_form_id',
        'activity',
        'date_of_service',
        'payable_amount',
        'recommended_deductions',
        'recommended_payments',
        'remarks',
    ];
    
}

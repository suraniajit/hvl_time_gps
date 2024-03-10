<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RelainceServiceSecondForm extends Model
{
    
    protected $table='reliance_service_form_2';
    protected $fillable=[
        'main_form_id',
        'detail_of_activity',
        'week_1',
        'week_2',
        'week_3',
        'week_4',
        'remarks',
    ];
    
}

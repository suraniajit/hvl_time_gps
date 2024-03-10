<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RelainceServiceThirdForm extends Model
{
    
    protected $table='reliance_service_form_3';
    protected $fillable=[
        'main_form_id',
        'last_audit_suggestional',
        'earlier_audit_recommended',
        'last_observations_date'
    ];
    
}

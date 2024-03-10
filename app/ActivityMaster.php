<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ActivityMaster extends Model {

    public $timestamps = false;
    protected $table = 'hvl_activity_master';
    protected $fillable =[
        'employee_id',
        'customer_id',
        'master_date',
        'start_date',
        'end_date',
        'start_time',
        'end_time',
        'frequency',
        'type',
        'month',
        'status',
        'created_by',
        'create_at',
        'flag',
        'user_id',
        'job_card',
        'complete_date',
        'subject',
        'remark',
        'services_value',
        'batch',
    ];    
    
}

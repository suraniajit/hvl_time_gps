<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SystemLog extends Model
{
    protected $table = 'system_logs';
    protected $fillable =[
        'module',
        'action',
        'action_by',
        'action_user_id',
        'user_understand_data',
        'system_data',
    ];    
    
}

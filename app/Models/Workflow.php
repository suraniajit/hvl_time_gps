<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Workflow extends Model {

    protected $table = 'workflow_rules';
    protected $fillable = [
        'name',
        'module_id',
        'create_date',
        'rules_description',
        'when_execute',
        'email_template_id',
        'radio',
        'mail_status',
        'count_result',
        'is_active',
    ];

    //protected $guarded = [];
}

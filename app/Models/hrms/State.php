<?php

namespace App\Models\hrms;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class State extends Model {

    use SoftDeletes;

    protected $table = 'common_states';
    protected $fillable = [
        'country_id',
        'state_name',
        'is_active',
    ];
    protected $dates = ['deleted_at'];

}

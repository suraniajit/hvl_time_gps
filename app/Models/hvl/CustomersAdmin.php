<?php

namespace App\Models\hvl;

use Illuminate\Database\Eloquent\Model;

class CustomersAdmin extends Model {

    protected $table = 'customers_admins';
    protected $fillable = [
        'id','user_id','customers_id'
    ];
}

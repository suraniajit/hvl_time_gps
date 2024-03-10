<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Designation extends Model {

    protected $guarded = [];

    public function employees() {
        return $this->belongsToMany('App\Employee');
    }

}

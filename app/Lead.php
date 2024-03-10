<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lead extends Model {

    protected $guarded = [];

    public function user() {
        return $this->belongsTo('App\User');
    }

    public function departments() {
        return $this->belongsToMany('App\Department');
    }

    public function teams() {
        return $this->belongsToMany('App\Team');
    }

    public function designations() {
        return $this->belongsToMany('App\Designation');
    }
    public function leads() {
        return $this->belongsToMany('App\Lead');
    }

}

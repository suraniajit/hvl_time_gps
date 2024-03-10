<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $guarded = [];

    public function employees()
    {
        return $this->belongsToMany('App\Employee');
    }
}

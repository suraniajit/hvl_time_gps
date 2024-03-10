<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penalty extends Model
{
    protected $table='penalty';

    protected $fillable = [
        'penalty_for',
        'amount',

    ];
}

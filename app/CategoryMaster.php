<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CategoryMaster extends Model {

    protected $table = 'category';
    protected $fillable = [
        'name',
        'description',
        'is_active',
    ];

}

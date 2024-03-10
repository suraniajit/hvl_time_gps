<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubCategoriesMaster extends Model {

    protected $table = 'sub_category';
    protected $fillable = [
        'name',
        'category_id',
        'description',
        'is_active',
    ];

}

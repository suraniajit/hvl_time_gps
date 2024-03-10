<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserColors extends Model {

    protected $fillable = [
        'user_id',
        'menu_color',
        'navbar_color',
        'title_color',
        'breadcrumb_color',
        'button_color',
        'dark_menu',
        'menu_selection',
        'font_family',
        'menu_size',
        'breadcrumb_size',
        'title_size',
        'table_size',
        'label_size',
        'icon_color',
        'is_active',
    ];
    protected $table = 'user_colors';

}

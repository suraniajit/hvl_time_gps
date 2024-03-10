<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use App\Role;
use App\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\UserColors;

class ColorPickerController extends Controller {

    public function getcustomizerdata() {
        $id = Auth::id();
        $colors = UserColors::where('user_id', $id)->get();
        echo json_encode($colors);
    }

    public function storecustomizer(Request $request) {
        $id = Auth::id();

        $UserColors = DB::table("user_colors")->where("user_id", '=', $id)->update([
            'menu_color' => $request->menu_color,
            'navbar_color' => $request->navbar_color,
            'title_color' => $request->title_color,
            'breadcrumb_color' => $request->breadcrumb_color,
            'button_color' => $request->button_color,
            'dark_menu' => $request->menu_dark,
            'menu_selection' => $request->menu_selection,
            'font_family' => $request->font_family,
            'menu_size' => $request->menu_size,
            'breadcrumb_size' => $request->breadcrumb_size,
            'title_size' => $request->title_size,
            'table_size' => $request->table_size,
            'label_size' => $request->label_size,
            'icon_color' => $request->icon_color,
        ]);
        //dd($request->all());
    }

    //Set Default values
    public function customizerdefault() {
        $id = Auth::id();
        $UserColors = DB::table("user_colors")->where("user_id", '=', $id)->update([
            'menu_color' => 'gradient-45deg-purple-deep-purple',
            'navbar_color' => 'gradient-45deg-purple-deep-purple',
            'title_color' => 'black-text',
            'breadcrumb_color' => 'white-text',
            'button_color' => '#ff4081',
            'dark_menu' => '0',
            'menu_selection' => 'sidenav-active-square',
            'font_family' => 'Muli',
            'menu_size' => '14px',
            'breadcrumb_size' => '14px',
            'title_size' => '32px',
            'table_size' => '15px',
            'label_size' => '10px',
            'icon_color' => 'blue-text',
        ]);
    }

}

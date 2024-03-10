<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Mail;
use Carbon\Carbon;
//use App\Notification;

class Controller extends BaseController {

    use AuthorizesRequests,
        DispatchesJobs,
        ValidatesRequests;

    public function send_notification($user_id, $messgae) {
//        Notification::create([
//            'user_id' => $user_id,
//            'notification' => $messgae,
//        ]);
    }

    public function notifiaciton_remove(Request $request) {
        DB::table('user_notification')->where('id', $request->input('id'))->update(['is_read' => 1]);
    }

    public function notifiaciton(Request $request) {

        $breadcrumbs = [
            ['link' => "/notifiaciton", 'name' => "Home"],
            ['link' => "/notifiaciton/", 'name' => "Notifiaciton Master"],
        ];
        $pageConfigs = ['pageHeader' => true, 'isFabButton' => true, 'isCustomizer' => true];
        if (Auth::id() == 1) {
            $notification = Notification::where('is_read', '=', '0')
                    ->orderBy('id', 'DESC')
                    ->where('user_id', '=', Auth::id())
                    ->get();
        } else {
            $notification = Notification::where('is_read', '=', '0')
                    ->orderBy('id', 'DESC')
                    ->where('user_id', '=', Auth::id())
                    ->get();
        }

        return view('notifiaciton.index', [
            'notifications' => $notification,
            'pageConfigs' => $pageConfigs,
            'breadcrumbs' => $breadcrumbs,
        ]);
    }

    public function get_count_of_data($table_name, $where_condition, $where_imput, $count, $is_save = 1) {
        return DB::table($table_name)
                        ->where($where_condition, '=', $where_imput)
                        ->where('is_active', '=', 0)
                        ->where('is_save', '=', $is_save)
                        ->count($count);
    }

    public function get_sum_of_data_by_combination($table_name, $where_condition, $where_imput, $sum, $combination) {

        return DB::table($table_name)
                        ->where($where_condition, '=', $where_imput)
                        ->where('combination_name', '=', $combination)
                        ->where('is_active', '=', 0)
                        ->where('is_save', '=', '1')
                        ->sum($sum);
    }

    public function get_all_sum_of_data($table_name, $sum, $is_save = 1) {
        return DB::table($table_name)
                        ->where('is_active', '=', 0)
                        ->where('is_save', '=', $is_save)
                        ->sum($sum);
    }

    public function get_sum_of_data($table_name, $where_condition, $where_imput, $sum, $is_save = 1) {
        return DB::table($table_name)
                        ->where('is_active', '=', 0)
                        ->where($where_condition, '=', $where_imput)
                        ->where('is_save', '=', $is_save)
                        ->sum($sum);
    }

    public function getNotifiacitonUser(Request $request) {
        $user_id = $request->input('user_id_sesssion');
        $not_count = DB::table('user_notification')->where('user_id', '=', $user_id)->where('is_read', '=', 0)->count();
        if ($not_count > 0) {
            $res = array('status' => 1, 'count' => $not_count);
        } else {
            $res = array('status' => 0, 'count' => '0');
        }
        return json_encode($res);
        die;
    }

    public function getAllDynamicTable_OrderBy($table_name, $orderby, $order = "ASC") {
        return DB::table($table_name)->orderBy($orderby, $order)->get();
    }

    public function getAllDynamicTable($table_name) {
        return DB::table($table_name)->get();
    }

    public function getConditionDynamicTableAll($table_name, $where_condition, $where_value) {
        return DB::table($table_name)->where($where_condition, '=', $where_value)->get();
    }

    public function getConditionDynamicTable($table_name, $where_condition, $where_value) {
        return DB::table($table_name)->where($where_condition, '=', $where_value)->first();
    }

    public function getConditionDynamicNameTable($table_name, $where_condition, $where_value, $value) {
        return DB::table($table_name)->where($where_condition, '=', $where_value)->value($value);
    }

    public function getExpanceSettings($business_name) {
        return DB::table('api_expenses_settings')
                        ->where('business_name', '=', $business_name)
                        ->value('combined_submission');
    }

}

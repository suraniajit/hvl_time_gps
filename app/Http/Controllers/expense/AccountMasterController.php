<?php

namespace App\Http\Controllers\expense;

use App\User;
use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Datatables;
use SweetAlert;
use Validator;
use Mail;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

class AccountMasterController extends Controller {

    public function __construct() {

//        $this->middleware('permission:Access Accounts', ['only' => ['show', 'index']]);
//        $this->middleware('permission:Create Accounts', ['only' => ['create']]);
//        $this->middleware('permission:Read Accounts', ['only' => ['read']]);
//        $this->middleware('permission:Edit Accounts', ['only' => ['edit']]);
//        $this->middleware('permission:Delete Accounts', ['only' => ['delete']]);
    }

    public function index() {
        $breadcrumbs = [
            ['link' => "/", 'name' => "Home"],
            ['link' => "/account/", 'name' => "Account Master"],
        ];

        $pageConfigs = ['pageHeader' => true, 'isFabButton' => true, 'isCustomizer' => true];

        if (Auth::id() == 122) {
            $account_detais = DB::table('employees')
                    ->select('employees.*')
//                    ->where('employees.account_id', '!=', 0)
//                    ->where('employees.manager_id', '!=', 0)
                    ->get();
        } else {
            $account_detais = DB::table('employees')
                    ->where('employees.user_id', '=', Auth::id())
                    ->get();
        }

        return view('employee-master.account.index', [
            'pageConfigs' => $pageConfigs,
            'breadcrumbs' => $breadcrumbs,
            'account_detais' => $account_detais
        ]);
    }

    public function create() {

        $breadcrumbs = [
            ['link' => "account", 'name' => "Home"],
            ['link' => "account/", 'name' => "Account Master"],
            ['name' => "Create"],
        ];
        $pageConfigs = ['pageHeader' => true, 'isFabButton' => true, 'isCustomizer' => true];

        $payment_status_master = (new Controller)->getAllDynamicTable('payment_status');
        $payment_method_master = (new Controller)->getAllDynamicTable('payment_method');
        $employee_master = (new Controller)->getAllDynamicTable('employees');
        $account_master = (new Controller)->getAllDynamicTable('api_account_master');

        return view('employee-master.account.create', [
            'pageConfigs' => $pageConfigs,
            'breadcrumbs' => $breadcrumbs,
            'payment_method_master' => $payment_method_master,
            'payment_status_master' => $payment_status_master,
            'employee_master' => $employee_master,
            'account_master' => $account_master,
        ]);
    }

    public function view_allExpanceActions($id) {
        $breadcrumbs = [
            ['link' => "/home", 'name' => "Home"],
            ['link' => "/account/", 'name' => "Account Managment"],
            ['name' => "Update"],
        ];
//Pageheader set true for breadcrumbs
        $pageConfigs = ['pageHeader' => true, 'isFabButton' => true, 'isCustomizer' => true];

        $accountMaster = DB::table('employees')->select('*')->where('id', '=', $id)->first();
        $payment_status_master = (new Controller)->getAllDynamicTable('payment_status');
        $payment_method_master = (new Controller)->getAllDynamicTable('payment_method');
        $employee_master = (new Controller)->getAllDynamicTable('employees');

        if (Auth::id() == 1) {
            $account_detais = DB::table('api_expenses_action_log')
                    ->select('api_expenses_action_log.*')
                    ->where('api_expenses_action_log.emp_id', '=', $id)
                    ->get();
        } else {
            $account_detais = DB::table('employees')
                    ->where('api_expenses_action_log.emp_id', '=', Auth::id())
                    ->get();
        }


        if ($accountMaster) {
            return view('employee-master.account.view_expances', [
                'pageConfigs' => $pageConfigs,
                'breadcrumbs' => $breadcrumbs,
                'account_detais' => $account_detais,
            ]);
        }
    }

    public function edit($id) {
        $breadcrumbs = [
            ['link' => "/home", 'name' => "Home"],
            ['link' => "/account/", 'name' => "Account Managment"],
            ['name' => "Update"],
        ];
//Pageheader set true for breadcrumbs
        $pageConfigs = ['pageHeader' => true, 'isFabButton' => true, 'isCustomizer' => true];

        $accountMaster = DB::table('employees')->select('*')->where('id', '=', $id)->first();
        $payment_status_master = (new Controller)->getAllDynamicTable('payment_status');
        $payment_method_master = (new Controller)->getAllDynamicTable('payment_method');
        $employee_master = (new Controller)->getAllDynamicTable('employees');
        if ($accountMaster) {
            return view('employee-master.account.edit', [
                'pageConfigs' => $pageConfigs,
                'breadcrumbs' => $breadcrumbs,
                'payment_method_master' => $payment_method_master,
                'payment_status_master' => $payment_status_master,
                'employee_master' => $employee_master,
                'accountMaster' => $accountMaster,
            ]);
        }
    }

    public function update(Request $request, $id) {


        $apiemp_master = DB::table('employees')->where('id', '=', $id)->update([
            'manager_id' => $request->manager_id,
            'account_id' => $request->account_id,
//            'account_note' => $request->account_note,
        ]);

//        if (isset($request->ddl_team_lead)) {
//            $send_notification = (new Controller)->send_notification($request->ddl_team_lead, "Employee Create Successfully : " . $request->name . "");
//        }
//        if (isset($request->dd_department_lead)) {
//            $send_notification = (new Controller)->send_notification($request->dd_department_lead, "Hello Department , Employee Create Successfully : " . $request->name . "");
//        }
//        if (isset($request->dd_hr)) {
//            $send_notification = (new Controller)->send_notification($request->dd_hr, "Dear HR, Employee Create Successfully : " . $request->name . "");
//        }

        $send_notification = (new Controller)->send_notification('1', "Employee Update Successfully");

        return redirect(route('account'))->with('success', 'Employee Account Update Successfully!');
    }

    function delete(Request $request) {
        $apiemp_master = DB::table('employees')->where('id', '=', $request->input('id'))->update([
            'manager_id' => 0,
            'account_id' => 0,
        ]);
    }

    public function store(Request $request) {


        $apiemp_master = DB::table('employees')->where('user_id', '=', $request->emp_id)->update([
            'manager_id' => $request->manager_id,
            'account_id' => $request->account_id,
//            'account_note' => $request->account_note,
        ]);

//        if (isset($request->ddl_team_lead)) {
//            $send_notification = (new Controller)->send_notification($request->ddl_team_lead, "Employee Create Successfully : " . $request->name . "");
//        }
//        if (isset($request->dd_department_lead)) {
//            $send_notification = (new Controller)->send_notification($request->dd_department_lead, "Hello Department , Employee Create Successfully : " . $request->name . "");
//        }
//        if (isset($request->dd_hr)) {
//            $send_notification = (new Controller)->send_notification($request->dd_hr, "Dear HR, Employee Create Successfully : " . $request->name . "");
//        }

        $send_notification = (new Controller)->send_notification('1', "Employee Account Successfully");

        return redirect(route('account'))->with('success', 'Employee Account Create Successfully!');
    }

}

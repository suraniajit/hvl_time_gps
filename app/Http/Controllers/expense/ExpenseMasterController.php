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
use App\ExpenseMaster;
use Validator;
use Mail;
use Carbon\Carbon;
use App\Mail\DownloadAttachementMail;

class ExpenseMasterController extends Controller {

    public function __construct() {
        $this->middleware('permission:Access expense', ['only' => ['show', 'index']]);
        $this->middleware('permission:Create expense', ['only' => ['create']]);
        $this->middleware('permission:Read expense', ['only' => ['read']]);
        $this->middleware('permission:Edit expense', ['only' => ['edit']]);
        $this->middleware('permission:Delete expense', ['only' => ['delete']]);
    }

    function expense_document($document_id) {

        $account_detaile_file = DB::table('api_expenses_documents')
                ->where('api_expenses_documents.emp_id', '=', $document_id)
                ->get();
        return view('employee-master.expense._document_view', [
            'account_detaile_file' => $account_detaile_file,
        ]);
    }

    function mass_move_save(Request $request) {

        $comname = '';
        $emp_mass = $request->input('id');
        $combination_name = trim($request->input('combination_name'));

        if (!isset($combination_name) || $combination_name != '') {
            $comname = $combination_name;
        } else {
            $comname = 'expance-' . Carbon::today()->format('h') . '_' . rand(0, 9) . '_' . Auth::id();
        }
        foreach ($emp_mass as $id) {
            DB::table('api_expenses')->where('id', '=', $id)->update([
                'is_save' => 1,
// 'combination_name' => ($combination_name ? $combination_name : $toda ),
                'combination_name' => $comname,
                'combination_submit_date' => Carbon::today()->format('Y-m-d'),
                'combination_name_temp' => $comname . rand(0, 9) . '_' . Auth::id(),
            ]);
        }
    }

    function massremove(Request $request) {
        $emp_mass = $request->input('id');
        foreach ($emp_mass as $id) {
            DB::table('api_expenses')->where('id', '=', $id)->delete();
            DB::table('api_expenses_documents')->where('emp_id', '=', $id)->delete();
            DB::table('api_expenses_action_log')->where('emp_id', '=', $id)->delete();
            DB::table('employees')->where('user_id', '=', $id)->update([
                'manager_id' => 0,
                'account_id' => 0,
            ]);
        }
    }

    public function expense_delete(Request $request, $id) {

        DB::table('api_expenses_documents')->where('id', $request->input('id'))->delete();
    }

    public function expense_document_delete(Request $request) {
        if ($request->input('delete') == 'expance_document') {
            DB::table('api_expenses_documents')->where('id', $request->input('id'))->delete();
        }
    }

    public function destroy(Request $request) {
        if ($request->input('delete') == 'expance_details') {

            $edit_details_file = (new Controller)->getConditionDynamicTableAll('api_expenses', 'id', $request->input('id'));
            $is_user = $edit_details_file[0]->is_user;

            DB::table('api_expenses_documents')->where('emp_id', $request->input('id'))->delete();
            DB::table('api_expenses_action_log')->where('emp_id', $request->input('id'))->delete();
            DB::table('api_expenses_resubmit')
                    ->where('is_user', '=', $is_user)
                    ->where('expance_id', '=', $request->input('id'))
                    ->delete();
            DB::table('api_expenses')->where('id', $request->input('id'))->delete();
        } else if ($request->input('delete') == 'expance_document') {

            DB::table('api_expenses_documents')->where('emp_id', $request->input('id'))->delete();
        }
    }

    function validcontact(Request $request) {
        if ($request->input('contact_no') !== '') {
            $rule = array(
                'contact_no' => 'unique:employees',
            );
            $validator = Validator::make($request->all(), $rule);
            if (!$validator->fails()) {
                die('true');
            }
        }
        die('false');
    }

    function validemail(Request $request) {

        if ($request->input('email') !== '') {
            $rule = array(
                'email' => 'unique:users',
            );
            $validator = Validator::make($request->all(), $rule);
            if (!$validator->fails()) {
                die('true');
            }
        }
        die('false');
    }

    public function editvalidname(Request $request) {
        $id = $request->id;
        $rule = array(
            'email' => Rule::unique('users', 'email')->ignore($id),
        );
        $validator = Validator::make($request->all(), $rule);
        if (!$validator->fails()) {
            die('true');
        }
        die('false');
    }

    public function editvalidcontact(Request $request) {
        $id = $request->id;
        $rule = array(
            'contact_no' => Rule::unique('employees', 'contact_no')->ignore($id),
        );
        $validator = Validator::make($request->all(), $rule);
        if (!$validator->fails()) {
            die('true');
        }
        die('false');
    }

    public function expance_action_search(Request $request) {
        $breadcrumbs = [
            ['link' => "expense/", 'name' => "Home"],
            ['link' => "expense/", 'name' => "Expense Action"],
            ['name' => "View"],
        ];
//Pageheader set true for breadcrumbs
        $pageConfigs = ['pageHeader' => true, 'isFabButton' => true, 'isCustomizer' => true];

        $to_date = $request->to_date_search;
        $from_date = $request->from_date_search;
        return view('employee-master.expense.expance_action.index', [
            'pageConfigs' => $pageConfigs,
            'to_date' => $to_date,
            'from_date' => $from_date,
            'breadcrumbs' => $breadcrumbs,
        ]);
    }

    public function expance_action() {
        $breadcrumbs = [
            ['link' => "expense/", 'name' => "Home"],
            ['link' => "expense/", 'name' => "Expense Action"],
            ['name' => "View"],
        ];
//Pageheader set true for breadcrumbs
        $pageConfigs = ['pageHeader' => true, 'isFabButton' => true, 'isCustomizer' => true];

        return view('employee-master.expense.expance_action.index', [
            'pageConfigs' => $pageConfigs,
            'breadcrumbs' => $breadcrumbs,
        ]);
    }

    public function view_expances($id) {
        $breadcrumbs = [
            ['link' => "expense/", 'name' => "Home"],
            ['link' => "expense/", 'name' => "Expense Master"],
            ['name' => "View"],
        ];
        $pageConfigs = ['pageHeader' => true, 'isFabButton' => true, 'isCustomizer' => true];

        $edit_details = (new Controller)->getConditionDynamicTable('api_expenses', 'id', $id);
        $edit_details_file = (new Controller)->getConditionDynamicTableAll('api_expenses_documents', 'emp_id', $id);

        $category_master = (new Controller)->getAllDynamicTable('category');
        $subcategory_master = (new Controller)->getAllDynamicTable('sub_category');
        $departments_master = (new Controller)->getAllDynamicTable_OrderBy('departments', 'name');
        $payment_status_master = (new Controller)->getAllDynamicTable('payment_status');
        $payment_method_master = (new Controller)->getAllDynamicTable('payment_method');
        $vehicles_master = (new Controller)->getAllDynamicTable('vehicles');
        $employee_master = (new Controller)->getAllDynamicTable('employees');

        return view('employee-master.expense.view_expances', [
            'pageConfigs' => $pageConfigs,
            'breadcrumbs' => $breadcrumbs,
            'edit_details' => $edit_details,
            'category_master' => $category_master,
            'subcategory_master' => $subcategory_master,
            'departments_master' => $departments_master,
            'payment_status_master' => $payment_status_master,
            'payment_method_master' => $payment_method_master,
            'vehicles_master' => $vehicles_master,
            'edit_details_file' => $edit_details_file,
            'employee_master' => $employee_master,
            'combined_submission' => (new Controller)->getExpanceSettings('hherp'),
        ]);
    }

    public function view($id) {

        $breadcrumbs = [
            ['link' => "expense/", 'name' => "Home"],
            ['link' => "expense/", 'name' => "Expense Master"],
            ['name' => "View"],
        ];
        $pageConfigs = ['pageHeader' => true, 'isFabButton' => true, 'isCustomizer' => true];

        $edit_details = (new Controller)->getConditionDynamicTable('api_expenses', 'id', $id);
        $edit_details_file = (new Controller)->getConditionDynamicTableAll('api_expenses_documents', 'emp_id', $id);

        $category_master = (new Controller)->getAllDynamicTable('category');
        $subcategory_master = (new Controller)->getAllDynamicTable('sub_category');
        $departments_master = (new Controller)->getAllDynamicTable_OrderBy('departments', 'name');
        $payment_status_master = (new Controller)->getAllDynamicTable_OrderBy('payment_status', 'name');
        $payment_method_master = (new Controller)->getAllDynamicTable('payment_method');
        $vehicles_master = (new Controller)->getAllDynamicTable('vehicles');
        $employee_master = (new Controller)->getAllDynamicTable('employees');

        return view('employee-master.expense.view', [
            'pageConfigs' => $pageConfigs,
            'breadcrumbs' => $breadcrumbs,
            'edit_details' => $edit_details,
            'category_master' => $category_master,
            'subcategory_master' => $subcategory_master,
            'departments_master' => $departments_master,
            'payment_status_master' => $payment_status_master,
            'payment_method_master' => $payment_method_master,
            'vehicles_master' => $vehicles_master,
            'edit_details_file' => $edit_details_file,
            'employee_master' => $employee_master,
            'combined_submission' => (new Controller)->getExpanceSettings('hherp'),
        ]);
    }

    public function search_details(Request $request, $emp_id) {
        $breadcrumbs = [
            ['link' => "/", 'name' => "Home"],
            ['link' => "/expense/", 'name' => "Expense Master"],
            ['link' => "/expense/create", 'name' => "Create"],
        ];
        $rightlink = [
            ['rightlink' => "/expense/create", 'name' => "Create"],
        ];

        $pageConfigs = ['pageHeader' => true, 'isFabButton' => true, 'isCustomizer' => true];

        $to_date = $request->to_date_search;
        $from_date = $request->from_date_search;
        $payment_method_id = $request->payment_method_id_search;
        $payment_status_id = $request->payment_status_id_search;

        $query = DB::table('api_expenses')
                ->where('is_user', '=', $emp_id)
                ->orderBy('api_expenses.id', 'DESC');

        if ($payment_method_id) {
            $query->where('api_expenses.payment_method_id', '=', $payment_method_id);
        }
        if ($payment_status_id) {
            $query->where('api_expenses.payment_status_id', '=', $payment_status_id);
        }
        if ($to_date && $from_date) {
            $query->whereBetween('api_expenses.date_search', [$to_date, $from_date]);
        }

        $query->select('*');

//        \DB::enableQueryLog(); // Enable query log
        $expenses_details = $query->get();
//        dd(\DB::getQueryLog());
//        dd($request->all(), $expenses_details, $emp_id);
        $expenses_details_normal = DB::table('api_expenses')
                ->select('*')
                ->where('is_user', '=', $emp_id)
                ->where('is_save', '=', 1)
                ->where('is_process', '!=', 5)
                ->orderBy('api_expenses.id', 'DESC')
                ->get();

        $expenses_details_draft = DB::table('api_expenses')
                ->select('*')
                ->where('is_user', '=', $emp_id)
                ->where('is_save', '=', 2)
                ->orderBy('api_expenses.id', 'DESC')
                ->get();
        $expenses_details_complited = DB::table('api_expenses')
                ->select('*')
                ->where('is_user', '=', $emp_id)
                ->whereIn('is_process', [3, 5, 12])
//->orderBy('api_expenses.id', 'DESC')
                ->get();

        return view('employee-master.expense.index', [
            'pageConfigs' => $pageConfigs,
            'rightlink' => $rightlink,
            'breadcrumbs' => $breadcrumbs,
            'payment_status_master' => (new Controller)->getAllDynamicTable('payment_status'),
            'payment_method_master' => (new Controller)->getAllDynamicTable('payment_method'),
            'to_date' => $to_date,
            'from_date' => $from_date,
            'payment_method_id' => $payment_method_id,
            'payment_status_id' => $payment_status_id,
            'expenses_details' => $expenses_details,
            'expenses_details_normal' => $expenses_details_normal,
            'expenses_details_draft' => $expenses_details_draft,
            'expenses_details_complited' => $expenses_details_complited,
            'emp_id' => $emp_id
        ]);
    }

    public function search(Request $request) {
        -

                $emp_id = null;
        $breadcrumbs = [
            ['link' => "/", 'name' => "Home"],
            ['link' => "/expense/", 'name' => "Expense Master"],
            ['link' => "/expense/create", 'name' => "Create"],
        ];
        $rightlink = [
            ['rightlink' => "/expense/create", 'name' => "Create"],
        ];
        $deletelink = [
            ['name' => "Delete"],
        ];
        $downloadlink = [
            ['name' => "Delete"],
        ];

        $pageConfigs = ['pageHeader' => true, 'isFabButton' => true, 'isCustomizer' => true];

//        $expenses_details=(new Controller)->getAllDynamicTable('api_expenses');

        $payment_status_master = (new Controller)->getAllDynamicTable('payment_status');
        $payment_method_master = (new Controller)->getAllDynamicTable('payment_method');

        $to_date = $request->to_date_search;
        $from_date = $request->from_date_search;
        $payment_method_id = $request->payment_method_id_search;
        $payment_status_id = $request->payment_status_id_search;
        $is_save_search = $request->is_save_search;

        /**/
        $emp_id = $request->is_user;
        $query = DB::table('api_expenses')
                ->where('is_user', '=', $emp_id)
                ->orderBy('api_expenses.id', 'DESC');

        $expenses_details_normal = DB::table('api_expenses');
        $expenses_details_draft = DB::table('api_expenses');

        if ($to_date && $from_date) {
            $query->orwhereBetween('api_expenses.date_search', ['"$to_date"', '"$from_date"']);
        }
        if ($payment_method_id) {
            $query->where('api_expenses.payment_method_id', '=', $payment_method_id);
        }
        if ($payment_status_id) {
            $query->where('api_expenses.payment_status_id', '=', $payment_status_id);
        }
        if ($is_save_search) {
            $query->where('api_expenses.is_save', '=', $is_save_search);
        }
        $query->select('*');

//        \DB::enableQueryLog(); // Enable query log
        $expenses_details = $query->get();
//        dd(\DB::getQueryLog());

        return view('employee-master.expense.index', [
            'pageConfigs' => $pageConfigs,
            'rightlink' => $rightlink,
            'deletelink' => $deletelink,
            'downloadlink' => $downloadlink,
            'breadcrumbs' => $breadcrumbs,
            'payment_status_master' => $payment_status_master,
            'payment_method_master' => $payment_method_master,
            'to_date' => $to_date,
            'from_date' => $from_date,
            'payment_method_id' => $payment_method_id,
            'payment_status_id' => $payment_status_id,
            'expenses_details' => $expenses_details,
            'expenses_details_normal' => $expenses_details_normal,
            'expenses_details_draft' => $expenses_details_draft,
            'is_save_search' => $is_save_search,
            'emp_id' => $emp_id
        ]);
    }

    public function index($emp_id = null) {


        $breadcrumbs = [
            ['link' => "/", 'name' => "Home"],
            ['link' => "/expense/", 'name' => "Expense Master"],
        ];

        $rightlink = [
            ['rightlink' => "/expense/create", 'name' => "Create"],
        ];
        $deletelink = [
            ['name' => "Delete"],
        ];

        $pageConfigs = ['pageHeader' => true, 'isFabButton' => true, 'isCustomizer' => true];
        $expenses_details_normal = $expenses_details_complited = $expenses_details_draft = 0;

//        echo Auth::id() . '::';
        if (Auth::id() == 122) {

            if (empty($emp_id)) {
//                echo '<br>' . 'empty emp';
                $expenses_details = DB::table('api_expenses')
                        ->select('*')
                        ->groupBy('api_expenses.is_user')
                        ->orderBy('api_expenses.id', 'DESC')
                        ->get();
            } else {
//                echo '<br>' . 'else empty emp';
                $expenses_details = DB::table('api_expenses')
                        ->select('*')
                        ->where('is_user', '=', $emp_id)
                        ->orderBy('api_expenses.id', 'DESC')
                        ->get();
                $expenses_details_normal = DB::table('api_expenses')
                        ->select('*')
                        ->where('is_user', '=', $emp_id)
                        ->where('is_save', '=', 1)
                        ->whereNotIn('is_process', [3, 5])
                        ->orderBy('api_expenses.id', 'DESC')
                        ->get();
                $expenses_details_draft = DB::table('api_expenses')
                        ->select('*')
                        ->where('is_user', '=', $emp_id)
                        ->where('is_save', '=', 2)
                        ->orderBy('api_expenses.id', 'DESC')
                        ->get();
                $expenses_details_complited = DB::table('api_expenses')
                        ->select('*')
                        ->where('is_user', '=', $emp_id)
                        ->whereIn('is_process', [3, 5, 12])
//->orderBy('api_expenses.id', 'DESC')
                        ->get();
            }
//            echo '<br>in if';
        } else {
//            echo '<br>in else';
            $expenses_details = DB::table('api_expenses')
                    ->select('*')
                    ->where('is_user', '=', Auth::id())
//->whereNotIn('is_save', [3])
                    ->orderBy('api_expenses.id', 'DESC')
                    ->get();
            $expenses_details_normal = DB::table('api_expenses')
                    ->select('*')
                    ->where('is_user', '=', Auth::id())
                    ->where('is_save', '=', 1)
                    ->whereNotIn('is_process', [3, 5])
                    ->orderBy('api_expenses.id', 'DESC')
                    ->get();
            $expenses_details_draft = DB::table('api_expenses')
                    ->select('*')
                    ->where('is_user', '=', Auth::id())
                    ->where('is_save', '=', 2)
                    ->orderBy('api_expenses.id', 'DESC')
                    ->get();
            $expenses_details_complited = DB::table('api_expenses')
                    ->select('*')
                    ->where('is_user', '=', Auth::id())
                    ->whereIn('is_process', [3, 5, 12])
//->orderBy('api_expenses.id', 'DESC')
                    ->get();
        }
        $payment_status_master = (new Controller)->getAllDynamicTable('payment_status');
        $payment_method_master = (new Controller)->getAllDynamicTable('payment_method');
        return view('employee-master.expense.index', [
            'pageConfigs' => $pageConfigs,
            'rightlink' => $rightlink,
//            'deletelink' => $deletelink,
            'breadcrumbs' => $breadcrumbs,
            'payment_status_master' => $payment_status_master,
            'payment_method_master' => $payment_method_master,
            'expenses_details' => $expenses_details,
            'expenses_details_normal' => $expenses_details_normal,
            'expenses_details_draft' => $expenses_details_draft,
            'expenses_details_complited' => $expenses_details_complited,
            'combined_submission' => (new Controller)->getExpanceSettings('hherp'),
            'emp_id' => $emp_id
        ]);
    }

    public function create() {

        $breadcrumbs = [
            ['link' => "expense/", 'name' => "Home"],
            ['link' => "expense/", 'name' => "Expense Master"],
            ['name' => "Create"],
        ];
        $pageConfigs = ['pageHeader' => true, 'isFabButton' => true, 'isCustomizer' => true];

//         $result=(new OtherController)->exampleFunction();
//        getDynamicTable($table_name, $where_condition, $where_value, $get_value)
//        $result=(new OtherController)->getDynamicTable('recruiter', $where_condition, $where_value, $get_value);
//        $result=(new OtherController)->getDynamicTable('recruiter', $where_condition, $where_value, $get_value);
//        $recruiters_master=(new Controller)->getAllDynamicTable('recruiter');
//        $shifts_master=(new Controller)->getAllDynamicTable('shifts');
//        $teams_master=(new Controller)->getAllDynamicTable('teams');
//        $designations_master=(new Controller)->getAllDynamicTable('designations');
//        $employee_types_master=(new Controller)->getAllDynamicTable('employee_types');
//        $PtypeDetails=(new Controller)->getAllDynamicTable('password-type');
//        $equipmentDetails=(new Controller)->getAllDynamicTable('equipment');
//        $issuanceDetails=(new Controller)->getAllDynamicTable('issuance');
//        $employeesDetails=(new Controller)->getAllDynamicTable('employees');
//        $salaryTypeDetails=(new Controller)->getAllDynamicTable('salary_type');

        $category_master = (new Controller)->getAllDynamicTable('category');
        $departments_master = (new Controller)->getAllDynamicTable_OrderBy('departments', 'name');
        $payment_status_master = (new Controller)->getAllDynamicTable('payment_status');
        $payment_method_master = (new Controller)->getAllDynamicTable('payment_method');
        $vehicles_master = (new Controller)->getAllDynamicTable('vehicles');
        $subcategory_master = (new Controller)->getAllDynamicTable('sub_category');
        $employee_master = (new Controller)->getAllDynamicTable('employees');
        return view('employee-master.expense.create', [
            'pageConfigs' => $pageConfigs,
            'breadcrumbs' => $breadcrumbs,
            'category_master' => $category_master,
            'departments_master' => $departments_master,
            'payment_status_master' => $payment_status_master,
            'payment_method_master' => $payment_method_master,
            'vehicles_master' => $vehicles_master,
            'subcategory_master' => $subcategory_master,
            'employee_master' => $employee_master,
            'combined_submission' => (new Controller)->getExpanceSettings('hherp'),
//             'salaryTypeDetails' => $salaryTypeDetails,
//            'designations_master' => $designations_master, 'PtypeDetails' => $PtypeDetails, 'issuanceDetails' => $issuanceDetails,
//            'employee_types_master' => $employee_types_master, 'equipmentDetails' => $equipmentDetails, 'employeesDetails' => $employeesDetails,
//            'recruiters_master' => $recruiters_master, 'shifts_master' => $shifts_master,
//            'password_details' => 0, 'bank_details' => 0, 'document_details' => 0, 'vehicleDetails' => 0
        ]);
    }

    public function getvehicalRat(Request $request) {

        if ($request->ajax()) {
            $id = $request->input('id');
            $common_states = DB::table("vehicles")
                    ->where("id", '=', $id)
                    ->select("vehicles.rate_per_km")
                    ->get();
            return response()->json($common_states);
        }
    }

    public function getSubCategory(Request $request) {

        if ($request->ajax()) {
            $id = $request->input('id');
            $common_states = DB::table("sub_category")
                    ->where("category_id", '=', $id)
                    ->select("*")
                    ->where('is_active', '=', '0')
                    ->get();
            return response()->json($common_states);
        }
    }

//
//    public function holidayupdate(Request $request, $id) {
//
//
//        DB::table('apiemp_holidays_master')->where('emp_id', $id)->delete();
//        $holiday_name=$request->holiday_name;
//
//        if (($holiday_name != null) && count($holiday_name) > 0) {
//            foreach ($holiday_name as $key => $value) {
//                DB::table("apiemp_holidays_master")->insertGetId([
//                    'emp_id' => $id,
//                    'holiday_type' => $request->holiday_type[$key],
//                    'holiday_name' => $request->holiday_name[$key],
//                    'holiday_date' => $request->holiday_date[$key],
//                    'holiday_note' => $request->holiday_note[$key],
//                ]);
//            }
//        }
//        // $send_notification=(new Controller)->send_notification('1', "Holidays Upload Successfully");
//        redirect()->back()->with('success', 'Custome Holiday Updated Successfully !');
//        return redirect(route('emp.edit', $id));
//    }
//
//    public function holidayshow($id) {
//        $breadcrumbs=[
//            ['link' => "expense/", 'name' => "Home"],
//            ['link' => "expense/", 'name' => "Expense Master"],
//            ['link' => "expense/", 'name' => "Holiday Master"],
//            ['name' => "Holiday's list"],
//        ];
//        $pageConfigs=['pageHeader' => true, 'isFabButton' => true, 'isCustomizer' => true];
//        $holidaysDetails=(new Controller)->getConditionDynamicTableAll('apiemp_holidays_master', 'emp_id', $id);
//        $name=(new Controller)->getConditionDynamicNameTable('employees', 'id', $id, 'name');
//
//        return view('employee-master.expense.holidaybulkupload.emp_list_holiday', [
//            'pageConfigs' => $pageConfigs,
//            'breadcrumbs' => $breadcrumbs,
//            'name' => $name,
//            'emp_id' => $id,
//            'holidaysDetails' => $holidaysDetails
//        ]);
//    }

    public function expense_master($id) {
        $breadcrumbs = [
            ['link' => "expense/", 'name' => "Home"],
            ['link' => "expense/", 'name' => "Expense Master"],
            ['name' => "Edit"],
        ];
        $pageConfigs = ['pageHeader' => true, 'isFabButton' => true, 'isCustomizer' => true];

        $edit_details = (new Controller)->getConditionDynamicTable('api_expenses', 'id', $id);
        $edit_details_file = (new Controller)->getConditionDynamicTableAll('api_expenses_documents', 'emp_id', $id);

        $category_master = (new Controller)->getAllDynamicTable('category');
        $subcategory_master = (new Controller)->getAllDynamicTable('sub_category');
        $departments_master = (new Controller)->getAllDynamicTable_OrderBy('departments', 'name');
        $payment_status_master = (new Controller)->getAllDynamicTable('payment_status');
        $payment_method_master = (new Controller)->getAllDynamicTable('payment_method');
        $vehicles_master = (new Controller)->getAllDynamicTable('vehicles');

        return view('employee-master.expense.expense_master', [
            'pageConfigs' => $pageConfigs,
            'breadcrumbs' => $breadcrumbs,
            'edit_details' => $edit_details,
            'category_master' => $category_master,
            'subcategory_master' => $subcategory_master,
            'departments_master' => $departments_master,
            'payment_status_master' => $payment_status_master,
            'payment_method_master' => $payment_method_master,
            'vehicles_master' => $vehicles_master,
            'edit_details_file' => $edit_details_file,
        ]);
    }

    public function edit($id) {
        $breadcrumbs = [
            ['link' => "expense/", 'name' => "Home"],
            ['link' => "expense/", 'name' => "Expense Master"],
            ['name' => "Edit"],
        ];
        $pageConfigs = ['pageHeader' => true, 'isFabButton' => true, 'isCustomizer' => true];

        $edit_details = (new Controller)->getConditionDynamicTable('api_expenses', 'id', $id);
        $edit_details_file = (new Controller)->getConditionDynamicTableAll('api_expenses_documents', 'emp_id', $id);

        $category_master = (new Controller)->getAllDynamicTable('category');
        $subcategory_master = (new Controller)->getAllDynamicTable('sub_category');
        $departments_master = (new Controller)->getAllDynamicTable_OrderBy('departments', 'name');
        $payment_status_master = (new Controller)->getAllDynamicTable('payment_status');
        $payment_method_master = (new Controller)->getAllDynamicTable('payment_method');
        $vehicles_master = (new Controller)->getAllDynamicTable('vehicles');
        $employee_master = (new Controller)->getAllDynamicTable('employees');

        return view('employee-master.expense.edit', [
            'pageConfigs' => $pageConfigs,
            'breadcrumbs' => $breadcrumbs,
            'edit_details' => $edit_details,
            'category_master' => $category_master,
            'subcategory_master' => $subcategory_master,
            'departments_master' => $departments_master,
            'payment_status_master' => $payment_status_master,
            'payment_method_master' => $payment_method_master,
            'vehicles_master' => $vehicles_master,
            'edit_details_file' => $edit_details_file,
            'employee_master' => $employee_master,
            'combined_submission' => (new Controller)->getExpanceSettings('hherp'),
        ]);
    }

    public function multi_updateByManager(Request $request, $id) {

//dd($request->all(), $id);

        $expances_ids = $request->expances_ids;
        $settlement_amount = $reject_amount = $manger_settl_amount = 0;
        foreach ($expances_ids as $key => $expances_id) {
            $api_expenses = DB::table('api_expenses')->where('id', '=', $expances_id)->first();

            if ($request->is_status_manager[$key] == 0) {
                return redirect(route('expance_action'))->with('success', 'Please Select Process Status');
            }


            if ($request->is_status_manager[$key] == '11') { //Partially
                $settlement_amount = $request->settlement_amount[$key];
                $reject_amount = ($api_expenses->claim_amount - $request->settlement_amount[$key]);
// $reject_amount=0;
                $manger_settl_amount = $request->settlement_amount[$key];
                $payment_status_id = '2';
//echo 'in 11';
            } else if ($request->is_status_manager[$key] == '2') { // reject case
                $settlement_amount = 0;
                $reject_amount = $api_expenses->claim_amount;
                $manger_settl_amount = 0;
                $payment_status_id = '3'; // reject

                /* 23-02-2024 reject update */
                DB::table('api_expenses')
                        ->where('id', '=', $expances_id)
                        ->update(['is_save' => 3, 'is_resubmit' => 1]);
                /* 23-02-2024 reject update */


//                $reject_amount=$request->settlement_amount[$key];
            } else if ($request->is_status_manager[$key] == '1') { // accapted  case
                if ($request->settlement_amount[$key] == 0) {
                    $settlement_amount = $api_expenses->claim_amount; // for all amount is setalled
                    $reject_amount = 0;
                } else {
                    $settlement_amount = $request->settlement_amount[$key]; // for all amount is setalled
                    $reject_amount = ($api_expenses->claim_amount - $request->settlement_amount[$key]);
                }
                $payment_status_id = '2';
                $manger_settl_amount = $settlement_amount;
//                $settlement_amount=$request->settlement_amount[$key];
//$settlement_amount=$api_expenses->claim_amount; // for all amount is setalled
//$reject_amount=($api_expenses->claim_amount - $request->settlement_amount[$key]);
//$manger_settl_amount=$request->settlement_amount[$key];
            }

//dd($request->all(), $settlement_amount, $manger_settl_amount, $reject_amount);
            DB::table('api_expenses')->where('id', '=', $expances_id)->update([
                'is_process' => $request->is_status_manager[$key],
                'action_by_user_id' => Auth::id(),
                'payment_status_id' => $payment_status_id,
                'settlement_amount' => $settlement_amount,
                'manger_settl_amount' => $manger_settl_amount,
                'reject_amount' => $reject_amount,
            ]);
//********api_expenses_action_log*********//
            $api_expenses_action_log = DB::table('api_expenses_action_log')
                    ->where('emp_id', '=', $expances_id)
                    ->where('action_by', '=', 'Manager')
                    ->first();
            if (isset($api_expenses_action_log)) {
                DB::table('api_expenses_action_log')->where('emp_id', '=', $expances_id)->update([
                    'action_date' => Carbon::today()->format('Y-m-d'),
                    'action_by_user_id' => Auth::id(),
                    'is_process' => $request->is_status_manager[$key],
                    'clam_amount' => $request->clam_amount[$key],
                    'payment_status_id' => $payment_status_id,
                    'settlement_amount' => $settlement_amount,
                    'manager_settlement_amount' => $manger_settl_amount,
                    'reject_amount' => $reject_amount,
                    'master_note' => $request->comment[$key],
                    'note_by_manager' => $request->comment[$key],
                ]);
            } else {
                DB::table('api_expenses_action_log')->insertGetId([
                    'emp_id' => $expances_id,
                    'action_by' => 'Manager',
                    'action_date' => Carbon::today()->format('Y-m-d'),
                    'action_by_user_id' => Auth::id(),
                    'is_process' => $request->is_status_manager[$key],
                    'clam_amount' => $request->clam_amount[$key],
                    'payment_status_id' => $payment_status_id,
                    'settlement_amount' => $settlement_amount,
                    'manager_settlement_amount' => $manger_settl_amount,
                    'reject_amount' => $reject_amount,
                    'master_note' => $request->comment[$key],
                    'note_by_manager' => $request->comment[$key],
                ]);
            }
        }
        return redirect(route('expance_action'))->with('success', 'Manager Action Updated Successfully');
    }

    public function updateByManager(Request $request, $id) {

        if (($request->is_status_manager == 0)) {
            return redirect(route('expance_action'))->with('success', 'Please Select action');
        } else {
            $api_expenses_action_log = DB::table('api_expenses')->where('id', '=', $id)->first();
            $settlement_amount = 0;
            if ($request->is_status_manager == 11) {
                $settlement_amount = $request->settlement_amount;
            } else {
                $settlement_amount = ($api_expenses_action_log->settlement_amount + $request->settlement_amount);
            }

            if ($request->is_status_manager == '2') { // reject case
                $reject_amount = $request->settlement_amount;
                $settlement_amount = 0;
            } else {
                $reject_amount = 0;
                $settlement_amount = $request->settlement_amount;
            }

            DB::table('api_expenses')->where('id', '=', $id)->update([
                'is_process' => $request->is_status_manager,
                'action_by_user_id' => Auth::id(),
                'payment_status_id' => 2,
                'settlement_amount' => $settlement_amount,
                'reject_amount' => $reject_amount,
                'manger_settl_amount' => $settlement_amount
            ]);
            if ($request->is_status_manager == 11) {
                DB::table('api_expenses_action_log')
                        ->where('emp_id', $id)
                        ->where('action_by_user_id', '=', Auth::id())
                        ->where('action_by', '=', 'Manager')
                        ->delete();
            }

            DB::table('api_expenses_action_log')->insertGetId([
                'emp_id' => $id,
                'action_by' => 'Manager',
                'action_date' => Carbon::today()->format('Y-m-d'),
                'action_by_user_id' => Auth::id(),
                'is_process' => $request->is_status_manager,
                'master_note' => $request->note_by_manager,
                'clam_amount' => $request->clam_amount,
                'payment_status_id' => 2,
                'settlement_amount' => $settlement_amount,
                'manager_settlement_amount' => $settlement_amount,
                'reject_amount' => $reject_amount,
            ]);

//==============================================================================================================
            $to_email = DB::table('employees')->where('user_id', '=', $api_expenses_action_log->is_user)->first();

            $case = null;
            if ($request->is_status_manager == '1') {
                $case = "Accepted by Manager amount of " . $api_expenses_action_log->currency . ' ' . $settlement_amount;
            } else if ($request->is_status_manager == '11') {
                $case = "Partially Approve by Manager amount of " . $api_expenses_action_log->currency . ' ' . $settlement_amount;
            } else if ($request->is_status_manager == '2') {
                $case = "Reject by Manager amount of " . $api_expenses_action_log->currency . ' ' . $settlement_amount;
            }
            $body = "Your Submitted Expense on date : " . $api_expenses_action_log->date_search . " Spent at : " . $api_expenses_action_log->spent_at . " Has been " . $case;
            $details = array(
                'employee_name' => $to_email->name,
                'admin_email' => $to_email->email,
                'from_email' => $to_email->email,
                'title' => 'Manager Expance Notification : ' . $to_email->name,
                'subject' => 'Manager Expance Notification : ' . $to_email->name,
                'body' => $body
            );
            Mail::send('emails.expance_body', ['details' => $details], function ($message) use ($details) {
                $message->to($details['admin_email'], 'Admin : Hiteshkumar')
                        ->cc($details['admin_email'])
                        ->subject($details['subject']);
                $message->from($details['from_email'], $details['title']);
            });
// $send_notification=(new Controller)->send_notification($api_expenses_action_log->is_user, $body);
//==============================================================================================================
            return redirect(route('expance_action'))->with('success', 'Manager Action Updated Successfully');
        }
    }

    public function multi_updateByAcount(Request $request, $id) {

        $expances_ids = $request->expances_ids;
        $settlement_amount = $reject_amount = 0;
        foreach ($expances_ids as $key => $expances_id) {
            $api_expenses = DB::table('api_expenses')->where('id', '=', $id)->first();

            if ($request->is_status_account[$key] == '12') { //  Partially Approved by the Manager
                $settlement_amount = $request->settlement_amount[$key];
                $reject_amount = ($request->clam_amount[$key] - $request->settlement_amount[$key]);
                $is_status_account = $request->is_status_account[$key];

//dd($request->all(), $settlement_amount, $reject_amount);

                if ($api_expenses->total_amount_cash == $settlement_amount) {
                    $payment_status_account = 4; // Completed
                    $is_status_account = 3;
                    DB::table('api_expenses')
                            ->where('id', '=', $expances_id)
                            ->update([
                                'is_save' => 1,
                                    //'is_resubmit' => 1,
                    ]);
//echo 'in total';
                } else {
//echo 'in total exit';
                    $payment_status_account = 4; // Completed
                    $is_status_account = $request->is_status_account[$key];
                    DB::table('api_expenses')
                            ->where('id', '=', $expances_id)
                            ->update([
                                'is_save' => 3,
                                'is_process' => 0,
                                //'is_resubmit' => 1,
                                'action_by_user_id' => Auth::id(),
                                'claim_amount' => $reject_amount,
                                //'settlement_amount' => $reject_amount,
                                'reject_amount' => ($api_expenses->total_amount_cash - $reject_amount),
                                //'acount_settl_amount' => $settlement_amount,
                                'payment_status_id' => $payment_status_account, // update payment status
                    ]);
                }

                DB::table('api_expenses_resubmit')->insertGetId([
                    'is_user' => $api_expenses->is_user,
                    'expance_id' => $expances_id,
                    'is_process' => $request->is_status_account[$key],
                    'claim_amount' => $request->clam_amount[$key],
                    'settlement_amount' => $settlement_amount,
                    'account_settlement_amount' => $settlement_amount,
                    'reject_amount' => $reject_amount,
                    'note' => $request->note_by_account[$key],
                ]);
            } else if ($request->is_status_account[$key] == '4') { // reject case
                $reject_amount = $request->clam_amount[$key];
                $settlement_amount = 0;
//                $reject_amount = $api_expenses->claim_amount[$key];
                $is_status_account = 4;
                /* 23-02-2024 reject update */
                DB::table('api_expenses')
                        ->where('id', '=', $expances_id)
                        ->update(['is_save' => 3, //'is_resubmit' => 1
                ]);
                /* 23-02-2024 reject update */
                $payment_status_account = 3; //Rejected
            } else if ($request->is_status_account[$key] == '3') {  // Accepted case
                if ($api_expenses->is_resubmit == 1) {
                    DB::table('api_expenses_resubmit')->insertGetId([
                        'is_user' => $api_expenses->is_user,
                        'expance_id' => $expances_id,
                        'is_process' => $request->is_status_account[$key],
                        'claim_amount' => $request->clam_amount[$key],
                        'settlement_amount' => $request->settlement_amount[$key],
                        'account_settlement_amount' => $request->settlement_amount[$key],
//                        'reject_amount' => ($request->clam_amount[$key] - $request->settlement_amount[$key]),
                        'reject_amount' => ($request->clam_amount[$key] - $request->settlement_amount[$key]),
                        'note' => $request->note_by_account[$key],
                    ]);

                    $resubmit_settlement_amount = DB::table('api_expenses_resubmit')
                            ->where('expance_id', '=', $expances_id)
                            ->where('is_user', '=', $api_expenses->is_user)
                            ->sum('settlement_amount');

                    $resubmit_claim_amount = DB::table('api_expenses_resubmit')
                            ->where('expance_id', '=', $expances_id)
                            ->where('is_user', '=', $api_expenses->is_user)
                            ->sum('claim_amount');

//                        echo $resubmit_settlement_amount;
//                        echo '<br>' . $resubmit_claim_amount;
                    $claim_amount = $request->total_amount_cash[$key];

                    $settlement_amount = ($resubmit_settlement_amount );
                    $reject_amount = ($request->clam_amount[$key] - $request->settlement_amount[$key]);

                    $is_status_account = $request->is_status_account[$key];
                    $payment_status_account = 4; // Completed
//                    dd($resubmit_settlement_amount, $request->all(), $expances_id, $api_expenses->is_user, $api_expenses->total_amount_cash, $claim_amount, $settlement_amount, $reject_amount, $is_status_account, $payment_status_account);

                    DB::table('api_expenses')
                            ->where('id', '=', $expances_id)
                            ->update([
                                'claim_amount' => $api_expenses->total_amount_cash,
                    ]);
                } else {
                    $settlement_amount = $request->settlement_amount[$key];
                    $reject_amount = ($request->clam_amount[$key] - $request->settlement_amount[$key]);
                    $payment_status_account = 4; // Completed
                    $is_status_account = $request->is_status_account[$key];
                }
            } else {
                return redirect(route('expance_action'))->with('success', 'Please Select action');
            }





            DB::table('api_expenses')
                    ->where('id', '=', $expances_id)
                    ->update([
                        'is_process' => $is_status_account,
                        'action_by_user_id' => Auth::id(),
                        'settlement_amount' => $settlement_amount,
                        'reject_amount' => $reject_amount,
                        'acount_settl_amount' => $settlement_amount,
                        'account_action_date' => Carbon::today()->format('Y-m-d'),
                        'payment_status_id' => $payment_status_account, // update payment status
            ]);
//            echo 'in data';
//            dd($expances_id, $request->all());
            $api_expenses_action_log = DB::table('api_expenses_action_log')
                    ->where('emp_id', '=', $expances_id)
                    ->where('action_by', '=', 'Account')
                    ->first();
            if (isset($api_expenses_action_log)) {
                DB::table('api_expenses_action_log')
                        ->where('emp_id', '=', $expances_id)
                        ->where('action_by', '=', 'Account')
                        ->update([
                            'action_date' => Carbon::today()->format('Y-m-d'),
                            'action_by_user_id' => Auth::id(),
                            'is_process' => $request->is_status_account[$key],
                            'payment_status_id' => $payment_status_account, // update payment status
                            'master_note' => $request->note_by_account[$key],
                            'note_by_admin' => $request->note_by_account[$key],
                            'clam_amount' => $request->clam_amount[$key],
                            'settlement_amount' => $settlement_amount,
                            'account_settlement_amount' => $settlement_amount,
                            'reject_amount' => $reject_amount,
                ]);
            } else {
                DB::table('api_expenses_action_log')->insertGetId([
                    'emp_id' => $id,
                    'action_by' => 'Account',
                    'action_date' => Carbon::today()->format('Y-m-d'),
                    'action_by_user_id' => Auth::id(),
                    'is_process' => $request->is_status_account[$key],
                    'payment_status_id' => $payment_status_account, // update payment status
                    'master_note' => $request->note_by_account[$key],
                    'note_by_admin' => $request->note_by_account[$key],
                    'clam_amount' => $request->clam_amount[$key],
                    'settlement_amount' => $settlement_amount,
                    'account_settlement_amount' => $settlement_amount,
                    'reject_amount' => $reject_amount,
                ]);
            }
        }

//dd($request->all());
        return redirect(route('expance_action'))->with('success', 'Accountent multi Expenses Updated Successfully');

//        dd($request->all(), $id);
    }

    public function updateByAccount(Request $request, $id) {

        if (($request->is_status_account == 0) || ($request->is_status_account == 2) || ($request->is_status_account == 1)) {
            return redirect(route('expance_action'))->with('success', 'Please Select action');
        } else {

            $settlement_amount = $reject_amount = 0;
            $api_expenses = DB::table('api_expenses')->where('id', '=', $id)->first();

            if ($request->is_status_account == '4') { // reject case
                $reject_amount = $request->settlement_amount;
                $settlement_amount = 0;
            } else {
                $reject_amount = 0;
                $settlement_amount = $request->settlement_amount;
            }

            DB::table('api_expenses')->where('id', '=', $id)->update([
                'is_process' => $request->is_status_account,
                'action_by_user_id' => Auth::id(),
//                'settlement_amount' => $api_expenses->settlement_amount + $request->settlement_amount,
                'settlement_amount' => $settlement_amount,
                'reject_amount' => $reject_amount,
                'payment_status_id' => $request->payment_status_account, // update payment status
            ]);
            DB::table('api_expenses_action_log')->insertGetId([
                'emp_id' => $id,
                'action_by' => 'Account',
                'action_date' => Carbon::today()->format('Y-m-d'),
                'action_by_user_id' => Auth::id(),
                'is_process' => $request->is_status_account,
                'payment_status_id' => $request->payment_status_account, // update payment status
                'master_note' => $request->note_by_account,
                'clam_amount' => $request->clam_amount,
                'settlement_amount' => $settlement_amount,
                'account_settlement_amount' => $settlement_amount,
                'reject_amount' => $reject_amount,
            ]);

//==================================================================================================
            $to_email = DB::table('employees')->where('user_id', '=', $api_expenses->is_user)->first();
            $case = null;
            if ($request->is_status_account == '3') {
                $case = "Accepted by Accountent amount of " . $api_expenses->currency . ' ' . $settlement_amount;
            } else if ($request->is_status_account == '4') {
                $case = "Reject by Accountent amount of " . $api_expenses->currency . ' ' . $settlement_amount;
            }
            $body = "Your Submitted Expense on date : " . $api_expenses->date_search . " Spent at : " . $api_expenses->spent_at . " Has been " . $case;
            $details = array(
                'employee_name' => $to_email->name,
                'admin_email' => $to_email->email,
                'from_email' => $to_email->email,
                'title' => 'Accountent Expance Notification : ' . $to_email->name,
                'subject' => 'Accountent Expance Notification : ' . $to_email->name,
                'body' => $body
            );
            Mail::send('emails.expance_body', ['details' => $details], function ($message) use ($details) {
                $message->to($details['admin_email'], 'Admin : Hiteshkumar')
                        ->cc($details['admin_email'])
                        ->subject($details['subject']);
                $message->from($details['from_email'], $details['title']);
            });
// $send_notification=(new Controller)->send_notification($api_expenses->is_user, $body);
//==============================================================================================================

            return redirect(route('expance_action'))->with('success', 'Accountent Expenses Updated Successfully');
        }
    }

    public function expense_settings_view() {
        $breadcrumbs = [
            ['link' => "expense/", 'name' => "Home"],
            ['link' => "expense/", 'name' => "Expense Settings"],
        ];
        $pageConfigs = ['pageHeader' => true, 'isFabButton' => true, 'isCustomizer' => true];
        return view('employee-master.expense.expense_settings', [
            'pageConfigs' => $pageConfigs,
            'breadcrumbs' => $breadcrumbs,
            'expense_settings' => (new Controller)->getExpanceSettings('hherp'),
        ]);
    }

    public function expense_settings_update(Request $request, $id) {
        DB::table('api_expenses_settings')->where('business_name', '=', $id)->update([
            'combined_submission' => $request->combined_submission,
        ]);
        return redirect(route('expense'))->with('success', 'Expense has been updated!');
    }

    public function update(Request $request, $id) {

        $check_resubmit_partial = DB::table('api_expenses')->where('id', '=', $id)->first();
        if ($request->is_save == '3') {
            DB::table('api_expenses')->where('id', '=', $id)->update([
                'is_process' => '0',
                'is_save' => '1',
                'is_resubmit' => '1',
                'reject_amount' => '0',
                'settlement_amount' => '0',
                'acount_settl_amount' => '0',
                'manger_settl_amount' => '0',
            ]);
        }

        if ($request->expense_type == '0') {
            DB::table('api_expenses')->where('id', '=', $id)->update([
                'expense_type' => $request->expense_type,
                'is_process' => $request->is_status_admin,
                'total_amount_cash' => ($request->is_save == 3) ? $check_resubmit_partial->total_amount_cash : $request->total_amount_cash,
                'claim_amount' => $request->total_amount_cash,
                'spent_at' => $request->spent_at_cash,
                'date_of_expense_cash' => $request->date_of_expense_cash,
                'city_id_cash' => $request->city_id_cash,
                'account_premises_no_cash' => $request->account_premises_no_cash,
                'card_used_cash' => $request->card_used_cash,
                'account_name_cash' => $request->account_name_cash,
                'department_id' => $request->ddl_department_cash,
                'category_id_cash' => $request->category_id_cash,
                'sub_category_id_cash' => $request->sub_category_id_cash,
                'payment_method_id' => $request->payment_method_id,
                'description_cash' => $request->description_cash,
                'property_address_cash' => $request->property_address_cash,
                'expance_multi_day' => $request->expance_multi_day,
                'multi_day_from_date' => $request->multi_day_from_date_cash,
                'multi_day_to_date' => $request->multi_day_to_date_cash,
                'is_active' => $request->is_active,
                'date_of_expense_time' => $request->date_of_expense_time,
                'date_search' => $request->date_of_expense_cash,
                'payment_status_id' => $request->payment_status_id,
                'is_save' => ($request->is_save == '3' ? '1' : $request->is_save),
//'settlement_amount' => $request->settlement_amount,
//                'is_user' => (Auth::id() == 122) ? $request->employee_id : ''
            ]);
        } else if ($request->expense_type == '1') {
            DB::table('api_expenses')->where('id', '=', $id)->update([
                'expense_type' => $request->expense_type,
                'is_process' => $request->is_status_admin,
                'vehicle_type_mile' => $request->vehicle_type_mile,
                'vehicle_rate_mile' => $request->vehicle_rate_mile,
                'distance_mile' => $request->distance_mile,
                'spent_at_mile' => $request->spent_at_mile,
                'date_of_expense_mile' => $request->date_of_expense_mile,
                'city_name_mile' => $request->city_name_mile,
                'total_amount_mile' => $request->total_amount_mile,
                'claim_amount' => $request->total_amount_mile,
                'category_id_mile' => $request->category_id_mile,
                'payment_method_id' => $request->payment_method_id,
                'subcategory_id_mile' => $request->subcategory_id_mile,
                'description_mile' => $request->description_mile,
                'is_active' => $request->is_active,
                'date_search' => $request->date_of_expense_mile,
                'date_of_expense_time' => $request->date_of_expense_time_mile,
                'payment_status_id' => $request->payment_status_id,
                'is_save' => $request->is_save,
//'settlement_amount' => $request->settlement_amount,
//                'is_user' => (Auth::id() == 122) ? $request->employee_id : ''
            ]);
        } else {
            if ($request->is_status_admin == '6') { // reject case
//                $payment_status_id=$request->payment_status_id;
                $payment_status_id = '6';
            } else if ($request->is_status_admin == '5') { // Accepted case
                $payment_status_id = '4';
            }
            DB::table('api_expenses')->where('id', '=', $id)->update([
                'is_active' => $request->is_active,
                'is_process' => $request->is_status_admin,
                'payment_method_id' => $request->payment_method_id,
                'payment_status_id' => $payment_status_id,
                'is_save' => $request->is_save,
            ]);
        }



        $clam_amount__ = ($request->expense_type == 0) ? $request->total_amount_cash : $request->total_amount_mile;

        if ($request->is_status_admin == 5 || $request->is_status_admin == 6) {
            $api_expenses_action_log = DB::table('api_expenses_action_log')
                    ->where('emp_id', '=', $id)
                    ->where('action_by', '=', 'Admin')
                    ->first();
            $api_api_expenses = DB::table('api_expenses')
                    ->where('id', '=', $id)
                    ->first();
            if ($request->is_status_admin == '6') { // reject case
// $reject_amount=$request->settlement_amount;
//$payment_status_id=$request->payment_status_id;
                $reject_amount = ($clam_amount__ - $request->settlement_amount);
                $settlement_amount = $request->settlement_amount;
                $payment_status_id = '4';
            } else if ($request->is_status_admin == '5') { // accepted case
                $settlement_amount = $request->settlement_amount;
                $payment_status_id = '4';
                $reject_amount = ($clam_amount__ - $request->settlement_amount);
            }
            if ($api_api_expenses->settlement_amount === $api_api_expenses->claim_amount) {
                
            } else {

                if ($api_expenses_action_log) {

                    DB::table('api_expenses_action_log')
                            ->where('emp_id', '=', $id)
                            ->where('action_by', '=', 'Admin')
                            ->update([
                                'emp_id' => $id,
                                'action_date' => Carbon::today()->format('Y-m-d'),
                                'action_by' => 'Admin',
                                'action_by_user_id' => Auth::id(),
                                'is_process' => $request->is_status_admin,
                                'clam_amount' => ($request->expense_type == 0) ? $request->total_amount_cash : $request->total_amount_mile,
                                'payment_status_id' => $payment_status_id,
                                'master_note' => $request->note_by_admin,
                                'settlement_amount' => ($settlement_amount),
                                'reject_amount' => ($reject_amount),
                    ]);
                    DB::table('api_expenses')->where('id', '=', $id)->update([
                        'settlement_amount' => ($settlement_amount),
                        'reject_amount' => ($reject_amount),
                    ]);
                } else {

                    DB::table('api_expenses_action_log')->insertGetId([
                        'emp_id' => $id,
                        'action_by' => 'Admin',
                        'action_date' => Carbon::today()->format('Y-m-d'),
                        'action_by_user_id' => Auth::id(),
                        'is_process' => $request->is_status_admin,
                        'clam_amount' => ($request->expense_type == 0) ? $request->total_amount_cash : $request->total_amount_mile,
                        'payment_status_id' => $payment_status_id,
                        'master_note' => $request->note_by_admin,
                        'settlement_amount' => $settlement_amount,
                        'reject_amount' => $reject_amount,
                    ]);

                    DB::table('api_expenses')->where('id', '=', $id)->update([
                        'settlement_amount' => $settlement_amount,
                        'reject_amount' => $reject_amount,
                        'payment_status_id' => $payment_status_id,
                    ]);
                }


//==================================================================================================
// $to_email=DB::table('employees')->where('user_id', '=', $api_api_expenses->is_user)->first();
// $case=null;
// $settlement_amount=$request->settlement_amount;
// if ($request->is_status_admin == '5') {
//     $case="Accepted by Admin amount of " . $api_api_expenses->currency . ' ' . $settlement_amount;
// } else if ($request->is_status_admin == '6') {
//     $case="Reject by Admin amount of " . $api_api_expenses->currency . ' ' . $settlement_amount;
// }
// $body="Your Submitted Expense on date : " . $api_api_expenses->date_search . " Spent at : " . $api_api_expenses->spent_at . " Has been " . $case;
// $details=array(
//     'employee_name' => $to_email->name,
//     'admin_email' => $to_email->email,
//     'from_email' => $to_email->email,
//     'title' => 'Super Admin Expance Notification : ' . $to_email->name,
//     'subject' => 'Super Admin Expance Notification : ' . $to_email->name,
//     'body' => $body
// );
// Mail::send('emails.expance_body', ['details' => $details], function ($message) use ($details) {
//     $message->to($details['admin_email'], 'Admin : Hiteshkumar')
//             ->cc($details['admin_email'])
//             ->subject($details['subject']);
//     $message->from($details['from_email'], $details['title']);
// });
// $send_notification=(new Controller)->send_notification($api_api_expenses->is_user, $body);
//==============================================================================================================
            }
        }


        $document_name = $request->expense_type_document;
        if (isset($document_name)) {
//DB::table('api_expenses_documents')->where('emp_id', $id)->delete();
            foreach ($document_name as $key => $value) {
                $document_file = $request->file('expense_type_document')[$key];
                $FileExtension = $document_file->getClientOriginalExtension();
                $DestinationPath = 'public/uploads/expense_document/' . $id . '/'; //upload path
                $Media_Storing_Name = $document_file->getClientOriginalName();
                $fileName = str_replace(' ', '_', rand(999, 111) . (trim($Media_Storing_Name)));
                $document_file->move($DestinationPath, $fileName);

                DB::table("api_expenses_documents")->insertGetId([
                    'emp_id' => $id,
                    'document_file' => $fileName,
                    'file_extension' => $FileExtension,
                ]);
            }
        }
// $send_notification=(new Controller)->send_notification('1', "Expense Update Successfully");
        return redirect(route('expense'))->with('success', 'Expense has been updated!');
    }

    public function store(Request $request) {

        $combination_name = $is_save = '';
        if ($request->is_save == '2') {
            $combination_name = '';
        } else if ($request->is_save == '1') {
            $combination_name = 'expance-' . Carbon::today()->format('h') . '_' . rand(0, 9) . '_' . Auth::id();
        } else {
            $combination_name = 'expance-' . Carbon::today()->format('h') . '_' . rand(0, 9) . '_' . Auth::id();
        }
//($request->txt_combination_name == '0' ? $combination_name : $request->txt_combination_name)



        if ($request->expense_type == '0') {
            $apiemp_master = DB::table('api_expenses')->insertGetId([
                'expense_type' => $request->expense_type,
                'currency' => 'INR',
                'combination_name' => $combination_name . '_' . rand(0, 9),
                'combination_name_temp' => ($request->txt_combination_name == '0' ? $combination_name : $request->txt_combination_name) . rand(0, 8888) . '_' . Auth::id(),
                'claim_amount' => $request->total_amount_cash,
                'def_claim_amount' => $request->total_amount_cash,
                'combination_submit_date' => Carbon::today()->format('Y-m-d'),
                'total_amount_cash' => $request->total_amount_cash,
                'spent_at' => $request->spent_at_cash,
                'date_of_expense_cash' => $request->date_of_expense_cash,
                'city_id_cash' => $request->city_id_cash,
                'account_premises_no_cash' => $request->account_premises_no_cash,
                'card_used_cash' => $request->card_used_cash,
                'account_name_cash' => $request->account_name_cash,
                'department_id' => $request->ddl_department_cash,
                'category_id_cash' => $request->category_id_cash,
                'sub_category_id_cash' => $request->sub_category_id_cash,
                'payment_method_id' => $request->payment_method_id,
                'description_cash' => $request->description_cash,
                'property_address_cash' => $request->property_address_cash,
                'expance_multi_day' => $request->expance_multi_day,
                'multi_day_from_date' => $request->multi_day_from_date_cash,
                'multi_day_to_date' => $request->multi_day_to_date_cash,
                'date_search' => $request->date_of_expense_cash,
                'is_active' => $request->is_active,
                'date_of_expense_time' => $request->date_of_expense_time,
                'payment_status_id' => $request->payment_status_id,
                'is_save' => $request->is_save,
                'is_user' => (Auth::id() == 122) ? $request->employee_id : Auth::id()
            ]);
            DB::table('api_expenses')->where('id', '=', $apiemp_master)->update([
                'is_resubmit_expance_id' => $apiemp_master,
            ]);
        } else if ($request->expense_type == '1') {
            $apiemp_master = DB::table('api_expenses')->insertGetId([
                'currency' => 'INR',
                'combination_name' => $combination_name,
                'combination_name_temp' => $combination_name . rand(0, 9) . '_' . Auth::id(),
                'expense_type' => $request->expense_type,
                'vehicle_type_mile' => $request->vehicle_type_mile,
                'vehicle_rate_mile' => $request->vehicle_rate_mile,
                'distance_mile' => $request->distance_mile,
                'spent_at_mile' => $request->spent_at_mile,
                'date_of_expense_mile' => $request->date_of_expense_mile,
                'date_of_expense_time' => $request->date_of_expense_time,
                'city_name_mile' => $request->city_name_mile,
                'claim_amount' => $request->total_amount_cash,
                'total_amount_mile' => $request->total_amount_mile,
                'category_id_mile' => $request->category_id_mile,
                'subcategory_id_mile' => $request->subcategory_id_mile,
                'description_mile' => $request->description_mile,
                'is_active' => $request->is_active,
                'date_search' => $request->date_of_expense_mile,
                'payment_status_id' => $request->payment_status_id,
                'is_save' => $request->is_save,
                'is_user' => (Auth::id() == 122) ? $request->employee_id : Auth::id()
            ]);
        } else {
            return redirect(route('expense'))->with('success', 'Expense has been not create please try again.');
        }


        $document_name = $request->expense_type_document;
        if (isset($document_name)) {
            foreach ($document_name as $key => $value) {

                $document_file = $request->file('expense_type_document')[$key];
                $FileExtension = $document_file->getClientOriginalExtension();
                $DestinationPath = 'public/uploads/expense_document/' . $apiemp_master . '/'; //upload path
                $Media_Storing_Name = $document_file->getClientOriginalName();
                $fileName = str_replace(' ', '_', rand(999, 111) . (trim($Media_Storing_Name)));
                $document_file->move($DestinationPath, $fileName);

                DB::table("api_expenses_documents")->insertGetId([
                    'emp_id' => $apiemp_master,
                    'document_file' => $fileName,
                    'file_extension' => $FileExtension,
                ]);
            }
        }
// $send_notification=(new Controller)->send_notification(1, "Expense has been Create Successfully.");
        return redirect(route('expense'))->with('success', 'Expense has been Create Successfully.');
    }

}

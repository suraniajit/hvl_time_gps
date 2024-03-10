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

class ExpenseReportController extends Controller {

    public function __construct() {
        $this->middleware('permission:Access Expense Report', ['only' => ['show', 'index']]);
        $this->middleware('permission:Create Expense Report', ['only' => ['create']]);
        $this->middleware('permission:Read Expense Report', ['only' => ['read']]);
        $this->middleware('permission:Edit Expense Report', ['only' => ['edit']]);
        $this->middleware('permission:Delete Expense Report', ['only' => ['delete']]);
    }

    public function index() {
        // echo $uid = auth()->User()->id;
        $breadcrumbs = [
            ['link' => "/", 'name' => "Home"],
            ['link' => "/expense_report/", 'name' => "Expense Report Master"],
        ];

        $pageConfigs = ['pageHeader' => true, 'isFabButton' => true, 'isCustomizer' => true];

        $payment_method_master = (new Controller)->getAllDynamicTable('payment_method');

        $payment_status_master = (new Controller)->getConditionDynamicTableAll('payment_status', 'is_display', '0');

        if ((auth()->User()->id == '122') || (auth()->User()->id == '916')) {
            $employee_master = (new Controller)->getAllDynamicTable('employees');

            $expenses_details = DB::table('api_expenses')
                    ->select('*')
                    ->where('is_save', '=', 1)
                    // ->groupBy('api_expenses.is_user')
                    ->orderBy('api_expenses.id', 'DESC')
                    ->get();
            return view('employee-master.expense.report.index', [
                'pageConfigs' => $pageConfigs,
                'breadcrumbs' => $breadcrumbs,
                'employee_master' => $employee_master,
                'payment_status_master' => $payment_status_master,
                'payment_method_master' => $payment_method_master,
                'expenses_details' => $expenses_details,
            ]);
        } else {

            echo 'in employee_index==' . auth()->User()->id;
            $employee_master = DB::table('employees')
                    ->where('user_id', '=', auth()->User()->id)
                    ->get();

            foreach ($employee_master as $key => $v) {
                $emp_Array[] = $v->user_id;
            }



            $expenses_details = DB::table('api_expenses')
                    ->select('*')
                    ->whereIn('is_user', $emp_Array)
//                     $query->whereIn('api_expenses.is_user', $employee_id);
//                    $query->whereIn('api_expenses.is_user', $employee_id);
                    ->get();

            return view('employee-master.expense.report.index', [
                'pageConfigs' => $pageConfigs,
                'breadcrumbs' => $breadcrumbs,
                'employee_master' => $employee_master,
                'payment_status_master' => $payment_status_master,
                'payment_method_master' => $payment_method_master,
                'expenses_details' => $expenses_details,
            ]);
        }
    }

    public function search_by_employee(Request $request, $emp_id = null) {

        $breadcrumbs = [
            ['link' => "/", 'name' => "Home"],
            ['link' => "/expense_report/", 'name' => "Expense Report Master"],
        ];

        $pageConfigs = ['pageHeader' => true, 'isFabButton' => true, 'isCustomizer' => true];

        $to_date = $request->to_date_search;
        $from_date = $request->from_date_search;
        $payment_method_id = $request->payment_method_id_search;
        $payment_status_id = $request->payment_status_id_search;
        $employee_id = $request->employee_id;
        $expense_status_search = $request->expense_status_search;
        $process_status = $request->process_status;

        $employee_master = (new Controller)->getAllDynamicTable('employees');

        $query = DB::table('api_expenses')
                ->where('is_user', '=', $emp_id)
                ->orderBy('api_expenses.id', 'DESC');
        if ($employee_id) {
            $query->whereIn('api_expenses.is_user', $employee_id);
        }
        if ($process_status) {
            $query->whereIn('api_expenses.is_process', $process_status);
        }
        if ($payment_method_id) {
            $query->where('api_expenses.payment_method_id', '=', $payment_method_id);
        }
        if ($payment_status_id) {
            $query->whereIn('api_expenses.payment_status_id', $payment_status_id);
        }
        if ($expense_status_search) {
            $query->whereIn('api_expenses.is_save', $expense_status_search);
        }
        if ($to_date && $from_date) {
            $query->whereBetween('api_expenses.date_search', [$to_date, $from_date]);
        }

        $query->select('*');
        $expenses_details = $query->get();

        return view('employee-master.expense.report.index', [
            'pageConfigs' => $pageConfigs,
            'breadcrumbs' => $breadcrumbs,
            'payment_status_master' => (new Controller)->getAllDynamicTable('payment_status'),
            'payment_method_master' => (new Controller)->getAllDynamicTable('payment_method'),
            'to_date' => $to_date,
            'from_date' => $from_date,
            'employee_master' => $employee_master,
            'payment_method_id' => $payment_method_id,
            'payment_status_id' => $payment_status_id,
            'expenses_details' => $expenses_details,
            'expense_status_search' => $expense_status_search,
            'employee_id' => $employee_id,
            'process_status' => $process_status,
            'emp_id' => $emp_id
        ]);
    }

    public function search_details(Request $request, $emp_id = null) {
        echo auth()->User()->id;
        echo '<pre>';
        print_r($request->all());
        echo '</pre>';
        $breadcrumbs = [
            ['link' => "/", 'name' => "Home"],
            ['link' => "/expense_report/", 'name' => "Expense Report Master"],
        ];

        $pageConfigs = ['pageHeader' => true, 'isFabButton' => true, 'isCustomizer' => true];

        $to_date = $request->to_date_search;
        $from_date = $request->from_date_search;
        $payment_method_id = $request->payment_method_id_search;
        $payment_status_id = $request->payment_status_id_search;
        $employee_id = $request->employee_id;
        $expense_status_search = $request->expense_status_search;
        $process_status = $request->process_status;

        $process_status = $request->process_status;

        if ((auth()->User()->id == '122') || (auth()->User()->id == '916')) {

            $employee_master = (new Controller)->getAllDynamicTable('employees');

            $query = DB::table('api_expenses')
                    ->orderBy('api_expenses.id', 'DESC');
            if ($employee_id) {
                $query->whereIn('api_expenses.is_user', $employee_id);
            }
            if ($to_date && $from_date) {
                $query->whereBetween('api_expenses.date_search', [$to_date, $from_date]);
            }
            if ($process_status) {
                $query->whereIn('api_expenses.is_process', $process_status);
            }
//            if (isset($expense_status_search)) {
//                $query->whereIn('api_expenses.is_save', $expense_status_search);
//            }
//            if ($payment_method_id) {
//                $query->where('api_expenses.payment_method_id', '=', $payment_method_id);
//            }
//            if ($payment_status_id) {
//                $query->whereIn('api_expenses.payment_status_id', $payment_status_id);
//            }
        } else {

            $employee_master = DB::table('employees')
                    ->where('account_id', '=', auth()->User()->id)
                    ->get();
            // foreach ($employee_master as $key => $v) {
            //     $emp_Array[] = $v->user_id;
            // }

            $query = DB::table('api_expenses')
                    ->where('is_user', '=', auth()->User()->id);
            //->whereIn('is_user', $emp_Array);
            if ($employee_id) {
                $query->whereIn('api_expenses.is_user', $employee_id);
            }
            if ($process_status) {
                $query->whereIn('api_expenses.is_process', $process_status);
            }
            if ($payment_method_id) {
                $query->where('api_expenses.payment_method_id', '=', $payment_method_id);
            }
            if ($expense_status_search) {
                $query->whereIn('api_expenses.is_save', $expense_status_search);
            }
            if ($payment_status_id) {
                $query->whereIn('api_expenses.payment_status_id', $payment_status_id);
            }
            if ($to_date && $from_date) {
                $query->whereBetween('api_expenses.date_search', [$to_date, $from_date]);
            }
        }
        $query->select('*');
        $expenses_details = $query->get();

        return view('employee-master.expense.report.index', [
            'pageConfigs' => $pageConfigs,
            'breadcrumbs' => $breadcrumbs,
            'payment_status_master' => (new Controller)->getAllDynamicTable('payment_status'),
            'payment_method_master' => (new Controller)->getAllDynamicTable('payment_method'),
            'to_date' => $to_date,
            'from_date' => $from_date,
            'employee_master' => $employee_master,
            'payment_method_id' => $payment_method_id,
            'payment_status_id' => $payment_status_id,
            'expenses_details' => $expenses_details,
            'expense_status_search' => $expense_status_search,
            'employee_id' => $employee_id,
            'process_status' => $process_status,
            'emp_id' => $emp_id
        ]);
    }

}

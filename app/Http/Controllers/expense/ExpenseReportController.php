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
use Maatwebsite\Excel\Facades\Excel;
use App\ExpenseMaster;
use Validator;
use Mail;
use Carbon\Carbon;
use App\Mail\DownloadAttachementMail;
 use App\Exports\ExpenseReportExport;
use Maatwebsite\Excel\Excel as BaseExcel;
use App\Helpers\Helper;

class ExpenseReportController extends Controller {

    public function __construct() {
        $this->middleware('permission:Access Expense Report', ['only' => ['show', 'index']]);
        $this->middleware('permission:Create Expense Report', ['only' => ['create']]);
        $this->middleware('permission:Read Expense Report', ['only' => ['read']]);
        $this->middleware('permission:Edit Expense Report', ['only' => ['edit']]);
        $this->middleware('permission:Delete Expense Report', ['only' => ['delete']]);
    }

    public function report_history_download(Request $request) {
        return Excel::download(new ExpenseReportExport($request->all()), 'expence.xlsx');
//        return Excel::download(new ExpenseReportExport($request->all()), 'expence.pdf');
    }

    public function index() {
        if (auth()->User()->id == '13951') {
            $today_date = Carbon::today()->format('Y-m-d');
//            $pendding_list = DB::table('employees1')
//                    ->select('employees.user_id as user_id', 'api_expenses.*', 'api_expenses.id as exp_id')
//                    ->where('api_expenses.is_save', '=', 1)
////                    ->where('api_expenses.is_user', '=', 1395)
//                    ->where('api_expenses.payment_status_id', '=', null)
//                    ->whereIn('is_process', [0])
//                    ->whereNotIn('employees.manager_id', [0])
//                    ->join('api_expenses', 'api_expenses.is_user', '=', 'employees.user_id')
////                    ->join('employees', 'employees.user_id', '=', 'api_expenses.is_user')
//                    ->groupBy('api_expenses.is_user')
//                    ->get();
//            SELECT * FROM `api_expenses` WHERE `is_save` = 1 AND `is_process` = 0 AND `payment_status_id` 
//                    IS NULL GROUP BY `is_user` ORDER BY `id` DESC 
            $pendding_list = DB::table('api_expenses')
                    ->select('api_expenses.*', 'api_expenses.id as exp_id')
                    ->where('api_expenses.is_save', '=', 1)
//                    ->whereIn('api_expenses.is_user', [1395, 1401])
                    ->where('api_expenses.payment_status_id', '=', null)
                    ->whereIn('is_process', [0])
                    ->groupBy('api_expenses.is_user')
                    ->get();
            echo '<br>';
            echo count($pendding_list);
            echo '<br>';
            ?>
            <table>
                <tr>
                    <th>Expance_id</th>
                    <th>is_process</th>
                    <th>Employee name</th>
                    <th>combination_name</th>
                    <th>date_of_expense_cash</th>
                    <th>spent_at</th>
                    <th>manager email id</th>
                </tr>
                <?php
                $emp_Array = $pendding_list_ = [];
                foreach ($pendding_list as $key => $pendding_data) {
                    $manager_id = app('App\Http\Controllers\Controller')->getConditionDynamicNameTable('employees', 'user_id', $pendding_data->is_user, 'manager_id');
                    $manager_email = app('App\Http\Controllers\Controller')->getConditionDynamicNameTable('employees', 'user_id', $manager_id, 'email');
                    $emp_name = app('App\Http\Controllers\Controller')->getConditionDynamicNameTable('employees', 'user_id', $pendding_data->is_user, 'Name');
                    echo '(' . $emp_name . ') is_user ' . $pendding_data->is_user . ' - manager_id ' . $manager_id . '- manager_email ' . $manager_email;
                    echo '<br>';
//                    $emp_Array[] = $manager_id; // manager id
                    $emp_Array[] = $pendding_data->is_user; // manager id
                    ?>

                <?php } ?>
            </table>
            <table>
                <tr>
                    <th>Expance_id</th>
                    <th>Employee name</th>
                    <th>combination_name</th>
                    <th>date_of_expense_cash</th>
                </tr>
                <?php
                echo '<pre>';
                print_r($emp_Array);
                echo '</pre>';
                $cars[] = $array[] = $manager_list_[] = '';

                foreach ($emp_Array as $kry => $manager_ids) {
                    echo $manager_ids . '<br>';
                    $manager_list_ = DB::table('employees')
                                    ->where('manager_id', '=', $manager_ids)
                                    ->pluck('employees.user_id')->toArray();

                    $pendding_list_ = DB::table('api_expenses')
                            ->select('api_expenses.spent_at',
                                    'api_expenses.id',
                                    'api_expenses.is_user',
                                    'api_expenses.combination_name',
                                    'api_expenses.date_of_expense_cash',
                            )
                            ->where('api_expenses.is_save', '=', 1)
                            ->whereIn('is_process', [0])
                            ->where('api_expenses.payment_status_id', '=', null)
//                            ->where('api_expenses.is_user', '=', $send_data)
                            ->whereIn('api_expenses.is_user', $manager_list_)
                            ->get();
                    echo '<br>';
                    echo '# ' . count($pendding_list_) . ' #';
                    if (count($pendding_list_) > 0) {
                        echo '<br>';
                        foreach ($pendding_list_ as $key => $new) {
                            echo $new->is_user . ' - ' . $new->spent_at . '<br>';
                        }
                        echo '<hr>';
                    }
                }
                die();
            }


            // echo $uid = auth()->User()->id;
            $breadcrumbs = [
                ['link' => "/", 'name' => "Home"],
                ['link' => "/expense_report/", 'name' => "Expense Report Master"],
            ];

            $pageConfigs = ['pageHeader' => true, 'isFabButton' => true, 'isCustomizer' => true];

            if ((auth()->User()->id == '122') || (auth()->User()->id == '916')) {
                $employee_master = (new Controller)->getAllDynamicTable('employees');

                $expenses_details = DB::table('api_expenses')
                        ->select('*')
//                    ->where('is_save', '=', 1)
                        // ->groupBy('api_expenses.is_user')
                        ->orderBy('api_expenses.id', 'DESC')
                        ->get();
                return view('employee-master.expense.report.index', [
                    'pageConfigs' => $pageConfigs,
                    'breadcrumbs' => $breadcrumbs,
                    'employee_master' => $employee_master,
                    'payment_status_master' => (new Controller)->getConditionDynamicTableAll('payment_status', 'is_display', '0'),
                    'payment_method_master' => (new Controller)->getAllDynamicTable('payment_method'),
                    'expenses_details' => $expenses_details,
                ]);
            } else {

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
                    'payment_status_master' => (new Controller)->getConditionDynamicTableAll('payment_status', 'is_display', '0'),
                    'payment_method_master' => (new Controller)->getAllDynamicTable('payment_method'),
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

            if ($to_date && $from_date) {
                $query->whereBetween('api_expenses.account_action_date', [$to_date, $from_date]);
            }



            $query->select('*');
            $expenses_details = $query->get();

            return view('employee-master.expense.report.index', [
                'pageConfigs' => $pageConfigs,
                'breadcrumbs' => $breadcrumbs,
                'payment_status_master' => (new Controller)->getConditionDynamicTableAll('payment_status', 'is_display', '0'),
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

            $breadcrumbs = [
                ['link' => "/", 'name' => "Home"],
                ['link' => "/expense_report/", 'name' => "Expense Report Master"],
            ];

            $pageConfigs = ['pageHeader' => true, 'isFabButton' => true, 'isCustomizer' => true];
            $array = '';
            $to_date = $request->to_date_search;
            $from_date = $request->from_date_search;
            $employee_id = $request->employee_id;
            $process_status = $request->process_status;

            $array = array_search("0", $process_status);

            if ((auth()->User()->id == '122') || (auth()->User()->id == '916')) {
//            echo 'search_details';

                $employee_master = (new Controller)->getAllDynamicTable('employees');

                $query = DB::table('api_expenses')
                        ->orderBy('api_expenses.id', 'DESC');
                if ($employee_id) {
                    $query->whereIn('api_expenses.is_user', $employee_id);
                }
                if ($to_date && $from_date) {
                    $query->whereBetween('api_expenses.account_action_date', [$to_date, $from_date]);
                }
//            if ($array != 0) {
                if ($process_status) {
                    $query->whereIn('api_expenses.is_process', $process_status);
                }
//            }
            } else {
//            echo 'search_detailsElse';
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

                if ($to_date && $from_date) {
                    $query->whereBetween('api_expenses.account_action_date', [$to_date, $from_date]);
                }
            }
            $query->select('*');
            $expenses_details = $query->get();

            return view('employee-master.expense.report.index', [
                'pageConfigs' => $pageConfigs,
                'breadcrumbs' => $breadcrumbs,
                'payment_status_master' => (new Controller)->getConditionDynamicTableAll('payment_status', 'is_display', '0'),
                'payment_method_master' => (new Controller)->getAllDynamicTable('payment_method'),
                'to_date' => $to_date,
                'from_date' => $from_date,
                'employee_master' => $employee_master,
                'expenses_details' => $expenses_details,
                'employee_id' => $employee_id,
                'process_status' => $process_status,
                'emp_id' => $emp_id
//            'payment_method_id' => $payment_method_id,
//            'payment_status_id' => $payment_status_id,
//            'expense_status_search' => $expense_status_search,
            ]);
        }

//**********************************************************************************************
        public function report_history_by_report_details($emp_id, $report_name) {
            $breadcrumbs = [
                ['link' => "/", 'name' => "Home"],
                ['link' => "/expense/", 'name' => "Expense History Details"],
            ];

            $pageConfigs = ['pageHeader' => true, 'isFabButton' => true, 'isCustomizer' => true];

            $expenses_details = DB::table('api_expenses')
                    ->select('*')
                    ->where('is_user', '=', $emp_id)
                    ->where('combination_name', '=', $report_name)
                    ->whereIn('is_process', [3, 12])
                    ->whereIn('payment_status_id', [4])
                    ->orderBy('api_expenses.id', 'DESC')
                    ->get();
            return view('employee-master.expense.report.expense_histroy.index_details_report', [
                'pageConfigs' => $pageConfigs,
                'breadcrumbs' => $breadcrumbs,
                'payment_status_master' => (new Controller)->getConditionDynamicTableAll('payment_status', 'is_display', '0'),
                'payment_method_master' => (new Controller)->getAllDynamicTable('payment_method'),
                'expenses_details' => $expenses_details,
                'report_name' => $report_name,
                'emp_id' => $emp_id
            ]);
        }

        public function report_history_search_step_3(Request $request) {
            $breadcrumbs = [
                ['link' => "/", 'name' => "Home"],
                ['link' => "/expense/", 'name' => "Expense History Details"],
            ];

            $pageConfigs = ['pageHeader' => true, 'isFabButton' => true, 'isCustomizer' => true];

            $emp_id = $request->emp_id;
            $to_date = $request->to_date_search;
            $from_date = $request->from_date_search;
            $report_name = $request->report_name;

            $query = DB::table('api_expenses')
                    ->whereIn('is_process', [3, 12])
                    ->whereIn('payment_status_id', [4])
                    ->where('is_user', '=', $emp_id)
                    ->where('combination_name', '=', $report_name)
                    ->orderBy('api_expenses.id', 'DESC');

            if ($to_date && $from_date) {
                $query->whereBetween('api_expenses.account_action_date', [$from_date, $to_date]);
            }

            $query->select('*');
            $expenses_details = $query->get();
            return view('employee-master.expense.report.expense_histroy.index_details_report', [
                'pageConfigs' => $pageConfigs,
                'breadcrumbs' => $breadcrumbs,
                'payment_status_master' => (new Controller)->getConditionDynamicTableAll('payment_status', 'is_display', '0'),
                'payment_method_master' => (new Controller)->getAllDynamicTable('payment_method'),
                'expenses_details' => $expenses_details,
                'report_name' => $report_name,
                'to_date' => $to_date,
                'from_date' => $from_date,
                'emp_id' => $emp_id
            ]);
        }

        public function report_history_search_step_2(Request $request) {
            $breadcrumbs = [
                ['link' => "/", 'name' => "Home"],
                ['link' => "/expense/", 'name' => "Expense History Details"],
            ];

            $pageConfigs = ['pageHeader' => true, 'isFabButton' => true, 'isCustomizer' => true];

            $emp_id = $request->emp_id;
            $to_date = $request->to_date_search;
            $from_date = $request->from_date_search;

            $query = DB::table('api_expenses')
                    ->whereIn('is_process', [3, 12])
                    ->groupBy('api_expenses.combination_name')
                    ->whereIn('payment_status_id', [4])
                    ->where('is_user', '=', $emp_id)
                    ->orderBy('api_expenses.id', 'DESC');

            if ($to_date && $from_date) {
                $query->whereBetween('api_expenses.account_action_date', [$from_date, $to_date]);
            }

            $query->select('*');
            $expenses_details = $query->get();
            return view('employee-master.expense.report.expense_histroy.index_details', [
                'pageConfigs' => $pageConfigs,
                'breadcrumbs' => $breadcrumbs,
                'payment_status_master' => (new Controller)->getConditionDynamicTableAll('payment_status', 'is_display', '0'),
                'payment_method_master' => (new Controller)->getAllDynamicTable('payment_method'),
                'expenses_details' => $expenses_details,
                'emp_id' => $emp_id,
                'to_date' => $to_date,
                'from_date' => $from_date,
            ]);
        }

        public function report_history_details($emp_id) {

            $breadcrumbs = [
                ['link' => "/", 'name' => "Home"],
                ['link' => "/expense/", 'name' => "Expense History Details"],
            ];

            $pageConfigs = ['pageHeader' => true, 'isFabButton' => true, 'isCustomizer' => true];

            $expenses_details = DB::table('api_expenses')
                    ->select('*')
                    ->where('is_user', '=', $emp_id)
                    ->groupBy('api_expenses.combination_name')
                    ->whereIn('is_process', [3, 12])
                    ->whereIn('payment_status_id', [4])
                    ->orderBy('api_expenses.id', 'DESC')
                    ->get();
            return view('employee-master.expense.report.expense_histroy.index_details', [
                'pageConfigs' => $pageConfigs,
                'breadcrumbs' => $breadcrumbs,
                'payment_status_master' => (new Controller)->getConditionDynamicTableAll('payment_status', 'is_display', '0'),
                'payment_method_master' => (new Controller)->getAllDynamicTable('payment_method'),
                'expenses_details' => $expenses_details,
                'emp_id' => $emp_id
            ]);
        }

        public function report_history_index(Request $request) {
            $breadcrumbs = [
                ['link' => "/", 'name' => "Home"],
                ['link' => "/expense/", 'name' => "Expense History"],
            ];
            $pageConfigs = ['pageHeader' => true, 'isFabButton' => true, 'isCustomizer' => true];
            $expenses_details = DB::table('api_expenses')
                    ->select('*')
                    ->groupBy('api_expenses.is_user')
                    ->whereIn('is_process', [3, 12])
                    ->whereIn('payment_status_id', [4])
                    ->orderBy('api_expenses.account_action_date', 'DESC')
                    ->get();
            $employee_master = (new Controller)->getAllDynamicTable('employees');
            return view('employee-master.expense.report.expense_histroy.index', [
                'pageConfigs' => $pageConfigs,
                'breadcrumbs' => $breadcrumbs,
                'employee_master' => $employee_master,
                'payment_status_master' => (new Controller)->getConditionDynamicTableAll('payment_status', 'is_display', '0'),
                'payment_method_master' => (new Controller)->getAllDynamicTable('payment_method'),
                'expenses_details' => $expenses_details,
            ]);
        }

        public function report_history_search_step_1(Request $request) {
            $breadcrumbs = [
                ['link' => "/", 'name' => "Home"],
                ['link' => "/expense/", 'name' => "Expense History"],
            ];
            $pageConfigs = ['pageHeader' => true, 'isFabButton' => true, 'isCustomizer' => true];
            $to_date = $request->to_date_search;
            $from_date = $request->from_date_search;

            $query = DB::table('api_expenses')
                    ->groupBy('api_expenses.is_user')
                    ->whereIn('is_process', [3, 12])
                    ->whereIn('payment_status_id', [4])
                    ->orderBy('api_expenses.account_action_date', 'DESC');

            if ($to_date && $from_date) {
                $query->whereBetween('api_expenses.account_action_date', [$from_date, $to_date]);
            }

            $query->select('*');
            $expenses_details = $query->get();

            $employee_master = (new Controller)->getAllDynamicTable('employees');
            return view('employee-master.expense.report.expense_histroy.index', [
                'pageConfigs' => $pageConfigs,
                'breadcrumbs' => $breadcrumbs,
                'employee_master' => $employee_master,
                'payment_status_master' => (new Controller)->getConditionDynamicTableAll('payment_status', 'is_display', '0'),
                'payment_method_master' => (new Controller)->getAllDynamicTable('payment_method'),
                'expenses_details' => $expenses_details,
                'to_date' => $to_date,
                'from_date' => $from_date,
            ]);
        }

//**********************************************************************************************
    }
    
<?php

namespace App\Http\Controllers\hvl\activitymaster;

use Auth;
use App\User;
use Validator;
use DateTime;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\hvl\CustomerMaster;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ImportActivity;
use App\Imports\ImportCustomers;
use App\Exports\ExportActivity;

class ActivityMasterController extends Controller {

    public function __construct() {
        $this->middleware('permission:Access Activity', ['only' => ['show', 'index']]);
        $this->middleware('permission:Create Activity', ['only' => ['create']]);
        $this->middleware('permission:Read Activity', ['only' => ['read']]);
        $this->middleware('permission:Edit Activity', ['only' => ['edit']]);
        $this->middleware('permission:Delete Activity', ['only' => ['delete']]);
    }

    public function index() {
        $em_id = Auth::User()->id;
        $emp = DB::table('employees')->where('user_id', '=', $em_id)->first();
        $statuses = DB::table('activitystatus')->get();
        $today_date = Carbon::today()->format('Y-m-d');
        $activity_details = "";
        $branchs = array();
//if ($em_id == 1 or $em_id == 122 or $em_id == 158 or $em_id == 184) {
        if ($em_id == 1 or $em_id == 122 or $em_id == 184) {
            $activity_details = DB::table('hvl_activity_master')
                    ->select('hvl_activity_master.*', 'activitystatus.Name as activity_status', 'hvl_customer_master.customer_name as customer_id', 'Branch.name')
                    ->join('hvl_customer_master', 'hvl_customer_master.id', '=', 'hvl_activity_master.customer_id')
                    ->join('Branch', 'Branch.id', '=', 'hvl_customer_master.branch_name')
                    ->join('activitystatus', 'activitystatus.id', '=', 'hvl_activity_master.status')
                    ->orderBy('hvl_activity_master.id', 'DESC')
                    ->paginate(100);
            $branchs = DB::table('Branch')->get();
        } else {
            $activity_details = DB::table('hvl_activity_master')
                    ->join('hvl_customer_master', 'hvl_customer_master.id', '=', 'hvl_activity_master.customer_id')
                    ->join('hvl_customer_employees', 'hvl_customer_employees.customer_id', '=', 'hvl_customer_master.id')
                    ->join('Branch', 'Branch.id', '=', 'hvl_customer_master.branch_name')
                    ->join('activitystatus', 'activitystatus.id', '=', 'hvl_activity_master.status')
                    ->where('hvl_customer_employees.employee_id', $emp->id)
                    ->select('hvl_activity_master.*', 'activitystatus.Name as activity_status', 'hvl_customer_master.customer_name as customer_id', 'Branch.name')
                    ->orderBy('hvl_activity_master.id', 'DESC')
                    ->paginate(100);
            $cutomers = DB::table('hvl_activity_master')
                    ->join('hvl_customer_master', 'hvl_customer_master.customer_name', '=', 'hvl_activity_master.customer_id')
                    ->join('hvl_customer_employees', 'hvl_customer_employees.customer_id', '=', 'hvl_customer_master.id')
                    ->where('hvl_customer_employees.employee_id', $emp->id)
                    ->select('hvl_activity_master.*', 'hvl_customer_master.customer_name', 'hvl_customer_master.customer_name')
                    ->get()
                    ->groupBy('customer_name');
            $branc_id = DB::table('hvl_customer_master')
                    ->join('hvl_customer_employees', 'hvl_customer_employees.customer_id', '=', 'hvl_customer_master.id')
                    ->join('Branch', 'Branch.id', '=', 'hvl_customer_master.branch_name')
                    ->where('hvl_customer_employees.employee_id', $emp->id)
                    ->select('Branch.*')
                    ->get()
                    ->groupBy('Name');
            if (!empty($branc_id)) {
                foreach ($branc_id as $key => $branch_id) {
                    $branchs[] = DB::table('Branch')->where('Name', $key)->get();
                }
            }
        }
        return view('hvl.activitymaster.index', [
            'details' => $activity_details,
            // 'customers' => $cutomers,
            'branchs' => $branchs,
            'statuses' => $statuses
        ]);
    }

    public function get_index_customer(Request $request) {
        $id = $request->eids;
        $em_id = Auth::User()->id;
        $emp = DB::table('employees')->where('user_id', '=', $em_id)->first();
        if ($em_id == 1 or $em_id == 122) {
            $custdetails = DB::table('hvl_customer_master')
                    ->where('hvl_customer_master.branch_name', $id)
                    ->select('hvl_customer_master.id', 'hvl_customer_master.customer_name')
                    ->orderBy('hvl_customer_master.customer_name', 'ASC')
                    ->get();
        } else {
            $custdetails = DB::table('hvl_customer_master')
                    ->join('hvl_customer_employees', 'hvl_customer_employees.customer_id', '=', 'hvl_customer_master.id')
                    ->where('hvl_customer_master.branch_name', $id)
                    ->where('hvl_customer_employees.employee_id', $emp->id)
                    ->select('hvl_customer_master.id', 'hvl_customer_master.customer_name')
                    ->orderBy('hvl_customer_master.customer_name', 'ASC')
                    ->get();
        }
        return response()->json($custdetails);
    }

    public function get_index_customer_details(Request $request) {
        $em_id = Auth::User()->id;
        $emp = DB::table('employees')->where('user_id', '=', $em_id)->first();
        $ids = $request->customer_id;
        $custdetails = array();
        foreach ($ids as $id) {
            $custdetails[] = DB::table('hvl_activity_master')
                    ->orderBy('ASC')
                    ->join('activitystatus', 'activitystatus.id', '=', 'hvl_activity_master.status')
                    ->where('hvl_activity_master.customer_id', $id)
                    ->select('hvl_activity_master.*', 'activitystatus.Name as activity_status')
                    ->orderBy('hvl_activity_master.id', 'DESC')
                    ->get();
        }
        $statuses = DB::table('activitystatus')->get();
        return response()->json($statuses);
        if ($em_id == 1 or $em_id == 122) {
            $branchs = DB::table('Branch')->get();
        } else {
            $branchs = array();
            $branc_id = DB::table('hvl_customer_master')
                    ->join('hvl_customer_employees', 'hvl_customer_employees.customer_id', '=', 'hvl_customer_master.id')
                    ->join('Branch', 'Branch.id', '=', 'hvl_customer_master.branch_name')
                    ->where('hvl_customer_employees.employee_id', $emp->id)
                    ->select('Branch.*')
                    ->get()
                    ->groupBy('Name');
            if (!empty($branc_id)) {
                foreach ($branc_id as $key => $branch_id) {
                    $branchs[] = DB::table('Branch')->where('Name', $key)->get();
                }
            }
        }
        return view('hvl.activitymaster.index_details', [
            'details' => $custdetails,
            'branchs' => $branchs,
            'statuses' => $statuses
        ]);
    }

    public function create_activity() {
        $breadcrumbs = [
                ['link' => "/", 'name' => "Home"],
                ['link' => "/activity-master", 'name' => "Activity Management"],
                ['link' => "/activity-maste/create", 'name' => "Create"],
        ];
        /* Pageheader set true for breadcrumbs */
        $pageConfigs = [
            'pageHeader' => true,
            'isFabButton' => true, 'isCustomizer' => true
        ];
        /* Fetching all the statuses from status master */
        $uid = auth()->User()->id;
        if ($uid == 1 or $uid == 122) {
            $employees = DB::table('employees')->get();
            $table_data = '';
            $customers = DB::table('hvl_customer_master')
                    ->get();
        } else {
            $employees = '';
            $table_data = DB::table('employees')->where('user_id', $uid)->first();
            $customers = DB::table('hvl_customer_master')
                    ->join('hvl_customer_employees', 'hvl_customer_employees.customer_id', '=', 'hvl_customer_master.id')
                    ->where('hvl_customer_employees.employee_id', $table_data->id)
                    ->select('hvl_customer_master.*')
                    ->get();
        }
        $statuses = DB::table('activitystatus')->get();
        $types = DB::table('activitytype')->get();
        return view('hvl.activitymaster.create_activity', [
            'pageConfigs' => $pageConfigs,
            'breadcrumbs' => $breadcrumbs,
            'customers' => $customers,
            'employee_id' => $table_data,
            'employees' => $employees,
            'statuses' => $statuses,
            'types' => $types,
        ]);
    }

    function edit_activity($id) {
        $breadcrumbs = [
                ['link' => "/", 'name' => "Home"],
                ['link' => "/activity-master", 'name' => "Activity Management"],
                ['link' => "/activity-maste/create", 'name' => "Create"],
        ];
        $pageConfigs = ['pageHeader' => true, 'isFabButton' => true, 'isCustomizer' => true];
        $rightlink = [
                ['rightlink' => "/activity-master/create", 'name' => " "]
        ];
        $deletelink = [
                ['name' => "Delete"],
        ];
        $customer_activity = DB::table('hvl_activity_master')
                ->join('hvl_customer_master', 'hvl_customer_master.id', '=', 'hvl_activity_master.customer_id')
                ->join('employees', 'employees.id', '=', 'hvl_activity_master.employee_id')
                ->select('hvl_activity_master.*', 'employees.Name as emp_name', 'hvl_customer_master.customer_name as customer_id')
//            'hvl_customer_master.customer_name'
//                ->join('hvl_customer_master', 'hvl_customer_master.id', '=', 'hvl_activity_master.customer_id')
                ->where('hvl_activity_master.id', '=', $id)
                ->get();
//        dd($customer_activity);
        $statuses = DB::table('activitystatus')->get();
        $types = DB::table('activitytype')->get();
        $employees = DB::table('employees')->get();
        $jobcards = DB::table('hvl_job_cards')
                ->where('activity_id', '=', $id)
                ->get();
        $auditreport = DB::table('hvl_audit_reports')
                ->where('activity_id', $id)
                ->orderBy('id', 'DESC')
                ->get();
        if ($customer_activity) {
            return view('hvl.activitymaster.activity_edit', [
                'customer_activity' => $customer_activity,
                'pageConfigs' => $pageConfigs,
                'breadcrumbs' => $breadcrumbs,
                'employees' => $employees,
                'statuses' => $statuses,
                'types' => $types,
                'jobcards' => $jobcards,
                'audit_report' => $auditreport,
            ]);
        }
    }

    public static function today_date() {
        return Carbon::today()->format('Y-m-d');
    }

    function hvi_hisrty_delete(Request $request) {
        $data = DB::table('hvl_job_cards')->where('activity_id', $request->id)->get();
        $audit = DB::table('hvl_audit_reports')->where('activity_id', $request->id)->get();
        if (count($data) > 0 or count($audit) > 0) {
            return response('error');
        } else {
            DB::table('hvl_activity_master')
                    ->where('id', '=', $request->input('id'))
                    ->delete();
        }
    }

    function massdelete(Request $request) {
        $Status_ids = $request->input('ids');
        foreach ($Status_ids as $id) {
            $data = DB::table('hvl_job_cards')->where('activity_id', $id)->get();
            $audit = DB::table('hvl_audit_reports')->where('activity_id', $id)->get();
            if (count($data) > 0 or count($audit) > 0) {
                return response('error');
            } else {
                $Status_Multi_Delete = DB::table('hvl_activity_master')->whereId($id)->delete();
//                $Status_Multi_Delete->forceDelete();
            }
        }
    }

    public static function getcityNameByCityId($city_id) {
        return DB::table('common_cities')
                        ->select('common_cities.Name as city_name')
                        ->where('id', '=', $city_id)
                        ->get();
    }

    public static function getCustomerReport() {
        $breadcrumbs = [
                ['link' => "/", 'name' => "Home"],
                ['link' => "/activity-master", 'name' => "Activity Management"],
                ['link' => "/activity-maste/create", 'name' => "Create"],
        ];
        $pageConfigs = ['pageHeader' => true, 'isFabButton' => true, 'isCustomizer' => true];
        $deletelink = [
                ['name' => "Delete"],
        ];
        $downloadlink = [
                ['downloadlink' => "", 'name' => "Create"]
        ];
//        $report = DB::table('customer_activity')
//                ->select('employees.Name as emp_name', 'customer_activity.*', 'Customers.*')
//                ->join('employees', 'employees.user_id', '=', 'customer_activity.user_id')
//                ->join('Customers', 'Customers.id', '=', 'customer_activity.customer_id')
//                ->get();
        $report = DB::table('Customers')
                ->select('hvl_activity_master.*', 'Customers.*')
                ->join('hvl_activity_master', 'hvl_activity_master.customer_id', '=', 'Customers.id')
                ->groupBy('Customers.id')
                ->get();
        return view('hvl.activitymaster.hvi_report', [
            'customer_report' => $report,
            'downloadlink' => $downloadlink,
            'pageConfigs' => $pageConfigs,
            'breadcrumbs' => $breadcrumbs,
        ]);
    }

    public static function getCustomerDetails($customer_id, $to, $from) {
        return DB::table('hvl_activity_master')
                        ->select('hvl_activity_master.*')
                        ->where('customer_id', '=', $customer_id)
//                        ->whereBetween('start_date', ["'$to'", "'$from'"])
//                        ->whereBetween('start_date', [$to, $from])
                        ->orderBy('id', 'DESC')
                        ->get();
    }

    function update_activity(Request $request, $id) {
//        $customer_id = $request->customer_id;
        $txt_start_date = $request->txt_start_date;
        $txt_end_date = $request->txt_end_date;
        $ddl_type = $request->ddl_type;
        $ddl_status = $request->ddl_status;
        $created_by = $request->created_by;
        $ddl_frequency = $request->ddl_frequency;
        $complete_date = $request->complete_date;
//        $subject = $request->subject;
        $subject = str_replace(',', ' ', $request->subject);
        $txt_remark = $request->txt_remark;
        $insert = DB::table('hvl_activity_master')->where('id', '=', $id)
                ->update([
            'start_date' => $txt_start_date,
            'end_date' => $txt_end_date,
            'type' => $ddl_type,
            'status' => $ddl_status,
            'frequency' => $ddl_frequency,
            'created_by' => $created_by,
            'complete_date' => $complete_date,
            'subject' => $subject,
            'remark' => $txt_remark
        ]);
        return redirect()->back()->with('success', 'Activity Updated Successfully !');
//        return redirect('/activity-master');
    }

    public function activity_superadmin_store(Request $request) {
        $begin = new DateTime($request->txt_start_date);
        $end = new DateTime($request->txt_end_date);
        $employee_id = $request->employee_id;
        $customer_id = $request->customer_id;
//        $txt_start_date = $request->txt_start_date;
//        $txt_end_date = $request->txt_end_date;
        $ddl_type = $request->ddl_type;
        $ddl_status = $request->ddl_status;
        $created_by = $request->created_by;
        $ddl_frequency = $request->ddl_frequency;
        $complete_date = $request->complete_date;
        $subject = str_replace(',', ' ', $request->subject);
        $user = auth()->user();
        $id = Auth::id();
        if ($ddl_frequency == 'daily') {
            for ($i = $begin; $i <= $end; $i->modify('+1 day')) {
//                echo $i->format("Y-m-d");
                $insert = DB::table('hvl_activity_master')->insert([
                    'employee_id' => $employee_id,
                    'customer_id' => $customer_id,
                    'start_date' => $i->format("Y-m-d"),
                    'end_date' => $i->format("Y-m-d"),
                    'type' => $ddl_type,
                    'status' => $ddl_status,
                    'created_by' => $created_by,
                    'frequency' => $ddl_frequency,
                    'master_date' => $this->today_date(),
                    'complete_date' => $complete_date,
                    'user_id' => $id,
                    'subject' => $subject,
                    'remark' => $request->txt_remark, // developed by hitesh 20-08-2021
                ]);
            }
        } elseif ($ddl_frequency == 'weekly') {
            for ($i = $begin; $i <= $end; $i->modify('+8 day')) {
                $insert = DB::table('hvl_activity_master')->insert([
                    'employee_id' => $employee_id,
                    'customer_id' => $customer_id,
                    'start_date' => $i->format("Y-m-d"),
                    'end_date' => $i->format("Y-m-d"),
                    'type' => $ddl_type,
                    'status' => $ddl_status,
                    'created_by' => $created_by,
                    'frequency' => $ddl_frequency,
                    'master_date' => $this->today_date(),
                    'complete_date' => $complete_date,
                    'user_id' => $id,
                    'subject' => $subject,
                    'remark' => $request->txt_remark, // developed by hitesh 20-08-2021
                ]);
            }
        } elseif ($ddl_frequency == 'weekly_twice') {
            for ($i = $begin; $i <= $end; $i->modify('+4 day')) {
                $insert = DB::table('hvl_activity_master')->insert([
                    'employee_id' => $employee_id,
                    'customer_id' => $customer_id,
                    'start_date' => $i->format("Y-m-d"),
                    'end_date' => $i->format("Y-m-d"),
                    'type' => $ddl_type,
                    'status' => $ddl_status,
                    'created_by' => $created_by,
                    'frequency' => $ddl_frequency,
                    'master_date' => $this->today_date(),
                    'complete_date' => $complete_date,
                    'user_id' => $id,
                    'subject' => $subject,
                    'remark' => $request->txt_remark, // developed by hitesh 20-08-2021
                ]);
            }
        } elseif ($ddl_frequency == 'weekly_thrice') {
            for ($i = $begin; $i <= $end; $i->modify('+3 day')) {
                $insert = DB::table('hvl_activity_master')->insert([
                    'employee_id' => $employee_id,
                    'customer_id' => $customer_id,
                    'start_date' => $i->format("Y-m-d"),
                    'end_date' => $i->format("Y-m-d"),
                    'type' => $ddl_type,
                    'status' => $ddl_status,
                    'created_by' => $created_by,
                    'frequency' => $ddl_frequency,
                    'master_date' => $this->today_date(),
                    'complete_date' => $complete_date,
                    'user_id' => $id,
                    'subject' => $subject,
                    'remark' => $request->txt_remark, // developed by hitesh 20-08-2021
                ]);
            }
        } elseif ($ddl_frequency == 'fortnightly') {
            for ($i = $begin; $i <= $end; $i->modify('+15 day')) {
                $insert = DB::table('hvl_activity_master')->insert([
                    'employee_id' => $employee_id,
                    'customer_id' => $customer_id,
                    'start_date' => $i->format("Y-m-d"),
                    'end_date' => $i->format("Y-m-d"),
                    'type' => $ddl_type,
                    'status' => $ddl_status,
                    'created_by' => $created_by,
                    'frequency' => $ddl_frequency,
                    'master_date' => $this->today_date(),
                    'complete_date' => $complete_date,
                    'user_id' => $id,
                    'subject' => $subject,
                    'remark' => $request->txt_remark, // developed by hitesh 20-08-2021
                ]);
            }
        } elseif ($ddl_frequency == 'monthly') {
            for ($i = $begin; $i <= $end; $i->modify('+31 day')) {
                $insert = DB::table('hvl_activity_master')->insert([
                    'employee_id' => $employee_id,
                    'customer_id' => $customer_id,
                    'start_date' => $i->format("Y-m-d"),
                    'end_date' => $i->format("Y-m-d"),
                    'type' => $ddl_type,
                    'status' => $ddl_status,
                    'created_by' => $created_by,
                    'frequency' => $ddl_frequency,
                    'master_date' => $this->today_date(),
                    'complete_date' => $complete_date,
                    'user_id' => $id,
                    'subject' => $subject,
                    'remark' => $request->txt_remark, // developed by hitesh 20-08-2021
                ]);
            }
        } elseif ($ddl_frequency == 'monthly_thrice') {
            for ($i = $begin; $i <= $end; $i->modify('+11 day')) {
                $insert = DB::table('hvl_activity_master')->insert([
                    'employee_id' => $employee_id,
                    'customer_id' => $customer_id,
                    'start_date' => $i->format("Y-m-d"),
                    'end_date' => $i->format("Y-m-d"),
                    'type' => $ddl_type,
                    'status' => $ddl_status,
                    'created_by' => $created_by,
                    'frequency' => $ddl_frequency,
                    'master_date' => $this->today_date(),
                    'complete_date' => $complete_date,
                    'user_id' => $id,
                    'subject' => $subject,
                    'remark' => $request->txt_remark, // developed by hitesh 20-08-2021
                ]);
            }
        } elseif ($ddl_frequency == 'bimonthly') {
            for ($i = $begin; $i <= $end; $i->modify('+61 day')) {
                $insert = DB::table('hvl_activity_master')->insert([
                    'employee_id' => $employee_id,
                    'customer_id' => $customer_id,
                    'start_date' => $i->format("Y-m-d"),
                    'end_date' => $i->format("Y-m-d"),
                    'type' => $ddl_type,
                    'status' => $ddl_status,
                    'created_by' => $created_by,
                    'frequency' => $ddl_frequency,
                    'master_date' => $this->today_date(),
                    'complete_date' => $complete_date,
                    'user_id' => $id,
                    'subject' => $subject,
                    'remark' => $request->txt_remark, // developed by hitesh 20-08-2021
                ]);
            }
        } elseif ($ddl_frequency == 'quarterly') {
            for ($i = $begin; $i <= $end; $i->modify('+92 day')) {
                $insert = DB::table('hvl_activity_master')->insert([
                    'employee_id' => $employee_id,
                    'customer_id' => $customer_id,
                    'start_date' => $i->format("Y-m-d"),
                    'end_date' => $i->format("Y-m-d"),
                    'type' => $ddl_type,
                    'status' => $ddl_status,
                    'created_by' => $created_by,
                    'frequency' => $ddl_frequency,
                    'master_date' => $this->today_date(),
                    'complete_date' => $complete_date,
                    'user_id' => $id,
                    'subject' => $subject,
                    'remark' => $request->txt_remark, // developed by hitesh 20-08-2021
                ]);
            }
        } elseif ($ddl_frequency == 'quarterly_twice') {
            for ($i = $begin; $i <= $end; $i->modify('+46 day')) {
                $insert = DB::table('hvl_activity_master')->insert([
                    'employee_id' => $employee_id,
                    'customer_id' => $customer_id,
                    'start_date' => $i->format("Y-m-d"),
                    'end_date' => $i->format("Y-m-d"),
                    'type' => $ddl_type,
                    'status' => $ddl_status,
                    'created_by' => $created_by,
                    'frequency' => $ddl_frequency,
                    'master_date' => $this->today_date(),
                    'complete_date' => $complete_date,
                    'user_id' => $id,
                    'subject' => $subject,
                    'remark' => $request->txt_remark, // developed by hitesh 20-08-2021
                ]);
            }
        } elseif ($ddl_frequency == 'thrice_year') {
            for ($i = $begin; $i < $end; $i->modify('+122 day')) {
                $insert = DB::table('hvl_activity_master')->insert([
                    'employee_id' => $employee_id,
                    'customer_id' => $customer_id,
                    'start_date' => $i->format("Y-m-d"),
                    'end_date' => $i->format("Y-m-d"),
                    'type' => $ddl_type,
                    'status' => $ddl_status,
                    'created_by' => $created_by,
                    'frequency' => $ddl_frequency,
                    'master_date' => $this->today_date(),
                    'complete_date' => $complete_date,
                    'user_id' => $id,
                    'subject' => $subject,
                    'remark' => $request->txt_remark, // developed by hitesh 20-08-2021
                ]);
            }
        } else {
            for ($i = $begin; $i < $end; $i->modify('+366 day')) {
                $insert = DB::table('hvl_activity_master')->insert([
                    'employee_id' => $employee_id,
                    'customer_id' => $customer_id,
                    'start_date' => $i->format("Y-m-d"),
                    'end_date' => $i->format("Y-m-d"),
                    'type' => $ddl_type,
                    'status' => $ddl_status,
                    'created_by' => $created_by,
                    'frequency' => $ddl_frequency,
                    'master_date' => $this->today_date(),
                    'complete_date' => $complete_date,
                    'user_id' => $id,
                    'subject' => $subject,
                    'remark' => $request->txt_remark, // developed by hitesh 20-08-2021
                ]);
            }
        }
//        $insert = DB::table('hvl_activity_master')->insert([
//            'employee_id' => $employee_id,
//            'customer_id' => $customer_id,
//            'start_date' => $txt_start_date,
//            'end_date' => $txt_end_date,
//            'type' => $ddl_type,
//            'status' => $ddl_status,
//            'created_by' => $created_by,
//            'frequency' => $ddl_frequency,
//            'master_date' => $this->today_date(),
//            'user_id' => $id
//        ]);
        redirect()->back()->with('success', 'Activity Add Successfully !');
        return redirect('/activity-master');
    }

    public function jobcards_store_ajax_base(Request $request) {
        $data = array();
        $activity_id = $request->activity_id;
        if ($request->file('after_file')) {
            $file = $request->file('after_file');
            $after_file = time() . '_' . $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            $location = 'public/uploads/activitymaster/jobcards';
            $file->move($location, $after_file);
            $path = 'public/uploads/activitymaster/jobcards';
            $data['success'] = 1;
            $data['message'] = 'Uploaded Successfully!';
            $data['filepath'] = $path;
            $data['extension'] = $extension;
            DB::table('hvl_job_cards')->insert([
                'activity_id' => $activity_id,
                'before_pic' => '',
                'after_pic' => $after_file,
                'path' => $path,
                'added' => $this->today_date()
            ]);
        } else if ($request->file('before_file')) {
            $file = $request->file('before_file');
            $before_file = time() . '_' . $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            $location = 'public/uploads/activitymaster/jobcards';
            $file->move($location, $before_file);
            $path = 'public/uploads/activitymaster/jobcards';
            $data['success'] = 1;
            $data['message'] = 'Uploaded Successfully!';
            $data['filepath'] = $path;
            $data['extension'] = $extension;
            DB::table('hvl_job_cards')->insert([
                'activity_id' => $activity_id,
                'before_pic' => $before_file,
                'path' => $path,
                'added' => $this->today_date()
            ]);
        } else {
            $data['success'] = 2;
            $data['message'] = 'File not uploaded.';
        }
        if (!empty($request->file('before_file')) and !empty($request->file('after_file'))) {
            DB::table('hvl_activity_master')
                    ->whereId($activity_id)
                    ->update(['job_card' => 1]);
        }
        return response()->json($data);
    }

    public function jobcards_store(Request $request) {
        $round = '';
        $activity_id = $request->activity_id;
        $redirect_to = $request->redirect_to;
        $before_pic = '';
        $after_pic = '';
        if (!empty($request->file('before_pic'))) {
            foreach ($request->file('before_pic') as $before) {
                $path = 'public/uploads/activitymaster/jobcards';
                $before_pic = $before->getClientOriginalName();
                $before_file = $round . $before_pic;
                $before->move($path, $before_file);
                DB::table('hvl_job_cards')->insert([
                    'activity_id' => $activity_id,
                    'before_pic' => $before_file,
                    'after_pic' => '',
                    'path' => $path,
                    'added' => $this->today_date()
                ]);
            }
        }
        if (!empty($request->file('after_pic'))) {
            foreach ($request->file('after_pic') as $after) {
                $path = 'public/uploads/activitymaster/jobcards';
                $after_pic = $after->getClientOriginalName();
                $filename = $round . $after_pic;
                $after->move($path, $filename);
                DB::table('hvl_job_cards')->insert([
                    'activity_id' => $activity_id,
                    'before_pic' => '',
                    'after_pic' => $filename,
                    'path' => $path,
                    'added' => $this->today_date()
                ]);
            }
        }
        if (!empty($before_pic) and !empty($after_pic)) {
            DB::table('hvl_activity_master')
                    ->whereId($activity_id)
                    ->update(['job_card' => 1]);
        }

        return redirect()->back()->with('success', 'Job Card Added Successfully !');
//        return redirect('/activity-master');
    }

    public function audit_store(Request $request) {
        $round = rand(00001, 99999);
        $activity_id = $request->activity_id;
        $report = '';
        if (!empty($request->file('audit_report'))) {
            $path = 'uploads/activitymaster/auditreports';
            $report = $request->file('audit_report')->getClientOriginalName();
            $report_name = $report;
            $request->file('audit_report')->move($path, $report_name);
            DB::table('hvl_audit_reports')->insert([
                'activity_id' => $activity_id,
                'report' => $report_name,
                'path' => $path,
                'type' => $request->file('audit_report')->getClientOriginalExtension(),
                'added' => $this->today_date()
            ]);
        }
        return redirect()->back()->with('success', 'Audit Report Added Successfully !');
    }

    public function show_activity($id) {
        $customer_activity = DB::table('hvl_activity_master')
                ->select('hvl_activity_master.*', 'employees.Name as emp_name', 'hvl_customer_master.customer_name as customer_id')
                ->join('hvl_customer_master', 'hvl_customer_master.id', '=', 'hvl_activity_master.customer_id')
                ->join('employees', 'employees.id', '=', 'hvl_activity_master.employee_id')
                ->where('hvl_activity_master.id', '=', $id)
                ->get();
        $statuses = DB::table('activitystatus')->get();
        $types = DB::table('activitytype')->get();
        $jobcards = DB::table('hvl_job_cards')
                ->where('activity_id', '=', $id)
                ->get();
        $auditreport = DB::table('hvl_audit_reports')
                ->where('activity_id', $id)
                ->orderBy('id', 'DESC')
                ->paginate(100);
        if ($customer_activity) {
            return view('hvl.activitymaster.show', [
                'customer_activity' => $customer_activity,
                'jobcards' => $jobcards,
                'audit_report' => $auditreport,
                'statuses' => $statuses,
                'types' => $types,
            ]);
        }
    }

    public function delete_image(Request $request) {
        DB::table('hvl_job_cards')
                ->whereId($request->id)
                ->delete();
        return redirect()->back();
    }

    public function import_activity_view() {
        return view('hvl.importactivity');
    }

    public function import_activity(Request $request) {
        $request->validate([
            'import_file' => 'required'
        ]);
        Excel::import(new ImportActivity, request()->file('import_file'));
        return redirect('/import-activity')->with('success', 'Data imported successfully.');
    }

    public function get_customer(Request $request) {
        $custdetails = DB::table('hvl_customer_employees')
                ->join('hvl_customer_master', 'hvl_customer_master.id', '=', 'hvl_customer_employees.customer_id')
                ->where('hvl_customer_employees.employee_id ', $request->eid)
                ->select('hvl_customer_master.* ')
                ->get();
//dd($custdetails);
        return response()->json($custdetails);
    }

    public function get_status(Request $request) {
        $status = DB::table('activitystatus')->get();
//dd($custdetails);
        return response()->json($status);
    }

    public function get_date_data(Request $request) {
        //dd($request->all());
        $em_id = Auth::User()->id;
        $branch = $request->branch;
        $mindate = $request->start;
        $maxdate = $request->end;
        $status = $request->status_id;
        $status_id = $request->status_id;
        $ids = $request->customer_id;
        $emp = DB::table('employees')->where('user_id', '=', $em_id)->first();
        $branchs = array();
        $statuses = DB::table('activitystatus')->get();
        $activity_details = array();
        foreach ($ids as $id) {
            if (isset($mindate) and isset($maxdate) and isset($status_id)) {
                $activity_details[] = DB::table('hvl_activity_master')
                        ->join('activitystatus', 'activitystatus.id', '=', 'hvl_activity_master.status')
                        ->join('hvl_customer_master', 'hvl_customer_master.id', '=', 'hvl_activity_master.customer_id')
                        ->join('Branch', 'Branch.id', '=', 'hvl_customer_master.branch_name')
                        ->select('hvl_activity_master.*', 'activitystatus.Name as activity_status', 'hvl_customer_master.customer_name as customer_id', 'Branch.name')
                        ->where('hvl_activity_master.customer_id', $id)
                        //->whereIn('hvl_activity_master.status', $status_id)
                        ->whereBetween('start_date', [$mindate, $maxdate])
                        ->orderBy('hvl_activity_master.id', 'DESC')
                        ->get()
                        ->toArray();
            } elseif (!empty($mindate) and !empty($maxdate)) {
                $activity_details[] = DB::table('hvl_activity_master')
                        ->join('activitystatus', 'activitystatus.id', '=', 'hvl_activity_master.status')
                        ->join('hvl_customer_master', 'hvl_customer_master.id', '=', 'hvl_activity_master.customer_id')
                        ->join('Branch', 'Branch.id', '=', 'hvl_customer_master.branch_name')
                        ->select('hvl_activity_master.*', 'activitystatus.Name as activity_status', 'hvl_customer_master.customer_name as customer_id', 'Branch.name')
                        ->where('hvl_activity_master.customer_id', $id)
                        ->whereBetween('start_date', [$mindate, $maxdate])
                        ->orderBy('hvl_activity_master.id', 'DESC')
                        ->get();
            } elseif (!empty($status_id)) {
                $activity_details[] = DB::table('hvl_activity_master')
                        ->join('activitystatus', 'activitystatus.id', '=', 'hvl_activity_master.status')
                        ->join('hvl_customer_master', 'hvl_customer_master.id', '=', 'hvl_activity_master.customer_id')
                        ->join('Branch', 'Branch.id', '=', 'hvl_customer_master.branch_name')
                        ->select('hvl_activity_master.*', 'activitystatus.Name as activity_status', 'hvl_customer_master.customer_name as customer_id', 'Branch.name')
                        ->where('hvl_activity_master.customer_id', $id)
                        ->whereIn('hvl_activity_master.status', $status_id)
                        ->orderBy('hvl_activity_master.id', 'DESC')
                        ->get();
            } else {
                $activity_details[] = DB::table('hvl_activity_master')
                        ->join('hvl_customer_master', 'hvl_customer_master.id', '=', 'hvl_activity_master.customer_id')
                        ->join('activitystatus', 'activitystatus.id', '=', 'hvl_activity_master.status')
                        ->join('Branch', 'Branch.id', '=', 'hvl_customer_master.branch_name')
                        ->select('hvl_activity_master.*', 'activitystatus.Name as activity_status', 'hvl_customer_master.customer_name as customer_id', 'Branch.name')
                        ->orderBy('hvl_activity_master.id', 'DESC')
                        ->where('hvl_activity_master.customer_id', $id)
                        ->get();
            }
        }
        if ($em_id == 1 or $em_id == 122) {
            $branchs = DB::table('Branch')->get();
        } else {
            $branc_id = DB::table('hvl_customer_master')
                    ->join('hvl_customer_employees', 'hvl_customer_employees.customer_id', '=', 'hvl_customer_master.id')
                    ->join('Branch', 'Branch.id', '=', 'hvl_customer_master.branch_name')
                    ->where('hvl_customer_employees.employee_id', $emp->id)
                    ->select('Branch.*')
                    ->get()
                    ->groupBy('Name');
            foreach ($branc_id as $key => $branch_id) {
                $branchs[] = DB::table('Branch')->where('Name', $key)->get();
            }
        }
        return view('hvl.activitymaster.index_details', [
            'details' => $activity_details,
            // 'customers' => $customers,
            'branchs' => $branchs,
            'branch_id' => $request->branch,
            'startdate' => $request->start,
            'enddate' => $request->end,
            'status_id' => $request->status_id,
            'statuses' => $statuses
        ]);
    }

    public function export_all_activity() {
        return (new ExportActivity)->download('Allactivity.xlsx');
    }

}

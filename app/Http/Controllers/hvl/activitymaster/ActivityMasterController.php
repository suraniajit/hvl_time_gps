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
use App\Models\hvl\CustomersAdmin;
use App\Models\hvl\ActivityServiceReport;
use Hypweb\Flysystem\GoogleDrive\GoogleDriveAdapter;
use Illuminate\Support\Facades\Storage;
use Config;
// use Helper;
use Illuminate\Support\Facades\Mail;
use App\Mail\ActivityMasterSheetMail;
use App\Exports\ActivityMasterExport;
use Maatwebsite\Excel\Excel as BaseExcel;
use App\Helpers\Helper;
use App\ActivityMaster;

class ActivityMasterController extends Controller {

    protected  $helper = null;
    public function __construct() {
        $this->middleware('permission:Access Activity', ['only' => ['show', 'index']]);
        $this->middleware('permission:Create Activity', ['only' => ['create']]);
        $this->middleware('permission:Read Activity', ['only' => ['read']]);
        $this->middleware('permission:Edit Activity', ['only' => ['edit']]);
        $this->middleware('permission:Delete Activity', ['only' => ['delete']]);
        $this->helper = new Helper();
    }

    public function get_index_customer(Request $request) {
        $id = $request->eids;
        $em_id = Auth::User()->id;
        $emp = DB::table('employees')->where('user_id', '=', $em_id)->first();
        if ($em_id == 1 or $em_id == 122) {
            $custdetails = DB::table('hvl_customer_master')
                    ->where('hvl_customer_master.branch_name', $id)
                    ->orderBy('hvl_customer_master.customer_name', 'ASC')
                    ->pluck('hvl_customer_master.customer_name', 'hvl_customer_master.id')
                    ->toArray();
        } else {
            if ($emp) {
                $custdetails = DB::table('hvl_customer_master')
                        ->join('hvl_customer_employees', 'hvl_customer_employees.customer_id', '=', 'hvl_customer_master.id')
                        ->where('hvl_customer_master.branch_name', $id)
                        ->where('hvl_customer_employees.employee_id', $emp->id)
                        ->orderBy('hvl_customer_master.customer_name', 'ASC')
                        ->pluck('hvl_customer_master.customer_name', 'hvl_customer_master.id')
                        ->toArray();
            } else {
                $customersIds = [];
                $customers_admin = CustomersAdmin::where('user_id', Auth::User()->id)->first();
                if ($customers_admin) {
                    $customersIds = json_decode($customers_admin->customers_id, true);
                }
                $custdetails = DB::table('hvl_customer_master')
                        // ->select('hvl_customer_master.id', 'hvl_customer_master.customer_name')
                        ->where('hvl_customer_master.branch_name', $id)
                        ->whereIn('hvl_customer_master.id', $customersIds)
                        ->orderBy('hvl_customer_master.customer_name', 'ASC')
                        // ->get()
                        ->pluck('hvl_customer_master.customer_name', 'hvl_customer_master.id')
                        ->toArray();
            }
        }
        return response()->json($custdetails);
    }

    public function get_index_customer_details(Request $request) {
        $statuses = DB::table('activitystatus')->get();
        return response()->json($statuses);
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

    public function edit_activity($id) {
        $jobcards = DB::table('hvl_job_cards')->where('activity_id', '=', $id)->get();
        $auditreport = DB::table('hvl_audit_reports')->where('activity_id', $id)->orderBy('id', 'DESC')->get();
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
                ->leftJoin('hvl_customer_master', 'hvl_customer_master.id', '=', 'hvl_activity_master.customer_id')
                ->leftJoin('employees', 'employees.id', '=', 'hvl_activity_master.employee_id')
                ->select('hvl_activity_master.*', 'employees.Name as emp_name', 'hvl_customer_master.customer_name as customer_id')
                ->where('hvl_activity_master.id', '=', $id)
                ->first();
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
            $helper = new Helper();

            return view('hvl.activitymaster.activity_edit', [
                'customer_activity' => $customer_activity,
                'pageConfigs' => $pageConfigs,
                'breadcrumbs' => $breadcrumbs,
                'employees' => $employees,
                'statuses' => $statuses,
                'types' => $types,
                'jobcards' => $jobcards,
                'audit_report' => $auditreport,
                'helper' => $helper
            ]);
        }
    }

    public static function today_date() {

        return Carbon::today()->format('Y-m-d');
    }

    public function hvi_hisrty_delete(Request $request) {

        $data = DB::table('hvl_job_cards')->where('activity_id', $request->id)->get();
        $audit = DB::table('hvl_audit_reports')->where('activity_id', $request->id)->get();
        if (count($data) > 0 or count($audit) > 0) {
            return response('error');
        } else {
              DB::beginTransaction();
      
             $delete_data = DB::table('hvl_activity_master')->whereId($request->input('id'))->first();
            if($delete_data){
                 //system log by surani ajit
                $param['module']='Activity';
                $param['action']='Delete';
                $param['system_data']=$delete_data;
                $param['user_understand_data']= $this->userUnderstandData($request->input('id'));
                $this->helper->AddSystemLog($param);
                DB::table('hvl_activity_master')->where('id', '=', $request->input('id'))->delete();
            }
             DB::commit();
        }
    }

    public function massdelete(Request $request) {

        $Status_ids = $request->input('ids');
        foreach ($Status_ids as $id) {
            $data = DB::table('hvl_job_cards')->where('activity_id', $id)->get();
            $audit = DB::table('hvl_audit_reports')->where('activity_id', $id)->get();
            if (count($data) > 0 or count($audit) > 0) {
                return response('error');
            } else {
                 $delete_data = DB::table('hvl_activity_master')->whereId($id)->first();
               
                    //system log by surani ajit
                    DB::beginTransaction();
                    $param['module']='Activity';
                    $param['action']='Delete';
                    $param['system_data']=  $delete_data;
                    $param['user_understand_data']= $this->userUnderstandData($id); 
                    $this->helper->AddSystemLog($param);
                    //end  system log by surani ajit
                    $Status_Multi_Delete = DB::table('hvl_activity_master')->whereId($id)->delete();
                    DB::commit();
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
                        ->orderBy('id', 'DESC')
                        ->get();
    }

    public function update_activity(Request $request, $id) {
        try{    
            DB::beginTransaction();
            $txt_start_date = $request->txt_start_date;
            $txt_end_date = $request->txt_end_date;
            $start_time = $request->txt_start_time;
            $end_time = $request->txt_end_time;
            $ddl_type = $request->ddl_type;
            $ddl_status = $request->ddl_status;
            $start_date = $request->txt_start_date;
            $end_date = $request->txt_end_date;
            $created_by = $request->created_by;
            $ddl_frequency = $request->ddl_frequency;
            $complete_date = $request->complete_date;
            $subject = str_replace(',', ' ', $request->subject);
            $txt_remark = $request->txt_remark;
            $services_value = $request->services_value;
            $helper = new Helper();
            $super_admin = $helper->getSuperAdmin();
            date_default_timezone_set("Asia/Kolkata");
            $customer_activity = DB::table('hvl_activity_master')->where('id', $id)->first();
            // $startEnddateFlag = (date('d') == Config::get('app.edit_start_end_date_date_enable_activity')) ? (date('m', strtotime($customer_activity->start_date)) == date('m') ) ? true : false : false;
            $startEnddateFlag = (Auth::user()->email != $super_admin && (!Auth::user()->hasRole('Coordinator'))) ?
                    (in_array(date('d'), Config::get('app.edit_start_end_date_date_enable_activity'))) ?
                    (date('m', strtotime($customer_activity->start_date)) == date('m') ) ?
                    true :
                    false : false :
                    true;
            $update_data = [];
            if ($startEnddateFlag) {
                $update_data['start_date'] = $txt_start_date;
                $update_data['end_date'] = $txt_end_date;

            }
            $update_data['start_time'] = $start_time;
            $update_data['end_time'] = $end_time;
            
            $update_data['subject'] = $subject;
            $update_data['type'] = $ddl_type;
            $update_data['status'] = $ddl_status;
            $update_data['frequency'] = $ddl_frequency;
            $update_data['created_by'] = $created_by;
            $update_data['complete_date'] = $complete_date;
            $update_data['remark'] = $txt_remark;
            $update_data['services_value'] = $services_value;

            $activity_db_data = DB::table('hvl_activity_master')->where('id', '=', $id)->first();
            $activity_start_date = (isset($update_data['start_date']))?$update_data['start_date']:$activity_db_data->start_date;
            $activity_end_date  = (isset($update_data['end_date']))?$update_data['end_date']:$activity_db_data->end_date;

            $employee_already_assign = $this->checkEmployeeAssignToOtherEmployee($activity_db_data->employee_id,$activity_start_date,$activity_end_date,$start_time,$end_time,$activity_db_data->id);
            if($employee_already_assign['status']){                    
                DB::rollBack();
                throw new \ErrorException('Employee has already been assigned for '.$employee_already_assign['customer_name'].'. Please select different Date & Time to allocate activitiy');
            }

            $insert = DB::table('hvl_activity_master')->where('id', '=', $id)->update($update_data);
            //system log by surani ajit
            $param['module']='Activity';
            $param['action']='Update';
            $param['system_data']=$update_data;
            $param['user_understand_data']= $this->userUnderstandData($id);
            $this->helper->AddSystemLog($param);
            //end system log by surani ajit    
            DB::commit();
            return redirect()->back()->with('success', 'Activity Updated Successfully !');
        }catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors($e->getMessage());
            // return self::index($request)->withErrors("Please show a list of fields or row no = " . );
        }
   

    }

    public function activity_superadmin_store(Request $request) {
        try{
            
            DB::beginTransaction();
            $begin = new DateTime($request->txt_start_date);
            $end = new DateTime($request->txt_end_date);
            $subject = str_replace(',', ' ', $request->subject);
            $user = auth()->user();
            $id = Auth::id();
            $existing_last_activity = DB::table('hvl_activity_master')->groupBy('batch')->orderBy('batch', 'DESC')->first();
            if ($existing_last_activity) {
                $batch_no = $existing_last_activity->batch + 1;
            } else {
                $batch_no = 1;
            }
            $activity_data = [];
            $activity_date_list = $this->getActivityDateList($begin, $end, $request->ddl_frequency);
            foreach ($activity_date_list as $key => $activity_date) {
                // new code by ajit surani for time validation
                $employee_already_assign = $this->checkEmployeeAssignToOtherEmployee($request->employee_id,$activity_date,$activity_date,$request->txt_start_time,$request->txt_end_time);
                
                if($employee_already_assign['status']){                    
                    DB::rollBack();
                    throw new \ErrorException('Employee has already been assigned for '.$employee_already_assign['customer_name'].'. Please select different Date & Time to allocate activitiy');
                }
                // new code validation 
                $activity_data = [
                    'employee_id' => $request->employee_id,
                    'customer_id' => $request->customer_id,
                    'start_date' => $activity_date,
                    'end_date' => $activity_date,
                    'start_time'=>$request->txt_start_time,
                    'end_time'=>$request->txt_end_time,
                    'month' => date('m-m', strtotime("now")),
                    'type' => $request->ddl_type,
                    'status' => $request->ddl_status,
                    'created_by' => $request->created_by,
                    'frequency' => $request->ddl_frequency,
                    'master_date' => $this->today_date(),
                    'complete_date' => $request->complete_date,
                    'user_id' => $id,
                    'subject' => $subject,
                    'remark' => $request->txt_remark, // developed by hitesh 20-08-2021
                    'services_value' => $request->services_value, // developed by surani ajit
                    'batch' => $batch_no,
                ];
                $activityMaster = new ActivityMaster();
                $activityMaster->employee_id = $request->employee_id;
                $activityMaster->customer_id = $request->customer_id;
                $activityMaster->start_date = $activity_date;
                $activityMaster->end_date = $activity_date;
                $activityMaster->start_time = $request->txt_start_time;
                $activityMaster->end_time = $request->txt_end_time;
                $activityMaster->month = date('m-m', strtotime("now"));
                $activityMaster->type = $request->ddl_type;
                $activityMaster->status = $request->ddl_status;
                $activityMaster->created_by = $request->created_by;
                $activityMaster->frequency = $request->ddl_frequency;
                $activityMaster->master_date = $this->today_date();
                $activityMaster->complete_date = $request->complete_date;
                $activityMaster->user_id = $id;
                $activityMaster->subject = $subject;
                $activityMaster->remark = $request->txt_remark; // developed by hitesh 20-08-2021
                $activityMaster->services_value = $request->services_value; // developed by surani ajit
                $activityMaster->batch = $batch_no;
                $activityMaster->save();
                    //system log by surani ajit
                $param['module']='Activity';
                $param['action']='Add';
                $param['system_data']=$activity_data;
                $param['user_understand_data']= $this->userUnderstandData($activityMaster->id);
                $this->helper->AddSystemLog($param);
                //end system log by surani ajit
            }
          
            DB::commit();
            // DB::table('hvl_activity_master')->insert($activity_data);
            redirect()->back()->with('success', 'Activity Add Successfully !');
            return redirect('/activity-master');
        }catch (\Exception $e) {
            
            DB::rollBack();
            return redirect()->back()->withErrors($e->getMessage());
            
            // return self::index($request)->withErrors("Please show a list of fields or row no = " . );
        }
    }

    public function checkEmployeeAssignToOtherEmployee($employee_id,$start_date,$end_date,$start_time,$end_time,$except_activity_id=null){
        $employee_activity = ActivityMaster::where('hvl_activity_master.employee_id',$employee_id)
                ->leftjoin('hvl_customer_master','hvl_customer_master.id','=','hvl_activity_master.customer_id')
                ->where('start_date',$start_date);
                if($except_activity_id!=null){
                    $employee_activity=$employee_activity->whereNotIn('hvl_activity_master.id',[$except_activity_id]);
                }
                $employee_activity=$employee_activity->select(['hvl_activity_master.id','start_time','end_time','hvl_customer_master.customer_name'])
                ->get();
           if($employee_activity){
                foreach($employee_activity as $activity){
                    if($activity->start_time == null || $activity->end_time == null){
                        continue;
                    }
                    $db_start_time = date('His',strtotime($activity->start_time));
                    $db_end_time = date('His',strtotime($activity->end_time));    
                    $req_start_time = date('His',strtotime($start_time));
                    $req_end_time = date('His',strtotime($end_time));
                    if( $req_start_time  >  $db_start_time  && $req_start_time > $db_end_time && $req_end_time >= $db_start_time && $req_end_time >$db_end_time){
                    }else if( $db_start_time > $req_start_time && $db_start_time > $req_end_time && $db_end_time >= $req_start_time && $db_end_time > $req_end_time){
                    }
                    else{
                        return ['status'=>true,'customer_name'=>$activity->customer_name];
                    }
                }
                return ['status'=>false];
            }
            return ['status'=>false];
             
    }
    public function getActivityDateList($start_date, $end_date, $frequency) {
        $activity_date_list = [];
        if ($frequency == 'daily') {
            for ($i = $start_date; $i <= $end_date; $i->modify('+1 day')) {
                $activity_date_list[] = $i->format("Y-m-d");
            }
        } else if ($frequency == 'onetime') {
            $activity_date_list = [$start_date];
        } elseif ($frequency == 'weekly') {
            for ($i = $start_date; $i <= $end_date; $i->modify('+7 day')) {
                $activity_date_list[] = $i->format("Y-m-d");
            }
        } elseif ($frequency == 'alternative') {
            // 1+ day   
            for ($i = $start_date; $i <= $end_date;) {
                $activity_date_list[] = $i->format("Y-m-d");
                $i->modify('+2 day');
            }
        } elseif ($frequency == 'weekly_twice') {
            // week 2(3+4)  
            for ($i = $start_date; $i <= $end_date;) {
                $activity_date_list[] = $i->format("Y-m-d");
                $i->modify('+3 day');
                $activity_date_list[] = $i->format("Y-m-d");
                $i->modify('+4 day');
            }
        } elseif ($frequency == 'weekly_thrice') {
            // week 3 (2+3+2)
            for ($i = $start_date; $i <= $end_date;) {
                $activity_date_list[] = $i->format("Y-m-d");
                $i->modify('+2 day');
                $activity_date_list[] = $i->format("Y-m-d");
                $i->modify('+3 day');
                $activity_date_list[] = $i->format("Y-m-d");
                $i->modify('+2 day');
            }
        } elseif ($frequency == 'fortnightly') {
            //currect
            for ($i = $start_date; $i <= $end_date; $i->modify('+14 day')) {
                $activity_date_list[] = $i->format("Y-m-d");
            }
        } elseif ($frequency == 'monthly') {
            //currect
            for ($i = $start_date; $i <= $end_date; $i->modify('+1 month')) {
                $activity_date_list[] = $i->format("Y-m-d");
            }
        } elseif ($frequency == 'monthly_thrice') {
            // currect
            for ($i = $start_date; $i <= $end_date; $i->modify('+10 day')) {
                $activity_date_list[] = $i->format("Y-m-d");
            }
        } elseif ($frequency == 'bimonthly') {
            // currect
            for ($i = $start_date; $i <= $end_date; $i->modify('+2 month')) {
                $activity_date_list[] = $i->format("Y-m-d");
            }
        } elseif ($frequency == 'quarterly') {
            // currect
            for ($i = $start_date; $i <= $end_date; $i->modify('+3 month')) {
                $activity_date_list[] = $i->format("Y-m-d");
            }
        } elseif ($frequency == 'quarterly_twice') {
            //currect
            for ($i = $start_date; $i <= $end_date; $i->modify('+45 day')) {
                $activity_date_list[] = $i->format("Y-m-d");
            }
        } elseif ($frequency == 'thrice_year') {
            // currect
            for ($i = $start_date; $i <= $end_date; $i->modify('+4 month')) {
                $activity_date_list[] = $i->format("Y-m-d");
            }
        } else {
            $activity_date_list = [$start_date];
        }
        return $activity_date_list;
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
            // google drive
            $file_param = [
                'file_name' => $after_file,
            ];
            $helper = new Helper();
            $file_result = $helper->uploadGoogleFile($file, $file_param);

            // google drive end
            $location = 'public/uploads/activitymaster/jobcards';
            $file->move($location, $after_file);

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
            // google drive by ajit
            $file_param = [
                'file_name' => $after_file,
            ];
            $helper = new Helper();
            $file_result = $helper->uploadGoogleFile($file, $file_param);
            // google drive by ajit

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
        if (!empty($request->file('before_file')) and!empty($request->file('after_file'))) {
            DB::table('hvl_activity_master')
                    ->whereId($activity_id)
                    ->update(['job_card' => 1]);
        }
        return response()->json($data);
    }

    function google_drive_folder_create($folderName, $image_name, $clientOriginalName) {
        // $dir_2 = '/';
        // $recursive = false; // Get subdirectories also?
        // $contents = collect(Storage::cloud()->listContents($dir_2, $recursive));
        // $dir_2 = $contents->where('type', '=', 'dir')->where('filename', '=', $folderName)
        //         ->first(); // There could be duplicate directory names!
        // return Storage::cloud()->put($dir_2['path'] . '/' . $image_name, file_get_contents($clientOriginalName));
    }

    public function jobcards_store(Request $request) {

        $activity_id = $request->activity_id;
        $redirect_to = $request->redirect_to;
        $before_pic = $after_pic = '';
        if (!empty($request->file('before_pic'))) {
            foreach ($request->file('before_pic') as $before) {
                /* ---------------- developed by hitesh Google-: 04-01-2023 */
                $before_pic = strtolower(str_replace(' ', '', $activity_id . '_' . $before->getClientOriginalName()));
                // $this->google_drive_folder_create('jobcards', $before_pic, $before);
                /* ---------------- developed by hitesh Google-: 04-01-2023 */
                $path = 'public/uploads/activitymaster/jobcards';

                // google drive by ajit
                $file_param = [
                    'file_name' => $before_pic,
                ];
                $helper = new Helper();
                $file_result = $helper->uploadGoogleFile($before, $file_param);
                // google drive by ajit

                $before->move($path, $before_pic);
                DB::table('hvl_job_cards')->insert([
                    'activity_id' => $activity_id,
                    'before_pic' => $before_pic,
                    'after_pic' => '',
                    'path' => $path,
                    'added' => $this->today_date()
                ]);
            }
        }
        if (!empty($request->file('after_pic'))) {
            foreach ($request->file('after_pic') as $after) {

                $after_pic = strtolower(str_replace(' ', '', $activity_id . '_' . $after->getClientOriginalName()));
                $this->google_drive_folder_create('jobcards', $after_pic, $after);
                $path = 'public/uploads/activitymaster/jobcards';
                // google drive by ajit
                $file_param = [
                    'file_name' => $after_pic,
                ];
                $helper = new Helper();
                $file_result = $helper->uploadGoogleFile($after, $file_param);
                // google drive by ajit
                $after->move($path, $after_pic);

                DB::table('hvl_job_cards')->insert([
                    'activity_id' => $activity_id,
                    'before_pic' => '',
                    'after_pic' => $after_pic,
                    'path' => $path,
                    'added' => $this->today_date()
                ]);
            }
        }
        if (!empty($before_pic) and!empty($after_pic)) {
            DB::table('hvl_activity_master')
                    ->whereId($activity_id)
                    ->update(['job_card' => 1]);
        }
        return redirect()->back()->with('success', 'Job Card Added Successfully !');
    }

    public function audit_store(Request $request) {

        $round = rand(00001, 99999);
        $activity_id = $request->activity_id;
        $report = '';
        if (!empty($request->hasFile('audit_report'))) {

            /* ---------------- developed by hitesh Google-: 04-01-2023 */
            $before = $request->file('audit_report');
            $before_pic = $activity_id . '_' . $before->getClientOriginalName();
            // google drive by ajit
            $file_param = [
                'file_name' => $before_pic,
            ];
            $helper = new Helper();
            $file_result = $helper->uploadGoogleFile($before, $file_param);
            // google drive by ajit
            $path = 'uploads/activitymaster/auditreports';
            $before->move($path, $before_pic);

            // $request->file('audit_report')->move($path, $before_pic);
            DB::table('hvl_audit_reports')->insert([
                'activity_id' => $activity_id,
                'report' => $before_pic,
                'path' => $path,
                'type' => $request->file('audit_report')->getClientOriginalExtension(),
                'added' => $this->today_date()
            ]);
        }

        return redirect()->back()->with('success', 'Audit Report Added Successfully !');
    }

    public function show_activity($id) {

        $customer_activity = DB::table('hvl_activity_master')
                ->leftJoin('hvl_customer_master', 'hvl_customer_master.id', '=', 'hvl_activity_master.customer_id')
                ->leftJoin('employees', 'employees.id', '=', 'hvl_activity_master.employee_id')
                ->select('hvl_activity_master.*', 'employees.Name as emp_name', 'hvl_customer_master.customer_name as customer_id')
                ->where('hvl_activity_master.id', '=', $id)
                ->first();
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
            $helper = new Helper();
            return view('hvl.activitymaster.show', [
                'customer_activity' => $customer_activity,
                'jobcards' => $jobcards,
                'audit_report' => $auditreport,
                'statuses' => $statuses,
                'types' => $types,
                'helper' => $helper
            ]);
        }
    }

    public function google_cloud($folder_name) {
        $folder_name = $folder_name; // Get root directory contents...
        $contents = collect(Storage::cloud()->listContents('/', false)); // Find the folder you are looking for...
        $dir = $contents->where('type', '=', 'dir')->where('filename', '=', $folder_name)->first(); // There could be duplicate directory names!
        return $clouds_files = collect(Storage::cloud()->listContents($dir['path'], false))->where('type', '=', 'file'); // Get the files inside the folder...
    }

    public function delete_image(Request $request) {
        $file_name = $request->name;
        $row = DB::table('hvl_job_cards')->whereId($request->id)->first();
        $before_image_path = base_path() . "/" . $row->path . "/" . $row->before_pic;
        $after_image_path = base_path() . "/" . $row->path . "/" . $row->after_pic;
        if ($row->before_pic) {
            if (file_exists($before_image_path)) {
                unlink($before_image_path);
            }
        }
        if ($row->after_pic) {
            if (file_exists($after_image_path)) {
                unlink($after_image_path);
            }
        }

        /* ---------------- developed by hitesh Google : 04-01-2023 */
        /*
          $clouds_files = $this->google_cloud('jobcards');

          foreach ($clouds_files as $k => $file) {
          $file_path = $file['path'];
          $url = Storage::disk('google')->url($file_path);
          if ($file_name == $file['name']) {
          Storage::cloud()->delete($file['path']);
          }
          }
         */
        /* ---------------- developed by hitesh Google : 04-01-2023 */

        DB::table('hvl_job_cards')->whereId($request->id)->delete();
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
        return response()->json($custdetails);
    }

    public function get_status(Request $request) {
        $status = DB::table('activitystatus')->get();
        return response()->json($status);
    }

    public function index(Request $request) {

        $search_branch = $request->branch;
        $search_sdate = $request->start;
        $search_edate = $request->end;
        $search_status_id = $request->status_id;
        $search_customer_ids = $request->customer_id;
        $em_id = Auth::User()->id;
        $emp = DB::table('employees')->where('user_id', '=', $em_id)->first();
        $statuses = DB::table('activitystatus')->get();
        $today_date = Carbon::today()->format('Y-m-d');
        $today_data = $request->input('today', false);
        $activity_details = null;
        $employees_array =  DB::table('employees')->pluck('Name','id')->toArray();
        $branchs = array();
        $customer_options = array();
        // for today defualt today activity
        if(((!isset($search_sdate)) || $search_sdate == null) && (!isset($search_edate) || $search_edate == null)){
            $today_data= true;
        }

        if ($em_id == 1 or $em_id == 122 or $em_id == 184) {
            $activity_details = DB::table('hvl_activity_master')
                    ->select('hvl_activity_master.*', 'hvl_customer_master.branch_name')
                    ->join('hvl_customer_master', 'hvl_customer_master.id', '=', 'hvl_activity_master.customer_id');
            // ->whereRaw('hvl_activity_master.status != 5');

            if ($today_data) {
                $activity_details = $activity_details->where('hvl_activity_master.start_date', $today_date);
            } else {
                if ($search_sdate != null && $search_edate != null) {
                    $activity_details = $activity_details->whereBetween('hvl_activity_master.start_date', [$search_sdate, $search_edate]);
                }
            }

            if ($search_status_id != null && (!empty($search_status_id))) {
                $activity_details = $activity_details->whereIn('hvl_activity_master.status', $search_status_id);
            }

            if ($search_customer_ids != null && (!empty($search_customer_ids))) {
                $activity_details = $activity_details->whereIn('hvl_activity_master.customer_id', $search_customer_ids);
            }

            if ($search_branch != null) {
                $activity_details = $activity_details->where('hvl_customer_master.branch_name', $search_branch);
            }
            $activity_details = $activity_details->orderBy('hvl_activity_master.id', 'DESC');
            if ($search_sdate == null && $search_edate == null && $search_status_id == null && $search_customer_ids == null && $search_branch == null) {
                $activity_details = $activity_details->paginate(100);
            } else {


                $activity_details = $activity_details->get();
            }
            if ($search_branch != null) {
                $customer_options = DB::table('hvl_customer_master')->where('hvl_customer_master.branch_name', $search_branch)->pluck('customer_name', 'id')->toArray();
            }
            $customers = DB::table('hvl_customer_master')->pluck('customer_name', 'id')->toArray();
            $branchs = DB::table('Branch')->pluck('Name', 'id')->toArray();
        } else {
            if ($emp) {
                $customers = DB::table('hvl_customer_master')
                        ->join('hvl_customer_employees', 'hvl_customer_employees.customer_id', '=', 'hvl_customer_master.id')
                        ->where('hvl_customer_employees.employee_id', $emp->id)
                        ->pluck('hvl_customer_master.customer_name', 'hvl_customer_master.id')
                        ->toArray();
                $db_customer_ids = array_keys($customers);
                $activity_details = DB::table('hvl_activity_master')
                        ->select('hvl_activity_master.*', 'hvl_customer_master.branch_name')
                        ->join('hvl_customer_master', 'hvl_customer_master.id', '=', 'hvl_activity_master.customer_id');

                if ($today_data) {
                    $activity_details = $activity_details->where('hvl_activity_master.start_date', $today_date);
                } else {
                    if ($search_sdate != null && $search_edate != null) {
                        $activity_details = $activity_details->whereBetween('hvl_activity_master.start_date', [$search_sdate, $search_edate]);
                    }
                }
                if ($search_status_id != null && (!empty($search_status_id))) {
                    $activity_details = $activity_details->whereIn('hvl_activity_master.status', $search_status_id);
                }

                if ($search_customer_ids != null && (!empty($search_customer_ids))) {
                    $activity_details = $activity_details->whereIn('hvl_activity_master.customer_id', $search_customer_ids);
                } else {
                    $activity_details = $activity_details->whereIn('hvl_activity_master.customer_id', $db_customer_ids);
                }
                if ($search_branch != null) {
                    $activity_details = $activity_details->where('hvl_customer_master.branch_name', $search_branch);
                }
                $activity_details = $activity_details->orderBy('hvl_activity_master.id', 'DESC');
                if ($search_sdate == null && $search_edate == null && $search_status_id == null && $search_customer_ids == null && $search_branch == null) {
                    $activity_details = $activity_details->paginate(100);
                } else {
                    $activity_details = $activity_details->get();
                }

                if ($search_branch != null) {
                    $customer_options = DB::table('hvl_customer_master')
                                    ->where('hvl_customer_master.branch_name', $search_branch)
                                    ->whereIn('hvl_customer_master.id', $db_customer_ids)
                                    ->pluck('hvl_customer_master.customer_name', 'hvl_customer_master.id')->toArray();
                }

                $branchs = DB::table('hvl_customer_master')
                        ->join('hvl_customer_employees', 'hvl_customer_employees.customer_id', '=', 'hvl_customer_master.id')
                        ->join('Branch', 'Branch.id', '=', 'hvl_customer_master.branch_name')
                        ->where('hvl_customer_employees.employee_id', $emp->id)
                        ->groupBy('Name')
                        ->pluck('Name', 'Branch.id')
                        ->toArray();
            } else {
                //  for customer admin login
                $db_customersIds = [];
                $customers_admin = CustomersAdmin::where('user_id', Auth::User()->id)->first();
                if ($customers_admin) {
                    $db_customersIds = json_decode($customers_admin->customers_id, true);
                }

                $activity_details = DB::table('hvl_activity_master')
                        ->select('hvl_activity_master.*', 'hvl_customer_master.branch_name')
                        ->join('hvl_customer_master', 'hvl_customer_master.id', '=', 'hvl_activity_master.customer_id');
                if ($today_data) {
                    $activity_details = $activity_details->where('hvl_activity_master.start_date', $today_date);
                } else {
                    if ($search_sdate != null && $search_edate != null) {
                        $activity_details = $activity_details->whereBetween('hvl_activity_master.start_date', [$search_sdate, $search_edate]);
                    }
                }
                if ($search_status_id != null && (!empty($search_status_id))) {
                    $activity_details = $activity_details->whereIn('hvl_activity_master.status', $search_status_id);
                }

                if ($search_customer_ids != null && (!empty($search_customer_ids))) {
                    $activity_details = $activity_details->whereIn('hvl_activity_master.customer_id', $search_customer_ids);
                } else {
                    $activity_details = $activity_details->whereIn('hvl_activity_master.customer_id', $db_customersIds);
                }
                if ($search_branch != null) {
                    $activity_details = $activity_details->where('hvl_customer_master.branch_name', $search_branch);
                }
                $activity_details = $activity_details->orderBy('hvl_activity_master.id', 'DESC');
                if ($search_sdate == null && $search_edate == null && $search_status_id == null && $search_customer_ids == null && $search_branch == null) {
                    $activity_details = $activity_details->paginate(100);
                } else {
                    $activity_details = $activity_details->get();
                }

                if ($search_branch != null) {
                    $customer_options = DB::table('hvl_customer_master')
                                    ->where('hvl_customer_master.branch_name', $search_branch)
                                    ->whereIn('hvl_customer_master.id', $db_customersIds)
                                    ->pluck('hvl_customer_master.customer_name', 'hvl_customer_master.id')->toArray();
                }

                $customers = DB::table('hvl_customer_master')
                                ->whereIn('hvl_customer_master.id', $db_customersIds)
                                ->pluck('customer_name', 'id')->toArray();

                $branchs = DB::table('hvl_customer_master')
                        ->join('Branch', 'Branch.id', '=', 'hvl_customer_master.branch_name')
                        ->whereIn('hvl_customer_master.id', $db_customersIds)
                        ->groupBy('Branch.id')
                        ->pluck('Name', 'Branch.id')
                        ->toArray();
            }
        }
        $activity_ids = array_column($activity_details->toArray(), 'id');
        $customer_code = DB::table('hvl_customer_master')
                        ->whereIn('hvl_customer_master.id', array_keys($customers))
                        ->pluck('customer_code', 'id')->toArray();
        $hvl_job_cards = DB::table('hvl_job_cards')
                // ->whereIn('hvl_job_cards.activity_id',$activity_ids)
                ->groupBy('hvl_job_cards.activity_id')
                ->orderBy('id', 'DESC')
                ->pluck('hvl_job_cards.added', 'hvl_job_cards.activity_id')
                ->toArray();

        $hvl_audit_reports = DB::table('hvl_audit_reports')
                // ->whereIn('hvl_audit_reports.activity_id',$activity_ids)    
                ->groupBy('hvl_audit_reports.activity_id')
                ->orderBy('id', 'DESC')
                ->pluck('hvl_audit_reports.added', 'hvl_audit_reports.activity_id')
                ->toArray();

        $jobcardupdated = ActivityServiceReport::pluck('created_at', 'activity_id');

        $relaince_form_pest_control_activity = [
            "Pest control activity : First Week (RM/FM)",
            "Pest control activity : Second  Week (RM/FM)",
            "Pest control activity : Third Week (RM/FM)",
            "Pest control activity : Fourth Week (RM/FM)",
            "Pest control activity : Cockroach Management"
        ];
        $relaince_form_activity_details = [
            "Total new glue pads placed for rodents in Store",
            "Number of glue pads replaced",
            "Number of rodent catches",
            "Number of new fly ribbons placed in the Store",
            "Number of fly ribbons replaced",
            "Number of rodent alarms for the Store",
            "Store dump (in Rupees) due to rodent menace  (Write only if the same is shown to the Pest Control Contractor)",
        ];
        $month_week_list = [
            "week_1",
            "week_2",
            "week_3",
            "week_4"
        ];
        $pest_controller_service = [
            97 => "fly_management",
            98 => "rodent_management",
            99 => "cockroach_management",
            100 => "lizard_management",
            101 => "honey_bee/seasonal_flies",
            102 => "",
            103 => "",
            104 => "",
        ];
        $months = [
            'jan' => 'January',
            'feb' => 'February',
            'mar' => 'March',
            'apr' => 'April',
            'may' => 'May',
            'jun' => 'June',
            'jul' => 'July',
            'aug' => 'August',
            'sep' => 'September',
            'oct' => 'October',
            'nov' => 'November',
            'dec' => 'December'
        ];

        $activity_status = DB::table('activitystatus')->pluck('Name', 'id')->toArray();

        return view('hvl.activitymaster.index', [
            'employees'=>$employees_array,
            'em_id' => $em_id,
            'details' => $activity_details,
            'customers' => $customers,
            'customer_code' => $customer_code,
            'customer_options' => $customer_options,
            'jobcardupdated' => $jobcardupdated,
            'branchs' => $branchs,
            'status' => $activity_status,
            'hvl_job_cards' => $hvl_job_cards,
            'hvl_audit_reports' => $hvl_audit_reports,
            'today_data' => $today_data,
            'search_branch' => ($search_branch != null) ? $search_branch : null,
            'search_sdate' => ($search_sdate != null) ? $search_sdate : null,
            'search_edate' => ($search_edate != null) ? $search_edate : null,
            'search_status_id' => ($search_status_id != null && (!empty($search_status_id))) ? $search_status_id : [],
            'search_customer_ids' => ($search_customer_ids != null && (!empty($search_customer_ids))) ? $search_customer_ids : [],
            'first_form_activity_list' => $relaince_form_pest_control_activity,
            'relaince_form_activity_details' => $relaince_form_activity_details,
            'month_week_list' => $month_week_list,
            'pest_controller_service' => $pest_controller_service,
            'months' => $months,
            'frequency_option' => $this->getFrequencyOption(),
        ]);
    }

    public function export_all_activity() {
        return (new ExportActivity)->download('Allactivity.xlsx');
    }

    /* comment for mobile download issue solve by ajit
    public function getDownloadActivity(Request $request) {
        return Excel::download(new ActivityMasterExport($request->all()), 'activity_master.xlsx');
    }
    */
    public function getDownloadActivity(Request $request){
        $file_name = date('Y_m_d_h_i_s')."_activity_master.xlsx";
        Excel::store(new ActivityMasterExport($request->all()), '/public/temp/'.$file_name);
        return redirect()->to( asset('public/storage/temp/'.$file_name));
    }
    

    public function sendActivityExcelSheet(Request $request) {
        $attachment = Excel::raw(
                        new ActivityMasterExport($request->all()),
                        BaseExcel::CSV
        );

        $message = Mail::to($request->to);
        if (isset($request->cc)) {
            $message->cc($request->cc);
        }
        if (isset($request->bcc)) {
            $message->bcc($request->bcc);
        }
        $message->send(new ActivityMasterSheetMail($attachment, $request->subject, $request->body));
        return redirect('/activity-master')->with('success', 'Email Sent successfully.');
    }

    public function getFrequencyOption() {
        return [
            "daily" => "Daily",
            "weekly" => "Weekly",
            "weekly_twice" => "Weekly Twice",
            "weekly_thrice" => "Weekly Thrice",
            "fortnightly" => "Fortnightly",
            "monthly" => "Monthly",
            "monthly_thrice" => "Monthly Thrice ",
            "bimonthly" => "Bimonthly",
            "quarterly" => "Quarterly",
            "quarterly_twice" => "Quarterly twice",
            "thrice_year" => "Thrice in a Year",
            "onetime" => "One Time",
        ];
    }
     public function userUnderstandData($activity_id){
            $data = DB::table('hvl_activity_master')
                ->join('hvl_customer_master','hvl_customer_master.id', '=' ,'hvl_activity_master.customer_id')
                ->join('employees','employees.id','=', 'hvl_activity_master.employee_id')
                ->join('activitytype','activitytype.id','=','hvl_activity_master.type')
                ->join('activitystatus','activitystatus.id','=','hvl_activity_master.status')
                ->select([
                    'employees.name as employee_name',
                    'hvl_customer_master.customer_name as customer_name',
                    'hvl_activity_master.subject as activity_subject',
                    'hvl_activity_master.start_date  as start_date',
                    'hvl_activity_master.end_date  as end_date',
                    'hvl_activity_master.services_value as services_value',
                    'activitytype.name as activity_type',
                    'hvl_activity_master.frequency as frequency',
                    'hvl_activity_master.created_by as created_by',
                    'hvl_activity_master.master_date as completion_date',
                    'hvl_activity_master.remark as remark'])
                ->where('hvl_activity_master.id',$activity_id)
                ->first();
            return [
                'employee_name'=>$data->employee_name,
                'customer_name'=>$data->customer_name,
                'activity_subject'=>$data->activity_subject,
                'start_date'=>$data->start_date,
                'end_date'=>$data->end_date,
                'services_value'=>$data->services_value,
                'activity_type'=> ucfirst($data->activity_type),
                'frequency'=>ucfirst($data->frequency),
                'created_by'=>ucfirst($data->created_by),
                'completion_date'=>ucfirst($data->completion_date),
                'remark'=>ucfirst($data->remark),
            ];
    }


}

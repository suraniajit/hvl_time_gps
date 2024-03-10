<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use Validator;
use DateTime;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\hvl\LeadMaster;


class DashboardController extends Controller {

    public function CountCustomerNameByCust($id) {
        return DB::table('hvl_customer_employees')
                        ->where('employee_id', '=', $id)
                        ->count();
    }

    public function getCustomerNameCust_id($id, $colume) {
        return DB::table('hvl_customer_master')
                        ->where('id', '=', $id)
                        ->value($colume);
    }

    public function graph_emp_total_customers($id) {
        $breadcrumbs = [
                ['link' => "/", 'name' => "Home"],
                ['link' => "/", 'name' => "Employee Total Customer"],
        ];
        /* Pageheader set true for breadcrumbs */
        $pageConfigs = [
            'pageHeader' => true,
            'isFabButton' => true, 'isCustomizer' => true
        ];

        $customer_employees_details = DB::table('hvl_customer_employees')
                ->where('employee_id', '=', $id)
                ->get();

        return view('hvl.dashboard.emp.index_total_customer', [
            'pageConfigs' => $pageConfigs,
            'breadcrumbs' => $breadcrumbs,
            'totalCustomer' => $this->CountCustomerNameByCust($id),
            'customer_employees_details' => $customer_employees_details,
        ]);
    }

    public function graph_emp_revenue($id) {
        $breadcrumbs = [
                ['link' => "/", 'name' => "Home"],
                ['link' => "/", 'name' => "Employee Total Revenue"],
        ];
        /* Pageheader set true for breadcrumbs */
        $pageConfigs = [
            'pageHeader' => true,
            'isFabButton' => true, 'isCustomizer' => true
        ];
        $total_revenue = $this->getRevenueByUser_id($id);

        $total_revenue_details = DB::table('hvl_lead_master')
                ->where('employee_id', '=', $id)
                ->get();

        return view('hvl.dashboard.emp.index_total_revenue', [
            'pageConfigs' => $pageConfigs,
            'breadcrumbs' => $breadcrumbs,
            'total_revenue' => $total_revenue,
            'total_revenue_details' => $total_revenue_details,
        ]);
    }

    public function index(Request $request) {
        
        $search_end_date = $request->input('end_date', date('Y-m-d'));
        $search_day_counter = $request->input('day_counter', 30);
        $search_start_date = date('Y-m-d',strtotime('-'.$search_day_counter.'day'));
        
        $em_id = Auth::User()->id;
        if (!($em_id == 1 or $em_id == 122 or $em_id == 213)) {
               return redirect('/home');
        }
        $lead_master = new LeadMaster();
        $lead_source_array = DB::table('LeadSource')->pluck('Name','id')->toArray();
        $employee_array = DB::table('employees')->pluck('Name','id')->toArray();
        
        $lead_source_wise_data =[];
        $employee_wise_lead_data =[];
        $employee_wise_revenue_data =[];
        $lead_classification_wise =[];
        $lead_graphical_wise =[];
        // --------------------------------------------------------------------------------------
        // lead source wise lead
        $lead_source_wise_db_data = 
                $lead_master
                ->select([ DB::raw('count(*) as lead_count'),'lead_source']);
                if ($search_start_date != null && $search_end_date != null) {
                    $lead_source_wise_db_data = $lead_source_wise_db_data->whereBetween('hvl_lead_master.created_at', [$search_start_date, $search_end_date]);
                }
                $lead_source_wise_db_data = $lead_source_wise_db_data->groupBy('lead_source')
                    ->get()
                    ->toArray();
        foreach( $lead_source_wise_db_data as $row){
            if(isset($lead_source_array[$row['lead_source']])){
                $lead_source_wise_data[] = 
                    [
                        'x'=>$lead_source_array[$row['lead_source']],
                        'value'=>$row['lead_count']
                    ];
            }
        }
        //$lead_source_wise_data
        // ----------------------------------------------------------------------------------
        //employee wise lead
        $lead_master = new LeadMaster();
        $employee_wise_lead_db_data = 
            $lead_master
                ->select([ DB::raw('count(*) as lead_count'),'employee_id']);
                if ($search_start_date != null && $search_end_date != null) {
                    $employee_wise_lead_db_data = $employee_wise_lead_db_data->whereBetween('hvl_lead_master.created_at', [$search_start_date, $search_end_date]);
                }
                $employee_wise_lead_db_data = $employee_wise_lead_db_data->groupBy('employee_id')
                ->get()
                ->toArray();
        foreach( $employee_wise_lead_db_data as $row){
            if(isset($employee_array[$row['employee_id']])){
                $employee_wise_lead_data [] = [
                    'x'=>$employee_array[$row['employee_id']],
                    'value'=>$row['lead_count']
                ];
            }
        }
        //$employee_wise_lead_data
        // --------------------------------------------------------------------------------------------
       
        //employee wise revenue
        $lead_master = new LeadMaster();
        $employee_wise_revenue_db_data = 
            $lead_master
                ->select([ DB::raw('SUM(revenue) as revenue_sum'),'employee_id']);
                if ($search_start_date != null && $search_end_date != null) {
                    $employee_wise_revenue_db_data = $employee_wise_revenue_db_data->whereBetween('hvl_lead_master.created_at', [$search_start_date, $search_end_date]);
                }
                $employee_wise_revenue_db_data = $employee_wise_revenue_db_data->groupBy('employee_id')
                    ->get()
                    ->toArray();
        foreach( $employee_wise_revenue_db_data as $row){
            if(isset($employee_array[$row['employee_id']])){
                $employee_wise_revenue_data[]= [
                    'x'=>$employee_array[$row['employee_id']],
                    'value'=>$row['revenue_sum'],
                ];
            }
        }
        //$employee_wise_revenue_data
        // --------------------------------------------------------------------------------------------------
        return view('hvl.dashboard.index', [
            'search_end_date'             =>  $search_end_date,
            'search_day_counter'            =>  $search_day_counter,
            'lead_source_wise_data'         =>  $lead_source_wise_data,
            'employee_wise_lead_data'       =>  $employee_wise_lead_data,
            'employee_wise_revenue_data'    =>  $employee_wise_revenue_data,
        ]);
        
    }

    public function graph_filter(Request $request) {
        $breadcrumbs = [
                ['link' => "/", 'name' => "Home"],
        ];
        /* Pageheader set true for breadcrumbs */
        $pageConfigs = [
            'pageHeader' => true,
            'isFabButton' => true, 'isCustomizer' => true
        ];
        $employee_id = $request->employee_id;
        $start_date = $request->start;
        $end_date = $request->end;
        $ddl_date = $request->ddl_date;


        $end_date = $this->date_addon($start_date, $ddl_date);

        $emp_lead_masters_table = DB::table('employees')
                ->where('Select_Department', '=', 67)
                ->select('user_id', 'id', 'Name')
                ->get();

        $leadSource_masters = DB::table('LeadSource')
                ->orderBy('Name', 'Desc')
                ->get();

        $emp_lead_masters = DB::table('employees')
                ->where('Select_Department', '=', 67)
                ->orderBy('Name', 'Desc')
                ->get();
        return view('hvl.dashboard.index', [
            'pageConfigs' => $pageConfigs,
            'start_date' => $start_date,
            'end_date' => $end_date,
            'ddl_date' => $ddl_date,
            'leadSource_masters' => $leadSource_masters,
            'emp_lead_masters' => $emp_lead_masters,
            'emp_lead_masters_table' => $emp_lead_masters_table,
            'breadcrumbs' => $breadcrumbs,
        ]);
    }

    public function date_addon($start_date, $extend_days) {
        return date('Y-m-d', strtotime($start_date . ' - ' . $extend_days . ' days'));
    }

    public function graph_emp_lead_filter(Request $request) {
        $breadcrumbs = [
                ['link' => "/", 'name' => "Home"],
        ];
        /* Pageheader set true for breadcrumbs */
        $pageConfigs = [
            'pageHeader' => true,
            'isFabButton' => true, 'isCustomizer' => true
        ];
        $mindate = $request->start;
        $maxdate = $request->end;
        $employee_id = $request->employee_id;

//        $emp = DB::table('employees')->where('user_id', '=', $em_id)->first();
//        DB::enableQueryLog(); // Enable query log

        $total_lead_details = DB::table('hvl_lead_master')
                ->where('employee_id', '=', $employee_id)
                ->whereBetween('hvl_lead_master.create_date', ["'$mindate'", "'$maxdate'"])
                ->get();
        $total_lead_chartDatas = DB::table('hvl_lead_master')
                ->where('employee_id', '=', $employee_id)
                ->whereBetween('hvl_lead_master.create_date', ["'$mindate'", "'$maxdate'"])
                ->orderBy('last_company_name', 'Desc')
                ->get();
//        DB::getQueryLog();
//        dd(DB::getQueryLog()); // Show results of log
//        dd($request->all());

        $total_lead_count = DB::table('hvl_lead_master')
                ->where('employee_id', '=', $employee_id)
                ->count();
        return view('hvl.dashboard.emp.index_total_lead', [
            'pageConfigs' => $pageConfigs, 'id' => $employee_id,
            'breadcrumbs' => $breadcrumbs,
            'mindate' => $mindate,
            'maxdate' => $maxdate,
            'total_lead_details' => $total_lead_details,
            'total_lead_chartDatas' => $total_lead_chartDatas,
            'total_lead_count' => $total_lead_count,
        ]);
    }

    public function graph_emp_lead($id) {


        $breadcrumbs = [
                ['link' => "/", 'name' => "Home"],
        ];
        /* Pageheader set true for breadcrumbs */
        $pageConfigs = [
            'pageHeader' => true,
            'isFabButton' => true, 'isCustomizer' => true
        ];

        $total_lead_details = DB::table('hvl_lead_master')
                ->where('employee_id', '=', $id)
                ->get();
        $total_lead_count = DB::table('hvl_lead_master')
                ->where('employee_id', '=', $id)
                ->count();

        $total_lead_chartDatas = DB::table('hvl_lead_master')
                ->where('employee_id', '=', $id)
                ->orderBy('last_company_name', 'asc')
                ->get();
        return view('hvl.dashboard.emp.index_total_lead', [
            'pageConfigs' => $pageConfigs,
            'id' => $id,
            'breadcrumbs' => $breadcrumbs,
            'total_lead_chartDatas' => $total_lead_chartDatas,
            'total_lead_details' => $total_lead_details,
            'total_lead_count' => $total_lead_count,
        ]);
    }

    public function getRevenueByUser_id($user_id, $mindate = null, $maxdate = null) {
//        $results = DB::select( DB::raw("SELECT * FROM some_table WHERE some_col = '$someVariable'") ); 

        $results = DB::select(DB::raw("select sum(`revenue`) as aggregate from `hvl_lead_master` where `employee_id` = $user_id and `hvl_lead_master`.`create_date` between '$mindate' and '$maxdate'"));


        $d = 0;
        if (!empty($results[0]->aggregate)) {
            $d = $results[0]->aggregate;
        } else {
            $d = 0;
        }

        return $d;
//
//        
//        $mindate = '2021-06-01';
//        $maxdate = '2021-12-01';
//        $user_id = 67;
//        $query = DB::table('hvl_lead_master1')
//                ->where('employee_id', '=', $user_id)
//                ->whereBetween('hvl_lead_master.create_date', ["'$mindate'", "'$maxdate'"])
//                ->sum('revenue');
//        return $query . ' AS';
//        return $sql = $query->enableQueryLog();
    }

    public function getLeadSourceBylead_id($lead_source_id, $mindate = null, $maxdate = null) {
//        return DB::table('hvl_lead_master')
//                        ->where('lead_source', '=', $lead_source_id)
//                        ->count();
        $results = DB::select(DB::raw("select count(*) as aggregate from `hvl_lead_master` where `lead_source` = $lead_source_id and `hvl_lead_master`.`create_date` between '$mindate' and '$maxdate'"));
//        return $results[0]->aggregate;
        $d = 0;
        if (!empty($results[0]->aggregate)) {
            $d = $results[0]->aggregate;
        } else {
//            $d = 10;
            $d = $results[0]->aggregate;
        }
        return $results[0]->aggregate;
    }

    public function getLeadByUser_id($user_id, $mindate = null, $maxdate = null) {
//        select count(*) as aggregate from `hvl_lead_master` where `employee_id` = 67 and `hvl_lead_master`.`create_date` between '2021-06-04' and '2021-12-01'
        $results = DB::select(DB::raw("select  count(*)  as aggregate from `hvl_lead_master` where `employee_id` = $user_id and `hvl_lead_master`.`create_date` between '$mindate' and '$maxdate'"));
        return $results[0]->aggregate;
//        return DB::table('hvl_lead_master1')
//                        ->where('employee_id', '=', $user_id)
//                        ->whereBetween('hvl_lead_master.create_date', ["'$maxdate'", "'$mindate'"])
//                        ->count();
    }

    public function dashboardModern() {
        return view('/pages/dashboard-modern');
    }

    public function dashboardEcommerce() {
        // navbar large
//        $pageConfigs = ['navbarLarge' => false];

        return view('hvl.activitymaster.index', [
            'details' => $activity_details,
            // 'customers' => $cutomers,
            'branchs' => $branchs,
            'statuses' => $statuses
        ]);
    }

    public function dashboardAnalytics() {
        // navbar large
        $pageConfigs = ['navbarLarge' => false];

        return view('/pages/dashboard-analytics', ['pageConfigs' => $pageConfigs]);
    }

}

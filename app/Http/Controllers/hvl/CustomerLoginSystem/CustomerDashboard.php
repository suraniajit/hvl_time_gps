<?php
namespace App\Http\Controllers\hvl\CustomerLoginSystem;
use Auth;
use App\Http\Controllers\Controller;
use App\Models\hvl\CustomersAdmin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\hvl\ActivityServiceReport;

class CustomerDashboard extends Controller {

    
    public function __construct() {
        $this->middleware('permission:Access Customer Dashboad', ['only' => ['show', 'index']]);
    }
    
    public function getDashboard(Request $request){
        $customers_admin= CustomersAdmin::where('user_id',Auth::User()->id)->first();
        if(!$customers_admin){
            echo "do something wrong";
            die;
        }
        $db_customersIds = json_decode($customers_admin->customers_id,true); 
        
        $activity_status = DB::table('activitystatus')->pluck('Name','id')->toArray();
        $customers = DB::table('hvl_customer_master')
            ->whereIn('hvl_customer_master.id',$db_customersIds)
            ->pluck('customer_name','id')->toArray();
        $branchs = DB::table('hvl_customer_master')
            ->join('Branch', 'Branch.id', '=', 'hvl_customer_master.branch_name')
            ->whereIn('hvl_customer_master.id',$db_customersIds)
            ->groupBy('Branch.id')
            ->pluck('Name','Branch.id')
            ->toArray();
        $hvl_job_cards = DB::table('hvl_job_cards')
            ->groupBy('hvl_job_cards.activity_id')
            ->orderBy('id','DESC')
            ->pluck('hvl_job_cards.added','hvl_job_cards.activity_id')
            ->toArray(); 
        $jobcardupdated = ActivityServiceReport::pluck('created_at', 'activity_id');
        
        $hvl_audit_reports = DB::table('hvl_audit_reports')
            ->groupBy('hvl_audit_reports.activity_id')
            ->orderBy('id','DESC')
            ->pluck('hvl_audit_reports.added','hvl_audit_reports.activity_id')
            ->toArray();              
       
        // get acticity
        $activities = DB::table('hvl_activity_master')
            ->select(
                [
                    'hvl_activity_master.id',
                    'hvl_activity_master.customer_id',
                    'hvl_activity_master.subject',
                    'hvl_customer_master.branch_name',
                    'hvl_activity_master.start_date',
                    'hvl_activity_master.end_date',
                    'hvl_activity_master.status',
                    'hvl_activity_master.frequency',
                    'hvl_activity_master.complete_date',
                    'hvl_activity_master.remark',
                    'hvl_activity_master.remark'
                ])  
                ->join('hvl_customer_master', 'hvl_activity_master.customer_id', '=', 'hvl_customer_master.id');
          
        $activities =  $activities->whereNotIn('hvl_activity_master.status',['5']);
        if($request->start != null &&  $request->end != null){
            $activities = $activities->whereBetween('hvl_activity_master.start_date', [$request->start, $request->end]);
        }
        //customer id based
        if($request->customer_id != null && (!empty($request->customer_id))){
            $activities = $activities->whereIn('hvl_activity_master.customer_id',$request->customer_id)->get();
        }else{
            $activities = $activities->whereIn('hvl_activity_master.customer_id',$db_customersIds)->get();
        }
        $activityStatusCounter = [];
        foreach($activities as $activity){
            if(!isset($activity_status[$activity->status])){
                continue;
            }
            if(!isset($activityStatusCounter[$activity_status[$activity->status]])){
                $activityStatusCounter[$activity_status[$activity->status]] = 1;
            }else{
                $activityStatusCounter[$activity_status[$activity->status]]++;
            }
        }
        
        return view('hvl.customer_login_system.customer_dashboard.index',[
                'hvl_audit_reports'=>$hvl_audit_reports,
                'hvl_job_cards'=>$hvl_job_cards,
                'jobcardupdated'=>$jobcardupdated,
                'activityStatusCounter'=>$activityStatusCounter,
                'activities'=>$activities,
                'activity_status'=>$activity_status,
                'customers'=>$customers,
                'branchs'=>$branchs,
                'serach_customers'=>$request->customer_id,
                'search_sdate'=>$request->start,
                'search_edate'=>$request->end,
            ]);
    }
}
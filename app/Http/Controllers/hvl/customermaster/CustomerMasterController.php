<?php
namespace App\Http\Controllers\hvl\customermaster;
use App\User;
use Auth;
use App\Http\Controllers\Controller;
use App\Models\hvl\CustomerMaster;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Imports\ImportCustomers;
use App\Imports\RemoveCustomers;
use App\Exports\ExportCustomer;
use App\Models\hvl\CustomersAdmin;
use Illuminate\Support\Facades\Mail;
use App\Mail\CustomerMasterSheetMail;
use App\Exports\CustomerMasterExport;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Excel as BaseExcel;

class CustomerMasterController extends Controller {
    public function __construct() {
        $this->middleware('permission:Access Customer', ['only' => ['show', 'index']]);
        $this->middleware('permission:Create Customer', ['only' => ['create']]);
        $this->middleware('permission:Read Customer', ['only' => ['read']]);
        $this->middleware('permission:Edit Customer', ['only' => ['edit']]);
        $this->middleware('permission:Delete Customer', ['only' => ['delete']]);
    }
    public function index(Request $request) {
       
        $mindate = $request->contract_start;
        $maxdate = $request->contract_end;
        $branch_id = $request->branch_id;
        $customer_id = $request->customer_id;

        $em_id = Auth::User()->id;
         $emp = DB::table('employees')->where('user_id', '=', $em_id)->first();
        $today_date = Carbon::today()->format('Y-m-d');
        $customerDetails = "";
        $branchs = array();
        $search_branchs_customers = [];
        if(isset($branch_id)){
            $search_branchs_customers = DB::table('hvl_customer_master')
                ->where('branch_name', $branch_id)
                ->orderby('hvl_customer_master.customer_name')
                ->pluck('customer_name','id')
                ->toArray();
        }
        

        if ($em_id == 1 or $em_id == 122) {
                $customerDetails = DB::table('hvl_customer_master')
                    ->join('Branch', 'Branch.id', '=', 'hvl_customer_master.branch_name')
                    ->join('common_states AS ship_state', 'ship_state.id', '=', 'hvl_customer_master.shipping_state')
                    ->join('common_states AS bill_state', 'bill_state.id', '=', 'hvl_customer_master.billing_state')
                    ->select('hvl_customer_master.*', 'bill_state.state_name as billing_state_name', 'ship_state.state_name as shipping_state_name', 'Branch.Name as customer_branch_name'
                );
                if(isset($mindate) && isset( $maxdate)){
                    $customerDetails =$customerDetails->whereBetween('create_date', [$mindate, $maxdate]);
                }
                if(isset($branch_id)){
                    $customerDetails = $customerDetails->where('hvl_customer_master.branch_name', $branch_id);
                }
                if(isset($customer_id)){
                    $customerDetails = $customerDetails->whereIn('hvl_customer_master.id',$customer_id);            
                }  
                $customerDetails = $customerDetails->orderBy('hvl_customer_master.id', 'DESC');
                
                if((isset($mindate) && isset( $maxdate)) || isset($branch_id) || isset($customer_id) ){
                    $customerDetails = $customerDetails->get();
                }else{
                    $customerDetails = $customerDetails->paginate(50);
                }
            $branchs = DB::table('Branch')->pluck('Name', 'Branch.id')->toArray();
        }
        else{
            if ($emp) {
               
                $customerDetails = DB::table('hvl_customer_master')
                    ->join('hvl_customer_employees', 'hvl_customer_employees.customer_id', '=', 'hvl_customer_master.id')
                    ->join('employees', 'employees.id', '=', 'hvl_customer_employees.employee_id')
                    ->join('Branch', 'Branch.id', '=', 'hvl_customer_master.branch_name')
                    ->join('common_states AS ship_state', 'ship_state.id', '=', 'hvl_customer_master.shipping_state')
                    ->join('common_states AS bill_state', 'bill_state.id', '=', 'hvl_customer_master.billing_state')
                    ->where('hvl_customer_employees.employee_id', $emp->id)
                    
                    ->select('hvl_customer_master.*', 'bill_state.state_name as billing_state_name', 'ship_state.state_name as shipping_state_name', 'Branch.Name as customer_branch_name'
                    );

                    if(isset($mindate) && isset( $maxdate)){
                        $customerDetails =$customerDetails->whereBetween('create_date', [$mindate, $maxdate]);
                    }
                    if(isset($branch_id)){
                        $customerDetails = $customerDetails->where('hvl_customer_master.branch_name', $branch_id);
                    }
                    if(isset($customer_id)){
                        $customerDetails = $customerDetails->whereIn('hvl_customer_master.id',$customer_id);            
                    } 
                    $customerDetails =$customerDetails->groupBy('hvl_customer_master.id')
                        ->groupBy('customer_name')
                        ->orderBy('hvl_customer_master.id', 'DESC')
                        ->get();
                    
                    $branchs = DB::table('hvl_customer_master')
                        ->join('hvl_customer_employees', 'hvl_customer_employees.customer_id', '=', 'hvl_customer_master.id')
                        ->join('Branch', 'Branch.id', '=', 'hvl_customer_master.branch_name')
                        ->where('hvl_customer_employees.employee_id', $emp->id)
                        ->groupBy('Name')
                        ->pluck('Name', 'Branch.id')
                        ->toArray();
            }else{
                $db_customersIds = [];
                $customers_admin = CustomersAdmin::where('user_id', Auth::User()->id)->first();
                if ($customers_admin) {
                    $db_customersIds = json_decode($customers_admin->customers_id, true);
                }
                $customerDetails = DB::table('hvl_customer_master')
                    ->join('hvl_customer_employees', 'hvl_customer_employees.customer_id', '=', 'hvl_customer_master.id')
                    ->join('employees', 'employees.id', '=', 'hvl_customer_employees.employee_id')
                    ->join('Branch', 'Branch.id', '=', 'hvl_customer_master.branch_name')
                    ->join('common_states AS ship_state', 'ship_state.id', '=', 'hvl_customer_master.shipping_state')
                    ->join('common_states AS bill_state', 'bill_state.id', '=', 'hvl_customer_master.billing_state')
                    ->whereIn('hvl_customer_master.id', $db_customersIds)
                    ->select('hvl_customer_master.*', 'bill_state.state_name as billing_state_name', 'ship_state.state_name as shipping_state_name', 'Branch.Name as customer_branch_name');
                if(isset($mindate) && isset( $maxdate)){
                    $customerDetails =$customerDetails->whereBetween('create_date', [$mindate, $maxdate]);
                }
                if(isset($branch_id)){
                    $customerDetails = $customerDetails->where('hvl_customer_master.branch_name', $branch_id);
                }
                if(isset($customer_id)){
                    $customerDetails = $customerDetails->whereIn('hvl_customer_master.id',$customer_id);            
                } 
                $customerDetails = 
                    $customerDetails
                    ->groupBy('customer_name')
                    ->orderBy('hvl_customer_master.id', 'DESC')
                    ->get();

                $branchs = DB::table('hvl_customer_master')
                        ->join('Branch', 'Branch.id', '=', 'hvl_customer_master.branch_name')
                        ->whereIn('hvl_customer_master.id', $db_customersIds)
                        ->groupBy('Branch.id')
                        ->pluck('Name', 'Branch.id')
                        ->toArray();
                
            }
        }
       
        return view('hvl.customermaster.index', [
            'customerDetails' => $customerDetails,
            'branchs' => $branchs,
            'search__sdate'=>$request->contract_start,
            'search__edate'=>$request->contract_end,
            'search_branch'=>$request->branch_id,
            'search_customer'=>$request->customer_id,
            'search_branchs_customers'=> $search_branchs_customers,
        ]);
    }
    public function create() {
        $pageConfigs = ['pageHeader' => true, 'isFabButton' => true, 'isCustomizer' => true];
        $breadcrumbs = [
                ['link' => "hvl", 'name' => "Home"],
                ['link' => "/customer-master/", 'name' => "Customer Master"],
                ['link' => "/customer-master/create", 'name' => "Create"],
        ];
        $state = DB::table('common_states')->where('country_id', '=', 1)->get();
        $employees = DB::table('employees')->get();
        $branch = DB::table('Branch')->get();
        
        return view('hvl.customermaster.create', [
            'pageConfigs' => $pageConfigs,
            'breadcrumbs' => $breadcrumbs,
            'states' => $state,
            'employees' => $employees,
            'branchs' => $branch
        ]);
    }
    public function store(Request $request) {
        
        $customer_id = CustomerMaster::insertGetId([
                    'customer_code' => $request->customer_code,
                    'customer_name' => $request->customer_name,
                    'customer_alias' => $request->customer_alias,
                    'billing_address' => $request->billing_address,
                    'billing_state' => $request->billing_state,
                    'billing_city' => $request->billing_city,
                    'billing_pincode' => $request->billing_pincode,
                    
                    'billing_location' => $request->billing_location,
                    'billing_latitude' => $request->billing_latitude,
                    'billing_longitude' => $request->billing_longitude,
                    

                    'contact_person' => $request->contact_person,
                    'contact_person_phone' => $request->contact_person_phone,
                    'billing_email' => $request->billing_mail,
                    'billing_mobile' => $request->billing_mobile,
                    'operator'=>$request->operator,
                    'operation_executive'=>$request->operation_executive,
                    'sales_person' => $request->sales_person,
                    'reference' => $request->reference,
                    'status' => $request->is_active,
                    'create_date' => $request->create_date,
                    'shipping_address' => $request->shipping_adress,
                    'shipping_state' => $request->shipping_state,
                    'shipping_city' => $request->shipping_city,
                    'shipping_pincode' => $request->shipping_pincode,
                    'credit_limit' => $request->credit_limit,
                    'gst_reges_type' => $request->gst_reges_type,
                    'gstin' => $request->gstin,
                    'branch_name' => $request->branch,
                    'payment_mode' => $request->payment_mode,
                    'con_start_date' => $request->con_start_date,
                    'con_end_date' => $request->con_end_date,
                    'cust_value' => $request->cust_value,
                    'is_active' => $request->is_active
        ]);
        foreach ($request->employee_id as $employee) {
            DB::table('hvl_customer_employees')
                    ->insert([
                        'customer_id' => $customer_id,
                        'employee_id' => $employee
            ]);
        }
        return redirect('/customer-master')->with('success', 'Customer Record Has Been Inserted');
    }
    public function edit($id) {
        
        $pageConfigs = ['pageHeader' => true, 'isFabButton' => true, 'isCustomizer' => true];
        $breadcrumbs = [
                ['link' => "hvl", 'name' => "Home"],
                ['link' => "/customer-master/", 'name' => "Customer Master"],
                ['link' => "/customer-master/edit/" . $id, 'name' => "Update"],
        ];
        $details = CustomerMaster::whereId($id)->first();
        $customer_employees = DB::table('hvl_customer_employees')
                ->where('hvl_customer_employees.customer_id', '=', $id)
                ->pluck('hvl_customer_employees.employee_id')
                ->all();
        $state = DB::table('common_states')->where('country_id', '=', 1)->get();
        $billing_citys = DB::table('common_cities')->where('state_id', '=', $details->billing_state)->get();
        $shipping_citys = DB::table('common_cities')->where('state_id', '=', $details->shipping_state)->get();
        $employees = DB::table('employees')->get();
        $branch = DB::table('Branch')->get();
        return view('hvl.customermaster.edit', [
            'pageConfigs' => $pageConfigs,
            'breadcrumbs' => $breadcrumbs,
            'details' => $details,
            'customer_employees' => $customer_employees,
            'states' => $state,
            'employees' => $employees,
            'branchs' => $branch,
            'billing_cities' => $billing_citys,
            'shipping_cities' => $shipping_citys,
        ]);
    }
    public function update(Request $request, $id) {
        $already_inactive_modal = new CustomerMaster();
        $already_inactive_modal = $already_inactive_modal->whereId($id)->first();
        $already_inactive = false;
        if($already_inactive_modal){
            $already_inactive = ($already_inactive_modal->is_active==1)?true:false;
        }
        $post_data =[
            'employee_id' => $request->employee_id,
            'customer_code' => $request->customer_code,
            'customer_name' => $request->customer_name,
            'customer_alias' => $request->customer_alias,
            'billing_address' => $request->billing_address,
            'billing_state' => $request->billing_state,
            'billing_city' => $request->billing_city,
            'billing_pincode' => $request->billing_pincode,

            'billing_location' => $request->billing_location,
            'billing_latitude' => $request->billing_latitude,
            'billing_longitude' => $request->billing_longitude,
                    


            'contact_person' => $request->contact_person,
            'contact_person_phone' => $request->contact_person_phone,
            'billing_email' => $request->billing_mail,
            'billing_mobile' => $request->billing_mobile,
            'operator'=>$request->operator,
            'operation_executive'=>$request->operation_executive,
            'sales_person' => $request->sales_person,
            'reference' => $request->reference,
            'status' => $request->is_active,
            // 'create_date' => $request->create_date,
            'shipping_address' => $request->shipping_adress,
            'shipping_state' => $request->shipping_state,
            'shipping_city' => $request->shipping_city,
            'shipping_pincode' => $request->shipping_pincode,
            'credit_limit' => $request->credit_limit,
            'gst_reges_type' => $request->gst_reges_type,
            'gstin' => $request->gstin,
            'branch_name' => $request->branch,
            'payment_mode' => $request->payment_mode,
            'con_start_date' => $request->con_start_date,
            'con_end_date' => $request->con_end_date,
            'cust_value' => $request->cust_value,
            'is_active' => $request->is_active,
            'inactive_remark'=>($request->is_active==1)?$request->inactive_remark:''
        ];
        if($request->is_active==1 && $already_inactive == false){
             $post_data['inactive_date'] = date('Y-m-d');
        }
        CustomerMaster::whereId($id)->update($post_data);
        if($request->is_active){
            DB::table('hvl_activity_master')
            ->where('customer_id',$id)
            ->whereRaw("`start_date` >= '". date('Y-m-d H:i:s')."'")
            ->delete();
        }
        DB::table('hvl_customer_employees')->where('customer_id', $id)->delete();
        foreach ($request->employee_id as $employee) {
            DB::table('hvl_customer_employees')
                    ->insert([
                        'customer_id' => $id,
                        'employee_id' => $employee
            ]);
        }
        return redirect('/customer-master')->with('success', 'Customer Record Has Been Updated');
    }
    function removedata(Request $request) {
        $Lead_delete = CustomerMaster::whereId($request->input('id'))->first();
        $data = DB::table('hvl_activity_master')->where('customer_id', $Lead_delete->id)->get();
        if (count($data) > 0) {
            return response('error');
        } else {
            $Lead_delete->forceDelete();
        }
    }
    function massremove(Request $request) {
        $Status_ids = $request->input('ids');
        foreach ($Status_ids as $id) {
            $Status_Multi_Delete = CustomerMaster::whereId($id)->first();
            $data = DB::table('hvl_activity_master')->where('customer_id', $Status_Multi_Delete->id)->get();
            if (count($data) > 0) {
                return response('error');
            } else {
                $Status_Multi_Delete->forceDelete();
            }
        }
    }
    public function import_customer(Request $request) {
        $request->validate([
            'import_file' => 'required'
        ]);
        Excel::import(new ImportCustomers, request()->file('import_file'));
        return redirect('/customer-master')->with('success', 'Data imported successfully.');
    }
    public function add_contract(Request $request) {
        $round = rand(00001, 99999);
        $customer_id = $request->customer_id;
        if (!empty($request->file('contract'))) {
            foreach ($request->file('contract') as $before) {
                $path = 'public/uploads/customercontract/';
                $before_pic = $before->getClientOriginalName();
                $before_file = $before_pic;
                $before->move($path, $before_file);
                DB::table('hvl_customer_contract')->insert([
                    'customer_id' => $customer_id,
                    'contract' => $before_file,
                    'type' => $before->getClientOriginalExtension(),
                    'path' => $path
                ]);
            }
            DB::table('hvl_customer_master')
                    ->whereId($customer_id)
                    ->update(['contract' => 1]);
        }
        return redirect('/customer-master')->with('success', 'Customer Contract Added Successfully');
    }
    public function edit_contract(Request $request) {
        $round = rand(00001, 99999);
        $customer_id = $request->customer_id;
        if (!empty($request->file('contract'))) {
            foreach ($request->file('contract') as $before) {
                $path = 'public/uploads/customercontract/';
                $before_pic = $before->getClientOriginalName();
                $before_file = $before_pic;
                $before->move($path, $before_file);
                DB::table('hvl_customer_contract')->insert([
                    'customer_id' => $customer_id,
                    'contract' => $before_file,
                    'type' => $before->getClientOriginalExtension(),
                    'path' => $path
                ]);
            }
            DB::table('hvl_customer_master')
                    ->whereId($customer_id)
                    ->update(['contract' => 1]);
        }
        return redirect('/customer-master/show/' . $customer_id)->with('success', 'Customer Contract Added Successfully');
    }
    public function delete_contract(Request $request) {
        DB::table('hvl_customer_contract')->whereId($request->id)->delete();
    }
    public function show($id) {
        $pageConfigs = ['pageHeader' => true, 'isFabButton' => true, 'isCustomizer' => true];
        $breadcrumbs = [
                ['link' => "hvl", 'name' => "Home"],
                ['link' => "/customer-master/", 'name' => "Customer Master"],
                ['link' => "/customer-master/edit/" . $id, 'name' => "Update"],
        ];
        $details = CustomerMaster::whereId($id)->first();
        $customer_employees = DB::table('hvl_customer_employees')
                ->join('hvl_customer_master', 'hvl_customer_master.id', '=', 'hvl_customer_employees.customer_id')
                ->where('hvl_customer_master.id', '=', $id)
                ->pluck('hvl_customer_employees.employee_id')
                ->all();
        $contracts = DB::table('hvl_customer_contract')->where('customer_id', $id)->get();
        $state = DB::table('common_states')->where('country_id', '=', 1)->get();
        $billing_citys = DB::table('common_cities')->where('state_id', '=', $details->billing_state)->get();
        $shipping_citys = DB::table('common_cities')->where('state_id', '=', $details->shipping_state)->get();
        $employees = DB::table('employees')->get();
        $branch = DB::table('Branch')->get();
        return view('hvl.customermaster.view', [
            'pageConfigs' => $pageConfigs,
            'breadcrumbs' => $breadcrumbs,
            'details' => $details,
            'states' => $state,
            'customer_employees' => $customer_employees,
            'employees' => $employees,
            'branchs' => $branch,
            'billing_cities' => $billing_citys,
            'shipping_cities' => $shipping_citys,
            'contracts' => $contracts
        ]);
    }
    public function get_customer(Request $request) {
        $id = $request->eids;
        $em_id = Auth::User()->id;
        $emp = DB::table('employees')->where('user_id', '=', $em_id)->first();
        if ($em_id == 1 or $em_id == 122) {
            $custdetails = DB::table('hvl_customer_master')
                    ->where('branch_name', $id)
                    ->select('hvl_customer_master.customer_name')
                    ->orderby('hvl_customer_master.customer_name')
                    ->get()
                    ->groupBy('customer_name');
        } else {
            $custdetails = DB::table('hvl_customer_master')
                    ->join('hvl_customer_employees', 'hvl_customer_employees.customer_id', '=', 'hvl_customer_master.id')
                    ->where('hvl_customer_master.branch_name', $id)
                    ->where('hvl_customer_employees.employee_id', $emp->id)
                    ->select('hvl_customer_master.customer_name')
                    ->get()
                    ->groupBy('customer_name');
        }
        return response()->json($custdetails);
    }
    public function delete_customer() {
        return view('hvl.customermaster.bulk_remove');
    }
    public function bulk_remove_customer(Request $request) {
        $request->validate([
            'upload_file' => 'required'
        ]);
        Excel::import(new RemoveCustomers, request()->file('upload_file'));
        return redirect('/customer-master')->with('success', 'Data Removed successfully.');
    }
    
    public function view_activity($id) {
        $customer_options =array();
        $activity_details = DB::table('hvl_activity_master')
        ->select('hvl_activity_master.*', 'hvl_customer_master.branch_name')
        ->join('hvl_customer_master', 'hvl_customer_master.id', '=', 'hvl_activity_master.customer_id');
        
        $activity_details = $activity_details->where('hvl_activity_master.customer_id',$id);
        $activity_details = $activity_details->orderBy('hvl_activity_master.id', 'DESC');
        $activity_details=$activity_details->get();
      

        $em_id = Auth::User()->id;
        $emp = DB::table('employees')
                ->where('user_id', '=', $em_id)
                ->first();
        $branchs = DB::table('hvl_customer_master')
                ->join('Branch', 'Branch.id', '=', 'hvl_customer_master.branch_name')
                ->where('hvl_customer_master.id',$id)
                ->groupBy('Branch.id')
                ->pluck('Name','Branch.id')
                ->toArray();               
        
        $customers = DB::table('hvl_customer_master')
            ->where('hvl_customer_master.id',$id)
            ->pluck('customer_name','id')->toArray();

        $customer_code = DB::table('hvl_customer_master')
            ->whereIn('hvl_customer_master.id',array_keys($customers))
            ->pluck('customer_code', 'id')->toArray();

        $hvl_job_cards = DB::table('hvl_job_cards')
            ->groupBy('hvl_job_cards.activity_id')
            ->orderBy('id','DESC')
            ->pluck('hvl_job_cards.added','hvl_job_cards.activity_id')
            ->toArray(); 
            
        $hvl_audit_reports = DB::table('hvl_audit_reports')
            ->groupBy('hvl_audit_reports.activity_id')
            ->orderBy('id','DESC')
            ->pluck('hvl_audit_reports.added','hvl_audit_reports.activity_id')
            ->toArray(); 
    
        $activity_status = DB::table('activitystatus')->pluck('Name','id')->toArray();
        
        
          $relaince_form_pest_control_activity =[
            "Pest control activity : First Week (RM/FM)",
            "Pest control activity : Second  Week (RM/FM)",
            "Pest control activity : Third Week (RM/FM)",
            "Pest control activity : Fourth Week (RM/FM)",
            "Pest control activity : Cockroach Management"
        ];
        $relaince_form_activity_details =[
            "Total new glue pads placed for rodents in Store",
            "Number of glue pads replaced",
            "Number of rodent catches",
            "Number of new fly ribbons placed in the Store",
            "Number of fly ribbons replaced",
            "Number of rodent alarms for the Store",
            "Store dump (in Rupees) due to rodent menace  (Write only if the same is shown to the Pest Control Contractor)",
        ];
        $month_week_list =[
            "week_1",
            "week_2",
            "week_3",
            "week_4"
        ];
        $pest_controller_service =[
            97=>"fly_management",
            98=>"rodent_management",
            99=>"cockroach_management",
            100=>"lizard_management",
            101=>"honey_bee/seasonal_flies",
            102=>"",
            103=>"",
            104=>"",
        ];
        $months = [
            'jan'=>'January',
            'feb'=>'February',
            'mar'=>'March',
            'apr'=>'April',
            'may'=>'May',
            'jun'=>'June',
            'jul'=>'July',
            'aug'=>'August',
            'sep'=>'September',
            'oct'=>'October',
            'nov'=>'November',
            'dec'=>'December'
        ];

       
        
        return view('hvl.activitymaster.index', [
            'em_id'=>$em_id,
            'details' => $activity_details,
            'customers'=>$customers,
            'customer_code'=>$customer_code,
            'customer_options'=>$customer_options,
            'branchs' => $branchs,
            'status'=>$activity_status,
            'hvl_job_cards'=>$hvl_job_cards,
            'hvl_audit_reports'=>$hvl_audit_reports,
            'search_branch'=> null,
            'search_sdate'=>null,
            'search_edate'=>null,
            'search_status_id'=>[],
            'search_customer_ids'=>[$id],   
            'first_form_activity_list'=>$relaince_form_pest_control_activity,
            'relaince_form_activity_details'=>$relaince_form_activity_details,
            'month_week_list'=>$month_week_list,
            'pest_controller_service'=>$pest_controller_service,
            'months'=>$months,
            'frequency_option'=>$this->getFrequencyOption(),
        ]);
    }
    public function export_all_customer() {
        return (new ExportCustomer)->download('AllCustomer.xlsx');
    }
    public function getDownloadCustomers(Request $request){
        $file_name= date('Y_m_d_h_i_s')."customer_master.xlsx";
        Excel::store(new CustomerMasterExport($request->all()), '/public/temp/'.$file_name);
        return redirect()->to( asset('public/storage/temp/'.$file_name));
        
        // return Excel::download(new CustomerMasterExport($request->all()), $file_name); 
    }
    
    public function sendCustomerExcelSheet(Request $request){
        $attachment = Excel::raw(
            new CustomerMasterExport($request->all()), 
            BaseExcel::CSV
        );
        $message = Mail::to($request->to);
        if (isset($request->cc)){
            $message->cc($request->cc);
        }
        if (isset($request->bcc)){
            $message->bcc($request->bcc);
        }
         $message->send(new CustomerMasterSheetMail($attachment, $request->subject, $request->body));
        return redirect('/customer-master')->with('success', 'Email Sent successfully.');
    }
  public function getFrequencyOption(){
        return [
            "daily"         =>  "Daily",
            "weekly"        =>  "Weekly",
            "weekly_twice"  =>  "Weekly Twice",
            "weekly_thrice" =>  "Weekly Thrice",
            "fortnightly"   =>  "Fortnightly",
            "monthly"       =>  "Monthly",
            "monthly_thrice"=>  "Monthly Thrice ",
            "bimonthly"     =>  "Bimonthly",
            "quarterly"     =>  "Quarterly",
            "quarterly_twice"=> "Quarterly twice",
            "thrice_year"   =>  "Thrice in a Year",
            "onetime"       =>  "One Time",
        ];
    }

}

<?php
namespace App\Http\Controllers\hvl\leadmaster;
use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\hvl\LeadMaster;
use App\Models\hvl\CustomerMaster;
use App\Imports\ImportLeads;
class LeadMasterController extends Controller {
    public function __construct() {
        $this->middleware('permission:Access leads', ['only' => ['show', 'index']]);
        $this->middleware('permission:Create leads', ['only' => ['create']]);
        $this->middleware('permission:Read leads', ['only' => ['read']]);
        $this->middleware('permission:Edit leads', ['only' => ['edit']]);
        $this->middleware('permission:Delete leads', ['only' => ['delete']]);
    }
    public function index() {
        $em_id = Auth::User()->id;
        $emp = DB::table('employees')->where('user_id', '=', $em_id)->first();
        if ($em_id == 1 or $em_id == 122 or $em_id == 213) {
            $leadDetails = DB::table('hvl_lead_master')
                    ->join('employees AS emp', 'emp.id', '=', 'hvl_lead_master.employee_id')
                    ->join('employees AS owner', 'owner.id', '=', 'hvl_lead_master.owner')
                    ->leftJoin('CompanyType', 'CompanyType.id', '=', 'hvl_lead_master.company_type')
                    ->leftJoin('LeadStatus', 'LeadStatus.id', '=', 'hvl_lead_master.status')
                    ->Join('LeadSource', 'LeadSource.id', '=', 'hvl_lead_master.lead_source')
                    ->leftJoin('Rating', 'Rating.id', '=', 'hvl_lead_master.rating')
                    ->leftJoin('Industry', 'Industry.id', '=', 'hvl_lead_master.industry')
                    ->select('emp.Name as emp_name', 'owner.Name as owner_name', 'LeadSource.Name as lead_name', 'CompanyType.Name as company_type_name', 'LeadStatus.Name as lead_status', 'Rating.Name as rating_name', 'Industry.Name as industry_name', 'hvl_lead_master.*')
                    ->where('hvl_lead_master.flag', '=', 0)
                    ->orderBy('hvl_lead_master.id', 'DESC')
                     ->orderBy('hvl_lead_master.id', 'DESC')
                    // ->paginate(50);
                    ->get();
            // ->paginate(100);
        } else {
            $leadDetails = DB::table('hvl_lead_master')
                    ->join('employees AS emp', 'emp.id', '=', 'hvl_lead_master.employee_id')
                    ->join('employees AS owner', 'owner.id', '=', 'hvl_lead_master.owner')
                    ->leftJoin('CompanyType', 'CompanyType.id', '=', 'hvl_lead_master.company_type')
                    ->leftJoin('LeadStatus', 'LeadStatus.id', '=', 'hvl_lead_master.status')
                    ->Join('LeadSource', 'LeadSource.id', '=', 'hvl_lead_master.lead_source')
                    ->leftJoin('Rating', 'Rating.id', '=', 'hvl_lead_master.rating')
                    ->leftJoin('Industry', 'Industry.id', '=', 'hvl_lead_master.industry')
                    ->select('emp.Name as emp_name', 'owner.Name as owner_name', 'LeadSource.Name as lead_name', 'CompanyType.Name as company_type_name', 'LeadStatus.Name as lead_status', 'Rating.Name as rating_name', 'Industry.Name as industry_name', 'hvl_lead_master.*')
                    ->where('hvl_lead_master.employee_id', '=', $emp->id)
                    ->where('hvl_lead_master.flag', '=', 0)
                    ->orderBy('hvl_lead_master.id', 'DESC')
                    ->get();
        }
        return view('hvl.leadmaster.index', [
            'leadDetails' => $leadDetails
        ]);
    }
    public function date_wise_lead(Request $request) {
        $mindate = $request->start;
        $maxdate = $request->end;
        $em_id = Auth::User()->id;
        $emp = DB::table('employees')->where('user_id', '=', $em_id)->first();
        if ($em_id == 1 or $em_id == 122) {
            $leadDetails = DB::table('hvl_lead_master')
                    ->join('employees AS emp', 'emp.id', '=', 'hvl_lead_master.employee_id')
                    ->join('employees AS owner', 'owner.id', '=', 'hvl_lead_master.owner')
                    ->leftJoin('CompanyType', 'CompanyType.id', '=', 'hvl_lead_master.company_type')
                    ->leftJoin('LeadStatus', 'LeadStatus.id', '=', 'hvl_lead_master.status')
                    ->Join('LeadSource', 'LeadSource.id', '=', 'hvl_lead_master.lead_source')
                    ->leftJoin('Rating', 'Rating.id', '=', 'hvl_lead_master.rating')
                    ->leftJoin('Industry', 'Industry.id', '=', 'hvl_lead_master.industry')
                    ->select('emp.Name as emp_name', 'owner.Name as owner_name', 'LeadSource.Name as lead_name', 'CompanyType.Name as company_type_name', 'LeadStatus.Name as lead_status', 'Rating.Name as rating_name', 'Industry.Name as industry_name', 'hvl_lead_master.*')
                    ->where('hvl_lead_master.flag', '=', 0)
                    ->whereBetween('hvl_lead_master.create_date', [$mindate, $maxdate])
                    ->orderBy('hvl_lead_master.id', 'DESC')
                    ->get();
            // ->paginate(100);
        } else {
            $leadDetails = DB::table('hvl_lead_master')
                    ->join('employees AS emp', 'emp.id', '=', 'hvl_lead_master.employee_id')
                    ->join('employees AS owner', 'owner.id', '=', 'hvl_lead_master.owner')
                    ->leftJoin('CompanyType', 'CompanyType.id', '=', 'hvl_lead_master.company_type')
                    ->leftJoin('LeadStatus', 'LeadStatus.id', '=', 'hvl_lead_master.status')
                    ->Join('LeadSource', 'LeadSource.id', '=', 'hvl_lead_master.lead_source')
                    ->leftJoin('Rating', 'Rating.id', '=', 'hvl_lead_master.rating')
                    ->leftJoin('Industry', 'Industry.id', '=', 'hvl_lead_master.industry')
                    ->select('emp.Name as emp_name', 'owner.Name as owner_name', 'LeadSource.Name as lead_name', 'CompanyType.Name as company_type_name', 'LeadStatus.Name as lead_status', 'Rating.Name as rating_name', 'Industry.Name as industry_name', 'hvl_lead_master.*')
                    ->where('hvl_lead_master.employee_id', '=', $emp->id)
                    ->whereBetween('hvl_lead_master.create_date', [$mindate, $maxdate])
                    ->where('hvl_lead_master.flag', '=', 0)
                    ->orderBy('hvl_lead_master.id', 'DESC')
                    ->get();
        }
        return view('hvl.leadmaster.index', [
            'leadDetails' => $leadDetails
        ]);
    }
    public function create() {
        $pageConfigs = ['pageHeader' => true, 'isFabButton' => true, 'isCustomizer' => true];
        $breadcrumbs = [
                ['link' => "hvl", 'name' => "Home"],
                ['link' => "/lead-master/", 'name' => "Lead Master"],
                ['link' => "/lead-master/create", 'name' => "Create"],
        ];
        $company_type = DB::table('CompanyType')->get();
        $industry = DB::table('Industry')->get();
        $status = DB::table('LeadStatus')->get();
        $rating = DB::table('Rating')->get();
        $employees = DB::table('employees')->get();
        $leadsource = DB::table('LeadSource')->get();
        return view('hvl.leadmaster.create', [
            'pageConfigs' => $pageConfigs,
            'breadcrumbs' => $breadcrumbs,
            'company_types' => $company_type,
            'industrys' => $industry,
            'statuses' => $status,
            'ratings' => $rating,
            'employees' => $employees,
            'leadsources' => $leadsource
        ]);
    }
    public function store(Request $request) {
        LeadMaster::create([
            'company_type' => $request->company_type,
            'last_company_name' => $request->compnay_name,
            'f_name' => $request->f_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'employee_id' => $request->employee,
            'owner' => $request->owner,
            'create_date' => $request->create_date,
            'follow_date' => $request->follow_date,
            'status' => $request->status,
            'rating' => $request->rating,
            'lead_source' => $request->lead_source,
            'industry' => $request->industry,
            'address' => $request->address,
            'comment' => $request->comment,
            'credit_value' => $request->value,
            'revenue' => $request->revenue,
            'is_active' => $request->is_active,
        ]);
        return redirect('/lead-master')->with('success', 'Record Has Been Inserted');
    }
    public function edit($id) {
        $pageConfigs = ['pageHeader' => true, 'isFabButton' => true, 'isCustomizer' => true];
        $breadcrumbs = [
                ['link' => "hvl", 'name' => "Home"],
                ['link' => "/lead-master/", 'name' => "Lead Master"],
                ['link' => "/lead-master/edit/" . $id, 'name' => "Update"],
        ];
        $details = LeadMaster::whereId($id)->first();
        $company_type = DB::table('CompanyType')->get();
        $industry = DB::table('Industry')->get();
        $status = DB::table('LeadStatus')->get();
        $rating = DB::table('Rating')->get();
        $employees = DB::table('employees')->get();
        $leadsource = DB::table('LeadSource')->get();
        return view('hvl.leadmaster.edit', [
            'pageConfigs' => $pageConfigs,
            'breadcrumbs' => $breadcrumbs,
            'company_types' => $company_type,
            'industrys' => $industry,
            'statuses' => $status,
            'ratings' => $rating,
            'employees' => $employees,
            'details' => $details,
            'leadsources' => $leadsource
        ]);
    }
    public function update(Request $request, $id) {
        LeadMaster::whereId($id)
                ->update([
                    'company_type' => $request->company_type,
                    'last_company_name' => $request->compnay_name,
                    'f_name' => $request->f_name,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'employee_id' => $request->employee,
                    'owner' => $request->owner,
                    'create_date' => $request->create_date,
                    'follow_date' => $request->follow_date,
                    'status' => $request->status,
                    'rating' => $request->rating,
                    'lead_source' => $request->lead_source,
                    'industry' => $request->industry,
                    'address' => $request->address,
                    'comment' => $request->comment,
                    'credit_value' => $request->value,
                    'revenue' => $request->revenue,
                    'is_active' => $request->is_active,
        ]);
        return redirect('/lead-master')->with('success', 'Record Has Been Updated');
    }
    function removedata(Request $request) {
        $Lead_delete = LeadMaster::whereId($request->input('id'))->first();
        $Lead_delete->forceDelete();
    }
    function massremove(Request $request) {
        $Status_ids = $request->input('ids');
        foreach ($Status_ids as $id) {
            $Status_Multi_Delete = LeadMaster::whereId($id)->first();
            $Status_Multi_Delete->forceDelete();
        }
    }
    public function add_toCustomer($id) {
        $pageConfigs = ['pageHeader' => true, 'isFabButton' => true, 'isCustomizer' => true];
        $breadcrumbs = [
                ['link' => "hvl", 'name' => "Home"],
                ['name' => "Create Customer"],
        ];
        $details = LeadMaster::whereId($id)->first();
        $customer_id = CustomerMaster::insertGetId([
                    'customer_name' => $details->f_name,
                    'customer_alias' => $details->last_company_name,
                    'billing_address' => $details->address,
                    'contact_person' => $details->f_name,
                    'contact_person_phone' => $details->phone,
                    'billing_email' => $details->email,
                    'billing_mobile' => $details->phone,
                    'sales_person' => $details->employee_id,
//                'status' => $details->status,
                    'create_date' => $details->create_date,
                    'shipping_address' => $details->address,
        ]);
        $customer_details = CustomerMaster::whereId($customer_id)->first();
        $state = DB::table('common_states')->where('country_id', '=', 1)->get();
        $employees = DB::table('employees')->get();
        $branch = DB::table('Branch')->get();
        return view('hvl.customermaster.fromLead', [
            'pageConfigs' => $pageConfigs,
            'breadcrumbs' => $breadcrumbs,
            'details' => $customer_details,
            'states' => $state,
            'employees' => $employees,
            'branchs' => $branch,
            'lead_id' => $id
        ]);
    }
    public function update_toCustomer(Request $request, $id) {
        DB::table('hvl_customer_master')->whereId($id)
                ->update([
//                    'employee_id' => $request->employee_id,
                    'customer_code' => $request->customer_code,
                    'customer_name' => $request->customer_name,
                    'customer_alias' => $request->customer_alias,
                    'billing_address' => $request->billing_address,
                    'billing_state' => $request->billing_state,
                    'billing_city' => $request->billing_city,
                    'billing_pincode' => $request->billing_pincode,
                    'contact_person' => $request->contact_person,
                    'contact_person_phone' => $request->contact_person_phone,
                    'billing_email' => $request->billing_mail,
                    'billing_mobile' => $request->billing_mobile,
                    'sales_person' => $request->sales_person,
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
//                    'is_active' => $request->is_active
        ]);
        foreach ($request->employee_id as $employee) {
            DB::table('hvl_customer_employees')
                    ->insert([
                        'customer_id' => $id,
                        'employee_id' => $employee
            ]);
        }
        LeadMaster::whereId($request->lead_id)->update(['flag' => 1]);
        return redirect('/customer-master')->with('success', 'Record Has Been Updated');
    }
    public function import_lead(Request $request) {
        $request->validate([
            'import_file' => 'required'
        ]);
        Excel::import(new ImportLeads, request()->file('import_file'));
        return redirect('/lead-master')->with('success', 'Data imported successfully.');
    }
    public function show($id) {
        $details = LeadMaster::whereId($id)->first();
        $company_type = DB::table('CompanyType')->get();
        $industry = DB::table('Industry')->get();
        $status = DB::table('LeadStatus')->get();
        $rating = DB::table('Rating')->get();
        $employees = DB::table('employees')->get();
        $leadsource = DB::table('LeadSource')->get();
        return view('hvl.leadmaster.view', [
            'company_types' => $company_type,
            'industrys' => $industry,
            'statuses' => $status,
            'ratings' => $rating,
            'employees' => $employees,
            'details' => $details,
            'leadsources' => $leadsource
        ]);
    }
}
//public function index()
//{
//    $url = "http://localhost:8081/get/users";
//
//    $options = array(
//        CURLOPT_RETURNTRANSFER => true,   // return web page
//        CURLOPT_HEADER => false,  // don't return headers
//        CURLOPT_FOLLOWLOCATION => true,   // follow redirects
//        CURLOPT_MAXREDIRS => 10,     // stop after 10 redirects
//        CURLOPT_ENCODING => "",     // handle compressed
//        CURLOPT_USERAGENT => "test", // name of client
//        CURLOPT_AUTOREFERER => true,   // set referrer on redirect
//        CURLOPT_CONNECTTIMEOUT => 120,    // time-out on connect
//        CURLOPT_TIMEOUT => 120,    // time-out on response
//    );
//
//    $ch = curl_init($url);
//    curl_setopt_array($ch, $options);
//
//    $content = curl_exec($ch);
//    dd($content);
//    curl_close($ch);
//
//    return view('demoapi.index');
//}
//public function api_request(Request $request)
//{
//
//    $url = "http://localhost:8081/get/users";
//
//    $options = array(
//        CURLOPT_RETURNTRANSFER => true,   // return web page
//        CURLOPT_HEADER => false,  // don't return headers
//        CURLOPT_FOLLOWLOCATION => true,   // follow redirects
//        CURLOPT_MAXREDIRS => 10,     // stop after 10 redirects
//        CURLOPT_ENCODING => "",     // handle compressed
//        CURLOPT_USERAGENT => "test", // name of client
//        CURLOPT_AUTOREFERER => true,   // set referrer on redirect
//        CURLOPT_CONNECTTIMEOUT => 120,    // time-out on connect
//        CURLOPT_TIMEOUT => 120,    // time-out on response
//    );
//
//    $ch = curl_init($url);
//    curl_setopt_array($ch, $options);
//
//    $content = curl_exec($ch);
//    dd($content);
//    curl_close($ch);
//
//    $response = json_decode($content);
//}

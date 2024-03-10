<?php
namespace App\Http\Controllers\hvl\leadmaster;
use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\hvl\LeadMaster;
use App\Models\hvl\LeadProposal;
use App\Models\hvl\CustomerMaster;
use App\Imports\ImportLeads;
use App\Http\Requests\StoreProposal;
use App\Exports\LeadMasterExport;
use Illuminate\Support\Facades\Mail;
use App\Mail\LeadMasterSheetMail;
use Maatwebsite\Excel\Excel as BaseExcel;

class LeadMasterController extends Controller {
    public function __construct() {
        $this->middleware('permission:Access leads', ['only' => ['show', 'index']]);
        $this->middleware('permission:Create leads', ['only' => ['create']]);
        $this->middleware('permission:Read leads', ['only' => ['read']]);
        $this->middleware('permission:Edit leads', ['only' => ['edit']]);
        $this->middleware('permission:Delete leads', ['only' => ['delete']]);
    }
    public function index(Request $request) {
        $latest_lead_proposal = $this->getLeadlatestProposal();
        $em_id = Auth::User()->id;
        $lead_master = new LeadMaster();
        $lead_sizes = $lead_master->getLeadSizeOption();
        $search_start_date     =   $request->start;
        $search_end_date       =   $request->end;
        $search_status         =   $request->status_id;
        $status = DB::table('LeadStatus')->pluck('Name','id')->toArray();
         if(!isset($search_status)){
            $search_status=[];
        }
        $emp = DB::table('employees')->where('user_id', '=', $em_id)->first();
         $leadDetails = DB::table('hvl_lead_master')
            ->leftJoin('employees AS emp', 'emp.id', '=', 'hvl_lead_master.employee_id')
            ->leftJoin('employees AS owner', 'owner.id', '=', 'hvl_lead_master.owner')
            ->leftJoin('CompanyType', 'CompanyType.id', '=', 'hvl_lead_master.company_type')
            ->leftJoin('LeadStatus', 'LeadStatus.id', '=', 'hvl_lead_master.status')
            ->leftJoin('LeadSource', 'LeadSource.id', '=', 'hvl_lead_master.lead_source')
            ->leftJoin('Rating', 'Rating.id', '=', 'hvl_lead_master.rating')
            ->leftJoin('Industry', 'Industry.id', '=', 'hvl_lead_master.industry')
            ->select('emp.Name as emp_name', 'owner.Name as owner_name', 'LeadSource.Name as lead_name', 'CompanyType.Name as company_type_name', 'LeadStatus.Name as lead_status', 'Rating.Name as rating_name', 'Industry.Name as industry_name', 'hvl_lead_master.*')
            ->where('hvl_lead_master.flag', '=', 0);
         if(isset($search_start_date) && isset($search_end_date)){
              $leadDetails = $leadDetails->whereBetween('hvl_lead_master.create_date', [$search_start_date, $search_end_date]);
         }
         if(isset($search_status) && (!empty($search_status))){
              $leadDetails = $leadDetails->whereIn('hvl_lead_master.status', $search_status);
         }
         if (!($em_id == 1 or $em_id == 122 or $em_id == 213)) {
              $leadDetails = $leadDetails->where('hvl_lead_master.employee_id', '=', $emp->id);
         }
        $leadDetails = $leadDetails->orderBy('hvl_lead_master.id', 'DESC')
            ->orderBy('hvl_lead_master.id', 'DESC')
            ->get();
        return view('hvl.leadmaster.index', [
            'leadDetails' => $leadDetails,
            'lead_sizes'=>$lead_sizes,
            'lead_proposal_date'=>$latest_lead_proposal,
            'status'=>$status,
            'search_start_date' =>  $search_start_date,
            'search_end_date' =>  $search_end_date,
            'search_status'     =>  $search_status,
        ]);
    }
     
     public function getLeadlatestProposal(){
         $latest_lead_proposal = [];
         $rows = LeadProposal::orderBy('lead_id','DESC')
                    ->orderBy('updated_at','DESC')
                    ->select('updated_at','lead_id')
                    ->get();
                
        foreach($rows as $row){
                if(!isset($latest_lead_proposal[$row->lead_id]))
                    $latest_lead_proposal[$row->lead_id] = $row->updated_at;  
        }
        return $latest_lead_proposal;
     }
    public function saveProposal(StoreProposal $request){
        $lead_id = null;
        if($request->lead_id){
            $lead_id = $request->lead_id;
        }
        
        $file = $request->file('file');
        $fileName = date('Y_m_d_H_i_s').''.$file->getClientOriginalName();
        $file->move(public_path(LeadProposal::filePath),$fileName);
        $leadProposal = new LeadProposal();
        $leadProposal->lead_id  =  $lead_id;
        $leadProposal->proposal =  $fileName;
        $leadProposal->save();
        $file_path = asset('public/'.LeadProposal::filePath.'/'.$fileName);
       if($leadProposal->isImage($leadProposal->proposal)){
            $imagePath = asset( 'public/'.LeadProposal::filePath ).'/'. $leadProposal->proposal;
        }
        else if($leadProposal->isPdf($leadProposal->proposal)) 
        {
            $imagePath = asset( 'public/img/pdf.png' );
        }
        elseif($leadProposal->isDocument($leadProposal->proposal))
        {
            $imagePath = asset( 'public/img/doc.png' );
        }
        return response()->json([
                        'status'=>'success',
                        'data'=>[
                            'proposal_id' => $leadProposal->id,
                            'image' => $imagePath,
                            'file_path'=>$file_path,
                        ]
        ]);
    }
    public function removeProposalByLeadId($lead_id){
        $leadProposalRecord = LeadProposal::where('lead_id',$lead_id)->get();
        foreach($leadProposalRecord as $leadProposal){
            $file = public_path(LeadProposal::filePath)."/".$leadProposal->proposal;
            if(file_exists($file)) 
                    unlink($file);
        }
        LeadProposal::where('lead_id',$lead_id)->delete();
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
        $lead_master=  new LeadMaster();
        $lead_size = $lead_master->getLeadSizeOption();

        
        return view('hvl.leadmaster.create', [
            'pageConfigs' => $pageConfigs,
            'breadcrumbs' => $breadcrumbs,
            'company_types' => $company_type,
            'industrys' => $industry,
            'statuses' => $status,
            'ratings' => $rating,
            'employees' => $employees,
            'leadsources' => $leadsource,
            'lead_size'=>$lead_size
        ]);
    }
    public function store(Request $request) {
        $lead_master = new LeadMaster();
        $lead_master->company_type          = $request->company_type;
        $lead_master->last_company_name     = $request->compnay_name;
        $lead_master->f_name                = $request->f_name;
        $lead_master->email                 = $request->email;
        $lead_master->email_2                 = $request->email_2;
        $lead_master->phone                 = $request->phone;
        $lead_master->employee_id           = $request->employee;
        $lead_master->owner                 = $request->owner;
        $lead_master->create_date           = $request->create_date;
        $lead_master->follow_date           = $request->follow_date;
        $lead_master->status                = $request->status;
        $lead_master->rating                = $request->rating;
        $lead_master->lead_source           = $request->lead_source;
        $lead_master->industry              = $request->industry;
        $lead_master->address               = $request->address;
        $lead_master->comment               = $request->comment;
        $lead_master->comment_2             = $request->comment_2;
        $lead_master->comment_3             = $request->comment_3;
        $lead_master->lead_size             = $request->lead_size;
        $lead_master->revenue               = $request->revenue;
        $lead_master->is_active             = $request->is_active;
        $lead_master->save();
        
        if(!empty($request->proposal)){
            LeadProposal::whereIn('id',$request->proposal)
            ->update(['lead_id' =>$lead_master->id]);
        }
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
        $lead_master=  new LeadMaster();
        $lead_size = $lead_master->getLeadSizeOption();
        $proposal = LeadProposal::where('lead_id','=',$id)->orderBy('updated_at','desc')->get();
        $proposalPath = LeadProposal::filePath;
      
        return view('hvl.leadmaster.edit', [
            'pageConfigs' => $pageConfigs,
            'breadcrumbs' => $breadcrumbs,
            'company_types' => $company_type,
            'industrys' => $industry,
            'statuses' => $status,
            'ratings' => $rating,
            'employees' => $employees,
            'details' => $details,
            'leadsources' => $leadsource,
            'lead_size'=>$lead_size,
            'proposals'=>$proposal,
            'proposalPath'=>$proposalPath,
        ]);
    }
    
    public function update(Request $request, $id) {
        $post_data = [
            'company_type' => $request->company_type,
            'last_company_name' => $request->compnay_name,
            'f_name' => $request->f_name,
            'email' => $request->email,
            'email_2' => $request->email_2,
            'phone' => $request->phone,
            'employee_id' => $request->employee,
            'owner' => $request->owner,
            'follow_date' => $request->follow_date,
            'status' => $request->status,
            'rating' => $request->rating,
            'lead_source' => $request->lead_source,
            'industry' => $request->industry,
            'address' => $request->address,
            'comment' => $request->comment,
            'comment_2' => $request->comment_2,
            'comment_3' => $request->comment_3,
            'lead_size' => $request->lead_size,
            // 'credit_value' => $request->value,
            'revenue' => $request->revenue,
            'is_active' => $request->is_active,
        ];
        $lead_data = new LeadMaster();
        $lead_data = $lead_data->find($id);
        if($lead_data->create_date == null ){
            $post_data['create_date'] = $request->create_date;
        }
        LeadMaster::whereId($id)->update($post_data);
        return redirect('/lead-master')->with('success', 'Record Has Been Updated');
    }
    function removedata(Request $request){
        $this->removeProposalByLeadId($request->input('id'));
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
                   //'status' => $details->status,
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
                   // 'employee_id' => $request->employee_id,
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
                    //'is_active' => $request->is_active
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
        $lead_master=  new LeadMaster();
        $lead_size = $lead_master->getLeadSizeOption();
        $proposal = LeadProposal::where('lead_id','=',$id)->orderBy('updated_at','desc')->get();
        $proposalPath = LeadProposal::filePath;
        
        return view('hvl.leadmaster.view', [
            'company_types' => $company_type,
            'industrys' => $industry,
            'statuses' => $status,
            'ratings' => $rating,
            'employees' => $employees,
            'details' => $details,
            'leadsources' => $leadsource,
            'lead_size'=>$lead_size,
            'proposals'=>$proposal,
            'proposalPath'=>$proposalPath,
        ]);
    }
    public function getDownloadLeads(Request $request){
     $file_name = date('Y_m_d_h_i_s')."_lead_master.xlsx";
          Excel::store(new LeadMasterExport($request->all()), '/public/temp/'.$file_name);
        return redirect()->to( asset('public/storage/temp/'.$file_name));
      
        // return Excel::download(new LeadMasterExport($request->all()), 'lead_master.csv');
    }
    public function sendLeadExcelSheet(Request $request){
        
        $attachment = Excel::raw(
            new LeadMasterExport($request->all()), 
            BaseExcel::CSV
        );

        $message = Mail::to($request->to);
        if (isset($request->cc))
            $message->cc($request->cc);

        if (isset($request->bcc))
            $message->bcc($request->bcc);

         $message->send(new LeadMasterSheetMail($attachment, $request->subject, $request->body));

        return redirect('/lead-master')->with('success', 'Email Sent successfully.');
    }
    
}

<?php

namespace App\Http\Controllers\hvl\leadmaster;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Requests\ExcelBulkUploadRequest;
use App\Models\hvl\LeadMaster;
use Auth;
use App\Helpers\Helper;


class LeadBulkUploadController extends Controller {
    private $company_type_data;
    private $company_employee;
    private $lead_status;
    private $rating;
    private $lead_source;
    private $industry;
    private $lead_size;
    public function index(){
        $user = Auth::user();
        if(!$user->can('Access Lead Bulkupload')){
           abort(403, 'Access denied');
        }
        return view('hvl.leadmaster.bulk_upload');    
    }    
    public function saveLeadManagementBulkUpload(ExcelBulkUploadRequest $request){
        $line_no = 0;
        $flag = false;
        $existingLead = $this->getExsitingLead();
        $user = Auth::user();
        if(!$user->can('Access Lead Bulkupload')){
           abort(403, 'Access denied');
        }
        $can_lead_add = $user->can('Create Lead Bulkupload'); 
        $can_lead_edit = $user->can('Edit Lead Bulkupload');
        $can_lead_delete = $user->can('Delete Lead Bulkupload');
        
        try{
            DB::beginTransaction();
            $ExcelArray = Excel::toArray(new Controller(), $request->file('excel_file'));
            $prepare_data  = $this->setData($ExcelArray[0]);
            foreach($prepare_data as $line_no=>$row){
                $mail_id = $row['email'];
                $lead_occur_count = count(array_filter($existingLead,function($a)use ($mail_id){return $a==$mail_id;})); 
                if($row['action'] == 'ADD'){
                     if(!$can_lead_add){
                        abort(403, 'Access Denied Multi Add Lead '.($line_no+1));
                    }
                    if( $lead_occur_count > 0){
                            throw new \ErrorException($row['email'].' Lead Already Existing');
                    }
                    LeadMaster::create( 
                            [
                            'company_type'      =>  $row['company_type'],
                            'last_company_name' =>  $row['last_company_name'],
                            'f_name'            =>  $row['f_name'],
                            'email'             =>  $row['email'],
                            'phone'             =>  $row['phone'],
                            'employee_id'       =>  $row['employee_id'],
                            'owner'             =>  $row['owner'],
                            'create_date'       =>  $row['create_date'],
                            'follow_date'       =>  $row['follow_date'],
                            'status'            =>  $row['status'],
                            'rating'            =>  $row['rating'],
                            'lead_source'       =>  $row['lead_source'],
                            'industry'          =>  $row['industry'],
                            'address'           =>  $row['address'],
                            'comment_2'         =>  $row['comment_2'],
                            'comment_3'         =>  $row['comment_3'],
                            'comment'           =>  $row['comment'],
                            'revenue'           =>  $row['revenue'],
                            'is_active'         =>  $row['is_active'],
                            'lead_size'         =>  $row['lead_size'],
                            'email_2'           =>  $row['email_2'],
                            ]);
                }
                else if($row['action'] == 'DELETE'){
                    if(!$can_lead_delete){
                        abort(403, 'Access Denied Multi Delete Lead '.($line_no+1));
                    }
                    if($lead_occur_count == 1){
                        $lead_master = new LeadMaster();
                        $lead_master = $lead_master->where('email',$row['email']);
                        $lead_master->delete();

                    }else if($lead_occur_count < 1){
                        throw new \ErrorException( 'Lead Not Found => ' .$row['email']);
                    }else{
                        throw new \ErrorException( $row['email']."Lead Have No Uniq Id Please Make It Uniq First");
                    }
                }
                else if($row['action'] == 'EDIT'){
                    if(!$can_lead_edit){
                        abort(403, 'Access Denied Multi Edit Lead '.($line_no+1));
                    }
                    if($lead_occur_count == 1){
                        $leadMaster = new LeadMaster();
                        $leadMaster = $leadMaster->where('email',$row['email'])->first();      
                            $leadMaster->company_type       =  $row['company_type'];
                            $leadMaster->last_company_name  =  $row['last_company_name'];
                            $leadMaster->f_name             =  $row['f_name'];
                            $leadMaster->email              =  $row['email'];
                            $leadMaster->phone              =  $row['phone'];
                            $leadMaster->employee_id        =  $row['employee_id'];
                            $leadMaster->owner              =  $row['owner'];
                            $leadMaster->create_date        =  $row['create_date'];
                            $leadMaster->follow_date        =  $row['follow_date'];
                            $leadMaster->status             =  $row['status'];
                            $leadMaster->rating             =  $row['rating'];
                            $leadMaster->lead_source        =  $row['lead_source'];
                            $leadMaster->industry           =  $row['industry'];
                            $leadMaster->address            =  $row['address'];
                            $leadMaster->comment_2          =  $row['comment_2'];
                            $leadMaster->comment_3          =  $row['comment_3'];
                            $leadMaster->comment            =  $row['comment'];
                            $leadMaster->revenue            =  $row['revenue'];
                            $leadMaster->is_active          =  $row['is_active'];
                            $leadMaster->lead_size          =  $row['lead_size'];
                            $leadMaster->email_2            =  $row['email_2'];
                            
                            $leadMaster->save();
                    }else if($lead_occur_count < 1){
                        throw new \ErrorException('Lead Not Found => ' .$row['email']);
                    }else{
                        throw new \ErrorException( $row['email']." Lead Have No Uniq Id Please Make It Uniq First");
                    }
                }
            }
            DB::commit();
            return redirect()->route('admin.leadmaster_bulkupload.index')->with('success', 'Data has been uploaded successfully');        
        }catch (\Exception $e) {
            DB::rollBack();
            return self::index($request)->withErrors("Please show a list of fields or row no = ".($line_no+1)." where error is ".$e->getMessage());
     
        }
    }
    public function getExsitingLead(){
        $leade_Master =   LeadMaster::pluck("email","id")->toArray();
        return $leade_Master;
    }
    public function setData($data){
            $company_type_data = $this->getCompanyType();
            $company_employee = $this->getEmployee();
            $lead_status = $this->getStatus();
            $rating = $this->getGeographicalSegment();
            $lead_source = $this->getLeadSource();
            $industry = $this->getIndustry();
            $is_active = $this->getIsActive();
            $lead_size = $this->getSize();
            $helper = new Helper();
           foreach($data as $key => $row){
                if($key == 0){
                    continue;
                }
                if($row[1] == null || (!isset($row[1])) ){
                    continue;
                }
                if(strtoupper($row[0])=="DELETE"){
                
                    if($row[0] == null || (!isset($row[1]) ) ){
                        throw new \ErrorException('Please Provide All Data');
                    }
                    $response[] =   
                    [
                        'action'            =>  strtoupper($row[0]),
                        'email'             =>  $row[1],
                    ];    
                    
                }else{
                    if($key == 0){
                        continue;
                    }
                    if($row[1] == null || (!isset($row[1])) ){
                        continue;
                    }
                    if($row[2] == null){
                        throw new \ErrorException('Company Type : Not Found');
                    }
                    
                    if(!isset($company_type_data[trim(strtoupper($row[2]))])){
                        throw new \ErrorException('Company Type : '.$row[2] .' Invalid');
                    }
                    
                    if($row[3] == null){
                        throw new \ErrorException('Last Company Name : Not Found');
                    }
                    
                    if($row[4] == null){
                        throw new \ErrorException('First Name : Not Found');
                    }
                    
                    if($row[6] == null){
                        throw new \ErrorException('Employee : Not Found');
                    }

                    if(!isset($company_employee[trim(strtoupper($row[6]))])){
                        throw new \ErrorException('Employee : '.$row[6].' Invalid');
                    }
                    
                    if($row[7] == null){
                        throw new \ErrorException('Owner : Not Found');
                    }

                    if(!isset($company_employee[trim(strtoupper($row[7]))])){
                        throw new \ErrorException('Owner : '.$row[7].' Invalid');
                    }
                    
                    if($row[8] == null){
                        throw new \ErrorException('Create Date : Not Found');
                    }
                    
                    if($row[9] == null){
                        throw new \ErrorException('Follow Up Date : Not Found');
                    }
                    
                    if($row[10] == null){
                        throw new \ErrorException('Status : Not Found');
                    }
                    
                    if(isset($row[10]) && (!isset($lead_status[trim(strtoupper($row[10]))]))){
                        throw new \ErrorException('Status : '.$row[10] .' Invalid');
                    }
                    
                    if($row[11] == null){
                        throw new \ErrorException('Geographical : Not Found');
                    }
                    
                    if(isset($row[11]) && (!isset($rating[trim(trim(strtoupper($row[11])))]))){
                        throw new \ErrorException('Geographical : '.$row[11] .' Invalid');
                    }
                    
                    if($row[12] == null){
                        throw new \ErrorException('Lead Source : Not Found');
                    }

                    if(!isset($lead_source[trim(strtoupper($row[12]))])){
                        throw new \ErrorException('Lead Source : '.$row[12] .' Invalid');
                    }
                    
                    if($row[13] == null){
                        throw new \ErrorException('Industry : Not Found');
                    }
                    
                    if(!isset($industry[trim(strtoupper($row[13]))])){
                        throw new \ErrorException('Industry : '.$row[13].' Invalid');
                    }
                    
                    if($row[14] == null){
                        throw new \ErrorException('Address : Not Found');
                    }
                    
                    if($row[15] == null){
                        throw new \ErrorException('Revenue : Not Found');
                    }
                    
                    if($row[16] == null){
                        throw new \ErrorException('Comment : Not Found');
                    }
                    
                    
                    if($row[19] == null){
                        throw new \ErrorException('Is Active : Not Found');
                    }
                    
                    if(!isset($is_active[trim(strtoupper($row[19]))] )){
                        throw new \ErrorException('Is Active : '.$row[19].' Invalid');
                    }
                    
                    if($row[20] == null){
                        throw new \ErrorException('Lead Size : Not Found');
                    }
                    
                    if(!isset($lead_size[trim(strtoupper($row[20]))] )){
                        throw new \ErrorException('Lead Size : '.$row[20].' Invalid');
                    }
                    
                    $response[] =   
                    [
                        'action'            =>  trim(strtoupper($row[0])),
                        'email'             =>  $row[1],
                        'company_type'      =>  $company_type_data[trim(strtoupper($row[2]))],
                        'last_company_name' =>  $row[3],
                        'f_name'            =>  $row[4],
                        'phone'             =>  $row[5],
                        'employee_id'       =>  $company_employee[trim(strtoupper($row[6]))],
                        'owner'             =>  $company_employee[trim(strtoupper($row[7]))],
                        'create_date'       =>  $helper->transformDate($row[8]),
                        'follow_date'       =>  $helper->transformDate($row[9]),
                        'status'            =>  $lead_status[trim(strtoupper($row[10]))],
                        'rating'            =>  $rating[trim(trim(strtoupper($row[11])))],
                        'lead_source'       =>  $lead_source[trim(strtoupper($row[12]))],
                        'industry'          =>  $industry[trim(strtoupper($row[13]))],
                        'address'           =>  trim($row[14]),
                        'revenue'           =>  $row[15],
                        'comment'           =>  $row[16],
                        'comment_2'         =>  $row[17],
                        'comment_3'         =>  $row[18],
                        'is_active'         =>  $is_active[strtoupper($row[19])],
                        'lead_size'         =>  $lead_size[strtoupper($row[20])],
                        'email_2'           =>  $row[21],
                    ];
                    
                }
            }
            return $response;
                
    }
    private function getCompanyType(){
        if(!isset($this->company_type_data)){
            $company_type_data =  DB::table('CompanyType')->pluck('Name','id')->toArray();
            foreach($company_type_data as $id=>$row){
                $this->company_type_data[strtoupper($row)] = $id; 
            }
        }
        return $this->company_type_data;
    }
    
    private function getEmployee(){
        if(!isset($this->company_employee)){
            $company_employee =  DB::table('employees')->pluck('email','id')->toArray();
            foreach($company_employee as $id=>$row){
                $this->company_employee[strtoupper($row)] = $id; 
            }
        }
        return $this->company_employee;
    }

    private function getStatus(){
        
        if(!isset($this->lead_status)){
            $lead_status =  DB::table('LeadStatus')->pluck('Name','id')->toArray();
            foreach($lead_status as $id=>$row){
                $this->lead_status[strtoupper($row)] = $id ; 
            }
        }
        return $this->lead_status;
    }
    private function getGeographicalSegment(){
        if(!isset($this->rating)){
            $rating =  DB::table('Rating')->pluck('Name','id')->toArray();
            foreach($rating as $id=>$row){
                $this->rating[strtoupper($row)] = $id; 
            } 
        }
        return $this->rating;
    }
    private function getLeadSource(){
        if(!isset($this->lead_source)){
            $lead_source =  DB::table('LeadSource')->pluck('Name','id')->toArray();
            foreach($lead_source as $id=>$row){
                $this->lead_source[strtoupper($row)] = $id; 
            }
        }
        return $this->lead_source;
    }
    private function getIndustry(){
        if(!isset($this->industry)){
            $industry =  DB::table('Industry')->pluck('Name','id')->toArray();
            foreach($industry as $id=>$row){
                $this->industry[strtoupper($row) ] = $id; 
            }
        }
        return $this->industry;
    }
    private function getIsActive(){
        return ['ACTIVE'=>'0','INACTIVE'=>'1'];
    }
    private function getSize(){
        $lead_master = new LeadMaster();
        $leadsize = $lead_master->getLeadSizeOption();
        foreach($leadsize as $key=>$row){
            $this->lead_size[strtoupper($row)] = $key; 
        }
        return $this->lead_size;
    }
}

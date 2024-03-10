<?php

namespace App\Http\Controllers\hvl\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ExportActivity;
use App\Http\Requests\ExcelBulkUploadRequest;
use App\Employee;
use App\Team;
use App\Department;
use App\Designation;
use App\Models\hrms\City; 
use App\User;
use Auth;
use Illuminate\Support\Facades\Hash;
 

class EmployeesBulkUploadController extends Controller {
    private $designation =[];
    private $team =[];
    private $departments =[];
    private $city =[];

    public function index(){
        $user = Auth::user();
        if(!$user->can('Access Employee Bulkupload')){
           abort(403, 'Access denied');
        }
        return view('hvl.employee.bulk_upload');    
    }    
    public function saveEmployeeManagementBulkUpload(ExcelBulkUploadRequest $request){
        $user = Auth::user();
        if(!$user->can('Access Employee Bulkupload')){
           abort(403, 'Access denied');
        }
        $can_employee_add = $user->can('Create Employee Bulkupload'); 
        $can_employee_edit = $user->can('Edit Employee Bulkupload');
        $can_employee_delete = $user->can('Delete Employee Bulkupload');
       
        $line_no = 0;
        $flag = false;
        $existingEmployees = array_flip(array_change_key_case($this->getExsitingEmployees(),CASE_UPPER));
        try{
            $create_data_array = [];
            $delete_data_array = [];
            DB::beginTransaction();
            $ExcelArray = Excel::toArray(new Controller(), $request->file('excel_file'));
            $prepare_data  = $this->setData($ExcelArray[0]);
            
           
            
            foreach($prepare_data as $line_no=>$row){
           
            // $user = User::where('email',$row['email'])->first();
            
            // if(!$user){
            //         throw new \ErrorException('error');
            // }  
            // $employee = new Employee();
            // $employee_data = $employee->where('email',$row['email'])->first();
            // $employee_data->user_id = $user->id ;
            // $employee_data->save();
            // DB::commit();
            // continue;
            // // echo "<pre>";
            // // print_r($user);
            // // print_r($prepare_data);
            // die;
            
                $employee_email = $row['email_uc'];
                $employee_occur_count = count(array_filter($existingEmployees,function($a)use ($employee_email){return $a==$employee_email;}));  
                if($row['action'] == 'ADD'){
                    if(!$can_employee_add){
                        abort(403, 'Access Denied Multi Add Employee '.($line_no+1));
                    }
                    if($employee_occur_count>0){
                            throw new \ErrorException('Employee Already Existing'.$row['email']);
                    }
                    $user = new User();
                        $user->name = $row['name'];
                        $user->email = $row['email'];
                        $user->password = Hash::make('Hvl@1234');
                        $user->created_at = date('Y-m-d');
                        $user->save();
                    // $user->assignRole('Expense User');
                       
                    Employee::create( 
                        [
                            'Name'=>$row['name'],
                            'email'=>$row['email'],
                            'user_id'=>$user->id,
                            'Date_of_Brith'=>$row['date_of_brith'],
                            'Select_Department'=>$row['departments'],
                            'Select_Team'=>$row['team'],
                            'Select_Designation'=>$row['designation'],
                            'Date_of_Appointment'=>$row['appointment_date'],
                            'select_city'=>$row['city'],
                            'Address'=>$row['address'],
                            'account_id'=>$row['account_id'],
                            'manager_id'=>$row['manager_id'],
                            'created_at'=>date('Y-m-d'),
                            'updated_at'=>date('Y-m-d'),
                            
                        ]);
                        // $user = new User();
                        // $user->name = $row['name'];
                        // $user->email = $row['email'];
                        // $user->password = Hash::make('Hvl@1234');
                        // $user->created_at = date('Y-m-d');
                        // $user->save();
                        // $user->assignRole('Expense User');
                        
                            
                }
                else if($row['action'] == 'DELETE'){
                    if(!$can_employee_delete){
                        abort(403, 'Access Denied Multi Delete Employee '.($line_no+1));
                    }
                    if($employee_occur_count > 1){
                        throw new \ErrorException('Same email address multiple employee have');
                    }else if($employee_occur_count < 1){
                        throw new \ErrorException('email address found');
                    }
                    $employee = new Employee();
                    $employee_record = $employee->where('email',$row['email'])->first();
                    if(!$employee_record){
                    }
                    $employee->delete();

                    $user = new User();
                    $user_record = $user->where('email',$row['email']);
                    if(!$user_record){
                        throw new \ErrorException('User Not Found');
                    }
                    $user->delete();
                }
                else if($row['action'] == 'EDIT'){
                    if(!$can_employee_edit){
                        abort(403, 'Access Denied Multi edit Employee '.($line_no+1));
                    }
                    if($employee_occur_count > 1){
                        throw new \ErrorException('Same email address multiple employee have');
                    }else if($employee_occur_count < 1){
                        throw new \ErrorException('email address found');
                    }
                    $employee = new Employee();
                    $employee_data = $employee->where('email',$row['email'])->first();
                    $employee_data->Name                =   $row['name'];
                    // $employee_data->email               =   $row['email'];
                    $employee_data->Date_of_Brith       =   $row['date_of_brith'];
                    $employee_data->Select_Department   =   $row['departments'];
                    $employee_data->Select_Team         =   $row['team'];
                    $employee_data->Select_Designation  =   $row['designation'];
                    $employee_data->Date_of_Appointment =   $row['appointment_date'];
                    $employee_data->select_city         =   $row['city'];
                    $employee_data->Address             =   $row['address'];
                    $employee_data->account_id          =   $row['account_id'];
                    $employee_data->manager_id          =   $row['manager_id'];
                    $employee_data->created_at          =   date('Y-m-d');
                    $employee_data->updated_at          =   date('Y-m-d');
                    
                    $employee_data->save();
                    //save user table value
                    $user = new User();
                    $user_data = $user->where('email',$row['email'])->first();
                    if(!$user_data){
                        throw new \ErrorException('user Not Found');
                    }
                    $user_data->name = $row['name'];
                    $user_data->save();
                }
            }
            DB::commit();
            return redirect()->route('admin.employeemaster_bulkupload.index')->with('success', 'Data has been uploaded successfully');        
        }catch (\Exception $e) {
            DB::rollBack();
            return self::index($request)->withErrors("Please show a list of fields or row no = ".($line_no+2)." where error is ".$e->getMessage());
        }
    }

    public function getExsitingEmployees(){
        $employee = Employee::pluck('id','email')->toArray();
        return $employee;
    }

    private function setData($data){
       
        $response = [];
        $departments = $this->getDepartments();
        $designation = $this->getDesignation();
        $team = $this->getTeam();
        $city = $this->getcities();
        $employee_list = $this->getEmployee();

        foreach($data as $key=>$row){
            if($key == 0){
                continue;
            }
            if($row[0] == null || $row[1]==null){
                continue;
            }
            
            if(trim(strtoupper($row[0])) == 'DELETE'){
                if($row[0] == null || (!isset($row[1])) ){
                   throw new \ErrorException('please fill all mandatory data');
                }
            }else{
                if($row[0] == null || (!isset($row[1]))){
                  throw new \ErrorException('please fill all mandatory data');
                }
                if(!isset($team[strtoupper($row[5])])){
                    throw new \ErrorException('Team not found');
                }
                if(!(isset($designation[strtoupper($row[6])]))){
                    throw new \ErrorException('Designation not found');
                }
                if(!(isset($departments[strtoupper($row[4])]))){
                    throw new \ErrorException('Departments not found');
                }
                if(!isset($city[strtoupper($row[8])])){
                    throw new \ErrorException('City not found');
                }
                if(!isset($row[10])){
                    throw new \ErrorException('Manager not found');
                }
                 
                if(!isset($employee_list[strtoupper($row[10])])){
                    // throw new \ErrorException('invalid : manager');
                }
                 
                 
                
                if(!isset($row[11])){
                    throw new \ErrorException('Account Employee not found');
                }
                if(!isset($employee_list[strtoupper($row[11])])){
                    throw new \ErrorException('invalid : Account');
                }
                $response[] =   [
                    'action'            =>  trim(strtoupper($row[0])),
                    'email'             =>  $row[1],
                    'email_uc'          =>  trim(strtoupper($row[1])),
                    'name'              =>  $row[2],
                    'date_of_brith'     =>  (isset($row[3]))?$row[3]:null,
                    'departments'       =>  $departments[trim(strtoupper($row[4]))],
                    'team'              =>  $team[trim(strtoupper($row[5]))],
                    'designation'       =>  $designation[trim(strtoupper($row[6]))],
                    'appointment_date'  =>  (isset($row[7]))?$row[7]:null,
                    'city'              =>  (isset($row[8]))?$city[trim(strtoupper($row[8]))]:null,
                    'address'           =>  $row[9],
                    'manager_id'        =>  $employee_list[trim(strtoupper($row[10]))],
                    'account_id'        =>  $employee_list[trim(strtoupper($row[11]))]
                ];    
            }
        }
        return $response;
    }
    private function getDesignation(){
        if(empty($this->designation)){
            $designations = Designation::pluck('Name','id')->toArray();
            foreach($designations as $id=>$designation){
                $this->designation[strtoupper($designation)] = $id;
            }
        }
        return $this->designation;
    }
    private function getTeam(){
        if(empty($this->team)){
            $teames = Team::pluck('Name','id')->toArray();
            foreach($teames as $id=>$team){
                $this->team[strtoupper($team)] = $id;
            } 
        }
        return $this->team;
    }
    private function getDepartments(){
        if(empty($this->departments)){
            $departmentes = Department::pluck('Name','id')->toArray();
            foreach($departmentes as $id=>$department){
                $this->departments [strtoupper($department)] = $id;
            }
        }
        return $this->departments;
    }
    
    private function getcities(){
        if(empty($this->city)){
            $cities = City::pluck('Name','id')->toArray();
            foreach($cities as $id=>$city){
                $this->city [strtoupper($city)] = $id;
            }
        }
        return $this->city;
    }
    private function getEmployee(){
        if(!isset($this->company_employee)){
            $company_employee =  DB::table('employees')->pluck('email','user_id')->toArray();
            foreach($company_employee as $id=>$row){
                $this->company_employee[strtoupper($row)] = $id; 
            }
        }
        return $this->company_employee;
    }
}

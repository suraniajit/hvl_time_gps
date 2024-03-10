<?php

namespace App\Providers;

namespace App\Http\Controllers\hrms;

use App\User;
use Auth;
use Hash;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Passport\Passport;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Spatie\Permission\Models\Role;
use App\Models\hrms\EmployeeMaster;
use App\Models\hrms\EmployeeDetails;
use App\Models\hrms\EmployeeDependent;
use App\Models\hrms\Department;
use App\Models\hrms\DepartmentEmpAssign;
use App\Models\hrms\Team;
use App\Models\hrms\TeamEmpAssign;
use App\Models\hrms\Scale;
use App\Models\hrms\ScaleEmpAssign;

use Datatables;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class EmployeeMasterController extends Controller {

    function __construct() {
//        $this->middleware('auth');
        $this->middleware('permission:employee-list|employee-create|employee-edit|employee-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:employee-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:employee-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:employee-delete', ['only' => ['delete']]);
        $this->middleware('permission:employee-multidelete', ['only' => ['multidelete']]);
    }

    public function index() {
//Pageheader set true for breadcrumbs
        $pageConfigs = ['pageHeader' => true, 'isFabButton' => true,'isCustomizer'=>true];

        if (Auth::user()->can('employee-create')) {
            $breadcrumbs = [
                ['link' => "hrms", 'name' => "Home"],
                ['link' => "hrms/employee/", 'name' => "Employee Master"],
                ['link' => "hrms/employee/create", 'name' => "Create"],
            ];
            $rigthlink = [
                ['rigthlink' => "employee/create", 'name' => "Create"]
            ];
            return view('hrms.employee-master.index', [
                'rigthlink' => $rigthlink,
                'pageConfigs' => $pageConfigs,
                'breadcrumbs' => $breadcrumbs,
            ]);
        } else {

            $breadcrumbs = [
                ['link' => "hrms", 'name' => "Home"],
                ['link' => "hrms/employee/", 'name' => "Employee Master"],
            ];
            return view('hrms.employee-master.index', [
                'pageConfigs' => $pageConfigs,
                'breadcrumbs' => $breadcrumbs,
            ]);
        }
    }

    public function getNextOrderNumber() {
// Get the last created order
        $lastOrder = EmployeeMaster::orderBy('id', 'desc')->first();

        if (!$lastOrder)
// We get here if there is no order at all
// If there is no number set it to 0, which will be 1 at the end.
            $number = 0;
        else
            $number = substr($lastOrder->id, 0);

// If we have ORD000001 in the database then we only want the number
// So the substr returns this 000001
// Add the string in front and higher up the number.
// the %05d part makes sure that there are always 6 numbers in the string.
// so it adds the missing zero's when needed.
//        return 'TEMP:' . sprintf('%06d', intval($number) + 1);
        return sprintf('%05d', intval($number) + 1);
    }

    function getEmployeeIncrementsMasters() {
        return DB::table('employee_increments')
                        ->where('is_active', '=', '0')
                        ->get();
    }

    function getDesignationsMasters() {
        return DB::table('designations')
                        ->where('is_active', '=', '0')
                        ->get();
    }

    function getEmployeeGetMastersDetails() {
        return DB::table('employee_masters')
                        ->where('is_active', '=', '0')
                        ->get();
    }

    function getEmployeeScaleMasters() {
        return DB::table('scales')
                        ->where('is_active', '=', '0')
                        ->get();
    }

    function getVendorMasters() {
        return DB::table('vendors')
                        ->where('is_active', '=', '0')
                        ->get();
    }

    function getTeamsMasters() {
        return DB::table('teams')
                        ->where('is_active', '=', '0')
                        ->get();
    }

    function getDepartmentMasters() {
        return DB::table('departments')
                        ->where('is_active', '=', '0')
                        ->get();
    }

    function getEmployeeTypeMasters() {
        return DB::table('employee_types')
                        ->where('is_active', '=', '0')
                        ->get();
    }

    function getMaritalStatuseMasters() {
        return DB::table('marital_statuses')
                        ->where('is_active', '=', '0')
                        ->get();
    }

    function getrolesMaster() {
        return DB::table('roles')
                        ->where('is_active', '=', '0')
                        ->get(); //designations master Table
    }

    function getGendersMasters() {
        return DB::table('genders')
                        ->where('is_active', '=', '0')
                        ->get();
    }

    function getShiftMasters() {
        return DB::table('shifts')
                        ->where('is_active', '=', '0')
                        ->get();
    }

    function getRelationshipsMasters() {
        return DB::table('relationships')
                        ->where('is_active', '=', '0')
                        ->get();
    }

    function getReasonLeavesMasters() {
        return DB::table('reason_to_leaves')
                        ->where('is_active', '=', '0')
                        ->get();
    }

    function getCountryMasters() {
        return DB::table('countries')
                        ->where('is_active', '=', '0')
                        ->get();
    }

    function getCityMasters() {
        return DB::table('cities')
                        ->where('is_active', '=', '0')
                        ->get();
    }

    function getStateMasters() {
        return DB::table('states')
                        ->where('is_active', '=', '0')
                        ->get();
    }

    public function fill_unit_select_box(Request $request) {
        if ($request->ajax()) {
            $states = DB::table("relationships")
                    ->select('relationship_name', 'id')
                    ->where('is_active', '=', '0')
                    ->get();
            return response()->json($states);
        }
    }

    public function ipAddress() {
        return \Request::ip();
    }

    function getEmployeeDetails_EmployeeMasters($id = null) {
        return DB::table('employee_details')
                        ->where('employee_masters.is_active', '=', '0')
                        ->where('employee_details.is_active', '=', '0')
                        ->where('employee_details.employee_masters_id', '=', $id)
                        ->join('employee_masters', 'employee_masters.id', '=', 'employee_details.employee_masters_id')
                        ->first();
    }

    function getEmployeeDependents_EmployeeMasters($id = null) {
        return DB::table('employee_masters')
                        ->where('employee_masters.is_active', '=', '0')
                        ->where('employee_dependents.is_active', '=', '0')
                        ->where('employee_dependents.employee_masters_id', '=', $id)
                        ->join('employee_dependents', 'employee_masters.id', '=', 'employee_dependents.employee_masters_id')
                        ->get();
    }

    public function create() {

        $breadcrumbs = [
            ['link' => "hrms", 'name' => "Home"],
            ['link' => "hrms/employee/", 'name' => "Employee Master"],
            ['name' => "Create"],
        ];
//Pageheader set true for breadcrumbs
        $pageConfigs = ['pageHeader' => true, 'isFabButton' => true,'isCustomizer'=>true];

        $rand = 'EMP-' . rand(0, 9) . date('s'); // autogenrate code


        $rolesMaster = DB::table('roles')
                ->where('is_active', '=', '0')
                ->get(); //designations master Table



        $getNextOrderNumber = $this->getNextOrderNumber();
        return view('hrms.employee-master.create', [
            'pageConfigs' => $pageConfigs,
            'breadcrumbs' => $breadcrumbs,
            'randNumber' => $getNextOrderNumber,
            'rolesMasters' => $this->getrolesMaster(),
            'GendersMasters' => $this->getGendersMasters(),
            'MaritalStatuseMasters' => $this->getMaritalStatuseMasters(),
            'EmployeeTypeMasters' => $this->getEmployeeTypeMasters(),
            'DesignationsMasters' => $this->getDesignationsMasters(),
            'DepartmentMasters' => $this->getDepartmentMasters(),
            'TeamsMasters' => $this->getTeamsMasters(),
            'VendorMasters' => $this->getVendorMasters(),
            'EmployeeIncrementsMasters' => $this->getEmployeeIncrementsMasters(),
            'ShiftMasters' => $this->getShiftMasters(),
            'ReasonLeavesMasters' => $this->getReasonLeavesMasters(),
            'RelationshipsMasters' => $this->getRelationshipsMasters(),
            'EmployeeScaleMasters' => $this->getEmployeeScaleMasters(),
            'CountryMasters' => $this->getCountryMasters(),
            'StateMasters' => $this->getStateMasters(),
            'CityMasters' => $this->getCityMasters(),
            'EmployeeGetMastersDetails' => $this->getEmployeeGetMastersDetails(),
        ]);
    }

    public function view($id) {
        $breadcrumbs = [
            ['link' => "hrms", 'name' => "Home"],
            ['link' => "hrms/employee/", 'name' => "Employee Master"],
            ['name' => "View"],
        ];
//Pageheader set true for breadcrumbs
        $pageConfigs = ['pageHeader' => true, 'isFabButton' => true,'isCustomizer'=>true];

        if ($Employee = EmployeeMaster::whereId($id)->first()) {
            return view('hrms.employee-master.view', [
                'pageConfigs' => $pageConfigs,
                'breadcrumbs' => $breadcrumbs,
                'Employee_Details' => $Employee,
                'rolesMasters' => $this->getrolesMaster(),
                'GendersMasters' => $this->getGendersMasters(),
                'MaritalStatuseMasters' => $this->getMaritalStatuseMasters(),
                'EmployeeTypeMasters' => $this->getEmployeeTypeMasters(),
                'DesignationsMasters' => $this->getDesignationsMasters(),
                'DepartmentMasters' => $this->getDepartmentMasters(),
                'TeamsMasters' => $this->getTeamsMasters(),
                'VendorMasters' => $this->getVendorMasters(),
                'EmployeeIncrementsMasters' => $this->getEmployeeIncrementsMasters(),
                'ShiftMasters' => $this->getShiftMasters(),
                'RelationshipsMasters' => $this->getRelationshipsMasters(),
                'ReasonLeavesMasters' => $this->getReasonLeavesMasters(),
                'EmployeeScaleMasters' => $this->getEmployeeScaleMasters(),
                'CountryMasters' => $this->getCountryMasters(),
                'StateMasters' => $this->getStateMasters(),
                'CityMasters' => $this->getCityMasters(),
                'EmployeeDetails_EmployeeMasters' => $this->getEmployeeDetails_EmployeeMasters($id),
                'EmployeeDependents_EmployeeMasters' => $this->getEmployeeDependents_EmployeeMasters($id),
                'EmployeeGetMastersDetails' => $this->getEmployeeGetMastersDetails(),
            ]);
        }
    }

    public function edit($id) {
        $breadcrumbs = [
            ['link' => "hrms", 'name' => "Home"],
            ['link' => "hrms/employee/", 'name' => "Employee Master"],
            ['name' => "edit"],
        ];
//Pageheader set true for breadcrumbs
        $pageConfigs = ['pageHeader' => true, 'isFabButton' => true,'isCustomizer'=>true];

        if ($Employee = EmployeeMaster::whereId($id)->first()) {
            return view('hrms.employee-master.edit', [
                'pageConfigs' => $pageConfigs,
                'breadcrumbs' => $breadcrumbs,
                'Employee_Details' => $Employee,
                'rolesMasters' => $this->getrolesMaster(),
                'GendersMasters' => $this->getGendersMasters(),
                'MaritalStatuseMasters' => $this->getMaritalStatuseMasters(),
                'EmployeeTypeMasters' => $this->getEmployeeTypeMasters(),
                'DesignationsMasters' => $this->getDesignationsMasters(),
                'DepartmentMasters' => $this->getDepartmentMasters(),
                'TeamsMasters' => $this->getTeamsMasters(),
                'VendorMasters' => $this->getVendorMasters(),
                'EmployeeIncrementsMasters' => $this->getEmployeeIncrementsMasters(),
                'ShiftMasters' => $this->getShiftMasters(),
                'RelationshipsMasters' => $this->getRelationshipsMasters(),
                'ReasonLeavesMasters' => $this->getReasonLeavesMasters(),
                'EmployeeScaleMasters' => $this->getEmployeeScaleMasters(),
                'CountryMasters' => $this->getCountryMasters(),
                'StateMasters' => $this->getStateMasters(),
                'CityMasters' => $this->getCityMasters(),
                'EmployeeDetails_EmployeeMasters' => $this->getEmployeeDetails_EmployeeMasters($id),
                'EmployeeDependents_EmployeeMasters' => $this->getEmployeeDependents_EmployeeMasters($id),
                'EmployeeGetMastersDetails' => $this->getEmployeeGetMastersDetails(),
            ]);
        }
    }

    public function getDepartmentIDByLeadEmp(Request $Request) {
        /* Auto get emp desgination using ajax call */
        $department_id = $Request->department_id;

        $getEmpDesignations = DB::table('employee_masters')
                ->select('departments.id',
                        'departments.department_name',
                        'employee_masters.full_Name')
                ->where('departments.id', '=', $department_id)
                ->where('departments.is_active', '=', '0')
                ->join('departments', 'departments.emp_department_lead_id', '=', 'employee_masters.id')
                ->get();
        foreach ($getEmpDesignations as $getEmpDesignation) {
            if ($department_id == $getEmpDesignation->id) {
                echo $getEmpDesignation->full_Name;
            }
        }
    }

    public function store(Request $request) {
//---------------------------------------------------------------------------------------

        /* file upload start */
        if ($request->hasFile('image_employee')) {

            $destinationPath = 'uploads/employees/';
            $files = $request->file('image_employee'); // will get all files
            $file_name = $files->getClientOriginalName(); //Get file original name
            $files->move($destinationPath, $file_name);
//            $done = Partyphoto::create([
//                     'party_id' => $last_id,
//                     'photos' => $file_name
//            ]);
        } else {
            $file_name = "user.png";
        }

        /* file upload end */
        //---------------------------------------------------------------------------------------

        $input = $request->all();
        $fullName = $request->f_name . ' ' . $request->l_name;

        $input['password'] = Hash::make($input['password']);
        $role_id = $request->roles;
        $user = User::create([
                    'name' => $fullName,
                    'email' => strtolower($request->email_id),
                    'email_verified_at' => $request->email_verified_at,
                    'password' => Hash::make($request->password),
                    'role' => $role_id,
                    'is_active' => '0',
        ]);
        $user_last_id = DB::getPDO()->lastInsertId();
        $user->assignRole($request->input('roles'));

        $First_arr = explode(' ', trim($request->f_name));
        $last_arr = explode(' ', trim($request->l_name));
        $emp_prifx = strtoupper($First_arr[0][0] . $last_arr[0][0]);

        $department_id = $request->department_id;
        $team_id = $request->team_id;
        $scale_id = $request->scale_id;
        echo 'user created';

        EmployeeMaster::create([
            'employee_id' => $emp_prifx . $request->employee_id,
            'user_id' => $user_last_id,
            'employee_image' => $file_name,
            'f_name' => $request->f_name,
            'l_name' => $request->l_name,
            'full_Name' => $fullName,
            'email_id' => strtolower($request->email_id),
            'password' => $request->password,
            'vendor_id' => $request->vendor_id,
            'team_id' => $team_id,
            'shift_id' => $request->shift_id,
            'designation_id' => $request->designation_id,
            'scale_id' => $scale_id,
            'department_id' => $department_id,
            'roles' => $request->roles,
            'hash_password' => Hash::make($request->password),
            'is_active' => $request->is_active
        ]);
        $Employees_last_id = DB::getPDO()->lastInsertId();

        $EmployeeDetails = EmployeeDetails::create([
                    'employee_masters_id' => $Employees_last_id,
                    'user_id' => $user_last_id,
                    'date_of_appointment' => $request->date_of_appointment,
                    'gender_id' => $request->gender_id,
                    'date_of_birth' => $request->date_of_birth,
                    'marital_id' => $request->marital_id,
                    'country_id' => $request->country_id,
                    'state_id' => $request->state_id,
                    'city_id' => $request->city_id,
                    'location_name' => $request->location_name,
                    'address_textArea' => $request->address_textArea,
                    'skype_id' => $request->skype_id,
                    'phone_number' => $request->phone_number,
                    'cell_number' => $request->cell_number,
                    'CNIC_number' => $request->CNIC_number,
                    'bank_name' => $request->bank_name,
                    'account_holder_name' => $request->account_holder_name,
                    'account_number' => $request->account_number,
                    'IFSC_number' => $request->IFSC_number,
                    'Swift_number' => $request->Swift_number,
                    'bank_address' => $request->bank_address,
                    'IBAN_number' => $request->IBAN_number,
                    'routing_number' => $request->routing_number,
                    'employee_type_id' => $request->employee_type_id,
                    'overtime_id' => $request->overtime_id,
                    'reason_id' => $request->reason_id,
                    'ipAddress' => $this->ipAddress(),
                    'is_active' => $request->is_active,
        ]);
//

        $dependent_name = $request->dependent_name;
        if (empty($dependent_name)) {
            
        } else {
            if (count($dependent_name) > 0) {
                $dependent_relationship_id = $request->dependent_relationship_id;
                $dependent_CNIC = $request->dependent_CNIC;
                $dependent_dob = $request->dependent_dob;
                for ($i = 0; $i < count($dependent_name); $i++) {
                    EmployeeDependent::create([
                        'user_id' => $user_last_id,
                        'employee_masters_id' => $Employees_last_id,
                        'dependent_name' => $dependent_name[$i],
                        'dependent_relationship_id' => $dependent_relationship_id[$i],
                        'dependent_CNIC' => $dependent_CNIC[$i],
                        'dependent_dob' => $dependent_dob[$i],
                        'is_active' => '0'
                    ]);
                }
                echo 'dependent_name++++';
            }
        }
//
//---------------------------------------------------------------------------------------------------------------------------------------
        /* dynimic update using department id start */

        DepartmentEmpAssign::create([
            'emp_id' => $Employees_last_id,
            'departments_id' => $department_id,
            'flag' => '1',
            'is_active' => '0'
        ]);

        $DepartmentEmpAssign_Count = DepartmentEmpAssign::where("departments_id", "=", $department_id);
        $count = $DepartmentEmpAssign_Count->count();
        $getDepartmentEmp_id = DB::table('departments')->where('id', ' = ', $department_id)->get();

        if (($getDepartmentEmp_id[0]->emp_ids) != '') {
            $implode = $getDepartmentEmp_id[0]->emp_ids . "," . ($Employees_last_id);
        } else {
            $implode = "," . ($Employees_last_id);
        }

        $Department = Department::findOrFail($department_id);
        $Department->update([
            'total_emp' => $count,
            'emp_ids' => $implode,
            'is_active' => '0',
        ]);
        $Department->save();

        /* dynimic update using department id end */
//---------------------------------------------------------------------------------------
        TeamEmpAssign::create([
            'emp_id' => $Employees_last_id,
            'team_id' => $team_id,
            'flag' => '1',
            'is_active' => '0'
        ]);

        $TeamEmpAssign_Count = TeamEmpAssign::where("team_id", "=", $team_id);
        $countTeamEmpAssign = $TeamEmpAssign_Count->count();

        $getTeamsEmp_id = DB::table('teams')->where('id', ' = ', $team_id)->get();


        $implode_TeamEmp = '';
        if (($getTeamsEmp_id[0]->emp_ids) != '') {
            $implode_TeamEmp = $getTeamsEmp_id[0]->emp_ids . "," . ($Employees_last_id);
        } else {
            $implode_TeamEmp = "," . ($Employees_last_id);
        }

        $Team = Team::findOrFail($team_id);
        $Team->update([
            'total_emp' => $countTeamEmpAssign,
            'emp_ids' => $implode_TeamEmp,
            'is_active' => '0',
        ]);
        $Team->save();


//---------------------------------------------------------------------------------------
//Scale update start $scale_id ScaleEmpAssign Scale scale_id scales
        ScaleEmpAssign::create([
            'emp_id' => $Employees_last_id,
            'scale_id' => $scale_id,
            'flag' => '1',
            'is_active' => '0'
        ]);

        $ScaleEmpAssign_Count = ScaleEmpAssign::where("scale_id", "=", $scale_id);
        $countScaleEmpAssign = $ScaleEmpAssign_Count->count();
        $getScaleEmp_id = DB::table('scales')->where('id', '=', $scale_id)->get();

        if (($getScaleEmp_id[0]->emp_ids) != '') {
            $implode_ScaleEmp = $getScaleEmp_id[0]->emp_ids . "," . ($Employees_last_id);
        } else {
            $implode_ScaleEmp = "," . ($Employees_last_id);
        }

        $Scale = Scale::findOrFail($scale_id);
        $Scale->update([
            'total_emp' => $countScaleEmpAssign,
            'emp_ids' => $implode_ScaleEmp,
            'is_active' => '0',
        ]);
        $Scale->save();
//Scale update end
//---------------------------------------------------------------------------------------
        redirect()->back()->with('success', 'Employee Create Successfully!');
        return redirect('hrms/employee/');
    }

    public function update(Request $Request, $id) {

        $input = $Request->all();

//        dd($Request);
        $user_id = EmployeeMaster::whereId($id)->first();

        /* Condition to check if user is there or empty
          if empty then insert data
          else update data
         */
        if ($user_id->user_id == null) {
            $deletOldRecord = EmployeeMaster::whereId($id)->first();
            $deletOldRecord->delete();

            if ($Request->hasFile('image_employee')) {

                $destinationPath = 'uploads/employees/';
                $files = $Request->file('image_employee'); // will get all files
                $file_name = $files->getClientOriginalName(); //Get file original name
                $files->move($destinationPath, $file_name);
            } else {
                $file_name = "user.png";
            }

            /* file upload end */
            //---------------------------------------------------------------------------------------

            $input = $Request->all();
            $fullName = $Request->f_name . ' ' . $Request->l_name;

            $input['password'] = Hash::make($input['password']);
            $role_id = $Request->roles;
            $user = User::create([
                        'name' => $fullName,
                        'email' => strtolower($Request->email_id),
                        'email_verified_at' => $Request->email_verified_at,
                        'password' => Hash::make($Request->password),
                        'role' => $role_id,
                        'is_active' => '0',
            ]);
            $user_last_id = DB::getPDO()->lastInsertId();
            $user->assignRole($Request->input('roles'));

            $First_arr = explode(' ', trim($Request->f_name));
            $last_arr = explode(' ', trim($Request->l_name));
            $emp_prifx = strtoupper($First_arr[0][0] . $last_arr[0][0]);

            $department_id = $Request->department_id;
            $team_id = $Request->team_id;
            $scale_id = $Request->scale_id;
            echo 'user created';

            EmployeeMaster::create([
                'employee_id' => $emp_prifx . $Request->employee_id,
                'user_id' => $user_last_id,
                'employee_image' => $file_name,
                'f_name' => $Request->f_name,
                'l_name' => $Request->l_name,
                'full_Name' => $fullName,
                'email_id' => strtolower($Request->email_id),
                'password' => $Request->password,
                'vendor_id' => $Request->vendor_id,
                'team_id' => $team_id,
                'shift_id' => $Request->shift_id,
                'designation_id' => $Request->designation_id,
                'scale_id' => $scale_id,
                'department_id' => $department_id,
                'roles' => $Request->roles,
                'hash_password' => Hash::make($Request->password),
                'is_active' => $Request->is_active
            ]);
            $Employees_last_id = DB::getPDO()->lastInsertId();

            $EmployeeDetails = EmployeeDetails::create([
                        'employee_masters_id' => $Employees_last_id,
                        'user_id' => $user_last_id,
                        'date_of_appointment' => $Request->date_of_appointment,
                        'gender_id' => $Request->gender_id,
                        'date_of_birth' => $Request->date_of_birth,
                        'marital_id' => $Request->marital_id,
                        'country_id' => $Request->country_id,
                        'state_id' => $Request->state_id,
                        'city_id' => $Request->city_id,
                        'location_name' => $Request->location_name,
                        'address_textArea' => $Request->address_textArea,
                        'skype_id' => $Request->skype_id,
                        'phone_number' => $Request->phone_number,
                        'cell_number' => $Request->cell_number,
                        'CNIC_number' => $Request->CNIC_number,
                        'bank_name' => $Request->bank_name,
                        'account_holder_name' => $Request->account_holder_name,
                        'account_number' => $Request->account_number,
                        'IFSC_number' => $Request->IFSC_number,
                        'Swift_number' => $Request->Swift_number,
                        'bank_address' => $Request->bank_address,
                        'IBAN_number' => $Request->IBAN_number,
                        'routing_number' => $Request->routing_number,
                        'employee_type_id' => $Request->employee_type_id,
                        'overtime_id' => $Request->overtime_id,
                        'reason_id' => $Request->reason_id,
                        'ipAddress' => $this->ipAddress(),
                        'is_active' => $Request->is_active,
            ]);
//

            $dependent_name = $Request->dependent_name;
            if (empty($dependent_name)) {
                
            } else {
                if (count($dependent_name) > 0) {
                    $dependent_relationship_id = $Request->dependent_relationship_id;
                    $dependent_CNIC = $Request->dependent_CNIC;
                    $dependent_dob = $Request->dependent_dob;
                    for ($i = 0; $i < count($dependent_name); $i++) {
                        EmployeeDependent::create([
                            'user_id' => $user_last_id,
                            'employee_masters_id' => $Employees_last_id,
                            'dependent_name' => $dependent_name[$i],
                            'dependent_relationship_id' => $dependent_relationship_id[$i],
                            'dependent_CNIC' => $dependent_CNIC[$i],
                            'dependent_dob' => $dependent_dob[$i],
                            'is_active' => '0'
                        ]);
                    }
                    echo 'dependent_name++++';
                }
            }
//
//---------------------------------------------------------------------------------------------------------------------------------------
            /* dynimic update using department id start */

            DepartmentEmpAssign::create([
                'emp_id' => $Employees_last_id,
                'departments_id' => $department_id,
                'flag' => '1',
                'is_active' => '0'
            ]);

            $DepartmentEmpAssign_Count = DepartmentEmpAssign::where("departments_id", "=", $department_id);
            $count = $DepartmentEmpAssign_Count->count();
            $getDepartmentEmp_id = DB::table('departments')->where('id', ' = ', $department_id)->get();

            if (($getDepartmentEmp_id[0]->emp_ids) != '') {
                $implode = $getDepartmentEmp_id[0]->emp_ids . "," . ($Employees_last_id);
            } else {
                $implode = "," . ($Employees_last_id);
            }

            $Department = Department::findOrFail($department_id);
            $Department->update([
                'total_emp' => $count,
                'emp_ids' => $implode,
                'is_active' => '0',
            ]);
            $Department->save();

            /* dynimic update using department id end */
//---------------------------------------------------------------------------------------
            TeamEmpAssign::create([
                'emp_id' => $Employees_last_id,
                'team_id' => $team_id,
                'flag' => '1',
                'is_active' => '0'
            ]);

            $TeamEmpAssign_Count = TeamEmpAssign::where("team_id", "=", $team_id);
            $countTeamEmpAssign = $TeamEmpAssign_Count->count();

            $getTeamsEmp_id = DB::table('teams')->where('id', ' = ', $team_id)->get();


            $implode_TeamEmp = '';
            if (($getTeamsEmp_id[0]->emp_ids) != '') {
                $implode_TeamEmp = $getTeamsEmp_id[0]->emp_ids . "," . ($Employees_last_id);
            } else {
                $implode_TeamEmp = "," . ($Employees_last_id);
            }

            $Team = Team::findOrFail($team_id);
            $Team->update([
                'total_emp' => $countTeamEmpAssign,
                'emp_ids' => $implode_TeamEmp,
                'is_active' => '0',
            ]);
            $Team->save();


//---------------------------------------------------------------------------------------
//Scale update start $scale_id ScaleEmpAssign Scale scale_id scales
            ScaleEmpAssign::create([
                'emp_id' => $Employees_last_id,
                'scale_id' => $scale_id,
                'flag' => '1',
                'is_active' => '0'
            ]);

            $ScaleEmpAssign_Count = ScaleEmpAssign::where("scale_id", "=", $scale_id);
            $countScaleEmpAssign = $ScaleEmpAssign_Count->count();
            $getScaleEmp_id = DB::table('scales')->where('id', '=', $scale_id)->get();

            if (($getScaleEmp_id[0]->emp_ids) != '') {
                $implode_ScaleEmp = $getScaleEmp_id[0]->emp_ids . "," . ($Employees_last_id);
            } else {
                $implode_ScaleEmp = "," . ($Employees_last_id);
            }

            $Scale = Scale::findOrFail($scale_id);
            $Scale->update([
                'total_emp' => $countScaleEmpAssign,
                'emp_ids' => $implode_ScaleEmp,
                'is_active' => '0',
            ]);
            $Scale->save();
        } // insert if over here
        else {
            $hash_password = Hash::make($input['password']);

            $user = User::find($user_id->user_id);
            $user->update([
                'name' => $Request->f_name,
                'email' => $Request->email_id,
                'password' => $hash_password,
                'is_active' => $Request->is_active,
            ]);
            DB::table('model_has_roles')->where('model_id', $user_id->user_id)->delete();
            $user->assignRole($Request->input('roles'));

//        $user = User::find($id);
//        $user->update($input);
//        DB::table('model_has_roles')->where('model_id', $id)->delete();
//        $user->assignRole($request->input('roles'));



            $First_arr = explode(' ', trim($Request->f_name));
            $last_arr = explode(' ', trim($Request->l_name));
            $emp_prifx = strtoupper($First_arr[0][0] . $last_arr[0][0]);
            $fullName = $Request->f_name . ' ' . $Request->l_name;

            $department_id = $Request->department_id;
            $team_id = $Request->team_id;
            $scale_id = $Request->scale_id;


            if ($department_id) {
//            $DepartmentEmpAssign = DepartmentEmpAssign::where('emp_id', $id)->get();
                $DepartmentEmpAssign = DB::table('department_emp_assigns')
                        ->where('emp_id', ' = ', $id)
                        ->where('departments_id', ' = ', $department_id)
                        ->get();
                if (($DepartmentEmpAssign->count()) == '0') {
//                echo 'no data';
                    DepartmentEmpAssign::create([
                        'emp_id' => $id,
                        'flag' => '1',
                        'departments_id' => $department_id,
                    ]);
                } else {
//                echo 'data';
                    $DepartmentEmpAssign->update([
                        'emp_id' => $id,
                        'flag' => '1',
                        'departments_id' => $department_id,
                    ]);
                    $DepartmentEmpAssign->save();
                }
//            ***
                $DepartmentEmpAssign_Count = DepartmentEmpAssign::where("departments_id", "=", $department_id);

                $Department = Department::findOrFail($department_id);
                $Department->update([
                    'total_emp' => $DepartmentEmpAssign_Count->count(),
                    'is_active' => '0',
                ]);
                $Department->save();
            }


            if ($team_id) {
//            $TeamEmpAssign = TeamEmpAssign::where('emp_id', $id)->get();
//             = TeamEmpAssign::where('emp_id', $id)->get();
                $TeamEmpAssign = DB::table('team_emp_assigns')
                        ->where('emp_id', ' = ', $id)
                        ->where('team_id', ' = ', $team_id)
                        ->get();

                if (($TeamEmpAssign->count()) == '0') {
                    TeamEmpAssign::create([
                        'emp_id' => $id,
                        'flag' => '1',
                        'team_id' => $team_id,
                    ]);
                } else {
                    $TeamEmpAssign->update([
                        'emp_id' => $id,
                        'flag' => '1',
                        'team_id' => $team_id,
                    ]);
                    $TeamEmpAssign->save();
                }
//            ***
                $TeamEmpAssign_Count = TeamEmpAssign::where("team_id", "=", $team_id);
                $Team = Team::findOrFail($team_id);
                $Team->update([
                    'total_emp' => $TeamEmpAssign_Count->count(),
                    'is_active' => '0',
                ]);
                $Team->save();
            }


            if ($scale_id) {
//            $ScaleEmpAssign = ScaleEmpAssign::where('emp_id', $id)->get();
                $ScaleEmpAssign = DB::table('scale_emp_assigns')
                        ->where('emp_id', ' = ', $id)
                        ->where('scale_id', ' = ', $scale_id)
                        ->get();
                if (($ScaleEmpAssign->count()) == '0') {
//                echo 'no data';
                    ScaleEmpAssign::create([
                        'emp_id' => $id,
                        'flag' => '1',
                        'scale_id' => $scale_id,
                    ]);
                } else {
//                echo 'data';
                    $ScaleEmpAssign->update([
                        'emp_id' => $id,
                        'flag' => '1',
                        'scale_id' => $scale_id,
                    ]);
                    $ScaleEmpAssign->save();
                }
//            ***
                $ScaleEmpAssign_Count = ScaleEmpAssign::where("scale_id", "=", $scale_id);
                $Scale = Scale::findOrFail($scale_id);
                $Scale->update([
                    'total_emp' => $ScaleEmpAssign_Count->count(),
                    'is_active' => '0',
                ]);
                $Scale->save();
            }

            //-------------------------------------------------------------------------------
//------------------------------------------------------------------
//
            $CourseUpdate = EmployeeMaster::find($id);
            $CourseImage = $Request->file('image_employee');
            $image_employee = $Request->image_employee;
            $image = $Request->hidden_image;
            if ($Request->hasFile('image_employee')) {
                $destinationPath = 'uploads/employees/';
                $profileImage = $CourseImage->getClientOriginalExtension();
                $CourseImage->move($destinationPath, $profileImage);
            } else {
                $CourseImage = $image_employee;
            }
            if (empty($image_employee)) {

                $CourseImage = $image;
            }
            //------------------------------------------------------------------


            $EmployeeMaster = EmployeeMaster::findOrFail($id);
            $EmployeeMaster->update([
                'employee_id' => $emp_prifx . substr($Request->employee_id, 2),
                'user_id' => $user_id->user_id,
                'employee_image' => $CourseImage,
                'f_name' => $Request->f_name,
                'l_name' => $Request->l_name,
                'full_Name' => $fullName,
                'email_id' => strtolower($Request->email_id),
                'password' => $Request->password,
                'designation_id' => $Request->designation_id,
                'shift_id' => $Request->shift_id,
                'vendor_id' => $Request->vendor_id,
                'department_id' => $department_id,
                'team_id' => $team_id,
                'scale_id' => $scale_id,
                'roles' => $Request->roles,
                'hash_password' => $hash_password,
                'is_active' => $Request->is_active
            ]);
            $EmployeeMaster->save();

            $EmployeeDetails = EmployeeDetails::where("employee_masters_id", "=", $id)->first();
            $EmployeeDetails->update([
                'employee_masters_id' => $id,
                'user_id' => $user_id->user_id,
                'date_of_appointment' => $Request->date_of_appointment,
                'gender_id' => $Request->gender_id,
                'date_of_birth' => $Request->date_of_birth,
                'marital_id' => $Request->marital_id,
                'country_id' => $Request->country_id,
                'state_id' => $Request->state_id,
                'city_id' => $Request->city_id,
                'location_name' => $Request->location_name,
                'address_textArea' => $Request->address_textArea,
                'skype_id' => $Request->skype_id,
                'phone_number' => $Request->phone_number,
                'cell_number' => $Request->cell_number,
                'CNIC_number' => $Request->CNIC_number,
                'bank_name' => $Request->bank_name,
                'account_holder_name' => $Request->account_holder_name,
                'account_number' => $Request->account_number,
                'IFSC_number' => $Request->IFSC_number,
                'Swift_number' => $Request->Swift_number,
                'bank_address' => $Request->bank_address,
                'IBAN_number' => $Request->IBAN_number,
                'routing_number' => $Request->routing_number,
                'employee_type_id' => $Request->employee_type_id,
                'overtime_id' => $Request->overtime_id,
                'reason_id' => $Request->reason_id,
                'ipAddress' => $this->ipAddress()
            ]);
            $EmployeeDetails->save();


            $dependent_name = 0;
            $dependent_name = $Request->dependent_name;
            $dependent_relationship_id = $Request->dependent_relationship_id;
            $dependent_CNIC = $Request->dependent_CNIC;
            $dependent_dob = $Request->dependent_dob;
            if (empty($dependent_name)) {
                
            } else {
//            $EmployeeDependentsDetails = DB::table('employee_dependents1')
//                            ->where('user_id', '=', $user_id->user_id)
//                            ->where('employee_masters_id', '=', $id)->get();

                $EmployeeDependentsDetails = EmployeeDependent::where("employee_masters_id", "=", $id);
                echo $EmployeeDependentsDetails->count();

                if ($EmployeeDependentsDetails->count() > 0) {
//                have data
                    if ($EmployeeDependentsDetails->forceDelete()) {
                        for ($i = 0; $i < count($dependent_name); $i++) {
                            EmployeeDependent::create([
                                'user_id' => $user_id->user_id,
                                'employee_masters_id' => $id,
                                'dependent_name' => $dependent_name[$i],
                                'dependent_relationship_id' => $dependent_relationship_id[$i],
                                'dependent_CNIC' => $dependent_CNIC[$i],
                                'dependent_dob' => $dependent_dob[$i],
                            ]);
                        }
                    }
                } else {
                    for ($i = 0; $i < count($dependent_name); $i++) {
                        EmployeeDependent::create([
                            'user_id' => $user_id->user_id,
                            'employee_masters_id' => $id,
                            'dependent_name' => $dependent_name[$i],
                            'dependent_relationship_id' => $dependent_relationship_id[$i],
                            'dependent_CNIC' => $dependent_CNIC[$i],
                            'dependent_dob' => $dependent_dob[$i],
                        ]);
                    }
                }
            }
        } // update else over here


        redirect()->back()->with('success', 'Employee Update Successfully!');
        return redirect('hrms/employee/');
    }

    function getdata() {

        $Employees = DB::table('employee_masters')
                ->where('employee_masters.deleted_at', '=', '')
                ->orWhereNull('employee_masters.deleted_at')
                ->select('employee_masters.id',
                        'status_codes.name',
                        'employee_masters.employee_id',
                        'employee_masters.full_Name',
                        'employee_masters.email_id',
                        'departments.department_name',
                        'teams.team_name',
//                        'scales.scale_name'
                )
                ->join('status_codes', 'status_codes.code', '=', 'employee_masters.is_active')
                ->join('departments', 'departments.id', '=', 'employee_masters.department_id')
                ->join('teams', 'teams.id', '=', 'employee_masters.team_id')
//                ->join('scales', 'scales.id', '=', 'employee_masters.scale_id')
                ->get();
        return Datatables::of($Employees)
                        ->addColumn('action', function($Employee) {
                            $actionBtn = '';
                            $actionBtn .= '<a href="' . route('hrms.employee.view', ['id' => $Employee->id]) . '"><i class="material-icons dp48">visibility</i></a>';
                            $actionBtn .= '<a href = "' . route('hrms.employee.edit', ['id' => $Employee->id]) . '" class = "invoice-action-edit edit" id = "' . $Employee->id . '"><i class="material-icons">edit</i></a>';
                            $actionBtn .= '<a href = "#" class = "invoice-action-view mr-4 delete" id = "' . $Employee->id . '"><i class="material-icons dp48 button delete-confirm">delete</i></a>';
                            return $actionBtn;
                        })
                        ->addColumn('checkbox', '<label><input type = "checkbox" class = "employee_checkbox" value = "{{$id}}" /><span></span></label>')
                        ->rawColumns(['checkbox', 'action'])
                        ->make(true);
    }

    function sentEmployeeDependentID_Delete(Request $request) {
        $employeeDependentID = $request->input('employeeDependentID');
//        $EmployeeDependent = EmployeeDependent::find($employeeDependentID);
////        if ($EmployeeDependent->delete()) {
//        echo 'Data Deleted';
////        }
        echo $employeeDependentID;
        $EmployeeDependent_delete = EmployeeDependent::findOrFail($employeeDependentID);
        $EmployeeDependent_delete->update([
            'is_active' => '1',
        ]);
        $EmployeeDependent_delete->save();
    }

    function delete(Request $request) {
        $Employees = EmployeeMaster::find($request->input('id'));
        if ($Employees->delete()) {
            echo 'Data Deleted';
        }
    }

    function multidelete(Request $request) {
        $Employee_id_array = $request->input('id');
        $Employee = EmployeeMaster:: whereIn('id', $Employee_id_array);
        if ($Employee->delete()) {
            echo 'Data Deleted';
        }
    }

}

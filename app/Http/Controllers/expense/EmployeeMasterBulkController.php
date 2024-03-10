<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Requests\ExcelBulkUploadRequest;
use App\EmployeeMaster;
use Auth;
use App\User;
use Validator;
use Mail;
use Carbon\Carbon;
use App\Helpers\Helper;
use Illuminate\Validation\Rule;

class EmployeeMasterBulkController extends Controller {

    private $Team;
    private $Department;
    private $Designation;
    private $Leads;
    private $SalaryType;
    private $getEmpType;
    private $Shift;
    private $Recruiter;
    private $Insurance;

    public function index() {
        $breadcrumbs = [
            ['link' => "/", 'name' => "Home"],
            ['link' => "emp/", 'name' => "Employee Master"],
            ['link' => "empbulk/bulkupload/index", 'name' => "Employee Bulk Upload"],
        ];
        $pageConfigs = ['pageHeader' => true, 'isFabButton' => true, 'isCustomizer' => true];
        $user = Auth::user();

        return view('employee-master.bulkupload.bulk_upload', [
            'pageConfigs' => $pageConfigs,
            'breadcrumbs' => $breadcrumbs,
        ]);
    }

    public function saveLeadManagementBulkUpload(ExcelBulkUploadRequest $request) {

        $line_no = 0;
        $flag = false;
        $existingLead = $this->getExsitingLead();
        $user = Auth::user();

        try {
            DB::beginTransaction();
            $ExcelArray = Excel::toArray(new Controller(), $request->file('excel_file'));
            $prepare_data = $this->setData($ExcelArray[0]);

            foreach ($prepare_data as $line_no => $row) {
                $mail_id = $row['email'];
                $lead_occur_count = count(array_filter($existingLead, function ($a)use ($mail_id) {
                            return $a == $mail_id;
                        }));
                if ($row['action'] == 'ADD') {


                    if ($lead_occur_count > 0) {
                        throw new \ErrorException($row['email'] . ' employee already existing');
                    }

                    $user = User::insertGetId([
                                'name' => $row['name'],
                                'email' => $row['email'],
                                'password' => bcrypt('Password@1234'),
                                'reset_password' => 0
                    ]);
                    DB::table('model_has_roles')->insert(
                            array(
                                'role_id' => '2',
                                'model_type' => 'App\User',
                                'model_id' => $user
                            )
                    );
                    $noti_period = date('Y-m-d', strtotime("+6 months", strtotime($row['date_of_appointment'])));

                    $EmployeeMaster = EmployeeMaster::insertGetId([
                                'name' => $row['name'],
                                'email' => $row['email'],
                                'user_id' => $user,
                                'contact_no' => $row['phone'],
                                'dob' => $row['dob'],
                                'date_of_appointment' => $row['date_of_appointment'],
                                'date_of_increment' => $row['date_of_increment'],
                                'team' => $row['team'],
                                'department' => $row['department'],
                                'designation' => $row['designation'],
                                'hr' => $row['hr'],
                                'department_lead' => $row['department_lead'],
                                'team_lead' => $row['team_lead'],
                                'salary_type' => $row['salary_type'],
                                'salary' => $row['salary'],
                                'employee_type' => $row['employee_type'],
                                'shift' => $row['shift'],
                                'recruiter' => $row['recruiter'],
                                'insurance_category' => $row['insurance_category'],
                                'nationality' => $row['nationality'],
                                'address' => $row['address'],
                                'home_country_address' => $row['home_country_address'],
                                'contact_number_home' => $row['contact_number_home'],
                                'emergency_contact_name' => $row['emergency_contact_name'],
                                'emergency_contact_number' => $row['emergency_contact_number'],
                                'ddl_marital_status' => $row['ddl_marital_status'],
                                'equipment_note' => $row['equipment_note']
                    ]);
                    DB::table("apiemp_document_master")->insertGetId([
                        'emp_id' => $EmployeeMaster,
                        'document_name' => 'Passport',
                        'document_not' => 'Upload by Excel',
                        'is_flag' => '1',
                        'fix_doc' => '1',
                    ]);
                    DB::table("apiemp_document_master")->insertGetId([
                        'emp_id' => $EmployeeMaster,
                        'document_name' => 'Visa',
                        'document_not' => 'Upload by Excel',
                        'is_flag' => '1', 'fix_doc' => '1',
                    ]);
                    DB::table("apiemp_document_master")->insertGetId([
                        'emp_id' => $EmployeeMaster,
                        'document_name' => 'Emirates ID',
                        'document_not' => 'Upload by Excel',
                        'is_flag' => '1', 'fix_doc' => '1',
                    ]);
                    DB::table("apiemp_document_master")->insertGetId([
                        'emp_id' => $EmployeeMaster,
                        'document_name' => 'Broker Card Number',
                        'document_not' => 'Upload by Excel',
                        'is_flag' => '1', 'fix_doc' => '1',
                    ]);
                    DB::table("apiemp_document_master")->insertGetId([
                        'emp_id' => $EmployeeMaster,
                        'document_name' => 'Agreeement',
                        'document_not' => 'Upload by Excel',
                        'is_flag' => '1', 'fix_doc' => '1',
                    ]);
                } else if ($row['action'] == 'DELETE') {
                    if ($lead_occur_count == 1) {
                        $employee_master = new EmployeeMaster();
                        $employee_master = $employee_master->where('email', $row['email']);
                        $employee_master->delete();
                    } else if ($lead_occur_count < 1) {
                        throw new \ErrorException('employee not found => ' . $row['email']);
                    } else {
                        throw new \ErrorException($row['email'] . "employee have no uniq Id please make it uniq first");
                    }
                } else if ($row['action'] == 'EDIT') {
                    if ($lead_occur_count == 1) {
                        $employeeMaster = new EmployeeMaster();
                        $employeeMaster = $employeeMaster->where('email', $row['email'])->first();
                        $employeeMaster->name = $row['name'];
                        $employeeMaster->email = $row['email'];
                        $employeeMaster->contact_no = $row['contact_no'];
                        $employeeMaster->dob = $row['dob'];
                        $employeeMaster->date_of_appointment = $row['date_of_appointment'];
                        $employeeMaster->date_of_increment = $row['date_of_increment'];
                        $employeeMaster->team = $row['team'];
                        $employeeMaster->department = $row['department'];
                        $employeeMaster->designation = $row['designation'];
                        $employeeMaster->hr = $row['hr'];
                        $employeeMaster->department_lead = $row['department_lead'];
                        $employeeMaster->team_lead = $row['team_lead'];
                        $employeeMaster->salary_type = $row['salary_type'];
                        $employeeMaster->salary = $row['salary'];
                        $employeeMaster->employee_type = $row['employee_type'];
                        $employeeMaster->shift = $row['shift'];
                        $employeeMaster->recruiter = $row['recruiter'];
                        $employeeMaster->insurance_category = $row['insurance_category'];

                        $employeeMaster->nationality = $row['nationality'];
                        $employeeMaster->address = $row['address'];
                        $employeeMaster->home_country_address = $row['home_country_address'];
                        $employeeMaster->emergency_contact_name = $row['emergency_contact_name'];
                        $employeeMaster->contact_number_home = $row['contact_number_home'];
                        $employeeMaster->emergency_contact_number = $row['emergency_contact_number'];
                        $employeeMaster->ddl_marital_status = $row['ddl_marital_status'];
                        $employeeMaster->equipment_note = $row['equipment_note'];

                        $employeeMaster->save();
                    } else if ($lead_occur_count < 1) {
                        throw new \ErrorException('Employee Not Found => ' . $row['email']);
                    } else {
                        throw new \ErrorException($row['email'] . " Emplyee have no uniq Id please Make It uniq first");
                    }
                }
            }
            DB::commit();
            return redirect()->route('emp')->with('success', 'Employee Excel data has been uploaded successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return self::index($request)->withErrors("Line No  " . ($line_no + 1) . " is " . $e->getMessage());
        }
    }

    public function getExsitingLead() {
        $leade_Master = EmployeeMaster::pluck("email", "id")->toArray();
        return $leade_Master;
    }

    public function setData($data) {
        $response = [];
        $getTeam = $this->getTeam();
        $getDepartment = $this->getDepartment();
        $getDesignation = $this->getDesignation();
        $getSalaryType = $this->getSalaryType();
        $getLeads = $this->getLeads();
        $getEmpType = $this->getEmpType();
        $getShift = $this->getShift();
        $getRecruiter = $this->getRecruiter();
        $getInsurance = $this->getInsurance();

        foreach ($data as $key => $row) {
            if ($key == 0) {
                continue;
            }
            if ($row[1] == null || (!isset($row[1]))) {
                continue;
            }
            if (strtoupper($row[0]) == "DELETE") {

                if ($row[0] == null || (!isset($row[1]) )) {
                    throw new \ErrorException('Please provide in all excel data');
                }
                $response[] = [
                    'action' => strtoupper($row[0]),
                    'email' => $row[1],
                ];
            } else {
                if ($row[0] == null ||
                        (!isset($row[1])) ||
                        (!isset($row[2])) ||
                        (!isset($row[3])) ||
                        (!isset($row[4])) ||
                        (!isset($row[5])) ||
                        (!isset($row[6])) ||
                        (!isset($row[7])) ||
                        (!isset($row[8])) ||
                        (!isset($row[9])) ||
                        (!isset($row[10])) ||
                        (!isset($row[11])) ||
                        (!isset($row[12])) ||
                        (!isset($row[13])) ||
                        (!isset($row[14])) ||
                        (!isset($row[15])) ||
                        (!isset($row[16])) ||
                        (!isset($row[17])) ||
                        (!isset($row[18]))
                ) {

                    throw new \ErrorException('Please provide in all excel data');
                }

                if (!isset($getTeam[strtoupper($row[7])])) {
                    throw new \ErrorException('Team not found');
                }
                if (!isset($getDepartment[strtoupper($row[8])])) {
                    throw new \ErrorException('Department not found');
                }
                $response[] = [
                    'action' => trim(strtoupper($row[0])),
                    'name' => $row[1],
                    'email' => $row[2],
                    'phone' => $row[3],
                    'dob' => $row[4],
                    'date_of_appointment' => $row[5],
                    'date_of_increment' => $row[6],
                    'team' => ($row[7] == '') ? '' : $getTeam[trim(strtoupper($row[7]))],
                    'department' => ($row[8] == '') ? '' : $getDepartment[trim(strtoupper($row[8]))],
                    'designation' => ($row[9] == '') ? '' : $getDesignation[trim(strtoupper($row[9]))],
                    'hr' => ($row[10] == '') ? '' : $getLeads[trim(strtoupper($row[10]))],
                    'department_lead' => ($row[11] == '') ? '' : $getLeads[trim(strtoupper($row[11]))],
                    'team_lead' => ($row[12] == '') ? '' : $getLeads[trim(strtoupper($row[12]))],
                    'salary_type' => ($row[13] == '') ? '' : $getSalaryType[trim(strtoupper($row[13]))],
                    'salary' => ($row[14] == '') ? '0' : $row[14],
                    'employee_type' => ($row[15] == '') ? '' : $getEmpType[trim(strtoupper($row[15]))],
                    'shift' => ($row[16] == '') ? '' : $getShift[trim(strtoupper($row[16]))],
                    'recruiter' => ($row[17] == '') ? '' : $getRecruiter[trim(strtoupper($row[17]))],
                    'insurance_category' => ($row[18] == '') ? '' : $getInsurance[trim(strtoupper($row[18]))],
                    'nationality' => ($row[19] == '') ? '' : $row[19],
                    'address' => ($row[20] == '') ? '' : $row[20],
                    'home_country_address' => ($row[21] == '') ? '' : $row[21],
                    'contact_number_home' => ($row[22] == '') ? '' : $row[22],
                    'emergency_contact_name' => ($row[23] == '') ? '' : $row[23],
                    'emergency_contact_number' => ($row[24] == '') ? '' : $row[24],
                    'ddl_marital_status' => ($row[25] == '') ? '' : $row[25],
                    'equipment_note' => ($row[26] == '') ? '' : $row[26],
                ];
            }
        }
        return $response;
    }

    private function getInsurance() {
        if (!isset($this->Insurance)) {
            $Insurancer = DB::table('insurance')->pluck('name', 'id')->toArray();
            foreach ($Insurancer as $id => $row) {
                $this->Insurance[strtoupper($row)] = $id;
            }
        }
        return $this->Insurance;
    }

    private function getRecruiter() {
        if (!isset($this->Recruiter)) {
            $Recruiter = DB::table('recruiter')->pluck('name', 'id')->toArray();
            foreach ($Recruiter as $id => $row) {
                $this->Recruiter[strtoupper($row)] = $id;
            }
        }
        return $this->Recruiter;
    }

    private function getShift() {
        if (!isset($this->Shift)) {
            $getShift = DB::table('shifts')->pluck('name', 'id')->toArray();
            foreach ($getShift as $id => $row) {
                $this->Shift[strtoupper($row)] = $id;
            }
        }
        return $this->Shift;
    }

    private function getEmpType() {
        if (!isset($this->EmpType)) {
            $getEmpType = DB::table('employee_types')->pluck('name', 'id')->toArray();
            foreach ($getEmpType as $id => $row) {
                $this->EmpType[strtoupper($row)] = $id;
            }
        }
        return $this->EmpType;
    }

    private function getSalaryType() {
        if (!isset($this->SalaryType)) {
            $SalaryType = DB::table('salary_type')->pluck('name', 'id')->toArray();
            foreach ($SalaryType as $id => $row) {
                $this->SalaryType[strtoupper($row)] = $id;
            }
        }
        return $this->SalaryType;
    }

    private function getTeam() {
        if (!isset($this->Team)) {
            $Team = DB::table('teams')->pluck('name', 'id')->toArray();
            foreach ($Team as $id => $row) {
                $this->Team[strtoupper($row)] = $id;
            }
        }
        return $this->Team;
    }

    private function getDepartment() {
        if (!isset($this->Department)) {
            $Department = DB::table('departments')->pluck('name', 'id')->toArray();
            foreach ($Department as $id => $row) {
                $this->Department[strtoupper($row)] = $id;
            }
        }
        return $this->Department;
    }

    private function getDesignation() {
        if (!isset($this->Designation)) {
            $Designation = DB::table('designations')->pluck('name', 'id')->toArray();
            foreach ($Designation as $id => $row) {
                $this->Designation[strtoupper($row)] = $id;
            }
        }
        return $this->Designation;
    }

    private function getLeads() {
        if (!isset($this->Leads)) {
            $Leads = DB::table('employees')->pluck('name', 'id')->toArray();
            foreach ($Leads as $id => $row) {
                $this->Leads[strtoupper($row)] = $id;
            }
        }
        return $this->Leads;
    }

}

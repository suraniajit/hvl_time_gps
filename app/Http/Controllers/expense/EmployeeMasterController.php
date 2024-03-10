<?php

namespace App\Http\Controllers;

use App\User;
use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Datatables;
use SweetAlert;
use Validator;
use PDF;
use Mail;
use Carbon\Carbon;
use Illuminate\Validation\Rule;
use App\Models\EmailTemplate\EmailTemplate;
use App\Mail\SendEmployeeOfferMail;

class EmployeeMasterController extends Controller {

    public function __construct() {

        $this->middleware('permission:Access employees', ['only' => ['show', 'index']]);
        $this->middleware('permission:Create employees', ['only' => ['create']]);
        $this->middleware('permission:Read employees', ['only' => ['read']]);
        $this->middleware('permission:Edit employees', ['only' => ['edit']]);
        $this->middleware('permission:Delete employees', ['only' => ['delete']]);
    }

    public function sendDocument_email(Request $request, $id = null) {
        $res = null;
        $document_details = (new Controller)->getConditionDynamicTableAll('apiemp_document_master', 'id', $request->agreeement_id);
        if ($document_details) {

            $DestinationPath = 'https://hherp.probsoltech.com/public/uploads/hherp/apiemp/' . $document_details[0]->emp_id . '/' . $document_details[0]->document_file;
//
            $data["email"] = "aatmaninfotech@gmail.com";
            $data["title"] = "From ItSolutionStuff.com";
            $data["body"] = "This is Demo";
            $data["note_send"] = $request->agriemnt_note_send;

            Mail::send('emails.attachments_emp_docuemt', ['request' => $request], function ($message) use ($request, $DestinationPath, $data) {
                $message->to($request->email_id, "Hitesh")->subject('Your Reminder!');
                $message->attach($DestinationPath);
            });
            $res = "0";
        } else {
            $res = "1";
        }

        return response()->json($res);

//        return redirect()->back();
    }

    function holidaysPdfUpdate(Request $request, $id) {


        $document_file_ = $request->file('pdf_file');
        if ($document_file_) {
            //DB::table('apiemp_document_master')->where('emp_id', $id)->delete();
            foreach ($document_file_ as $key => $value) {
                $document_file = $request->file('pdf_file')[$key];

                $FileExtension = $document_file->getClientOriginalExtension();
                $DestinationPath = 'public/uploads/hherp/holidayPDF/' . $id . '/'; //upload path
                $Media_Storing_Name = $document_file->getClientOriginalName();
                $fileName = str_replace(' ', '_', rand(999, 111) . (trim($Media_Storing_Name)));
                $document_file->move($DestinationPath, $fileName);

                DB::table("apiemp_holiday_document_master")->insertGetId([
                    'emp_id' => $id,
                    'document_file' => $fileName,
                    'file_extension' => $FileExtension,
                    'upload_date' => Carbon::today()->format('Y-m-d'),
                ]);
            }
        }
        redirect()->back()->with('success', 'Holiday PDF data has been uploaded successfully !');
        return redirect(route('emp.holidayshow', $id));
//        return redirect()->route('emp')->with('success', 'Holiday PDF data has been uploaded successfully');
    }

    function holidaysPdfView(Request $request, $id) {
        $breadcrumbs = [
            ['link' => "/", 'name' => "Home"],
            ['link' => "holiday_index/", 'name' => "Holiday Master"],
            ['name' => "Upload Form"],
        ];
        $pageConfigs = ['pageHeader' => true, 'isFabButton' => true, 'isCustomizer' => true];
        $holidaysDetails = (new Controller)->getConditionDynamicTableAll('apiemp_holidays_master', 'emp_id', $id);

        $name = (new Controller)->getConditionDynamicNameTable('employees', 'id', $id, 'name');

        return view('employee-master.holidays._holiday_pdf', [
            'pageConfigs' => $pageConfigs,
            'breadcrumbs' => $breadcrumbs,
            'name' => $name,
            'emp_id' => $id,
            'holidaysDetails' => $holidaysDetails
        ]);
    }

    function massremove(Request $request) {
        $emp_mass = $request->input('id');

        foreach ($emp_mass as $id) {


            $id_delete = (new Controller)->getConditionDynamicNameTable('employees', 'id', $id, 'user_id');
            $user = User::find($id_delete);
            $user->delete();

            DB::table('employees')->where('id', '=', $id)->delete();
            DB::table('apiemp_password_master')->where('emp_id', '=', $id)->delete();
            DB::table('apiemp_document_master')->where('emp_id', '=', $id)->delete();
            DB::table('apiemp_vehicle_master')->where('emp_id', '=', $id)->delete();
            DB::table('apiemp_bank_master')->where('emp_id', '=', $id)->delete();
            DB::table('apiemp_holidays_master')->where('emp_id', '=', $id)->delete();
        }
    }

    public function delete_($id) {
        $id_delete = (new Controller)->getConditionDynamicNameTable('employees', 'id', $id, 'user_id');
        
        $user = User::find($id_delete);
        DB::table('employees')->where('id', $id)->delete();
        DB::table('apiemp_password_master')->where('emp_id', $id)->delete();
        DB::table('apiemp_document_master')->where('emp_id', $id)->delete();
        DB::table('apiemp_vehicle_master')->where('emp_id', $id)->delete();
        DB::table('apiemp_bank_master')->where('emp_id', $id)->delete();
        DB::table('apiemp_holidays_master')->where('emp_id', $id)->delete();
        DB::table('apiemp_holiday_document_master')->where('emp_id', $id)->delete();
        DB::table('api_expenses')->where('is_user', $id)->delete();
        DB::table('api_expenses_action_log')->where('emp_id', $id)->delete();
        DB::table('api_expenses_documents')->where('emp_id', $id)->delete();
        return redirect()->back()->with('success', 'Employee Deleted Successfully !');
    }

    public function destroy(Request $request) {


        if ($request->input('delete') == 'password_details') {
            DB::table('apiemp_password_master')->where('id', $request->input('id'))->delete();
        } else if ($request->input('delete') == 'document_details') {
            DB::table('apiemp_document_master')->where('id', $request->input('id'))->delete();
        } else if ($request->input('delete') == 'vehicle_details') {
            DB::table('apiemp_vehicle_master')->where('id', $request->input('id'))->delete();
        } else if ($request->input('delete') == 'bank_details') {
            DB::table('apiemp_bank_master')->where('id', $request->input('id'))->delete();
        } else if ($request->input('delete') == 'holiday_details') {
            DB::table('apiemp_holidays_master')->where('id', $request->input('id'))->delete();
        } else if ($request->input('delete') == 'employee_holiday_pdf') {
            DB::table('apiemp_holiday_document_master')->where('id', $request->input('id'))->delete();
        } else if ($request->input('delete') == 'expance_document') {
            DB::table('api_expenses_documents')->where('id', $request->input('id'))->delete();
        } else if ($request->input('delete') == 'expance_details') {

            DB::table('api_expenses')->where('id', $request->input('id'))->delete();

            DB::table('api_expenses_documents')->where('emp_id', $request->input('id'))->delete();

            DB::table('api_expenses_action_log')->where('emp_id', '=', $request->input('id'))->delete();

            DB::table('employees')->where('user_id', '=', $request->input('id'))->update([
                'manager_id' => 0,
                'account_id' => 0,
            ]);
        } else if ($request->input('delete') == 'employee_details') {

            $id_delete = (new Controller)->getConditionDynamicNameTable('employees', 'id', $request->input('id'), 'user_id');
            $user = User::find($id_delete);
//            $user->delete();

            DB::table('employees')->where('id', $request->input('id'))->delete();
            DB::table('apiemp_password_master')->where('emp_id', $request->input('id'))->delete();
            DB::table('apiemp_document_master')->where('emp_id', $request->input('id'))->delete();
            DB::table('apiemp_vehicle_master')->where('emp_id', $request->input('id'))->delete();
            DB::table('apiemp_bank_master')->where('emp_id', $request->input('id'))->delete();
            DB::table('apiemp_holidays_master')->where('emp_id', $request->input('id'))->delete();
            DB::table('apiemp_holiday_document_master')->where('emp_id', $request->input('id'))->delete();
        }
    }

    function validcontact(Request $request) {
        if ($request->input('contact_no') !== '') {
            $rule = array(
                'contact_no' => 'unique:employees',
            );
            $validator = Validator::make($request->all(), $rule);
            if (!$validator->fails()) {
                die('true');
            }
        }
        die('false');
    }

    function getCallTeamDepartment(Request $request) {
        $team_id = $request->input('id');
        if ($request->ajax()) {
            $teams_data = DB::table("teams")
//                    ->join('departments', 'teams.department', '=', 'departments.id')
//                    ->select('teams.id',
//                            'teams.name as teamname',
//                            'departments.name as departmentsname')
                    ->where("teams.id", '=', $team_id)
                    ->where("teams.department", '!=', 0)
                    ->where("teams.department_lead", '!=', 0)
                    ->first();
            if ($teams_data) {
                $departments_name = DB::table("departments")
                        ->where("id", '=', $teams_data->department)
                        ->select("departments.*")
                        ->get();
                $departments_lead_name = DB::table("employees")
                        ->where("id", '=', $teams_data->department_lead)
                        ->select("employees.*")
                        ->get();

                $team_lead_name = DB::table("employees")
                        ->where("id", '=', $teams_data->team_lead)
                        ->select("employees.*")
                        ->get();
                $hr_name = DB::table("employees")
                        ->where("id", '=', $teams_data->hr)
                        ->select("employees.*")
                        ->get();

                $res = array(
                    'team_lead_name' => $team_lead_name,
                    'hr_name' => $hr_name,
                    'departments_name' => $departments_name,
                    'departments_lead_name' => $departments_lead_name,
                );
            } else {
                $departments_name = DB::table("departments")
                        ->select("departments.*")
                        ->get();
                $departments_lead_name = DB::table("employees")
                        ->select("employees.*")
                        ->get();
                $team_lead_name = DB::table("employees")
                        ->select("employees.*")
                        ->get();
                $hr_name = DB::table("employees")
                        ->select("employees.*")
                        ->get();
                $res = array(
                    'hr_name' => $hr_name,
                    'team_lead_name' => $team_lead_name,
                    'departments_name' => $departments_name,
                    'departments_lead_name' => $departments_lead_name,
                );
            }
            return response()->json($res);
        }
    }

    function validemail(Request $request) {

        if ($request->input('email') !== '') {
            $rule = array(
                'email' => 'unique:users',
            );
            $validator = Validator::make($request->all(), $rule);
            if (!$validator->fails()) {
                die('true');
            }
        }
        die('false');
    }

    public function editvalidname(Request $request) {
        $id = $request->id;
        $rule = array(
            'email' => Rule::unique('users', 'email')->ignore($id),
        );
        $validator = Validator::make($request->all(), $rule);
        if (!$validator->fails()) {
            die('true');
        }
        die('false');
    }

    public function editvalidcontact(Request $request) {
        $id = $request->id;
        $rule = array(
            'contact_no' => Rule::unique('employees', 'contact_no')->ignore($id),
        );
        $validator = Validator::make($request->all(), $rule);
        if (!$validator->fails()) {
            die('true');
        }
        die('false');
    }

    public function view($id) {

        $breadcrumbs = [
            ['link' => "emp", 'name' => "Home"],
            ['link' => "emp/", 'name' => "Employee Master"],
            ['name' => "View"],
        ];
        $pageConfigs = ['pageHeader' => true, 'isFabButton' => true, 'isCustomizer' => true];

        $recruiters_master = (new Controller)->getAllDynamicTable('recruiter');
        $shifts_master = (new Controller)->getAllDynamicTable('shifts');
        $teams_master = (new Controller)->getAllDynamicTable_OrderBy('teams', 'name');
        $departments_master = (new Controller)->getAllDynamicTable_OrderBy('departments', 'name');
        $designations_master = (new Controller)->getAllDynamicTable_OrderBy('designations', 'name');
        $employee_types_master = (new Controller)->getAllDynamicTable('employee_types');
        $PtypeDetails = (new Controller)->getAllDynamicTable('password_option');
        $equipmentDetails = (new Controller)->getAllDynamicTable('equipment');
        $issuanceDetails = (new Controller)->getAllDynamicTable('insurance');
        $employeesDetails = (new Controller)->getAllDynamicTable_OrderBy('employees', 'name');
        $salaryTypeDetails = (new Controller)->getAllDynamicTable('salary_type');

        $edit_details = (new Controller)->getConditionDynamicTable('employees', 'id', $id);

        $password_details = (new Controller)->getConditionDynamicTableAll('apiemp_password_master', 'emp_id', $id);
        $bank_details = (new Controller)->getConditionDynamicTableAll('apiemp_bank_master', 'emp_id', $id);
        $document_details = (new Controller)->getConditionDynamicTableAll('apiemp_document_master', 'emp_id', $id);
        $vehicleDetails = (new Controller)->getConditionDynamicTableAll('apiemp_vehicle_master', 'emp_id', $id);
        $account_master = (new Controller)->getConditionDynamicTable('api_account_master', 'emp_id', $id);

        $payment_status_master = (new Controller)->getAllDynamicTable('payment_status');
        $payment_method_master = (new Controller)->getAllDynamicTable('payment_method');
        $employee_master = (new Controller)->getAllDynamicTable_OrderBy('employees', 'name');

        $employee_shift = DB::table('apiemp_quipment_acess')
                ->where('apiemp_quipment_acess.emp_id', '=', $id)
                ->pluck('apiemp_quipment_acess.equipment_id', 'apiemp_quipment_acess.equipment_id')
                ->all();

        $hr_roles = 0;
        if ($edit_details->hr != 0) {
            $hr_roles = (new Controller)->getConditionDynamicNameTable('employees', 'id', $edit_details->hr, 'user_id');
        }

        return view('employee-master.view', [
            'pageConfigs' => $pageConfigs,
            'breadcrumbs' => $breadcrumbs,
            'teams_master' => $teams_master,
            'departments_master' => $departments_master, 'salaryTypeDetails' => $salaryTypeDetails,
            'designations_master' => $designations_master, 'PtypeDetails' => $PtypeDetails, 'issuanceDetails' => $issuanceDetails,
            'employee_types_master' => $employee_types_master, 'equipmentDetails' => $equipmentDetails, 'employeesDetails' => $employeesDetails,
            'recruiters_master' => $recruiters_master, 'shifts_master' => $shifts_master, 'view_details' => $edit_details,
            'password_details' => $password_details, 'bank_details' => $bank_details, 'document_details' => $document_details,
            'vehicleDetails' => $vehicleDetails, 'employee_shift' => $employee_shift,
            'account_master' => $account_master, 'employee_master' => $employee_master, 'payment_status_master' => $payment_status_master,
            'payment_method_master' => $payment_method_master,
            'hr_roles' => $hr_roles,
        ]);
    }

    public function holiday_index(Request $request) {
        $breadcrumbs = [
            ['link' => "/", 'name' => "Home"],
            ['link' => "/holiday_index", 'name' => "Holiday Master"],
        ];
        $pageConfigs = ['pageHeader' => true, 'isFabButton' => true, 'isCustomizer' => true];

        if (Auth::id() == 1) {
            $employee_details = (new Controller)->getAllDynamicTable_OrderBy('employees', 'name');
        } else {
            $employee_details = (new Controller)->getConditionDynamicTableAll('employees', 'user_id', Auth::id());
        }

        return view('employee-master.holidays.index.index', [
            'pageConfigs' => $pageConfigs,
            'breadcrumbs' => $breadcrumbs,
            'employee_details' => $employee_details,
        ]);
    }

    public function index(Request $request) {
//
//        $user_id = '1';
//        $messgae = 'it is testing';
//        $send_notification = (new Controller)->send_notification($user_id, $messgae);
//        dd($send_notification);
//        
//        $data = array('name' => "Hitesh", 'body' => "Controoler Gmail from Laravel + body");
//        Mail::send('employee-master.email-template.mail', ["data" => $data], function ($message) {
//            $message->to('hiteshv253@gmail.com', 'hitesh')
//                    ->subject('Employee Create');
//            $message->from('heetesh215@gmail.com', 'hitesh Vishwakarma');
//        });
//        if (Mail::failures()) {
//            return response()->Fail('Sorry! Please try again latter');
//        } else {
//            return response()->json('Yes, You have sent email to GMAIL from LARAVEL 5.8 !!');
//        }

        $breadcrumbs = [
            ['link' => "/", 'name' => "Home"],
            ['link' => "/emp/", 'name' => "Employee Master"],
        ];
        $rightlink = [
            ['rightlink' => "/emp/create", 'name' => "Create"],
        ];
        $deletelink = [
            ['name' => "Delete"],
        ];
        $downloadlink = [
            ['name' => "Delete"],
        ];
        $uploadloadlink = [
            ['uploadlink' => "/empbulk/bulkupload/index", 'name' => "Upload"],
        ];
        $pageConfigs = ['pageHeader' => true, 'isFabButton' => true, 'isCustomizer' => true];

        $recruiters_master = (new Controller)->getAllDynamicTable('recruiter');
        $shifts_master = (new Controller)->getAllDynamicTable('shifts');
        $teams_master = (new Controller)->getAllDynamicTable_OrderBy('teams', 'name');
        $departments_master = (new Controller)->getAllDynamicTable_OrderBy('departments', 'name');
        $designations_master = (new Controller)->getAllDynamicTable_OrderBy('designations', 'name');
        $employee_types_master = (new Controller)->getAllDynamicTable('employee_types');
        $PtypeDetails = (new Controller)->getAllDynamicTable('password_option');
        $equipmentDetails = (new Controller)->getAllDynamicTable('equipment');
        $issuanceDetails = (new Controller)->getAllDynamicTable('insurance');
        $employeesDetails = (new Controller)->getAllDynamicTable_OrderBy('employees', 'name');
        $salaryTypeDetails = (new Controller)->getAllDynamicTable('salary_type');
        $vehicleDetails = (new Controller)->getAllDynamicTable('apiemp_vehicle_master');

        $payment_status_master = (new Controller)->getAllDynamicTable('payment_status');
        $payment_method_master = (new Controller)->getAllDynamicTable('payment_method');
        $employee_master = (new Controller)->getAllDynamicTable_OrderBy('employees', 'name');

//        if (Auth::id() == 1) {
//            $employee_details = (new Controller)->getAllDynamicTable_OrderBy('employees','name');
//        } else {
//            $employee_details = (new Controller)->getConditionDynamicTableAll('employees', 'user_id', Auth::id());
//        }



        /**/
        $query = DB::table('employees')
                ->orderBy('employees.id', 'DESC');
        if ($request->ddl_account) {
            $query->where('employees.account_id', '=', $request->ddl_account);
        }
        if ($request->ddl_manager) {
            $query->where('employees.manager_id', '=', $request->ddl_manager);
        }
        if ($request->ddl_emp) {
            $query->where('employees.user_id', '=', $request->ddl_emp);
        }

        if ($request->ddl_team) {
            $query->where('employees.team', '=', $request->ddl_team);
        }
        if ($request->ddl_department) {
            $query->where('employees.department', '=', $request->ddl_department);
        }
        if ($request->ddl_designation) {
            $query->where('employees.designation', '=', $request->ddl_designation);
        }
        if ($request->ddl_shift) {
            $query->where('employees.shift', '=', $request->ddl_shift);
        }
        if ($request->ddl_recruiter) {
            $query->where('employees.recruiter', '=', $request->ddl_recruiter);
        }
        if ($request->ddl_salary_type) {
            $query->where('employees.salary_type', '=', $request->ddl_salary_type);
        }
        if ($request->ddl_employee_status) {
            $query->where('employees.employee_status', '=', $request->ddl_employee_status);
        }
        if ($request->ddl_date_filter) {

            if ($request->ddl_date_filter == "dob") {
                $to_date = $request->to_date;
                $from_date = $request->from_date;
                if ($to_date && $from_date) {
                    $query->orwhereBetween('employees.dob', [$to_date, $from_date]);
                }
            }
            if ($request->ddl_date_filter == "date_of_appointment") {
                $to_date = $request->to_date;
                $from_date = $request->from_date;
                if ($to_date && $from_date) {
                    $query->orwhereBetween('employees.date_of_appointment', [$to_date, $from_date]);
                }
            }
            if ($request->ddl_date_filter == "date_of_increment") {
                $to_date = $request->to_date;
                $from_date = $request->from_date;
                if ($to_date && $from_date) {
                    $query->orwhereBetween('employees.date_of_increment', [$to_date, $from_date]);
                }
            }
        }
        $query->select('*');

//        \DB::enableQueryLog(); // Enable query log
        $employee_details = $query->get();

        return view('employee-master.index', [
            'pageConfigs' => $pageConfigs,
            'rightlink' => $rightlink,
            //'deletelink' => $deletelink,
//            'downloadlink' => $downloadlink,
            'uploadloadlink' => $uploadloadlink,
            'breadcrumbs' => $breadcrumbs,
            'employee_details' => $employee_details,
            'teams_master' => $teams_master, 'payment_method_master' => $payment_method_master,
            'payment_status_master' => $payment_status_master, 'employee_master' => $employee_master,
            'departments_master' => $departments_master, 'salaryTypeDetails' => $salaryTypeDetails,
            'designations_master' => $designations_master, 'PtypeDetails' => $PtypeDetails, 'issuanceDetails' => $issuanceDetails,
            'employee_types_master' => $employee_types_master, 'equipmentDetails' => $equipmentDetails, 'employeesDetails' => $employeesDetails,
            'recruiters_master' => $recruiters_master, 'shifts_master' => $shifts_master,
        ]);
    }

    public function create() {

        $breadcrumbs = [
            ['link' => "emp", 'name' => "Home"],
            ['link' => "emp/", 'name' => "Employee Master"],
            ['name' => "Create"],
        ];
        $pageConfigs = ['pageHeader' => true, 'isFabButton' => true, 'isCustomizer' => true];

//         $result = (new OtherController)->exampleFunction();
//        getDynamicTable($table_name, $where_condition, $where_value, $get_value)
//        $result = (new OtherController)->getDynamicTable('recruiter', $where_condition, $where_value, $get_value);
//        $result = (new OtherController)->getDynamicTable('recruiter', $where_condition, $where_value, $get_value);

        $recruiters_master = (new Controller)->getAllDynamicTable('recruiter');
        $shifts_master = (new Controller)->getAllDynamicTable('shifts');
        $teams_master = (new Controller)->getAllDynamicTable_OrderBy('teams', 'name');

        $departments_master = (new Controller)->getAllDynamicTable_OrderBy('departments', 'name');

        $designations_master = (new Controller)->getAllDynamicTable_OrderBy('designations', 'name');
        $employee_types_master = (new Controller)->getAllDynamicTable('employee_types');
        $PtypeDetails = (new Controller)->getAllDynamicTable('password_option');
        $equipmentDetails = (new Controller)->getAllDynamicTable('equipment');
        $issuanceDetails = (new Controller)->getAllDynamicTable('insurance');
        $employeesDetails = (new Controller)->getAllDynamicTable_OrderBy('employees', 'name');
        $salaryTypeDetails = (new Controller)->getAllDynamicTable('salary_type');
        $vehicleDetails = (new Controller)->getAllDynamicTable('apiemp_vehicle_master');

        $payment_status_master = (new Controller)->getAllDynamicTable('payment_status');
        $payment_method_master = (new Controller)->getAllDynamicTable('payment_method');
        $employee_master = (new Controller)->getAllDynamicTable_OrderBy('employees', 'name');

        return view('employee-master.create', [
            'pageConfigs' => $pageConfigs,
            'breadcrumbs' => $breadcrumbs,
            'teams_master' => $teams_master,
            'payment_method_master' => $payment_method_master,
            'payment_status_master' => $payment_status_master,
            'employee_master' => $employee_master,
            'departments_master' => $departments_master, 'salaryTypeDetails' => $salaryTypeDetails,
            'designations_master' => $designations_master, 'PtypeDetails' => $PtypeDetails, 'issuanceDetails' => $issuanceDetails,
            'employee_types_master' => $employee_types_master, 'equipmentDetails' => $equipmentDetails, 'employeesDetails' => $employeesDetails,
            'recruiters_master' => $recruiters_master, 'shifts_master' => $shifts_master,
            'password_details' => 0, 'bank_details' => 0, 'document_details' => 0, 'vehicleDetails' => 0
        ]);
    }

    public function holidayupdate(Request $request, $id) {


        DB::table('apiemp_holidays_master')->where('emp_id', $id)->delete();
        $holiday_name = $request->holiday_name;

        if (($holiday_name != null) && count($holiday_name) > 0) {
            foreach ($holiday_name as $key => $value) {
                DB::table("apiemp_holidays_master")->insertGetId([
                    'emp_id' => $id,
                    'holiday_type' => $request->holiday_type[$key],
                    'holiday_name' => $request->holiday_name[$key],
                    'holiday_date' => $request->holiday_date[$key],
                    'holiday_note' => $request->holiday_note[$key],
                ]);
            }
        }
        $send_notification = (new Controller)->send_notification('1', "Holidays Upload Successfully");
        return redirect()->back()->with('success', 'Custome Holiday Updated Successfully !');
        redirect(route('emp.holidayshow', $id));
    }

    public function holidayshow($id) {
        $breadcrumbs = [
            ['link' => "/", 'name' => "Home"],
            ['link' => "holiday_index", 'name' => "Holiday Master"],
            ['name' => "Holiday's list"],
        ];
        $pageConfigs = ['pageHeader' => true, 'isFabButton' => true, 'isCustomizer' => true];
        $holidaysDetails = (new Controller)->getConditionDynamicTableAll('apiemp_holidays_master', 'emp_id', $id);
        $name = (new Controller)->getConditionDynamicNameTable('employees', 'id', $id, 'name');
        $holidaysPDFDetails = (new Controller)->getConditionDynamicTableAll('apiemp_holiday_document_master', 'emp_id', $id);

        return view('employee-master.holidaybulkupload.emp_list_holiday', [
            'pageConfigs' => $pageConfigs,
            'breadcrumbs' => $breadcrumbs,
            'name' => $name,
            'holidaysPDFDetails' => $holidaysPDFDetails,
            'emp_id' => $id,
            'holidaysDetails' => $holidaysDetails
        ]);
    }

    public function edit($id) {

        $breadcrumbs = [
            ['link' => "/", 'name' => "Home"],
            ['link' => "emp/", 'name' => "Employee Master"],
            ['name' => "Edit"],
        ];
        $pageConfigs = ['pageHeader' => true, 'isFabButton' => true, 'isCustomizer' => true];

        $recruiters_master = (new Controller)->getAllDynamicTable('recruiter');
        $shifts_master = (new Controller)->getAllDynamicTable('shifts');
        $teams_master = (new Controller)->getAllDynamicTable_OrderBy('teams', 'name');
        $departments_master = (new Controller)->getAllDynamicTable_OrderBy('departments', 'name');
        $designations_master = (new Controller)->getAllDynamicTable_OrderBy('designations', 'name');
        $employee_types_master = (new Controller)->getAllDynamicTable('employee_types');
        $PtypeDetails = (new Controller)->getAllDynamicTable('password_option');
        $equipmentDetails = (new Controller)->getAllDynamicTable('equipment');
        $issuanceDetails = (new Controller)->getAllDynamicTable('insurance');
        $employeesDetails = (new Controller)->getAllDynamicTable_OrderBy('employees', 'name');
        $salaryTypeDetails = (new Controller)->getAllDynamicTable('salary_type');

        $edit_details = (new Controller)->getConditionDynamicTable('employees', 'id', $id);
        $password_details = (new Controller)->getConditionDynamicTableAll('apiemp_password_master', 'emp_id', $id);
        $bank_details = (new Controller)->getConditionDynamicTableAll('apiemp_bank_master', 'emp_id', $id);
//        $document_details = (new Controller)->getConditionDynamicTableAll('apiemp_document_master', 'emp_id', $id);
        $vehicleDetails = (new Controller)->getConditionDynamicTableAll('apiemp_vehicle_master', 'emp_id', $id);
        $account_master = (new Controller)->getConditionDynamicTable('api_account_master', 'emp_id', $id);
        $employee_shift = DB::table('apiemp_quipment_acess')
                ->where('apiemp_quipment_acess.emp_id', '=', $id)
                ->pluck('apiemp_quipment_acess.equipment_id', 'apiemp_quipment_acess.equipment_id')
                ->all();

        $payment_status_master = (new Controller)->getAllDynamicTable('payment_status');
        $payment_method_master = (new Controller)->getAllDynamicTable('payment_method');
        $employee_master = (new Controller)->getAllDynamicTable_OrderBy('employees', 'name');

        $hr_roles = 0;
        if ($edit_details->hr != 0) {
            $hr_roles = (new Controller)->getConditionDynamicNameTable('employees', 'id', $edit_details->hr, 'user_id');
        }
        $document_mandatory_details = DB::table('apiemp_document_master')
                ->where('emp_id', '=', $id)
                ->where('fix_doc', '=', 1)
                ->get();
        $document_details = DB::table('apiemp_document_master')
                ->where('emp_id', '=', $id)
                ->where('fix_doc', '=', 0)
                ->get();

        return view('employee-master.edit', [
            'pageConfigs' => $pageConfigs,
            'breadcrumbs' => $breadcrumbs,
            'payment_status_master' => $payment_status_master,
            'payment_method_master' => $payment_method_master,
            'teams_master' => $teams_master,
            'employee_master' => $employee_master,
            'departments_master' => $departments_master, 'salaryTypeDetails' => $salaryTypeDetails,
            'designations_master' => $designations_master, 'PtypeDetails' => $PtypeDetails, 'issuanceDetails' => $issuanceDetails,
            'employee_types_master' => $employee_types_master, 'equipmentDetails' => $equipmentDetails, 'employeesDetails' => $employeesDetails,
            'recruiters_master' => $recruiters_master, 'shifts_master' => $shifts_master, 'edit_details' => $edit_details,
            'password_details' => $password_details, 'bank_details' => $bank_details,
            'document_details' => $document_details,
            'document_mandatory_details' => $document_mandatory_details,
            'vehicleDetails' => $vehicleDetails,
            'employee_shift' => $employee_shift, 'account_master' => $account_master, 'hr_roles' => $hr_roles
        ]);
    }

    public function update(Request $request, $id) {

        $apiemp_master = DB::table('employees')->where('id', '=', $id)->update([
            'name' => $request->name,
            'email' => $request->email,
            'contact_no' => $request->contact_no,
            'dob' => $request->dob,
            'date_of_appointment' => $request->date_of_appointment,
            'upcoming_probation_period' => date('Y-m-d', strtotime("+6 months", strtotime($request->date_of_appointment))),
            'notification_date_probation' => date('Y-m-d', strtotime("-1 months", strtotime(date('Y-m-d', strtotime("+6 months", strtotime($request->date_of_appointment)))))),
            'date_of_increment' => $request->date_of_increment,
            'team' => $request->ddl_team,
            'team_lead' => $request->ddl_team_lead,
            'department' => $request->ddl_department,
            'department_lead' => $request->dd_department_lead,
            'designation' => $request->ddl_designation,
            'hr' => $request->dd_hr,
            'shift' => $request->ddl_shift,
            'salary' => $request->salary,
            'salary_type' => $request->ddl_salary_type,
            'employee_type' => $request->ddl_employee_type,
            'recruiter' => $request->ddl_recruiter,
            'insurance_category' => $request->ddl_issuance_type,
            'employee_status' => $request->employee_status,
            'manager_id' => $request->manager_id,
            'account_id' => $request->account_id,
            'nationality' => $request->nationality,
            'address' => $request->address,
            'home_country_address' => $request->home_country_address,
            'emergency_contact_name' => $request->emergency_contact_name,
            'emergency_contact_number' => $request->emergency_contact_number,
            'contact_number_home' => $request->contact_number_home,
            'ddl_marital_status' => $request->ddl_marital_status,
            'equipment_note' => $request->equipment_note,
            'target' => $request->target,
            'commission' => $request->commission,
            'date_of_resignation' => $request->date_of_resignation,
        ]);

        /* api_account_master */
        if ($request->manager_id) {
            DB::table("api_account_master")->where('emp_id', '=', $id)->update([
                'emp_id' => $id,
                'manager_id' => $request->manager_id,
                'account_id' => $request->account_id,
                'payment_status_id' => $request->payment_status_id,
                'note' => $request->note,
            ]);
        }
        /* api_account_master */


        $bank_name = $request->bank_name;

        if (($bank_name != null) && count($bank_name) > 0) {
            DB::table('apiemp_bank_master')->where('emp_id', $id)->delete();
            foreach ($bank_name as $key => $value) {
                DB::table("apiemp_bank_master")->insertGetId([
                    'emp_id' => $id,
                    'bank_name' => $request->bank_name[$key],
                    'bank_type' => $request->bank_type[$key],
                    'bank_account_number' => $request->bank_account_number[$key],
                    'bank_customer_name' => $request->bank_customer_name[$key],
                    'IBAN' => $request->IBAN[$key],
                    'bank_note' => $request->bank_note[$key],
                ]);
            }
        }
//====================================================================================
// Mandatory Documents Details end

        if ($request->document_passport) {
            $document_file = $request->file('document_passport_file');
            if ($document_file) {
                $FileExtension = $document_file->getClientOriginalExtension();
                $DestinationPath = 'public/uploads/hherp/apiemp/' . $id . '/'; //upload path
                $Media_Storing_Name = $document_file->getClientOriginalName();
                $fileName = str_replace(' ', '_', rand(999, 111) . (trim($Media_Storing_Name)));
                $document_file->move($DestinationPath, $fileName);
                DB::table("apiemp_document_master")
                        ->where('document_name', '=', $request->document_passport)
                        ->where('emp_id', '=', $id)
                        ->where('fix_doc', '=', 1)
                        ->update([
                            'document_expiry' => ($request->document_passport_exp) ? $request->document_passport_exp : "",
                            'document_file' => ($fileName) ? $fileName : '',
                            'document_not' => ($request->document_passport_not) ? $request->document_passport_not : "",
                            'file_extension' => ($FileExtension) ? $FileExtension : "-",
                            'is_upload' => '1',
                ]);
            } else {
                DB::table("apiemp_document_master")
                        ->where('document_name', '=', $request->document_passport)
                        ->where('emp_id', '=', $id)
                        ->where('fix_doc', '=', 1)
                        ->update([
                            'document_expiry' => ($request->document_passport_exp) ? $request->document_passport_exp : "",
                            'document_not' => ($request->document_passport_not) ? $request->document_passport_not : "",
                ]);
            }
        }
        if ($request->document_visa) {
            $document_file = $request->file('document_visa_file');
            if ($document_file) {
                $FileExtension = $document_file->getClientOriginalExtension();
                $DestinationPath = 'public/uploads/hherp/apiemp/' . $id . '/'; //upload path
                $Media_Storing_Name = $document_file->getClientOriginalName();
                $fileName = str_replace(' ', '_', rand(999, 111) . (trim($Media_Storing_Name)));
                $document_file->move($DestinationPath, $fileName);
                DB::table("apiemp_document_master")
                        ->where('document_name', '=', $request->document_visa)
                        ->where('emp_id', '=', $id)
                        ->where('fix_doc', '=', 1)
                        ->update([
                            'document_expiry' => ($request->document_visa_exp) ? $request->document_visa_exp : "",
                            'document_file' => ($fileName) ? $fileName : '',
                            'document_not' => ($request->document_visa_not) ? $request->document_visa_not : "",
                            'file_extension' => ($FileExtension) ? $FileExtension : "-",
                            'is_upload' => '1',
                ]);
            } else {
                DB::table("apiemp_document_master")
                        ->where('document_name', '=', $request->document_visa)
                        ->where('emp_id', '=', $id)
                        ->where('fix_doc', '=', 1)
                        ->update([
                            'document_expiry' => ($request->document_visa_exp) ? $request->document_visa_exp : "",
                            'document_not' => ($request->document_visa_not) ? $request->document_visa_not : "",
                ]);
            }
        }
        if ($request->document_emirates) {
            $document_file = $request->file('document_emirates_file');
            if ($document_file) {

                $FileExtension = $document_file->getClientOriginalExtension();
                $DestinationPath = 'public/uploads/hherp/apiemp/' . $id . '/'; //upload path
                $Media_Storing_Name = $document_file->getClientOriginalName();
                $fileName = str_replace(' ', '_', rand(999, 111) . (trim($Media_Storing_Name)));
                $document_file->move($DestinationPath, $fileName);

                DB::table("apiemp_document_master")
                        ->where('document_name', '=', $request->document_emirates)
                        ->where('emp_id', '=', $id)
                        ->where('fix_doc', '=', 1)
                        ->update([
                            'document_expiry' => ($request->document_emirates_exp) ? $request->document_emirates_exp : "",
                            'document_file' => ($fileName) ? $fileName : '',
                            'document_not' => ($request->document_emirates_not) ? $request->document_emirates_not : "",
                            'file_extension' => ($FileExtension) ? $FileExtension : "-",
                            'is_upload' => '1',
                ]);
            } else {
                DB::table("apiemp_document_master")
                        ->where('document_name', '=', $request->document_emirates)
                        ->where('emp_id', '=', $id)
                        ->where('fix_doc', '=', 1)
                        ->update([
                            'document_expiry' => ($request->document_emirates_exp) ? $request->document_emirates_exp : "",
                            'document_not' => ($request->document_emirates_not) ? $request->document_emirates_not : "",
                ]);
            }
        }
        if ($request->document_broker) {
            $document_file = $request->file('document_broker_file');
            if ($document_file) {


                $FileExtension = $document_file->getClientOriginalExtension();
                $DestinationPath = 'public/uploads/hherp/apiemp/' . $id . '/'; //upload path
                $Media_Storing_Name = $document_file->getClientOriginalName();
                $fileName = str_replace(' ', '_', rand(999, 111) . (trim($Media_Storing_Name)));
                $document_file->move($DestinationPath, $fileName);

                DB::table("apiemp_document_master")
                        ->where('document_name', '=', $request->document_broker)
                        ->where('emp_id', '=', $id)
                        ->where('fix_doc', '=', 1)
                        ->update([
                            'document_expiry' => ($request->document_broker_exp) ? $request->document_broker_exp : "",
                            'document_file' => ($fileName) ? $fileName : '',
                            'document_not' => ($request->document_broker_not) ? $request->document_broker_not : "",
                            'file_extension' => ($FileExtension) ? $FileExtension : "-",
                            'is_upload' => '1',
                ]);
            } else {
                DB::table("apiemp_document_master")
                        ->where('document_name', '=', $request->document_broker)
                        ->where('emp_id', '=', $id)
                        ->where('fix_doc', '=', 1)
                        ->update([
                            'document_expiry' => ($request->document_broker_exp) ? $request->document_broker_exp : "",
                            'document_not' => ($request->document_broker_not) ? $request->document_broker_not : "",
                ]);
            }
        }
        if ($request->document_agreement) {
            $document_file = $request->file('document_agreement_file');
            if ($document_file) {

                $FileExtension = $document_file->getClientOriginalExtension();
                $DestinationPath = 'public/uploads/hherp/apiemp/' . $id . '/'; //upload path
                $Media_Storing_Name = $document_file->getClientOriginalName();
                $fileName = str_replace(' ', '_', rand(999, 111) . (trim($Media_Storing_Name)));
                $document_file->move($DestinationPath, $fileName);

                DB::table("apiemp_document_master")
                        ->where('document_name', '=', $request->document_agreement)
                        ->where('emp_id', '=', $id)
                        ->where('fix_doc', '=', 1)
                        ->update([
                            'document_expiry' => ($request->document_agreement_exp) ? $request->document_agreement_exp : "",
                            'document_file' => ($fileName) ? $fileName : '',
                            'document_not' => ($request->document_agreement_not) ? $request->document_agreement_not : "",
                            'file_extension' => ($FileExtension) ? $FileExtension : "-",
                            'is_upload' => '1',
                ]);
            } else {
                DB::table("apiemp_document_master")
                        ->where('document_name', '=', $request->document_agreement)
                        ->where('emp_id', '=', $id)
                        ->where('fix_doc', '=', 1)
                        ->update([
                            'document_expiry' => ($request->document_agreement_exp) ? $request->document_agreement_exp : "",
                            'document_not' => ($request->document_agreement_not) ? $request->document_agreement_not : "",
                ]);
            }
        }


        //============end of mendorotry files========================================================================
        $document_name = $request->document_name;
        $document_file_ = $request->file('document_file');
        if ($document_file_) {
            if (($document_name != null) && count($document_name) > 0) {
//                DB::table('apiemp_document_master')->where('fix_doc', '=', 0)->where('emp_id', $id)->delete();

                foreach ($document_name as $key => $value) {
                    $document_file = $request->document_file[$key];

                    $FileExtension = $document_file->getClientOriginalExtension();
                    $DestinationPath = 'public/uploads/hherp/apiemp/' . $id . '/'; //upload path
                    $Media_Storing_Name = $document_file->getClientOriginalName();
                    $fileName = str_replace(' ', '_', rand(999, 111) . (trim($Media_Storing_Name)));
                    $document_file->move($DestinationPath, $fileName);
                    DB::table("apiemp_document_master")->insertGetId([
                        'emp_id' => $id,
                        'document_name' => $request->document_name[$key],
                        'document_expiry' => ($request->document_expiry[$key]) ? $request->document_expiry[$key] : '',
                        'document_file' => ($fileName) ? $fileName : '',
                        'document_not' => ($request->pass_note[$key]) ? $request->pass_note[$key] : "",
                        'file_extension' => ($FileExtension) ? $FileExtension : "",
                        'is_upload' => '1',
                    ]);
                }
            }
        }

        $pass_pass_type = $request->pass_type;
        if (($pass_pass_type != null) && count($pass_pass_type) > 0) {
            DB::table('apiemp_password_master')->where('emp_id', $id)->delete();
            foreach ($pass_pass_type as $key => $value) {
                DB::table("apiemp_password_master")->insertGetId([
                    'emp_id' => $id,
                    'pass_type' => $request->pass_type[$key],
                    'password' => $request->pass_name[$key],
                    'pass_note' => $request->pass_note[$key],
                ]);
            }
        }
        $vehicle_name = $request->vehicle_name;
        if (($vehicle_name != null) && count($vehicle_name) > 0) {
            DB::table('apiemp_vehicle_master')->where('emp_id', $id)->delete();
            foreach ($vehicle_name as $key => $value) {
                DB::table("apiemp_vehicle_master")->insertGetId([
                    'emp_id' => $id,
                    'vehicle_name' => $request->vehicle_name[$key],
                    'vehicle_number' => $request->vehicle_number[$key],
                    'vehicle_mileage' => $request->vehicle_mileage[$key],
                    'vehicle_run_start' => $request->vehicle_run_start[$key],
                    'vehicle_run_end' => $request->vehicle_run_end[$key],
                    'vehicle_note' => $request->vehicle_note[$key],
                ]);
            }
        }
        if (($request->ddl_equipment != null) && count($request->ddl_equipment) > 0) {
            DB::table('apiemp_quipment_acess')->where('emp_id', $id)->delete();
            foreach ($request->ddl_equipment as $e) {
                DB::table('apiemp_quipment_acess')->insert(
                        ['emp_id' => $id, 'equipment_id' => $e]
                );
            }
        }

        $send_notification = (new Controller)->send_notification('1', "Employee Update Successfully");
        return redirect(route('emp'))->with('success', 'Employee has been updated!');
    }

    public function document_file_upload(Request $request) {
        dd($request->all());
    }

    public function store(Request $request) {


//        $this->validate($request, [
//            'email' => 'required|email|unique:users',
//        ]);
        $user = User::insertGetId([
                    'name' => $request->name,
                    'email' => $request->email,
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
        /* assgin default roles of 'employee' end */
//        $effectiveDate = $request->date_of_appointment;
//        $noti_period = date('Y-m-d', strtotime("+6 months", strtotime($effectiveDate)));
//        $notification_date = date('Y-m-d', strtotime("-1 months", strtotime($noti_period)));

        $apiemp_master = DB::table('employees')->insertGetId([
            'name' => $request->name,
            'is_user' => Auth::id(),
            'user_id' => $user,
            'email' => $request->email,
            'contact_no' => $request->contact_no,
            'dob' => $request->dob,
            'date_of_appointment' => $request->date_of_appointment,
            'upcoming_probation_period' => date('Y-m-d', strtotime("+6 months", strtotime($request->date_of_appointment))),
            'notification_date_probation' => date('Y-m-d', strtotime("-1 months", strtotime(date('Y-m-d', strtotime("+6 months", strtotime($request->date_of_appointment)))))),
            'date_of_increment' => $request->date_of_increment,
            'team' => $request->ddl_team,
            'team_lead' => $request->ddl_team_lead,
            'department' => $request->ddl_department,
            'department_lead' => $request->dd_department_lead,
            'designation' => $request->ddl_designation,
            'hr' => $request->dd_hr,
            'shift' => $request->ddl_shift,
            'salary' => $request->salary,
            'salary_type' => $request->ddl_salary_type,
            'employee_type' => $request->ddl_employee_type,
            'recruiter' => $request->ddl_recruiter,
            'insurance_category' => $request->ddl_issuance_type,
            'employee_status' => $request->employee_status,
            'flag' => '1', // from system 
            'nationality' => $request->nationality,
            'address' => $request->address,
            'home_country_address' => $request->home_country_address,
            'emergency_contact_name' => $request->emergency_contact_name,
            'emergency_contact_number' => $request->emergency_contact_number,
            'contact_number_home' => $request->contact_number_home,
            'ddl_marital_status' => $request->ddl_marital_status,
            'equipment_note' => $request->equipment_note,
            'target' => $request->target,
            'commission' => $request->commission,
            'date_of_resignation' => $request->date_of_resignation,
        ]);

// Mandatory Documents Details end
//fix to insert into system
        DB::table("apiemp_document_master")->insertGetId([
            'emp_id' => $apiemp_master,
            'document_name' => 'Passport',
            'fix_doc' => '1',
        ]);
        DB::table("apiemp_document_master")->insertGetId([
            'emp_id' => $apiemp_master,
            'document_name' => 'Visa',
            'fix_doc' => '1',
        ]);
        DB::table("apiemp_document_master")->insertGetId([
            'emp_id' => $apiemp_master,
            'document_name' => 'Emirates ID',
            'fix_doc' => '1',
        ]);
        DB::table("apiemp_document_master")->insertGetId([
            'emp_id' => $apiemp_master,
            'document_name' => 'Broker Card Number',
            'fix_doc' => '1',
        ]);
        DB::table("apiemp_document_master")->insertGetId([
            'emp_id' => $apiemp_master,
            'document_name' => 'Agreeement',
            'fix_doc' => '1',
        ]);

//fix to insert into system
        if ($request->document_passport) {
            $document_file = $request->file('document_passport_file');
            if ($document_file) {
                $FileExtension = $document_file->getClientOriginalExtension();
                $DestinationPath = 'public/uploads/hherp/apiemp/' . $apiemp_master . '/'; //upload path
                $Media_Storing_Name = $document_file->getClientOriginalName();
                $fileName = str_replace(' ', '_', rand(999, 111) . (trim($Media_Storing_Name)));
                $document_file->move($DestinationPath, $fileName);
                DB::table("apiemp_document_master")
                        ->where('document_name', '=', $request->document_passport)
                        ->where('emp_id', '=', $apiemp_master)
                        ->where('fix_doc', '=', 1)
                        ->update([
                            'document_expiry' => ($request->document_passport_exp) ? $request->document_passport_exp : "",
                            'document_file' => ($fileName) ? $fileName : '',
                            'document_not' => ($request->document_passport_not) ? $request->document_passport_not : "",
                            'file_extension' => ($FileExtension) ? $FileExtension : "-",
                            'is_upload' => '1',
                ]);
            } else {
                DB::table("apiemp_document_master")
                        ->where('document_name', '=', $request->document_passport)
                        ->where('emp_id', '=', $apiemp_master)
                        ->where('fix_doc', '=', 1)
                        ->update([
                            'document_expiry' => ($request->document_passport_exp) ? $request->document_passport_exp : "",
                            'document_not' => ($request->document_passport_not) ? $request->document_passport_not : "",
                ]);
            }
        }
        if ($request->document_visa) {
            $document_file = $request->file('document_visa_file');
            if ($document_file) {
                $FileExtension = $document_file->getClientOriginalExtension();
                $DestinationPath = 'public/uploads/hherp/apiemp/' . $apiemp_master . '/'; //upload path
                $Media_Storing_Name = $document_file->getClientOriginalName();
                $fileName = str_replace(' ', '_', rand(999, 111) . (trim($Media_Storing_Name)));
                $document_file->move($DestinationPath, $fileName);
                DB::table("apiemp_document_master")
                        ->where('document_name', '=', $request->document_visa)
                        ->where('emp_id', '=', $apiemp_master)
                        ->where('fix_doc', '=', 1)
                        ->update([
                            'document_expiry' => ($request->document_visa_exp) ? $request->document_visa_exp : "",
                            'document_file' => ($fileName) ? $fileName : '',
                            'document_not' => ($request->document_visa_not) ? $request->document_visa_not : "",
                            'file_extension' => ($FileExtension) ? $FileExtension : "-",
                            'is_upload' => '1',
                ]);
            } else {
                DB::table("apiemp_document_master")
                        ->where('document_name', '=', $request->document_visa)
                        ->where('emp_id', '=', $apiemp_master)
                        ->where('fix_doc', '=', 1)
                        ->update([
                            'document_expiry' => ($request->document_visa_exp) ? $request->document_visa_exp : "",
                            'document_not' => ($request->document_visa_not) ? $request->document_visa_not : "",
                ]);
            }
        }
        if ($request->document_emirates) {
            $document_file = $request->file('document_emirates_file');
            if ($document_file) {

                $FileExtension = $document_file->getClientOriginalExtension();
                $DestinationPath = 'public/uploads/hherp/apiemp/' . $apiemp_master . '/'; //upload path
                $Media_Storing_Name = $document_file->getClientOriginalName();
                $fileName = str_replace(' ', '_', rand(999, 111) . (trim($Media_Storing_Name)));
                $document_file->move($DestinationPath, $fileName);

                DB::table("apiemp_document_master")
                        ->where('document_name', '=', $request->document_emirates)
                        ->where('emp_id', '=', $apiemp_master)
                        ->where('fix_doc', '=', 1)
                        ->update([
                            'document_expiry' => ($request->document_emirates_exp) ? $request->document_emirates_exp : "",
                            'document_file' => ($fileName) ? $fileName : '',
                            'document_not' => ($request->document_emirates_not) ? $request->document_emirates_not : "",
                            'file_extension' => ($FileExtension) ? $FileExtension : "-",
                            'is_upload' => '1',
                ]);
            } else {
                DB::table("apiemp_document_master")
                        ->where('document_name', '=', $request->document_emirates)
                        ->where('emp_id', '=', $apiemp_master)
                        ->where('fix_doc', '=', 1)
                        ->update([
                            'document_expiry' => ($request->document_emirates_exp) ? $request->document_emirates_exp : "",
                            'document_not' => ($request->document_emirates_not) ? $request->document_emirates_not : "",
                ]);
            }
        }
        if ($request->document_broker) {
            $document_file = $request->file('document_broker_file');
            if ($document_file) {


                $FileExtension = $document_file->getClientOriginalExtension();
                $DestinationPath = 'public/uploads/hherp/apiemp/' . $apiemp_master . '/'; //upload path
                $Media_Storing_Name = $document_file->getClientOriginalName();
                $fileName = str_replace(' ', '_', rand(999, 111) . (trim($Media_Storing_Name)));
                $document_file->move($DestinationPath, $fileName);

                DB::table("apiemp_document_master")
                        ->where('document_name', '=', $request->document_broker)
                        ->where('emp_id', '=', $apiemp_master)
                        ->where('fix_doc', '=', 1)
                        ->update([
                            'document_expiry' => ($request->document_broker_exp) ? $request->document_broker_exp : "",
                            'document_file' => ($fileName) ? $fileName : '',
                            'document_not' => ($request->document_broker_not) ? $request->document_broker_not : "",
                            'file_extension' => ($FileExtension) ? $FileExtension : "-",
                            'is_upload' => '1',
                ]);
            } else {
                DB::table("apiemp_document_master")
                        ->where('document_name', '=', $request->document_broker)
                        ->where('emp_id', '=', $apiemp_master)
                        ->where('fix_doc', '=', 1)
                        ->update([
                            'document_expiry' => ($request->document_broker_exp) ? $request->document_broker_exp : "",
                            'document_not' => ($request->document_broker_not) ? $request->document_broker_not : "",
                ]);
            }
        }
        if ($request->document_agreement) {
            $document_file = $request->file('document_agreement_file');
            if ($document_file) {

                $FileExtension = $document_file->getClientOriginalExtension();
                $DestinationPath = 'public/uploads/hherp/apiemp/' . $apiemp_master . '/'; //upload path
                $Media_Storing_Name = $document_file->getClientOriginalName();
                $fileName = str_replace(' ', '_', rand(999, 111) . (trim($Media_Storing_Name)));
                $document_file->move($DestinationPath, $fileName);

                DB::table("apiemp_document_master")
                        ->where('document_name', '=', $request->document_agreement)
                        ->where('emp_id', '=', $apiemp_master)
                        ->where('fix_doc', '=', 1)
                        ->update([
                            'document_expiry' => ($request->document_agreement_exp) ? $request->document_agreement_exp : "",
                            'document_file' => ($fileName) ? $fileName : '',
                            'document_not' => ($request->document_agreement_not) ? $request->document_agreement_not : "",
                            'file_extension' => ($FileExtension) ? $FileExtension : "-",
                            'is_upload' => '1',
                ]);
            } else {
                DB::table("apiemp_document_master")
                        ->where('document_name', '=', $request->document_agreement)
                        ->where('emp_id', '=', $apiemp_master)
                        ->where('fix_doc', '=', 1)
                        ->update([
                            'document_expiry' => ($request->document_agreement_exp) ? $request->document_agreement_exp : "",
                            'document_not' => ($request->document_agreement_not) ? $request->document_agreement_not : "",
                ]);
            }
        }

// Mandatory Documents Details end


        if (isset($request->ddl_team_lead)) {
            $send_notification = (new Controller)->send_notification($request->ddl_team_lead, "Employee Create Successfully : " . $request->name . "");
        }
        if (isset($request->dd_department_lead)) {
            $send_notification = (new Controller)->send_notification($request->dd_department_lead, "Hello Department , Employee Create Successfully : " . $request->name . "");
        }
        if (isset($request->dd_hr)) {
            $send_notification = (new Controller)->send_notification($request->dd_hr, "Dear HR, Employee Create Successfully : " . $request->name . "");
        }


        $bank_name = $request->bank_name;
        if (isset($bank_name)) {
            foreach ($bank_name as $key => $value) {
                DB::table("apiemp_bank_master")->insertGetId([
                    'emp_id' => $apiemp_master,
                    'bank_name' => $request->bank_name[$key],
                    'bank_type' => $request->bank_type[$key],
                    'bank_account_number' => $request->bank_account_number[$key],
                    'bank_customer_name' => $request->bank_customer_name[$key],
                    'IBAN' => $request->IBAN[$key],
                    'bank_note' => $request->bank_note[$key],
                ]);
            }
        }
        $document_name = $request->document_name;
        if (isset($document_name)) {
            foreach ($document_name as $key => $value) {

                $document_file = $request->file('document_file')[$key];
                $FileExtension = $document_file->getClientOriginalExtension();
                $DestinationPath = 'public/uploads/hherp/apiemp/' . $apiemp_master . '/'; //upload path
                $Media_Storing_Name = $document_file->getClientOriginalName();
                $fileName = str_replace(' ', '_', rand(999, 111) . (trim($Media_Storing_Name)));
                $document_file->move($DestinationPath, $fileName);

                DB::table("apiemp_document_master")->insertGetId([
                    'emp_id' => $apiemp_master,
                    'document_name' => $request->document_name[$key],
                    'document_expiry' => $request->document_expiry[$key],
                    'document_file' => $fileName,
                    'document_not' => $request->pass_note[$key],
                    'file_extension' => $FileExtension,
                ]);
            }
        }
        $pass_pass_type = $request->pass_type;
        if (isset($pass_pass_type)) {
            foreach ($pass_pass_type as $key => $value) {
                DB::table("apiemp_password_master")->insertGetId([
                    'emp_id' => $apiemp_master,
                    'pass_type' => $request->pass_type[$key],
                    'password' => $request->pass_name[$key],
                    'pass_note' => $request->pass_note[$key],
                ]);
            }
        }
        $vehicle_name = $request->vehicle_name;
        if (isset($vehicle_name)) {
            foreach ($vehicle_name as $key => $value) {
                DB::table("apiemp_vehicle_master")->insertGetId([
                    'emp_id' => $apiemp_master,
                    'vehicle_name' => $request->vehicle_name[$key],
                    'vehicle_number' => $request->vehicle_number[$key],
                    'vehicle_mileage' => $request->vehicle_mileage[$key],
                    'vehicle_run_start' => $request->vehicle_run_start[$key],
                    'vehicle_run_end' => $request->vehicle_run_end[$key],
                    'vehicle_note' => $request->vehicle_note[$key],
                ]);
            }
        }

        if (isset($request->ddl_equipment)) {
            foreach ($request->ddl_equipment as $e) {
                DB::table('apiemp_quipment_acess')->insert(
                        ['emp_id' => $apiemp_master, 'equipment_id' => $e]
                );
            }
        }
        $send_notification = (new Controller)->send_notification('1', "Employee Create Successfully : " . $request->name . "");

        //dd($request->all());
        return redirect(route('emp'))->with('success', 'Employee has been Create Successfully!');

//        dd($request->all());
//
//        $Batchs = Batch::create($request->all());
//        $last_id = DB::getPDO()->lastInsertId(); //get last id of the batch
//        $Batchs->save();
//        redirect()->back()->with('success', 'Batch Create Successfully !');
//        return redirect('hrms/batch/');
    }

    /* 07082023 */

    public function sendOfferLatter(Request $request, $id) {
        $employee = DB::table('employees')
                ->where('employees.user_id', $id)
                ->leftjoin('designations', 'designations.id', 'employees.designation')
                ->select(['employees.*', 'designations.name as designations'])
                ->first();

        if (!$employee) {
            return response()->json(['message' => 'Employee not found.'], 400);
        }
        $attech_pdf_replace_content = [
            'CURRENT_DATE' => date('Y-m-d'),
            'EMPLOYEE_NAME' => $employee->name,
            'EMPLOYEE_DESIGNATION' => $employee->designations,
            'EMPLOYEE_JOING_DATE' => $employee->date_of_appointment
        ];
        $attech_mail_body_replace_content = [
            'EMPLOYEE_NAME' => $employee->name,
        ];

        $attech_pdf_content_html = $this->setTemplateString('offer-letter-mail-attachment-pdf', $attech_pdf_replace_content);
        $mail_body_content_html = $this->setTemplateString('offer-letter-mail-body', $attech_mail_body_replace_content);

        if (!$attech_pdf_content_html) {
            return redirect(route('emp/', 'employees'))->with('error', '"offer-letter-mail-attachment-pdf" Not Found Slug !');
        }
        if (!$mail_body_content_html) {
            return redirect(route('emp/', 'employees'))->with('error', '"offer-letter-mail-body" Not Found Slug !');
        }
        $offer_mail_param = [
            'subject' => 'Employee Mail',
            'attech_pdf_content_html' => $attech_pdf_content_html,
            'mail_body_content_html' => $mail_body_content_html,
            'employee_name' => $employee->name
        ];

        Mail::to($employee->email)->send(new SendEmployeeOfferMail($offer_mail_param));
        return redirect(route('emp', 'employees'))->with('success', "Offer Letter has been successfully sent to " . $employee->name);
    }

    public function printPDFOfferLatter(Request $request, $id) {
        $employee = DB::table('employees')->where('employees.user_id', $id)
                ->leftjoin('designations', 'designations.id', 'employees.designation')
                ->select(['employees.*', 'designations.name as designations'])
                ->first();
        if (!$employee) {
            return redirect(route('emp/', 'employees'))->with('error', 'Employee Not Found !');
        }

        $replace_content = [
            'CURRENT_DATE' => date('Y-m-d'),
            'EMPLOYEE_NAME' => $employee->name,
            'EMPLOYEE_DESIGNATION' => $employee->designations,
            'EMPLOYEE_JOING_DATE' => $employee->date_of_appointment
        ];
        $attech_pdf_content_html = $this->setTemplateString('offer-letter-mail-attachment-pdf', $replace_content);
        if (!$attech_pdf_content_html) {
            return redirect(route('emp', 'employees'))->with('error', '"offer-letter-mail-attachment-pdf" Not Found Slug !');
        }
        date_default_timezone_set("Asia/Kolkata");
        $pdf = PDF::loadView('emailtemplate.template_view', ['template_content_html' => $attech_pdf_content_html]);
        return $pdf->download($employee->name . ' - Offer Letter.pdf');
    }

    public function setTemplateString($template_code, $replace_array = []) {
        $email_template = EmailTemplate::where('slug', $template_code)->first();
        if (!$email_template) {
            return false;
        }
        $content_html = $email_template->content_html;
        foreach ($replace_array as $key => $replace_str) {
            $content_html = str_replace("#" . $key . '#', $replace_str, $content_html);
        }
        return $content_html;
    }

    /* 07082023 */
}

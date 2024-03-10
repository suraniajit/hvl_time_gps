<?php

namespace App\Http\Controllers;

use App\Role;
use App\User;
use Auth;
use App\Employee;
use App\Module;
use Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\hrms\LeaveRequest;
use Carbon\Carbon;
use Validator;
use App\Models\Penalty;
use App\Models\Attendance\Attendance;
use App\Models\training\SimulationUserResult;

class UserProfileController extends Controller {

    public function show_employee(Request $request) {


        $table_name = 'employees';

        $table_data = DB::table($table_name)->where('user_id', $request->id)->first();

        $table_name = str_replace('_', ' ', $table_name);
        $module_name = str_replace('_', ' ', $table_name);


        $fields = Module::where('name', $table_name)->select('form')->get();

        $breadcrumbs = [
            ['link' => "/", 'name' => "Home"],
            ['name' => "View"],
        ];
        //Pageheader set true for breadcrumbs
        $pageConfigs = ['pageHeader' => true, 'isFabButton' => true, 'isCustomizer' => true];


        return view('user-profile.employee_details', [
            'pageConfigs' => $pageConfigs,
            'breadcrumbs' => $breadcrumbs,
            'table_data' => $table_data,
            'fields' => $fields,
            'table_name' => $table_name
        ]);
    }

    public static function getEmployeeLeaveDetailsId($user_id) {
        return DB::table('leave_request')
                        ->select('*', 'leave_type.Name as leave_type_Name')
//                        ->join('leave_request', 'employees.user_id', '=', 'leave_request.employee_id')
                        ->join('leave_type', 'leave_type.id', '=', 'leave_request.leave_type')
                        ->where('leave_request.employee_id', '=', $user_id)
                        ->get();
    }

    static function user_employees($user_id) {
        return DB::table('users')
                        ->select('users.*', 'employees.*')
                        ->join('employees', 'users.id', '=', 'employees.user_id')
                        ->where('employees.user_id', '=', $user_id)
                        ->get();
    }

    static function getAllRolesBYRoles($role_id) {
        return DB::table('model_has_roles')
                        ->select(
                                'users.id as users.id',
                                'users.name as usersname',
                                'users.email as user_email_id',
                                'roles.id as roles_id',
                                'roles.name as user_role', 'employees.*'
                        )
                        ->where('roles.id', '=', $role_id)
                        ->join('users', 'users.id', '=', 'model_has_roles.model_id')
                        ->join('employees', 'users.id', '=', 'employees.user_id')
                        ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
                        ->get();
    }

    public static function getEmpDetailsbyUser_id($user_id) {
        return DB::table('employees')
                        ->select('employees.Name as Name',
                                'teams.Name as Team_name',
                                'departments.Name as departments_name',
                                'designations.Name as designations_name')
                        ->where('employees.user_id', '=', $user_id)
                        ->join('teams', 'teams.id', '=', 'employees.Select_Team')
                        ->join('departments', 'departments.id', '=', 'employees.Select_Department')
                        ->join('designations', 'designations.id', '=', 'employees.select_designation')
                        ->get();
    }

    static function getCount_dashboard_details_role_id($role_id) {
        $List = implode(',', $role_id);
        $t = DB::table('role_has_permissions')
                ->select('role_has_permissions.permission_id', 'permissions.name', 'permissions.path')
                ->whereIn('role_has_permissions.role_id', [$List])
                //                ->whereIn('permissions.id', ['permissions.id'])
                ->where('permissions.dashboard', '=', 1)
                ->join('permissions', 'permissions.id', '=', 'role_has_permissions.permission_id')
                ->get();
        return $t;
    }

    static function getCountDetailsRoleID($role_id, $path) {
        DB::enableQueryLog();
//        echo 'getCountDetailsRoleID';
        $List = implode(',', $role_id);
        $t = DB::table('role_has_permissions')
                ->select('role_has_permissions.*')
//                ->select('role_has_permissions.permission_id', 'permissions.name', 'permissions.path')
                ->whereIn('role_has_permissions.role_id', [$List])
                ->where('permissions.path', '=', $path)
//                ->whereIn('permissions.id', ['permissions.id'])
                ->where('permissions.name', 'like', '%Access %')
//                ->where('permissions.dashboard', '=', 1)
                ->join('permissions', 'permissions.id', '=', 'role_has_permissions.permission_id')
                ->get();
//        dd(DB::getQueryLog()); // Show results of log
        return $t;
    }

    static function find_user_role($user_id) {

        //DB::enableQueryLog();
        //dd(DB::getQueryLog()); // Show results of log
        return $quwye = DB::table('model_has_roles')
                ->select(
                        'users.id as users.id',
                        'users.name as usersname',
                        'roles.id as roles_id',
                        'roles.name as user_role'
                )
                ->where('model_has_roles.model_id', '=', $user_id)
                ->join('users', 'users.id', '=', 'model_has_roles.model_id')
//                ->join('employees', 'users.id', '=', 'employees.user_id')
                ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
                ->get();

//        dd(DB::getQueryLog()); // Show results of log
    }

    public function index() {

    }

    public static function getHRNameByid_table_name($emp_Id) {
        $tableName = 'employees';
        return DB::table($tableName)
                        ->where($tableName . '.id', '=', $emp_Id)
                        ->value('Name');
    }

    public static function getdepartmentNameByid($emp_Id) {
        return DB::table('departments')
                        ->where('departments.id', '=', $emp_Id)
                        ->value('Name');
    }

    public static function getteamNameByid($emp_Id) {
        return DB::table('teams')
                        ->where('teams.id', '=', $emp_Id)
                        ->value('Name');
    }

    public static function getdesignationNameByid($emp_Id) {
        return DB::table('designations')
                        ->where('designations.id', '=', $emp_Id)
                        ->value('Name');
    }

    function getMyTeam($team_lead_name) {
        return Employee::where('team_lead', $team_lead_name)->get();
    }

    public function get_Course_status($user_id) {
        return DB::table('employee_course_statuses')
                        ->select('employee_course_statuses.*')
                        ->where('employee_course_statuses.employee_id', '=', $user_id)
                        ->get();
    }

    public function get_Course_result($user_id) {
        return DB::table('user_results')
                        ->where('user_id', '=', $user_id)
                        ->select('user_results.*')
                        ->get();
    }

    public function getMyTeamSimulatedCourse($user_id) {
        return DB::table('simulation_courses')
                        ->select(
                                'simulation_courses.*',
                                'simulation_course_employees.*'
                        )
                        ->join('simulation_course_employees', 'simulation_course_employees.course_id', '=', 'simulation_courses.id')
                        ->where('simulation_courses.is_active', '=', '0')
                        ->where('simulation_course_employees.employee_id', '=', $user_id)
                        ->get();
    }

    function getresultby_SimulationId_emp_id($user_id, $course_id) {
        return DB::table('simulation_user_results')
                        ->select('*')
                        ->where('is_active', '=', '0')
                        ->where('user_id', '=', $user_id)
                        ->where('course_id', '=', $course_id)
                        ->get();
    }

    function getresultby_CourseId_emp_id($user_id, $course_id) {
        return DB::table('user_results')
                        ->select('*')
                        ->where('is_active', '=', '0')
                        ->where('user_id', '=', $user_id)
                        ->where('course_id', '=', $course_id)
                        ->get();
    }

    function getResumeEmployeeSimulatedCourse_pop($user_id) {
        /* $EmployeeSimulatedCourses_popup */
//           DB::enableQueryLog();
        return $getResumeEmployeeSimulatedCourse_pop = DB::table('simulation_course_employees')
                ->join('simulation_courses', 'simulation_courses.id', '=', 'simulation_course_employees.course_id')
                ->join('employee_simulation_course_statuses', 'employee_simulation_course_statuses.course_id', '=', 'simulation_courses.id')
                ->where('simulation_course_employees.employee_id', '=', $user_id)
                ->where('employee_simulation_course_statuses.employee_id', '=', $user_id)
                ->where('employee_simulation_course_statuses.is_start', '=', 1)
                ->select('simulation_courses.*', 'simulation_courses.id as course_id', 'simulation_course_employees.*', 'employee_simulation_course_statuses.is_start')
                ->get();
//        dd(DB::getQueryLog());
        /* $EmployeeSimulatedCourses_popup */
    }

    function getAudioDetailsByTranierId_UserId($user_id) {
        return DB::table('user_audio_answers')
                        ->join('train_courses', 'train_courses.id', '=', 'user_audio_answers.course_id')
                        ->join('employees', 'employees.user_id', '=', 'user_audio_answers.user_id')
                        ->where('user_audio_answers.trainer_id', '=', $user_id)
                        ->whereNull('user_audio_answers.result')
                        ->select('*', 'train_courses.id as course_id', 'user_audio_answers.user_id as uid')
                        ->get()
                        ->groupBy('course_id');
    }

    function getMyTeamCourse($user_id) {

// dd($user_id);
        // return DB::table('train_course_employees')
        //                 ->join('train_courses', 'train_courses.id', '=', 'train_course_employees.course_id')
        //                 ->join('train_category_courses', 'train_category_courses.course_id', '=', 'train_courses.id')
        //                 ->join('train_categories', 'train_categories.id', '=', 'train_category_courses.category_id')
        //                 // ->join('employee_course_statuses', 'employee_course_statuses.course_id', '=', 'train_courses.id')
        //                 // ->where('train_course_employees.employee_id', '=', $user_id)
        //                 // ->select('train_courses.*', 'train_courses.id as course_id', 'train_course_employees.*', 'train_categories.*', 'employee_course_statuses.is_start')
        //                 ->select('train_courses.*', 'train_courses.id as course_id', 'train_course_employees.*', 'train_categories.*')
        //                 ->get();
        DB::enableQueryLog();

//        $t = DB::table('train_course_employees')
//                ->where('train_course_employees.employee_id', '=', $user_id)
//                ->join('train_courses', 'train_courses.id', '=', 'train_course_employees.course_id')
////                ->join('train_category_courses', 'train_category_courses.course_id', '=', 'train_courses.id')
////                ->join('train_categories', 'train_categories.id', '=', 'train_category_courses.category_id')
//                ->get();

        $t = DB::table('train_course_employees')
                ->select('train_courses.*',
                        'train_courses.id as course_id',
                        'train_course_employees.*',
                        'train_categories.*',
                        'employees.*'
                )
                ->where('train_course_employees.employee_id', '=', $user_id)
                ->join('train_courses', 'train_courses.id', '=', 'train_course_employees.course_id')
                ->join('train_category_courses', 'train_category_courses.course_id', '=', 'train_courses.id')
                ->join('train_categories', 'train_categories.id', '=', 'train_category_courses.category_id')
                ->join('employees', 'train_course_employees.employee_id', '=', 'employees.user_id')
                ->get();

//        $t = DB::table('train_course_employees')
//                ->select('train_courses.*',
//                        'train_courses.id as course_id',
//                        'train_course_employees.*',
//                        'train_categories.*',
//                        'employees.*'
//                )
//                ->where('train_course_employees.employee_id', '=', $user_id)
//                ->join('train_courses', 'train_courses.id', '=', 'train_course_employees.course_id')
//        ->join('train_category_courses', 'train_category_courses.course_id', '=', 'train_courses.id')
//        ->join('train_categories', 'train_categories.id', '=', 'train_category_courses.category_id')
//                ->join('employees', 'train_course_employees.employee_id', '=', 'employees.user_id')
//                ->get();
//        dd(DB::getQueryLog());
//        dd($t);
        return $t;
    }

    public function getAllLeads($team_lead_name) {
//        Employee::where('team_lead', $team_lead_name)->get();
        return DB::table('lead_opration')
                        ->select('leads.*', 'employees.Name as assign_employee_empName', 'lead_opration.*')
                        ->join('leads', 'leads.id', '=', 'lead_opration.lead_id')
                        ->join('employees', 'employees.id', '=', 'leads.assign_employee')
//                ->where('lead_opration.assign_employee', '=', $user_id)
//                ->where('lead_create_date', '=', $today)
                        ->where('employees.team_lead', '=', $team_lead_name)
                        ->get();

//        DB::table('leads')
//
//                ->get();
    }

    public function userProfile() {


        $breadcrumbs = [
            ['link' => "modern", 'name' => "Home"],
            ['link' => "javascript:void(0)", 'name' => "Pages"],
            ['name' => "User Profile Page"],
        ];
//Pageheader set true for breadcrumbs
        $pageConfigs = ['pageHeader' => true, 'isFabButton' => true];







        $user = auth()->user();
        $roles = Role::all();
        $user_id = $user['id'];
        $user_name = $user['name'];
        $user_email = $user['email'];


        $users_roles_name = $this->find_user_role($user_id);
        $UserEmployeesDetails = $this->user_employees($user_id);

        $table_name = 'employees';
        $table_data = DB::table('employees')->where('user_id', $user_id)->first();
        $module_name = str_replace('_', ' ', $table_name);
        $module_form = Module::where('name', $module_name)->get();

        /* raj's leave summary start */
        $id = Auth::id();
        $used_leaves = array();

        $hvi_customer_details = DB::table('hvl_customer_master')
                ->select('common_cities.Name as city_name', 'hvl_customer_master.*')
                ->join('common_cities', 'common_cities.id', '=', 'hvl_customer_master.shipping_city')
//                ->where('Customers.select_employee', '=', $id)
                ->where('hvl_customer_master.employee_id', '=', $table_data->id)
//                ->where('Customers.Select_City', '=', $table_data->select_city)
                ->get();



//        if (isset($used_leaves)) {
////            $arr = array();
////            $sum = array();
//            $arr = array();
//            $sum = array();
//
//            foreach ($used_leaves as $u) {
//                if (!isset($arr[$u->leave_type])) {
//                    $arr[$u->leave_type] = array();
//                }
//                array_push($arr[$u->leave_type], $u->total_days);
//            }
//
//
//            for ($i = 1; $i <= count($arr); $i++) {
//                if (!isset($arr[$i])) {
//                    $arr[$i] = [0];
//                }
//                $sum[$i] = array_sum($arr[$i]);
//            }



//            return view('user-profile.index', [
//                'team_lead_details' => $team_lead_details,
//                'id' => $id,
//                'pageConfigs' => $pageConfigs,
//                'leaverequest' => $leaverequest,
//                'sum' => $sum,
//                'leaves_master' => $leaves_master,
//                /* employee data */
//                'user' => $user,
//                'UserEmployeesDetails' => $UserEmployeesDetails,
//                'SimulatedCourseDetails' => $SimulatedCourseDetails,
//                'CourseDetails' => $CourseDetails,
//                'CourseStatuses' => $getCoursestatus,
//                'CourseResults' => $getCourseResult,
//                'users_roles_name' => $users_roles_name,
//                'table_data' => $table_data,
//                'table_name' => $table_name,
//                'module_form' => $module_form,
// 'checkout' => $checkout,
//                'amount' => $amount,
//                'holidays' => $holidays,
//                'holiday_approved' => $holiday_approved,
//                'attendance_table_data' => $attendance_table_data,
//                'hvi_customer_details' => $hvi_customer_details,
//                'total_penalty_checkin' => $total_penalty_checkin,
//                'total_penalty_checkout' => $total_penalty_checkout,
//                'leaverequest_hr' => $leaverequest_hr,
//                'leaverequest_lead' => $leaverequest_lead,
//                'getAllLeads' => $getAllLeads,
//                'SimulationCourseStatus' => $SimulationCourseStatus,
//                'EmployeeSimulatedCourses' => $getResumeEmployeeSimulatedCourse,
//                'AudioDetails' => $this->getAudioDetailsByTranierId_UserId($id)
//            ]);
//        } else {
            return view('user-profile.index', [
//                'team_lead_details' => $team_lead_details,
                'id' => $id,
                'pageConfigs' => $pageConfigs,
//                'leaverequest' => $leaverequest,
//                'leaves_master' => $leaves_master,
                /* employee data */
                'user' => $user,
                'UserEmployeesDetails' => $UserEmployeesDetails,
//                'SimulatedCourseDetails' => $SimulatedCourseDetails,
//                'CourseDetails' => $CourseDetails,
//                'CourseStatuses' => $getCoursestatus,
//                'CourseResults' => $getCourseResult,
                'users_roles_name' => $users_roles_name,
                'table_data' => $table_data,
                'table_name' => $table_name,
                'module_form' => $module_form,
//                'checkout' => $checkout,
//                'amount' => $amount,
//                'holidays' => $holidays,
//                'holiday_approved' => $holiday_approved,
//                'attendance_table_data' => $attendance_table_data,
                'hvi_customer_details' => $hvi_customer_details,
//                'total_penalty_checkin' => $total_penalty_checkin,
//                'total_penalty_checkout' => $total_penalty_checkout,
//                'leaverequest_hr' => $leaverequest_hr,
//                'leaverequest_lead' => $leaverequest_lead,
//                'getAllLeads' => $getAllLeads,
//                'SimulationCourseStatus' => $SimulationCourseStatus,
//                'EmployeeSimulatedCourses' => $getResumeEmployeeSimulatedCourse,
//                'AudioDetails' => $this->getAudioDetailsByTranierId_UserId($id)
            ]);
//        }
    }

    function action(Request $request) {
        $id = $request->user_id;
        $validation = Validator::make($request->all(), [
                    'select_file' => 'required|image|mimes:jpeg,png,jpg|max:1048'
        ]);
        if ($validation->passes()) {
            $image = $request->file('select_file');
            $new_name = rand() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('profile/'), $new_name);

            $user = User::find($id);
            $user->update([
                'path' => $new_name,
                'profile_image' => $new_name,
            ]);
            Session::forget('profile_image');

            $user = User::find($id);
            $profile_image = $user['profile_image'];
            Session::put('profile_image', $profile_image);

            return response()->json([
                        'message' => 'Image Upload Successfully',
                        'uploaded_image' => '<img src="/profile/' . $new_name . '" class="border-radius-4" alt="profile image" height="64" width="64" />',
                        'class_name' => 'alert-success'
            ]);
        } else {
            return response()->json([
                        'message' => $validation->errors()->all(),
                        'uploaded_image' => '',
                        'class_name' => 'alert-danger'
            ]);
        }
    }

}

<?php

namespace App\Http\Controllers;

use App\Module;
use App\Permission;
use App\Role;
use Hash;
use App\Models\training\CourseMedia;
use App\Models\training\UserQuestionnaireAnswer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmployeeDashboard extends Controller {

    function __construct() {
        $this->middleware('auth');
//        $this->middleware('permission:batch-list|batch-create|batch-edit|batch-delete', ['only' => ['index', 'getdata']]);
//        $this->middleware('permission:batch-create', ['only' => ['create', 'store']]);
//        $this->middleware('permission:batch-edit', ['only' => ['edit', 'update']]);
//        $this->middleware('permission:batch-delete', ['only' => ['delete']]);
//        $this->middleware('permission:batch-multidelete', ['only' => ['multidelete']]);
    }

    static public function employee_course_statuses($course_id, $user_id) {
       return $data = DB::table('employee_course_statuses')
                ->select('*')
                ->where([
                    ['employee_id', '=', $user_id],
                    ['course_id', '=', $course_id],
                ])
                ->first();
//        print_r($data);
        
        //return $data;
    }

    public function index() {
        $user = auth()->user();

//        $Users_roles_name = DB::table('model_has_roles')
//                ->select('users.name as usersName',
//                        'users.name as name',
//                        'users.email as email',
//                        'roles.name as rolesName',
//                        'employees.id as employee_id'
//                )
//                ->where('model_has_roles.model_id', '=', $user->id)
//                ->join('users', 'users.id', '=', 'model_has_roles.model_id')
//                ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
//                ->join('employees', 'users.id', '=', 'employees.user_id')
//                ->first();
//
//        if ($Users_roles_name != '') {
//            $EmployeeId = $Users_roles_name->employee_id;
//            $getEmployeeCourse = DB::table('train_course_employees')
//                    ->join('train_courses', 'train_courses.id', '=', 'train_course_employees.course_id')
//                    ->where('employee_id', '=', $EmployeeId)
//                    ->select('train_courses.*', 'train_courses.id as course_id', 'train_course_employees.*')
//                    ->get();
//        } else {
//            return 'You Dont Have Permission To view This Page';
//        }
       $EmployeeId = $user->id;
        $CourseEmployeeDetails = DB::table('train_course_employees')
                ->select('train_courses.*',
                        'train_courses.id as course_id',
                        'train_course_employees.*', 'employees.Name as TrainerName')
                ->where('employee_id', '=', $EmployeeId)
                ->join('train_courses', 'train_courses.id', '=', 'train_course_employees.course_id')
                ->join('employees', 'train_courses.trainer', '=', 'employees.user_id')
//                ->join('employee_team', 'train_courses.id', '=', 'employee_team.team_id')
                ->get();


        $user_results = DB::table('user_results')
                ->select('*')
                ->where('user_id', '=', $EmployeeId)
                ->get();


//        $id = $CourseEmployeeDetails[0]->id;
//
//        /* getting the total number of questionnaire and fetchng user completed questionnaire */
//        /* fetching course Media of particuler course  */
//        $CourseMediaDetails = CourseMedia::where('course_id', '=', $id)
//                ->whereNull('deleted_at')
//                ->where('is_active', '=', '0')
//                ->get()
//                ->groupBy('set_name');
//        $IsStart = 0;
//        $Total_questionaire = '';
//        foreach ($CourseMediaDetails as $Coursemedia => $Medias) {
//            $totalquestionnaire[] = count(json_decode($Medias[0]->questionnaire_ids));
//        }
//        if (!empty($totalquestionnaire)) {
//            $Total_questionaire = array_sum($totalquestionnaire);
//        }
//        $GetUserQuestionnaire = count(UserQuestionnaireAnswer::where('course_id', '=', $id)
//                        ->where('user_id', '=', $EmployeeId)
//                        ->get());

        return view('training.emp_dashboard.employee_dashboard', [
            'user' => $user,
            'EmployeeCourses' => $CourseEmployeeDetails,
            'user_results' => $user_results,
//            'IsStart' => $IsStart,
//            'Total_Questionnaires' => $Total_questionaire,
//            'UserQuestionnaires' => $GetUserQuestionnaire,
        ]);
    }

}

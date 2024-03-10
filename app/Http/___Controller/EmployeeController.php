<?php

namespace App\Http\Controllers;

use Auth;
use App\Employee;
use App\Module;
use App\User;
use App\Role;
use Carbon\Carbon;
use App\Models\UserColors;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmployeeController extends Controller {

    public function employeeStore(Request $request) {
        $validatedData = $request->validate([
            'email' => 'unique:users,email,' . $request->id
        ]);

        $user = User::insertGetId([
                    'name' => $request->Name,
                    'email' => $request->email,
//                    'password' => bcrypt($request->email),
                    'password' => bcrypt('Password@1234'),
                    'reset_password' => 0
        ]);
        $table_id = Employee::insertGetId([]);
        Employee::where('id', $table_id)->update([
            'Name' => $request->Name,
            'user_id' => $user,
            'email' => $request->email,
            'Date_of_Brith' => $request->Date_of_Brith,
            'Select_Department' => $request->Select_Department,
            'Select_Designation' => $request->Select_Designation,
            'Select_Team' => $request->Select_Team,
            'select_city' => $request->select_city,
            'Address' => $request->Address,
            'Date_of_Appointment' => $request->Date_of_Appointment,
        ]);


        /* color entry */
        $colorUsers = UserColors::firstOrNew([
                    'user_id' => $table_id,
                    'menu_color' => 'gradient-45deg-purple-deep-purple',
                    'navbar_color' => 'gradient-45deg-purple-deep-purple',
                    'title_color' => 'black-text',
                    'breadcrumb_color' => 'white-text',
                    'button_color' => '#ff4081',
                    'dark_menu' => '0',
                    'menu_selection' => 'sidenav-active-square',
                    'font_family' => 'Muli',
                    'menu_size' => '14px',
                    'breadcrumb_size' => '14px',
                    'title_size' => '22px',
                    'table_size' => '15px',
                    'label_size' => '8px',
        ]);
        $colorUsers->save();
        /* color entry end */


        /* assgin default roles of 'employee' start */
//        DB::table('model_has_roles')->insert(
//                array(
//                    'role_id' => '2',
//                    'model_type' => 'App\User',
//                    'model_id' => $user
//                )
//        );
        /* assgin default roles of 'employee' end */

        $fields = Module::where('name', 'employees')->select('form')->get();


//        /* two way communcation by hitesh */
//        echo $emp_id = $request->id;
//        $Select_Department = $request->Select_Department;
//        $select_designation = $request->select_designation;
//        $team_id = $request->Select_Team;
//
//
////        $select_shift = $request->select_shift;
////        DB::table('shift_employee')->insert(['employee_id' => $table_id, 'shift_id' => $select_shift]);
//
//
//        DB::table('department_employee')->insert(['department_id' => $Select_Department, 'employee_id' => $table_id]);
//        DB::table('designation_employee')->insert(['designation_id' => $Select_Department, 'employee_id' => $table_id]);
//        DB::table('employee_team')->insert(['team_id' => $team_id, 'employee_id' => $table_id]);
//
//        foreach ($fields as $field) {
//            foreach (json_decode($field->form) as $item) {
//                if ($item->type !== 'section') {
//                    $f = str_replace(' ', '_', $item->label);
//
//                    if (is_array($request->$f) === true) {
//
//                        $array_value = implode(',', $request->$f);
//                        Employee::where('id', $table_id)->update([
//                            $f => $array_value
//                        ]);
//                    } else {
//
//                        if ($item->type === 'file') {
//                            if ($request->hasFile($f)) {
//                                $file_path = $this->uploadFile($request->$f);
//                            } else {
//                                $file_path = '';
//                            }
//
//                            Employee::where('id', $table_id)->update([
//                                $f => $file_path
//                            ]);
//                        } else {
//
//                            Employee::where('id', $table_id)->update([
//                                $f => $request->$f
//                            ]);
//                        }
//                    }
//                }
//            }
//        }



        /* salary counting payroll start */

//        DB::table('payroll_salary_master')->insert([
//            'user_id' => $table_id, //employee id
//            'join_date' => Carbon::today()->format('Y-m-d'),
//        ]);
        /* salary counting payroll end */

        return redirect(route('modules.module', 'employees'))->with('message', 'Record Inserted!');
    }

    public function employeeSalaryCalulation(Request $request) {
        dd($request->all());
    }

    public function employeeUpdate(Request $request) {

        Employee::where('id', $request->id)->update([
            'Name' => $request->Name,
            'email' => $request->email,
            'Date_of_Brith' => $request->Date_of_Brith,
            'Select_Department' => $request->Select_Department,
            'Select_Designation' => $request->Select_Designation,
            'Select_Team' => $request->Select_Team,
            'select_city' => $request->select_city,
            'Address' => $request->Address,
            'Date_of_Appointment' => $request->Date_of_Appointment
        ]);

        $fields = Module::where('name', 'employees')->select('form')->get();


        /* update department using two way commnucation */
        $emp_id = $request->id;
        $Select_Department = $request->Select_Department;
        $select_designation = $request->select_designation;
        $team_id = $request->Select_Team;
////        $select_shift = $request->select_shift;
//
//        $GetShiftData = DB::table('shift_employee')->where('employee_id', $emp_id)->get();
//        if (count($GetShiftData) > 0) {
//            echo 'data Allready in database';
//
//            $del = DB::table('shift_employee')->where('employee_id', $emp_id)->delete();
//
//            if ($del) {
//                echo '<br>' . 'data is delete';
//                DB::table('shift_employee')->insert(['employee_id' => $emp_id, 'shift_id' => $select_shift]);
//            } else {
//                echo '<br>' . 'data is update';
//                DB::table('shift_employee')->where('employee_id', $emp_id)->update(['shift_id' => $select_shift]);
////            DB::table('shift_employee')->insert(['employee_id' => $emp_id, 'shift_id' => $select_shift]);
//            }
//        } else {
//            echo 'data not in database';
//            DB::table('shift_employee')->insert(['employee_id' => $emp_id, 'shift_id' => $select_shift]);
//        }




        /*         * ****************************** */

//        $GetDepartmentData = DB::table('department_employee')->where('employee_id', $emp_id)->get();
//        if (count($GetDepartmentData) > 0) {
//            echo 'data Allready in database';
//
//            $del = DB::table('department_employee')->where('employee_id', $emp_id)->delete();
//
//            if ($del) {
//                echo '<br>' . 'data is delete';
//                DB::table('department_employee')->insert(['employee_id' => $emp_id, 'department_id' => $Select_Department]);
//            } else {
//                echo '<br>' . 'data is update';
//                DB::table('department_employee')->where('employee_id', $emp_id)->update(['department_id' => $Select_Department]);
//            }
//        } else {
//            echo 'data not in database';
//            DB::table('department_employee')->insert(['employee_id' => $emp_id, 'department_id' => $Select_Department]);
//        }
//
////        DB::table('department_employee')->where('employee_id', $emp_id)->delete();
////        DB::table('department_employee')->where('employee_id', $emp_id)->update(['department_id' => $Select_Department]);
//        /*         * ****************************** */
//
//
//        /*         * ***********designation_employee******************* */
//
//
//        $GetDesignationData = DB::table('designation_employee')->where('employee_id', $emp_id)->get();
//        if (count($GetDesignationData) > 0) {
//            $del = DB::table('designation_employee')->where('employee_id', $emp_id)->delete(); // 'data Allready in database';
//            if ($del) {
//                DB::table('designation_employee')->insert(['employee_id' => $emp_id, 'designation_id' => $select_designation]); //'data is delete'
//            } else {
//                DB::table('designation_employee')->where('employee_id', $emp_id)->update(['designation_id' => $select_designation]); //  'data is update';
//            }
//        } else {
//            DB::table('designation_employee')->insert(['employee_id' => $emp_id, 'designation_id' => $select_designation]); //'data not in database';
//        }
////        DB::table('designation_employee')->where('employee_id', $emp_id)->update(['designation_id' => $select_designation]);
//
//        /*         * ***********designation_employee******************* */
//
//
//
//
//        /*         * ***********employee_team******************* */
//
//
//        $GetTeamData = DB::table('employee_team')->where('employee_id', $emp_id)->get();
//        if (count($GetTeamData) > 0) {
//            $del = DB::table('employee_team')->where('employee_id', $emp_id)->delete(); // 'data Allready in database';
//            if ($del) {
//                DB::table('employee_team')->insert(['employee_id' => $emp_id, 'team_id' => $team_id]); //'data is delete'
//            } else {
//                DB::table('employee_team')->where('employee_id', $emp_id)->update(['team_id' => $team_id]); //  'data is update';
//            }
//        } else {
//            DB::table('employee_team')->insert(['employee_id' => $emp_id, 'team_id' => $team_id]); //'data not in database';
//        }
//
////        DB::table('employee_team')->where('employee_id', $emp_id)->delete();
////        DB::table('employee_team')->insert(['team_id' => $team_id, 'employee_id' => $emp_id]);
//
//
//        /*         * ***********employee_team******************* */
//
//
//
////        DB::table('department_employee')->insert(['department_id' => $Select_Department, 'employee_id' => $emp_id]);
////        DB::table('designation_employee')->insert(['designation_id' => $Select_Department, 'employee_id' => $emp_id]);
//
//
//
//        foreach ($fields as $field) {
//            foreach (json_decode($field->form) as $item) {
//                if ($item->type !== 'section') {
//                    $f = str_replace(' ', '_', $item->label);
//
//                    if (is_array($request->$f) === true) {
//
//                        $array_value = implode(',', $request->$f);
//                        Employee::where('id', $request->id)->update([
//                            $f => $array_value
//                        ]);
//                    } else {
//
//                        if ($item->type === 'file') {
//                            if ($request->hasFile($f)) {
//                                $file_path = $this->uploadFile($request->$f);
//                            } else {
//                                $file_path = '';
//                            }
//
//                            Employee::where('id', $request->id)->update([
//                                $f => $file_path
//                            ]);
//                        } else {
//
//                            Employee::where('id', $request->id)->update([
//                                $f => $request->$f
//                            ]);
//                        }
//                    }
//                }
//            }
//        }
//        dd($request->all());
        return redirect(route('modules.module', 'employees'))->with('message', 'Record Updated!');
    }

    public function uploadFile($file) {
        $fileName = time() . '_' . $file->getClientOriginalName();

        $file->move(public_path('uploads'), $fileName);
        $file_path = url('uploads', $fileName);
        return $file_path;
    }

}

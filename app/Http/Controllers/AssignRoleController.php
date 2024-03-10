<?php

namespace App\Http\Controllers;

use Auth;
use Session;
use App\Department;
use App\Designation;
use App\Employee;
use App\Role;
use App\Team;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Permission;

class AssignRoleController extends Controller {

    public function create() {
        $roles = Role::all();
        $employees = Employee::all();
        $departments = Department::all();
        $teams = Team::all();
        $designations = Designation::all();

        $breadcrumbs = [
            ['link' => "/", 'name' => "Home"],
            ['link' => "/roles/", 'name' => "Assign Roles"],
            ['name' => "Assign"],
        ];
        $pageConfigs = ['pageHeader' => true, 'isFabButton' => true, 'isCustomizer' => true];
//        $rightlink = [
//            ['rightlink' => "/role/assign/", 'name' => "Assign"]
//        ];
        return view('assignrole.new', [
            'pageConfigs' => $pageConfigs,
            'breadcrumbs' => $breadcrumbs,
//            'rightlink' => $rightlink,
            'roles' => $roles,
            'employees' => $employees,
            'departments' => $departments,
            'teams' => $teams,
            'designations' => $designations,
        ]);

        return view('assignrole.new', compact('roles', 'employees', 'departments', 'teams', 'designations'));
    }

    public function store(Request $request) {

        $name = '';

        if ($request->assign_to === 'employees') {

            foreach ($request->employees as $employee) {

                $emp = Employee::find($employee);
                $user = User::find($emp->user->id);
//                echo $emp->user->id;
//                dd($user);
//                $role = Role::findOrFail(['name' => 'employees']);

                $user->syncRoles($request->roles);
//                dd($request->roles);
            }
            $name = 'employees';
        } elseif ($request->assign_to === 'department') {

            $department = Department::find($request->department);
            foreach ($department->employees as $employee) {
//                $emp = Employee::find($employee->id);
//                $user = User::find($emp->user->id);
//                $user->syncRoles($request->roles);
                $emp = Employee::where('Select_Department', '=', $request->department)->get();
                foreach ($emp as $emp) {
                    $user = User::find($emp->user->id);
                    $user->syncRoles($request->roles);
                }
            }
            $name = 'department';
        } elseif ($request->assign_to === 'team') {
             $team = Team::find($request->team);
            foreach ($team->employees as $employee) {

                $emp = Employee::where('Select_Team', '=', $request->team)->get();
                 foreach ($emp as $emp) {
                    $user = User::find($emp->user->id);
                    $user->syncRoles($request->roles);
                    
                }
            }
             $name = 'team';
        } elseif ($request->assign_to === 'designation') {
            $designation = Designation::find($request->designation);
            foreach ($designation->employees as $employee) {
//                $emp = Employee::find($employee->id);
//                $user = User::find($emp->user->id);
//                $user->syncRoles($request->roles);
                $emp = Employee::where('select_designation', '=', $request->designation)->get();
                foreach ($emp as $emp) {
                    $user = User::find($emp->user->id);
                    $user->syncRoles($request->roles);
                }
            }
            $name = 'designation';
        }
         return redirect(route('roles.index'))->with('success', 'Role assigned to! ' . $name);
     }

    public function all_view() {

        $getAllRoles_Details = DB::table('users')
                ->select('users.*', 'roles.name as rolesname')
                 ->join('model_has_roles', 'model_has_roles.model_id', '=', 'users.id')
                ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
                 ->get();

        $breadcrumbs = [
            ['link' => "crm", 'name' => "Home"],
            ['link' => "/roles/", 'name' => "Manage Role"],
            ['name' => "View"],
        ];

        //Pageheader set true for breadcrumbs
        $pageConfigs = ['pageHeader' => true, 'isFabButton' => true, 'isCustomizer' => true];

        $users = User::all();

        return view('assignrole.view', [
            'pageConfigs' => $pageConfigs, 'breadcrumbs' => $breadcrumbs,
            'users' => $users,
            'getAllRoles_Details' => $getAllRoles_Details,
        ]);
    }

}

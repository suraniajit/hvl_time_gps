<?php

namespace App\Http\Controllers;

use App\Permission;
use App\Role;
use Auth;
use App\User;
use Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class RoleController extends Controller {

    public function __construct() {
        $this->middleware('permission:Access Role', ['only' => ['show', 'index']]);
        $this->middleware('permission:Create Role', ['only' => ['create']]);
        $this->middleware('permission:Edit Role', ['only' => ['edit']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index() {
        $roles = Role::all();
//        return view('role.index', compact('roles'));

        if (Auth::user()->can('Create Role')) {
            $breadcrumbs = [
                ['link' => "crm", 'name' => "Home"],
                ['link' => "/roles/", 'name' => " Manage Role"],
                ['link' => "/roles/create", 'name' => "Create"],
            ];
            $rightlink = [
                ['rightlink' => "/roles/create", 'name' => "Create"]
            ];
            //Pageheader set true for breadcrumbs
            $pageConfigs = ['pageHeader' => true, 'isFabButton' => true, 'isCustomizer' => true];

            return view('role.index', [
                'pageConfigs' => $pageConfigs,
                'breadcrumbs' => $breadcrumbs,
                'rightlink' => $rightlink,
                'roles' => $roles
            ]);
        } else {
            $breadcrumbs = [
                ['link' => "crm", 'name' => "Home"],
                ['link' => "/roles/", 'name' => " Manage Role"],
            ];

            //Pageheader set true for breadcrumbs
            $pageConfigs = ['pageHeader' => true, 'isFabButton' => true, 'isCustomizer' => true];

            return view('role.index', [
                'pageConfigs' => $pageConfigs,
                'breadcrumbs' => $breadcrumbs,
                'roles' => $roles
            ]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create() {
        $permissions = Permission::all();
//        return view('role.new', compact('permissions'));

        $breadcrumbs = [
            ['link' => "crm", 'name' => "Home"],
            ['link' => "/roles/", 'name' => " Manage Role"],
            ['name' => "Create"],
        ];
        //Pageheader set true for breadcrumbs
        $pageConfigs = ['pageHeader' => true, 'isFabButton' => true, 'isCustomizer' => true];

        return view('role.new', [
            'pageConfigs' => $pageConfigs,
            'breadcrumbs' => $breadcrumbs,
            'permissions' => $permissions
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $this->validate($request, ['name' => 'required|unique:roles']);
        $role = Role::create($request->only('name'));
        $role->syncPermissions($request->permissions);

        return redirect(route('roles.index'))->with('success', 'Role has been created!');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public static function getName_byId_and_Table($id, $table) {
        return DB::table($table)
                        ->select($table . '.*')
                        ->where($table . '.' . $id, '=', $role_id)
                        ->join('users', 'users.id', '=', 'model_has_roles.model_id')
                        ->join('employees', 'users.id', '=', 'employees.user_id')
                        ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
                        ->get();
    }

    public function view($id) {
//        echo $id;
//        $getAllRolesBYRoles = app('App\Http\Controllers\UserProfileController')->getAllRolesBYRoles($id);
//        $getAllRoles_Details = DB::table('model_has_roles')
//                ->select(
//                        'users.*', 'employees.*','roles.id as roles_id'
//                )
//                ->join('users', 'users.id', '=', 'model_has_roles.model_id')
//                ->join('employees', 'users.id', '=', 'employees.user_id')
//                ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
//                ->get();

        $getAllRoles_Details = DB::table('users')
                ->select('users.*', 'roles.name as rolesname')
//                ->select('users.*', 'employees.*')
                ->join('model_has_roles', 'model_has_roles.model_id', '=', 'users.id')
                ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
//                ->join('employees', 'employees.user_id', '=', 'users.id')
                ->where('model_has_roles.role_id', '=', $id)
                ->get();

//        dd($getAllRoles_Details);
        $breadcrumbs = [
            ['link' => "crm", 'name' => "Home"],
            ['link' => "/roles/", 'name' => "Manage Role"],
            ['name' => "View"],
        ];

        //Pageheader set true for breadcrumbs
        $pageConfigs = ['pageHeader' => true, 'isFabButton' => true, 'isCustomizer' => true];

        $users = User::all();
//        $users = DB::table('users')->get();

        return view('role.view', [
            'pageConfigs' => $pageConfigs,
            'breadcrumbs' => $breadcrumbs,
            'users' => $users,
            'id' => $id,
            'getAllRoles_Details' => $getAllRoles_Details,
        ]);
    }

    public function show($id) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id) {

        $permissions = Permission::all();
//        $posts = Post::orderBy('id', 'DESC')->get();
//        $permissions = Permission::orderBy('name', 'ASC')->get();

        $role = Role::findById($id);
//        return view('role.edit', compact('permissions', 'role'));

        $breadcrumbs = [
            ['link' => "crm", 'name' => "Home"],
            ['link' => "/roles/", 'name' => " Manage Role"],
            ['name' => "Edit Role"],
        ];

        //Pageheader set true for breadcrumbs
        $pageConfigs = ['pageHeader' => true, 'isFabButton' => true, 'isCustomizer' => true];

        return view('role.edit', [
            'pageConfigs' => $pageConfigs,
            'breadcrumbs' => $breadcrumbs,
            'permissions' => $permissions,
            'role' => $role
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if ($role = Role:: findOrFail($id)) {
            // admin role has everything
            if ($role->name === 'Admin') {
                $role->syncPermissions(Permission::all());
                return redirect()->route('roles.index');
            }

            $permissions = $request->get('permissions', []);

            $role->syncPermissions($permissions);

            return redirect()->route('roles.index')->with('success', 'Role has been updated!');
        } else {
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $role = Role::findById($id);
        $role->delete();
        return response()->json(['message'
                    => 'Given record has been removed!'], 200);
    }

}

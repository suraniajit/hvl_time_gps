<?php

namespace App\Http\Controllers;

use Auth;
use App\Module;
use App\User;
use App\Role;
use App\Employee;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\UserColors;
use Illuminate\Support\Facades\DB;

class UserController extends Controller {

    public function __construct() {
        $this->middleware('permission:Access User', ['only' => ['show', 'index']]);
        $this->middleware('permission:Create User', ['only' => ['create']]);
        $this->middleware('permission:Edit User', ['only' => ['edit']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index() {
        $users = User::all();
        //return view('users.index', compact('users'));
        if (Auth::user()->can('Create User')) {
            $breadcrumbs = [
                ['link' => "/", 'name' => "Home"],
                ['link' => "/users/", 'name' => "Users"],
//                ['link' => "/users/create", 'name' => "Create"],
            ];
            $rightlink = [
                ['rightlink' => "/users/create", 'name' => "Create"]
            ];
            //Pageheader set true for breadcrumbs
            $pageConfigs = ['pageHeader' => true, 'isFabButton' => true, 'isCustomizer' => true];

            return view('users.index', [
                'pageConfigs' => $pageConfigs,
                'breadcrumbs' => $breadcrumbs,
                'rightlink' => $rightlink,
                'users' => $users
            ]);
        } else {
            $breadcrumbs = [
                ['link' => "crm", 'name' => "Home"],
                ['link' => "/users/", 'name' => "Users"],
            ];

            //Pageheader set true for breadcrumbs
            $pageConfigs = ['pageHeader' => true, 'isFabButton' => true, 'isCustomizer' => true];

            return view('users.index', [
                'pageConfigs' => $pageConfigs,
                'breadcrumbs' => $breadcrumbs,
                'users' => $users
            ]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create() {
        $roles = Role::all();
        //return view('users.new', compact('roles'));

        $breadcrumbs = [
            ['link' => "/", 'name' => "Home"],
            ['link' => "/users/", 'name' => "Users"],
            ['name' => "Create"],
        ];

        //Pageheader set true for breadcrumbs
        $pageConfigs = ['pageHeader' => true, 'isFabButton' => true, 'isCustomizer' => true];

        return view('users.new', [
            'pageConfigs' => $pageConfigs,
            'breadcrumbs' => $breadcrumbs,
            'roles' => $roles
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $this->validate($request, [
            'name' => 'bail|required|min:2',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'roles' => 'required|min:1'
        ]);

        // hash password
        $request->merge(['password' => bcrypt($request->get('password'))]);


        $DataUser = User::create($request->except('roles'));

        $lastId = $DataUser->id;


        $table_id = Employee::insertGetId([]);
        Employee::where('id', $table_id)->update([
            'name' => $request->name,
            'user_id' => $lastId,
            'email' => $request->email
        ]);
        /* assgin default roles of 'employee' start */
//        DB::table('model_has_roles')->insert(
//                array(
//                    'role_id' => '2',
//                    'model_type' => 'App\User',
//                    'model_id' => $table_id
//                )
//        );
        /* assgin default roles of 'employee' end */


//*color code genrate start*/
        $colorUsers = UserColors::firstOrNew([
                    'user_id' => $lastId,
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

//*color code genrate end*/
//
//
        // Create the user
        if ($user = $DataUser) {

            $user->syncRoles($request->roles);

            return redirect()->route('users.index')->with('success', 'User has been created.');
        } else {
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
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
        $user = User::find($id);
        $roles = Role::all();
        //return view('users.edit', compact('user', 'roles'));


        $breadcrumbs = [
            ['link' => "/", 'name' => "Home"],
            ['link' => "/users/", 'name' => "Users"],
            ['name' => "edit"],
        ];

        //Pageheader set true for breadcrumbs
        $pageConfigs = ['pageHeader' => true, 'isFabButton' => true, 'isCustomizer' => true];

        return view('users.edit', [
            'pageConfigs' => $pageConfigs,
            'breadcrumbs' => $breadcrumbs,
            'user' => $user,
            'roles' => $roles
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id) {
        
        
        
        $this->validate($request, [
            // 'name' => 'bail|required|min:2',
            // 'email' => 'required|email|unique:users,email,' . $id,
            'roles' => 'required|min:1'
        ]);

        // Get the user
        $user = User::findOrFail($id);

        // Update user
        // $user->fill($request->except('roles', 'password'));

        // check for password change
        if ($request->get('password')) {
            $user->password = bcrypt($request->get('password'));
        }

        // Handle the user roles
        $user->syncRoles($request->roles);

        $user->save();

        redirect()->back()->with('success', 'User has been updated. !');
        return redirect('/users/');
//        redirect()->route('users.index')->with('success', 'User has been updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id) {
        
        /*01-02-2024*/
        DB::table('api_expenses')->where('is_user', $id)->delete();
        DB::table('employees')->where('user_id', $id)->delete();
        /*01-02-2024*/
        
        $user = User::find($id);
        $user->delete();
        return response()->json(['message' => 'Given record has been removed!'], 200);
    }

}

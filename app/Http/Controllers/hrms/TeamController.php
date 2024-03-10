<?php

namespace App\Http\Controllers\hrms;

use App\User;
use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\softDeletes;
use Illuminate\Support\Facades\View;
use Illuminate\Validation\Rule;
use App\Models\hrms\Team;
use App\Models\hrms\TeamEmpAssign;
use App\Models\hrms\EmployeeMaster;
use Datatables;
use SweetAlert;
use Validator;

class TeamController extends Controller {

    function __construct() {
//        $this->middleware('auth');
        $this->middleware('permission:team-list|team-create|team-edit|team-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:team-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:team-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:team-delete', ['only' => ['delete']]);
        $this->middleware('permission:team-multidelete', ['only' => ['multidelete']]);
    }

    public function index() {
        //Pageheader set true for breadcrumbs
        $pageConfigs = ['pageHeader' => true, 'isFabButton' => true,'isCustomizer' => true];
        if (Auth::user()->can('team-create')) {
            $breadcrumbs = [
             ['link' => "hrms", 'name' => "Home"],
             ['link' => "hrms/team/", 'name' => "Team Master"],
             ['link' => "hrms/team/create", 'name' => "Create"],
            ];
            $rigthlink = [
             ['rigthlink' => "team/create", 'name' => "Create"]
            ];
            return view('hrms.team.index', [
             'rigthlink' => $rigthlink,
             'pageConfigs' => $pageConfigs,
             'breadcrumbs' => $breadcrumbs,
            ]);
        } else {
            $breadcrumbs = [
             ['link' => "hrms", 'name' => "Home"],
             ['link' => "hrms/team/", 'name' => "Team Master"],
            ];
            return view('hrms.team.index', [
             'pageConfigs' => $pageConfigs,
             'breadcrumbs' => $breadcrumbs,
            ]);
        }
    }

    public function create() {

        $breadcrumbs = [
         ['link' => "hrms", 'name' => "Home"],
         ['link' => "hrms/team/", 'name' => "Team Master"],
         ['name' => "Create"],
        ];
//Pageheader set true for breadcrumbs
        $pageConfigs = ['pageHeader' => true, 'isFabButton' => true,'isCustomizer' => true];

        $VendorMaster = DB::table('vendors')->where('is_active', '=', '0')
                ->get();
        $EmployeeMaster = DB::table('employee_masters')->where('is_active', '=', '0')
                ->get();
        $ShiftMaster = DB::table('shifts')->where('is_active', '=', '0')
                ->get();

        return view('hrms.team.create', [
         'EmployeeMasters' => $EmployeeMaster,
         'VendorMasters' => $VendorMaster,
         'ShiftMasters' => $ShiftMaster,
         'pageConfigs' => $pageConfigs,
         'breadcrumbs' => $breadcrumbs
        ]);
    }

    public function store(Request $Request) {

        $emp_id = $Request->emp_id;
        $shift_id = $Request->shift_id;
        $implode = implode(',', $emp_id);

        Team::create([
         'team_name' => $Request->team_name,
          'team_lead' => $Request->team_lead,
         'vendor_id' => $Request->vendor_id,
         'date_of_shift' => $Request->date_of_shift,
         'shift_id' => $shift_id,
         'emp_ids' => $implode,
         'total_emp' => count($Request->emp_id)
        ]);
        $Team_last_id = DB::getPDO()->lastInsertId();


        for ($i = 0; $i < count($emp_id); $i++) {
            TeamEmpAssign::create([
             'emp_id' => $Request->emp_id[$i],
             'team_id' => $Team_last_id
            ]);
        }

        foreach ($emp_id as $emp) {
            $EmployeeGetData = EmployeeMaster::findOrFail($emp);
            $EmployeeGetData->update([
             'team_id' => $Team_last_id,
            ]);
            $EmployeeGetData->save();
        }

        redirect()->back()->with('success', 'New Team Create Successfully !');
        return redirect('hrms/team/');
    }

    function getdata() {

        $Teams = DB::table('teams')
                ->where('teams.deleted_at', '=', '')
                ->orWhereNull('teams.deleted_at')
                ->select(
                        'teams.id',
                        'status_codes.name',
                        'teams.team_name',
                        'teams.is_active',
                        'teams.created_at',
                        'vendors.vendor_name',
                        'teams.total_emp',
                        'shifts.shift_name',
                        'teams.date_of_shift')
                ->join('status_codes', 'status_codes.code', '=', 'teams.is_active')
                ->join('vendors', 'vendors.id', '=', 'teams.vendor_id')
                ->join('shifts', 'shifts.id', '=', 'teams.shift_id')
//                               ->join('team_emp_assigns', 'team_emp_assigns.team_id', '=', 'teams.id')
                ->get();
        return Datatables::of($Teams)
                        ->addColumn('action', function($Team) {

                            $actionBtn = '';

                            if (Auth::user()->can('team-view')) {
                                
                            }
                            if (Auth::user()->can('team-edit')) {
                                $actionBtn .= '<a href="' . route('hrms.team.view', ['id' => $Team->id]) . '"><i class="material-icons dp48">visibility</i></a>';
                                $actionBtn .= '<a href = "' . route('hrms.team.edit', ['id' => $Team->id]) . '" class = "invoice-action-edit edit" id = "' . $Team->id . '"><i class="material-icons">edit</i></a>';
                            }
                            if (Auth::user()->can('team-delete')) {
                                $actionBtn .= '<a href = "#" class = "invoice-action-view mr-4 delete" id = "' . $Team->id . '"><i class="material-icons dp48 button delete-confirm">delete</i></a>';
                            }

                            return $actionBtn;
                        })
                        ->addColumn('checkbox', '<label><input type = "checkbox" class = "batch_checkbox" value = "{{$id}}" /><span></span></label>')
                        ->rawColumns(['checkbox', 'action'])
                        ->make(true);
    }

    function delete(Request $request) {
        /* single delete */
        $id = $request->input('id');
        $Teams_delete = Team::whereId($request->input('id'))->first();
        $Teams_delete->update([
         'is_active' => '1',
         'total_emp' => '0',
         'emp_ids' => NULL
        ]);
        $Teams = Team::find($request->input('id'));
        if ($Teams->delete()) {
            echo 'Data Deleted';
        }


        $Team = TeamEmpAssign::where("team_id", "=", $id);
        $Team->update([
         'is_active' => '1',
        ]);


        $empAss_team_delete = TeamEmpAssign::where("team_id", "=", $request->input('id'));
        if ($empAss_team_delete->forceDelete()) {
            echo 'Data Deleted';
        }

        $Emp_team_delete = EmployeeMaster::where("team_id", "=", $request->input('id'));
        $Emp_team_delete->update([
         'team_id' => '0',
        ]);
    }

    function multidelete(Request $request) {
        $Team_id_array = $request->input('id');

        foreach ($Team_id_array as $id) {
            $Teams_delete = Team::whereId($id)->first();
            $Teams_delete->update([
             'is_active' => '1',
             'total_emp' => '0',
             'emp_ids' => NULL
            ]);

            $Team = TeamEmpAssign::where("team_id", "=", $id);
            $Team->update([
             'is_active' => '1',
            ]);

            $empAss_team_delete = TeamEmpAssign::where("team_id", "=", $id);
            if ($empAss_team_delete->forceDelete()) {
                echo 'Data Deleted';
            }
            $Emp_team_delete = EmployeeMaster::where("team_id", "=", $id);
            $Emp_team_delete->update([
             'team_id' => '0',
            ]);
        }

        $Team = Team:: whereIn('id', $Team_id_array);
        if ($Team->delete()) {
            echo 'Data Deleted';
        }
    }

    public function edit($id) {
        $breadcrumbs = [
         ['link' => "hrms", 'name' => "Home"],
         ['link' => "hrms/team/", 'name' => "Team Master"],
         ['name' => "Update"],
        ];
//Pageheader set true for breadcrumbs
        $pageConfigs = ['pageHeader' => true, 'isFabButton' => true,'isCustomizer' => true];

        $Team = DB::table('teams')->where('is_active', '=', '0')
                ->get();
        $EmployeeMaster = DB::table('employee_masters')->where('is_active', '=', '0')
                ->get();
        $VendorMaster = DB::table('vendors')->where('is_active', '=', '0')
                ->get();

        $TeamEmployee = DB::table('teams')
                ->where('teams.deleted_at', '=', '')
                ->orWhereNull('teams.deleted_at')
                ->select('teams.id', 'employee_masters.f_name', 'employee_masters.id')
                ->join('team_emp_assigns', 'teams.id', '=', 'team_emp_assigns.team_id')
                ->join('employee_masters', 'team_emp_assigns.emp_id', '=', 'employee_masters.id')
                ->get();

        $selectedemployee = DB::table("team_emp_assigns")->where("team_emp_assigns.team_id", $id)
                ->pluck('team_emp_assigns.emp_id', 'team_emp_assigns.emp_id')
                ->all();

        $ShiftMaster = DB::table('shifts')->where('is_active', '=', '0')
                ->get();


        if ($Team = Team::whereId($id)->first()) {
            return view('hrms.team.edit',
                    [
                     'ShiftMasters' => $ShiftMaster,
                     'selectedemployee' => $selectedemployee,
                     'TeamEmployee' => $TeamEmployee,
                     'EmployeeMasters' => $EmployeeMaster,
                     'VendorMasters' => $VendorMaster,
                     'Team_Details' => $Team,
                     'pageConfigs' => $pageConfigs,
                     'breadcrumbs' => $breadcrumbs
            ]);
        }
    }

    public function update(Request $Request, $id) {

        $team_id = $Request->team_id;
        $vendor_id = $Request->vendor_id;
        $emp_id = $Request->emp_id;
        $implode = implode(',', $emp_id);
        $shift_id = $Request->shift_id;


        $Team = Team::findOrFail($id);
        $Team->update([
         'team_name' => $Request->team_name,
           'team_lead' => $Request->team_lead,
         'vendor_id' => $Request->vendor_id,
         'date_of_shift' => $Request->date_of_shift,
         'shift_id' => $shift_id,
         'emp_ids' => $implode,
         'total_emp' => count($Request->emp_id)
        ]);
        $Team->save();

        if (count($emp_id) > 0) {
            $emp_delete = TeamEmpAssign:: where("team_id", "=", $team_id);
            $empAssingCount = $emp_delete->count();
            if ($empAssingCount > 0) {
//                have data
                if ($emp_delete->forceDelete()) {
                    for ($i = 0; $i < count($emp_id); $i++) {
                        TeamEmpAssign::create([
                         'emp_id' => $emp_id[$i],
                         'team_id' => $team_id,
                        ]);
                    }
                }
            } else {
//                echo 'no data';
                for ($i = 0; $i < count($emp_id); $i++) {
                    TeamEmpAssign::create([
                     'emp_id' => $emp_id[$i],
                     'team_id' => $team_id,
                    ]);
                }
            }
        }

        foreach ($emp_id as $emp) {
            $EmployeeGetData = EmployeeMaster::findOrFail($emp);
            $EmployeeGetData->update([
             'team_id' => $team_id,
            ]);
            $EmployeeGetData->save();
        }



        redirect()->back()->with('success', 'Team Update Successfully !');
        return redirect('hrms/team/');
    }

    public function view($id) {
        $breadcrumbs = [
         ['link' => "hrms", 'name' => "Home"],
         ['link' => "hrms/team/", 'name' => "Team Master"],
         ['name' => "view"],
        ];
//Pageheader set true for breadcrumbs
        $pageConfigs = ['pageHeader' => true, 'isFabButton' => true,'isCustomizer' => true];

        $Team = DB::table('teams')->where('is_active', '=', '0')
                ->get();
        $EmployeeMaster = DB::table('employee_masters')->where('is_active', '=', '0')
                ->get();
        $VendorMaster = DB::table('vendors')->where('is_active', '=', '0')
                ->get();

        $TeamEmployee = DB::table('teams')
                ->where('teams.deleted_at', '=', '')
                ->orWhereNull('teams.deleted_at')
                ->select('teams.id', 'employee_masters.f_name', 'employee_masters.id')
                ->join('team_emp_assigns', 'teams.id', '=', 'team_emp_assigns.team_id')
                ->join('employee_masters', 'team_emp_assigns.emp_id', '=', 'employee_masters.id')
                ->get();


        $selectedemployee = DB::table("team_emp_assigns")->where("team_emp_assigns.team_id", $id)
                ->pluck('team_emp_assigns.emp_id', 'team_emp_assigns.emp_id')
                ->all();
        $ShiftMaster = DB::table('shifts')->where('is_active', '=', '0')
                ->get();

        if ($Team = Team::whereId($id)->first()) {
            return view('hrms.team.view',
                    [
                     'ShiftMasters' => $ShiftMaster,
                     'selectedemployee' => $selectedemployee,
                     'TeamEmployee' => $TeamEmployee,
                     'EmployeeMasters' => $EmployeeMaster,
                     'VendorMasters' => $VendorMaster,
                     'Team_Details' => $Team,
                     'pageConfigs' => $pageConfigs,
                     'breadcrumbs' => $breadcrumbs
            ]);
        }
    }

    public function validname(Request $request) {
        /* Validaiton of the designation */
        if ($request->input('team_name') !== '') {
            $rule = array(
             'team_name' => 'required|unique:teams,team_name,NULL,id,deleted_at,NULL',
            );
            $validator = Validator::make($request->all(), $rule);
            if (!$validator->fails()) {
                die('true');
            }
        }
        die('false');
    }

    public function editvalidname(Request $request) {
//        designationes.team_name',
        /* validating all the fields and unique marital status name while updating */
        $id = $request->id;
        $rule = array(
         'team_name' => Rule::unique('teams', 'team_name')
                 ->where('is_active', '=', '0')
                 ->ignore($id),
        );
        $validator = Validator::make($request->all(), $rule);
        if (!$validator->fails()) {
            die('true');
        }
        die('false');
    }

}

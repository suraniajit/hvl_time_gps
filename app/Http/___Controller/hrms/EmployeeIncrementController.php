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
use App\Models\hrms\EmployeeIncrement;
use Datatables;
use SweetAlert;
use Validator;

class EmployeeIncrementController extends Controller {

    function __construct() {
//        $this->middleware('auth');
        $this->middleware('permission:empincrement-list|empincrement-create|empincrement-edit|empincrement-delete', ['only' => ['index', 'getdata']]);
        $this->middleware('permission:empincrement-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:empincrement-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:empincrement-delete', ['only' => ['delete']]);
        $this->middleware('permission:empincrement-multidelete', ['only' => ['multidelete']]);
    }

    public function index() {
        if (Auth::user()->can('empincrement-create')) {
            //Pageheader set true for breadcrumbs
            $pageConfigs = ['pageHeader' => true, 'isFabButton' => true,'isCustomizer' => true];
            $breadcrumbs = [
             ['link' => "hrms", 'name' => "Home"],
             ['link' => "hrms/empincrement/", 'name' => "Employee Increment Master"],
             ['link' => "hrms/empincrement/create", 'name' => "Create"],
            ];
            $rigthlink = [
             ['rigthlink' => "empincrement/create", 'name' => "Create"]
            ];
            return view('hrms.empincrement.index', [
             'rigthlink' => $rigthlink,
             'pageConfigs' => $pageConfigs,
             'breadcrumbs' => $breadcrumbs]
            );
        } else {
            $breadcrumbs = [
             ['link' => "hrms", 'name' => "Home"],
             ['link' => "hrms/empincrement/", 'name' => "Employee Increment Master"],
             ];


            return view('hrms.empincrement.index', [
             'pageConfigs' => $pageConfigs,
             'breadcrumbs' => $breadcrumbs]
            );
        }
    }

    public function create() {

        $breadcrumbs = [
         ['link' => "hrms", 'name' => "Home"],
         ['link' => "hrms/empincrement/", 'name' => "Employee Increment Master"],
         ['name' => "Create"],
        ];
        //Pageheader set true for breadcrumbs
        $pageConfigs = ['pageHeader' => true, 'isFabButton' => false,'isCustomizer' => true];

        $EmployeeMaster = DB::table('employee_masters')->where('is_active', '=', '0')
                ->get();
        $DepartmentMaster = DB::table('departments')->where('is_active', '=', '0')
                ->get();
        $DesignationMaster = DB::table('designations')->where('is_active', '=', '0')
                ->get();
        $increment_types = DB::table('increment_types')->where('is_active', '=', '0')
                ->get();

        return view('hrms.empincrement.create', [
         'increment_types' => $increment_types,
         'EmployeeMasters' => $EmployeeMaster,
         'DesignationMasters' => $DesignationMaster,
         'pageConfigs' => $pageConfigs,
         'breadcrumbs' => $breadcrumbs
        ]);
    }

    public function getEmpDesignation(Request $Request) {
        /* Auto get emp desgination using ajax call */
        $emp_id = $Request->emp_id;
        $getEmpDesignations = DB::table('employee_masters')
                ->select('employee_masters.f_name',
                        'employee_masters.id',
                        'employee_masters.designation_id',
                        'designations.designation_name')
                ->where('employee_masters.id', '=', $emp_id)
                ->where('designations.is_active', '=', '0')
                ->join('designations', 'designations.id', '=', 'employee_masters.designation_id')
                ->get();
        foreach ($getEmpDesignations as $getEmpDesignation) {
            if ($emp_id == $getEmpDesignation->id) {
                echo $getEmpDesignation->designation_name;
            }
        }
    }

    public function store(Request $Request) {
        $EmployeeIncrement = EmployeeIncrement::create([
                 'emp_id' => $Request->emp_id,
                 'increment_date' => $Request->increment_date,
                 'emp_designation_current' => $Request->emp_designation_current,
                 'designation_id' => $Request->designation_id,
                 'increment_id' => $Request->increment_id,
                 'remark' => $Request->remark,
        ]);
        redirect()->back()->with('success', 'Employee Increment Master Create Successfully !');
        return redirect('hrms/empincrement/');
    }

    function getdata() {

        $EmployeeIncrements = DB::table('employee_increments')
                ->where('employee_increments.deleted_at', '=', '')
                ->orWhereNull('employee_increments.deleted_at')
                ->select('employee_increments.id',
                        'status_codes.name',
                        'employee_increments.emp_id',
                        'employee_masters.f_name',
                        'employee_increments.increment_date',
                        'employee_increments.emp_designation_current',
                        'designations.designation_name',
                        'increment_types.increment_name',
                        'employee_increments.remark'
                )
                ->join('employee_masters', 'employee_increments.emp_id', '=', 'employee_masters.id')
                ->join('designations', 'employee_increments.designation_id', '=', 'designations.id')
                ->join('increment_types', 'employee_increments.increment_id', '=', 'increment_types.id')
                ->join('status_codes', 'status_codes.code', '=', 'employee_increments.is_active')
                ->get();
        return Datatables::of($EmployeeIncrements)
                        ->addColumn('action', function($EmployeeIncrement) {

                            $actionBtn = '';
                            if (Auth::user()->can('empincrement-view')) {
                                $actionBtn .= '<a href="' . route('hrms.empincrement.view', ['id' => $EmployeeIncrement->id]) . '"><i class="material-icons dp48">visibility</i></a>';
                            }
                            if (Auth::user()->can('empincrement-edit')) {
                                $actionBtn .= '<a href = "' . route('hrms.empincrement.edit', ['id' => $EmployeeIncrement->id]) . '" class = "invoice-action-edit edit" id = "' . $EmployeeIncrement->id . '"><i class="material-icons">edit</i></a>';
                            }
                            if (Auth::user()->can('empincrement-delete')) {
                                $actionBtn .= '<a href = "#" class = "invoice-action-view mr-4 delete" id = "' . $EmployeeIncrement->id . '"><i class="material-icons dp48 button delete-confirm">delete</i></a>';
                            }
                            return $actionBtn;
                        })
                        ->addColumn('checkbox', '<label><input type = "checkbox" class = "EmployeeIncrement_checkbox" value = "{{$id}}" /><span></span></label>')
                        ->rawColumns(['checkbox', 'action'])
                        ->make(true);
    }

    function delete(Request $request) {
        /* single delete */
        $EmployeeIncrement_deletes = EmployeeIncrement::whereId($request->input('id'))->first();
        $EmployeeIncrement_deletes->update([
         'is_active' => '1',
        ]);
        $EmployeeIncrements = EmployeeIncrement::find($request->input('id'));
        if ($EmployeeIncrements->delete()) {
            echo 'Data Deleted';
        }
    }

    function multidelete(Request $request) {
        /* mulit delete */
        $EmployeeIncrement_id_array = $request->input('id');
        foreach ($EmployeeIncrement_id_array as $id) {
            $EmployeeIncrement_deletes = EmployeeIncrement::whereId($id)->first();
            $EmployeeIncrement_deletes->update([
             'is_active' => '1',
            ]);
        }
        $EmployeeIncrement = EmployeeIncrement::whereIn('id', $EmployeeIncrement_id_array);
        if ($EmployeeIncrement->delete()) {
            echo 'Data Deleted';
        }
    }

    public function edit($id) {
        $breadcrumbs = [
         ['link' => "hrms", 'name' => "Home"],
         ['link' => "hrms/empincrement/", 'name' => "Employee Increment Master"],
         ['name' => "Update"],
        ];
        $pageConfigs = ['pageHeader' => true, 'isFabButton' => true,'isCustomizer' => true];

        $EmployeeMaster = DB::table('employee_masters')->where('is_active', '=', '0')
                ->get();
        $DepartmentMaster = DB::table('departments')->where('is_active', '=', '0')
                ->get();
        $DesignationMaster = DB::table('designations')->where('is_active', '=', '0')
                ->get();
        $increment_types = DB::table('increment_types')->where('is_active', '=', '0')
                ->get();

        if ($EmployeeIncrementDetails = EmployeeIncrement::whereId($id)->first()) {
            return view('hrms.empincrement.edit', [
             'increment_types' => $increment_types,
             'EmployeeIncrementDetails' => $EmployeeIncrementDetails,
             'EmployeeMasters' => $EmployeeMaster,
             'DesignationMasters' => $DesignationMaster,
             'pageConfigs' => $pageConfigs,
             'breadcrumbs' => $breadcrumbs
            ]);
        }
    }

    public function update(Request $Request, $id) {

        $EmployeeIncrement = EmployeeIncrement::findOrFail($id);
        $EmployeeIncrement->update([
         'emp_id' => $Request->emp_id,
         'increment_date' => $Request->increment_date,
         'emp_designation_current' => $Request->emp_designation_current,
         'designation_id' => $Request->designation_id,
         'increment_id' => $Request->increment_id,
         'remark' => $Request->remark,
        ]);
        $EmployeeIncrement->save();
        redirect()->back()->with('success', 'Employee Increment Master Update Successfully!');
        return redirect('hrms/empincrement/');
    }

    public function view($id) {
        $breadcrumbs = [
         ['link' => "hrms", 'name' => "Home"],
         ['link' => "hrms/empincrement/", 'name' => "Employee Increment Master"],
         ['name' => "View"],
        ];
        $pageConfigs = ['pageHeader' => true, 'isFabButton' => true,'isCustomizer' => true];

        $EmployeeMaster = DB::table('employee_masters')->where('is_active', '=', '0')
                ->get();
        $DepartmentMaster = DB::table('departments')->where('is_active', '=', '0')
                ->get();
        $DesignationMaster = DB::table('designations')->where('is_active', '=', '0')
                ->get();
        $increment_types = DB::table('increment_types')->where('is_active', '=', '0')
                ->get();

        if ($EmployeeIncrementDetails = EmployeeIncrement::whereId($id)->first()) {
            return view('hrms.empincrement.view', [
             'increment_types' => $increment_types,
             'EmployeeIncrementDetails' => $EmployeeIncrementDetails,
             'EmployeeMasters' => $EmployeeMaster,
             'DesignationMasters' => $DesignationMaster,
             'pageConfigs' => $pageConfigs,
             'breadcrumbs' => $breadcrumbs
            ]);
        }
    }

}

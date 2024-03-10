<?php

   namespace App\Http\Controllers\hrms;

   use App\Http\Controllers\Controller;
   use Illuminate\Http\Request;
   use Illuminate\Support\Facades\DB;
   use App\Models\hrms\Employee;
   use Datatables;
   use Illuminate\Database\Eloquent\softDeletes;
   use Illuminate\Support\Facades\View;

   class EmployeeController extends Controller {

       public function index() {
           $breadcrumbs = [
              ['link' => "hrms", 'name' => "Home"],
              ['link' => "hrms/employee/", 'name' => "Employee Master"],
              ['link' => "hrms/employee/create", 'name' => "Create"],
           ];
           //Pageheader set true for breadcrumbs
           $pageConfigs = ['pageHeader' => true, 'isFabButton' => true];
           $rigthlink = [
              ['rigthlink' => "designation/create", 'name' => "Create"]
           ];
           $Employees = DB::table('batches')->get();
           return view('hrms.employee.index', [
              'rigthlink' => $rigthlink,
              'pageConfigs' => $pageConfigs,
              'breadcrumbs' => $breadcrumbs,
              'batchs' => $Employees
           ]);
       }

       public function create() {

           $breadcrumbs = [
              ['link' => "hrms", 'name' => "Home"],
              ['link' => "hrms/employee/", 'name' => "Employee Master"],
              ['link' => "hrms/employee/create", 'name' => "Create"],
           ];
           //Pageheader set true for breadcrumbs
           $pageConfigs = ['pageHeader' => true, 'isFabButton' => true];

           return view('hrms.employee.create', [
              'pageConfigs' => $pageConfigs,
              'breadcrumbs' => $breadcrumbs
           ]);
       }

       public function store(Request $Request) {
           $this->validate($Request, [
              'f_name' => 'required',
           ]);
           $Employees = Employee::create($Request->all());
           $last_id = DB::getPDO()->lastInsertId();
           $Employees->save();
           return redirect('hrms/employee/');
       }

       function getdata() {

           $Employees = DB::table('batches')
                     ->where('batches.deleted_at', '=', '')
                     ->orWhereNull('batches.deleted_at')
                     ->select('batches.id', 'status_codes.name', 'batches.batch_name', 'batches.is_active')
                     ->join('status_codes', 'status_codes.code', '=', 'batches.is_active')
                     ->get();
           return Datatables::of($Employees)
                               ->addColumn('action', function($Employee) {
                                   return '<a href = "' . route('hrms.employee.edit', ['id' => $Employee->id]) . '" class = "invoice-action-edit edit" id = "' . $Employee->id . '"><i class="material-icons">edit</i></a><a href = "#" class = "invoice-action-view mr-4 delete" id = "' . $Employee->id . '"><i class="material-icons dp48 button delete-confirm">delete</i></a>';
                               })
                               ->addColumn('checkbox', '<label><input type = "checkbox" class = "batch_checkbox" value = "{{$id}}" /><span></span></label>')
                               ->rawColumns(['checkbox', 'action'])
                               ->make(true);
       }

       function removedata(Request $request) {
           $Employees = Employee::find($request->input('id'));
           if ($Employees->delete()) {
               echo 'Data Deleted';
           }
       }

       function massremove(Request $request) {
           $Employee_id_array = $request->input('id');
           $Employee = Employee::whereIn('id', $Employee_id_array);
           if ($Employee->delete()) {
               echo 'Data Deleted';
           }
       }

       public function edit($id) {
           $breadcrumbs = [
              ['link' => "hrms", 'name' => "Home"],
              ['link' => "hrms/employee/", 'name' => "Employee Master"],
              ['link' => "hrms/employee/create", 'name' => "Create"],
           ];
           //Pageheader set true for breadcrumbs
           $pageConfigs = ['pageHeader' => true, 'isFabButton' => true];

           $Employee = DB::table('batches')->get();

           if ($Employee = Employee::whereId($id)->first()) {

           }
           return view('hrms.employee.edit', ['Employee_Details' => $Employee, 'pageConfigs' => $pageConfigs, 'breadcrumbs' => $breadcrumbs]);

//        return view('hrms/employee/edit', ['Employee_Details' => $Employee]);
       }

       public function update(Request $Request, $id) {

           $this->validate($Request, [
              'batch_name' => 'required',
           ]);

           $Employee = Employee::findOrFail($id);
           $Employee->update($Request->all());
           $Employee->save();

           return redirect('hrms/employee/');
       }

   }

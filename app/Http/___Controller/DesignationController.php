<?php

namespace App\Http\Controllers;

use App\Designation;
use App\Employee;
use App\Module;
use App\Team;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class DesignationController extends Controller {

    //employee_id |  department_id
    public static function getDesginationbyEmployeeId($employee_id) {
        $table_data = DB::table('designations')
                ->select('designations.Name')
                ->where('designation_employee.employee_id', '=', $employee_id)
                ->join('designation_employee', 'designation_employee.designation_id', '=', 'designations.id')
                ->get();
        if (count($table_data) > 0) {
            
        } else {
            echo ' not found';
        }

        return $table_data;
    }

    public function designationStore(Request $request) {

        $validatedData = $request->validate([
            'Name' => 'unique:designations,Name,' . $request->id
        ]);

        $tdesignation_id = Designation::insertGetId([]);
        $tdesignation = Designation::find($tdesignation_id);

        $employees = Employee::find($request->employees);
        $tdesignation->employees()->attach($employees);

        /* two way commnucation by hitesh select_designation */
        $array = $request->employees;
        if (!empty($request->employees) > 0) {
            foreach ($array as $emp_id) {
                DB::table('employees')->where('id', $emp_id)->update(['select_designation' => $tdesignation_id]);
            }
        }


        $fields = Module::where('name', 'designations')->select('form')->get();

        foreach ($fields as $field) {
            foreach (json_decode($field->form) as $item) {
                if ($item->type !== 'section') {
                    $f = str_replace(' ', '_', $item->label);

                    if (is_array($request->$f) === true) {

                        $array_value = implode(',', $request->$f);
                        Designation::where('id', $tdesignation_id)->update([
                            $f => $array_value
                        ]);
                    } else {

                        if ($item->type === 'file') {
                            if ($request->hasFile($f)) {
                                $file_path = $this->uploadFile($request->$f);
                            } else {
                                $file_path = '';
                            }

                            Designation::where('id', $tdesignation_id)->update([
                                $f => $file_path
                            ]);
                        } else {

                            Designation::where('id', $tdesignation_id)->update([
                                $f => $request->$f
                            ]);
                        }
                    }
                }
            }
        }
        return redirect(route('modules.module', 'designations'))->with('message', 'Record Inserted!');
    }

    public function designationUpdate(Request $request) {

        $validatedData = $request->validate([
            'Name' => 'unique:designations,Name,' . $request->id
        ]);

//        dd($request);
        $designation = Designation::find($request->id);
        $employees = Employee::find($request->employees);
        $designation->employees()->sync($employees);

        $fields = Module::where('name', 'designations')->select('form')->get();

        /* update department for two way commncation developed by hitesh */
        $department_id = $request->id;
        $array = $request->employees;
        if (!empty($request->employees) > 0) {
            foreach ($array as $emp_id) {
                DB::table('employees')->where('id', $emp_id)->update(['select_designation' => $department_id]);
            }
        }


        foreach ($fields as $field) {
            foreach (json_decode($field->form) as $item) {
                if ($item->type !== 'section') {
                    $f = str_replace(' ', '_', $item->label);

                    if (is_array($request->$f) === true) {

                        $array_value = implode(',', $request->$f);
                        Designation::where('id', $request->id)->update([
                            $f => $array_value
                        ]);
                    } else {

                        if ($item->type === 'file') {
                            if ($request->hasFile($f)) {
                                $file_path = $this->uploadFile($request->$f);
                            } else {
                                $file_path = '';
                            }

                            Designation::where('id', $request->id)->update([
                                $f => $file_path
                            ]);
                        } else {

                            Designation::where('id', $request->id)->update([
                                $f => $request->$f
                            ]);
                        }
                    }
                }
            }
        }
        return redirect(route('modules.module', 'designations'))->with('message', 'Record Updated!');
    }

    public function uploadFile($file) {
        $fileName = time() . '_' . $file->getClientOriginalName();

        $file->move(public_path('uploads'), $fileName);
        $file_path = url('uploads', $fileName);
        return $file_path;
    }

}

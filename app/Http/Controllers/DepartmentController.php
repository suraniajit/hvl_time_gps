<?php

namespace App\Http\Controllers;

use App\Department;
use App\Employee;
use App\Module;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DepartmentController extends Controller {

    public function departmentStore(Request $request) {

        $validatedData = $request->validate([
            'Name' => 'unique:departments,Name,' . $request->id
        ]);

        $department_id = Department::insertGetId([]);
        $department = Department::find($department_id);

        $employees = Employee::find($request->employees);
        $department->employees()->attach($employees);


        /* two way commnucation by hitesh */
        $array = $request->employees;
        if (!empty($request->employees) > 0) {
            foreach ($array as $emp_id) {
                DB::table('employees')->where('id', $emp_id)->update(['Select_Department' => $department_id]);
            }
        }


        $fields = Module::where('name', 'departments')->select('form')->get();
//        echo $department_id;

        /* employee update departments || Select_Department  */
        // DB::table('employees')->where('id', $request->employees)->update(['Select_Department' => $department_id]);
//        dd($request->all());

        foreach ($fields as $field) {
            foreach (json_decode($field->form) as $item) {
                if ($item->type !== 'section') {
                    $f = str_replace(' ', '_', $item->label);

                    if (is_array($request->$f) === true) {

                        $array_value = implode(',', $request->$f);
                        Department::where('id', $department_id)->update([
                            $f => $array_value
                        ]);
                    } else {

                        if ($item->type === 'file') {
                            if ($request->hasFile($f)) {
                                $file_path = $this->uploadFile($request->$f);
                            } else {
                                $file_path = '';
                            }

                            Department::where('id', $department_id)->update([
                                $f => $file_path
                            ]);
                        } else {

                            Department::where('id', $department_id)->update([
                                $f => $request->$f
                            ]);
                        }
                    }
                }
            }
        }
        return redirect(route('modules.module', 'departments'))->with('message', 'Record Inserted!');
    }

    public function uploadFile($file) {
        $fileName = time() . '_' . $file->getClientOriginalName();

        $file->move(public_path('uploads'), $fileName);
        $file_path = url('uploads', $fileName);
        return $file_path;
    }

    public function departmentUpdate(Request $request) {

        $validatedData = $request->validate([
            'Name' => 'unique:departments,Name,' . $request->id
        ]);

        $department = Department::find($request->id);
        $employees = Employee::find($request->employees);
//        $department->employees()->sync($employees); //sync attach

        $department_id = $request->id;

        $fields = Module::where('name', 'departments')->select('form')->get();

        /* update department for two way commncation developed by hitesh */

        $array = $request->employees;
        if (!empty($request->employees) > 0) {
            foreach ($array as $emp_id) {
                DB::table('employees')->where('id', $emp_id)->update(['Select_Department' => $department_id]);
                /**/
                $GetShiftData = DB::table('department_employee')->where('employee_id', $emp_id)->get();
//                print_r($GetShiftData);
                if (count($GetShiftData) > 0) {
                    echo 'data Allready in database';

                    $del = DB::table('department_employee')->where('employee_id', $emp_id)->delete();

                    if ($del) {
                        echo '<br>' . 'data is delete';
                        DB::table('department_employee')->insert(['employee_id' => $emp_id, 'department_id' => $department_id]);
                    } else {
                        echo '<br>' . 'data is update';
                        DB::table('department_employee')->where('employee_id', $emp_id)->update(['department_id' => $department_id]);
//            DB::table('department_employee')->insert(['employee_id' => $emp_id, 'department_id' => $department_id]);
                    }
                } else {
                    echo 'data not in database';
                    DB::table('department_employee')->insert(['employee_id' => $emp_id, 'department_id' => $department_id]);
                }
                /**/
            }
        }



        foreach ($fields as $field) {
            foreach (json_decode($field->form) as $item) {
                if ($item->type !== 'section') {
                    $f = str_replace(' ', '_', $item->label);

                    if (is_array($request->$f) === true) {

                        $array_value = implode(',', $request->$f);
                        Department::where('id', $request->id)->update([
                            $f => $array_value
                        ]);
                    } else {

                        if ($item->type === 'file') {
                            if ($request->hasFile($f)) {
                                $file_path = $this->uploadFile($request->$f);
                            } else {
                                $file_path = '';
                            }

                            Department::where('id', $request->id)->update([
                                $f => $file_path
                            ]);
                        } else {

                            Department::where('id', $request->id)->update([
                                $f => $request->$f
                            ]);
                        }
                    }
                }
            }
        }
        return redirect(route('modules.module', 'departments'))->with('message', 'Record Updated!');
    }

}

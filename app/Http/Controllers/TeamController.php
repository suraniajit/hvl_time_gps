<?php

namespace App\Http\Controllers;

use App\Employee;
use App\Module;
use App\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class TeamController extends Controller {

    public function teamStore(Request $request) {

        $validatedData = $request->validate([
            'Name' => 'unique:teams,Name,' . $request->id
        ]);

        $team_id = Team::insertGetId([]);
        $team = Team::find($team_id);

        $employees = Employee::find($request->employees);
        $team->employees()->attach($employees);


        /* two way commnucation by hitesh Select_Team */
        $array = $request->employees;
        if (!empty($request->employees) > 0) {
            foreach ($array as $emp_id) {
                DB::table('employees')->where('id', $emp_id)->update(['Select_Team' => $department_id]);
            }
        }

        $fields = Module::where('name', 'teams')->select('form')->get();

        foreach ($fields as $field) {
            foreach (json_decode($field->form) as $item) {
                if ($item->type !== 'section') {
                    $f = str_replace(' ', '_', $item->label);

                    if (is_array($request->$f) === true) {

                        $array_value = implode(',', $request->$f);
                        Team::where('id', $team_id)->update([
                            $f => $array_value
                        ]);
                    } else {

                        if ($item->type === 'file') {
                            if ($request->hasFile($f)) {
                                $file_path = $this->uploadFile($request->$f);
                            } else {
                                $file_path = '';
                            }

                            Team::where('id', $team_id)->update([
                                $f => $file_path
                            ]);
                        } else {

                            Team::where('id', $team_id)->update([
                                $f => $request->$f
                            ]);
                        }
                    }
                }
            }
        }
        return redirect(route('modules.module', 'teams'))->with('message', 'Record Inserted!');
    }

    public function teamUpdate(Request $request) {

        $validatedData = $request->validate([
            'Name' => 'unique:teams,Name,' . $request->id
        ]);


        $team = Team::find($request->id);
        $employees = Employee::find($request->employees);
        $team->employees()->sync($employees);


        /* update department for two way commncation developed by hitesh */
        $department_id = $request->id;
        $array = $request->employees;
        if (!empty($request->employees) > 0) {
            foreach ($array as $emp_id) {
                DB::table('employees')->where('id', $emp_id)->update(['Select_Team' => $department_id]);
            }
        }
        /**/

        $fields = Module::where('name', 'teams')->select('form')->get();

        foreach ($fields as $field) {
            foreach (json_decode($field->form) as $item) {
                if ($item->type !== 'section') {
                    $f = str_replace(' ', '_', $item->label);

                    if (is_array($request->$f) === true) {

                        $array_value = implode(',', $request->$f);
                        Team::where('id', $request->id)->update([
                            $f => $array_value
                        ]);
                    } else {

                        if ($item->type === 'file') {
                            if ($request->hasFile($f)) {
                                $file_path = $this->uploadFile($request->$f);
                            } else {
                                $file_path = '';
                            }

                            Team::where('id', $request->id)->update([
                                $f => $file_path
                            ]);
                        } else {

                            Team::where('id', $request->id)->update([
                                $f => $request->$f
                            ]);
                        }
                    }
                }
            }
        }
        return redirect(route('modules.module', 'teams'))->with('message', 'Record Updated!');
    }

    public function uploadFile($file) {
        $fileName = time() . '_' . $file->getClientOriginalName();

        $file->move(public_path('uploads'), $fileName);
        $file_path = url('uploads', $fileName);
        return $file_path;
    }

}

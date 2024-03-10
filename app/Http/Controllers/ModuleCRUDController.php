<?php

namespace App\Http\Controllers;

use App\Employee;
use App\Module;
use App\SaveFilter;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ModuleCRUDController extends Controller {

    public function __construct(Request $request) {
        $name = str_replace('_', ' ', $request->name);
        $this->middleware('permission:Access ' . $name, ['only' => ['show', 'index']]);
        $this->middleware('permission:Create ' . $name, ['only' => ['create']]);
        $this->middleware('permission:Edit ' . $name, ['only' => ['edit']]);
    }

    public function index(Request $request) {

        $table = str_replace(' ', '_', $request->name);
        $module_name = str_replace('_', ' ', $request->name);

        $columns = $this->getTableColumnsNames($table);
        if($module_name != 'employees'){
            $columns = array_diff($columns, ["created_at", "updated_at"]);
        }
        
        $filter_columns = Module::where('name', $request->name)->select('form')->get();
        $save_filters = SaveFilter::where('module_name', $table)->get();

        if (request()->has('filter')) {
            $data = DB::table($table);
            $all = request()->all();
            foreach ($all as $one) {
                if ($one !== 'filter') {
                    $column_sw = substr($one, strpos($one, "_") + 1);
                    $column = str_replace(' ', '_', $column_sw);
                    if ($this->startsWith($one, 'contains_') === true) {
                        $data->where($column, 'LIKE', '%' . request()->$column . '%');
                    } elseif ($this->startsWith($one, 'is_') === true) {
                        $data->where($column, request()->$column);
                    } elseif ($this->startsWith($one, 'isNot_') === true) {
                        $data->where($column, '!=', request()->$column);
                    } elseif ($this->startsWith($one, 'notContains_') === true) {
                        $data->orWhere($column, 'NOT LIKE', '%' . request()->$column . '%');
                    } elseif ($this->startsWith($one, 'isEmpty_') === true) {
                        $data->whereNull($column);
                    } elseif ($this->startsWith($one, 'startWith_') === true) {
                        $data->where($column, 'LIKE', request()->$column . '%');
                    } elseif ($this->startsWith($one, 'endWith_') === true) {
                        $data->where($column, 'LIKE', '%' . request()->$column);
                    } elseif ($this->startsWith($one, 'isNotEmpty_') === true) {
                        $data->whereNotNull($column);
                    } elseif ($this->startsWith($one, 'inTheLast_') === true) {
                        foreach ($all as $time_one_last) {
                            if ($this->startsWith($time_one_last, 'days_') === true) {
                                $data->whereDate($column, '>=', Carbon::now()->subDays(request()->$column));
                            } elseif ($this->startsWith($time_one_last, 'weeks_') === true) {
                                $data->whereDate($column, '>=', Carbon::now()->subWeeks(request()->$column));
                            } elseif ($this->startsWith($time_one_last, 'months_') === true) {
                                $data->whereDate($column, '>=', Carbon::now()->subMonths(request()->$column));
                            }
                        }
                    } elseif ($this->startsWith($one, 'dueIn_') === true) {
                        foreach ($all as $time_one_due) {
                            if ($this->startsWith($time_one_due, 'days_') === true) {
                                $data->whereDate($column, '>', Carbon::now()->subDays(request()->$column));
                            } elseif ($this->startsWith($time_one_due, 'weeks_') === true) {
                                $data->whereDate($column, '>', Carbon::now()->subWeeks(request()->$column));
                            } elseif ($this->startsWith($time_one_due, 'months_') === true) {
                                $data->whereDate($column, '>', Carbon::now()->subMonths(request()->$column));
                            }
                        }
                    } elseif ($this->startsWith($one, 'on_') === true) {
                        $req_value = 'generalDate_' . $column;
                        $data->where($column, request()->$req_value);
                    } elseif ($this->startsWith($one, 'before_') === true) {
                        $req_value = 'generalDate_' . $column;
                        $data->where($column, '<', request()->$req_value);
                    } elseif ($this->startsWith($one, 'after_') === true) {
                        $req_value = 'generalDate_' . $column;
                        $data->where($column, '>', request()->$req_value);
                    } elseif ($this->startsWith($one, 'between_') === true) {
                        $from_date = 'betweenStart_' . $column;
                        $to_date = 'betweenEnd_' . $column;
                        $from = request()->$from_date;
                        $to = request()->$to_date;
                        $data->whereBetween($column, [$from, $to]);
                    } elseif ($this->startsWith($one, 'today_') === true) {
                        $data->whereDate($column, '=', Carbon::today());
                    } elseif ($this->startsWith($one, 'yesterday_') === true) {
                        $data->whereDate($column, '=', Carbon::now()->addDay(-1));
                    } elseif ($this->startsWith($one, 'thisWeek_') === true) {
                        $data->where($column, [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
                    } elseif ($this->startsWith($one, 'thisMonth_') === true) {
                        $data->whereMonth($column, Carbon::now()->month)
                                ->whereYear($column, Carbon::now()->year);
                    } elseif ($this->startsWith($one, 'thisYear_') === true) {
                        $data->whereYear($column, Carbon::now()->year);
                    } elseif ($this->startsWith($one, 'lastWeek_') === true) {
                        $start = Carbon::now()->subWeek()->startOfWeek();
                        $end = Carbon::now()->subWeek()->endOfWeek();
                        $data->whereBetween($column, [$start, $end]);
                    } elseif ($this->startsWith($one, 'lastMonth_') === true) {
                        $start = Carbon::now()->subMonth()->startOfMonth();
                        $end = Carbon::now()->subMonth()->endOfMonth();
                        $data->whereBetween($column, [$start, $end]);
                    } elseif ($this->startsWith($one, 'dateIsEmpty_') === true) {
                        $data->whereNull($column);
                    } elseif ($this->startsWith($one, 'dateIsNotEmpty_') === true) {
                        $data->whereNotNull($column);
                    } elseif ($this->startsWith($one, 'numberEqual_') === true) {
                        $number_value = 'generalNumberValue_' . $column;
                        $data->where($column, '=', request()->$number_value);
                    } elseif ($this->startsWith($one, 'numberNotEqual_') === true) {
                        $number_value = 'generalNumberValue_' . $column;
                        $data->where($column, '!=', request()->$number_value);
                    } elseif ($this->startsWith($one, 'numberLess_') === true) {
                        $number_value = 'generalNumberValue_' . $column;
                        $data->where($column, '<', request()->$number_value);
                    } elseif ($this->startsWith($one, 'numberLessEqual_') === true) {
                        $number_value = 'generalNumberValue_' . $column;
                        $data->where($column, '<=', request()->$number_value);
                    } elseif ($this->startsWith($one, 'numberGrater_') === true) {
                        $number_value = 'generalNumberValue_' . $column;
                        $data->where($column, '>', request()->$number_value);
                    } elseif ($this->startsWith($one, 'numberGraterEqual_') === true) {
                        $number_value = 'generalNumberValue_' . $column;
                        $data->where($column, '>=', request()->$number_value);
                    } elseif ($this->startsWith($one, 'numberBetween_') === true) {
                        $start = 'numberBetweenStart_' . $column;
                        $end = 'numberBetweenEnd_' . $column;
                        $data->whereBetween($column, [request()->$start, request()->$end]);
                    } elseif ($this->startsWith($one, 'numberNotBetween_') === true) {
                        $start = 'numberBetweenStart_' . $column;
                        $end = 'numberBetweenEnd_' . $column;
                        $data->whereNotBetween($column, [request()->$start, request()->$end]);
                    } elseif ($this->startsWith($one, 'numberEmpty_') === true) {
                        $data->whereNull($column);
                    } elseif ($this->startsWith($one, 'numberNotEmpty_') === true) {
                        $data->whereNotNull($column);
                    }
                }
            }
            $rows = $data->get();
        } else {
            $rows = DB::table($table)->get();
        }

        $tname = ucfirst(str_replace('_', '%20', $module_name));
//        $tname = substr($tname, 0, -1);
        $breadcrumbs = [
            ['link' => "module", 'name' => "Home"],
            ['link' => "/modules/module/" . str_replace('_', '%20', $module_name), 'name' => $tname],
//            ['link' => "/modules/module/" . $table . "/create", 'name' => "Create"],
        ];
        //Pageheader set true for breadcrumbs
        $pageConfigs = ['pageHeader' => true, 'isFabButton' => true, 'isCustomizer' => true];

        $rightlink = [
            ['rightlink' => "/modules/module/" . $table . "/create", 'name' => "Create"],
        ];
//        $downloadlink = [
//            ['downloadlink' => "/modules/module/" . $table . "/create", 'name' => "Create"]
//        ];
//
//
//
        $deletelink = [
            ['deletelink' => "/modules/module/" . $table . "/create", 'name' => "Create"],
        ];
          
//Department:: team degination hide
        if ($table !== 'employees' && $table !== 'departments' && $table !== 'teams' && $table !== 'designations') {
            return view('module.index', [
                'pageConfigs' => $pageConfigs,
                'breadcrumbs' => $breadcrumbs,
                'rightlink' => $rightlink,
//                'downloadlink' => $downloadlink,
                'deletelink' => $deletelink,
                'columns' => $columns,
                'table' => $table,
                'rows' => $rows,
                'filter_columns' => $filter_columns,
                'save_filters' => $save_filters,
                'module_name'=>$module_name
            ]);
        } else {

            return view('module.index', [
                'pageConfigs' => $pageConfigs,
                'breadcrumbs' => $breadcrumbs,
                'rightlink' => $rightlink,
                'deletelink' => $deletelink,
                'columns' => $columns,
                'table' => $table,
                'rows' => $rows,
                'filter_columns' => $filter_columns,
                'save_filters' => $save_filters,
                'module_name'=>$module_name
            ]);
        }
    }

    public function getTableColumnsNames($table_name) {
        return \Schema::getColumnListing($table_name);
    }

    public function create(Request $request) {
        $module_name = str_replace('_', ' ', $request->name);
        $module_form = Module::where('name', $module_name)->get();

        $breadcrumbs = [
            ['link' => "module", 'name' => "Home"],
            ['link' => "modules/module/" . $module_name, 'name' => ucfirst($module_name)],
            ['name' => "Create"],
        ];
        //Pageheader set true for breadcrumbs
        $pageConfigs = ['pageHeader' => true, 'isFabButton' => true, 'isCustomizer' => true];

        return view('module.create', [
            'pageConfigs' => $pageConfigs,
            'breadcrumbs' => $breadcrumbs,
            'module_name' => $module_name,
            'module_form' => $module_form
        ]);

//        return view('module.create', compact('module_name', 'module_form'));
    }

    public function store(Request $request) {
        $table_id = DB::table($request->table_name)->insertGetId([]);
        $module_name = str_replace('_', ' ', $request->table_name);
        $fields = Module::where('name', $module_name)->select('form')->get();

        foreach ($fields as $field) {
            foreach (json_decode($field->form) as $item) {
                if ($item->type !== 'section') {

                    $f = str_replace(' ', '_', $item->label);
                    if (is_array($request->$f) === true) {
                        $array_value = implode(',', $request->$f);
                        DB::table($request->table_name)->where('id', $table_id)->update([
                            $f => $array_value
                        ]);
                    } else {

                        if ($item->type === 'file') {
                            if ($request->hasFile($f)) {
                                $file_path = $this->uploadFile($request->$f);
                            } else {
                                $file_path = '';
                            }

                            DB::table($request->table_name)->where('id', $table_id)->update([
                                $f => $file_path
                            ]);
                        } else {

                            DB::table($request->table_name)->where('id', $table_id)->update([
                                $f => $request->$f
                            ]);
                        }
                    }
                }
            }
        }
//str_replace('_', '%20', $module_name)
//        return redirect(route('modules.module', str_replace(' ', '_', $request->table_name)))->with('success', 'Record Inserted!');
        return redirect(route('modules.module', str_replace('_', '%20', $request->table_name)))->with('success', 'Record Inserted!');
    }

    public function show(Request $request) {
        $table_data = DB::table($request->name)->where('id', $request->id)->first();
        $table_name = str_replace('_', ' ', $request->name);
        $module_name = str_replace('_', ' ', $request->name);
        $fields = Module::where('name', $module_name)->select('form')->get();
        



        $breadcrumbs = [
            ['link' => "module", 'name' => "Home"],
            ['link' => "/modules/module/" . $table_name . "", 'name' => ucfirst($table_name)],
            ['name' => "View"],
        ];
        //Pageheader set true for breadcrumbs
        $pageConfigs = ['pageHeader' => true, 'isFabButton' => true, 'isCustomizer' => true];

        return view('module.show', [
            'pageConfigs' => $pageConfigs,
            'breadcrumbs' => $breadcrumbs,
            'table_data' => $table_data,
            'fields' => $fields,
            'table_name' => $table_name
        ]);
    }

    public function edit(Request $request) {
        $table_data = DB::table($request->name)->where('id', $request->id)->first();
        $table_name = $request->name;

        $module_name = str_replace('_', ' ', $request->name);
        $module_form = Module::where('name', $module_name)->get();



        $breadcrumbs = [
            ['link' => "module", 'name' => "Home"],
            ['link' => "/modules/module/" . $table_name . "", 'name' => ucfirst($table_name)],
            ['name' => "Edit"],
        ];
        //Pageheader set true for breadcrumbs
        $pageConfigs = ['pageHeader' => true, 'isFabButton' => true, 'isCustomizer' => true];

        return view('module.edit', [
            'pageConfigs' => $pageConfigs,
            'breadcrumbs' => $breadcrumbs,
            'table_data' => $table_data,
            'table_name' => $table_name,
            'module_form' => $module_form
        ]);
    }

    public function destroy(Request $request) {
        

        if ($request->name === 'employees') {
            $data = DB::table('hvl_customer_employees')->where('employee_id',$request->id)->get();
            if (count($data) > 0)
            {
                echo 'in if';
                return response('error');
            }
            else {
                
              echo 'else';  
                
                $user_id=DB::table('employees')->where('id',$request->id)->value('user_id');
                DB::table('api_expenses')->where('is_user', $user_id)->delete();
                
               //DB::table('api_expenses_documents')->where('emp_id', $user_id)->delete();
               //DB::table('api_expenses_action_log')->where('emp_id', $user_id)->delete();
                
                
                $employee = Employee::find($request->id);
                $employee->user()->delete();
                $table = DB::table($request->name)->where('id', $request->id)->delete();
                
            }
        }
        elseif ($request->name === 'Zones') {
            $data = DB::table('Branch')->where('zone',$request->id)->get();
            if (count($data) > 0)
            {
                return response('zone_error');
            }
            else {
                $zone = DB::table('Zones')->where('id',$request->id);
                $zone->delete();
            }
        }
        else{
            //$table = DB::table($request->name)->where('id', $request->id)->delete();

            return response()->json(['message' => 'Given record has been removed!'], 200);
        }
    }

    public function uploadFile($file) {
        $fileName = time() . '_' . $file->getClientOriginalName();

        $file->move(public_path('uploads'), $fileName);
        $file_path = url('uploads', $fileName);
        return $file_path;
    }

    public function massDestroy(Request $request) {
        if ($request->table === 'employees') {
            foreach ($request->ids as $id) {
                $employee = Employee::find($id);
                $employee->user()->delete();
            }
        }

        DB::table($request->table)->whereIn('id', $request->ids)->delete();

        return response()->json(['message' => 'Given records has been removed!'], 200);
    }

    public function update(Request $request) {
//        dd($request);
        $module_name = str_replace('_', ' ', $request->table_name);
        $fields = Module::where('name', $module_name)->select('form')->get();

        foreach ($fields as $field) {
            foreach (json_decode($field->form) as $item) {
                if ($item->type !== 'section') {

                    $f = str_replace(' ', '_', $item->label);
                    if (is_array($request->$f) === true) {
                        $array_value = implode(',', $request->$f);
                        DB::table($request->table_name)->where('id', $request->id)->update([
                            $f => $array_value
                        ]);
                    } else {

                        if ($item->type === 'file') {
                            if ($request->hasFile($f)) {
                                $file_path = $this->uploadFile($request->$f);
                            } else {
                                $file_path = '';
                            }
                            DB::table($request->table_name)->where('id', $request->id)->update([
                                $f => $file_path
                            ]);
                        } else {

                            DB::table($request->table_name)->where('id', $request->id)->update([
                                $f => $request->$f
                            ]);
                        }
                    }
                }
            }
        }

//        str_replace('_', '%20', $module_name)
//        return redirect(route('modules.module', $request->table_name))->with('success', 'Record updated!');
        return redirect(route('modules.module', str_replace('_', '%20', $request->table_name)))->with('success', 'Record updated!');
    }

    public function startsWith($haystack, $needle) {
        $length = strlen($needle);
        return (substr($haystack, 0, $length) === $needle);
    }

}

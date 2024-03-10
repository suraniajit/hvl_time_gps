<?php

namespace App\Http\Controllers;

use auth;
use App\Module;
use App\Permission;
use App\Role;
use App\ComponentResult;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Str;
use FusionExport\ExportManager;
use FusionExport\ExportConfig;

class FusionChart extends Controller {

    public function getColume(Request $request = null) {
//        $table = str_replace(' ', '_', $request->name);
        $table = 'department_employee';
        $columns = $this->getTableColumnsNames($table);
        $columns = array_diff($columns, ["created_at", "updated_at"]);
        print_r($columns);
    }

    public function home() {

        $modules = Module::orderBy('id', 'asc')->get();
        $ComponentResults = ComponentResult::where('is_active', '=', '0')
                        ->orderBy('id', 'desc')->get();

        $breadcrumbs = [
            ['link' => "crm", 'name' => "Home"],
            ['link' => "fusioncharts/", 'name' => "Create Dashboard"],
        ];
        $pageConfigs = ['pageHeader' => true, 'isFabButton' => true, 'isCustomizer' => true];


        return view('fusioncharts.index', [
            'pageConfigs' => $pageConfigs,
            'breadcrumbs' => $breadcrumbs,
            'modules' => $modules,
            'ComponentResults' => $ComponentResults
        ]);


        // return view('fusioncharts/index', compact('modules', 'ComponentResults'));
    }

    public static function getTableColumnsNames($primary_module_name) {
        return \Schema::getColumnListing($primary_module_name);
    }

    public function getchartdestroy(Request $request) {
        $ComponentResult = ComponentResult::whereId($request->input('id'))->first();
//        if ($ComponentResult->delete()) {
        $ComponentResult->update([
            'is_active' => '1'
        ]);
//        }
        return back();
    }

    public function edit($id) {
        $modules = Module::orderBy('id', 'asc')->get();
        if ($ComponentResultMaster = ComponentResult::whereId($id)->first()) {
            return view('fusioncharts.edit', [
                'modules' => $modules,
                'component_result' => $ComponentResultMaster,
            ]);
        }
    }

    public function update(Request $request, $id) {


        $data_points = array();
        $labelValueArray = array();

        $component_name = $request->component_name;
        $chart_type = $request->chart_type;
        $chart_design = $request->chart_design;
        $path_modules = $request->select_module;

        $ComponentResult = ComponentResult::findOrFail($id);


        if (($chart_design == 'line') || ($chart_design == 'funnel')) {
            $chart_design = '';
            $chart_type = '';
        } else {
            $chart_design = $chart_design;
        }



        $ComponentResult->update([
            'component_name' => $component_name,
            'chart_type' => $chart_type,
            'chart_design' => $chart_design,
            'path' => $path_modules,
            'is_active' => $request->is_active,
        ]);
        $ComponentResult->save();

        return redirect(route(strtolower($path_modules)))->with('success', 'Record Updated Successfully!');
    }

    public function getTableSecondaryColumns(Request $request) {
        $measure = array();
        $secondary_module_name = $request->secondary_module_name;
        $measure[] = 'Count of' . ' ' . $secondary_module_name;
        $measure[] = 'Sum of' . ' ' . $secondary_module_name;
        $measure[] = 'minimum of' . ' ' . $secondary_module_name;
        $measure[] = 'Avrage of' . ' ' . $secondary_module_name;

        return response()->json($measure);
    }

    public function getTableColumns(Request $request) {
        $columns = array();
        $measure = array();
        $grouping = array();
        $relatetable = array();

        $module_name_look = $module_name_multilook = 'not related any table';
//        $module_name_multilook = 'not related';


        $primary_module_name = $request->primary_module_name;
        $secondary_module_name = $request->secondary_module_name;

//        $measure[] = 'Count of' . '- ' . $primary_module_name . ' ' . DB::table($primary_module_name)->count();
//        $measure[] = 'Sum of' . '- ' . DB::table($primary_module_name)->count();
//        $measure[] = 'minimum of' . '- ' . DB::table($primary_module_name)->count();

        $measure[] = 'Count of' . '- ' . $primary_module_name;
        $measure[] = 'Sum of' . '- ' . $primary_module_name;
        $measure[] = 'minimum of' . '- ' . $primary_module_name;
        $measure[] = 'Maximum of' . '- ' . $primary_module_name;

        if ($secondary_module_name) {
//            $measure[] = 'Count of' . ' ' . DB::table($secondary_module_name)->count();
//            $measure[] = 'Sum of' . ' ' . DB::table($secondary_module_name)->count();
//            $measure[] = 'minimum of' . ' ' . DB::table($secondary_module_name)->count();

            $measure[] = 'Count of' . ' ' . $secondary_module_name;
            $measure[] = 'Sum of' . ' ' . $secondary_module_name;
            $measure[] = 'minimum of' . ' ' . $secondary_module_name;
            $measure[] = 'Maximum of' . ' ' . $secondary_module_name;
        }
        if ($primary_module_name) {
            $count = DB::table($primary_module_name)->count();

            $fields = Module::where('name', $primary_module_name)->select('form')->get();
            foreach ($fields as $field) {
                foreach (json_decode($field->form) as $item) {

                    if ($item->type === 'lookup') {
                        $relatetable[] = str_replace(' ', '_', $item->module);
                    }
                    if ($item->type === 'multiLookup') {
                        $relatetable[] = str_replace(' ', '_', $item->module);
                    }
                }
            }
            $grouping_primary = $this->getTableColumnsNames($primary_module_name);
            $grouping = array_diff($grouping_primary, ["id", "created_at", "updated_at"]);

            return response()->json(array(
                        "relatetable" => $relatetable,
                        "measure" => $measure,
                        "grouping" => $grouping
            ));
        }
    }

    public function getChartfilterByPrimaryTable(Request $request) {
        $data_points = array();
        $labelValueArray = array();
        $chartConfigObj = array();
        $get_module_data = array();
        $chart_design = null;


        $select_chart = '';
        $lable = 'name';

        $component_id = $request->component_id;
        $primary_module_id = $request->primary_module_id;
        $select_filter_primary = $request->select_filter_primary;
        $module_grouping = $request->module_grouping;
        $ComponentResult_DataJson = ComponentResult::findOrFail($component_id);

        $select_chart = $ComponentResult_DataJson->chart_type;
        $component_name = $ComponentResult_DataJson->component_name;
        $secondary_module_filter_save = $ComponentResult_DataJson->secondary_module_filter_save;

//        if (count($select_filter_primary) > 0) {
//            $chartDataOrignal = $ComponentResult_DataJson->chartData;
//        }
//        $secondary_module_filter_save = $ComponentResult_DataJson->module_grouping;
//        echo count($select_filter_primary);
//        dd($request->all());
        DB::enableQueryLog();
        if ($primary_module_id == 'employees') {
            echo 'if' . '<br>';
            foreach ($select_filter_primary as $filters) {
//                echo $filters;

                $get_module_data = DB::table($primary_module_id)
                        ->select('*')
                        ->join('users', 'users.id', '=', "$primary_module_id.user_id")
                        ->where($primary_module_id . '.' . $module_grouping, '=', $filters)
                        ->get();


                foreach ($get_module_data as $key => $row) {
                    $point = array('label' => $row->$lable, "value" => $this->getNameFromTables($primary_module_id, $module_grouping, $row->$module_grouping)->count());
                    array_push($labelValueArray, $point);
                }
            }
        } else {
            echo 'else' . '<br>';
            DB::enableQueryLog();
            $get_module_data = DB::table($primary_module_id)
//                    ->select('*', $module_grouping)
                    ->select('*')
//                    ->groupBy($module_grouping)
                    ->where($module_grouping, '=', $select_filter_primary)
                    ->get();
//            dd(DB::getQueryLog());
            foreach ($get_module_data as $key => $row) {
                $point = array('label' => $row->Name, "value" => $this->getNameFromTables($primary_module_id, $module_grouping, $row->$module_grouping)->count());
                array_push($labelValueArray, $point);
            }
        }
//        dd(DB::getQueryLog());

        $trendlines = array();

        if ($select_chart == 'pie') {
            $chartConfigObj = array("chart" =>
                array(
                    "caption" => $component_name,
                    "subCaption" => 'For ' . $primary_module_id . ' - ' . $module_grouping . ' by ' . $secondary_module_filter_save,
                    "plottooltext" => $primary_module_id,
                    "showlegend" => '1',
                    "showpercentvalues" => "1",
                    "legendposition" => "bottom",
                    "usedataplotcolorforlabels" => "1",
                    "theme" => "fusion"
                )
            );
        }
        if ($select_chart == 'bar') {

            $chartConfigObj = array("chart" =>
                array(
                    "caption" => $component_name,
                    "subCaption" => 'For ' . $primary_module_id . ' - ' . $module_grouping . ' by ' . $secondary_module_filter_save,
                    "showValues" => $primary_module_id,
                    "showPercentInTooltip" => '0',
                    "numberPrefix" => "No",
                    "enableMultiSlicing" => "No",
                    "theme" => "fusion"
                )
            );
        }

        if ($select_chart == 'line') {
            $chartConfigObj = array("chart" =>
                array(
                    "caption" => $component_name,
                    "subCaption" => 'For ' . $primary_module_id . ' - ' . $module_grouping . ' by ' . $secondary_module_filter_save,
                    "xAxisName" => $primary_module_id,
                    "yaxisname" => 'Record Count',
                    "lineThickness" => "5",
                    "theme" => "fusion"
                )
            );

            $trendlines = array("line" =>
                array(
                    "startvalue" => "18500",
                    "color" => "#1aaf5d",
                    "displayvalue" => "Average{br}weekly{br}footfall",
                    "valueOnRight" => "1",
                    "thickness" => "2"
            ));
        }
        if ($select_chart == 'funnel') {
            $chartConfigObj = array("chart" =>
                array(
                    "caption" => $component_name,
                    "subCaption" => 'For ' . $primary_module_id . ' - ' . $module_grouping . ' by ' . $secondary_module_filter_save,
                    "decimals" => "1",
                    "isHollow" => "1",
                    "labelDistance" => "15",
                    "is2D" => "1",
                    "plotTooltext" => "Success" . $percentOfPrevValue,
                    "showPercentValues" => "1",
                    "theme" => "fusion"
                )
            );
        }

        if ($select_chart == 'doughnut') {
            echo 'doughnut';
            $chartConfigObj = array("chart" =>
                array(
                    "caption" => $component_name,
                    "subCaption" => 'For ' . $primary_module_id . ' - ' . $module_grouping . ' by ' . $secondary_module_filter_save,
                    "enablesmartlabels" => "1",
                    "showlabels" => "1",
                    "enableMultiSlicing" => "1",
                    "usedataplotcolorforlabels" => "1",
                    "theme" => "fusion"
                )
            );
        }
        if ($select_chart == 'column') {
            echo 'column';
            $chartConfigObj = array("chart" =>
                array(
                    "caption" => $component_name,
                    "subcaption" => $primary_module_id . ' by ' . $secondary_module_filter_save . ' of ' . $module_grouping,
                    "enablesmartlabels" => "1",
                    "xaxisname" => $module_grouping,
                    "yaxisname" => 'Record Count',
                    "showlabels" => "1",
                    "usedataplotcolorforlabels" => "1",
                    "theme" => "fusion"
            ));
        }


        if (($select_chart == 'line') || ($select_chart == 'funnel')) {
            $chart_design = '';
        } else {
            $chart_design = '2d';
        }

        $chartConfigObj["data"] = $labelValueArray;
        if ($trendlines) {
            $chartConfigObj["trendlines"] = $trendlines;
        }
        echo json_encode($chartConfigObj);
//        dd(DB::getQueryLog());


        /* update chart data into json formate */

        $ComponentResult_DataJson->update([
            'chartData' => json_encode($chartConfigObj),
            'chart_type' => $select_chart,
            'chart_design' => $chart_design,
//            'secondary_module_filter_save' => json_encode($request->select_filter_primary)
            'secondary_module_filter_save' => implode(",", $request->select_filter_primary),
        ]);

//        $component_results = ComponentResult::where($select_filter_primary, '=', $module_grouping)->get();
//        $component_results->update([
//            'is_filter' => '**/*/1',
//            'chart_type' => '9858587',
//        ]);
        dd($request->all());
    }

    public function getChartfilter(Request $request) {
        $chart_design = null;
        $component_id = $request->component_id;
        $select_chart = $request->select_chart;
        $ComponentResult = ComponentResult::findOrFail($component_id);
        $chart_design = $ComponentResult->chart_design;

        if (($select_chart == 'line') || ($select_chart == 'funnel')) {
            $chart_design = '';
        } else {
            $chart_design = '2d';
        }

        $ComponentResult->update([
            'chart_type' => $select_chart,
            'chart_design' => $chart_design,
        ]);
        dd($request->all());
    }

    public static function getfirstLevelFilter($primary_module_id, $module_grouping) {
        return DB::table($primary_module_id)
                        ->select('*')
                        ->groupBy($primary_module_id . '.' . $module_grouping)
                        ->get();
    }

    public function getNameFromTables($table = null, $selector = null, $variable = null) {
//        $table = 'employees';
//        $selector = 'Department';
//        $variable = 'IT Department';
//        DB::enableQueryLog();
        return DB::table($table)
                        ->select($selector)
                        ->where($selector, '=', $variable)
                        ->get();
    }

    public function store(Request $request) {
        //dd($request->all());
        $data_points = array();
        $labelValueArray = array();
        $chart_type = $request->chart_type;
        $chart_design = $request->chart_design;

        $select_module = $request->select_module;
        $component_name = $request->component_name;
//        $component_name = $request->component_name . '-' . $chart_type . '-' . $chart_design;
        $primary_module_id = $request->primary_module_id;
        $module_measure = $request->module_measure;
        $module_grouping = $request->module_grouping;
        $path_modules = $request->select_module;


        $is_filter = '0';
        $secondary_module_id = $request->secondary_module_id;
        if ($secondary_module_id) {
            $secondary_module_id = $secondary_module_id;
            $is_filter = '1';
        } else {
            $secondary_module_id = null;
            $is_filter = '0';
        }

        /**/
        $trendlines = array();
        if ($chart_type == 'line') {
            $chart_design = '';
            $chartConfigObj = array("chart" =>
                array(
                    "caption" => $component_name,
                    "subCaption" => 'For ' . $primary_module_id . ' - ' . $module_grouping . ' by ' . $secondary_module_id,
                    "xAxisName" => $module_grouping,
                    "yaxisname" => 'Record Count',
                    "lineThickness" => "15",
                    "theme" => "fusion"
                )
            );

            $trendlines = array("line" =>
                array(
                    "startvalue" => "18500",
                    "color" => "#1aaf5d",
                    "displayvalue" => "Average{br}weekly{br}footfall",
                    "valueOnRight" => "1",
                    "thickness" => "2"
            ));
//            $chartConfigObj["trendlines"] = $trendlines;
        }
        if ($chart_type == 'funnel') {
            $chart_design = '';
            $chartConfigObj = array("chart" =>
                array(
                    "caption" => $component_name,
                    "subCaption" => 'For ' . $primary_module_id . ' - ' . $module_grouping . ' by ' . $secondary_module_id,
                    "decimals" => "1",
                    "isHollow" => "1",
                    "labelDistance" => "15",
                    "is2D" => "1",
                    "plotTooltext" => "Success",
                    "showPercentValues" => "1",
                    "theme" => "fusion"
                )
            );
        }


        /**/
        ComponentResult::create([
            'component_name' => $component_name,
            'primary_module_id' => $primary_module_id,
            'is_filter' => $is_filter,
            'secondary_module_id' => $secondary_module_id,
            'module_measure' => $module_measure,
            'module_grouping' => $module_grouping,
            'chart_type' => $chart_type,
            'chart_design' => $chart_design,
        ]);

        $ComponentResult_Lastid = DB::getPdo()->lastInsertId();

        $primary_module_data = DB::table($primary_module_id)->get();

        if (empty($secondary_module_id)) {
//            echo '2 is not';
//            echo count($primary_module_data);

            foreach ($primary_module_data as $key => $row) {
//                $point = array('label' => $row->$module_grouping, "value" => $row->id);
                $point = array('label' => $row->$module_grouping, "value" => count($primary_module_data));
                array_push($labelValueArray, $point);
            }
            $chartConfigObj = array("chart" =>
                array(
                    "caption" => $component_name,
                    "subcaption" => $primary_module_id . ' by ' . $module_grouping,
                    "enablesmartlabels" => "1",
                    "xaxisname" => $primary_module_id . ' ' . $module_grouping,
                    "yaxisname" => 'Record Count',
                    "showlabels" => "1",
                    "usedataplotcolorforlabels" => "1",
                    "theme" => "fusion"
                )
            );
        } else {

//            echo '1 is have';
//            echo '<br>' . 
            $primary_remove_last_string_ = ucfirst(substr($primary_module_id, 0, -1));
//            echo '<br>' . 
            $secondary_remove_last_string_ = ucfirst(substr($secondary_module_id, 0, -1));
//            echo '<br>' . 
            $module_grouping;
            $secondary_module_data = DB::table($primary_module_id)->get();

//            echo '<pre>';
//            print_r($secondary_module_data);
//            echo '</pre>';
//            echo '<br>';
//            DB::enableQueryLog();
            //dd(DB::getQueryLog());
//            echo '***'.$this->getNameFromTables($primary_module_id, $module_grouping, $module_grouping)->count();
            if ($primary_module_id === 'employees') {
                $get_module_data = DB::table($primary_module_id)
//                    ->select($secondary_remove_last_string_)
                        ->select('*', $primary_module_id . '.' . $module_grouping)
                        ->join('users', 'users.id', '=', "$primary_module_id.user_id")
                        ->groupBy($primary_module_id . '.' . $module_grouping)
//                        ->where($primary_module_id=)
                        ->get();
            } else {
                $get_module_data = DB::table($primary_module_id)
                        ->select('*', $module_grouping)
                        ->groupBy($secondary_remove_last_string_)
                        ->get();
            }

//            echo '<pre>';
//            print_r($get_module_data);
//            echo '</pre>';
//            echo $get_module_data[0]->$secondary_remove_last_string_;
//            die();
//            echo $get_module_data->count();
            //dd(DB::getQueryLog());
//            die();
//            echo '<br>';
//                echo $get_module_data[0]->$secondary_remove_last_string_;
//                echo '<br>';
            foreach ($get_module_data as $key => $row) {
//                echo '<pre>';
//                print_r($row);
//                echo '</pre>';
//                $point = array('label' => $row->$module_grouping, "value" => $row->name);
                $point = array('label' => $row->$module_grouping, "value" => $this->getNameFromTables($primary_module_id, $module_grouping, $row->$module_grouping)->count());
                array_push($labelValueArray, $point);
            }

            $chartConfigObj = array("chart" =>
                array(
                    "caption" => $component_name,
                    "subcaption" => $primary_module_id . ' by ' . $module_grouping,
                    "enablesmartlabels" => "1",
                    "xaxisname" => $module_grouping,
                    "yaxisname" => 'Record Count',
                    "showlabels" => "1",
                    "usedataplotcolorforlabels" => "1",
                    "theme" => "fusion"
                )
            );
        }

        if ($chart_type == 'pie') {
            $chartConfigObj = array("chart" =>
                array(
                    "caption" => $component_name,
                    "subCaption" => 'For ' . $primary_module_id . ' - ' . $module_grouping,
                    "plottooltext" => $primary_module_id,
                    "showlegend" => '1',
                    "showpercentvalues" => "1",
                    "legendposition" => "bottom",
                    "usedataplotcolorforlabels" => "1",
                    "theme" => "fusion"
                )
            );
        }
        if ($chart_type == 'bar') {

            $chartConfigObj = array("chart" =>
                array(
                    "caption" => $component_name,
                    "subCaption" => 'For ' . $primary_module_id . ' - ' . $module_grouping,
                    "showValues" => $primary_module_id,
                    "showPercentInTooltip" => '0',
                    "numberPrefix" => "No",
                    "enableMultiSlicing" => "No",
                    "theme" => "fusion"
                )
            );
        }


        if ($chart_type == 'doughnut') {
            echo 'doughnut';
            $chartConfigObj = array("chart" =>
                array(
                    "caption" => $component_name,
                    "subCaption" => 'For ' . $primary_module_id . ' - ' . $module_grouping,
                    "enablesmartlabels" => "1",
                    "showlabels" => "1",
                    "enableMultiSlicing" => "1",
                    "usedataplotcolorforlabels" => "1",
                    "theme" => "fusion"
                )
            );
        }
        if ($chart_type == 'column') {
            echo 'column';
            $chartConfigObj = array("chart" =>
                array(
                    "caption" => $component_name,
                    "subcaption" => $primary_module_id . ' by ' . $module_grouping,
                    "enablesmartlabels" => "1",
                    "xaxisname" => $module_grouping,
                    "yaxisname" => 'Record Count',
                    "showlabels" => "1",
                    "usedataplotcolorforlabels" => "1",
                    "theme" => "fusion"
            ));
        }



        $chartConfigObj["data"] = $labelValueArray;
        if ($trendlines) {
            $chartConfigObj["trendlines"] = $trendlines;
        }

//        echo json_encode($chartConfigObj);

        /* update chart data into json formate */
        $ComponentResult_DataJson = ComponentResult::findOrFail($ComponentResult_Lastid);
        $ComponentResult_DataJson->update([
            'path' => $path_modules,
            'chartData' => json_encode($chartConfigObj),
        ]);
//        echo $path_modules;
//        dd($request->all());

        return redirect(route(strtolower($path_modules)))->with('success', 'Record Inserted!');
    }

}

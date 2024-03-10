<?php

namespace App\Http\Controllers\hrms;

use App\Role;
use App\User;
use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\softDeletes;
use Illuminate\Support\Facades\View;
use Illuminate\Validation\Rule;
use App\Models\hrms\City;
use Validator;

class CityController extends Controller {

    public function __construct() {
        $this->middleware('permission:Access City', ['only' => ['show', 'index']]);
        $this->middleware('permission:Create City', ['only' => ['create']]);
        $this->middleware('permission:Read City', ['only' => ['read']]);
        $this->middleware('permission:Edit City', ['only' => ['edit']]);
        $this->middleware('permission:Delete City', ['only' => ['delete']]);
    }

    public function index() {

        $CityDetails = DB::table('common_cities')
                ->where('common_countries.is_active', '!=', 1)
                ->where('common_states.is_active', '!=', 1)
                ->select('common_cities.id',
                        'common_countries.country_name',
                        'common_states.state_name',
                        'common_cities.city_name',
                        'common_cities.is_active')
                ->join('common_countries', 'common_countries.id', '=', 'common_cities.country_id')
                ->join('common_states', 'common_states.id', '=', 'common_cities.state_id')
                ->orderBy('city_name', 'asc')
                ->get();
        if (Auth::user()->can('Create City')) {
            $breadcrumbs = [
                ['link' => "/home", 'name' => "Home"],
                ['link' => "/city/", 'name' => "City Managment"],
                ['link' => "/city/create", 'name' => "Create"],
            ];
            $pageConfigs = ['pageHeader' => true, 'isFabButton' => true, 'isCustomizer' => true];

            $rightlink = [
                ['rightlink' => "/city/create", 'name' => "Create"]
            ];
            $deletelink = [
                ['name' => "Delete"],
            ];
            if (Auth::user()->can('Delete City')) {
                return view('hrms.city.index', [
                    'rightlink' => $rightlink,
                    'CityDetails' => $CityDetails,
                    'deletelink' => $deletelink,
                    'pageConfigs' => $pageConfigs,
                    'breadcrumbs' => $breadcrumbs,
                ]);
            } else {
                return view('hrms.city.index', [
                    'rightlink' => $rightlink,
                    'CityDetails' => $CityDetails,
                    'pageConfigs' => $pageConfigs,
                    'breadcrumbs' => $breadcrumbs,
                ]);
            }
        } else {
            $breadcrumbs = [
                ['link' => "/home", 'name' => "Home"],
                ['link' => "/city/", 'name' => "City Managment"],
            ];
            $pageConfigs = ['pageHeader' => true, 'isFabButton' => true, 'isCustomizer' => true];


            $deletelink = [
                ['name' => "Delete"],
            ];
            if (Auth::user()->can('Delete City')) {
                return view('hrms.city.index', [
                    'CityDetails' => $CityDetails,
                    'deletelink' => $deletelink,
                    'pageConfigs' => $pageConfigs,
                    'breadcrumbs' => $breadcrumbs,
                ]);
            } else {
                return view('hrms.city.index', [
                    'CityDetails' => $CityDetails,
                    'pageConfigs' => $pageConfigs,
                    'breadcrumbs' => $breadcrumbs,
                ]);
            }
        }
    }

    public function getstate(Request $request) {

        if ($request->ajax()) {
            $id = $request->input('id');
            $common_states = DB::table("common_states")
                    ->where("country_id", '=', $id)
                    ->select("common_states.*")
                    ->whereNull('deleted_at')
                    ->where('is_active', '=', '0')
                    ->get();
            return response()->json($common_states);
        }
    }

    public function getCity(Request $request) {
        if ($request->ajax()) {
            $state_id = $request->input('state_id');
//            $country_id = $request->input('country_id');
            $common_states = DB::table("common_cities")
                    ->where("state_id", '=', $state_id)
//                    ->where("country_id", '=', $country_id)
                    ->select("common_cities.*")
                    ->whereNull('deleted_at')
                    ->where('is_active', '=', '0')
                    ->get();
            return response()->json($common_states);
        }
    }

    public function create() {
        $breadcrumbs = [
            ['link' => "/home", 'name' => "Home"],
            ['link' => "/city", 'name' => "City Managment"],
            ['name' => "Create"],
        ];
        //Pageheader set true for breadcrumbs
        $pageConfigs = ['pageHeader' => true, 'isFabButton' => true, 'isCustomizer' => true];
        $state = DB::table('common_states')->where('country_id', '=', 1)->where('is_active', '=', '0')->get();

        return view('hrms.city.create', [
            'common_countries' => $this->getCountry(),
            'common_cities' => $this->getCitys(),
            'pageConfigs' => $pageConfigs,
            'breadcrumbs' => $breadcrumbs,
            'states' => $state
        ]);
    }

    public function store(Request $Request) {
        $validatedData = $Request->validate([
            'country_id' => 'required',
            'state_id' => 'required',
            'city_name' => 'required',
            'location' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'is_active' => 'required',
        ]);

        City::create([
            'country_id' => $Request->country_id,
            'state_id' => $Request->state_id,
            'city_name' => $Request->city_name,
            'Name' => $Request->city_name,
            'location'=>$Request->location,
            'latitude'=>$Request->latitude,
            'longitude'=>$Request->longitude,
            'is_active' => $Request->is_active,
        ]);
        redirect()->back()->with('success', 'City Create Successfully !');
        return redirect('/city');
    }

    function getdata() {
        /* get all data from table to database */
        $States = DB::table('common_cities')
                ->where('common_cities.deleted_at', '=', '')
                ->where('common_states.is_active', '=', '0')
                ->where('common_countries.is_active', '=', '0')
                ->orWhereNull('common_cities.deleted_at')
                ->select('common_cities.id',
                        'status_codes.name',
                        'common_countries.country_name',
                        'common_states.state_name',
                        'common_cities.city_name',
                        'common_cities.is_active')
                ->join('status_codes', 'status_codes.code', '=', 'common_cities.is_active')
                ->join('common_countries', 'common_countries.id', '=', 'common_cities.country_id')
                ->join('common_states', 'common_states.id', '=', 'common_cities.state_id')
                ->get();
        return Datatables::of($States)
                        ->addColumn('action', function($State) {

                            $actionBtn = '';
                            if (Auth::user()->can('city-edit')) {
                                $actionBtn .= '<a href = "' . route('hrms.city.edit', ['id' => $State->id]) . '" class = "invoice-action-edit edit" id = "' . $State->id . '"><i class="material-icons">edit</i></a>';
                            }
                            if (Auth::user()->can('city-delete')) {
                                $actionBtn .= '<a href = "#" class = "invoice-action-view mr-4 delete" id = "' . $State->id . '"><i class="material-icons dp48 button delete-confirm">delete</i></a>';
                            }
                            return $actionBtn;
                        })
                        ->addColumn('checkbox', '<label><input type = "checkbox" class = "state_checkbox" value = "{{$id}}" /><span></span></label>')
                        ->rawColumns(['checkbox', 'action'])
                        ->make(true);
    }

    function delete(Request $request) {

        $City_delete = City::whereId($request->input('id'))->first();

        $emp_data = DB::table('employees')->where('select_city',$request->input('id'))->get();
        if(count($emp_data) > 0)
        {
            return response('error');
        }
        else
        {
            $City_delete->forceDelete();
        }

        /* single delete */
//        $delete = City::whereId($request->input('id'))->first();
//        if ($delete->delete()) {
//            $delete->update([
//                'is_active' => '1',
//            ]);
//        }
    }

    function multidelete(Request $request) {
        /* multi delete */

        $id_arrary = $request->input('ids');
        foreach ($id_arrary as $id) {
            $delete = City::whereId($id)->first();
            $delete->forceDelete();
//            if ($delete->delete()) {
//                $delete->update([
//                    'is_active' => '1',
//                ]);
//            }
        }
    }

    public function edit($id) {

        $breadcrumbs = [
            ['link' => "/home", 'name' => "Home"],
            ['link' => "/city/", 'name' => "City Managment"],
            ['name' => "/Update"],
        ];
        $pageConfigs = ['pageHeader' => true, 'isFabButton' => true, 'isCustomizer' => true];

        $CountryMaster = DB::table('common_countries')
                ->where('is_active', '=', '0')
                ->get();
//        $StateMaster = DB::table('common_states')
//                ->where('is_active', '=', '0')
//                ->get();
        $state = DB::table('common_states')->where('country_id', '=', 1)->where('is_active', '=', '0')->get();
        if ($CityMaster = City::whereId($id)->first()) {
            return view('hrms.city.edit', [
                'pageConfigs' => $pageConfigs,
                'breadcrumbs' => $breadcrumbs,
                'CityMasters' => $CityMaster,
//                'StateMasters' => $StateMaster,
                'CountryMasters' => $CountryMaster,
                'states' => $state,
                'common_countries' => $this->getCountry()
            ]);
        }
    }

    public function getCitys() {
        return DB::table('common_cities')
                        ->where('is_active', '=', '0')
                        ->orderBy('city_name', 'asc')
                        ->get();
    }

    public function getStates() {
        return DB::table('common_states')
                        ->where('is_active', '=', '0')
                        ->orderBy('state_name', 'asc')
                        ->get();
    }

    public function getCountry() {
        return DB::table('common_countries')
                        ->where('is_active', '=', '0')
                        ->orderBy('country_name', 'asc')
                        ->get();
    }

    public function update(Request $Request, $id) {
        $validatedData = $Request->validate([
            'country_id' => 'required',
            'state_id' => 'required',
            'city_name' => 'required',
            // 'Name' => 'required',
            'location' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'is_active' => 'required',
        ]);

        $City = City::findOrFail($id);
        $City->update($Request->all());
        $City->save();
        redirect()->back()->with('success', 'City Update Successfully !');
        return redirect('/city');
    }

    function validname(Request $request) {
        if ($request->input('city_name') !== '') {
            if ($request->input('city_name')) {
                $rule = array(
                    'city_name' => 'required|unique:common_cities,city_name,NULL,id,deleted_at,NULL',
                );
                $validator = Validator::make($request->all(), $rule);
            }
            if (!$validator->fails()) {
                die('true');
            }
        }
        die('false');
    }

}

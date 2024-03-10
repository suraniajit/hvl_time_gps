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
use App\Models\hrms\State;
use Validator;

class StateController extends Controller {

    public function __construct() {
        $this->middleware('permission:Access State', ['only' => ['show', 'index']]);
        $this->middleware('permission:Create State', ['only' => ['create']]);
        $this->middleware('permission:Read State', ['only' => ['read']]);
        $this->middleware('permission:Edit State', ['only' => ['edit']]);
        $this->middleware('permission:Delete State', ['only' => ['delete']]);
    }

    public function index() {

        $StateDetails = DB::table('common_states')
            ->join('common_countries', 'common_countries.id', '=', 'common_states.country_id')
            ->select('common_states.id',
                'common_countries.country_name',
                'common_states.state_name',
                'common_states.is_active')
//                ->where('common_countries.is_active', '=', 0)
//                ->where('common_states.is_active', '=', 0)
            ->orderBy('state_name', 'asc')
            ->get();
        if (Auth::user()->can('Create Country')) {
            $breadcrumbs = [
                ['link' => "/hrms", 'name' => "Home"],
                ['link' => "/state/", 'name' => "State Managment"],
                ['link' => "/state/create", 'name' => "Create"],
            ];

            $pageConfigs = ['pageHeader' => true, 'isFabButton' => true, 'isCustomizer' => true];
            $rightlink = [
                ['rightlink' => "/state/create", 'name' => "Create"]
            ];
            $deletelink = [
                ['name' => "Delete"],
            ];

            if (Auth::user()->can('Delete State')) {
                return view('hrms.state.index', [
                    'rightlink' => $rightlink,
                    'pageConfigs' => $pageConfigs, 'deletelink' => $deletelink,
                    'breadcrumbs' => $breadcrumbs,
                    'StateDetails' => $StateDetails
                ]);
            } else {
                return view('hrms.state.index', [
                    'rightlink' => $rightlink,
                    'pageConfigs' => $pageConfigs,
                    'breadcrumbs' => $breadcrumbs,
                    'StateDetails' => $StateDetails
                ]);
            }
        } else {
            $breadcrumbs = [
                ['link' => "/hrms", 'name' => "Home"],
                ['link' => "/state/", 'name' => "State Managment"],
            ];

            $pageConfigs = ['pageHeader' => true, 'isFabButton' => true, 'isCustomizer' => true];

            $deletelink = [
                ['name' => "Delete"],
            ];
            if (Auth::user()->can('Delete State')) {
                return view('hrms.state.index', [
                    'pageConfigs' => $pageConfigs,
                    'deletelink' => $deletelink,
                    'breadcrumbs' => $breadcrumbs,
                    'StateDetails' => $StateDetails
                ]);
            } else {
                return view('hrms.state.index', [
                    'pageConfigs' => $pageConfigs,
                    'breadcrumbs' => $breadcrumbs,
                    'StateDetails' => $StateDetails
                ]);
            }
        }
    }

    public function create() {

        $breadcrumbs = [
            ['link' => "hrms", 'name' => "Home"],
            ['link' => "/state/create", 'name' => "State Managment"],
            ['name' => "Create"],
        ];
//Pageheader set true for breadcrumbs
        $pageConfigs = ['pageHeader' => true, 'isFabButton' => true, 'isCustomizer' => true];


        return view('hrms.state.create', [
            'pageConfigs' => $pageConfigs,
            'CountryMasters' => $this->getCountry(),
            'breadcrumbs' => $breadcrumbs
        ]);
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

    function validname(Request $request) {
        /* Validaiton of the state */
        if ($request->input('state_name') !== '') {
            $rule = array(
                'state_name' => 'required|unique:common_states,state_name,NULL,id,deleted_at,NULL',
            );
            $validator = Validator::make($request->all(), $rule);
            if (!$validator->fails()) {
                die('true');
            }
        }
        die('false');
    }
    public function editvalidname(Request $request) {
        /* validating all the fields and unique marital status name while updating */

        $id = $request->id;

        $rule = array(
            'state_name' => Rule::unique('common_states', 'state_name')->ignore($id),
        );
        $validator = Validator::make($request->all(), $rule);
        if (!$validator->fails()) {
            die('true');
        }
        die('false');
    }

    public function store(Request $Request) {
        State::create([
            'country_id' => $Request->country_id,
            'state_name' => $Request->state_name,
            'is_active' => $Request->is_active,
        ]);
        redirect()->back()->with('success', 'State Create Successfully !');
        return redirect('/state');
    }

    function getdata() {
        /* get all data from table to database */
        $States = DB::table('common_states')
            ->where('common_states.deleted_at', '=', '')
            ->orWhereNull('common_states.deleted_at')
            ->select('common_states.id',
                'status_codes.name',
                'common_countries.country_name',
                'common_states.state_name',
                'common_states.is_active')
            ->join('status_codes', 'status_codes.code', '=', 'common_states.is_active')
            ->join('common_countries', 'common_states.country_id', '=', 'common_countries.id')
            ->get();
        return Datatables::of($States)
            ->addColumn('action', function($State) {
                $actionBtn = '';
                if (Auth::user()->can('state-edit')) {
                    $actionBtn .= '<a href = "' . route('hrms.state.edit', ['id' => $State->id]) . '" class = "invoice-action-edit edit" id = "' . $State->id . '"><i class="material-icons">edit</i></a>';
                }
                if (Auth::user()->can('state-delete')) {
                    $actionBtn .= '<a href = "#" class = "invoice-action-view mr-4 delete" id = "' . $State->id . '"><i class="material-icons dp48 button delete-confirm">delete</i></a>';
                }
                return $actionBtn;
            })
            ->addColumn('checkbox', '<label><input type = "checkbox" class = "state_checkbox" value = "{{$id}}" /><span></span></label>')
            ->rawColumns(['checkbox', 'action'])
            ->make(true);
    }

    function checkState(Request $request) {
        /* check the state if is not avalable in table */
        $States = State::where('state_name', '=', $request->state_name)->get();

        if (count($States) > 0) {
            return "true";
        } else {
            return "false"; //already registered
        }
    }

    function delete(Request $request) {
        // delete city
        $delete_city = DB::table('common_cities')
            ->where('common_cities.state_id', '=', $request->input('id'))
            ->get();
        $delete_customer = DB::table('hvl_customer_master')
            ->where('hvl_customer_master.billing_state', '=', $request->input('id'))
            ->orWhere('hvl_customer_master.shipping_state','=',$request->input('id'))
            ->get();

        if (count($delete_city) > 0) {
           return response('error');
        }
        elseif (count($delete_customer) > 0 )
        {
            return response('error');
        }
        else
        {
            DB::table('common_cities')->where('common_cities.state_id', $request->input('id'))->delete();
            //delete state
            $Statedelete = State::whereId($request->input('id'))->first();
            $Statedelete->forceDelete();
        }



        /* single delete */
//        $delete = State::whereId($request->input('id'))->first();
//        if ($delete->delete()) {
//            $delete->update([
//                'is_active' => '1',
//            ]);
//        }
    }

    function multidelete(Request $request) {


        $id_array = $request->input('id');
        foreach ($id_array as $id) {
            $delete_city = DB::table('common_cities')
                ->where('common_cities.state_id', '=', $id)
                ->get();

            $delete_customer = DB::table('hvl_customer_master')
                ->where('hvl_customer_master.billing_state', '=', $id)
                ->orWhere('hvl_customer_master.shipping_state','=',$id)
                ->get();

            if (count($delete_city) > 0) {
                return response('error');
            }
            elseif (count($delete_customer) > 0 )
            {
                return response('error');
            }
            else
            {
                DB::table('common_cities')->where('common_cities.state_id', $id)->delete();
                //delete state
                $Statedelete = State::whereId($id)->first();
                $Statedelete->forceDelete();
            }
//            if ($delete->delete()) {
//                $delete->update([
//                    'is_active' => '1',
//                ]);
//            }
        }
    }

    public function edit($id) {
        $breadcrumbs = [
            ['link' => "hrms", 'name' => "Home"],
            ['link' => "/state", 'name' => "State Managment"],
            ['name' => "Update"],
        ];
//Pageheader set true for breadcrumbs
        $pageConfigs = ['pageHeader' => true, 'isFabButton' => true, 'isCustomizer' => true];



        $CountryMaster = DB::table('common_countries')
            ->where('is_active', '=', '0')
            ->get();

        if ($StateMaster = State::whereId($id)->first()) {
            return view('hrms.state.edit', [
                'StateMasters' => $StateMaster,
                'CountryMasters' => $CountryMaster,
                'pageConfigs' => $pageConfigs,
                'breadcrumbs' => $breadcrumbs
            ]);
        }
    }

    public function update(Request $Request, $id) {
        /* update of state */
        $State = State::findOrFail($id);
        $State->update($Request->all());
        $State->save();
        redirect()->back()->with('success', 'State Update Successfully !');
        return redirect('/state');
    }

}

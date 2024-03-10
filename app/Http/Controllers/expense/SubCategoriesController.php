<?php

namespace App\Http\Controllers\expense;

use App\User;
use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Validation\Rule;
use App\SubCategoriesMaster;
use Illuminate\Support\Facades\DB;
use Validator;

class SubCategoriesController extends Controller {

    public function __construct() {
//        INSERT INTO `permissions` (`name`, `path`, `dashboard`, `guard_name`)
//        VALUES ('Access category', 'HRMS', NULL, 'web'),
//        VALUES ('Read category', 'HRMS', NULL, 'web'),
//        VALUES ('Create category', 'HRMS', NULL, 'web'),
//        VALUES ('Edit category', 'HRMS', NULL, 'web'),
//        VALUES('Delete category', 'HRMS', NULL, 'web');
//        $this->middleware('permission:Access subcategory', ['only' => ['show', 'index']]);
//        $this->middleware('permission:Create subcategory', ['only' => ['create']]);
//        $this->middleware('permission:Read subcategory', ['only' => ['read']]);
//        $this->middleware('permission:Edit subcategory', ['only' => ['edit']]);
//        $this->middleware('permission:Delete subcategory', ['only' => ['delete']]);
    }

    public function index() {

        $subcategoryDetails = DB::table('sub_category')->select('*')->orderBy('name', 'desc')
                ->get();

        $breadcrumbs = [
            ['link' => "/home", 'name' => "Home"],
            ['link' => "/subcategory/", 'name' => "Sub Category Managment"],
        ];
        $pageConfigs = ['pageHeader' => true, 'isFabButton' => true, 'isCustomizer' => true];

        $rightlink = [
            ['rightlink' => "/subcategory/create", 'name' => "Create"]
        ];
        $deletelink = [
            ['name' => "Delete"],
        ];
        return view('employee-master.subcategory.index', [
            'subcategoryDetails' => $subcategoryDetails,
            'rightlink' => $rightlink,
            'deletelink' => $deletelink,
            'pageConfigs' => $pageConfigs,
            'breadcrumbs' => $breadcrumbs
        ]);
    }

    public function create() {

        $breadcrumbs = [
            ['link' => "/home", 'name' => "Home"],
            ['link' => "/subcategory/", 'name' => "Sub Category Managment"],
            ['name' => "Create"],
        ];
//Pageheader set true for breadcrumbs


        $pageConfigs = ['pageHeader' => true, 'isFabButton' => true, 'isCustomizer' => true];

        return view('employee-master.subcategory.create', [
            'pageConfigs' => $pageConfigs,
            'breadcrumbs' => $breadcrumbs,
            'getcategoryList' => $this->getcategoryList()
        ]);
    }

    public function getcategoryList() {
        return DB::table('category')->select('*')->orderBy('name', 'desc')->get();
    }

    public function store(Request $Request) {

        $subcategorys = SubCategoriesMaster::create($Request->all());
        $subcategorys->save();
        redirect()->back()->with('success', 'Sub Category Create Successfully !');
        return redirect('/subcategory');
    }

    public function edit($id) {

        $breadcrumbs = [
            ['link' => "/home", 'name' => "Home"],
            ['link' => "/subcategory/", 'name' => "Sub Category Managment"],
            ['name' => "Update"],
        ];
//Pageheader set true for breadcrumbs
        $pageConfigs = ['pageHeader' => true, 'isFabButton' => true, 'isCustomizer' => true];

        $subcategoryMaster = DB::table('sub_category')->select('*')->where('id', '=', $id)->first();

        if ($subcategoryMaster) {
            return view('employee-master.subcategory.edit', [
                'subcategory' => $subcategoryMaster,
                'pageConfigs' => $pageConfigs,
                'getcategoryList' => $this->getcategoryList(),
                'breadcrumbs' => $breadcrumbs
            ]);
        }
    }

    public function update(Request $Request, $id) {
        DB::update('update sub_category set name = ? , is_active = ?  where id = ?', [$Request->name
            , $Request->is_active, $id]);
        redirect()->back()->with('success', 'Sub Category Update Successfully !');
        return redirect('/subcategory');
    }

    function delete(Request $request) {
        DB::table('sub_category')->where('id', $request->input('id'))->delete();
    }

    function multidelete(Request $request) {

        $subcategory_id_array = $request->input('id');

        foreach ($subcategory_id_array as $key => $id) {
            DB::table('sub_category')->where('id', '=', $id)->delete();
        }
    }

    public function getsubcategorycode(Request $request) {

        if ($request->ajax()) {
            $id = $request->input('id');
            $common_currency = DB::table('sub_category')
                    ->where("id", '=', $id)
                    ->select("code")
//                    ->whereNull('deleted_at')->where('is_active', '=', '0')
                    ->get();
            return response()->json($common_currency);
        }
    }

    public function validname_(Request $request) {

        if ($request->ajax()) {
            $common_states = DB::table("sub_category")
                    ->where("category_id", '=', $request->input('category_id'))
                    ->where("name", '=', $request->input('name'))
                    ->select("*")
                    ->get();
            if (count($common_states) > 0) {
                return '0';
            } else {
                return '1';
            }
        }
    }

    public function validname(Request $request) {
        $id = $request->id;

        if ($request->input('name') !== '') {
            $rule = array(
                'name' => 'unique:sub_category',
            );
            $validator = Validator::make($request->all(), $rule);
            if (!$validator->fails()) {
                die('true');
            }
        }
        die('false');
    }

    public function editvalidname(Request $request) {
        $id = $request->id;
        $rule = array(
            'name' => Rule::unique('sub_category', 'name')->ignore($id),
        );
        $validator = Validator::make($request->all(), $rule);
        if (!$validator->fails()) {
            die('true');
        }
        die('false');
    }

}

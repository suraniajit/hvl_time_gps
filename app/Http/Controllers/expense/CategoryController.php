<?php

namespace App\Http\Controllers\expense;

use App\User;
use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Validation\Rule;
use App\CategoryMaster;
use Illuminate\Support\Facades\DB;
use Validator;

class CategoryController extends Controller {

    public function __construct() {
//        INSERT INTO `permissions` (`name`, `path`, `dashboard`, `guard_name`) 
//VALUES ('Access category', 'HRMS', NULL, 'web'),
//VALUES ('Read category', 'HRMS', NULL, 'web'),
//VALUES ('Create category', 'HRMS', NULL, 'web'),
//VALUES ('Edit category', 'HRMS', NULL, 'web'),
//VALUES ('Delete category', 'HRMS', NULL, 'web'); 
//        $this->middleware('permission:Access category', ['only' => ['show', 'index']]);
//        $this->middleware('permission:Create category', ['only' => ['create']]);
//        $this->middleware('permission:Read category', ['only' => ['read']]);
//        $this->middleware('permission:Edit category', ['only' => ['edit']]);
//        $this->middleware('permission:Delete category', ['only' => ['delete']]);
    }

    public function index() {

        $categoryDetails = DB::table('category')->select('*')->orderBy('name', 'desc')->get();

        $breadcrumbs = [
            ['link' => "/home", 'name' => "Home"],
            ['link' => "/category/", 'name' => "Category Managment"],
        ];
        $pageConfigs = ['pageHeader' => true, 'isFabButton' => true, 'isCustomizer' => true];

        $rightlink = [
            ['rightlink' => "/category/create", 'name' => "Create"]
        ];
        $deletelink = [
            ['name' => "Delete"],
        ];
        return view('employee-master.category.index', [
            'categoryDetails' => $categoryDetails,
            'rightlink' => $rightlink,
            'deletelink' => $deletelink,
            'pageConfigs' => $pageConfigs,
            'breadcrumbs' => $breadcrumbs
        ]);
    }

    public function create() {

        $breadcrumbs = [
            ['link' => "/home", 'name' => "Home"],
            ['link' => "/category/", 'name' => "Category Managment"],
            ['name' => "Create"],
        ];
//Pageheader set true for breadcrumbs


        $pageConfigs = ['pageHeader' => true, 'isFabButton' => true, 'isCustomizer' => true];

        return view('employee-master.category.create', [
            'pageConfigs' => $pageConfigs,
            'breadcrumbs' => $breadcrumbs
        ]);
    }

    public function store(Request $Request) {
        $categorys = CategoryMaster::create($Request->all());
        $categorys->save();
        redirect()->back()->with('success', 'Category Create Successfully !');
        return redirect('/category');
    }

    public function edit($id) {

        $breadcrumbs = [
            ['link' => "/home", 'name' => "Home"],
            ['link' => "/category/", 'name' => "Category Managment"],
            ['name' => "Update"],
        ];
//Pageheader set true for breadcrumbs
        $pageConfigs = ['pageHeader' => true, 'isFabButton' => true, 'isCustomizer' => true];

        $categoryMaster = DB::table('category')->select('*')->where('id', '=', $id)->first();

        if ($categoryMaster) {
            return view('employee-master.category.edit', [
                'categoryMaster' => $categoryMaster,
                'pageConfigs' => $pageConfigs,
                'breadcrumbs' => $breadcrumbs
            ]);
        }
    }

    public function update(Request $Request, $id) {
        DB::update('update category set name = ? , is_active = ?  where id = ?', [$Request->name
            , $Request->is_active, $id]);
        redirect()->back()->with('success', 'Category Update Successfully !');
        return redirect('/category');
    }

    function delete(Request $request) {
        $result = null;
        $sub_category = DB::table('sub_category')->where('category_id', $request->input('id'))->get();
        if (count($sub_category) > 0) {
            $result = 1;
        } else {
            $result = 0;
            DB::table('category')->where('id', $request->input('id'))->delete();
        }
        return $result;
    }

    function multidelete(Request $request) {

        $category_id_array = $request->input('id');

        foreach ($category_id_array as $key => $id) {
            DB::table('category')->where('id', '=', $id)->delete();
        }
    }

    public function getcategorycode(Request $request) {

        if ($request->ajax()) {
            $id = $request->input('id');
            $common_currency = DB::table("category")
                    ->where(
                            "id", '=', $id)
                    ->select("code")
//                    ->whereNull('deleted_at')->where('is_active', '=', '0')
                    ->get();
            return response()->json($common_currency);
        }
    }

    public function validname(Request $request) {
        /* Validaiton of the batch */

        if ($request->input('name') !== '') {
            $rule = array(
                'name' => 'unique:category',
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
            'name' => Rule::unique('category', 'name')->ignore($id),
        );
        $validator = Validator::make($request->all(), $rule);
        if (!$validator->fails()) {
            die('true');
        }
        die('false');
    }

}

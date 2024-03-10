<?php

namespace App\Http\Controllers\hrms;

use App\User;
use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\softDeletes;
use Illuminate\Validation\Rule;
use App\Models\hrms\Vendor;
use Datatables;
use SweetAlert;
use Validator;

class VendorController extends Controller {

    function __construct() {
//        $this->middleware('auth');
        $this->middleware('permission:vendor-list|vendor-create|vendor-edit|vendor-delete', ['only' => ['index', 'getdata']]);
        $this->middleware('permission:vendor-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:vendor-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:vendor-delete', ['only' => ['delete']]);
        $this->middleware('permission:vendor-multidelete', ['only' => ['multidelete']]);
    }

    public function index() {
        //Pageheader set true for breadcrumbs
        $pageConfigs = ['pageHeader' => true, 'isFabButton' => true,'isCustomizer' => true];
        if (Auth::user()->can('vendor-create')) {
            $breadcrumbs = [
             ['link' => "hrms", 'name' => "Home"],
             ['link' => "hrms/vendor/", 'name' => "Vendor Master"],
             ['link' => "hrms/vendor/create", 'name' => "Create"],
            ];
            $rigthlink = [
             ['rigthlink' => "vendor/create", 'name' => "Create"]
            ];
            return view('hrms.vendor.index', [
             'rigthlink' => $rigthlink,
             'pageConfigs' => $pageConfigs,
             'breadcrumbs' => $breadcrumbs
            ]);
        } else {
            $breadcrumbs = [
             ['link' => "hrms", 'name' => "Home"],
             ['link' => "hrms/vendor/", 'name' => "Vendor Master"],
            ];

            return view('hrms.vendor.index', [
             'pageConfigs' => $pageConfigs,
             'breadcrumbs' => $breadcrumbs
            ]);
        }
    }

    public function create() {

        $breadcrumbs = [
         ['link' => "hrms", 'name' => "Home"],
         ['link' => "hrms/vendor/", 'name' => "Vendor Master"],
         ['name' => "Create"],
        ];
//Pageheader set true for breadcrumbs
        $pageConfigs = ['pageHeader' => true, 'isFabButton' => false,'isCustomizer' => true];

        $CurrencyMasters = DB::table('currency_masters')->where('is_active', '=', '0')
                ->get();

        return view('hrms.vendor.create', [
         'CurrencyMasters' => $CurrencyMasters,
         'pageConfigs' => $pageConfigs,
         'breadcrumbs' => $breadcrumbs
        ]);
    }

    public function store(Request $Request) {
//           $this->validate($Request, [
//              'vendor_name' => 'required',
//              'vendor_product' => 'required',
//              'vendor_product' => 'required',
//              'products_value' => 'required',
//           ]);

        $Vendor = Vendor::create($Request->all());
        $last_id = DB::getPDO()->lastInsertId();
        $Vendor->save();
        redirect()->back()->with('success', 'New Vendor Create Successfully !');
        return redirect('hrms/vendor/');
    }

    function getdata() {
        $Vendors = DB::table('vendors')
                ->where('vendors.deleted_at', '=', '')
                ->orWhereNull('vendors.deleted_at')
                ->select('vendors.id',
                        'status_codes.name',
                        'vendors.vendor_name',
                        'vendors.vendor_rat',
                        'vendors.vendor_product',
                        'vendors.products_value',
                        'vendors.is_active',
                        'currency_masters.currency_code AS rat_name',
                        'currency_masters.currency_code AS alias_name')
                ->join('status_codes', 'status_codes.code', '=', 'vendors.is_active')
                ->join('currency_masters', 'vendors.currency_id_vendor_rat', '=', 'currency_masters.id')
                ->get();
        return Datatables::of($Vendors)
                        ->addColumn('action', function($Vendor) {
                            $actionBtn = '';
                            if (Auth::user()->can('vendor-view')) {
                                $actionBtn .= '<a href="' . route('hrms.vendor.view', ['id' => $Vendor->id]) . '"><i class="material-icons dp48">visibility</i></a>';
                            }
                            if (Auth::user()->can('vendor-edit')) {
                                $actionBtn .= '<a href = "' . route('hrms.vendor.edit', ['id' => $Vendor->id]) . '" class = "invoice-action-edit edit" id = "' . $Vendor->id . '"><i class="material-icons">edit</i></a>';
                            }
                            if (Auth::user()->can('vendor-delete')) {
                                $actionBtn .= '<a href = "#" class = "invoice-action-view mr-4 delete" id = "' . $Vendor->id . '"><i class="material-icons dp48 button delete-confirm">delete</i></a>';
                            }

                            return $actionBtn;
                        })
                        ->addColumn('checkbox', '<label><input type = "checkbox" class = "Vendor_checkbox" value = "{{$id}}" /><span></span></label>')
                        ->rawColumns(['checkbox', 'action'])
                        ->make(true);
    }

    function delete(Request $request) {

        $Vendors_delete = Vendor::whereId($request->input('id'))->first();
        $Vendors_delete->update([
         'is_active' => '1',
        ]);

        $Vendors = Vendor::find($request->input('id'));
        if ($Vendors->delete()) {
            echo 'Data Deleted';
        }
    }

    function multidelete(Request $request) {
        $Vendor_id_array = $request->input('id');

        foreach ($Vendor_id_array as $id) {
            $Vendors_delete = Vendor::whereId($id)->first();
            $Vendors_delete->update([
             'is_active' => '1',
            ]);
        }

        $Vendor = Vendor::whereIn('id', $Vendor_id_array);
        if ($Vendor->delete()) {
            echo 'Data Deleted';
        }
    }

    public function edit($id) {
        $breadcrumbs = [
         ['link' => "hrms", 'name' => "Home"],
         ['link' => "hrms/vendor/", 'name' => "Vendor Master"],
         ['name' => "Update"],
        ];
        $pageConfigs = ['pageHeader' => true, 'isFabButton' => true,'isCustomizer' => true];

        $CurrencyMasters = DB::table('currency_masters')->where('is_active', '=', '0')
                ->get();

        if ($Vendor = Vendor::whereId($id)->first()) {
            return view('hrms.vendor.edit', [
             'CurrencyMasters' => $CurrencyMasters,
             'vendors_Details' => $Vendor,
             'pageConfigs' => $pageConfigs,
             'breadcrumbs' => $breadcrumbs
            ]);
        }
    }

    public function update(Request $Request, $id) {

        $Vendor = Vendor::findOrFail($id);
        $Vendor->update($Request->all());
        $Vendor->save();
        redirect()->back()->with('success', 'Vendor Update Successfully!');
        return redirect('hrms/vendor/');
    }

    public function view($id) {
        $breadcrumbs = [
         ['link' => "hrms", 'name' => "Home"],
         ['link' => "hrms/vendor/", 'name' => "Vendor Master"],
         ['name' => "View"],
        ];
        $pageConfigs = ['pageHeader' => true, 'isFabButton' => true,'isCustomizer' => true];

        $CurrencyMasters = DB::table('currency_masters')->where('is_active', '=', '0')
                ->get();

        if ($Vendor = Vendor::whereId($id)->first()) {
            return view('hrms.vendor.view', [
             'CurrencyMasters' => $CurrencyMasters,
             'vendors_Details' => $Vendor,
             'pageConfigs' => $pageConfigs,
             'breadcrumbs' => $breadcrumbs
            ]);
        }
    }

    public function validname(Request $request) {
        /* Validaiton of the designation */
        if ($request->input('vendor_name') !== '') {
            $rule = array(
             'vendor_name' => 'required|unique:vendors,vendor_name,NULL,id,deleted_at,NULL',
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
         'vendor_name' => Rule::unique('vendors', 'vendor_name')->ignore($id),
        );
        $validator = Validator::make($request->all(), $rule);
        if (!$validator->fails()) {
            die('true');
        }
        die('false');
    }

}

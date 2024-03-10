<?php

namespace App\Http\Controllers\hrms;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Datatables;
use App\Models\hrms\StatusCode;
use Illuminate\Database\Eloquent\softDeletes;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;

class StatusCodeController extends Controller {

    //
    public function index() {
        $breadcrumbs = [
        ['link' => "hrms", 'name' => "Home"],
        ['link' => "hrms/StatusCode/", 'name' => "Status Code Master"],
        ['link' => "hrms/StatusCode/create", 'name' => "Create"],
        ];
        //Pageheader set true for breadcrumbs
        $pageConfigs = ['pageHeader' => true, 'isFabButton' => true];
        $StatusCodes = DB::table('status_codes')->get();
        return view('hrms.status-code.index', ['pageConfigs' => $pageConfigs, 'breadcrumbs' => $breadcrumbs]);
    }

    public function create() {
        return view('hrms.status-code.create');
    }

    public function store(Request $Request) {
        $this->validate($Request, [
        'batch_name' => 'required',
        ]);
        $StatusCode = StatusCode::create($Request->all());
        $last_id = DB::getPDO()->lastInsertId();
        $StatusCode->save();
        return redirect('hrms/status-code/');
    }

    public function edit() {
        return view('hrms.status-code.index');
    }

    function removedata(Request $request) {
        $StatusCode = StatusCode::find($request->input('id'));
        if ($StatusCode->delete()) {
            echo 'Data Deleted';
        }
    }

    function massremove(Request $request) {
        $StatusCode_id_array = $request->input('id');
        $StatusCode = StatusCode::whereIn('id', $StatusCode_id_array);
        if ($StatusCode->delete()) {
            echo 'Data Deleted';
        }
    }

    function getdata() {

        $StatusCodes = StatusCode:: select('id', 'status_name', 'status_code', 'is_active')->get();
        return Datatables::of($StatusCodes)
                                                                                                                                ->addColumn('action', function($StatusCode) {
                                                                                                                                    return '<a href = "' . route('hrms.StatusCode.edit', ['id' => $StatusCode->id]) . '" class = "invoice-action-edit edit" id = "' . $StatusCode->id . '"><i class="material-icons">edit</i></a><a href = "#" class = "invoice-action-view mr-4 delete" id = "' . $StatusCode->id . '"><i class="material-icons dp48 button delete-confirm">delete</i></a>';
                                                                                                                                })
                                                                                                                                ->addColumn('checkbox', '<label><input type = "checkbox" class = "batch_checkbox" value = "{{$id}}" /><span></span></label>')
                                                                                                                                ->rawColumns(['checkbox', 'action'])
                                                                                                                                ->make(true);
    }

}

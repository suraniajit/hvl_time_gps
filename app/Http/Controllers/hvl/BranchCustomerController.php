<?php

namespace App\Http\Controllers\hvl;

use App\User;
use Auth;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BranchCustomerController extends Controller {

    public function __construct() {
        $this->middleware('permission:Access Customer', ['only' => ['show', 'index']]);
        $this->middleware('permission:Create Customer', ['only' => ['create']]);
        $this->middleware('permission:Read Customer', ['only' => ['read']]);
        $this->middleware('permission:Edit Customer', ['only' => ['edit']]);
        $this->middleware('permission:Delete Customer', ['only' => ['delete']]);
    }

    public function index() {
        $details = DB::table('branch_to_customer')
                ->join('Zones', 'Zones.id', '=', 'branch_to_customer.zone_id')
                ->join('Branch', 'Branch.id', '=', 'branch_to_customer.branch_id')
                ->join('hvl_customer_master', 'hvl_customer_master.id', '=', 'branch_to_customer.customer_id')
                ->join('employees', 'employees.id', '=', 'branch_to_customer.employee_id')
                ->select('employees.Name as emp_name', 'hvl_customer_master.customer_name', 'Branch.Name as branch_name', 'Zones.Name as zone_name', 'branch_to_customer.*')
                ->get()
                ->groupBy('zone_name');

        return view('hvl.branchcustomer.index', [
            'details' => $details
        ]);
    }

    public function create() {

        return view('hvl.branchcustomer.create')
                        ->with('branchs', DB::table('Zones')->select('id', 'Name')->get())
                        ->with('customers', DB::table('hvl_customer_master')->get())
                        ->with('employees', DB::table('employees')->select('id', 'Name')->get());
    }

    public function store(Request $request) {
//dd($request);

        $zone_id = $request->zone_id;
        $cust_ids = $request->customer_id;
        $emp_ids = $request->employee_id;
        $branch_ids = $request->branch_id;


        foreach ($branch_ids as $branch_id) {
            foreach ($cust_ids as $key => $cust_id) {
//            $branch_id = DB::table('hvl_customer_master')->whereId($cust_id)->value('branch_name');

                foreach ($emp_ids as $emp) {

                    DB::table('hvl_customer_employees')->updateOrInsert(
                            ['customer_id' => $cust_id, 'employee_id' => $emp]
                    );


                    DB::table('branch_to_customer')
                            ->insert([
                                'zone_id' => $zone_id,
                                'branch_id' => $branch_id,
                                'customer_id' => $cust_id,
                                'employee_id' => $emp
                    ]);
                }
            }
        }
        return redirect('/branch-customer');
    }

    public function get_branch(Request $request) {

        $id = $request->eid;
        $branchs = DB::table('Branch')->where('zone', $id)->get();

        return response()->json($branchs);
    }

    public function branch_customer(Request $request) {
        $ids = $request->eids;
//        $branchs = DB::table('Branch')->where('zone',$id)->get();
//

        foreach ($ids as $id) {
            $data[] = DB::table('hvl_customer_master')
                    ->where('branch_name', '=', $id)
                    ->select('id', 'customer_name')
                    ->get();
        }
//        $details = array_values($data);
//        dd($data);
        return response()->json($data);
    }

    public function edit($id) {
        $branch_id = DB::table('branch_to_customer')->where('zone_id', $id)->get()->groupBy('branch_id');
        $customer_id = DB::table('branch_to_customer')->where('zone_id', $id)->get()->groupBy('customer_id');
        $employee_id = DB::table('branch_to_customer')->where('zone_id', $id)->select('employee_id')->get()->groupBy('employee_id');

        $emp_id = array();
        foreach ($employee_id as $key => $value) {
            $emp_id[] = $key;
        }
        return view('hvl.branchcustomer.edit', [
                            'branch_ids' => $branch_id,
                            'customer_ids' => $customer_id,
                            'employee_ids' => $emp_id,
                            'zone_id' => $id
                        ])
                        ->with('zones', DB::table('Zones')->get())
                        ->with('branchs', DB::table('Branch')->get())
                        ->with('customers', DB::table('hvl_customer_master')->get())
                        ->with('employees', DB::table('employees')->get());
    }

    public function update(Request $request, $id) {

        $zone_id = $request->zone_id;
        $cust_ids = $request->customer_id;
        $emp_ids = $request->employee_id;
        $branch_ids = $request->branch_id;

        DB::table('branch_to_customer')->where('zone_id', $id)->delete();
        foreach ($cust_ids as $key => $cust_id) {
            foreach ($emp_ids as $emp) {

                DB::table('hvl_customer_employees')
                        ->where('customer_id', $cust_id)
                        ->where('employee_id', $emp)
                        ->delete();
            }
        }

        foreach ($branch_ids as $branch_id) {
            foreach ($cust_ids as $key => $cust_id) {
//            $branch_id = DB::table('hvl_customer_master')->whereId($cust_id)->value('branch_name');

                foreach ($emp_ids as $emp) {

                    DB::table('hvl_customer_employees')->updateOrInsert(
                            ['customer_id' => $cust_id, 'employee_id' => $emp]
                    );


                    DB::table('branch_to_customer')
                            ->updateOrInsert([
                                'zone_id' => $zone_id,
                                'branch_id' => $branch_id,
                                'customer_id' => $cust_id,
                                'employee_id' => $emp
                    ]);
                }
            }
        }
        return redirect('/branch-customer');
    }

    public function delete(Request $request) {
        $id = $request->id;
        $customer_id = DB::table('branch_to_customer')->where('zone_id', $id)->select('customer_id')->get();
        foreach ($customer_id as $cust_id) {
            DB::table('hvl_customer_employees')->where('customer_id', $cust_id->customer_id)->delete();
        }
        DB::table('branch_to_customer')->where('zone_id', $id)->delete();
    }

}

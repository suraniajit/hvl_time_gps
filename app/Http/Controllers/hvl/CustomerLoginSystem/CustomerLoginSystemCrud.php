<?php
namespace App\Http\Controllers\hvl\CustomerLoginSystem;
use Auth;
use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// use Illuminate\Support\Facades\DB;
use App\Models\hvl\CustomerMaster;
use Illuminate\Support\Facades\Hash;
use App\Models\hvl\CustomersAdmin;


class CustomerLoginSystemCrud extends Controller {

    
    public function __construct() {

        $this->middleware('permission:Access CustomerAdmin', ['only' => ['show', 'index']]);

        $this->middleware('permission:Create CustomerAdmin', ['only' => ['create']]);

        $this->middleware('permission:Read CustomerAdmin', ['only' => ['read']]);

        $this->middleware('permission:Edit CustomerAdmin', ['only' => ['edit']]);

        $this->middleware('permission:Delete CustomerAdmin', ['only' => ['delete']]);
    }
    public function index() {
        $customers = $this->getAllCustomer();
        $customers_admin = CustomersAdmin::pluck('customers_id','user_id')->toArray();
        $user = User::role('Customers_admin')->get();
        return view('hvl.customer_login_system.index')->with(['users'=>$user,'customers_admins'=>$customers_admin,'customers'=>$customers]);
    }
    
    public function create(){
        $customers = $this->getAllCustomer();
        return view('hvl.customer_login_system.create')->with(['customers'=>$customers]);
    }
    public function store(Request $request){
          $this->validate($request,[
                'customer_admin_name'=>'required',
                'password' => 'required',
                'email'=>'unique:users,email|required|',
                'customer_id'=>'required|array|min:1'
          ]);
         if(!$request->customer_id){
            $request->customer_id=[];
        }
        $user = new User();
        $user->name = $request->customer_admin_name;
        $user->password = Hash::make($request->password);
        $user->email = $request->email;
        $user->save();
        $user->assignRole('Customers_admin');
        $customer_admin = new CustomersAdmin();
        $customer_admin->user_id = $user->id;
        $customer_admin->customers_id = json_encode($request->customer_id);
        $customer_admin->save();
        return redirect()->route('customer.login_system.index')->with('success', 'Record Has Been Inserted'); 
    }
    public function edit($id){
        
        $customers = $this->getAllCustomer();
        
        $custeradmin = CustomersAdmin::where('user_id',$id)
                        ->select(['id'=>'customers_admins.id','customers_id'=>'customers_admins.customers_id','user_id'=>'customers_admins.user_id','name'=>'users.name','email'=>'users.email'])
                        ->join('users','users.id','=','customers_admins.user_id')
                        ->first();
       
        return view('hvl.customer_login_system.edit')->with(['customers'=>$customers,'custeradmin'=> $custeradmin]);
    }
    public function update(Request $request){

         $this->validate($request,[
             'customer_admin_name'=>'required|max:8',
             'email'=>'required|unique:users,email,'. $request->user_id,
             'customer_admin_name'=>'required'
         ]);
        if(!$request->customer_id){
            $request->customer_id=[];
        }
        $user = User::where('id',$request->user_id)->first();
        $user->name = $request->customer_admin_name;
        if(isset($request->password) && ($request->password != null)){
            $user->password = Hash::make($request->password);
        }
        $user->email = $request->email;
        $user->save();
        $customer_admin = CustomersAdmin::where('user_id',$user->id)->first();
       
        $customer_admin->customers_id = json_encode($request->customer_id);
        $customer_admin->save();
        return redirect()->route('customer.login_system.index')->with('success', 'Record Has Been Updated');
    }
    public function massRemove(Request $request){
        $user_ids = $request->input('ids');
        foreach ($user_ids as $id) {
            $user = User::where('id', $id)->get();
            $customer_admin = CustomersAdmin::where('user_id', $id)->get();
            if (count($user) <= 0 or count($customer_admin) <= 0) {
                return response('error');
            } else {
                $Status_Multi_Delete = User::where('id',$id)->delete();
                $Status_Multi_Delete = CustomersAdmin::where('user_id',$id)->delete();
            }
        }
    }
    
    public function removeData(Request $request){
       $id = $request->id;
        $user = User::where('id', $id)->get();
        $customer_admin = CustomersAdmin::where('user_id', $id)->get();
        if (count($user) <= 0 or count($customer_admin) <= 0) {
            return response('error');
        } else {
            $Status_Multi_Delete = User::where('id',$id)->delete();
            $Status_Multi_Delete = CustomersAdmin::where('user_id',$id)->delete();
        }
    }

    public function show($id){
        $customers = $this->getAllCustomer();
        $custeradmin = CustomersAdmin::where('user_id',$id)
                        ->select(['id'=>'customers_admins.id','customers_id'=>'customers_admins.customers_id','user_id'=>'customers_admins.user_id','name'=>'users.name','email'=>'users.email'])
                        ->join('users','users.id','=','customers_admins.user_id')
                        ->first();
        return view('hvl.customer_login_system.show')->with(['customers'=>$customers,'custeradmin'=> $custeradmin]);
        
    }
    public function getAllCustomer(){
        $new_customers = array();
        $customers = CustomerMaster::pluck('customer_name','id')->toArray();
        foreach($customers as $key=>$customer){
            $new_customers[$key] =  preg_replace('/\s\s+/', ' ',$customer); 
        }
        
        
        return $new_customers;
    }
}


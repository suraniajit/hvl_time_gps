<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\User;
use Illuminate\Support\Facades\DB;
use DateTime;
use Carbon\Carbon;
use Auth;
use App\Employee;
use App\Models\hvl\CustomersAdmin;
use App\Models\hvl\LeadMaster;
use App\Helpers\Helper;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index( Request $req)
    {       
        // echo "<pre>";
        // print_r($req->ip());
        // die;
        // $permissons = [
        //     'Access google_drive',
        //     'Read google_drive',
        //     'Create google_drive',
        //     'Edit google_drive',
        //     'Delete google_drive'
        // ];
        // $user = Auth::user();
        // echo "<pre>";
        // print_r($user);
        
        // if($req->ip() =='49.36.58.46'){
        //         $helper = new Helper();
        //         $helper->freshData(8);
        // }
        
        //echo "done";
        // print_r($data);
        //die;
        // $user = Auth::user();
        // foreach ($permissons as $permisson){
        //     Permission::create([
        //         'name'=>$permisson
        //     ]);
        //     $user->givePermissionTo($permisson);
        // }
        // die;
       
        return view('common_dashboard');

    }   
}












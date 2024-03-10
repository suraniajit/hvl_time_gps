<?php

namespace App\Http\Controllers\hvl\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Spatie\Permission\Models\Role;

class BillingController extends Controller
{
    public function index(){
        $role_wise_user_count = array(); 
        $roles = Role::pluck('name','id');
          foreach($roles as $role){
            $users = User::role($role)->get();
            $role_wise_user_count[$role] = 0;
            foreach($users as $user){
                if($user->email == 'probsoltechnology@gmail.com'){
                    continue;
                }
                $employeeCreateDate =  date("Ymd", strtotime($user->created_at)); 
                $todaySystemDate = date("Ymt");
                if($employeeCreateDate <= $todaySystemDate ){
                    $role_wise_user_count[$role] += 1;
                }
            }
        }
            if (!$role_wise_user_count[$role]){
                unset($role_wise_user_count[$role]);
            }
              
        return view('hvl.employee.Billing.index')->with(
            [
                "role_wise_user_count"=>$role_wise_user_count,
                'role_cost'=>$this->getRolePaymentCost($roles),
                'month_list'=>$this->getMonthList(),
                'req_month'=>date("F"),
                'req_year'=>date("Y")
            ]
        );
    }


    public function filters(Request $request){

        $role_wise_user_count = array(); 
        $roles = Role::pluck('name','id');
        foreach($roles as $role){
            $users = User::role($role)->get();
            $role_wise_user_count[$role] = 0;
            foreach($users as $user){
                if($user->employee){
                    if($user->employee->email == 'probsoltechnology@gmail.com'){
                        continue;
                    }
                    $employeeCreateDate =  date("Ymd", strtotime($user->employee->created_at)); 
                    $todaySystemDate = date("Ymt",strtotime("01-".$request->month."-".$request->year));
                    
                    if($employeeCreateDate <= $todaySystemDate ){
                        $role_wise_user_count[$role] += 1;
                    }
                }
            }
            // echo "<pre>";
            // print_r($role_wise_user_count);
            // if (!$role_wise_user_count[$role]){
            //     unset($role_wise_user_count[$role]);
            // }
        }
        // die;
        return view('hvl.employee.Billing.index')->with([
            "role_wise_user_count"=>$role_wise_user_count,
            'role_cost'=>$this->getRolePaymentCost($roles),
            'month_list'=>$this->getMonthList(),
            'req_month'=>$request->month,
            'req_year'=>$request->year
            ]);
        }

        public function getRolePaymentCost($roles){
            foreach($roles as $role){
                $role_cost[$role] = 150;
            }
            $role_cost['administrator']= 700;
            $role_cost['Coordinator'] = 200;
            $role_cost['Demo']=0;
            
            return $role_cost;
        }

        public function getMonthList()
        {
            $months = []; 
            for ($m=1; $m<=12; $m++) {
                $months[date('F', mktime(0,0,0,$m, 1, date('Y')))] = date('F', mktime(0,0,0,$m, 1, date('Y'))) ;
            }
            return $months;
        }
}

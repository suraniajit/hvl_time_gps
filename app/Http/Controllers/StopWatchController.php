<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Illuminate\Routing\Controller;
use App\EmployeesRegister;
use Session;
use App\Helpers\Helper;
use App\EmployeesLocationHistory;
use App\EmployeesCurrentLocation;
use App\Employee;
// use 
class StopwatchController extends Controller{
  
    public function startDay(Request $request){
            $employee = Auth::user()->employee();
            if($employee){
                $employee_id = $employee->first()->id;
                $clock_close_for_today = EmployeesRegister::where('employee_id',$employee_id)
                        ->where('log_date',date('Y-m-d'))
                        ->whereNotNull('start_time')
                        ->where('stop_day','!=',null)
                        ->first();
                if($clock_close_for_today){
                    return redirect()->back()->withErrors('You have already logged out for today Please login again tomorrow to start your day');
                }

                $already_start = EmployeesRegister::where('employee_id',$employee_id)
                        ->where('log_date',date('Y-m-d'))
                        ->whereNotNull('start_time')
                        ->where('end_time','=',null)
                        ->first();
                
                if(!$already_start){
                    $employees_register = new EmployeesRegister();
                    $employees_register->employee_id = $employee_id;
                    $employees_register->log_date= date('Y-m-d');
                    $employees_register->start_time=date('H:i:s');
                    $employees_register->save();
                    $_SESSION["work_start_id"]=$employees_register->id;
                    $_SESSION["clock_enable"] = 'true';
                }else{
                    return redirect()->back()->withErrors('work already started!');
                }
            }else{
                    return redirect()->back()->withErrors('only employee for clock system exist');
            }
            return redirect()->back()->with('success', 'Your logged in successfully to start your day.');
            //add start work session make it start if not and  clock enable session start
    }
    public function pauseDay(Request $request){
        $employee = Auth::user()->employee();
          if($employee){
                $already_start = EmployeesRegister::where('employee_id',$employee->first()->id)
                    ->where('log_date',date('Y-m-d'))
                    ->whereNotNull('start_time')
                    ->where('end_time','=',null)
                    ->first();
                if($already_start){
                    $already_start->end_time=date('H:i:s');
                    $already_start->save();
                }else{
                    return redirect()->back()->withErrors('no timmer running');
                }
                return redirect()->back()->with('success','You have successfully paused your day. Please click on resume to continue work.');
        }else{
            return redirect()->back()->withErrors('only employee for clock system exist');
        }
    }
    public function stopDay(Request $request){
        $employee = Auth::user()->employee();
            if($employee){
                $employee_id = $employee->first()->id;
                $clock_close_for_today = EmployeesRegister::where('employee_id',$employee_id)
                        ->where('log_date',date('Y-m-d'))
                        ->where('stop_day','!=',null)
                        ->first();
                if($clock_close_for_today){
                    return redirect()->back()->withErrors('You have already logged out for today Please login again tomorrow to start your day');
                }
                $stop_timer_watch = EmployeesRegister::where('employee_id',$employee_id)
                    ->where('log_date',date('Y-m-d'))
                    ->where('stop_day','=',null)
                    ->orderBy('id','DESC')
                    ->first();
                if($stop_timer_watch){
                    if(!$stop_timer_watch->end_time){
                        $stop_timer_watch->end_time=date('H:i:s');
                    }
                    $stop_timer_watch->stop_day=date('H:i:s');
                    $stop_timer_watch->save();
                }else{
                    return redirect()->back()->withErrors('Not Found data');
                }
                return redirect()->back()->with('success','You have successfully logged out for the day. Please check your work activity for today');
        }else{
            return redirect()->back()->withErrors('only employee for clock system exist');
        }
    }
    public function getTodayWorkingTime($employee){
        $time_array = EmployeesRegister::select(['id','start_time','end_time','stop_day'])
                        ->where('employee_id',$employee)
                        ->where('log_date',date('Y-m-d'))
                        ->orderBy('id','DESC')
                        ->get();
        $helper = new Helper();
        $total_time = 0;
        $flag =false;
        $flag_for_stop = false;

        foreach($time_array as $time_data){
            if( $time_data->start_time != null){
                if( $time_data->end_time != null){
                    $total_time += $helper->getTotalTime($time_data->start_time,$time_data->end_time);
               }else{
                    $flag =true;
                    $total_time += $helper->getTotalTime($time_data->start_time,date('H:i:s'));
                }
            }
            if($time_data->stop_day != null){
                $flag_for_stop = true;
            }
        }
        $clock_status = null;
        if($flag_for_stop){
            $clock_status = 'stoped';
        }else if($flag){
            $clock_status = 'running';
        }else{
            $clock_status = 'puase';
        }
        return [
            'status'=>'success',
            'data'=>[
                'time'=>$total_time,
                'clock_status'=>$clock_status,
            ]
        ];
        
    }
    public function syncLocation(Request $request){
        $employee = Auth::user()->employee()->first();
        if($employee){
            $employees_location_history = new EmployeesLocationHistory();
            $employees_location_history->employee_id = $employee->id;
            $employees_location_history->location_time = date('H:i:s');
            $employees_location_history->location_date = date('Y-m-d');
            $employees_location_history->lat = $request->latitude;
            $employees_location_history->lang = $request->longitude;
            $employees_location_history->save();
        } 
        $employees_current_location = EmployeesCurrentLocation::updateOrCreate(['employee_id'=>$employee->id]);
        $employees_current_location->employee_id;
        $employees_current_location->location_time = date('H:i:s');
        $employees_current_location->location_date = date('Y-m-d');
        $employees_current_location->lat = $request->latitude;
        $employees_current_location->lang = $request->longitude;
        $employees_current_location->save();
    }
    public function getCurrentEmployeeLocation(){
        $user = Auth::user();
        if($user->hasRole('administrator')){
            $employee_id_array = Employee::pluck('id')->toArray();
        }else{
            $employee = Auth::user()->employee()->first();
            if($employee){
                $employee_id_array = Employee::where('manager_id',$employee->id)->pluck('id')->toArray();
            }
        }
        $employee_current  = new EmployeesCurrentLocation();
        $employee_current_location = $employee_current->whereIN('employee_id',$employee_id_array)
            ->where('employees_current_position.location_date',date('Y-m-d'))
            ->join('employees','employees_current_position.employee_id' ,'employees.id')
            ->select(['employees.Name','location_time','lat','lang'])
        ->get()->toArray();
       
        return view('location.employee_current_location')->with(['employee_current_location'=>$employee_current_location]);
    }
}
<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Illuminate\Routing\Controller;
use Session;
class StopwatchController extends Controller{
  
    public function startTime(){ 
        Session::put('variableName', 11);
        $user = Auth::user();
        echo "<pre>";
        print_r($user);
        die;
    }
    public function stopTime($log_id){ 
        echo 66; die;
    }
       
}












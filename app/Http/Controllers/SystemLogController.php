<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SystemLog;
use Illuminate\Routing\Controller;

class SystemLogController extends Controller{
    public function __construct(){
        $this->middleware('auth');
    }

    public function show(Request $req){ 
        $logs = SystemLog::orderBy('id', 'DESC')->paginate(10);
        return view('log.log',['logs'=>$logs]);
    }
    public function detail($log_id){ 
        $log = SystemLog::where('id',$log_id)->first();
        return view('log.log_detail',['logs'=>$log]);
    }
       
}












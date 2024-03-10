<?php

namespace App\Console\Commands\Hvi;

use Carbon\Carbon;
use Illuminate\Console\Command;
use App\Http\Controllers\hvl\activitymaster\ActivityMasterController;
use Illuminate\Support\Facades\DB;

class MonthlyCall extends Command {

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'MonthlyCall:hiv';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'MonthlyCall: it is only insert fresh data into table for insert and update enty for every calcaution';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle() {
        $today = ActivityMasterController::today_date();
        echo 'it is monthly call';
        $customer_activitys = DB::table('hvl_master_activity')
                        ->select('hvl_master_activity.*')
                        ->where('frequency', '=', 'monthly')
                        ->orderBy('id', 'DESC')->get();

        foreach ($customer_activitys as $key => $activity) {
            $id = $activity->id;
            $master_date = $activity->master_date;
            $customer_id = $activity->customer_id;
            $user_id = $activity->user_id;
            $start_date = $activity->start_date;
            $end_date = $activity->end_date;
            $nextDate = date('Y-m-d', strtotime($start_date . " +30 days"));

            DB::table('hvl_master_activity')->insert([
                'customer_id' => $customer_id,
                'start_date' => $nextDate, 'end_date' => $end_date,
                'status' => 'Not Started',
                'frequency' => 'monthly',
                'master_date' => ActivityMasterController::today_date(),
                'user_id' => $user_id,
                'flag' => 'System'
            ]);
            break;
        }
    }

}

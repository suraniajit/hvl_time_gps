<?php

namespace App\Console\Commands\Hvi;

use Carbon\Carbon;
use Illuminate\Console\Command;
use App\Http\Controllers\recruitment\CandidateController;
use Illuminate\Support\Facades\DB;

class MasterHVI extends Command {

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'MasterHVI:hiv';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'MasterHVI: it is only insert fresh data into table for insert and update enty for every calcaution';

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
        $today = CandidateController::today_date();

//        $delete = $this->get_delete_dublicate($today);
//        if ($delete) {
//            echo 'date is same so values are deleted';
//        }

        $customer_activitys = DB::table('customer_activity')->select('customer_activity.*')->orderBy('id', 'DESC')->get();


        $nextDate = '';
        $i = 0;

        foreach ($customer_activitys as $key => $activity) {

            $id = $activity->id;
            $master_date = $activity->master_date;
            $customer_id = $activity->customer_id;
            $user_id = $activity->user_id;
            $start_date = $activity->start_date;
            $end_date = $activity->end_date;

            if ($activity->frequency == 'bimonthly') {
                echo '****bimonthly****';
                $nextDate = date('Y-m-d', strtotime($start_date . " +60 days"));
                DB::table('customer_activity')->insert([
                    'customer_id' => $customer_id,
                    'start_date' => $nextDate, 'end_date' => $end_date,
                    'status' => 'Not Started',
                    'frequency' => 'bimonthly',
                    'master_date' => CandidateController::today_date(),
                    'user_id' => $user_id,
                    'flag' => 'System'
                ]);
                break;
            }
            if ($activity->frequency == 'quarterly') {
                echo '****quarterly****';
                $nextDate = date('Y-m-d', strtotime($start_date . " +90 days"));
                DB::table('customer_activity')->insert([
                    'customer_id' => $customer_id,
                    'start_date' => $nextDate, 'end_date' => $end_date,
                    'status' => 'Not Started',
                    'frequency' => 'quarterly_twice',
                    'master_date' => CandidateController::today_date(),
                    'user_id' => $user_id,
                    'flag' => 'System'
                ]);
                break;
            }
            if ($activity->frequency == 'quarterly_twice') {
                echo '****quarterly_twice****';
                $nextDate = date('Y-m-d', strtotime($start_date . " +45 days"));
                DB::table('customer_activity')->insert([
                    'customer_id' => $customer_id,
                    'start_date' => $nextDate, 'end_date' => $end_date,
                    'status' => 'Not Started',
                    'frequency' => 'quarterly_twice',
                    'master_date' => CandidateController::today_date(),
                    'user_id' => $user_id,
                    'flag' => 'System'
                ]);
                break;
            }
            if ($activity->frequency == 'thrice_year') {
                echo '****thrice_year****';
                $nextDate = date('Y-m-d', strtotime($start_date . " +120 days"));
                DB::table('customer_activity')->insert([
                    'customer_id' => $customer_id,
                    'start_date' => $nextDate, 'end_date' => $end_date,
                    'status' => 'Not Started',
                    'frequency' => 'thrice_year',
                    'master_date' => CandidateController::today_date(),
                    'user_id' => $user_id,
                    'flag' => 'System'
                ]);
                break;
            }
            if ($activity->frequency == 'daily') {
                echo '<br>' . '-it is daily call*';

                $nextDate = date('Y-m-d', strtotime($start_date . " +1 days"));

//                if ($today == $nextDate) {
                DB::table('customer_activity')->insert([
                    'customer_id' => $customer_id,
                    'start_date' => $nextDate, 'end_date' => $end_date,
                    'status' => 'Not Started',
                    'frequency' => 'daily',
                    'master_date' => CandidateController::today_date(),
                    'user_id' => $user_id,
                    'flag' => 'System'
                ]);
//                } 
                break;
            }

            if ($activity->frequency == 'monthly') {
                echo '**monthly call**';
                $nextDate = date('Y-m-d', strtotime($start_date . " +30 days"));
                DB::table('customer_activity')->insert([
                    'customer_id' => $customer_id,
                    'start_date' => $nextDate, 'end_date' => $end_date,
                    'status' => 'Not Started',
                    'frequency' => 'monthly',
                    'master_date' => CandidateController::today_date(),
                    'user_id' => $user_id,
                    'flag' => 'System'
                ]);
                break;
            }
            if ($activity->frequency == 'onetime') {

                echo '**onetime call**';
                $nextDate = date('Y-m-d', strtotime($start_date . " +365 days"));
                DB::table('customer_activity')->insert([
                    'customer_id' => $customer_id,
                    'start_date' => $nextDate, 'end_date' => $end_date,
                    'status' => 'Not Started',
                    'frequency' => 'onetime',
                    'master_date' => CandidateController::today_date(),
                    'user_id' => $user_id,
                    'flag' => 'System'
                ]);
                break;
            }
        }
    }

    public function OnefortnightlyCall($customer_id, $user_id, $start_date, $end_date, $today) {
//        Fortnightly (Once every 2 weeks based on start date)
    }

    public function OneBimonthlyCall($customer_id, $user_id, $start_date, $end_date, $today) {
//        (Once every 2 months based on start date) - 60days
    }

    public function OneQuarterlyCall($customer_id, $user_id, $start_date, $end_date, $today) {
//        Quarterly (Once every 3 weeks based on start date) - 90 days
    }

    public function OneQuarterlytwiceCall($customer_id, $user_id, $start_date, $end_date, $today) {
//Quarterly twice (Once every 45 days based on start date) -45  days
    }

    public function OnethriceCall($customer_id, $user_id, $start_date, $end_date, $today) {
//Thrice in a Year.(Once every 4 months based on start date) -120 days
//        $start_date = date_create("2020-04-26");
        $start_date = date_create($start_date);
        $today_date = date_create($today);
        $diff = date_diff($start_date, $today_date);
        echo $d = $diff->format("%a");

        if ($d >= 120) {
            echo 'one year done';
            DB::table('customer_activity')->insert([
                'customer_id' => $customer_id,
                'start_date' => CandidateController::today_date(),
//            'end_date' => $end_date,
                'status' => 'Not Started',
                'frequency' => 'thrice_year',
                'master_date' => CandidateController::today_date(),
                'user_id' => $user_id
            ]);
        } else {
            echo 'not done';
        }
    }

    public function OneTimeCall($customer_id, $user_id, $start_date, $end_date, $today) {

//One Time (Once every year based on start date) -days 365
//        $start_date = date_create("2020-04-26");
        $start_date = date_create($start_date);
        $today_date = date_create($today);
        $diff = date_diff($start_date, $today_date);
        echo $d = $diff->format("%a");

        if ($d >= 365) {
            echo 'one year done';
            DB::table('customer_activity')->insert([
                'customer_id' => $customer_id,
                'start_date' => CandidateController::today_date(),
//            'end_date' => $end_date,
                'status' => 'Not Started',
                'frequency' => 'onetime',
                'master_date' => CandidateController::today_date(),
                'user_id' => $user_id
            ]);
        } else {
            echo 'not done';
        }
    }

    public function monthlycall($customer_id, $user_id, $start_date, $end_date) {
        
    }

    public function weeklycall($customer_id, $user_id, $start_date, $end_date) {
        
    }

    public function dailycall($customer_id, $user_id, $start_date, $end_date) {
        $insert = DB::table('customer_activity1')->insert([
            'customer_id' => $customer_id,
            'start_date' => CandidateController::today_date(),
//            'end_date' => $end_date,
            'status' => 'Not Started',
            'frequency' => 'daily',
            'master_date' => CandidateController::today_date(),
            'user_id' => $user_id,
            'flag' => 'System'
        ]);
    }

    public function get_delete_dublicate($date) {
        return DB::table('customer_activity')
                        ->where('customer_activity.master_date', '=', $date)
                        ->where('customer_activity.start_date', '=', $date)
                        ->delete();
    }

}

<?php

namespace App\Console\Commands\expance;

use Carbon\Carbon;
use Illuminate\Console\Command;
use App\Http\Controllers\hvl\activitymaster\ActivityMasterController;
use Illuminate\Support\Facades\DB;
use Mail;

class ManagerPendingApproval extends Command {

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ManagerPendingApproval:daily';

//    artisan ManagerPendingApproval:daily

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'ManagerPendingApproval: Send email to Manager for a list of expenses pending approval (Daily basis 8 am)';

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
die();
        $today_date = Carbon::today()->format('Y-m-d');

        $pendding_list = DB::table('api_expenses')
                ->select('api_expenses.*', 'api_expenses.id as exp_id')
                ->where('api_expenses.is_save', '=', 1)
//                    ->whereIn('api_expenses.is_user', [1395, 1401])
                ->where('api_expenses.payment_status_id', '=', null)
                ->whereIn('is_process', [0])
                ->groupBy('api_expenses.is_user')
                ->get();
        $emp_Array = $pendding_list_ = [];
        foreach ($pendding_list as $key => $pendding_data) {
            $manager_id = app('App\Http\Controllers\Controller')->getConditionDynamicNameTable('employees', 'user_id', $pendding_data->is_user, 'manager_id');
            $manager_email = app('App\Http\Controllers\Controller')->getConditionDynamicNameTable('employees', 'user_id', $manager_id, 'email');
            $emp_name = app('App\Http\Controllers\Controller')->getConditionDynamicNameTable('employees', 'user_id', $pendding_data->is_user, 'Name');
//            echo '(' . $emp_name . ') is_user ' . $pendding_data->is_user . ' - manager_id ' . $manager_id . '- manager_email ' . $manager_email;
//            echo '<br>';
//                    $emp_Array[] = $manager_id; // manager id
            $emp_Array[] = $pendding_data->is_user;
        }
        foreach ($emp_Array as $kry => $send_data) {

            $manager_id = app('App\Http\Controllers\Controller')->getConditionDynamicNameTable('employees', 'user_id', $send_data, 'manager_id');
            $manager_email = app('App\Http\Controllers\Controller')->getConditionDynamicNameTable('employees', 'user_id', $manager_id, 'email');
            $emp_name = app('App\Http\Controllers\Controller')->getConditionDynamicNameTable('employees', 'user_id', $send_data, 'Name');

            $manager_list_ = DB::table('employees')
                            ->where('manager_id', '=', $send_data)
                            ->pluck('employees.user_id')->toArray();

            $pendding_list_count = DB::table('api_expenses')
                    ->select('api_expenses.spent_at',
                            'api_expenses.id',
                            'api_expenses.is_user',
                            'api_expenses.combination_name',
                            'api_expenses.date_of_expense_cash',
                    )
                    ->where('api_expenses.is_save', '=', 1)
                    ->whereIn('is_process', [0])
                    ->where('api_expenses.payment_status_id', '=', null)
//                            ->where('api_expenses.is_user', '=', $send_data)
                    ->whereIn('api_expenses.is_user', $manager_list_)
                    ->get();
            if (count($pendding_list_count) > 0) {
                $first_flowup = array(
                    'employee_name' => app('App\Http\Controllers\Controller')->getConditionDynamicNameTable('employees', 'user_id', $manager_id, 'Name'),
                    'email' => 'hiteshv253@gmail.com',
//                    'email' => 'sapan@probsoltech.com',
//                    'email' => $manager_email,
                    'admin_email' => "helpdesk@hvlpestservice s.com",
                    'from_email' => "helpdesk@hvlpestservices.com",
//                    'title' => 'Pendding Action from Manager Approval :: ' . $manager_email,
                    'title' => 'HVL Pest Control Services',
                    'subject' => 'Expense Management - Pending Action',
                    'body' => ''
                );
                Mail::send('emails.ManagerPendingApproval', ['manager_list_' => $manager_list_, 'first_flowup' => $first_flowup], function ($message) use ($first_flowup) {
                    $message->to($first_flowup['email'], '' . $first_flowup['employee_name'])
//                        ->cc($first_flowup['admin_email'])
//                        ->bcc($bccEmails)
                            ->subject($first_flowup['subject']);
                    $message->from($first_flowup['from_email'], $first_flowup['title']);
                });
            }
        }
        \Log::info("Cron is working fine!");
        $this->info('Demo:Cron Cummand Run successfully!');
    }

}

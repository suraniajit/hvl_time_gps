<style>
    .card-stats-title{
        color: black !important;
        font-weight: 700;
    }
</style>
<div class="card-content">
    <div id="card-stats" class="row">
        <div class="col s3 m3 x13">
            <div class="card" style="    background-color :#1B78AF	;">
                <div class="card-content cyan white-text" style="margin-top: 10px;margin-left: 18px;">
                    <p class="card-stats-title">Total Claim Amount</p>
                    <h4 class="card-stats-number white-text">
                        <?php
                        echo 'INR ' . DB::table('api_expenses')
                                ->where('is_active', '=', 0)
//                                ->where('is_save', '=', 1)
                                ->where('is_user', '=', Auth::id())
                                ->sum('def_claim_amount');

                        //app('App\Http\Controllers\Controller')->get_sum_of_data('api_expenses', 'is_user', Auth::id(), 'total_amount_cash'); 
                        ?>
                    </h4>
                </div>
                <div class="card-action green">
                    <div class="row">
                        <div id="invoice-line" class="center-align"><canvas width="264" height="25" style="display: inline-block; width: 264.175px; height: 25px; vertical-align: top;"></canvas></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col s3 m3 x13" style="display: none;">
            <div class="card" style="    background-color :#DFE1E0;">
                <div class="card-content cyan white-text" style="margin-top: 10px;margin-left: 18px;">
                    <p class="card-stats-title">Total Submitted Amount</p>
                    <h4 class="card-stats-number white-text">
                        <?php
                        echo 'INR ' . DB::table('api_expenses')
                                ->where('is_active', '=', 0)
                                ->where('is_user', '=', Auth::id())
//                                ->whereIn('is_process', [0, 3])
                                ->where('is_save', '!=', 2)
                                ->sum('def_claim_amount');

                        //app('App\Http\Controllers\Controller')->get_sum_of_data('api_expenses', 'is_user', Auth::id(), 'settlement_amount'); 
                        ?>
                    </h4>
                </div>
                <div class="card-action green">
                    <div class="row">
                        <div id="invoice-line" class="center-align"><canvas width="264" height="25" style="display: inline-block; width: 264.175px; height: 25px; vertical-align: top;"></canvas></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col s3 m3 x13">
            <div class="card" style="    background-color :#def4e3	;">
                <div class="card-content cyan white-text" style="margin-top: 10px;margin-left: 18px;">
                    <p class="card-stats-title">Total Settled Amount</p>
                    <h4 class="card-stats-number white-text">
                        <?php
                        $to1 = $to2 = 0;
                        $to1 = DB::table('api_expenses')
                                ->where('is_active', '=', 0)
                                ->where('is_user', '=', Auth::id())
                                ->where('is_process', '=', 3)
                                ->where('is_resubmit', '=', 0)
                                ->where('payment_status_id', '=', 4)
                                ->sum('settlement_amount'); 
                        $to2 = DB::table('api_expenses_resubmit')
                                ->where('is_user', '=', Auth::id())
                                ->sum('account_settlement_amount');
                    

                        echo 'INR ' . ($to1 + $to2);
//app('App\Http\Controllers\Controller')->get_sum_of_data('api_expenses', 'is_user', Auth::id(), 'settlement_amount'); 
                        ?>
                    </h4>
                </div>
                <div class="card-action green">
                    <div class="row">
                        <div id="invoice-line" class="center-align"><canvas width="264" height="25" style="display: inline-block; width: 264.175px; height: 25px; vertical-align: top;"></canvas></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col s3 m3 x13">
            <div class="card" style="    background-color :#f0ecff	;">
                <div class="card-content cyan white-text" style="margin-top: 10px;margin-left: 18px;">
                    <p class="card-stats-title">Total Drafted Amount</p>
                    <h4 class="card-stats-number white-text">
                        <?php echo 'INR ' . app('App\Http\Controllers\Controller')->get_sum_of_data('api_expenses', 'is_user', Auth::id(), 'claim_amount', '2');
                        ?>
                    </h4> 
                </div>
                <div class="card-action orange">
                    <div class="row">
                        <div id="profit-tristate" class="center-align"><canvas width="227" height="25" style="display: inline-block; width: 227px; height: 25px; vertical-align: top;"></canvas></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col s3 m3 x13">
            <div class="card" style="    background-color :#D28782;">
                <div class="card-content cyan white-text" style="margin-top: 10px;margin-left: 18px;">
                    <p class="card-stats-title">Total Rejected Amount</p>
                    <h4 class="card-stats-number white-text">
                        <?php
                        echo 'INR ' . DB::table('api_expenses')
                                ->where('is_active', '=', 0)
                                ->where('is_user', '=', Auth::id())
//                                    ->where('is_resubmit_expance_id', '!=', 0)
//                                ->where('is_save', '=', 3)
                                ->whereIn('is_process', [2, 3, 4, 12, 11])
                                ->sum('reject_amount');
                        ?>

                    </h4>
                </div>
                <div class="card-action red">
                    <div class="row">
                        <div id="sales-compositebar" class="center-align"><canvas width="227" height="25" style="display: inline-block; width: 227px; height: 25px; vertical-align: top;"></canvas></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col s3 m3 x13">
            <div class="card" style="    background-color :#EBC678;">
                <div class="card-content cyan white-text" style="margin-top: 10px;margin-left: 18px;">
                    <p class="card-stats-title">Total Resubmit Amount</p>
                    <h4 class="card-stats-number white-text">
                        <?php
                        echo 'INR ' . DB::table('api_expenses')
                                ->where('is_active', '=', 0)
                                ->where('is_user', '=', Auth::id())
                                ->where('is_resubmit', '!=', 0)
                                ->where('is_save', '=', 1)
                                ->whereIn('is_process', [0])
                                ->sum('claim_amount');

//echo 'INR ' . app('App\Http\Controllers\Controller')->get_sum_of_data('api_expenses', 'is_user', Auth::id(), 'reject_amount'); 
                        ?>
                    </h4>
                </div>
                <div class="card-action red">
                    <div class="row">
                        <div id="sales-compositebar" class="center-align"><canvas width="227" height="25" style="display: inline-block; width: 227px; height: 25px; vertical-align: top;"></canvas></div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

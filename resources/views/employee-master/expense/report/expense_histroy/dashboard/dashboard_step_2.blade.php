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
                    <p class="card-stats-title">Total Claim Amount step-2</p>
                    <h4 class="card-stats-number white-text">
                        <?php
                        if (isset($to_date)) {
                            echo 'INR ' . DB::table('api_expenses')
                                    ->where('is_active', '=', 0)
                                    ->whereIn('is_process', [3])
                                    ->whereIn('payment_status_id', [4])
                                    ->where('is_user', '=', $emp_id)
                                    ->whereBetween('api_expenses.account_action_date', [$from_date, $to_date])
                                    ->sum('def_claim_amount');
                        } else {
                            echo 'INR ' . DB::table('api_expenses')
                                    ->where('is_active', '=', 0)
                                    ->whereIn('is_process', [3])
                                    ->whereIn('payment_status_id', [4])
                                    ->where('is_user', '=', $emp_id)
                                    ->sum('def_claim_amount');
                        }
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
                        if (isset($to_date)) {
                            $to1 = DB::table('api_expenses')
                                    ->where('is_active', '=', 0)
                                    ->where('is_user', '=', $emp_id)
                                    ->whereIn('is_process', [3, 12])
                                    ->whereIn('payment_status_id', [4])
                                    ->whereBetween('api_expenses.account_action_date', [$from_date, $to_date])
                                    ->sum('settlement_amount');
                        } else {

                            $to1 = DB::table('api_expenses')
                                    ->where('is_active', '=', 0)
                                    ->where('is_user', '=', $emp_id)
                                    ->whereIn('is_process', [3, 12])
                                    ->whereIn('payment_status_id', [4])
                                    ->sum('settlement_amount');
                        }

                        echo 'INR ' . ($to1);
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
            <div class="card" style="    background-color :#D28782;">
                <div class="card-content cyan white-text" style="margin-top: 10px;margin-left: 18px;">
                    <p class="card-stats-title">Total Rejected Amount</p>
                    <h4 class="card-stats-number white-text">
                        <?php
                        if (isset($to_date)) {
                            echo 'INR ' . DB::table('api_expenses')
                                    ->where('is_active', '=', 0)
                                    ->where('is_user', '=', $emp_id)
                                    ->whereIn('is_process', [3, 12])
                                    ->whereIn('payment_status_id', [4])
                                    ->whereBetween('api_expenses.account_action_date', [$from_date, $to_date])
                                    ->sum('reject_amount');
                        } else {

                            echo 'INR ' . DB::table('api_expenses')
                                    ->where('is_active', '=', 0)
                                    ->where('is_user', '=', $emp_id)
                                    ->whereIn('is_process', [3, 12])
                                    ->whereIn('payment_status_id', [4])
                                    ->sum('reject_amount');
                        }
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

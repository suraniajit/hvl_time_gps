<style>
    .card-stats-title{
        color: black !important;
        font-weight: 700;
    }
</style>
<div class="card-content">
    <h4 class="modal-title">REPORT DETAILS</h4>
    <div class="card">
        <div id="card-stats" class="row">
            <div class="col s4 m4 x13">
                <div class="card-content cyan white-text" style="margin-top: 10px;margin-left: 18px;">
                    <p class="card-stats-title">
                        Employee Name : {{$em_name_account}}
                        <?php // echo Auth::id(); ?><br>
                        <?php // echo $account_detaile->user_id; ?><br>
                        <?php echo 'Report Submission Date : ' . $account_detaile->combination_submit_date; ?><br>
                        
                    </p>
                </div>
                <div class="card-content cyan white-text" style="margin-top: 10px;margin-left: 18px;">
                    <p class="card-stats-title">
                        <?php echo 'Report Name : ' . $account_detaile->combination_name;
                        ?><br>

                    </p>
                </div>
            </div>

            <div class="col s3 m3 x13" style="display: none;">
                <div class="card-content cyan white-text" style="margin-top: 10px;margin-left: 18px;">
                    <p class="card-stats-title">
                        <span style="color: green";>
                            <?php
                            $claim_amount = DB::table('api_expenses')
                                    ->where('is_active', '=', 0)
                                    // ->where('is_process', '=', 0)
                                    ->where('combination_name', '=', $account_detaile->combination_name)
//                                    ->where('is_save', '=', 1)
//                                    ->sum('total_amount_cash');
                                    ->sum('def_claim_amount');
                            if ($claim_amount == 0) {
                                $claim_amount = DB::table('api_expenses')
                                        ->where('is_active', '=', 0)
                                        // ->where('is_process', '=', 0)
                                        ->where('combination_name', '=', $account_detaile->combination_name)
//                                    ->where('is_save', '=', 1)
                                        ->sum('settlement_amount');
                            }
                            echo 'Total Claim Amount : INR ' . $claim_amount;
                            ?><br>


                        </span>
                    </p>
                </div>
            </div>
            <div class="col s3 m3 x13" style="display: none;">
                <div class="card-content cyan white-text" style="margin-top: 10px;margin-left: 18px;">
                    <p class="card-stats-title">
                        <span style="color: blue";>
                            <?php
                            if ($account_detaile->is_resubmit == 1) {
                                $settlement_amount = DB::table('api_expenses_resubmit')
                                                ->where('expance_id', '=', $account_detaile->id)
                                                ->where('is_user', '=', Auth::id())->sum('account_settlement_amount');
                            } else {
                                $settlement_amount = DB::table('api_expenses')
                                        ->where('is_active', '=', 0)
                                        // ->where('is_process', '=', 0)
                                        ->where('combination_name', '=', $account_detaile->combination_name)
//                                    ->where('is_save', '=', 1)
                                        ->sum('settlement_amount');
                            }
                            echo 'Total Settlement Amount : INR ' . $settlement_amount;
                            ?>
                        </span>
                        <br>
                        <span style="color: red";>
                            <?php
                            $reject_amount = DB::table('api_expenses')
                                    ->where('is_active', '=', 0)
                                    // ->where('is_process', '=', 0)
                                    ->where('combination_name', '=', $account_detaile->combination_name)
//                                    ->where('is_save', '=', 1)
                                    ->sum('reject_amount');

                            if ($claim_amount == 0) {
                                echo 'Total Reject Amount : INR ';
                            } else {
                                echo 'Total Reject Amount : INR ' . ($claim_amount - $settlement_amount);
                            }
                            ?>
                        </span>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

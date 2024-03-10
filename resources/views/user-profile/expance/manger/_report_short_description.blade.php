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
                        Employee Name : {{ucfirst($em_name_manager)}}<br>
                        <?php // echo Auth::id(); ?><br>
                        <?php // echo $expances_details->user_id; ?>

                        <?php echo 'Report Submission Date : ' . $expances_details->combination_submit_date; 
                        //$expances_details->created_at;
                        ?><br>
                    </p>
                </div>
                <div class="card-content cyan white-text" style="margin-top: 10px;margin-left: 18px;">
                    <p class="card-stats-title">
                        <?php echo 'Report Name : ' . $expances_details->combination_name; ?><br>
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
                                    ->where('combination_name', '=', $expances_details->combination_name)
                                    //->where('is_save', '=', 1)
                                    ->sum('def_claim_amount');
                            echo 'Total Claim Amount : INR ' . $claim_amount;
                            ?><br>
                            <?php
//                            echo '**' . $expances_details->is_process;
//                            if ($expances_details->is_process == '12') {
//                                echo 'this is Resubmit employee';
//                            }
                            ?>
                        </span>
                    </p>
                </div>
            </div>

            <div class="col s3 m3 x13"  style="display: none;">
                <div class="card-content cyan white-text" style="margin-top: 10px;margin-left: 18px;">
                    <p class="card-stats-title">
                        <span style="color: blue";>
                            <?php
                            if ($expances_details->is_resubmit == 1) {
                                $settlement_amount = DB::table('api_expenses_resubmit')
                                                ->where('expance_id', '=', $expances_details->id)
                                                ->where('is_user', '=', Auth::id())->sum('account_settlement_amount');
                            } else {
                                $settlement_amount = DB::table('api_expenses')
                                        ->where('is_active', '=', 0)
                                        // ->where('is_process', '=', 0)
                                        ->where('combination_name', '=', $expances_details->combination_name)
                                        ->where('is_save', '=', 1)
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
                                    ->where('combination_name', '=', $expances_details->combination_name)
                                    ->where('is_save', '=', 1)
                                    ->sum('reject_amount');
                            echo 'Total Reject Amount : INR ' . $reject_amount;
                            ?><br>
                        </span>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
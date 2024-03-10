<style>
    .card-stats-title{
        color: black !important;
        font-weight: 700;
    }
</style>
<div class="card-content">
    <div id="card-stats" class="row">
        <div class="col s3 m3 x13">
            <div class="card" style="    background-color :green;">
                <div class="card-content cyan white-text" style="margin-top: 10px;margin-left: 18px;">
                    <p class="card-stats-title">Total Submitted Amount</p>
                    <h4 class="card-stats-number white-text">
                        <?php echo 'INR ' . app('App\Http\Controllers\Controller')->get_all_sum_of_data('api_expenses', 'claim_amount'); ?>
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
            <div class="card" style="    background-color :gray;">
                <div class="card-content cyan white-text" style="margin-top: 10px;margin-left: 18px;">
                    <p class="card-stats-title">Total Drafted Amount</p>
                    <h4 class="card-stats-number white-text">
                        <?php echo 'INR ' . app('App\Http\Controllers\Controller')->get_all_sum_of_data('api_expenses', 'claim_amount', '2');
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
            <div class="card" style="    background-color :blueviolet;">
                <div class="card-content cyan white-text" style="margin-top: 10px;margin-left: 18px;">
                    <p class="card-stats-title">Total Approved Amount</p>
                    <h4 class="card-stats-number white-text">
                        <?php echo 'INR ' . app('App\Http\Controllers\Controller')->get_all_sum_of_data('api_expenses', 'settlement_amount'); ?>

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
            <div class="card" style="    background-color :red;">
                <div class="card-content cyan white-text" style="margin-top: 10px;margin-left: 18px;">
                    <p class="card-stats-title">Total Rejected Amount</p>
                    <h4 class="card-stats-number white-text">
                        <?php echo 'INR ' . app('App\Http\Controllers\Controller')->get_all_sum_of_data('api_expenses', 'reject_amount'); ?>
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



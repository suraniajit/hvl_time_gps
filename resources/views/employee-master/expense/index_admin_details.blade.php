@include('employee-master.expense.admin_filter.dashboard.report_dashboard')
<!--include('employee-master.expense.admin_filter.dashboard.master_dashboard')-->
<div class="tabs">
    <ul id="tabs-nav">
        <li><a href="#tab2" class="active">All Expenses</a></li>
        <li><a href="#tab1">Expenses by Report <?php echo $emp_id; ?></a></li>
        <li><a href="#tab3">Submitted Expenses</a></li>
        <li><a href="#tab4">Drafted Expenses</a></li>
        <li><a href="#tab5">Approved Expenses</a></li>
    </ul> <!-- END tabs-nav -->
    <div id="tabs-content">
        <div id="tab2" class="tab-content">
            <h2>All Expenses
                <span style="font-size: 10px;">
                    <?php
                    echo 'INR ' . DB::table('api_expenses')
                            ->where('is_active', '=', 0)
                            ->where('is_user', '=', $emp_id)
//                                ->whereIn('is_process', [0, 3])
                            ->where('is_save', '!=', 2)
                            ->sum('def_claim_amount');
                    ?>
                </span>
            </h2>
            @include('employee-master.expense.admin_filter.all')
        </div>
        <div id="tab1" class="tab-content">
            <h2>Expenses by Report</h2>
            @include('employee-master.expense.admin_filter.combination')
        </div>
        
        <div id="tab3" class="tab-content">
            <h2>Submitted Expenses


            </h2>
            @include('employee-master.expense.admin_filter.submit')        
        </div>
        <div id="tab4" class="tab-content">
            <h2>Drafted Expenses
                <span style="font-size: 10px;">
                    <?php echo ': INR ' . app('App\Http\Controllers\Controller')->get_sum_of_data('api_expenses', 'is_user', $emp_id, 'claim_amount', '2'); ?>
                </span>
            </h2>
            @include('employee-master.expense.admin_filter.draft')
        </div>
        <div id="tab5" class="tab-content">
            <h2>Approved Expenses

                <span style="font-size: 10px;">
                    <?php
                    $to1 = $to2 = 0;
                    $to1 = DB::table('api_expenses')
                            ->where('is_active', '=', 0)
                            ->where('is_user', '=', $emp_id)
                            ->where('is_process', '=', 3)
                            ->where('is_resubmit', '=', 0)
                            ->where('payment_status_id', '=', 4)
                            ->sum('settlement_amount');
//                    $to2 = DB::table('api_expenses_resubmit')
//                            ->where('is_user', '=', $emp_id)
//                            ->sum('account_settlement_amount');

                    echo 'INR ' . ($to1 + $to2);
                    ?>
                </span>
            </h2>
            @include('employee-master.expense.admin_filter.complied')
        </div>
    </div>
</div>

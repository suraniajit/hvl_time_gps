<div class="card-panel">
    <?php
    if (isset($to_date)) {
        $account_expances = DB::table('employees')
                ->select('employees.user_id as user_id',
                        'api_expenses.id',
                      
                        'api_expenses.is_save',
                        'api_expenses.is_process',
                        'api_expenses.is_resubmit',
                        'api_expenses.is_resubmit_expance_id',
                        'api_expenses.payment_status_id',
                        'api_expenses.claim_amount',
                        'api_expenses.reject_amount',
                        'api_expenses.total_amount_cash',
                        'api_expenses.combination_name',
                        'api_expenses.combination_submit_date',
                    'api_expenses.combination_name_temp',
                        'api_expenses.settlement_amount',
                        'api_expenses.acount_settl_amount',
                        'api_expenses.manger_settl_amount',
                        'api_expenses.action_by_user_id',
                        'api_expenses.date_search',
                        'api_expenses.currency',
                        'api_expenses.expense_type',
                        'api_expenses.spent_at',
                        'api_expenses.date_of_expense_cash',
                        'api_expenses.payment_status_id',
                        'api_expenses.created_at',
                        'api_expenses.is_notified')
                ->where('employees.account_id', '=', Auth::id())
                //->where('api_expenses.is_save', '=', 1)
                ->whereNotIn('is_process', [0, 2, 3, 4,12])
//                ->whereIn('is_process', [1])
                ->whereBetween('api_expenses.combination_submit_date', [$to_date, $from_date])
                ->join('api_expenses', 'api_expenses.is_user', '=', 'employees.user_id')
                ->groupBy('api_expenses.combination_name')
                ->orderBy('api_expenses.date_search', 'desc')
                ->get();
    } else {
        $account_expances = DB::table('employees')
                ->select('employees.user_id as user_id',
                        'api_expenses.id',
                        'api_expenses.is_save',
                        'api_expenses.is_process',
                        'api_expenses.is_resubmit',
                        'api_expenses.is_resubmit_expance_id',
                        'api_expenses.payment_status_id',
                        'api_expenses.claim_amount',
                        'api_expenses.reject_amount',
                        'api_expenses.total_amount_cash',
                        'api_expenses.combination_name',
                        'api_expenses.combination_submit_date',
                        'api_expenses.combination_name_temp',
                        'api_expenses.settlement_amount',
                        'api_expenses.acount_settl_amount',
                        'api_expenses.manger_settl_amount',
                        'api_expenses.action_by_user_id',
                        'api_expenses.date_search',
                        'api_expenses.currency',
                        'api_expenses.expense_type',
                        'api_expenses.spent_at',
                        'api_expenses.date_of_expense_cash',
                        'api_expenses.payment_status_id',
                        'api_expenses.created_at',
                        'api_expenses.is_notified')
                ->where('employees.account_id', '=', Auth::id())
                //->where('api_expenses.is_save', '=', 1)
                ->whereNotIn('is_process', [0, 2, 3, 4,12])
//                ->whereIn('is_process', [1])
                ->join('api_expenses', 'api_expenses.is_user', '=', 'employees.user_id')
                ->groupBy('api_expenses.combination_name')
                ->orderBy('api_expenses.date_search', 'desc')
                ->get();
    }
    ?>
    <div>

        <div style="text-align:center;">
            <div class="table-responsive">
                <table id="page-length-option_account" class="table table-striped table-hover multiselect">
                    <thead>
                        <tr>
                            <th>#ID</th>
                            <th>Employee Name</th>
                            <th>Report Name</th>
                            <th>Action</th>
                            <!--<th>Process status</th>-->
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($account_expances as $key => $account_detaile) {
                            $em_name_account = app('App\Http\Controllers\Controller')->getConditionDynamicNameTable('employees', 'user_id', $account_detaile->user_id, 'name');
                            $getCountValueFromTable = DB::table('api_expenses')->where('is_user', '=', $account_detaile->user_id)->where('combination_name', '=', $account_detaile->combination_name)->count();
                            ?>
                            <tr>
                                <td width="2%"> <center>{{$key+=1}}</center> </td>
                        <td>
                            <a href="{{ route('expense_report.search_by_employee', $account_detaile->user_id) }}" style="font-weight: 800;" target="_blank">
                                <?php echo $em_name_account; ?>
                            </a>
                        </td>
                        <td>
                            <?php
                            if (isset($account_detaile->combination_name)) {
                                echo $account_detaile->combination_name;
                            } else {
                                echo $account_detaile->combination_name;
                            }
                            ?>
                        </td>
                        <td>

                          

                            <?php
                            $expances_account_comi_ = DB::table('employees')
                                    ->select('employees.user_id as user_id', 'api_expenses.*')
                                    ->where('api_expenses.combination_name', '=', $account_detaile->combination_name)
                                    ->whereIn('is_process', [0, 1, 11])
                                    ->whereNotIn('is_process', [4])
                                    ->where('employees.account_id', '=', Auth::id())
                                    ->join('api_expenses', 'api_expenses.is_user', '=', 'employees.user_id')
                                    ->orderBy('api_expenses.date_search', 'desc')
                                    ->get();
                            ?>
                            <?php
//                            
//                            echo count($expances_account_comi_);
                            if (count($expances_account_comi_) != 0) {
                                ?>
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#moda_action_account{{$account_detaile->id}}">
                                    Pending Action (<?php echo count($expances_account_comi_); ?>)
                                </button>
                                <?php
                            }
                            ?>


                            <!-- The Modal -->
                            <div class="modal pop_" id="moda_action_account{{$account_detaile->id}}">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <form method="POST" enctype="multipart/form-data" id="formEditValidateManager" action="{{ route('expense.multi_updateByAcount', $account_detaile->id) }}" onsubmit="return(frmLoaderAcount());">
                                            <!-- Modal Header -->
                                            <div class="modal-header">
                                                <h4 class="modal-title">
                                                    Account Action
                                                </h4>
                                                <button type="button" class="close" onclick="closer(moda_action_account{{$account_detaile->id}})">&times;</button>
                                            </div>

                                            <!-- Modal body -->
                                            <div class="modal-body">
                                                <div class="table-responsive">
                                                    <table id="page-length-option_account" class="table table-striped table-hover multiselect">
                                                        @include('user-profile.expance.account._else_head_account')
                                                        <tbody>
                                                            <?php
                                                            $expances_account_comi_update = DB::table('employees')
                                                                    ->select('employees.user_id as user_id', 'api_expenses.*')
                                                                    // ->where('api_expenses.is_process', '!=', 2)
                                                                    ->where('employees.account_id', '=', Auth::id())
                                                                    ->where('api_expenses.combination_name', '=', $account_detaile->combination_name)
                                                                    //->whereNotIn('is_process', [2,12])
                                                                    ->whereNotIn('is_process', [2, 4, 12])
                                                                    ->join('api_expenses', 'api_expenses.is_user', '=', 'employees.user_id')
                                                                    ->orderBy('api_expenses.date_search', 'desc')
                                                                    ->get();

                                                            foreach ($expances_account_comi_update as $key => $account_detaile) {
                                                                ?>
                                                                <?php if (($account_detaile->is_process == '3') || ($account_detaile->is_process == '0') || ($account_detaile->is_process == '5') || ($account_detaile->is_process == '6')) { ?>

                                                                    <?php
                                                                } else {
                                                                    ?>
                                                                <input type="hidden" name="expances_ids[]" value="{{$account_detaile->id}}">
                                                                @include('user-profile.expance.account._else_account_details')
                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                        <?php // if (($account_detaile->is_process == '3') || ($account_detaile->is_process == '0') || ($account_detaile->is_process == '5') || ($account_detaile->is_process == '6')) { ?>
                                                        <!--                                                            <div style="font-size: 18px;
                                                                                                                         font-weight: 700;
                                                                                                                         text-align: center;
                                                                                                                         margin: 25px;">
                                                                                                                        Some Action Pending from Manager
                                                                                                                    </div>-->
                                                        <?php // } ?>
                                                        </tbody>
                                                    </table>

                                                </div>
                                            </div>

                                            <!-- Modal footer -->
                                            <div class="modal-footer">

                                                <button class="btn btn-danger mr-1" type="submit">Update Action</button>
                                             </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                        <!--</td>-->
                        <!--<td style="padding-top: 21px;" style="display: none;">-->
                            <?php // if ($account_detaile->is_process == 0) { ?>
                                <!--<span style="font-weight: 800;color: green;">Expense Create by Employee</span>-->
                            <?php // } else if ($account_detaile->is_process == 11) { ?>
                                <!--<span style="font-weight: 800;color: blue;"> Partially Approved from Manager</span>-->
                            <?php // } else if ($account_detaile->is_process == 3) { ?>
                                <!--<span style="font-weight: 800;color: green;">Accepted from Account</span>-->
                            <?php // } else if ($account_detaile->is_process == 1) { ?>
                                <!--<span style="font-weight: 800;color: green;">Accepted from Manager</span>-->
                            <?php // } ?>
                        <!--</td>-->
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>




<script type="text/javascript">
    $(document).ready(function () {
    $('#page-length-option_account').DataTable({
    "scrollX": true
    });
    });
      function frmLoaderAcount() {
     $("#load").css({"visibility": ""});
    }
</script>

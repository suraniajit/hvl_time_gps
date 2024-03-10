<div class="card-panel">

    <?php
    $expances = DB::table('employees')
            ->select('employees.user_id as user_id', 'api_expenses.*')
            ->where('employees.account_id', '=', Auth::id())
            ->where('api_expenses.is_save', '=', 1)
            ->join('api_expenses', 'api_expenses.is_user', '=', 'employees.user_id')
            ->orderBy('api_expenses.id', 'DESC')
//            ->whereIn('api_expenses.is_process', [4])
            ->get();
    $payment_status_master = DB::table('payment_status')
            ->select('payment_status.*')
            ->get();
    ?>_combination
    <div>
        <h6 class="title-color"><span>Account Expense Action</span></h6>
        <div style="text-align:center;">

            <table class="display striped">
                <thead>
                    <tr>
                        <th>#ID</th>
                        <th>Employee Name</th>
                        <th>Expense Type</th>
                        <th>Claim amount</th>
                        <th>Settlement Amount</th>
                        <th>Spent At</th>
                        <th>Date Time Of Expense</th>
                        <th>Payment Status</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>

                    <?php
                    foreach ($expances as $key => $account_detaile) {
                        ?>
                        <tr>
                            <td width="2%"> <center>{{$key+1}}</center> </td>
                    <td>
                        <?php
                        $em_name = app('App\Http\Controllers\Controller')->getConditionDynamicNameTable('employees', 'user_id', $account_detaile->user_id, 'name');
                        echo $em_name;
                        ?>
                    </td>
                    <td>
                        <?php
                        if ($account_detaile->expense_type == '0') {
                            echo 'Cash';
                        } else {
                            echo 'Mileage';
                        }
                        ?>
                    </td>
                    <td><?php echo ($account_detaile->expense_type == 0) ? $account_detaile->total_amount_cash : $account_detaile->total_amount_mile; ?></td>
                    <td><?php echo $account_detaile->settlement_amount; ?></td>
                    <td><?php echo ($account_detaile->expense_type == 0) ? $account_detaile->spent_at : $account_detaile->spent_at_mile; ?></td>
                    <td><?php echo ($account_detaile->expense_type == 0) ? $account_detaile->date_of_expense_cash : $account_detaile->date_of_expense_mile; ?></td>
                    <td>
                        <?php echo app('App\Http\Controllers\Controller')->getConditionDynamicNameTable('payment_status', 'id', $account_detaile->payment_status_id, 'name'); ?>
                    </td>

                    <td>


                        <?php
//                        echo $account_detaile->is_process;
                        if ($account_detaile->is_process == 0) {
                            ?>
                            -
                        <?php } else if ($account_detaile->is_process == 11) { ?>
                            Partially Approve from Manager
                        <?php } else if ($account_detaile->is_process == 1) { ?>
                            Accepted from Manager
                        <?php } else if ($account_detaile->is_process == 2) { ?>
                            Reject from Manager
                        <?php } else if ($account_detaile->is_process == 3) { ?>
                            Accepted from Accountant
                        <?php } else if ($account_detaile->is_process == 4) { ?>
                            Reject from Accountant
                        <?php } else if ($account_detaile->is_process == 5) { ?>
                            Accepted from Admin
                        <?php } else if ($account_detaile->is_process == 6) { ?>
                            Reject from admin
                        <?php } else { ?>
                            None
                        <?php } ?>



                    </td>
                    <td>

                        <?php if (($account_detaile->is_process == '3') || ($account_detaile->is_process == '0') || ($account_detaile->is_process == '5') || ($account_detaile->is_process == '6')) { ?>
                        <?php } else { ?>
                            <a class="modal-trigger" href="#mangerAction{{$account_detaile->id}}">
                                <span class="material-icons">call_to_action</span>
                            </a>
                        <?php } ?>
                        <a class="modal-trigger" href="#History{{$account_detaile->id}}">
                            <span class="material-icons">visibility</span>
                        </a>
                        <!--==============================================================================================-->
                        <!-- Modal Structure -->
                        <div id="mangerAction{{$account_detaile->id}}" class="modal">
                            <div class="modal-content">
                                <h4>Accountant Action <span style="font-size: 13px;color: blue;"># {{$em_name}}</span> </h4>
                                <form id="formEditValidateAdmin" action="{{ route('expense.updateByAccount', $account_detaile->id) }}" method="POST" enctype="multipart/form-data">
                                    <div class="row">
                                        <input type="hidden" name="clam_amount" readonly="" value="<?php echo ($account_detaile->expense_type == 0) ? $account_detaile->total_amount_cash : $account_detaile->total_amount_mile; ?>">
                                        <div class="input-field col s3">
                                            <select name="payment_status_account" id="payment_status_account">
                                                <option disabled="" selected="" value="0">Payment Status</option>
                                                @foreach($payment_status_master as $payment_status)
                                                <option value="{{$payment_status->id}}" {{$payment_status->id == $account_detaile->payment_status_id ? 'selected' : ''}}>{{$payment_status->name}}</option>
                                                @endforeach
                                            </select>
                                            <label>Payment Status</label>
                                            <!--<div class="payment_status_id_error"></div>-->

                                        </div>
                                        <div class="input-field col s3">
                                            <select name="is_status_account">
                                                <option value="{{$account_detaile->is_process}}" {{(($account_detaile->is_process=='0') || ($account_detaile->is_process=='1') || ($account_detaile->is_process=='2') ) ? 'selected' : ''}} >Action by Accountant</option>
                                                <option value="3" {{$account_detaile->is_process=='3' ? 'selected' : ''}} >Accepted</option>
                                                <option value="4" {{$account_detaile->is_process=='4' ? 'selected' : ''}} >Reject</option>
                                            </select>
                                            <label>Action by Accountant  </label>
                                        </div>
                                        <div class="input-field col s3">
                                            <label>
                                                Settlement Amount Total </a> <?php
                                                if ($account_detaile->claim_amount - $account_detaile->settlement_amount == 0) {
                                                    echo 'Full ' . $account_detaile->settlement_amount;
                                                } else {
                                                    echo $account_detaile->settlement_amount;
                                                }
                                                ?>
                                            </label>

                                            <input type="number" 
                                                   name="settlement_amount" 
                                                   value="0"
                                                   oninput="this.value = !!this.value && Math.abs(this.value) >= 0 ? Math.abs(this.value) : null"
                                                   id="settlement_amount"
                                                   min="0" 
                                                   max="<?php echo $account_detaile->claim_amount; ?>" 
                                                   >
                                                   <!--max="<?php // echo ($account_detaile->claim_amount - $account_detaile->settlement_amount); ?>"--> 
                                        </div>
                                        <div class="input-field col s3">
                                            <label>Description</label>
                                            <input type="text" name="note_by_account" placeholder="Note">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col s3">
                                            <label>Currency</label>
                                            <input type="text" disabled="" value="{{$account_detaile->currency}}">
                                        </div>
                                        <div class="col s3">
                                            <label>Spent Type</label>
                                            <input type="text" disabled="" value="<?php
                                            if ($account_detaile->expense_type == '0') {
                                                echo 'Cash';
                                            } else {
                                                echo 'Mileage';
                                            }
                                            ?>">
                                        </div>
                                        <div class="col s3">
                                            <label>Spent At</label>
                                            <input type="text" disabled="" value="<?php echo ($account_detaile->expense_type == 0) ? $account_detaile->spent_at : $account_detaile->spent_at_mile; ?>">
                                        </div>
                                        <div class="col s3">
                                            <label>Amount</label>
                                            <input type="text" disabled="" value="<?php echo ($account_detaile->expense_type == 0) ? $account_detaile->total_amount_cash : $account_detaile->total_amount_mile; ?>">

                                        </div>
                                        <div class="col s3">
                                            <label>Expance Date and time</label>
                                            <input type="text" disabled="" value="<?php echo ($account_detaile->expense_type == 0) ? $account_detaile->date_of_expense_cash . ' ' . $account_detaile->date_of_expense_time : $account_detaile->date_of_expense_mile . ' ' . $account_detaile->date_of_expense_time; ?>">
                                        </div>
                                        <div class="col s3">
                                            <label>Card Used</label>
                                            <input type="text" disabled="" value="<?php echo ($account_detaile->expense_type == 0) ? $account_detaile->card_used_cash : $account_detaile->card_used_cash; ?>">
                                        </div>

                                    </div>
                                    <div class = "row">
                                        <?php
                                        $account_detaile_file = DB::table('api_expenses_documents')
                                                ->where('api_expenses_documents.emp_id', '=', $account_detaile->id)
                                                ->get();
                                        if (count($account_detaile_file) > 0) {
                                            ?>
                                            <h6>Upload Bills / Documents</h6>
                                            <?php
                                            foreach ($account_detaile_file as $key => $files) {
                                                ?>
                                                <div class="input-field col s1" style="text-align: center;">
                                                    @include('employee-master.expense.__file_extension')
                                                </div>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </div>
                                    <div class="row">
                                        <div class="col s12 display-flex justify-content-end form-action">
                                            <button type="submit" class="btn btn-small indigo waves-light mr-1">
                                                <i class="material-icons right">send</i>  Update
                                            </button>
                                            <a href="#" class="modal-action modal-close btn btn-small indigo waves-light mr-1">
                                                <i class="material-icons right">settings_backup_restore</i>Close
                                            </a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>


                        <!--==============================================================================================-->

                        <div id="History{{$account_detaile->id}}" class="modal">
                            <div class="modal-content">
                                <h4>Accountant Action History  <span style="font-size: 13px;color: blue;"># {{$em_name}}</span></h4>
                                <div class="row">
                                    <?php
                                    $expenses_history = app('App\Http\Controllers\Controller')->getConditionDynamicTableAll('api_expenses_action_log', 'emp_id', $account_detaile->id);
                                    ?>

                                </div>
                                @include('user-profile.__expance_history')
                            </div>
                        </div>
                        <!--==============================================================================================-->
                    </td>
                    </tr>
                    <?php
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
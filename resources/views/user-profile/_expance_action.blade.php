<div class="card-panel">

    <?php
//    $expances = DB::table('api_expenses')
//            ->select('api_expenses.*')
////            ->join('api_account_master', 'api_account_master.emp_id', '=', 'api_expenses.is_user')
////                            ->join('employees', 'leave_request.employee_id', '=', 'employees.user_id')
////            ->where('api_expenses.is_user', '=', Session::get('user_id'))
//            ->where('api_expenses.is_user', '=', Auth::id())
//            ->orderBy('api_expenses.id', 'DESC')
////                            ->whereIn('leave_request.status', [4, 3, 2, 5, 7])
//            ->get();
    $expances = DB::table('employees')
            ->select('employees.user_id as user_id', 'api_expenses.*')
            ->where('employees.manager_id', '=', Auth::id())
            ->where('api_expenses.is_save', '=', 1)
            ->join('api_expenses', 'api_expenses.is_user', '=', 'employees.user_id')
            ->orderBy('api_expenses.id', 'DESC')
//            ->whereIn('api_expenses.is_process', [0, 1, 2])
            ->get();
    ?>
    <div>
        <h6 class="title-color"><span>Manager Expense Action</span></h6>

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
                    foreach ($expances as $key => $detaile) {
                        ?>
                        <tr>
                            <td width="2%"> <center>{{$key+1}}</center> </td>
                    <td>
                        <?php
                        $em_name = app('App\Http\Controllers\Controller')->getConditionDynamicNameTable('employees', 'user_id', $detaile->user_id, 'name');
                        echo $em_name;
                        ?>
                    </td>        
                    <td>
                        <?php
                        if ($detaile->expense_type == '0') {
                            echo 'Cash';
                        } else {
                            echo 'Mileage';
                        }
                        ?>
                    </td>
                    <td><?php echo ($detaile->expense_type == 0) ? $detaile->total_amount_cash : $detaile->total_amount_mile; ?></td>
                    <td><?php echo $detaile->settlement_amount; ?></td>
                    <td><?php echo ($detaile->expense_type == 0) ? $detaile->spent_at : $detaile->spent_at_mile; ?></td>
                    <td><?php echo ($detaile->expense_type == 0) ? $detaile->date_of_expense_cash : $detaile->date_of_expense_mile; ?></td>
                    <td>
                        <?php echo app('App\Http\Controllers\Controller')->getConditionDynamicNameTable('payment_status', 'id', $detaile->payment_status_id, 'name'); ?>
                    </td>

                    <td>
                        <?php
//                        echo $detaile->is_process;
                        if ($detaile->is_process == 0) {
                            ?>
                            -
                        <?php } else if ($detaile->is_process == 11) { ?>
                            Partially Approve from Manage
                        <?php } else if ($detaile->is_process == 1) { ?>
                            Accepted from Manager
                        <?php } else if ($detaile->is_process == 2) { ?>
                            Reject from Manager
                        <?php } else if ($detaile->is_process == 3) { ?>
                            Accepted from Accountant
                        <?php } else if ($detaile->is_process == 4) { ?>
                            Reject from Accountant
                        <?php } else if ($detaile->is_process == 5) { ?>
                            Accepted from Admin
                        <?php } else if ($detaile->is_process == 6) { ?>
                            Reject from admin
                        <?php } else { ?>
                            None
                        <?php } ?>


                    </td>
                    <td><?php if (($detaile->is_process == '1') || ($detaile->is_process == '3') || ($detaile->is_process == '5') || ($detaile->is_process == '6')) { ?>
                        <?php } else { ?>
                            <!-- Modal Trigger -->
                            <a class="modal-trigger" href="#moda_{{$detaile->id}}">
                                <span class="material-icons">call_to_action</span>
                            </a>
                            <!--================================================================-->

                            <!-- Modal Structure -->
                            <div id="moda_{{$detaile->id}}" class="modal">
                                <br>
                                <div class="modal-content">

                                    <h4>Manager Action <span style="font-size: 13px;color: blue;"># {{$em_name}}</span></h4>

                                    <form method="POST" enctype="multipart/form-data" id="formEditValidateManager" action="{{ route('expense.updateByManager', $detaile->id) }}" >
                                        <div class="row">
                                            <div class="input-field col s6">
                                                <select name="is_status_manager" required="required" class="form-control" >
                                                    <option value="0" {{$detaile->is_process=='0' ? 'selected' : ''}} disabled="">Manager Action</option>
                                                    <option value="1" {{$detaile->is_process=='1' ? 'selected' : ''}} >Accepted</option>
                                                    <option value="11" {{$detaile->is_process=='11' ? 'selected' : ''}} >Partially Approve</option>
                                                    <option value="2" {{$detaile->is_process=='2' ? 'selected' : ''}} >Reject</option>
                                                </select>
                                                <label>Manager Action </label>
                                            </div>
                                            <div class="input-field col s6" style="display: none;">
                                                <label>Settlement Amount <?php
                                                    if ($detaile->claim_amount - $detaile->settlement_amount == 0) {
                                                        echo 'Full ' . $detaile->settlement_amount;
                                                    } else {
                                                        echo $detaile->settlement_amount;
                                                    }
                                                    ?></label>
                                                <input type="number" 
                                                       name="settlement_amount" 
                                                       id="settlement_amount"
                                                       value="<?php echo $detaile->settlement_amount; ?>"
                                                       oninput="this.value = !!this.value && Math.abs(this.value) >= 0 ? Math.abs(this.value) : null"
                                                       min="0" 
                                                       max="<?php echo ($detaile->claim_amount); ?>" 
                                                       >
                                                       <!--max="<?php // echo ($detaile->claim_amount - $detaile->settlement_amount);  ?>"--> 
                                            </div>
                                            <div class="input-field col s6">
                                                <label>Description  </label>
                                                <input type="text" name="note_by_manager" placeholder="Note">
                                            </div>
                                        </div>
                                        <div class=" ">

                                            <div class="col s3">
                                                <label>Currency</label>
                                                <input type="text" disabled="" value="{{$detaile->currency}}">
                                            </div>
                                            <div class="col s3">
                                                <label>Spent Type</label>
                                                <input type="text" disabled="" value="<?php
                                                if ($detaile->expense_type == '0') {
                                                    echo 'Cash';
                                                } else {
                                                    echo 'Mileage';
                                                }
                                                ?>">
                                            </div>
                                            <div class="col s3">
                                                <label>Spent At</label>
                                                <input type="text" disabled="" value="<?php echo ($detaile->expense_type == 0) ? $detaile->spent_at : $detaile->spent_at_mile; ?>">
                                            </div>
                                            <div class="col s3">
                                                <label>Claim Amount</label>
                                                <input type="number" name="clam_amount" readonly="" value="<?php echo ($detaile->expense_type == 0) ? $detaile->total_amount_cash : $detaile->total_amount_mile; ?>">
                                            </div>

                                            <div class="col s3">
                                                <label>Expense Date and time</label>
                                                <input type="text" disabled="" value="<?php echo ($detaile->expense_type == 0) ? $detaile->date_of_expense_cash . ' ' . $detaile->date_of_expense_time : $detaile->date_of_expense_mile . ' ' . $detaile->date_of_expense_time; ?>">
                                            </div>
                                            <div class="col s3">
                                                <label>Card Used</label>
                                                <input type="text" disabled="" value="<?php echo ($detaile->expense_type == 0) ? $detaile->card_used_cash : $detaile->card_used_cash; ?>">
                                            </div>

                                        </div>
                                        <div class="row">
                                            <?php
                                            $detaile_file = DB::table('api_expenses_documents')
                                                    ->where('api_expenses_documents.emp_id', '=', $detaile->id)
                                                    ->get();
                                            if (count($detaile_file) > 0) {
                                                ?>
                                                <h6>Upload Bills / Documents</h6>
                                                <?php
                                                foreach ($detaile_file as $key => $files) {
                                                    ?>
                                                    <div class="input-field col s1" style="text-align: center;">
                                                        @include('employee-master.expense.__file_extension')
                                                    </div>
                                                <?php } ?>
                                            <?php } ?>
                                        </div>
                                        <div class="row">
                                            <div class="col s12 display-flex justify-content-end form-action">
                                                <button type="submit" class="btn btn-small indigo waves-light mr-1">
                                                    <i class="material-icons right">send</i>  Update
                                                </button>
                                                <a href="#" class="modal-action modal-close btn btn-small indigo waves-light mr-1">
                                                    <i class="material-icons right">settings_backup_restore</i>Close</a>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <br>
                            </div>
                        <?php } ?>
                        <!--================================================================-->
                        <a class="modal-trigger" href="#PopU_{{$detaile->id}}">
                            <span class="material-icons">visibility</span>
                        </a>
                        <div id="PopU_{{$detaile->id}}" class="modal">
                            <div class="modal-content">
                                <h4>Manager Action History <span style="font-size: 13px;color: blue;"># {{$em_name}}</span></h4>
                                <div class="row">
                                    <?php
                                    $expenses_history = DB::table('api_expenses_action_log')
                                            ->where('emp_id', '=', $detaile->id)
                                            ->where('is_process', '!=', 0)
                                            ->get();
                                    ?>

                                </div>
                                @include('user-profile.__expance_history')
                            </div>
                        </div>
                        <!--================================================================-->
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
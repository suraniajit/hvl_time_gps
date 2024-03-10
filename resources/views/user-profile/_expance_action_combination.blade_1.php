


<script src="https://hherp.probsoltech.com/js/ajax/jquery.min.js"></script>





<div class="card-panel">
    <?php
    $expances_combination = DB::table('employees')
            ->select('employees.user_id as user_id', 'api_expenses.*')
            ->where('employees.manager_id', '=', Auth::id())
            ->where('api_expenses.is_save', '=', 1)
            ->join('api_expenses', 'api_expenses.is_user', '=', 'employees.user_id')
            ->groupBy('api_expenses.combination_name')
            ->get();
    ?>
    <div>
        <h6 class="title-color"><span>Manager Expense Action#</span></h6>
        <table class="display striped">
            <thead>
                <tr>
                    <th>#ID</th>
                    <th>Employee Name</th>
                    <th>Combination</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($expances_combination as $key => $expances_details) {
                    $em_name = app('App\Http\Controllers\Controller')->getConditionDynamicNameTable('employees', 'user_id', $expances_details->user_id, 'name');
                    $getCountValueFromTable = DB::table('api_expenses')->where('combination_name', '=', $expances_details->combination_name)->count();
                    ?>
                    <tr>
                        <td width="2%">
                <center>{{$key+1}}</center>
                </td>
                <td>
                    <?php echo $em_name; ?>
                </td>  
                <td>
                    <a class="modal-trigger" href="#moda_all_exp_{{$expances_details->id}}" onclick="modal_overlay();">
                        <?php echo $expances_details->combination_name . ' (' . $getCountValueFromTable . ')'; ?>
                    </a>
                    <!-- Modal Structure -->
                    <div id="moda_all_exp_{{$expances_details->id}}" class="modal fade">
                        <br>
                        <!--==================================================================================================-->
                        <div class="modal-content">
                            <h4>List of Expense [{{$expances_details->id}}-{{$expances_details->combination_name}}] <span style="font-size: 13px;color: blue;"># {{$em_name}}</span></h4>

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
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $expances_comi = DB::table('employees')
                                                ->select('employees.user_id as user_id', 'api_expenses.*')
                                                ->where('api_expenses.combination_name', '=', $expances_details->combination_name)
                                                ->join('api_expenses', 'api_expenses.is_user', '=', 'employees.user_id')
                                                ->get();

                                        foreach ($expances_comi as $key => $expances_details) {
                                            ?>
                                            <tr>
                                                <td width="2%"> <center>{{$key+1}}</center> </td>
                                        <td><?php echo $em_name; ?> </td>
                                        <td>
                                            <?php
                                            if ($expances_details->expense_type == '0') {
                                                echo 'Cash';
                                            } else {
                                                echo 'Mileage';
                                            }
                                            ?>
                                        </td>
                                        <td><?php echo ($expances_details->expense_type == 0) ? $expances_details->total_amount_cash : $expances_details->total_amount_mile; ?></td>
                                        <td><?php echo $expances_details->settlement_amount; ?></td>
                                        <td><?php echo ($expances_details->expense_type == 0) ? $expances_details->spent_at : $expances_details->spent_at_mile; ?></td>
                                        <td><?php echo ($expances_details->expense_type == 0) ? $expances_details->date_of_expense_cash : $expances_details->date_of_expense_mile; ?></td>
                                        <td>
                                            <?php if ($expances_details->is_process == 0) { ?>
                                                -
                                            <?php } else if ($expances_details->is_process == 11) { ?>
                                                Partially Approve from Manage
                                            <?php } else if ($expances_details->is_process == 1) { ?>
                                                Accepted from Manager
                                            <?php } else if ($expances_details->is_process == 2) { ?>
                                                Reject from Manager
                                            <?php } else if ($expances_details->is_process == 3) { ?>
                                                Accepted from Accountant
                                            <?php } else if ($expances_details->is_process == 4) { ?>
                                                Reject from Accountant
                                            <?php } else if ($expances_details->is_process == 5) { ?>
                                                Accepted from Admin
                                            <?php } else if ($expances_details->is_process == 6) { ?>
                                                Reject from admin
                                            <?php } else { ?>
                                                None
                                            <?php } ?>
                                        </td>
                                        <td><?php if (($expances_details->is_process == '1') || ($expances_details->is_process == '3') || ($expances_details->is_process == '5') || ($expances_details->is_process == '6')) { ?>
                                            <?php } else { ?>
                                                <!-- Modal Trigger -->
                                                <a class="modal-trigger" href="#moda_{{$expances_details->id}}" onclick="modal_overlay();">
                                                    <span class="material-icons">call_to_action</span>
                                                </a>
                                                <!--================================================================-->

                                                <!-- Modal Structure -->
                                                <div id="moda_{{$expances_details->id}}" class="modal">
                                                    <br>
                                                    <div class="modal-content">

                                                        <h4>Manager Action <span style="font-size: 13px;color: blue;"># {{$em_name}}</span></h4>

                                                        <form method="POST" enctype="multipart/form-data" id="formEditValidateManager" action="{{ route('expense.updateByManager', $expances_details->id) }}" >
                                                            <div class="row">
                                                                <div class="input-field col s6">
                                                                    <select name="is_status_manager" required="required" class="form-control" >
                                                                        <option value="0" {{$expances_details->is_process=='0' ? 'selected' : ''}} disabled="">Manager Action</option>
                                                                        <option value="1" {{$expances_details->is_process=='1' ? 'selected' : ''}} >Accepted</option>
                                                                        <option value="11" {{$expances_details->is_process=='11' ? 'selected' : ''}} >Partially Approve</option>
                                                                        <option value="2" {{$expances_details->is_process=='2' ? 'selected' : ''}} >Reject</option>
                                                                    </select>
                                                                    <label>Manager Action </label>
                                                                </div>
                                                                <div class="input-field col s6" style="display: none;">
                                                                    <label>Settlement Amount <?php
                                                                        if ($expances_details->claim_amount - $expances_details->settlement_amount == 0) {
                                                                            echo 'Full ' . $expances_details->settlement_amount;
                                                                        } else {
                                                                            echo $expances_details->settlement_amount;
                                                                        }
                                                                        ?></label>
                                                                    <input type="number" 
                                                                           name="settlement_amount" 
                                                                           id="settlement_amount"
                                                                           value="<?php echo $expances_details->settlement_amount; ?>"
                                                                           oninput="this.value = !!this.value && Math.abs(this.value) >= 0 ? Math.abs(this.value) : null"
                                                                           min="0" 
                                                                           max="<?php echo ($expances_details->claim_amount); ?>" 
                                                                           >
                                                                           <!--max="<?php // echo ($expances_details->claim_amount - $expances_details->settlement_amount);        ?>"--> 
                                                                </div>
                                                                <div class="input-field col s6">
                                                                    <label>Description  </label>
                                                                    <input type="text" name="note_by_manager" placeholder="Note">
                                                                </div>
                                                            </div>
                                                            <div class=" ">

                                                                <div class="col s3">
                                                                    <label>Currency</label>
                                                                    <input type="text" disabled="" value="{{$expances_details->currency}}">
                                                                </div>
                                                                <div class="col s3">
                                                                    <label>Spent Type</label>
                                                                    <input type="text" disabled="" value="<?php
                                                                    if ($expances_details->expense_type == '0') {
                                                                        echo 'Cash';
                                                                    } else {
                                                                        echo 'Mileage';
                                                                    }
                                                                    ?>">
                                                                </div>
                                                                <div class="col s3">
                                                                    <label>Spent At</label>
                                                                    <input type="text" disabled="" value="<?php echo ($expances_details->expense_type == 0) ? $expances_details->spent_at : $expances_details->spent_at_mile; ?>">
                                                                </div>
                                                                <div class="col s3">
                                                                    <label>Claim Amount</label>
                                                                    <input type="number" name="clam_amount" readonly="" value="<?php echo ($expances_details->expense_type == 0) ? $expances_details->total_amount_cash : $expances_details->total_amount_mile; ?>">
                                                                </div>

                                                                <div class="col s3">
                                                                    <label>Expense Date and time</label>
                                                                    <input type="text" disabled="" value="<?php echo ($expances_details->expense_type == 0) ? $expances_details->date_of_expense_cash . ' ' . $expances_details->date_of_expense_time : $expances_details->date_of_expense_mile . ' ' . $expances_details->date_of_expense_time; ?>">
                                                                </div>
                                                                <div class="col s3">
                                                                    <label>Card Used</label>
                                                                    <input type="text" disabled="" value="<?php echo ($expances_details->expense_type == 0) ? $expances_details->card_used_cash : $expances_details->card_used_cash; ?>">
                                                                </div>

                                                            </div>
                                                            <div class="row">
                                                                <?php
                                                                $expances_details_file = DB::table('api_expenses_documents')
                                                                        ->where('api_expenses_documents.emp_id', '=', $expances_details->id)
                                                                        ->get();
                                                                if (count($expances_details_file) > 0) {
                                                                    ?>
                                                                    <h6>Upload Bills / Documents</h6>
                                                                    <?php
                                                                    foreach ($expances_details_file as $key => $files) {
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
                                            <a class="modal-trigger" href="#PopU_{{$expances_details->id}}" onclick="modal_overlay();">
                                                <span class="material-icons">visibility</span>
                                            </a>
                                            <div id="PopU_{{$expances_details->id}}" class="modal">
                                                <div class="modal-content">
                                                    <h4>Manager Action History <span style="font-size: 13px;color: blue;"># {{$em_name}}</span></h4>
                                                    <div class="row">
                                                        <?php
                                                        $expenses_history = DB::table('api_expenses_action_log')
                                                                ->where('emp_id', '=', $expances_details->id)
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
                        <!--==================================================================================================-->
                    </div>
                </td>
                </tr>
                <?php
            }
            ?>
            </tbody>
        </table>
    </div>
</div>

<script>
function modal_overlay() {
    alert();
    $(".modal-overlay").css({"z-index": ""});
}
</script>
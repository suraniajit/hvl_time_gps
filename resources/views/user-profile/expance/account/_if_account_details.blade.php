<!--_if_account_details.blade.php<br>-->
<tr>
    <td width="2%"> <center>{{$key+1}}</center> </td>
<td style="padding-top: 24px;"><?php echo ($account_detaile->expense_type == 0) ? "Cash" : "Mileage"; ?></td>
<td>  

    <a id="Popup_{{$account_detaile->id}}_if" href="https://hvl.probsoltech.com/expense_document/{{$account_detaile->id}}" target="_blank">
        <span class="fa fa-eye"></span> View 
    </a>


</td>
<td><?php echo ($account_detaile->expense_type == 0) ? $account_detaile->spent_at : $account_detaile->spent_at_mile; ?><br>
    <span><?php echo '<strong>Description :</strong> ' . substr($account_detaile->description_cash, 0, 40); ?></span>

    <br>
    <span>
        <?php
        $note_by_manager = app('App\Http\Controllers\Controller')->getConditionDynamicNameTable('api_expenses_action_log', 'emp_id', $account_detaile->id, 'note_by_manager');
        $note_by_admin = app('App\Http\Controllers\Controller')->getConditionDynamicNameTable('api_expenses_action_log', 'emp_id', $account_detaile->id, 'note_by_admin');
        if (isset($note_by_manager)) {
            echo '<hr><strong>Manager Note:</strong> ' . substr($note_by_manager, 0, 40);
        }
        if (isset($note_by_admin)) {
            echo '<hr><strong>Account Note:</strong> ' . substr($note_by_admin, 0, 40);
        }
        ?>
    </span>

</td>
<td><?php echo ($account_detaile->expense_type == 0) ? $account_detaile->date_of_expense_cash : $account_detaile->date_of_expense_mile; ?></td>
<td>
    <?php if ($account_detaile->payment_status_id == '2') { ?>
        <span style="color: blue;font-weight: 500;">
            <?php echo app('App\Http\Controllers\Controller')->getConditionDynamicNameTable('payment_status', 'id', $account_detaile->payment_status_id, 'name'); ?>
        </span>
        <?php
    } else {
        echo app('App\Http\Controllers\Controller')->getConditionDynamicNameTable('payment_status', 'id', $account_detaile->payment_status_id, 'name');
    }
    ?>
</td>
<td>
    <?php
    //echo $account_detaile->is_process;
    if ($account_detaile->is_process == 0) {
        ?>
        -
    <?php } else if ($account_detaile->is_process == 12) { ?>
        <span style="color: blue;font-weight: 500;">
            Partially Approved from Account
        </span>
    <?php } else if ($account_detaile->is_process == 11) { ?>
        <span style="color: blue;font-weight: 500;">

            Partially Approved from Manager
        </span>
    <?php } else if ($account_detaile->is_process == 1) { ?>
        <span style="color: green;font-weight: 500;">
            Accept from Manager
        </span>
    <?php } else if ($account_detaile->is_process == 2) { ?>
        <span style="color: red;font-weight: 500;">
            Reject from Manager
        </span>
    <?php } else if ($account_detaile->is_process == 3) { ?>
        <span style="color: green;font-weight: 500;">
            Accept from Account
        </span>
    <?php } else if ($account_detaile->is_process == 4) { ?>
        <span style="color: red;font-weight: 500;">
            Reject from Account
        </span>
    <?php } else if ($account_detaile->is_process == 5) { ?>
        <span style="color: green;font-weight: 500;">
            Accept from Admin
        </span>
    <?php } else if ($account_detaile->is_process == 6) { ?>
        <span style="color: red;font-weight: 500;">
            Reject from Admin
        </span>
    <?php } else { ?>
        None
    <?php } ?>
</td>
<td style="padding-top: 24px;font-weight: 600;">INR <?php echo ($account_detaile->expense_type == 0) ? $account_detaile->total_amount_cash : $account_detaile->total_amount_mile; ?></td>

<td style="padding-top: 24px;font-weight: 600;"><?php echo 'INR ' . $account_detaile->manger_settl_amount; ?></td>
<td style="padding-top: 24px;font-weight: 600;"><?php echo 'INR ' . $account_detaile->acount_settl_amount; ?></td>
<td>
    <?php
    if ($account_detaile->action_by_user_id !== '1') {
        echo app('App\Http\Controllers\Controller')->getConditionDynamicNameTable('employees', 'user_id', $account_detaile->action_by_user_id, 'name');
        echo '<br>(' . $account_detaile->created_at . ')';
    }
    ?>


</td>

<td>
    <?php if (($account_detaile->is_process == '3') || ($account_detaile->is_process == '0') || ($account_detaile->is_process == '5') || ($account_detaile->is_process == '6')) { ?>
    <?php } else { ?>
        <a class="modal-trigger" href="#accountAction{{$account_detaile->id}}" style="display: none;">
            <span class="material-icons">call_to_action</span>
        </a>
    <?php } ?>

    <!--==============================================================================================-->
    <!-- Modal Structure -->
    <div id="accountAction{{$account_detaile->id}}" class="modal">
        <div class="modal-content">
            <h4>Account Action <span style="font-size: 13px;color: blue;"># {{$em_name_account}}</span>
                <button class="btn close" data-dismiss="modal" aria-label="Close" style="float: right;" onclick="closer(accountAction{{$account_detaile->id}})" >
                    <span aria-hidden="true">×</span>
                </button>
            </h4>
            <form id="formEditValidateAdmin" action="{{ route('expense.updateByAccount', $account_detaile->id) }}" method="POST" enctype="multipart/form-data">
                <div class="row">
                    <input type="hidden" name="clam_amount" readonly="" value="<?php echo ($account_detaile->expense_type == 0) ? $account_detaile->total_amount_cash : $account_detaile->total_amount_mile; ?>">

                    <?php $payment_status_master = app('App\Http\Controllers\Controller')->getAllDynamicTable('payment_status'); ?>
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
                            <option value="{{$account_detaile->is_process}}" {{(($account_detaile->is_process=='0') || ($account_detaile->is_process=='1') || ($account_detaile->is_process=='2') ) ? 'selected' : ''}} >Action by Account</option>
                            <option value="3" {{$account_detaile->is_process=='3' ? 'selected' : ''}} >Accept</option>
                            <option value="4" {{$account_detaile->is_process=='4' ? 'selected' : ''}} >Reject</option>
                        </select>
                        <label>Action by Account  </label>
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
                               <!--max="<?php // echo ($account_detaile->claim_amount - $account_detaile->settlement_amount);                                                           ?>"--> 
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
                        <input type="text" disabled="" value="<?php echo ($account_detaile->expense_type == 0) ? "Cash" : "Mileage"; ?>">
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

                <div class="row">
                    <div class="col s12 display-flex justify-content-end form-action">
                        <button type="submit" class="btn btn-small indigo waves-light mr-1">
                            <i class="material-icons right">send</i>  Update
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>


</td>
</tr>
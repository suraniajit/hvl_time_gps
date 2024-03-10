<!--_else_account_details.blade.php<br>-->
<tr>
    <td width="2%"> <center>{{$key+=1}}</center> </td>
<td style="padding-top: 24px;"> <?php echo ($account_detaile->expense_type == 0) ? "Cash" : "Mileage"; ?> </td>
<td>  
    <?php
    if (auth()->User()->id == 1395) {
        ?>
        <a data-toggle="modal" data-target="#document_view_popup_{{$account_detaile->id}}">
            <span class="fa fa-eye"></span> View##
        </a>

        <div class="modal" id="document_view_popup_{{$account_detaile->id}}">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">
                            Expense Document <span style="font-size: 13px;color: blue;"> [{{$account_detaile->combination_name}}]</span>
                        </h4>
                        <button type="button" class="close" onclick="closer(document_view_popup_{{$account_detaile->id}})">&times;</button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body">
                        @include('employee-master.expense.expance_action._zoom')
                        <?php
                        $account_detaile_file = DB::table('api_expenses_documents')
                                ->where('api_expenses_documents.emp_id', '=', $account_detaile->id)
                                ->get();
                        if (count($account_detaile_file) > 0) {
                            ?>
                            <h6>Upload Bills / Documents</h6>
                            <br>
                            <div class="row">
                                <?php
                                foreach ($account_detaile_file as $key => $files) {
                                    ?>
                                    <div class="" style="margin-right: 16px; text-align: center;">
                                        @include('employee-master.expense.__file_extension')
                                    </div>
                                <?php } ?>
                            </div>
                        <?php } else { ?>
                            Document Not Uploaded
                        <?php } ?>

                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" onclick="closer(document_view_popup_{{$account_detaile->id}})">Close</button>
                    </div>

                </div>
            </div>
        </div>
    <?php } ?>



    <a id="Popup_{{$account_detaile->id}}" href="https://hvl.probsoltech.com/expense_document/{{$account_detaile->id}}" target="_blank">
        <span class="fa fa-eye"></span> View 
    </a>

    <script>
        $(document).ready(function () {
        $('#Popup_{{$account_detaile->id}}').click(function () {
        var NWin = window.open($(this).prop('href'), '', 'height=800,width=800');
        if (window.focus)
        {
        NWin.focus();
        }
        return false;
        });
        });
    </script>


</td>
<td> <?php echo ($account_detaile->expense_type == 0) ? $account_detaile->spent_at : $account_detaile->spent_at_mile; ?> <br>
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
<td style="padding-top: 24px;"> <?php echo ($account_detaile->expense_type == 0) ? $account_detaile->date_of_expense_cash : $account_detaile->date_of_expense_mile; ?> </td>
<td> 
    <select name="payment_status_account[]" class="form-control select">
        <label>Payment Status</label>

        <option value="4">Completed</option>

    </select>
    <?php // echo app('App\Http\Controllers\Controller')->getConditionDynamicNameTable('payment_status', 'id', $account_detaile->payment_status_id, 'name'); ?>
</td>


<td>
    <select name="is_status_account[]"  required="" class="form-control select" >
        <label>Account Action </label>
        <option value="{{$account_detaile->is_process}}" {{(($account_detaile->is_process=='0') || ($account_detaile->is_process=='1') || ($account_detaile->is_process=='2') ) ? 'selected' : ''}} >Action by Account</option>
        <option value="3" {{$account_detaile->is_process=='3' ? 'selected' : ''}} >Accept</option>
        <option value="12" {{$account_detaile->is_process=='12' ? 'selected' : ''}} >Partially Approved</option>
        <option value="4" {{$account_detaile->is_process=='4' ? 'selected' : ''}} >Reject</option>
    </select>

</td>


<td style="padding-top: 24px;font-weight: 600;"> 
    INR  

    <?php
    if ($account_detaile->is_resubmit == '1') {
        echo ($account_detaile->expense_type == 0) ? $account_detaile->claim_amount : $account_detaile->claim_amount;
        ?><br><span style="color: royalblue";><?php echo ($account_detaile->is_resubmit == '1' ? "resubmit of " . $account_detaile->total_amount_cash : ""); ?></span><?php
    } else {
        echo ($account_detaile->expense_type == 0) ? $account_detaile->total_amount_cash : $account_detaile->total_amount_mile;
    }
    ?>

</td>
<td style="padding-top: 24px;font-weight: 600;"> INR <?php echo $account_detaile->settlement_amount; ?> 
    <br><?php
    if ($account_detaile->is_process == '11') {
        echo '<span style="color: blue;">Partially Approved</span>';
    }
    ?>

</td>
<td> <input type="hidden" name="clam_amount[]" value="<?php echo $account_detaile->claim_amount; ?>">
    <input type="hidden" class="form-control" name="total_amount_cash[]" value="<?php echo ($account_detaile->expense_type == 0) ? $account_detaile->total_amount_cash : $account_detaile->total_amount_mile; ?>">

    <input type="number" name="settlement_amount[]"  class="form-control"
           oninput="this.value = !!this.value && Math.abs(this.value) >= 0 ? Math.abs(this.value) : null"
           min="0" 
           max="<?php echo ($account_detaile->settlement_amount); ?>"
           required=""
           >
</td>
<td>
    <input type="text" name="note_by_account[]" value="" class="form-control" placeholder="enter some comment">
</td>
<td>
    <?php
    if ($account_detaile->action_by_user_id !== '1') {
        echo app('App\Http\Controllers\Controller')->getConditionDynamicNameTable('employees', 'user_id', $account_detaile->action_by_user_id, 'name');
        echo '<br>(' . $account_detaile->created_at . ')';
    }
    ?>
</td>
</tr>
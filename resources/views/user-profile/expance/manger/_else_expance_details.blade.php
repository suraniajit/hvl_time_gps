<!--_else_expance_details.blade.php<br>-->
<tr>
    <td width="2%"> <center>{{$key+1}} {{$expances_details->is_process}}</center> </td>
<td> <?php echo ($expances_details->expense_type == 0) ? "Cash" : "Mileage"; ?> </td>
<td>  

    <a id="Popup_{{$expances_details->id}}_if" href="https://hvl.probsoltech.com/expense_document/{{$expances_details->id}}" target="_blank">
        <span class="fa fa-eye"></span> View 
    </a>
</td>
<td> <?php echo ($expances_details->expense_type == 0) ? $expances_details->spent_at : $expances_details->spent_at_mile; ?> <br>
    <span><?php echo '<strong>Description :</strong> ' . substr($expances_details->description_cash, 0, 40); ?></span>
    <br>
    <?php
    $note_by_manager = app('App\Http\Controllers\Controller')->getConditionDynamicNameTable('api_expenses_action_log', 'emp_id', $expances_details->id, 'note_by_manager');
    if (isset($note_by_manager)) {
        echo '<hr><strong>Manager Note:</strong> ' . substr($note_by_manager, 0, 40);
    }
    ?>

</td>

<td> <?php echo ($expances_details->expense_type == 0) ? $expances_details->date_of_expense_cash : $expances_details->date_of_expense_mile; ?> </td>

<td>  
INR <?php
    if ($expances_details->is_resubmit == '1') {
        echo ($expances_details->expense_type == 0) ? $expances_details->claim_amount : $expances_details->claim_amount;
        ?><br><span style="color: royalblue";><?php echo ($expances_details->is_resubmit == '1' ? "resubmit of " . $expances_details->total_amount_cash : ""); ?></span><?php
    } else {
        echo ($expances_details->expense_type == 0) ? $expances_details->total_amount_cash : $expances_details->total_amount_mile;
    }
    ?><br>
</td>
<td>
    <select name="is_status_manager[]" class="form-control select" required="required">
        <label>Manager Action </label>
        <option value="0" {{$expances_details->is_process=='0' ? 'selected' : ''}} >Manager Action</option>
        <option value="1" {{$expances_details->is_process=='1' ? 'selected' : ''}} >Accept</option>
        <option value="11" {{$expances_details->is_process=='11' ? 'selected' : ''}} >Partially Approve</option>
        <option value="2" {{$expances_details->is_process=='2' ? 'selected' : ''}} >Reject</option>
    </select>
</td>
<td>
    <input type="hidden" class="form-control" name="clam_amount[]" value="<?php echo ($expances_details->expense_type == 0) ? $expances_details->total_amount_cash : $expances_details->total_amount_mile; ?>">
    <input type="number" name="settlement_amount[]" class="form-control" required=""
           min="0" max="<?php echo ($expances_details->claim_amount); ?>"  placeholder="Enter Settlement Amount" oninput="this.value = !!this.value && Math.abs(this.value) >= 0 ? Math.abs(this.value) : null" onkeyup="enforceMinMax(this)" >
</td>
<td>


    <input type="text" name="comment[]" class="form-control" value="" placeholder="Enter some Comment">
</td>
</tr>



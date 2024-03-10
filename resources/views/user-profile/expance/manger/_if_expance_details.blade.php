<!--_if_expance_details.blade.php<bR>-->

<tr>
    <td width="2%"> <center>{{$key+1}}</center> </td>
<td><?php echo ($expances_details_ifcondi->expense_type == 0) ? "Cash" : "Mileage"; ?> </td>
<td>  


    <a id="Popup_{{$expances_details_ifcondi->id}}_if" href="https://hvl.probsoltech.com/expense_document/{{$expances_details_ifcondi->id}}" target="_blank">
        <span class="fa fa-eye"></span> View 
    </a>
</td>
<td>
    <?php echo ($expances_details_ifcondi->expense_type == 0) ? $expances_details_ifcondi->spent_at : $expances_details_ifcondi->spent_at_mile; ?><br>
    <span><?php echo '<strong>Description :</strong> ' . substr($expances_details_ifcondi->description_cash, 0, 40); ?></span>
    <br>
    <span>
        <?php
        $note_by_manager = app('App\Http\Controllers\Controller')->getConditionDynamicNameTable('api_expenses_action_log', 'emp_id', $expances_details_ifcondi->id, 'note_by_manager');
        if (isset($note_by_manager)) {
            echo '<hr><strong>Manager Note:</strong> ' . substr($note_by_manager, 0, 40);
        }
        ?>
    </span>
</td>
<td><?php echo ($expances_details_ifcondi->expense_type == 0) ? $expances_details_ifcondi->date_of_expense_cash : $expances_details_ifcondi->date_of_expense_mile; ?></td>
<td>INR <?php echo ($expances_details_ifcondi->expense_type == 0) ? $expances_details_ifcondi->total_amount_cash : $expances_details_ifcondi->total_amount_mile; ?></td>
<td>
    <?php
   // echo $expances_details->is_process;
    if ($expances_details_ifcondi->is_process == 0) { ?>
        -
    <?php } else if ($expances_details_ifcondi->is_process == 12) { ?>
        <span style="color: blue;font-weight: 500;">Partially Approved from Account</span>
    <?php } else if ($expances_details_ifcondi->is_process == 11) { ?>
        <span style="color: blue;font-weight: 500;"> Partially Approved from Manager</span>
    <?php } else if ($expances_details_ifcondi->is_process == 1) { ?>
        <span style="color: limegreen;font-weight: 500;">Accept from Manager</span>
    <?php } else if ($expances_details_ifcondi->is_process == 2) { ?>
        <span style="color: lightcoral;font-weight: 500;">Reject from Manager</span>
    <?php } else if ($expances_details_ifcondi->is_process == 3) { ?>
        <span style="color: green;font-weight: 500;">Accept from Account</span>
    <?php } else if ($expances_details_ifcondi->is_process == 4) { ?>
        <span style="color: red;font-weight: 500;">Reject from Account</span>
    <?php } else if ($expances_details_ifcondi->is_process == 5) { ?>
        <span style="color: green;font-weight: 500;">Accept from Admin</span>
    <?php } else if ($expances_details_ifcondi->is_process == 6) { ?>
        <span style="color: red;font-weight: 500;">Reject from Admin</span>
    <?php } else { ?>
        None
<?php } ?>
</td>
<td><?php echo 'INR ' . $expances_details_ifcondi->settlement_amount; ?></td>

<td><?php if (($expances_details_ifcondi->is_process == '1') || ($expances_details_ifcondi->is_process == '3') || ($expances_details_ifcondi->is_process == '5') || ($expances_details_ifcondi->is_process == '6')) { ?>
<?php } else { ?>
        <!-- Modal Trigger -->
        <a class="modal-trigger" href="#moda_{{$expances_details_ifcondi->id}}" style="display: none;">
            <span class="material-icons">call_to_action</span>
        </a>

        <!-- Modal Structure -->
        <div id="moda_{{$expances_details_ifcondi->id}}" class="modal">
            <br>
            <div class="modal-content">

                <h4>Manager Action <span style="font-size: 13px;color: blue;"># {{$em_name_manager}}</span>

                    <button class="btn close" data-dismiss="modal" aria-label="Close" style="float: right;" onclick="closer('moda_{{$expances_details_ifcondi->id}}');" >
                        <span aria-hidden="true">×</span>
                    </button>
                </h4>

                <form method="POST" enctype="multipart/form-data" id="formEditValidateManager" action="{{ route('expense.updateByManager', $expances_details_ifcondi->id) }}" >
                    <div class="row">
                        <div class="input-field col s6">
                            <select name="is_status_manager" required="required" class="form-control" >
                                <option value="0" {{$expances_details_ifcondi->is_process=='0' ? 'selected' : ''}} disabled="">Manager Action</option>
                                <option value="1" {{$expances_details_ifcondi->is_process=='1' ? 'selected' : ''}} >Accept</option>
                                <option value="11" {{$expances_details_ifcondi->is_process=='11' ? 'selected' : ''}} >Partially Approve</option>
                                <option value="2" {{$expances_details_ifcondi->is_process=='2' ? 'selected' : ''}} >Reject</option>
                            </select>
                            <label>Manager Action </label>
                        </div>
                        <div class="input-field col s6" style="display: none;">
                            <label>Settlement Amount <?php
                                if ($expances_details_ifcondi->claim_amount - $expances_details_ifcondi->settlement_amount == 0) {
                                    echo 'Full ' . $expances_details_ifcondi->settlement_amount;
                                } else {
                                    echo $expances_details_ifcondi->settlement_amount;
                                }
                                ?></label>
                            <input type="number" 
                                   name="settlement_amount" 
                                   id="settlement_amount"
                                   value="<?php echo $expances_details_ifcondi->settlement_amount; ?>"
                                   oninput="this.value = !!this.value && Math.abs(this.value) >= 0 ? Math.abs(this.value) : null"
                                   min="0" 
                                   max="<?php echo ($expances_details_ifcondi->claim_amount); ?>" 
                                   >
                                   <!--max="<?php // echo ($expances_details_ifcondi->claim_amount - $expances_details_ifcondi->settlement_amount);                                                                                    ?>"--> 
                        </div>
                        <div class="input-field col s6">
                            <label>Description  </label>
                            <input type="text" name="note_by_manager" placeholder="Note">
                        </div>
                    </div>
                    <div class=" ">

                        <div class="col s3">
                            <label>Currency</label>
                            <input type="text" disabled="" value="{{$expances_details_ifcondi->currency}}">
                        </div>
                        <div class="col s3">
                            <label>Spent Type</label>
                            <input type="text" disabled="" value="<?php echo ($expances_details_ifcondi->expense_type == 0) ? "Cash" : "Mileage"; ?>">
                        </div>
                        <div class="col s3">
                            <label>Spent At</label>
                            <input type="text" disabled="" value="<?php echo ($expances_details_ifcondi->expense_type == 0) ? $expances_details_ifcondi->spent_at : $expances_details_ifcondi->spent_at_mile; ?>">
                        </div>
                        <div class="col s3">
                            <label>Claim Amount</label>
                            <input type="number" name="clam_amount" readonly="" value="<?php echo ($expances_details_ifcondi->expense_type == 0) ? $expances_details_ifcondi->total_amount_cash : $expances_details_ifcondi->total_amount_mile; ?>">
                        </div>

                        <div class="col s3">
                            <label>Expense Date and time</label>
                            <input type="text" disabled="" value="<?php echo ($expances_details_ifcondi->expense_type == 0) ? $expances_details_ifcondi->date_of_expense_cash . ' ' . $expances_details_ifcondi->date_of_expense_time : $expances_details_ifcondi->date_of_expense_mile . ' ' . $expances_details_ifcondi->date_of_expense_time; ?>">
                        </div>
                        <div class="col s3">
                            <label>Card Used</label>
                            <input type="text" disabled="" value="<?php echo ($expances_details_ifcondi->expense_type == 0) ? $expances_details_ifcondi->card_used_cash : $expances_details_ifcondi->card_used_cash; ?>">
                        </div>
                    </div>
                    <div class="row">
                        <?php
                        $expances_details_ifcondi_file = DB::table('api_expenses_documents')
                                ->where('api_expenses_documents.emp_id', '=', $expances_details_ifcondi->id)
                                ->get();
                        if (count($expances_details_ifcondi_file) > 0) {
                            ?>
                            <h6>Upload Bills / Documents</h6>
                            <?php
                            foreach ($expances_details_ifcondi_file as $key => $files) {
                                ?>
                                <div class="" style="margin-right: 16px; text-align: center;">
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



    <!-- The Modal -->
    <div class="modal" id="PopU_{{$expances_details_ifcondi->id}}">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Manager Action History <span style="font-size: 13px;color: blue;"># {{$em_name_manager}}</span></h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <div class="row">
                        <?php
                        $expenses_history = DB::table('api_expenses_action_log')
                                ->where('emp_id', '=', $expances_details_ifcondi->id)
                                ->where('is_process', '!=', 0)
                                ->get();
                        ?>
                    </div>
                    @include('user-profile.__expance_history')
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>

            </div>
        </div>
    </div>


</td>
</tr>







<script>
//     $(document).ready(function () {
//     $(".content").hide();
//     $(".show_hide").on("click", function () {
//         var txt = $(".content").is(':visible') ? 'Read More' : 'Read Less';
//         $(".show_hide").text(txt);
//         $(this).next('.content'+{{$expances_details_ifcondi->id}}).slideToggle(200);
//     });
// });
</script>
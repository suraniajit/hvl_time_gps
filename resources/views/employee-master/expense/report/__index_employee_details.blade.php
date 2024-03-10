 

<div class="table-responsive">
    <table id="page-length-option_normal" class="table table-striped table-hover multiselect">
        <thead>
            <tr>
                <th>#ID</th>
                <th>Employee Name</th>
                <th>Expense Type </th>
                <th>Expense Status</th>
                <th>Report Name </th>
                <th>Submission Date of expense</th>
                <th>Total Claim Amount</th>
                <th>Total Settlement Amount</th>
                <th>Total Reject Amount</th>
                <th>Payment Status</th>
                 <th>Process Status</th>
                <th>Note</th>
            </tr>
        </thead>
        <tbody>
            @foreach($expenses_details as $key => $detaile)

            <tr>

                <td width="2%"> <center>{{$key+1}}</center> </td>
        <td><?php echo app('App\Http\Controllers\Controller')->getConditionDynamicNameTable('employees', 'user_id', $detaile->is_user, 'Name'); ?></td>
        <td><?php echo ($detaile->expense_type == 0) ? "Cash" : "Mileage"; ?></td>
        <td>
            <?php if ($detaile->is_save == 1) { ?>
                <span style="font-weight: 800;color: green;"> Submited</span>
            <?php } else if ($detaile->is_save == 2) { ?>
                <span style="font-weight: 800;color: blue;"> Drafted</span>
            <?php } else if ($detaile->is_save == 11) { ?>
                <span style="font-weight: 800;color: blue;"> In Process</span>
            <?php } else if (($detaile->is_save == 3)) { ?>
                <span style="font-weight: 800;color: lightcoral;"> Partially Reject</span>
            <?php } else if (($detaile->is_save == 12)) { ?>
                <span style="font-weight: 800;color: blue;"> Resubmit</span>
            <?php } ?>
        </td>
        <td><?php
            if ($detaile->is_save == 1) {
                echo $detaile->combination_name;
            }
            ?>
        </td>
        <td><?php echo $detaile->date_search; ?></td>

        <td width="10%">
            <span class="task-cat green">
                <?php
                echo $detaile->currency . ' ';
                echo ($detaile->expense_type == 0) ? $detaile->total_amount_cash : $detaile->total_amount_mile;
                ?>
            </span>
        </td>
        <td>
            <span class="task-cat cyan"> <?php echo $detaile->currency . ' ' . $detaile->settlement_amount; ?> </span>
        </td>
        <td width="10%">
            <span class="task-cat red">
                <?php
                if ($detaile->payment_status_id == 4) {
                    $cliem_amount = ($detaile->expense_type == 0) ? $detaile->total_amount_cash : $detaile->total_amount_mile;
                    echo $detaile->currency . ' ' . ($cliem_amount - $detaile->settlement_amount);
                } else {

                    echo $detaile->currency . ' ' . ($detaile->reject_amount);
                }
                ?>
            </span>
        </td>
         
        <td>


            <?php if ($detaile->payment_status_id == '2') { ?>
                <span style="color: blue;font-weight: 500;">
                    <?php echo app('App\Http\Controllers\Controller')->getConditionDynamicNameTable('payment_status', 'id', $detaile->payment_status_id, 'name'); ?>
                </span>
                <?php
            } else {
                echo app('App\Http\Controllers\Controller')->getConditionDynamicNameTable('payment_status', 'id', $detaile->payment_status_id, 'name');
            }
            ?>


        </td>
        <td>
            <?php if ($detaile->is_process == 0) { ?>

                <span style="font-weight: 800;color: green;"> Expense Create by employee </span>
            <?php } else if ($detaile->is_process == 12) { ?>
                <span style="font-weight: 800;color: blue;"> Partially Approved from Account</span>
            <?php } else if ($detaile->is_process == 11) { ?>
                <span style="font-weight: 800;color: blue;"> Partially Approved from Manager</span>
            <?php } else if ($detaile->is_process == 1) { ?>
                <span style="font-weight: 800;color: green;"> Accepted from Manager</span>
            <?php } else if ($detaile->is_process == 2) { ?>
                <span style="font-weight: 800;color: red;">Rejected from Manager </span>
            <?php } else if ($detaile->is_process == 3) { ?>
                <span style="font-weight: 800;color: green;"> Accepted from Account</span>
            <?php } else if ($detaile->is_process == 4) { ?>
                <span style="font-weight: 800;color: red;">Rejected from Account </span>
            <?php } else if ($detaile->is_process == 5) { ?>
                <span style="font-weight: 800;color: green;"> Accepted from Admin</span>
            <?php } else if ($detaile->is_process == 6) { ?>
                <span style="font-weight: 800;color: red;">Rejected from Admin </span>
            <?php } else { ?>
                None
            <?php } ?>
        </td>

        <td>
            <?php
            $note_by_manager = app('App\Http\Controllers\Controller')->getConditionDynamicNameTable('api_expenses_action_log', 'emp_id', $detaile->id, 'note_by_manager');
            $note_by_admin = app('App\Http\Controllers\Controller')->getConditionDynamicNameTable('api_expenses_action_log', 'emp_id', $detaile->id, 'note_by_admin');
            if (isset($note_by_manager)) {
                echo 'Manager : ' . substr($note_by_manager, 0, 40);
            }
            if (isset($note_by_admin)) {
                echo 'Account : ' . substr($note_by_admin, 0, 40);
            }
            ?>
        </td>
        
        </tr>
        @endforeach
        </tbody>
    </table>
</div>

<script>
    $(document).ready(function () {
        $('#page-length-option_normal').DataTable({
            "scrollX": true
        });
        $('.datepicker').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            todayHighlight: true
        });
    });
</script>

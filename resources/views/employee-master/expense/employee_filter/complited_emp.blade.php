<div class="table-responsive">
    <table id="page-length-option_complited" class="table table-striped table-hover multiselect">
        <thead>
            @include('employee-master.expense.employee_filter._comm_head')
        </thead>
        <tbody>

            @foreach($expenses_details_complited as $key => $details_normal)
            <tr>
                <td width="10%">
                    <a  href="{{ route('expense.view', $details_normal->id) }}"
                        class="tooltipped "
                        data-position="top"
                        data-tooltip="View Expance">
                        <span class="fa fa-eye"></span>
                    </a>
                </td>

                <td width="5%"> <center>{{$key+1}}</center> </td>
        <th width="10%"><?php echo ($details_normal->expense_type == 0) ? $details_normal->spent_at : $details_normal->spent_at_mile; ?></td>
        <th width="10%"><?php echo ($details_normal->expense_type == 0) ? "Cash" : "Mileage"; ?></td>
        <th width="10%"><?php echo ($details_normal->is_save != 2) ? $details_normal->combination_name : ""; ?></td>
        <th width="10%">
            <span class="task-cat green" style="color: green;font-weight: 500;">
                <?php
                echo $details_normal->currency . ' ';
                echo ($details_normal->expense_type == 0) ? $details_normal->total_amount_cash : $details_normal->total_amount_mile;
                ?>
            </span>

            </td>
        <th width="10%">



            <?php
            if ($details_normal->is_resubmit == 1) {
                echo 'INR ' . DB::table('api_expenses_resubmit')
                        ->where('expance_id', '=', $details_normal->id)
                        ->where('is_user', '=', Auth::id())->sum('account_settlement_amount');
            } else {
                ?>
                <span class="task-cat cyan" style="color: darkorchid;font-weight: 500;"> <?php echo $details_normal->currency . ' ' . $details_normal->settlement_amount; ?> </span>
                <br>
                <?php
                if ($details_normal->is_process == 12) {
                    echo 'Partially Approved Account';
                }
            }
            ?>


            </td>


        <th width="10%">

            <span class="task-cat red" style="color: red;font-weight: 500;">
                <?php echo $details_normal->currency . ' ' . ($details_normal->reject_amount); ?>
            </span>
            <br>
            <?php
//            if ($details_normal->is_process == 12) {
//                echo 'Resubmit amount';
//            }
            ?>
            </td>
        <th width="10%">
            <?php
            echo ($details_normal->expense_type == 0) ? $details_normal->date_of_expense_cash . ' ' . $details_normal->date_of_expense_time : $details_normal->date_of_expense_mile . ' ' . $details_normal->date_of_expense_time;
            ?>
            </td>
        <th width="10%">
            <?php echo app('App\Http\Controllers\Controller')->getConditionDynamicNameTable('payment_status', 'id', $details_normal->payment_status_id, 'name'); ?>
            </td>
        <th width="10%">
            <?php echo app('App\Http\Controllers\Controller')->getConditionDynamicNameTable('payment_method', 'id', $details_normal->payment_method_id, 'name'); ?>
            </td>

        <th width="10%"><?php echo ($details_normal->is_active == 0) ? "Active" : "inactive"; ?></td>
        <th width="10%">
            <?php
            $note_by_manager = app('App\Http\Controllers\Controller')->getConditionDynamicNameTable('api_expenses_action_log', 'emp_id', $details_normal->id, 'note_by_manager');
            $note_by_admin = app('App\Http\Controllers\Controller')->getConditionDynamicNameTable('api_expenses_action_log', 'emp_id', $details_normal->id, 'note_by_admin');
            if (isset($note_by_manager)) {
                echo '<strong>Manager Note:</strong> ' . substr($note_by_manager, 0, 40);
            }
            if (isset($note_by_admin)) {
                echo '<br><strong>Account Note:</strong> ' . substr($note_by_admin, 0, 40);
            }
            ?>
            </td>

        <th width="10%">
            <?php
            $action_by_user_id = app('App\Http\Controllers\Controller')->getConditionDynamicNameTable('employees', 'user_id', $details_normal->action_by_user_id, 'name');
            if ($details_normal->is_process == 0) {
                ?>
                -
            <?php } else if ($details_normal->is_process == 12) { ?>
                <span style="font-size: 8px;">{{$action_by_user_id}}</span>Partially Approved from Account
            <?php } else if ($details_normal->is_process == 11) { ?>
                <span style="font-size: 8px;">{{$action_by_user_id}}</span>Partially Approved from Manager
            <?php } else if ($details_normal->is_process == 1) { ?>
                <span style="font-size: 8px;">{{$action_by_user_id}}</span>Accept from Manager
            <?php } else if ($details_normal->is_process == 2) { ?>
                <span style="font-size: 8px;">{{$action_by_user_id}}</span>Reject from Manager
            <?php } else if ($details_normal->is_process == 3) { ?>
                <span style="font-size: 8px;">{{$action_by_user_id}}</span>Accept from Account
            <?php } else if ($details_normal->is_process == 4) { ?>
                <span style="font-size: 8px;">{{$action_by_user_id}}</span>Reject from Account
            <?php } else if ($details_normal->is_process == 5) { ?>
                <span style="font-size: 8px;">{{$action_by_user_id}}</span>Accept from Admin
            <?php } else if ($details_normal->is_process == 6) { ?>
                <span style="font-size: 8px;">{{$action_by_user_id}}</span>Reject from Admin
            <?php } else { ?>
                None
            <?php } ?>
            </td>
            </tr>

            @endforeach
            </tbody>

    </table>
</div>

<script>
    $(document).ready(function () {
        $('#page-length-option_complited').DataTable({
            "scrollX": true
        });
    });
</script>

<script>
    $(document).ready(function () {
        $('#page-length-option_resubmit_popup').DataTable({
            "scrollX": true
        });
    });
</script>
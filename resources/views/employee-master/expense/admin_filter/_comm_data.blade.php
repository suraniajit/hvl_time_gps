<tr>
    <td width="15%">
        <!--can('Read expense')-->

        <a  href="{{ route('expense.view', $detaile->id) }}"
            class="tooltipped mr-2"
            data-position="top"
            data-tooltip="Edit">
            <span class="fa fa-eye"></span>

        </a>
        <!--endcan-->
        <!--can('Delete expense')-->
        <a href="#"
           class="tooltipped mr-2 delete-record-click"
           data-position="top"
           data-tooltip="Delete" data-id="{{ $detaile->id }}">
            <span class="fa fa-trash"></span>
        </a>
        <!--endcan-->

        <!--can('Edit expense')-->
        <?php if (($detaile->is_save !== 2) && ($detaile->is_process !== 5) && ($detaile->payment_status_id !== 4)) { ?>
            <a href="{{ route('expense.edit', $detaile->id) }}"
               class="tooltipped mr-2"
               data-position="top"
               data-tooltip="Edit">
                <span class="fa fa-edit	"></span>
            </a>
        <?php } ?>
        <!--endcan-->
    </td>
    <td width="2%"> <center>{{$key+1}}</center> </td>
<td><?php echo ($detaile->expense_type == 0) ? "Cash" : "Mileage"; ?></td>
<td><?php echo ($detaile->is_save == 1) ? $detaile->combination_name : ""; ?></td>
<td><?php echo $detaile->date_search; ?></td>

<td width="10%">
    <span class="task-cat green" style="color: green;font-weight: 500;">
        <?php
        echo $detaile->currency . ' ';
        echo ($detaile->expense_type == 0) ? $detaile->total_amount_cash : $detaile->total_amount_mile;
        ?>
    </span>
</td>
<td>
    <span class="task-cat cyan" style="color: blue;font-weight: 500;"> <?php echo $detaile->currency . ' ' . $detaile->settlement_amount; ?> </span>
</td>
<td width="10%">
    <span class="task-cat red" style="color: red;font-weight: 500;">
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
<td><?php echo ($detaile->is_active == 0) ? "Active" : "inactive"; ?></td>
<th width="10%">
    <?php
    $note_by_manager = app('App\Http\Controllers\Controller')->getConditionDynamicNameTable('api_expenses_action_log', 'emp_id', $detaile->id, 'note_by_manager');
    $note_by_admin = app('App\Http\Controllers\Controller')->getConditionDynamicNameTable('api_expenses_action_log', 'emp_id', $detaile->id, 'note_by_admin');
    if (isset($note_by_manager)) {
        echo 'Manager Note: ' . substr($note_by_manager, 0, 40);
    }
    if (isset($note_by_admin)) {
        echo '<br>Account Note: ' . substr($note_by_admin, 0, 40);
    }
    ?>
</td>
<td>
    <?php echo app('App\Http\Controllers\Controller')->getConditionDynamicNameTable('payment_status', 'id', $detaile->payment_status_id, 'name'); ?>
</td>
<td>
    <?php echo app('App\Http\Controllers\Controller')->getConditionDynamicNameTable('payment_method', 'id', $detaile->payment_method_id, 'name'); ?>
</td>
<td>
    <?php if ($detaile->is_process == 0) { ?>
        -
    <?php } else if ($detaile->is_process == 11) { ?>
        Partially Approved from Manager
    <?php } else if ($detaile->is_process == 1) { ?>
        Accept from Manager
    <?php } else if ($detaile->is_process == 2) { ?>
        Reject from Manager
    <?php } else if ($detaile->is_process == 3) { ?>
        Accepted from Account
    <?php } else if ($detaile->is_process == 4) { ?>
        Reject from Account
    <?php } else if ($detaile->is_process == 5) { ?>
        Accept from Admin
    <?php } else if ($detaile->is_process == 6) { ?>
        Reject from Admin
    <?php } else { ?>
        None
    <?php } ?>
    <?php
    echo app('App\Http\Controllers\Controller')->getConditionDynamicNameTable('employees', 'user_id', $detaile->action_by_user_id, 'name');
    echo '<br>(' . $detaile->created_at . ')';
    ?>
</td>
</tr>
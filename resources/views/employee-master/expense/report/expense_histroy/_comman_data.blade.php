<?php
$total_count_report = DB::table('api_expenses')
        ->where('api_expenses.is_user', '=', $emp_id)
        ->where('api_expenses.combination_name', '=', $detaile->combination_name)
        ->where('api_expenses.is_save', '=', '1')
        ->get();
?>

<tr>

    <td width="2%"> <center>{{$key+1}} </center> </td>
<td>
    <?php if (count($total_count_report) > 1) { ?>
        <a href="/report_history_by_report_details/{{$emp_id}}/{{$detaile->combination_name}}">
            {{$detaile->combination_name}}
        </a>
        <?php
    } else if ($detaile->is_save == 1 || $detaile->is_save == 3) {
        echo $detaile->combination_name;
    }
    ?>
</td>

<td><?php echo $detaile->date_search; ?></td>

<td width="10%">

    <?php
    if (count($total_count_report) > 1) {
        $def_claim_amount = 0;
        $def_claim_amount = DB::table('api_expenses')
                ->where('api_expenses.is_user', '=', $emp_id)
                ->where('api_expenses.combination_name', '=', $detaile->combination_name)
                ->where('api_expenses.is_save', '=', '1')
                ->sum('def_claim_amount');
        ?>
        <span class="task-cat green" style="color: green;font-weight: 500;">
            INR <?php echo $def_claim_amount; ?>
        </span>
    <?php } else { ?>
        <span class="task-cat green" style="color: green;font-weight: 500;">
            INR <?php echo ($detaile->expense_type == 0) ? $detaile->total_amount_cash : $detaile->total_amount_mile; ?>
        </span>
        <?php
    }
    ?>
    <br>
    <?php
    if (($detaile->is_resubmit == 1) || ($detaile->is_process == 4)) {
        ?>
        <span class="resubmit_span">

            <a href="#"
               class="tooltipped "
               data-position="top"
               data-toggle="modal" data-target="#resubmited_popu{{$detaile->id}}"
               data-tooltip="View all Resubmit History">
                Resubmit 
            </a>
            <?php $details_normal = $detaile; ?>
            @include('employee-master.expense._popu._resubmit_popup')
        </span>
        <?php
    }
    ?>
</td>
<td>
    <?php
    if (count($total_count_report) > 1) {
        $settlement_amount = DB::table('api_expenses')
                ->where('api_expenses.is_user', '=', $emp_id)
                ->where('api_expenses.combination_name', '=', $detaile->combination_name)
                ->where('api_expenses.is_save', '=', '1')
                ->sum('settlement_amount');
        ?>
        <span class="task-cat green" style="color: green;font-weight: 500;">
            <?php echo $detaile->currency . ' ' . $settlement_amount; ?>
        </span>
    <?php } else { ?>
        <span class="task-cat cyan" style="color: blue;font-weight: 500;"> 
            <?php echo $detaile->currency . ' ' . $detaile->settlement_amount; ?> 
        </span>
    <?php } ?>

</td>
<td width="10%">
    <span class="task-cat red" style="color: red;font-weight: 500;">
        <?php
        if (count($total_count_report) > 1) {
            $reject_amount = DB::table('api_expenses')
                    ->where('api_expenses.is_user', '=', $emp_id)
                    ->where('api_expenses.combination_name', '=', $detaile->combination_name)
                    ->where('api_expenses.is_save', '=', '1')
                    ->sum('reject_amount');
            ?>
            <span class="task-cat green" style="color: green;font-weight: 500;">
                <?php echo $detaile->currency . ' ' . $reject_amount; ?>
            </span>
        <?php } else { ?>
            <?php
            if ($detaile->payment_status_id == 4) {
                $cliem_amount = ($detaile->expense_type == 0) ? $detaile->total_amount_cash : $detaile->total_amount_mile;
                echo $detaile->currency . ' ' . ($cliem_amount - $detaile->settlement_amount);
            } else {

                echo $detaile->currency . ' ' . ($detaile->reject_amount);
            }
        }
        ?>
    </span>
</td>
<td>
    <?php echo app('App\Http\Controllers\Controller')->getConditionDynamicNameTable('payment_status', 'id', $detaile->payment_status_id, 'name'); ?>
</td>


<td>
    <?php if ($detaile->is_process == 0) { ?>
        -
    <?php } else if ($detaile->is_process == 12) { ?>
        Partially Approved from Account
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
    echo '<br>' . app('App\Http\Controllers\Controller')->getConditionDynamicNameTable('employees', 'user_id', $detaile->action_by_user_id, 'name');
    echo ' (' . $detaile->account_action_date . ')';
    ?>
</td>
</tr>
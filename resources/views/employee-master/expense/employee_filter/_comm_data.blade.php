<tr>
    <td width="10%">

        <a  href="{{ route('expense.view', $details_normal->id) }}"
            class="tooltipped "
            data-position="top"
            data-tooltip="Edit">
            <span class="fa fa-eye"></span>
        </a>
        <a  href="#"
            class="tooltipped "
            data-position="top"
            data-toggle="modal" data-target="#view_document_popu{{$details_normal->id}}"
            data-tooltip="View All Document">
            <span class="fa fa-download fa-lg"></span>
        </a>

        @if(($details_normal->is_process==12)||($details_normal->is_save==3)||($details_normal->is_save==2) || ($details_normal->is_process==2)|| ($details_normal->is_process==12) || ($details_normal->is_process==4))

        <a href="{{ route('expense.edit', $details_normal->id) }}"
           class="tooltipped "
           data-position="top"
           data-tooltip="View">
            <span class="fa fa-edit	"></span>  
        </a>
        @endif

        <?php if ($details_normal->payment_status_id != '4') { ?>
            @can('Edit expense')



            @endcan

            @can('Delete expense') 
            <?php
            if (($details_normal->is_save == 2)) {
                ?>
                <a href="#"
                   class="tooltipped  delete-record-click"
                   data-position="top"
                   data-tooltip="Delete" data-id="{{ $details_normal->id }}">
                    <span class="fa fa-trash"></span>
                </a>
            <?php } ?>
            @endcan
        <?php } ?>

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
    <br>
    <?php
//        if (($page == "all") || ($details_normal->is_resubmit == 1) || ($details_normal->is_process != 4)) {
    if (($details_normal->is_resubmit == 1) || ($details_normal->is_process == 4)) {
        ?>

        <a  href="#"
            class="tooltipped "
            data-position="top"
            data-toggle="modal" data-target="#resubmited_popu{{$details_normal->id}}"
            data-tooltip="View all Resubmit History">
            Resubmit
        </a>
        @include('employee-master.expense._popu._resubmit_popup')
        <?php
    }
    ?>
</td>
<th width="10%">

    <?php
    if ($details_normal->is_resubmit == 1) {
       echo 'INR '.DB::table('api_expenses_resubmit')
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


    <?php
    if (($details_normal->is_process == 12)) {
        ?> <span class="task-cat red" style="color: red;font-weight: 500;">
        <?php echo $details_normal->currency . ' ' . ($details_normal->claim_amount); ?>
        </span>
        <br>
        <?php
        echo 'Resubmit amount';
    } else {
        ?>
        <span class="task-cat red" style="color: red;font-weight: 500;">
            <?php echo $details_normal->currency . ' ' . ($details_normal->reject_amount); ?>
        </span>
        <br><?php
        }
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


<div class="modal" id="view_document_popu{{$details_normal->id}}">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">
                    Uploaded Bills / Documents : <?php echo $details_normal->combination_name; ?>
                </h4>
                <button type="button" class="close" onclick="closer(view_document_popu{{$details_normal->id}})">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <div class="table-responsive">
                    <div class="row">
                        <?php
                        $edit_details_popup = app('App\Http\Controllers\Controller')->getConditionDynamicTableAll('api_expenses_documents', 'emp_id', $details_normal->id);
                        if (count($edit_details_popup) > 0) {
                            foreach ($edit_details_popup as $key => $files) {
                                ?>
                                <div class="col-md-2" style="text-align: center;margin-bottom: 11px;">
                                    @include('employee-master.expense.__file_extension')
                                </div>
                                <?php
                            }
                        } else {
                            echo '<div class="col-md-12" style="text-align: center;margin-bottom: 11px;">No file uploaded </div>';
                        }
                        ?>  
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

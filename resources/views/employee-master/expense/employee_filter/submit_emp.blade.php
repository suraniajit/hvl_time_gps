<div class="table-responsive">
    <table id="page-length-option_submited" class="table table-striped table-hover multiselect">
        <thead>
            @include('employee-master.expense.employee_filter._comm_head')
        </thead>
        <tbody>

            @foreach($expenses_details_normal as $key => $details_normal)
            <tr>
                <td width="10%">

                    <a  href="{{ route('expense.view', $details_normal->id) }}"
                        class="tooltipped "
                        data-position="top"
                        data-tooltip="Edit">
                        <span class="fa fa-eye"></span>
                    </a>


                    <?php if ($details_normal->payment_status_id != '4') { ?>
                        @can('Edit expense')
                        @if(($details_normal->is_save==2))
                        <!--||(details_normal->is_process==2)|| (details_normal->is_process==4)-->
                        <a href="{{ route('expense.edit', $details_normal->id) }}"
                           class="tooltipped "
                           data-position="top"
                           data-tooltip="View">
                            <span class="fa fa-edit	"></span>
                        </a>
                        @endif
                        @endcan


                        <?php if ($details_normal->is_save != 1) { ?>
                            @can('Delete expense')

                            <a href="#"
                               class="tooltipped  delete-record-click"
                               data-position="top"
                               data-tooltip="Delete" data-id="{{ $details_normal->id }}">
                                <span class="fa fa-trash"></span>
                            </a>
                            @endcan
                        <?php } ?>
                    <?php } else { ?>
                    <?php } ?>

                </td>

                <td width="5%"> <center>{{$key+1}}</center> </td>
        <th width="10%"><?php echo ($details_normal->expense_type == 0) ? $details_normal->spent_at : $details_normal->spent_at_mile; ?></td>
        <th width="10%">  <?php echo ($details_normal->expense_type == 0) ? "Cash" : "Mileage"; ?></td>
        <th width="10%">  <?php echo ($details_normal->is_save != 2) ? $details_normal->combination_name : ""; ?></td>
        <th width="10%">
            <span class="task-cat green" style="color: green;font-weight: 500;">
                <?php
                echo $details_normal->currency . ' ';
                echo ($details_normal->expense_type == 0) ? $details_normal->total_amount_cash : $details_normal->total_amount_mile;
                ?>
            </span>
            </td>
        <th width="10%">
            <span class="task-cat cyan" style="color: blue;font-weight: 500;"> <?php echo $details_normal->currency . ' ' . $details_normal->settlement_amount; ?> </span>
            </td>


        <th width="10%">

            <span class="task-cat red" style="color: red;font-weight: 500;">
                <?php
                echo $details_normal->currency . ' ' . ($details_normal->reject_amount);
                ?>
            </span>

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
            <?php $action_by_user_id = app('App\Http\Controllers\Controller')->getConditionDynamicNameTable('employees', 'user_id', $details_normal->action_by_user_id, 'name'); ?>
            <?php if ($details_normal->is_process == 0) { ?>
                -
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
            @endforeach
            </tbody>
    </table>
</div>
<script>
    $(document).ready(function () {
    $('#page-length-option_submited').DataTable({
    "scrollX": true
    });
    });
</script>
<div class="section section-data-tables">
    <div class="table-responsive">
        <table id="page-length-option_draft" class="table table-striped table-hover multiselect">
            <thead>
                <tr>
                    <th class="sorting_disabled" width="5%">#</th>
                    <th class="sorting_disabled" width="10%">Action</th>
                    <th width="5%">#ID</th>
                    <th width="10%">Spent At</th>
                    <th width="10%">Expense Type</th>
                    <th width="10%">Claim Amount</th>
                    <th width="10%">Settlement Amount</th>
                    <th width="10%">Total Reject Amount</th>
                    <th width="10%">Expense Submission Date</th>
                    <th width="10%">Payment Status</th>
                    <th width="10%">Payment Method</th>
                    <th width="10%">Status</th>
                    <th width="10%">Action Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($expenses_details_draft as $key => $details_normal)
                <tr>
                    <td width="5%">
                        <label>
                            <input type="checkbox" class="checkboxes" data-id="{{ $details_normal->id }}" name="selected_row"/>
                            <span></span>
                        </label>
                    </td>
                    <td width="10%">
                      
                        <a  href="{{ route('expense.view', $details_normal->id) }}"
                            class="tooltipped "
                            data-position="top"
                            data-tooltip="Edit">
                            <span class="fa fa-eye"></span>
                        </a>
                        <?php if (($details_normal->payment_status_id != '4')) { ?>
                            @can('Edit expense')
                            <a  href="{{ route('expense.edit', $details_normal->id) }}"
                                class="tooltipped "
                                data-position="top"
                                data-tooltip="View">
                                <span class="fa fa-edit"></span>
                            </a>
                            @endcan
                            @can('Delete expense')
                            <a href="#"
                               class="tooltipped  delete-record-click"
                               data-position="top"
                               data-tooltip="Delete" data-id="{{ $details_normal->id }}">
                                <span class="fa fa-trash"></span>
                            </a>
                            @endcan
                        <?php } else { ?>


                        <?php } ?>

                    </td>

                    <td width="5%"> <center>{{$key+1}}</center> </td>
            <th width="10%"><?php echo ($details_normal->expense_type == 0) ? $details_normal->spent_at : $details_normal->spent_at_mile; ?></td>
            <th width="10%"> <?php echo ($details_normal->expense_type == 0) ? "Cash" : "Mileage"; ?>  </td>
            <th width="10%">
                <span class="task-cat green" style="color: green;font-weight: 500;">
                    <?php
                    echo $details_normal->currency . ' ';
                    echo($details_normal->expense_type == 0) ? $details_normal->total_amount_cash : $details_normal->total_amount_mile;
                    ?>
                </span>
                </td>
            <th width="10%">
                <span class="task-cat cyan" style="color: blue;font-weight: 500;"><?php echo $details_normal->currency . ' ' . $details_normal->settlement_amount; ?></span>
                </td>
            <th width="10%">
                <span class="task-cat red" style="color: red;font-weight: 500;">
                    <?php
                    echo $details_normal->currency . ' ' . ($details_normal->reject_amount);
                    ?>
                </span>
                </td>
            <th width="10%"><?php echo ($details_normal->expense_type == 0) ? $details_normal->date_of_expense_cash . ' ' . $details_normal->date_of_expense_time : $details_normal->date_of_expense_mile . ' ' . $details_normal->date_of_expense_time; ?></td>
            <th width="10%">
                <?php echo app('App\Http\Controllers\Controller')->getConditionDynamicNameTable('payment_status', 'id', $details_normal->payment_status_id, 'name'); ?>
                </td>
            <th width="10%">
                <?php echo app('App\Http\Controllers\Controller')->getConditionDynamicNameTable('payment_method', 'id', $details_normal->payment_method_id, 'name'); ?>
                </td>

            <th width="10%">
                <?php if ($details_normal->is_active == 0) { ?>
                    Active
                <?php } else if ($details_normal->is_active == 1) { ?>
                    inactive
                <?php } ?>
                </td>

            <th width="10%">
                <?php $action_by_user_id = app('App\Http\Controllers\Controller')->getConditionDynamicNameTable('employees', 'user_id', $details_normal->action_by_user_id, 'name'); ?>

                <?php if ($details_normal->is_process == 0) { ?>
                    -
                <?php } else if ($details_normal->is_process == 11) { ?>
                    <span style="font-size: 8px;">{{$action_by_user_id}}</span>
                    Partially Approved from Manager
                <?php } else if ($details_normal->is_process == 1) { ?>
                    <span style="font-size: 8px;">{{$action_by_user_id}}</span>
                    Accept from Manager
                <?php } else if ($details_normal->is_process == 2) { ?>
                    <span style="font-size: 8px;">{{$action_by_user_id}}</span>
                    Reject from Manager
                <?php } else if ($details_normal->is_process == 3) { ?>
                    <span style="font-size: 8px;">{{$action_by_user_id}}</span>
                    Accept from Account
                <?php } else if ($details_normal->is_process == 4) { ?>
                    <span style="font-size: 8px;">{{$action_by_user_id}}</span>
                    Reject from Account
                <?php } else if ($details_normal->is_process == 5) { ?>
                    <span style="font-size: 8px;">{{$action_by_user_id}}</span>
                    Accept from Admin
                <?php } else if ($details_normal->is_process == 6) { ?>
                    <span style="font-size: 8px;">{{$action_by_user_id}}</span>
                    Reject from Admin
                <?php } else { ?>
                    None
                <?php } ?> 
                </td>
                </tr>
                @endforeach
                </tbody>
        </table>
    </div>
</div>



<script type="text/javascript">

function combinationAction() {
    var checkbox_array = [];
        var token = $("meta[name='csrf-token']").attr("content");
        $.each($("input[name='selected_row']:checked"), function () {
            checkbox_array.push($(this).data("id"));
        });
// console.log(checkbox_array);
        if (typeof checkbox_array !== 'undefined' && checkbox_array.length > 0) {
            swal({
                title: "Are you sure,",
                text: "you want to submit these expenses for approval? Please enter a name of this expanse.",
                type: "input",
                showCancelButton: true,
                closeOnConfirm: false,
                inputPlaceholder: "Write something"
            }, function (inputValue) {
                if (inputValue === false)
                    return false;
                if (inputValue === "") {
                    swal.showInputError("You need to write something!");
                    return false
                } else {
                    if (inputValue) {
                        $.ajax({
                            url: '/expense/mass_move_save/',
                            mehtod: "get",
                            data: {
                                "_token": token,
                                "combination_name": inputValue,
                                id: checkbox_array
                            },
                            success: function (result) {
                                swal("Thank you !", "You wrote: " + inputValue, "success");
                location.reload();
//                                swal("Record has been Update.!", {
//                                    icon: "success",
//                                }).then(function () {
//                                    location.reload();
//                                });
                            }
                        });
                    } else {
                        alert('blank');
                    }
                }
                
            });
        }
}


    $(document).ready(function () {
        
        $('#CheckAll').change(function () {
    ($(this).is(":checked") ? $('.checkboxes').prop("checked", true) :    $('.checkboxes').prop("checked", false))
});
        
        $('#page-length-option_draft').DataTable({
            "scrollX": true
        });
    });
    $('#is_save_action').click(function () {
        
    });

</script>
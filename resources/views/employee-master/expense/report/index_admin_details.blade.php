 


<div class="table-responsive">
    <table id="page-length-option_normal" class="table table-striped table-hover multiselect">
        <thead>
            <tr>
                <th>#ID</th>
                <?php if ((auth()->User()->id == '122') || (auth()->User()->id == '916')) { ?>
                    <th>Employee Name</th>
                <?php } ?>
                <th>Spent At</th>
                <th>Report Name </th>
                <th>Expense Submission Date</th>
                <th>Total Claim Amount</th>
                <th>Total Settlement Amount</th>
                <th>Total Reject Amount</th>
                <th>Payment Status</th>
                <th>Process Status</th>
                <th style="display: none;">Expense Status</th>
                <th>Note & time</th>
            </tr>
        </thead>
        <tbody>
            @foreach($expenses_details as $key => $detaile)

            <tr>

                <td width="2%"> <center>{{$key+1}}</center> </td>
        <?php if ((auth()->User()->id == '122') || (auth()->User()->id == '916')) { ?>
            <td><?php echo app('App\Http\Controllers\Controller')->getConditionDynamicNameTable('employees', 'user_id', $detaile->is_user, 'Name'); ?></td>
        <?php } ?>
        <td><?php echo $detaile->spent_at ?></td>
        <td><?php
            if ($detaile->is_save != 2) {
                echo $detaile->combination_name;
            }
            ?>
        </td>
        <td><?php echo $detaile->date_search; ?></td>

        <th width="10%">
            <span class="task-cat green" style="color: green;font-weight: 500;">
                <?php
                echo $detaile->currency . ' ';
                echo ($detaile->expense_type == 0) ? $detaile->total_amount_cash : $detaile->total_amount_mile;
                ?>
            </span>
            <br>
            <?php
            if (($detaile->is_resubmit == 1) || ($detaile->is_process == 4)) {
                ?>

                <a  href="#"
                    class="tooltipped "
                    data-position="top"
                    data-toggle="modal" data-target="#resubmited_popu{{$detaile->id}}"
                    data-tooltip="View all Resubmit History">
                    Resubmit
                </a>
                <?php $details_normal = $detaile; ?>
                @include('employee-master.expense._popu._resubmit_popup')
                <?php
            }
            ?>
            </td>
        <th width="10%">

            <?php
            if ($detaile->is_resubmit == 1) {
                echo 'INR ' . DB::table('api_expenses_resubmit')
                        ->where('expance_id', '=', $detaile->id)
                        ->where('is_user', '=', Auth::id())->sum('account_settlement_amount');
            } else {
                ?>
                <span class="task-cat cyan" style="color: darkorchid;font-weight: 500;"> <?php echo $detaile->currency . ' ' . $detaile->settlement_amount; ?> </span>
                <br>
                <?php
                if ($detaile->is_process == 12) {
                    echo 'Partially Approved Account';
                }
            }
            ?>
            </td>


        <th width="10%">


            <?php
            if (($detaile->is_process == 12)) {
                ?> <span class="task-cat red" style="color: red;font-weight: 500;">
                <?php echo $detaile->currency . ' ' . ($detaile->claim_amount); ?>
                </span>
                <br>
                <?php
                echo 'Resubmit amount';
            } else {
                ?>
                <span class="task-cat red" style="color: red;font-weight: 500;">
                    <?php echo $detaile->currency . ' ' . ($detaile->reject_amount); ?>
                </span>
                <br><?php
            }
            ?>
            </td>

        <td>


            <?php
// echo $detaile->payment_status_id;
            if ($detaile->payment_status_id == '2') {
                ?>
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

                <span style="font-weight: 800;color: green;">None</span>
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
        <td style="display: none;">
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

        <td>
            <?php
            $note_by_manager = app('App\Http\Controllers\Controller')->getConditionDynamicNameTable('api_expenses_action_log', 'emp_id', $detaile->id, 'note_by_manager');
            $note_by_admin = app('App\Http\Controllers\Controller')->getConditionDynamicNameTable('api_expenses_action_log', 'emp_id', $detaile->id, 'note_by_admin');
            $note_created_time = app('App\Http\Controllers\Controller')->getConditionDynamicNameTable('api_expenses_action_log', 'emp_id', $detaile->id, 'created_at');
            if (isset($note_by_manager)) {
                echo 'Manager :<br> ' . substr($note_by_manager, 0, 10);
            }
            if (isset($note_by_admin)) {
                echo 'Account :<br> ' . substr($note_by_admin, 0, 10);
            }
            ?>
            <br>

            <?php
            $expenses_action_log_count = DB::table('api_expenses_action_log')
                            ->orderBy('api_expenses_action_log.id', 'desc')
                            ->where('action_by_user_id', '=', $detaile->is_user)
                            ->where('emp_id', '=', $detaile->id)->get();

            if (count($expenses_action_log_count) > 0) {
                ?>
                <a  href="#"
                    class="tooltipped "
                    data-position="top"
                    data-toggle="modal" data-target="#notehistory{{$detaile->id}}"
                    data-tooltip="View all History">
                        <?php echo $note_created_time; ?>
                </a>
            <?php } ?>
            @include('employee-master.expense._popu._comment_pop')

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
    function closer(popid) {
//    alert(popid);
        $(popid).modal('hide');
    }
</script>

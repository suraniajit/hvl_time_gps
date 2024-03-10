<table class="table">
    <thead>
        <tr>
            <th>#No</th>
            <th>Date and time</th>
            <th>Action By</th>
            <th>Process</th>
            <th>Payment Status</th>
            <th>Total Claim Amount</th>
            <th>Total Settlement Amount</th>
            <th>Account Settlement Amount</th>
            <th>Manager Settlement Amount</th>
            <th>Total Reject Amount</th>
            <th>Comment</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($expenses_history as $key => $history) {
            ?>
            <tr>
                <td>{{$key+1}}</td>
                <td><?php echo $history->created_at; ?></td>
                <td><?php
        echo $history->action_by;
        if ($history->action_by_user_id !== '1') {
            echo '-' . app('App\Http\Controllers\Controller')->getConditionDynamicNameTable('employees', 'user_id', $history->action_by_user_id, 'name');
        }
            ?>
                </td>
                <td>
                    <?php if ($history->is_process == 0) { ?>
                        -
                    <?php } else if ($history->is_process == 11) { ?>
                        Partially Approved from Manager
                    <?php } else if ($history->is_process == 1) { ?>
                        Accept from Manager
                    <?php } else if ($history->is_process == 2) { ?>
                        Reject from Manager
                    <?php } else if ($history->is_process == 3) { ?>
                        Accept from Account
                    <?php } else if ($history->is_process == 4) { ?>
                        Reject from Account
                    <?php } else if ($history->is_process == 5) { ?>
                        Accept from Admin
                    <?php } else if ($history->is_process == 6) { ?>
                        Reject from Admin
                    <?php } else { ?>
                        None
                    <?php } ?>
                </td>
                <td>
                    <?php echo app('App\Http\Controllers\Controller')->getConditionDynamicNameTable('payment_status', 'id', $history->payment_status_id, 'name'); ?>
                </td>
                <td><?php echo 'INR ' . $history->clam_amount; ?></td>
                <td><?php echo 'INR ' . $history->settlement_amount; ?></td>
                <td><?php echo 'INR ' . $history->account_settlement_amount; ?></td>
                <td><?php echo 'INR ' . $history->manager_settlement_amount; ?></td>
                <td><?php echo 'INR ' . ($history->clam_amount - $history->settlement_amount); ?></td>
                <td><?php echo 'Admin :' . $history->note_by_admin; ?><br>
                    <?php echo 'Manger :' . $history->note_by_manager; ?></td>

                         <!--<td>-->
                <?php // echo app('App\Http\Controllers\Controller')->getConditionDynamicNameTable('employees', 'user_id', $history->action_by_user_id, 'name');    ?>
                <!--</td>-->
            </tr>
        <?php } ?>
    </tbody>
</table>
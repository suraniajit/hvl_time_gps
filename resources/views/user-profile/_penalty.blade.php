<div class="card-panel" style="padding-bottom: 34px;">
    <h4 class="title-color"><span>Penalty</span></h4>
    <table class="display striped">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th>Penalty Applied On</th>
                <th>Penalty Amount</th>
                <th>Reason</th>
            </tr>
        </thead>
        <tbody>

            @foreach($checkout as $key=>$check)
            <?php if ($check->penalty != '0') { ?>
                <tr>
                    <td width="5%" >{{++$key}}</td>
                    <td>{{$check->date}}</td>
                    <td>
                        <?php
                        if (!empty($check->penalty)) {
                            echo $check->penalty . '- Late Checkin';
                        }
                        echo '<br>';
                        if (!empty($check->checkout_penalty)) {
                            echo $check->checkout_penalty . '-  Checkout Missed';
                        }
                        ?>
                    </td>
                    <td> 
                        <?php
                        if ($check->status == '3') {
                            echo 'Checked In'; //Inchecking
                        } elseif ($check->status == '2') {
                            echo 'Late Checkin Penalty';
                        } elseif ($check->status == '1') {
                            echo 'Present';
                        } elseif ($check->status == '0') {
                            echo 'Absent';
                        } else {
                            echo '**';
                        }
                        ?></td>
                </tr>
            <?php } ?>
            @endforeach
            <?php if ($total_penalty_checkin != '0') { ?>
                <tr>
                    <td colspan="2">Total Penalty Amount:</td>
                    <td>{{$total_penalty_checkout+$total_penalty_checkin}}</td>

                </tr>
            <?php } ?>

        </tbody>
    </table>


</div>
<tr>
    <td>{{$key+=1}}</td>
    <td>
        <?php
        if ($resubmitdata->settlement_amount == 0) {
            echo 'In Process';
        } else {
            echo 'Completed';
        }

//        } else if ($resubmitdata->is_process == 3) {
//        }
        ?>
    </td>
    <td>INR {{$resubmitdata->claim_amount}}</td>
    <td>INR {{$resubmitdata->settlement_amount}}</td>
    <td>INR {{$resubmitdata->reject_amount}}</td>
    <td>{{$resubmitdata->note}}</td>
    <td>{{$resubmitdata->created_at}}</td>
</tr>
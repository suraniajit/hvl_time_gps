 
<div class="card-panel">

    <h4 class="title-color"><span>My Request </span></h4>



    <?php if (count($leaverequest) > 0) { ?>

        <div class=" ">
            <div style="text-align:center;">

                <table class="display striped">
                    <thead>
                        <tr>
                            <th style="width: 5%">&nbsp;&nbsp;ID</th>
                            <th>Leave Name</th>
                            <th>Start Date</th>
                            <th>End Date </th>
                            <th>Total Days</th>
                            <th>Remark</th>
                            <th>Status</th>
                            <th>Note</th>
                            <th>Action</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach($leaverequest as $key=>$leave)
                        <tr>
                            <th style="width: 5%">&nbsp;&nbsp;{{++$key}}</td>
                            <td>{{$leave->leaveName}}</td>
                            <td>{{$leave->from_date}}</td>
                            <td>{{$leave->end_date}}</td>
                            <td>{{$leave->total_days}}</td>
                            <td>{{$leave->remark}}</td>
                            <td>
                                <?php
                                //0-Reject | 1-Approve | 2-Pending | 3- Approved By Lead
                                if ($leave->status == '0') {
                                    ?><span class="">Reject</span><?php
                                } else if ($leave->status == '1') {
                                    ?><span class="">Approved</span><?php
                                } else if ($leave->status == '2') {
                                    ?><span class="">Pending by Team Lead</span><?php
                                } else if ($leave->status == '3') {
                                    ?><span class="">Pending by HR</span><?php
                                } else if ($leave->status == '4') {
                                    ?>
                                    <!--Approve Team Lead-->
                                    <span class="">Approved by Team Lead</span>
                                    <?php
                                } else if ($leave->status == '5') {
                                    ?>
                                    <!--Approved HR-->
                                    <span class="">Approved</span>
                                    <?php
                                } else if ($leave->status == '6') {
                                    ?>
                                    <span class="">Reject by Team Lead</span>
                                    <?php
                                } else if ($leave->status == '7') {
                                    ?>
                                    <span class="">Reject by HR</span>
                                    <?php
                                } else {
                                    ?><span class="">None</span><?php
                                }

//
//                                | 1- Approve
//                                | 2- Pending Team Lead
//                                | 3- Pending HR
//                                | 4- Approve Team Lead
//                                | 5- Approve HR
//                                | 6- Reject by Team Lead
//                                | 7- Reject by HR
                                ?>
                            </td>
                            <td>
                                <?php if (!empty($leave->reject_not)) { ?>
                                    <!-- Modal Trigger -->
                                    <a class="modal-trigger" href="#moda{{$leave->id}}">
                                        <span class="">View</span>
                                    </a>
                                    <!-- Modal Structure -->
                                    <div id="moda{{$leave->id}}" class="modal">
                                        <div class="modal-content">
                                            <h4 class="title-color">Team Lead :({{$leave->reject_not_date}}) </h4>
                                            <hr>
                                            <p>{{$leave->reject_not}}</p><br>

                                            <?php if (!empty($leave->reject_not_hr_date)) { ?>
                                                <h4 class="title-color">HR :({{$leave->reject_not_hr_date}}) </h4>
                                                <hr>
                                                <p>{{$leave->reject_not_hr}}</p><br>
                                            <?php } ?>
                                        </div>
                                        <div class="modal-footer">
                                            <a href="#!" class="modal-action modal-close btn-color  btn-flat">Close</a>
                                        </div>
                                    </div>
                                </td>
                            <?php } ?>
                            <td>
                                <?php if ($leave->status == '2') { ?>
                                    <a href="#" class="invoice-action-view mr-4 delete" id="{{$leave->id}}">
                                        <i class="material-icons dp48 button delete-confirm">delete</i>
                                    </a>
                                <?php } ?>

                            </td>

                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    <?php } else { ?>

        <div class="row">
            <div class="col 12">
                <h6>Record not found</h6>
            </div>
        </div>
    <?php } ?>
</div>

<script>
    //single data delete
    var textMassage = 'Leave Request';
    $(document).on('click', '.delete', function () {
        var id = $(this).attr('id');
        swal({
            title: "Are you sure, Are you sure you want to Delete this " + textMassage + "!",
            icon: 'warning',
            dangerMode: true,
            buttons: {
                cancel: 'No, Please!',
                delete: 'Yes, Delete It'
            }
        }).then(function (willDelete) {
            if (willDelete) {
                $.ajax({
                    url: "/hrms/leaverequest/delete/",
                    mehtod: "get",
                    data: {id: id},
                    success: function (data)
                    {
                        location.reload();
//                        swal("Poof! Leave Request has been deleted!", {
//                            icon: "success",
//                        });
                    }
                })
            } else {
                swal("Your Leave Request is safe", {
                    title: 'Cancelled',
                    icon: "error",
                });
                $('input[type=checkbox]').each(function ()
                {
                    $(this).prop('checked', false);
                });
                return false;
            }
        });
    });
</script>
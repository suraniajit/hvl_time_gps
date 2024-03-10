<div class="card-panel">

    <div>
        <h4 class="title-color"><span>Leave Approve HR</span></h4>


        <div style="text-align:center;">

            <table class="display striped">
                <thead>
                    <tr>
                        <th style="width: 5%;">ID</th>
                        <th>Employee Name</th>
                        <th>Leave Type</th>
                        <th>From Date</th>
                        <th>End Date</th>
                        <th>No. of Leaves</th>
                        <th>Remark</th>
                        <th>Status</th>
                        <th>Note</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($leaverequest_hr as $key=>$leave)
                    <tr>
                        <th style="width: 5%">{{++$key}}</td>
                        <td>{{$leave->emp_name}}</td>
                        <td>{{$leave->leavetype_name}}</td>
                        <td>{{$leave->from_date}}</td>
                        <td>{{$leave->end_date}}</td>
                        <td>{{$leave->total_days}}</td>
                        <td>{{$leave->remark}}</td>
                        <td>

                            <?php
                            if ($leave->status == '0') {
                                ?><span class="">Reject</span><?php
                            } else if ($leave->status == '1') {
                                ?><span class="">Approved</span><?php
                            } else if ($leave->status == '2') {
                                ?><span class="">Pending Team Lead</span><?php
                            } else if ($leave->status == '3') {
                                ?><span class="">Pending HR</span><?php
                            } else if ($leave->status == '4') {
                                ?>
                                <span class="">Approved by Team Lead </span>

                                <?php
                            } else if ($leave->status == '5') {
                                ?><span class="">Approved</span><?php
                            } else if ($leave->status == '6') {
                                ?><span class="">Rejected by Team Lead</span><?php
                            } else if ($leave->status == '7') {
                                ?>
                                <span class="">Rejected by HR</span>

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
                            <!-- Modal Trigger -->
                            <a class="modal-trigger" href="#moda{{$leave->id}}">
                                <span class="">View</span>
                            </a>
                            <!-- Modal Structure -->
                            <div id="moda{{$leave->id}}" class="modal">
                                <div class="modal-content">
                                    <h4>Team Lead :({{$leave->reject_not_date}}) </h4>
                                    <hr>
                                    <p>{{$leave->reject_not}}</p><br>


                                    <?php if (!empty($leave->reject_not_hr_date)) { ?>
                                        <h4>HR :({{$leave->reject_not_hr_date}}) </h4>
                                        <hr>
                                        <p>{{$leave->reject_not_hr}}</p><br>
                                    <?php } ?>

                                </div>


                                <div class="modal-footer">
                                    <a href="#!" class="modal-action modal-close  btn-color btn-flat">Close</a>
                                </div>
                            </div>
                        </td>
                        <td>
                            <?php if (($leave->status == '4')) { ?>
                                <a href="{{route('hrms.leaverequest.hr.approve.edit', ['id' => $leave->id])}}" class = "invoice-action-edit edit" id = "{{$leave->id}}"><i class="material-icons">edit</i></a>
                            <?php } ?>
                        </td>

                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="card-panel" style="padding-bottom: 34px;">
    <h4 class="title-color"><span>Lead Approval</span></h4>
    <table class="display striped">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th>Lead Name</th>
                <th>Lead Create Date</th>
                <th>Employee</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($getAllLeads as $key => $getAllLeads) { ?>
                <tr>
                    <td width="5%" >{{++$key}}</td>
                    <td>{{$getAllLeads->name}}</td>
                    <td>{{$getAllLeads->lead_create_date}}</td>
                    <td>{{$getAllLeads->assign_employee_empName}}</td>
                    <td> 
                        <?php
                        if ($getAllLeads->lead_progress_status == '1') {
                            echo 'Approved';
                        } else if ($getAllLeads->lead_progress_status == '0') {
//                            echo 'not Approval';
                        }
                        ?>
                    </td>
                    <td>
                        <?php
                        if ($getAllLeads->lead_progress_status == '1') {
                            ?>
                            <span class="badge green" style="width:79px;height: 24px;">Approved</span>
                            <?php
                        } else if ($getAllLeads->lead_progress_status == '0') {
                            ?>
                            <a href="{{route('leads.status',['lead_id'=>$getAllLeads->lead_id,'date'=>$getAllLeads->lead_create_date])}}">
                                <span class="badge black" style="width:79px;height: 24px;">Apply</span>
                            </a>
                            <?php
                        }
                        ?>

                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>


</div>
<?php // echo '[ ' . $end_date . ' -  ' . $start_date . '] - ' . $ddl_date . 'Days';  ?>
<div class="table-responsive shadow-lg p-3 mb-5 bg-white rounded">
    <h3 class="h3 display hed">Employee wise Leads</h3>
    <table id="employee_wise_lead_table" class="table table-striped table-hover multiselect">
        <thead>
            <tr>
                <th>Employee Name</th>
                <th>Total Lead</th>
            </tr>
        </thead>
        <tbody>
            @foreach($emp_lead_masters_table as $key => $data)
            <tr>
                <td>
                    {{ucfirst($data->Name)}}
                    <!--<a href="/dashboard/graph_emp_lead/{{$data->user_id}}">{{ucfirst($data->Name)}} </a>-->
                </td>
                <td>
                    <?php
                    echo app('App\Http\Controllers\DashboardController')->getLeadByUser_id($data->id, $end_date, $start_date);
                    ?>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
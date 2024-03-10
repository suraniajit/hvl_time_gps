<?php // echo '[ ' . $end_date . ' -  ' . $start_date . '] - ' . $ddl_date . 'Days';  ?>
<div class="table-responsive shadow-lg p-3 mb-5 bg-white rounded">
    <h3 class="h3 display hed">Employee wise Revenue</h3>
    <table id="employee_wise_revenue_table" class="table table-striped table-hover multiselect">
        <thead>
            <tr>
                <th>Employee Name</th>
                <th>Total Revenue</th>
            </tr>
        </thead>
        <tbody>

            @foreach($emp_lead_masters_table as $key => $lead_detail)
            <tr>
                <td>
                    {{ucfirst($lead_detail->Name)}}
                    <!--<a href="/dashboard/graph_emp_lead/{{$lead_detail->user_id}}"> {{ucfirst($lead_detail->Name)}} </a></td>-->
                <td>
                    <?php
                    echo $data = app('App\Http\Controllers\DashboardController')->getRevenueByUser_id($lead_detail->user_id, $end_date, $start_date);
                    ?>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
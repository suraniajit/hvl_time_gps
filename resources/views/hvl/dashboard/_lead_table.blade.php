<div class="table-responsive shadow-lg p-3 mb-5 bg-white rounded">
    <table id="source_lead_table" class="table table-striped table-hover multiselect">
        <thead>
            <tr>
                <th>Lead Source</th>
                <th>No of Leads</th>
            </tr>
        </thead>
        <tbody>

            @foreach($leadSource_masters as $key => $data)
            <tr>
                <td>{{ucfirst($data->Name)}} </td>
                <td>
                    <?php
//                    echo $TotalLeadCount = app('App\Http\Controllers\DashboardController')->getLeadSourceBylead_id($data->id);
                    echo $TotalLeadCount = app('App\Http\Controllers\DashboardController')->getLeadSourceBylead_id($data->id, $end_date, $start_date);
                    ?>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
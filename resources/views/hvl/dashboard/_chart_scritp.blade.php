<script type="text/javascript">
   
    // Load google charts
    google.charts.load('current', {'packages': ['corechart']});
    google.charts.setOnLoadCallback(drawChart);
// Draw the chart and set the chart values
 function drawChart() {

    // Display the chart inside the <div> element with id="piechart"
    var data_leadSource = google.visualization.arrayToDataTable([
    ['id', 'Name'],
            @php
            foreach($leadSource_masters as $leads) {
//    echo "['".$leads->Name."', ".app('App\Http\Controllers\DashboardController')->getLeadSourceBylead_id($leads->id)."],";
                echo "['".$leads->Name."', ".app('App\Http\Controllers\DashboardController')->getLeadSourceBylead_id($leads->id,$end_date,$start_date)."],";
            }
    @endphp
    ]);
    var options_leadSource = {
        'title': 'Lead Sourcewise',
        'width': 550,
        'height': 575,
        'pieHole': 0.2,
        'sliceVisibilityThreshold': 0,
    };
    var chart_leadSource = new google.visualization.PieChart(document.getElementById('lead_chart_piechart_'));
    chart_leadSource.draw(data_leadSource, options_leadSource);
//****************************************************************************************************************************************************


    var asset_data = google.visualization.arrayToDataTable([
    ['id', 'Name'],
            @php
            foreach($emp_lead_masters as $emps) {
                echo "['".$emps->Name."', ".app('App\Http\Controllers\DashboardController')->getLeadByUser_id($emps->id,$end_date,$start_date)."],";
            }
    @endphp
    ]);
    var asset_options_ = {
        'title': 'Employee wise Leads',
        'width': 550,
        'height': 600,
        'pieHole': 0.2,
        'sliceVisibilityThreshold': 0,
    };
    var asset_pieChart = new google.visualization.PieChart(document.getElementById('assetchart_'));
    asset_pieChart.draw(asset_data, asset_options_);
//****************************************************************************************************************************************************
//    var asset_options = {'title': 'Employee wise Leads (ColumnChart)', 'width': 750, 'height': 600};
//    var asset_chart = new google.visualization.ColumnChart(document.getElementById('assetchart'));
//    asset_chart.draw(asset_data, asset_options);
//****************************************************************************************************************************************************

    var employee_revenue_data = google.visualization.arrayToDataTable([
    ['id', 'Name'],
            @php
            foreach($emp_lead_masters as $emps) {
                echo "['".$emps->Name."', ".app('App\Http\Controllers\DashboardController')->getRevenueByUser_id($emps->user_id,$end_date,$start_date)."],";
            }
            @endphp
    ]);
    var employee_revenue_options_ = {
        'title': 'Employee wise Revenue', 
        'width': 550,
        'height': 600,
        'pieHole': 0.2,
        'sliceVisibilityThreshold': 0,
    };
    var employee_revenue_pieChart = new google.visualization.PieChart(document.getElementById('employee_revenue_chart_'));
    employee_revenue_pieChart.draw(employee_revenue_data, employee_revenue_options_);
    }

</script>
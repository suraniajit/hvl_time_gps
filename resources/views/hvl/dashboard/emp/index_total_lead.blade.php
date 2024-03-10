@extends('app.layout')

{{-- page title --}}
@section('title','User Management | HVL')

@section('content')

<section>
    <div class="container-fluid">
        <header>
            <div class="row">
                <div class="col-md-7">
                    <h2 class="h3 display">Employess Total Lead {{$total_lead_count}}</h2>
                </div>
            </div>
        </header>
        <!-- Page Length Options -->
        <div class="card"> 
            <br>
            <div class="col-sm-6 col-md-12">
                <form action="{{route('dashboard.graph_emp_lead_filter')}}" method="post">
                    <input type="hidden" name="employee_id" id="employee_id" value="{{(!empty($id) ? $id : $id)}}">
                    <div class="row">
                        <div class="col-sm-6 col-md-3">
                            <input type="text" name="start" class="form-control datepicker" placeholder="Enter Start Date" autocomplete="off" autofocus="off" value="{{(!empty($mindate) ? $mindate : '')}}">
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <input type="text" name="end" class="form-control datepicker" placeholder="Enter End Date" autocomplete="off" autofocus="off" value="{{(!empty($maxdate) ? $maxdate : '')}}">
                        </div>
                        <div class="col-sm-6 col-md-1">
                            <button type="submit" class="btn btn-primary">Search</button>
                        </div>
                        <div class="col-sm-6 col-md-1">
                            <a class="btn btn-primary" href="/users">Reset</a>
                        </div>
                    </div>
                </form>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-6">
                        <div id="lead_chart_piechart_" class="shadow-lg p-3 mb-5 bg-white rounded"></div>
                    </div>
                    <div class="col-sm-6">
                        <div id="lead_chart_piechart_revenue" class="shadow-lg p-3 mb-5 bg-white rounded"></div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table id="page-length-option" class="table table-striped table-hover multiselect">
                        <thead>
                            <tr>
                                <th>Company Name</th>
                                <th>Revenue</th>
                                <th>Create Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($total_lead_details as $key => $total_lead_detail)
                            <tr>
                                <td>
                                    {{$total_lead_detail->last_company_name}}
                                </td>

                                <td>
                                    {{$total_lead_detail->revenue}}
                                </td>
                                <td>
                                    {{$total_lead_detail->create_date}}
                                </td>

                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@section('page-script')
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
$(document).ready(function () {
$('#page-length-option').DataTable({
"scrollX": true,
        "fixedHeader": true,
        "lengthMenu": [[10, 25, 50, 100, - 1], [10, 25, 50, 100, "All"]],
        dom: 'Blfrtip',
        buttons: [
                'colvis'
        ]
});
$('.datepicker').datepicker({
format: 'yyyy-mm-dd',
        autoclose: true,
        todayHighlight: true
});
});
// Load google charts
google.charts.load('current', {'packages': ['corechart']});
google.charts.setOnLoadCallback(drawChart);
// Draw the chart and set the chart values
function drawChart() {
// Display the chart inside the <div> element with id="piechart"
var data_leadSource = google.visualization.arrayToDataTable([
['id', 'last_company_name'],
        @php
        foreach($total_lead_chartDatas as $lead_chart) {
echo "['".$lead_chart->last_company_name."', 10],";
}
@endphp
]);
var options_leadSource = {'title': 'filter Lead Source', 'width': 550, 'height': 400};
var chart_leadSource = new google.visualization.PieChart(document.getElementById('lead_chart_piechart_'));
chart_leadSource.draw(data_leadSource, options_leadSource);
//     ******************************************************************************
var data_leadSource_ = google.visualization.arrayToDataTable([
['id', 'last_company_name'],
        @php
        foreach($total_lead_chartDatas as $lead_chart) {
echo "['".$lead_chart->last_company_name."', ".$lead_chart->revenue."],";
}
@endphp
]);
var options_leadSource_ = {'title': 'filter Lead Source Revenue', 'width': 550, 'height': 400};
var chart_leadSource_ = new google.visualization.PieChart(document.getElementById('lead_chart_piechart_revenue'));
chart_leadSource_.draw(data_leadSource_, options_leadSource_);
}
</script>
@endsection

@extends('app.layout')
{{-- page title --}}
@section('title','Dashboard Management | HVL')

@section('vendor-style')
<!--https://codeactually.com/googlecharts.html-->
<style>
    .dataTables_info{
        display: none;
    }
    .hed{
        text-align: center;
        font-size: revert;
        color: red;
    }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class=" p-4">
            <div class="card-body">
                <u>
                    <h2 class="h3 display hed">Sourcewise Report</h2>
                </u>
                <br>
                <div class="row">
                    <div class="col-sm-6 col-md-12">
                        <form action="{{route('dashboard.graph_filter')}}" method="post">
                            <input type="hidden" name="employee_id" id="employee_id" value="{{(!empty($id) ? $id : '')}}">
                            <div class="row">
                                <div class="col-sm-6 col-md-3">
                                    <input type="text" name="start" class="form-control datepicker" placeholder="Enter Start Date" autocomplete="off" autofocus="off" value="{{(!empty($mindate) ? $mindate : date('Y-m-d'))}}">
                                </div>
                                <div class="col-sm-6 col-md-3" style="display: none;">
                                    <input type="text" name="end" class="form-control datepicker" placeholder="Enter End Date" autocomplete="off" autofocus="off" value="{{(!empty($maxdate) ? $maxdate : '')}}">
                                </div>
                                <div class="col-sm-6 col-md-3">
                                    <select class="form-control"  name="ddl_date" id="ddl_date">
                                        <option value="" disable="" selected>Select Interval</option>
                                        <option value="30" @if($ddl_date == '30') selected @endif >Last 30 days</option>
                                        <option value="60" @if($ddl_date == '60') selected @endif >Last 60 days</option>
                                        <option value="90" @if($ddl_date == '90') selected @endif >Last 90 days</option>
                                        <option value="120" @if($ddl_date == '120') selected @endif >Last 120 days</option>
                                        <option value="180" @if($ddl_date == '180') selected @endif >Last 180 days</option>
                                        <option value="360" @if($ddl_date == '360') selected @endif >Last 360 days</option>
                                        <option value="420" @if($ddl_date == '420') selected @endif >Last 420 days</option>
                                    </select>
                                    </select>
                                </div>
                                <div class="col-sm-6 col-md-1">
                                    <button type="submit" class="btn btn-primary">Search</button>
                                </div>
                                <div class="col-sm-6 col-md-1">
                                    <a class="btn btn-primary" href="/dashboard">Reset</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        @include('hvl.dashboard._lead_table')
                    </div>
                    <div class="col-sm-6">
                        <div id="lead_chart_piechart_" class="shadow-lg p-3 mb-5 bg-white rounded"></div>
                    </div>
                </div>

                <!--            <div class="card-body">
                                <h2 class="h3 display">Employee wise no of leads</h2>
                                <br>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div id="assetchart" class="shadow-lg p-3 mb-5 bg-white rounded"></div>
                                    </div>
                                </div>
                            </div>-->


                <div class="row">

                    <div class="col-sm-6">

                        @include('hvl.dashboard.employee_wise_lead_table')
                        <br>
                        <div id="assetchart_" class="shadow-lg p-3 mb-5 bg-white rounded"></div>
                    </div>
                    <div class="col-sm-6">

                        @include('hvl.dashboard.employee_wise_revenue_table')

                        <br>
                        <div id="employee_revenue_chart_" class="shadow-lg p-3 mb-5 bg-white rounded"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
{{-- page script --}}
@section('page-script') 
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">

$(document).ready(function () {
    $('#source_lead_table').DataTable({
        //                "scrollX": true
    });
    $('#employee_wise_lead_table').DataTable({
        //                "scrollX": true
    });
    $('#employee_wise_revenue_table').DataTable({
        //                "scrollX": true
    });
    $('.datepicker').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        todayHighlight: true
    });
});
</script>
@include('hvl.dashboard._chart_scritp')
@endsection









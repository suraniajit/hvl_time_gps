
@extends('app.layout')

{{-- page title --}}
@section('title','Customer Admin Dashboad | HVL')
@section('vendor-style')
<style>
</style>
@endsection
@section('content')
    <section>
        <div class="container-fluid">
            <header>
                <div class="row">
                    <div class="col-md-7">
                        <h2 class="h3 display">Customer Dashboad</h2>
                    </div>
                    <div class="col-md-5">
                        <a class="btn btn-primary rounded-pill pull-right mr-2 " data-toggle="modal" data-target="#modal_download">
                            <span class="fa fa-download fa-lg"></span> Download
                        </a>
                    </div>
                </div>
            </header>
            <div class="card">
                @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show center-block" role="alert">
                    <strong>{!! \Session::get('success') !!} </strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @endif
                <div class="card-body">
                    <div class="">
                        <form action="{{route('customer.dashboad.index')}}" method="get">
                            <div class="row">
                                <div class="col-sm-6 col-md-2">
                                    <select id="customer_id" name="customer_id[]" class="form-control select" multiple required>
                                    @foreach($customers as $key=>$customer_option)
                                        <option value="{{$key}}">{{$customer_option}}</option>
                                    @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-6 col-md-2">
                                    <input type="text" name="start" class="form-control datepicker" value="{{(isset($search_sdate)?$search_sdate:'')}}" autocomplete="off" placeholder="Enter Start Date" required>
                                </div>
                                <div class="col-sm-6 col-md-2">
                                    <input type="text" name="end" class="form-control datepicker" value="{{(isset($search_edate)?$search_edate:'')}}" autocomplete="off" placeholder="Enter End Date" required>
                                </div>
                                <div class="col-sm-6 col-md-1">
                                    <button type="submit" class="btn btn-primary"> Search</button>
                                </div>
                                <div class="col-sm-4 col-md-1" style="padding: 0px;">
                                    <a class="btn btn-primary" href="{{route('customer.dashboad.index')}}">Reset</a>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="table-responsive mt-4" style="display:none">
                        <center>
                        <table class="table table-striped table-hover ">
                            <thead>
                                <tr>
                                    <th>id</th>
                                    <th>Customer</th>
                                    <th>Subject</th>
                                    <th>Branch</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Status</th>
                                    <th>Frequency</th>
                                    <th>Completion date</th>
                                    <th>Remark</th>
                                    <th>Job update</th>
                                    <th>Audit update</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($activities as  $key=>$activity)
                                <tr>
                                    <td>{{$key+1}}</td>
                                    <td>{{$customers[$activity->customer_id]}}</td>
                                    <td>{{$activity->subject}}</td>
                                    <td>{{$branchs[$activity->branch_name]}}</td>
                                    <td>{{$activity->start_date}}</td>
                                    <td>{{$activity->end_date}}</td>
                                    <td>{{$activity_status[$activity->status]}}</td>
                                    <td>{{$activity->frequency}}</td>
                                    <td>{{$activity->complete_date}}</td>
                                    <td>{{$activity->remark}}</td>
                                    <td>{{ (isset($jobcardupdated[$activity->id]))?$jobcardupdated[$activity->id]:((isset($hvl_job_cards[$activity->id]))?$hvl_job_cards[$activity->id]:'') }}</td>
                                    <td>{{(isset($hvl_audit_reports[$activity->id]))?$hvl_audit_reports[$activity->id]:''}}</td>
                                </tr>
                               @endforeach
                            </tbody>
                        </table>
                        </center>
                    </div>
                </div>
            </div>
              
            
        </div>
        <div id="acticitychart">             
                    <div class="alert alert-danger alert-dismissible fade show center-block" role="alert">
                        <strong>No Data Found</strong>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>  
    </section>
    <div id="modal_download" tabindex="-1" role="dialog" aria-hidden="true" class="modal fade text-left">
        <div role="document" class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Download Report</h4>
                    <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body p-4 row">
                    <div class="col-sm-6">
                        <div class="card">
                            <div class="card-body text-center ">
                                <button class="btn btn-success " onclick="exportTableToCSV('ActivityStatus.csv')">
                                    <span class="fa fa-file-excel-o fa-3x text-green"></span>
                                    CSV
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="card">
                            <div class="card-body text-center">
                                <button class="btn btn-primary center" data-toggle="modal" data-target=".email_div">
                                    <span class="fa fa-envelope fa-3x text-danger"></span>
                                    Email
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div  tabindex="-1" role="dialog" aria-hidden="true" class="modal fade text-left email_div">
        <div role="document" class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Send Mail</h4>
                    <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body p-4 row">
                    <div class="col-sm-12">
                        <form action="{{ route('customer.mail.activitystatus') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="form-group col-sm-12 col-md-6">
                                    <label for="">To</label>
                                    <input type="email" class="form-control" name="to" required>
                                </div>
                                <div class="form-group col-sm-12 col-md-6">
                                    <label for="">Subject</label>
                                    <input type="text" class="form-control" name="subject" value="" required>
                                </div>
                                <div class="form-group col-sm-12 col-md-12">
                                    <label for="">Body</label>
                                    <textarea class="form-control" id="mail_body"  name="body"></textarea>
                                </div>
                                <div class="col-sm-12">
                                    <input type="submit" class="btn btn-success rounded" value="Send">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('page-script')
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script>
    $(document).ready(function () {
        $('.select').multiselect({
            includeSelectAllOption: true,
            enableFiltering: true,
            enableCaseInsensitiveFiltering: true,
            filterPlaceholder: 'Search for Customer...',
            nonSelectedText: 'Select Customer',
            maxHeight: 450
        });
        $('.datepicker').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            todayHighlight: true
        });

    });
</script>
<script type="text/javascript">
    // Load google charts
    @if(!empty($activityStatusCounter))
        google.charts.load('current', {'packages': ['corechart']});
        google.charts.setOnLoadCallback(drawChart);
    @endif
    // Draw the chart and set the chart values 
    function drawChart() {
        // Display the chart inside the <div> element with id="piechart"
        var data_leadSource = google.visualization.arrayToDataTable([
        ['id', 'Name'],
        @foreach( $activity_status as $rowDt)
            @if(isset($activityStatusCounter[$rowDt]))
            ['{{$rowDt}}',{{$activityStatusCounter[$rowDt]}}],
            @endif
        @endforeach
        ]);
        var options_leadSource = {
            'title': 'Activity Status',
            'width': 550,
            'height': 575,
            'pieHole': 0.2,
            'sliceVisibilityThreshold': 0,
        };
        var chart_leadSource = new google.visualization.PieChart(document.getElementById('acticitychart'));
        chart_leadSource.draw(data_leadSource, options_leadSource);
    }
    function exportTableToCSV(filename) {
        var csv = [];
        var rows = document.querySelectorAll("center table tr");
        for (var i = 0; i < rows.length; i++) {
            var row = [],
                    cols = rows[i].querySelectorAll("td, th");
            for (var j = 0; j < cols.length; j++)
                if (j !== 0) {
                    if (j !== cols.length - 0) {
                        row.push(cols[j].innerText);
                    }
                }
            csv.push(row.join(","));
        }
        // Download CSV file
        downloadCSV(csv.join("\n"), filename);
    }
    function downloadCSV(csv, filename) {
        var csvFile;
        var downloadLink;
        // CSV file
        csvFile = new Blob([csv], {
            type: "text/csv"
        });
        // Download link
        downloadLink = document.createElement("a");
        // File name
        downloadLink.download = filename;
        // Create a link to the file
        downloadLink.href = window.URL.createObjectURL(csvFile);
        // Hide download link
        downloadLink.style.display = "none";
        // Add the link to DOM
        document.body.appendChild(downloadLink);
        // Click download link
        downloadLink.click();
    }
</script>
@endsection



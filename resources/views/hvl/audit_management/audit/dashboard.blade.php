@extends('app.layout')
{{-- page title --}}
@section('title','Activity Management | HVL')
@section('vendor-style')
<link rel="stylesheet" href="https://cdn.datatables.net/datetime/1.1.0/css/dataTables.dateTime.min.css">
@endsection
@section('content')
<section>
    <div class="container-fluid">       
        <header>
            <div class="row">
                <div class="col-md-4">
                    <h2 class="h3 display">Genarated Vs In Process</h2>
                </div>
            </div>
        </header>
        <div class="row">
            <div class="col-sm-6 col-md-12">
                <form action="{{route('admin.audit.dashboard')}}" method="post">
                    <div class="row">
                        <div class="col-sm-6 col-md-3">
                            <input type="text" name="start" class="form-control datepicker" placeholder="Enter Start Date" autocomplete="off" autofocus="off" value="{{($sdate)?$sdate:''}}">
                        </div>
                        <div class="col-sm-6 col-md-3" >
                            <input type="text" name="end" class="form-control datepicker" placeholder="Enter End Date" autocomplete="off" autofocus="off" value="{{($edate)?$edate:''}}">
                        </div>
                        <div class="col-sm-6 col-md-1">
                            <button type="submit" class="btn btn-primary">Search</button>
                        </div>
                        <div class="col-sm-6 col-md-1">
                            <a class="btn btn-primary" href="{{route('admin.audit.dashboard')}}">Reset</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="card" >    
            <div class="row">
                <div class="col-sm-6">
                    <div class="chart-container" style="position: relative; height:40vh; width:80vw">
                        <canvas  id="audit_generate_chart"></canvas>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div>
                        <table class="table">
                            <thead class="thead-dark">
                                <tr>
                                <th scope="col">#</th>
                                <th scope="col">Status</th>
                                <th scope="col">No Of Audit</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i=1;?>
                                @foreach($genarated_inprocess as $key=>$row)
                                <tr>
                                    <th scope="row">{{$i}}</th>
                                    <td>{{$key}}</td>
                                    <td>{{$row}}</td>
                                </tr>
                                <?php $i++;?>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <header>
            <div class="row">
                <div class="col-md-4">
                    <h2 class="h3 display">Adhoc Vs Planed</h2>
                </div>
            </div>
        </header>
        <div class="card" >    
            <div class="row">
                <div class="col-sm-6">
                    <div>
                        <table class="table">
                            <thead class="thead-dark">
                                <tr>
                                <th scope="col">#</th>
                                <th scope="col">Audit Type</th>
                                <th scope="col">No Of Audit</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i=1;?>
                                @foreach($adhoc_planed as $key=>$row)
                                <tr>
                                    <th scope="row">{{$i}}</th>
                                    <td>{{$key}}</td>
                                    <td>{{$row}}</td>
                                </tr>
                                <?php $i++;?>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="chart-container" style="position: relative; height:40vh; width:80vw">
                        <canvas  id="adhoc_planned_chart"></canvas>    
                    </div>
                </div>
            </div>
        </div>
        <header>
            <div class="row">
                <div class="col-md-4">
                    <h2 class="h3 display">Day wise Audit</h2>
                </div>
            </div>
        </header>
        <div class="card" >    
            <div class="row">
                <div class="col-sm-6">
                    <div>
                        <canvas  id="day_wise_schedule_chart"></canvas> 
                    </div>
                </div>
                <div class="col-sm-6">
                    <div>
                        <div class="table-responsive mt-4">
                            <table  id="page-length-option" class="table table-striped table-hover multiselect">
                                <thead class="thead-dark">
                                    <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Time</th>
                                    <th scope="col">No Of Audit</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i=1;?>
                                    @foreach($day_wise_audit as $key=>$row)
                                    <tr>
                                        <th scope="row">{{$i}}</th>
                                        <td>{{$key}}</td>
                                        <td>{{$row}}</td>
                                    </tr>
                                    <?php $i++;?>
                                    @endforeach
                                </tbody>
                            </table>
</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@section('page-script')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    $('.datepicker').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        todayHighlight: true
    });
    const ctx = document.getElementById('audit_generate_chart');
    new Chart(ctx, {
            type: 'pie',
            data: {
            labels: ["<?=implode('","',array_keys($genarated_inprocess))?>"],
            datasets: [{
                data: [{{implode(',',$genarated_inprocess)}}],
                borderWidth: 1
            }]
            },
            options: {    
            scales: {
                y: {
                beginAtZero: true
                }
            }
        }
    });
</script>
<script>
    const ctx2 = document.getElementById('adhoc_planned_chart');
    new Chart(ctx2, {
        type: 'doughnut',
        data: {
        labels: ["<?=implode('","',array_keys($adhoc_planed))?>"],
        datasets: [{
            data: [{{implode(',',$adhoc_planed)}}],
            borderWidth: 1
        }]
        },
        options: {    
        scales: {
            y: {
            beginAtZero: true
            }
        }
        }
    });
</script>
<script>  
    const labels = ["<?=implode('","',array_keys($day_wise_audit))?>"];
    @php $border_color=[];@endphp
    const data = {
        labels: labels,
        datasets: [{
            label: 'Time Wise Audit Schedule',
            data: [{{implode(',',$day_wise_audit)}}],
            backgroundColor: [
                @foreach($day_wise_audit as $row)
                    @php
                    $color = "'rgba(".rand(1,255).",".rand(1,255).",".rand(1,255); 
                    $border_color [] = $color;
                    @endphp 
                    <?=$color?>, 0.2)',    
                @endforeach
            ],
            borderColor: [
            @foreach($border_color as $clr)
            <?=$clr?>)',
            @endforeach
            ],
            borderWidth: 1
        }]
    };
const ctx3 = document.getElementById('day_wise_schedule_chart');
    new Chart(ctx3, {
        type: 'bar',
        data: data,
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        },
    });
 
</script>

@endsection
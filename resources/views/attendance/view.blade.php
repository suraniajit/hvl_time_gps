{{-- layout --}}
@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title','Attendance Master')

{{-- vendor styles --}}
@section('vendor-style')
<link rel="stylesheet" type="text/css" href="{{asset('css/data-tables/buttons.dataTables.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/materialize.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/data-tables/css/jquery.dataTables.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/data-tables/extensions/responsive/css/responsive.dataTables.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('css/data-tables/buttons.dataTables.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/vendors.min.css')}}">
@endsection

{{-- page style --}}
@section('page-style')
<style>
    .time {
        padding-left: 1% !important;
        padding-right: 1% !important;
    }
    .btn-text {
        margin-left: 5px !important;
    }
    div.dt-buttons {
        float: left;
    }
    .badge{
        position: initial !important;
    }
</style>
<link rel="stylesheet" type="text/css" href="{{asset('css/pages/app-calendar.css')}}">
@endsection

{{-- page content --}}
@section('content')
<div class="card">
    <div class="card-content">
        <div class="row">
            <div class="col s9"><h5>Employee Name : @foreach($name as $n){{$n->Name}}@endforeach</h5></div>
            <div class="col s12">
                <table id="singleattendance_datatable" class="display" >
                    <thead>
                        <tr>

                            <th style="display: none">Employee Name</th>
                            <th>Date</th>
                            <th>Check In time</th>
                            <th>Check Out time</th>
                            <th>Months</th>
                            <th>calcau</th>
                            <th>Total Working Days</th>
                            <th>Total Hours</th>
                            <th>Status</th>
                            <th>checkout_type</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1 ?>
                        @foreach($AttendanceData as $key => $Details)
                        <tr>

                            <td style="display: none">{{$Details->full_Name}}</td>
                            <td>{{$Details->date}}</td>
                            <td>{{$Details->check_in}}</td>
                            <td>{{$Details->check_out}}</td>
                            <td>{{$Details->shift_name}}-{{$Details->id}}</td>
                            <td><?php
                                $d = date_parse_from_format("Y-m-d", $Details->date);
                                echo $year = $d["year"];
                                echo '-' . $month = $d["month"];
                                ?></td>
                            <td>
                                <!--//*total wokring days*//-->

                                <?php
                                $shift_total_days = $Details->total_days;
                                $wor = 0;
                                if ($shift_total_days == 7) {
                                    $wor = array(1, 2, 3, 4, 5, 6, 0);
                                }
                                if ($shift_total_days == 6) {
                                    $wor = array(1, 2, 3, 4, 5, 6);
                                }
                                if ($shift_total_days == 5) {
                                    $wor = array(1, 2, 3, 4, 5);
                                }
                                if ($shift_total_days == 4) {
                                    $wor = array(1, 2, 3, 4);
                                }
                                if ($shift_total_days == 3) {
                                    $wor = array(1, 2, 3);
                                }
                                if ($shift_total_days == 2) {
                                    $wor = array(1, 2);
                                }
                                if ($shift_total_days == 1) {
                                    $wor = array(1);
                                }

                                echo $MonthsCountDays = app('App\Http\Controllers\payroll\PayrollController')->MonthsCountDays($year, $month, $wor);
                                ?>
                            </td>
                            <td>{{$Details->total_hours}}</td>
                            <td> 
                                <?php if ($Details->status == '1') { ?>
                                    <span class="badge green lighten-5 green-text text-accent-4">Present</span>   
                                <?php } else if ($Details->status == null) { ?>
                                    <span class="badge pink lighten-5 pink-text text-accent-2">Check in</span>
                                <?php } else if ($Details->status == '0') { ?>
                                    <span class="badge pink lighten-5 pink-text text-accent-2">Absent</span>
                                <?php } ?>
                            </td>
                            <td>
                                <?php if ($Details->status == null) { ?>
                                                                                    <!--<span class="badge pink lighten-5 pink-text text-accent-2">Check in</span>-->

                                <?php } else { ?>
                                    <!--1-Self Checkout | 0-System Checkout-->
                                    <?php if ($Details->checkout_type == '1') { ?>
                                        <span class="badge green lighten-5 green-text text-accent-4">Self</span>   
                                    <?php } else if ($Details->status == null) { ?>
                                        <span class="badge pink lighten-5 pink-text text-accent-2">System</span>
                                    <?php } else { ?>
                                        <span class="badge pink lighten-5 pink-text text-accent-2">Admin</span>
                                    <?php } ?>
                                <?php } ?>


                            </td>
                        </tr>
                        <?php $i++ ?>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="row">
            <div class="col s12">
                <div id="basic-calendar"></div>
            </div>
            <input type="hidden" value="{{$id}}" id="id">
        </div>
    </div>
</div>

@endsection

{{-- vendor scripts --}}
@section('vendor-script')
<script src="{{asset('js/ajax/jquery.min.js')}}"></script>
<script src="{{asset('js/ajax/angular.min.js')}}"></script>
<script src="{{asset('js/materialize.js')}}"></script>
<script src="{{asset('vendors/data-tables/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('vendors/data-tables/extensions/responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('js/ajax/sweetalert.min.js')}}"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
<script src="{{asset('js/ajax/datatables/jszip.min.js')}}"></script>
<script src="{{asset('js/ajax/datatables/pdfmake.min.js')}}"></script>
<script src="{{asset('js/ajax/datatables/vfs_fonts.js')}}"></script>
<script src="{{asset('js/ajax/datatables/buttons.html5.min.js')}}"></script>
@endsection

{{-- page script --}}
@section('page-script')
<script src="{{asset('js/scripts/app-calendar.js')}}"></script>
<script src="{{asset('js/scripts/advance-ui-modals.js')}}"></script>
@endsection




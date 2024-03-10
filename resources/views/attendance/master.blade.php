{{-- layout --}}
@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title','Attendance Master')


{{-- vendor styles --}}
@section('vendor-style')
<!-- BEGIN: VENDOR CSS-->
<link rel="stylesheet" type="text/css" href="{{ asset('vendors/vendors.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('vendors/data-tables/css/jquery.dataTables.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('vendors/data-tables/extensions/responsive/css/responsive.dataTables.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('vendors/data-tables/css/select.dataTables.min.css') }}">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.6.2/css/buttons.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="{{ asset('css/pages/data-tables.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('css/pages/form-select2.css') }}">
@endsection




{{-- page content --}}
@section('content')
<div class="section section-data-tables">
    <div class="card">
        <div class="card-content">
            <div class="row">
                <div class="col s12">
                    <div class="col s6">
                        <h5 class="title-color"><span>Attendance Master</span></h5>
                    </div>
                    <div class="col s6">
                        <span class="badge pink lighten-5 pink-text text-accent-2">
                            Today's Date : {{$today_date}}
                        </span>
                    </div>
                </div>

            </div>

            <div class="row">
                <div class="col s12">
                    <ul class="tabs">
                        <li class="tab col m3"><a class="active" href="#TodayAttendance">Today Attendance</a></li>
                        <li class="tab col m3"><a href="#AllAttendance">All Attendance</a></li>
                    </ul>
                </div>
                <div id="TodayAttendance" class="col s12">
                    <br>
                    <table id="page-length-option" class="display multiselect">
                        <thead>
                            <tr>
                                <th style="width: 5%">#ID</th>
                                <th>Employee Name</th>

                                <th>Date</th>
                                <th>Check In</th>
                                <th>Check Out</th>
                                <th>Total Hours</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                            @foreach($todayAttendanceDetails as $key => $Details)
                            <tr>

                                <td>{{$key+=1}}
                                    <?php
//                            echo $firstChar = mb_substr($Details->full_Name, 0, 1, "UTF-8");
                                    ?>
                                </td>
                                <td>{{$Details->full_Name}}</td>

                                <td>{{$Details->date}}</td>
                                <td>{{$Details->check_in}}</td>
                                <td>{{$Details->check_out}}</td>
                                <td>{{$Details->total_hours}}</td>

                                <td> 
                                    <?php if ($Details->status == '1') { ?>
                                        <span class="badge green lighten-5 green-text text-accent-4">Present</span>   
                                    <?php } else if ($Details->status == null) { ?>
                                        <span class="badge pink lighten-5 pink-text text-accent-2">Check in</span>
                                    <?php } else { ?>
                                        <span class="badge pink lighten-5 pink-text text-accent-2">Absent</span>
                                    <?php } ?>
                                </td>
                                <td>
                                    <a href = "{{route('attendance.view', ['id' => $Details->user_id])}}" 
                                       class="invoice-action-edit edit tooltipped mr-10"
                                       data-position="top"
                                       data-tooltip="View"
                                       id = {{$Details->user_id}}>
                                           <i class="material-icons">visibility</i>
                                       </a>
                                    </td>
                                </tr>
                               
                                @endforeach
                            </tbody>
                        </table>

                    </div>
                    <div id="AllAttendance" class="col s12">
 <br>
                        <table id="page-length-option" class="display multiselect">
                            <thead>
                                <tr>
                                    <th style="width: 5%">#ID</th>
                                        <th>Employee Name</th>
                                        <th>Shift Name</th>
                                        <th>Shift Time</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                    @foreach($AllAttendanceDetails as $key => $AllAttendanceDetail)
                                    <tr>

                                        <td> {{$key+=1}}
                                            <?php
//                            echo $firstChar = mb_substr($Details->full_Name, 0, 1, "UTF-8");
                                            ?>
                                        </td>
                                        <td>{{$AllAttendanceDetail->full_Name}}</td>
                                        <td>{{$AllAttendanceDetail->shift_name}}</td>
                                        <td>{{$AllAttendanceDetail->start_time}}
                                            -{{$AllAttendanceDetail->end_time}}</td>
                                        <td>
                                            <a href = "{{route('attendance.view', ['id' => $AllAttendanceDetail->user_id])}}" 
                                               class="invoice-action-edit edit tooltipped mr-10"
                                               data-position="top"
                                               data-tooltip="View"
                                               id = {{$AllAttendanceDetail->user_id}}>
                                                <i class="material-icons">visibility</i>
                                            </a>
                                        </td>
                                    </tr>

                                    @endforeach
                                </tbody>
                            </table>

                        </div>

                    </div>



                </div>
            </div>
        </div>
    </div>
    @endsection


    {{-- vendor script --}}
    @section('vendor-script')

    <script src="{{ asset('vendors/data-tables/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendors/data-tables/extensions/responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('vendors/data-tables/js/dataTables.select.min.js') }}"></script>

    <script src="{{ asset('vendors/select2/select2.full.min.js') }}"></script>


    <script src="{{ asset('vendors/sweetalert/sweetalert.min.js') }}"></script><!-- BEGIN THEME  JS-->

    <!-- END THEME  JS-->
    <script src="{{ asset('js/scripts/data-tables.js') }}"></script>
    <script src="https://cdn.datatables.net/colreorder/1.5.2/js/dataTables.colReorder.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.colVis.min.js"></script>

    <!-- BEGIN PAGE LEVEL JS-->
    <script src="{{ asset('js/scripts/extra-components-sweetalert.js') }}"></script>
    <!-- END PAGE LEVEL JS--><!-- BEGIN: Custom Page JS-->
    <script src="{{ asset('js/scripts/form-select2.js') }}"></script>
    <script src="{{ asset('js/scripts/ui-alerts.js') }}"></script>

    <script src="{{ asset('js/scripts/page-users.js') }}"></script>
    <script src="{{ asset('js/download-table.js') }}"></script>
    <script src="https://unpkg.com/jspdf@latest/dist/jspdf.min.js"></script>
    @endsection



    {{-- page script --}}
    @section('page-script')
    <script>
$(document).ready(function () {
    $('#mass_delete_id').click(function () {
        var checkbox_array = [];
        var token = $("meta[name='csrf-token']").attr("content");
        $.each($("input[name='selected_row']:checked"), function () {
            checkbox_array.push($(this).data("id"));
        });
        // console.log(checkbox_array);
        if (typeof checkbox_array !== 'undefined' && checkbox_array.length > 0) {

            swal({
                title: "Are you sure?",
                text: "You will not be able to recover these record!",
                icon: 'warning',
                dangerMode: true,
                buttons: {
                    cancel: 'No, Please!',
                    delete: 'Yes, Delete It'
                }
            }).then(function (willDelete) {
                if (willDelete) {
                    $.ajax({
                        url: '/training/course/massremove',
                        mehtod: "get",
                        data: {
                            "_token": token,
                            id: checkbox_array
                        },
                        success: function (result) {
                            swal("Record has been deleted!", {
                                icon: "success",
                            }).then(function () {
                                location.reload();
                            });
                        }
                    });
                } else {
                    swal(name + " Record is safe", {
                        title: 'Cancelled',
                        icon: "error",
                    });
                }
            });
        } else {
            swal({
                title: "0 Row selected!",
                text: "Select any record from the list",
                icon: 'warning',
            });
        }
    });

    var checkbox = $('.multiselect tbody tr td input');
    var selectAll = $('.multiselect .select-all');

    checkbox.on('click', function () {
        // console.log($(this).attr("checked"));
        $(this).parent().parent().parent().toggleClass('selected');
    });

    checkbox.on('click', function () {
        // console.log($(this).attr("checked"));
        if ($(this).attr("checked")) {
            $(this).attr('checked', false);
        } else {
            $(this).attr('checked', true);
        }
    });

    selectAll.on('click', function () {
        $(this).toggleClass('clicked');
        if (selectAll.hasClass('clicked')) {
            $('.multiselect tbody tr').addClass('selected');
        } else {
            $('.multiselect tbody tr').removeClass('selected');
        }

        if ($('.multiselect tbody tr').hasClass('selected')) {
            checkbox.prop('checked', true);

        } else {
            checkbox.prop('checked', false);

        }
    });


    $('.delete-record-click').click(function () {
        var id = $(this).data("id");
        var name = $(this).data("name");
        var token = $("meta[name='csrf-token']").attr("content");

        swal({
            title: "Are you sure?",
            text: "You will not be able to recover this record!",
            icon: 'warning',
            dangerMode: true,
            buttons: {
                cancel: 'No, Please!',
                delete: 'Yes, Delete It'
            }
        }).then(function (willDelete) {
            if (willDelete) {
                $.ajax({
                    url: '/training/course/removedata',
                    mehtod: "get",
                    data: {
                        "_token": token,
                        'id': id
                    },
                    success: function (result) {
                        swal("Record has been deleted!", {
                            icon: "success",
                        }).then(function () {
                            location.reload();
                        });
                    }
                });
            } else {
                swal(name + " Record is safe", {
                    title: 'Cancelled',
                    icon: "error",
                });
            }
        });
    });

});
    </script>
    @endsection



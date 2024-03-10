{{-- layout --}}
@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title','Attendance')

{{-- vendor styles --}}
@section('vendor-style')
{{--Calendar--}}

<link rel="stylesheet" type="text/css" href="{{ asset('vendors/data-tables/css/jquery.dataTables.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('vendors/data-tables/extensions/responsive/css/responsive.dataTables.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('vendors/data-tables/css/select.dataTables.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('css/datatable/colReorder.dataTables.min.css') }} ">
<link rel="stylesheet" type="text/css" href="{{ asset('css/datatable/buttons.dataTables.min.css') }} ">

<link rel="stylesheet" type="text/css" href="{{asset('vendors/fullcalendar/daygrid/daygrid.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/fullcalendar/timegrid/timegrid.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/fullcalendar/css/fullcalendar.min.css')}}">


 

<link rel="stylesheet" type="text/css" href="{{ asset('css/pages/data-tables.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('css/pages/form-select2.css') }}">


@endsection

{{-- page style --}}
@section('page-style')
<style>
    .task-cat {
        padding: 9px 7px;
        font-size: 1.0rem;
    }

    .time {
        padding-left: 1% !important;
        padding-right: 1% !important;
    }

    .btn-text {
        margin-left: 5px !important;
    }

    #rel {
        margin-top: 2%;
    }

    .badge {
        position: initial !important;
    }
</style>
<link rel="stylesheet" type="text/css" href="{{asset('css/pages/app-calendar.css')}}">
@endsection

{{-- page content --}}
@section('content')


<input type="hidden" value="{{$id}}" id="id">
<input type="hidden" value="{{$date}}" id="date">

 


<div class="card">
    <div class="card-content">
        @if ($message = Session::get('success'))
        <div class="card-alert card green lighten-5" id="message">
            <div class="card-content green-text">
                <p>{{ $message }}</p>
            </div>
            <button type="button" class="close green-text close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>
        @elseif($message = Session::get('error'))
        <div class="card-alert card red lighten-5" id="message">
            <div class="card-content red-text">
                <p>{{ $message }}</p>
            </div>
            <button type="button" class="close red-text close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>
        @endif
        <!--success message end-->
        <div class="row">
            <div class="col s4">
                <div class="input-field col s12">

                    <input id="check_out_notes" type="text" placeholder="Check Out Notes" style="display: none">

                    <input id="check_in_notes" type="text" placeholder="Check In Notes" style="display: none">

                </div>
            </div>
            <div class="col s4 center-align" id="rel">

                <button class="btn red time modal-trigger" href="#check_out_modal" style="display: none">
                    <span class="valign-wrapper"><i class="material-icons">access_time</i>
                        <span class="btn-text" id="out" data-id="0">Check Out</span>
                    </span>
                </button>
                <!-- Modal Structure -->
                <div id="check_out_modal" class="modal">
                    <div class="modal-content">
                        <h6>Are you sure you want to checkout?</h6>
                    </div>
                    <div class="modal-footer">
                        <button id="checkout" class="modal-close btn green">Yes</button>
                        <button class="modal-close btn red">No</button>
                    </div>
                </div>
                <!-- Modal Structure END-->

                <button class="btn green time" id="checkin" style="display: none">
                    <span class="valign-wrapper"><i class="material-icons">access_time</i>
                        <span class="btn-text" id="in" data-id="1">Check In</span>
                    </span>
                </button>

                <button class="btn grey darken time" style="display: none" id="checkout_disabled">
                    <span class="valign-wrapper"><i class="material-icons">access_time</i>
                        <span class="btn-text">Check Out</span>
                    </span>
                </button>

            </div>
            <div class="col s4 center-align">
                <p id="txt"></p>
                <i class="material-icons dp48">access_alarms</i>&nbsp<h4 style="display: inline-block" id="normaltime"></h4>
                <h4 style="display: inline-block" id="seconds" class="hide-on-small-only"></h4>
                <div id="clock"></div>
            </div>

        </div>





        <!-- Modal Structure START-->
        <div id="modal1" class="modal">
            <div class="modal-content">
                <h4 id="modal_date"></h4>
                <table>
                    <tbody>
                        <tr>
                            <td>Check In Time</td>
                            <td id="modal_checkin"></td>
                            <td>Check In Notes</td>
                            <td id="modal_checkin_notes"></td>
                        </tr>
                        <tr>
                            <td>Check Out Time</td>
                            <td id="modal_checkout"></td>
                            <td>Check Out Notes</td>
                            <td id="modal_checkout_notes"></td>
                        </tr>
                        <tr>
                            <td>Total Hours</td>
                            <td id="modal_total_hours"></td>
                            <td style="display: none" id="penalty">Penalty</td>
                            <td id="penalty_amount"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button href="#!" class="modal-close white-text red btn-flat">Close</button>
            </div>
        </div>
        <!-- Modal Structure END-->


        <!-- Modal Structure START for Leave Request-->
        <div id="leaverequest_modal" class="modal">
            <div class="modal-content">
                <div class="container">

                    <h4 class="title-color">Create Leave Request</h4>
                    <form action="{{route('hrms.leaverequest.store')}}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col s6">
                                <label for="">Employee Name</label>
                                <input type="text" placeholder="Enter Name" id="emp_name" class="input-field"
                                       name="emp_name" disabled>
                                <input type="hidden" id="employee_id" name="employee_id">
                                <input type="hidden" id="is_confirm" name="is_confirm">
                                <input type="hidden" id="emp_date" name="emp_date">
                                <input type="hidden" id="team_lead" name="team_lead">
                                <input type="hidden" id="hr" name="hr">

                            </div>

                            <div class="input-field col s6">
                                <select id="leave_type" name="leave_type">
                                    <option value="">Select Leave Type</option>

                                </select>
                                <label for="leave_type">Select Leave Type</label>
                                @error('leave_type')
                                <div class="alert alert-danger red-text">{{ $message }}</div>
                                @enderror

                            </div>
                        </div>

                        <div class="row">
                            <div class="col s4">
                                <label for="">From Date</label>
                                <input type="text" placeholder="From Date" class="datepicker input-field"
                                       id="from_date" name="from_date">
                                @error('from_date')
                                <div class="alert alert-danger red-text">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col s4">
                                <label for="">End Date</label>
                                <input type="text" placeholder="End Date" class="datepicker input-field"
                                       id="end_date" name="end_date">
                                @error('end_date')
                                <div class="alert alert-danger red-text">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="input-field col s4">
                                <input type="hidden" id="total_days" name="total_days">
                                <label style="margin-top: -23px;">Total Days</label><br>
                                <span id="result" class="green-text result"></span>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col s12">
                                <label for="remark">Remark</label>
                                <input type="text" placeholder="Enter Remark" class="input-field" name="remark">
                                @error('remark')
                                <div class="alert alert-danger red-text">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>
                        <div class="row">
                            <div class="col s12 display-flex justify-content-end form-action">
                                <button type="submit" class="btn indigo btn-color waves-light mr-2">
                                    Create
                                </button>
                                <button type="reset"
                                        class="btn modal-close btn-light-pink btn-color waves-light mb-1">Cancel
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Modal Structure END for Leave Request-->

        <div class="row">
            <div class="col s12 right">
                <ul class="tabs">
                    <li class="tab col s6 p-0"><a class="active p-0" href="#calendar_view">Calendar View</a></li>
                    <li class="tab col s6 p-0"><a class="p-0" href="#table_view">Table View</a></li>
                </ul>
            </div>
        </div>
        <br>
        <div class="row">
            <div id="calendar_view">
                <div class="row">
                    <div class="col s12">
                        <p>
                            <label>
                                <input type="checkbox" id="sel"/>
                                <span>Select to add Leave Request</span>
                            </label>
                        </p><br>
                        <div class="col s12">
                            <div id="basic-calendar"></div>
                        </div>
                    </div>
                </div>
            </div>


            <div id="table_view">


                <table id="attendance_dataTable" class="display multiselect">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Date</th>
                            <th>Check In time</th>
                            <th>Check Out time</th>
                            <th>Total Hours</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1 ?>
                        @foreach($attendance_table_data as $Details)
                        <tr>
                            <td>{{$i}}</td>
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
                            <?php $i++ ?>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>
@endsection

{{-- vendor script --}}
@section('vendor-script')
<script src="{{asset('js/ajax/jquery.min.js')}}"></script>
<script src="{{asset('js/ajax/angular.min.js')}}"></script>
<script src="{{asset('js/materialize.js')}}"></script>
<script src="{{asset('js/ajax/sweetalert.min.js')}}"></script>

<script src="{{asset('vendors/fullcalendar/js/fullcalendar.min.js')}}"></script>
<script src="{{asset('vendors/fullcalendar/daygrid/daygrid.min.js')}}"></script>
<script src="{{asset('vendors/fullcalendar/timegrid/timegrid.min.js')}}"></script>
<script src="{{asset('vendors/fullcalendar/interaction/interaction.min.js')}}"></script>

<script src="{{ asset('vendors/data-tables/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('vendors/data-tables/extensions/responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('vendors/data-tables/js/dataTables.select.min.js') }}"></script>

<script src="{{asset('js/scripts/advance-ui-modals.js')}}"></script>
<script src="{{asset('js/attendance/index.js')}}"></script>

@endsection



{{-- page script --}}
@section('page-script')

<script>
$(document).ready(function () {

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
                    url: '/training/category/removedata',
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




@extends('app.layout')

{{-- page title --}}

@section('title','Activity Management-details | HVL')

@section('vendor-style')

<link rel="stylesheet" href="https://cdn.datatables.net/datetime/1.1.0/css/dataTables.dateTime.min.css">

@endsection

@section('content')

<section>

    <div class="container-fluid">

        <header>

            <div class="row">

                <div class="col-md-7">

                    <h2 class="h3 display">Activity Management</h2>

                </div>

                <div class="col-md-5">

                    @can('Create Activity')

                    <a href="{{route('activity.create_activity')}}" class="btn btn-primary pull-right rounded-pill">Add Activity</a>

                    @endcan

                    @can('Delete Activity' )

                    <a id="mass_delete_id" class="btn btn-primary pull-right rounded-pill mr-2">

                        <i class="fa fa-trash"></i> Mass Delete

                    </a>

                    @endcan

                    <a class="btn btn-primary rounded-pill pull-right mr-2 " data-toggle="modal" data-target="#modal_download">

                        <span class="fa fa-download fa-lg"></span> Download

                    </a>

                </div>

            </div>

        </header>

        <!-- Page Length Options -->

        <div class="card">

            @if (session('success'))

            <div class="alert alert-success alert-dismissible fade show center-block" role="alert">

                <strong>{!! Session::get('success') !!} </strong>

                <button type="button" class="close" data-dismiss="alert" aria-label="Close">

                    <span aria-hidden="true">&times;</span>

                </button>

            </div>

            @endif

            <div class="card-body">

                <div class="">

                    <form action="{{route('activity.get_date_data')}}" method="post">

                        @csrf

                        <div class="row">

                            <div class="col-sm-6 col-md-2">

                                <select id="branch" class="form-control" name="branch" required >

                                    <option value="{{session('branch')}}">Select Branch</option>

                                    @php

                                    $em_id = Auth::User()->id;

                                    $emp = DB::table('employees')->where('user_id','=',$em_id)->first();

                                    @endphp

                                    @if($em_id == 1 or $em_id == 122)

                                    @foreach($branchs as $branch)

                                    <option value="{{$branch->id}}" <?php

                                    if (!empty($branch_id)) {

                                        if ($branch_id == $branch->id) {

                                            echo 'selected';

                                        }

                                    }

                                    ?> >{{$branch->Name}}</option>

                                    @endforeach

                                    @else
                                        @if($emp){
                                            @foreach($branchs as $branch)
                                                @foreach($branch as $key => $value)
                                                    <option value="{{$value->id}}" <?php
                
                                                    if (!empty($branch_id)) {
                
                                                        if ($branch_id == $value->id) {
                
                                                            echo 'selected';
                
                                                        }
                
                                                    }
                
                                                    ?> >{{$value->Name}}</option>
                                                @endforeach
                                            @endforeach
                                        @else
                                          @foreach($branchs as $branch)
                                                <option value="{{$branch->id}}" {{((!empty($branch_id))&&($branch_id == $branch->id))?'selected':''}}> {{$branch->Name}}</option>
                                            @endforeach
                                        @endif

                                    @endif

                                </select>

                            </div>

                            <div class="col-sm-6 col-md-2">

                                <select id="customer_id" name="customer_id[]"class="form-control select" multiple required>

                                </select>

                            </div>

                            <div class="col-sm-6 col-md-2">

                                <input type="text" name="start"  value="{{request('start')}}"class="form-control datepicker" autocomplete="off" placeholder="Enter Start Date" required >

                            </div>

                            <div class="col-sm-6 col-md-2">

                                <input type="text" name="end" value="{{request('end')}}" class="form-control datepicker" autocomplete="off" placeholder="Enter End Date" required >

                            </div>

                            <div class="col-sm-6 col-md-2">

                                <select id="status_id" name="status_id[]"  class="form-control select" multiple required >

                                </select>

                            </div>

                            <div class="col-sm-6 col-md-1">

                                <button type="submit" class="btn btn-primary"> Search</button>

                            </div>

                            <div class="col-sm-4 col-md-1" style="padding: 0px;">

                                <a class="btn btn-primary" href="{{route('activity.index')}}">Reset</a>

                            </div>

                        </div>

                    </form>

                </div>

                <div class="table-responsive mt-4">

                    <table id="page-length-option" class="table table-striped table-hover multiselect">

                        <thead>

                            <tr>

                                <th class="sorting_disabled" width="5%">

                                    <label>

                                        <input type="checkbox" class="select-all m-1"/>

                                        <span></span>

                                    </label>

                                </th>

                                <th width="5%">ID</th>

                                <th width="5%">Action</th>

                                <th width="10%">Customer Name</th>

                                <th width="15%">Subject</th>

                                <th width="15%">Branch</th>

                                <th width="8%">Start Date</th>

                                <th width="8%">End Date</th>

                                <th width="6%">Status</th>

                                <th width="6%">Frequency</th>
                                
                                <th width="6%">Completion Date</th>

                                <th width="6%">Remark</th>

                                @can('Access Job Cards')

                                <th width="6%">Job Update</th>

                                @can('Create Job Cards')

                                <th width="10%">Job Cards</th>

                                @endcan

                                @endcan

                                @can('Access Audit Report')

                                <th width="6%">Audit Update</th>

                                <th>Send Audit</th>

                                @can('Create Audit Report')

                                <th width="10%">Audit Report</th>

                                @endcan

                                @endcan

                            </tr>

                        </thead>

                        <tbody loading="lazy">

                            @foreach($details as $key => $data)

                            @foreach($data as $d)

                            <tr>

                                <td><label> <input type="checkbox" data-id="{{ $d->id }}" name="selected_row"/><span></span></label></td>

                                <td>{{$d->id}}</td>

                                <td>

                                    @can('Read Activity')

                                    <a href="{{ route('activity.show_activity', $d->id) }}" class="tooltipped mr-10" data-position="top" target="_blank" data-tooltip="View">

                                        <span class="fa fa-eye"></span>

                                    </a>

                                    @endcan

                                    @can('Edit Activity')

                                    <?php

                                    $em_id = \Illuminate\Support\Facades\Auth::User()->id;

                                    $emp = DB::table('employees')->where('user_id', '=', $em_id)->first();

                                    ?>

                                    @if($em_id == 1 or $em_id == 122)

                                    <a href="{{ route('activity.edit_activity', $d->id) }}" class="tooltipped mr-10"  data-position="top"  target="_blank"  data-tooltip="Edit">

                                        <span class="fa fa-edit"></span>

                                    </a>

                                    @elseif($d->activity_status != 'Completed')

                                    <a href="{{ route('activity.edit_activity', $d->id) }}" class="tooltipped mr-10" data-position="top" target="_blank" data-tooltip="Edit">

                                        <span class="fa fa-edit"></span>

                                    </a>

                                    @endif

                                    @endcan

                                    @can('Delete Activity')

                                    @if($d->activity_status != 'Completed')

                                    <a href="" class="button" data-id="{{$d->id}}"><span class="fa fa-trash"></span></a>

                                    @endif

                                    @endcan

                                </td>

                                <td>{{$d->customer_id}}</td>

                                <td>{{$d->subject}}</td>

                                <td>{{$d->name}}</td>

                                <td>{{$d->start_date}}</td>

                                <td>{{$d->end_date}}</td>

                                <td>{{($d->activity_status == "Completed"? 'Completed' : '')}}

                                    {{($d->activity_status == "Not Started"? 'Not Started' : '')}}

                                    {{($d->activity_status == "In Progress"? 'In Progress' : '')}}

                                    {{($d->activity_status == "Deferred"? 'Deferred' : '')}}

                                </td>

                                <td>

                                    {{$d->frequency == "daily" ? 'Daily' : ''}}

                                    {{$d->frequency == "weekly" ? 'Weekly' : ''}}

                                    {{$d->frequency == "weekly_twice" ? 'Weekly Twice' : ''}}

                                    {{$d->frequency == "weekly_thrice" ? 'Weekly Thrice' : ''}}

                                    {{$d->frequency == "monthly" ? 'Monthly' : ''}}

                                    {{$d->frequency == "monthly_thrice" ? 'Monthly thrice' : ''}}

                                    {{$d->frequency == "fortnightly" ? 'Fortnightly' : ''}}

                                    {{$d->frequency == "bimonthly" ? 'Bimonthly' : ''}}

                                    {{$d->frequency == "quarterly" ? 'Quarterly' : ''}}

                                    {{$d->frequency == "quarterly_twice" ? 'Quarterly twice' : ''}}

                                    {{$d->frequency == "thrice_year" ? 'Thrice in a Year' : ''}}

                                    {{$d->frequency == "onetime" ? 'One Time' : ''}}

                                </td>

                                <td>{{$d->complete_date}}</td>
                                   
                                <td>{{$d->remark}}</td>

                                @can('Access Job Cards')

                                <td>

                                    @php

                                    $date = \Illuminate\Support\Facades\DB::table('hvl_job_cards')

                                    ->where('activity_id',$d->id)

                                    ->orderBy('id','DESC')

                                    ->paginate(1);

                                    foreach ($date as $update)

                                    {

                                    echo $update->added;

                                    }

                                    @endphp

                                </td>

                                @can('Create Job Cards')

                                <td>



                                    <button type="button" class="btn btn-primary rounded p-1 activity_id" data-toggle="modal" data-target="#modal{{$d->id}}">

                                        <span class="fa fa-upload"></span>Add Images

                                    </button>

                                    <div class="modal fade" id="modal{{$d->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

                                        <div class="modal-dialog" role="document">

                                            <div class="modal-content">

                                                <div class="modal-header">

                                                    <h4>Add Job Cards</h4>

                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                                                        <span aria-hidden="true">&times;</span>

                                                    </button>

                                                </div>

                                                <div class="modal-body">

                                                    <form  method="post" id="laravel-ajax-file-upload" enctype="multipart/form-data">

                                                        @csrf



                                                        <input type="hidden" name="activity_id" id="activity_id" value="{{$d->id}}">



                                                        <div class="form-group col-sm-12 col-md-12">

                                                            <lable>Before Image</lable>

                                                            <input type="file" name="before_file" id="before_file" accept=".jpg, .png, .jpeg"  class="form-control-file" onchange="upload_covid_files({{$d->id}})" required="">

                                                            <p class="text-danger">Max File Size:<strong> 3MB</strong><br>Supported Format: <strong>.jpg .png .jpeg</strong></p>

                                                            <p class="text-green" id="responseMsg_upload_covid_files"></p>

                                                        </div>

                                                        <br>

                                                        <div class="form-group col-sm-12 col-md-12">

                                                            <lable>After Image</lable>

                                                            <input type="file" name="after_file" id="after_file" accept=".jpg, .png, .jpeg" class="form-control-file" onchange="upload_covid_files_after_file({{$d->id}})">

                                                            <p class="text-danger">Max File Size:<strong> 3MB</strong><br>Supported Format: <strong>.jpg .png .jpeg</strong></p>

                                                            <p class="text-green" id="responseMsg_upload_covid_files_after_file"></p>

                                                        </div>



                                                        <div class="form-group col-sm-12 col-md-6">

                                                            <button type="button" class="btn btn-primary" onclick="save({{$d->id}})">Submit</button>

                                                        </div>

                                                    </form>

                                                </div>

                                            </div>

                                        </div>

                                    </div>

                                    @endcan

                                </td>

                                @endcan

                                @can('Access Audit Report')

                                <td>

                                    @php

                                    $date = \Illuminate\Support\Facades\DB::table('hvl_audit_reports')

                                    ->where('activity_id',$d->id)

                                    ->orderBy('id','DESC')

                                    ->paginate(1);

                                    foreach ($date as $update)

                                    {

                                    echo $update->added;

                                    }

                                    @endphp

                                </td>

                                <td>

                                    <a class="center" data-toggle="modal" data-target="#email_div{{$d->id}}">

                                        <span class="fa fa-envelope fa-lg "></span>

                                    </a>

                                    <div id="email_div{{$d->id}}" tabindex="-1" role="dialog" aria-hidden="true" class="modal fade text-left">

                                        <div role="document" class="modal-dialog">

                                            <div class="modal-content">

                                                <div class="modal-header">

                                                    <h4 class="modal-title">Send Mail</h4>

                                                    <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>

                                                </div>

                                                <div class="modal-body p-4 row">

                                                    <div class="col-sm-12">

                                                        <form action="{{ route('mail.sendaudit') }}" method="post" enctype="multipart/form-data">

                                                            @csrf

                                                            <input type="hidden" name="customer" value="{{$d->customer_id}}">

                                                            <input type="hidden" name="act_id" value="{{$d->id}}">

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

                                                                    <textarea class="form-control" name="body">Start Date : {{$d->start_date}} End Date : {{$d->end_date}}     Customer : {{$d->customer_id}}

                                                                    </textarea>

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

                                </td>

                                @can('Create Audit Report')

                                <td>

                                    <button type="button" class="btn btn-primary rounded p-1" data-toggle="modal" data-target="#modal_report{{$d->id}}">

                                        <span class="fa fa-upload"></span>Audit Report

                                    </button>

                                    <div class="modal fade" id="modal_report{{$d->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

                                        <div class="modal-dialog" role="document">

                                            <div class="modal-content">

                                                <div class="modal-header">

                                                    <h4>Add Audit Report</h4>

                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                                                        <span aria-hidden="true">&times;</span>

                                                    </button>

                                                </div>

                                                <div class="modal-body">

                                                    <form method="post" action="{{route('activity.auditreport')}}" enctype="multipart/form-data">

                                                        @csrf

                                                        <input type="hidden" name="activity_id" value="{{$d->id}}">

                                                        <div class="form-group col-sm-12 col-md-6">

                                                            <lable>Report File (only pdf and excel)</lable>

                                                            <input type="file" name="audit_report" id="audit_file" required class="form-control-file" accept=".pdf, .xls, .xlsx, .csv">

                                                            <p class="text-danger">Max File Size:<strong> 5MB</strong><br>Supported Format: <strong>.pdf, .xls, .xlsx, .csv</strong></p>

                                                            <br>

                                                            <input type="submit" class="btn btn-success rounded" value="Upload">

                                                        </div>

                                                    </form>

                                                </div>

                                            </div>

                                        </div>

                                    </div>

                                    @endcan

                                </td>

                                @endcan

                            </tr>

                            @endforeach

                            @endforeach

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>

</section>

@include('hvl.activitymaster._pops')

@endsection

{{-- page script --}}

@section('page-script')

<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.4/jspdf.min.js"></script>

<script>

                                                                function branchtrigger() {

                                                                    $('#branch').trigger('change');

                                                                    $('#customer_id').each(function () {

                                                                        this.checked = true;

                                                                    });

                                                                }

                                                                $(document).ready(function () {

                                                                    $('#responseMsg_upload_covid_files').hide();

                                                                     $('#responseMsg_upload_covid_files_after_file').hide();

                                                                    

                                                                    $('#page-length-option').DataTable({

                                                                        "scrollX": true,

                                                                        "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],

                                                                        dom: 'Blfrtip',

                                                                        buttons: [

                                                                            'colvis'

                                                                        ]

                                                                    });

                                                                    var statusCheck = $('#status_id').multiselect({

                                                                        includeSelectAllOption: true,

                                                                        enableFiltering: true,

                                                                        nonSelectedText: 'Select status',

                                                                        maxHeight: 450

                                                                    });

                                                                    var categCheck = $('#customer_id').multiselect({

                                                                        includeSelectAllOption: true,

                                                                        enableFiltering: true,

                                                                        nonSelectedText: 'Select Customer',

                                                                        maxHeight: 450

                                                                    });

                                                                    $('#branch').change(function () {

                                                                        var eids = $(this).val();

                                                                        if (eids) {

                                                                            $.ajax({

                                                                                type: "get",

                                                                                url: "/activity-master/get-branch-customer",

                                                                                data: {

                                                                                    eids: eids

                                                                                },

                                                                                success: function (res) {

                                                                                    if (!$.trim(res)) {

                                                                                    } else {

                                                                                        $("#customer_id").empty();

                                                                                        $.each(res, function (key, value) {

                                                                                            var opt = $('<option />', {

                                                                                                value: value.id,

                                                                                                text: value.customer_name

                                                                                            });

                                                                                            opt.appendTo(categCheck);

                                                                                            categCheck.multiselect('rebuild');

                                                                                        });

                                                                                    }

                                                                                }

                                                                            });

                                                                        }

                                                                    });

                                                                    $('#customer_id').change(function () {

                                                                        var eids = $(this).val();

                                                                        if (eids) {

                                                                            $.ajax({

                                                                                type: "get",

                                                                                url: "/activity-master/get-customer-status",

                                                                                data: {

                                                                                    eids: eids

                                                                                },

                                                                                success: function (res) {

                                                                                    console.log('data!')

                                                                                    if (!$.trim(res)) {

                                                                                    } else {

                                                                                        $("#status_id").empty();

                                                                                        $.each(res, function (key, value) {

                                                                                            var opt = $('<option />', {

                                                                                                value: value.id,

                                                                                                text: value.Name,

                                                                                            });

                                                                                            opt.appendTo(statusCheck);

                                                                                            statusCheck.multiselect('rebuild');

                                                                                        });

                                                                                    }

                                                                                }

                                                                            });

                                                                        }

                                                                    });

                                                                    branchtrigger();

                                                                });

                                                                $(document).ready(function () {

                                                                    $('.select').multiselect({

                                                                        // includeSelectAllOption: true,

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

                                                                    // mass delete

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

                                                                    // Select Every Row

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

                                                                    $('#mass_delete_id').click(function () {

                                                                        var checkbox_array = [];

                                                                        var token = $("meta[name='csrf-token']").attr("content");

                                                                        $.each($("input[name='selected_row']:checked"), function () {

                                                                            checkbox_array.push($(this).data("id"));

                                                                        });

                                                                        // console.log(checkbox_array);

                                                                        if (typeof checkbox_array !== 'undefined' && checkbox_array.length > 0) {

                                                                            swal({

                                                                                title: "Are you sure, you want to delete? ",

                                                                                text: "You will not be able to recover this record!",

                                                                                type: 'warning',

                                                                                showCancelButton: true,

                                                                                confirmButtonClass: "btn-danger",

                                                                                confirmButtonText: "Yes, delete it!",

                                                                                closeOnConfirm: false

                                                                            }, function (isConfirm) {

                                                                                if (isConfirm) {

                                                                                    $.ajax({

                                                                                        url: '{{route('activity.massdelete')}}',

                                                                                        type: 'POST',

                                                                                        data: {

                                                                                            "_token": token,

                                                                                            ids: checkbox_array,

                                                                                        },

                                                                                        success: function (result) {

                                                                                            if (result === 'error') {

                                                                                                swal({

                                                                                                    title: "Activity cannot be deleted as Job card or Audit report is assigned to this activity!",

                                                                                                    type: "warning",

                                                                                                })

                                                                                            } else {

                                                                                                swal({

                                                                                                    title: "Record has been deleted!",

                                                                                                    type: "success",

                                                                                                }, function () {

                                                                                                    location.reload();

                                                                                                });

                                                                                            }

                                                                                        }

                                                                                    });

                                                                                }

                                                                            });

                                                                        } else {

                                                                            swal({

                                                                                title: "Please Select Atleast One Record",

                                                                                type: 'warning',

                                                                            });

                                                                        }

                                                                    });

                                                                    $(document).on('click', '.button', function (e) {

                                                                        e.preventDefault();

                                                                        var id = $(this).data("id");

                                                                        swal({

                                                                            title: "Are you sure you want to delete? ",

                                                                            text: "You will not be able to recover this record!",

                                                                            type: 'warning',

                                                                            showCancelButton: true,

                                                                            confirmButtonClass: "btn-danger",

                                                                            confirmButtonText: "Yes, delete it!",

                                                                            closeOnConfirm: false

                                                                        }, function (isConfirm) {

                                                                            if (isConfirm) {

                                                                                $.ajax({

                                                                                    url: "{{route('activity.hvi_hisrty_delete')}}",

                                                                                    type: "get",

                                                                                    data: {

                                                                                        "id": id

                                                                                    },

                                                                                    success: function (result) {

                                                                                        if (result === 'error') {

                                                                                            swal({

                                                                                                title: "Activity cannot be deleted as Job card or Audit report is assigned to this activity!",

                                                                                                type: "warning",

                                                                                            })

                                                                                        } else {

                                                                                            swal({

                                                                                                title: "Record has been deleted!",

                                                                                                type: "success",

                                                                                            }, function () {

                                                                                                location.reload();

                                                                                            });

                                                                                        }

                                                                                    }

                                                                                });

                                                                            }

                                                                        });

                                                                    });

                                                                });

                                                                var csv = [];

                                                                var rows = document.querySelectorAll("table tr");

                                                                for (var i = 0; i < rows.length; i++) {

                                                                    var row = [],

                                                                            cols = rows[i].querySelectorAll("td, th");

                                                                    for (var j = 0; j < cols.length; j++)

                                                                        if (j !== 0) {

                                                                            if (j !== cols.length - 1) {

                                                                                row.push(cols[j].innerText);

                                                                            }

                                                                        }

                                                                    csv.push(row.join(","));

                                                                }

                                                                var csvFile;

                                                                csvFile = new Blob([csv.join("\n")], {

                                                                    type: "text/csv"

                                                                });

                                                                var reader = new FileReader();

                                                                reader.readAsDataURL(csvFile);

                                                                reader.onloadend = function () {

                                                                    var base64data = reader.result;

                                                                    var data = base64data.match(/base64,(.+)$/);

                                                                    var base64String = data[1];

                                                                    var input = $("<input>")

                                                                            .attr("type", "hidden")

                                                                            .attr("name", "csvfile").val(base64String);

                                                                    $('#mail_form').append(input);

                                                                };

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

                                                                function exportTableToCSV(filename) {

                                                                    var csv = [];

                                                                    var rows = document.querySelectorAll("table tr");

                                                                    for (var i = 1; i < rows.length; i++) {

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



                                                                function exportTableToPDF() {

                                                                    var pdf = new jsPDF('p', 'pt', 'letter');

                                                                    pdf.cellInitialize();

                                                                    pdf.setFontSize(10);

                                                                    $.each($('table tr'), function (i, row) {

                                                                        var total = $(row).find("td, th").length;

                                                                        $.each($(row).find("td, th"), function (j, cell) {

                                                                            if (j !== 0) {

                                                                                if (j !== total - 1) {

                                                                                    var txt = $(cell).text().trim() || " ";

                                                                                    var txtWidth = pdf.splitTextToSize(txt, 100);

                                                                                    var width = 100;

                                                                                    pdf.cell(30, 30, width, 30, txtWidth, i);

                                                                                }

                                                                            }

                                                                        });

                                                                    });

                                                                    pdf.save('sample-file.pdf');

                                                                }

                                                                function save(id) {

                                                                    

                                                                     var fd = new FormData();



                                                                    var files = $('#after_file')[0].files;

                                                                     var files_ = $('#before_file')[0].files;

                                                                    

                                                                    fd.append('after_file', files[0]);

                                                                    fd.append('before_file', files_[0]);



                                                                    fd.append('activity_id', id);

                                                                    $.ajax({

                                                                        url: "{{ route('activity.jobcards_store_ajax_base')}}",

                                                                        method: 'post',

                                                                        data: fd,

                                                                        contentType: false,

                                                                        processData: false,

                                                                        dataType: 'json',

                                                                        success: function (response) {

//                                                                       alert('File Upload done.')  

                                                                       location.reload();

                                                                        },

                                                                        error: function (response) {

                                                                            console.log("error : " + JSON.stringify(response));

                                                                        }

                                                                    });

                                                                }

                                                                function upload_covid_files_after_file(id) {



                                                                    var fd = new FormData();



                                                                    var after_file = $('#after_file')[0].files;



                                                                    fd.append('after_file', after_file[0]);



                                                                    fd.append('activity_id', id);

                                                                    $.ajax({

                                                                        url: "{{ route('activity.jobcards_store_ajax_base')}}",

                                                                        method: 'post',

                                                                        data: fd,

                                                                        contentType: false,

                                                                        processData: false,

                                                                        dataType: 'json',

                                                                        success: function (response) {

                                                                               $('#responseMsg_upload_covid_files_after_file').show();

                                                                            $('#responseMsg_upload_covid_files_after_file').html(response.message); 

//                                                                            $('#modal'+id).modal('toggle'); location.reload();

                                                                            

                                                                              

                                                                        },

                                                                        error: function (response) {

                                                                            console.log("error : " + JSON.stringify(response));

                                                                        }

                                                                    });

                                                                }

                                                                function upload_covid_files(id) {

                                                                    var fd = new FormData();



                                                                    var before_file = $('#before_file')[0].files;



                                                                    fd.append('before_file', before_file[0]);



                                                                    //fd.append('activity_id', $('.activity_id').val());

                                                                    fd.append('activity_id', id);

                                                                    $.ajax({

                                                                        url: "{{ route('activity.jobcards_store_ajax_base')}}",

                                                                        method: 'post',

                                                                        data: fd,

                                                                        contentType: false,

                                                                        processData: false,

                                                                        dataType: 'json',

                                                                        success: function (response) {

                                                                          $('#responseMsg_upload_covid_files').html(response.message);

                                                                             $('#responseMsg_upload_covid_files').show();

//                                                                             $('#modal'+id).modal('toggle');location.reload();

                                                                        },

                                                                        error: function (response) {

                                                                            console.log("error : " + JSON.stringify(response));

                                                                        }

                                                                    });

                                                                }

</script>

 @endsection
@extends('app.layout')
{{-- page title --}}
@section('title','Activity Management | HVL')
@section('vendor-style')
<link rel="stylesheet" href="https://cdn.datatables.net/datetime/1.1.0/css/dataTables.dateTime.min.css">
<style>
.modal {
  overflow-y:auto;
}
</style>
@endsection
@section('content')
@php 
$_auth_user_employee = Auth::user()->employee()->first();
$_is_employee_user = ($_auth_user_employee)? true:false;         

@endphp
@php
    $Access_Job_Cards = false;
    $create_job_cards_permission = false;
    $Access_Audit_Report =false;
    $Create_Audit_Report =false;
    $Read_Activity = false;
    $Edit_Activity =false;
    $Delete_Activity =false;
    $Create_Activity = false;
    $see_activity_value =true;
    $move_activity_report=false;
@endphp

@can('Access Job Cards')
    @php
        $Access_Job_Cards=true;
    @endphp
@endcan
 @can('Create Job Cards')
        @php
            $create_job_cards_permission = TRUE;
        @endphp                         
@endcan
@can('Access Audit Report')
    @php
        $Access_Audit_Report=true;
    @endphp
    @can('Create Audit Report')
        @php
            $Create_Audit_Report=true;
        @endphp              
    @endcan
@endcan
@can('Read Activity')
    @php
        $Read_Activity=true;
    @endphp 
@endcan   
@can('Edit Activity')  
    @php
        $Edit_Activity=true;
    @endphp
@endcan
@can('Delete Activity')
    @php
        $Delete_Activity=true;
    @endphp
@endcan
@can('Create Activity')
    @php
        $Create_Activity=true;
    @endphp
@endcan
@can('move activity')
    @php
        $move_activity_report=true;
    @endphp
@endcan

@php
    if( auth()->user()->hasRole('Operators') ){
        $see_activity_value =false;
    }
@endphp

<section class="activity_no_list_message" style="display:none">
    @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show center-block" role="alert">
        <strong>{!! Session::get('success') !!} </strong>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif
    @if($errors->any())
        @foreach ($errors->all() as $error)
        <div class="alert alert-danger alert-dismissible fade show center-block" role="alert">
            <strong>{{$error}}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endforeach
    @endif
    
    <div class="container-fluid">
        <div class="d-flex align-items-center justify-content-center h-100">
            <div class="col-sm-12 col-md-6 text-center ">
                <div class="card shadow-lg p-3 mb-5 bg-white rounded " style="margin-top: 40%">
                    <div class="card-body">
                        <h1>Please start your day to see a list of activities</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="activity_root_div" style="display:{{($_is_employee_user)?'none':'block'}}">
    <div class="container-fluid">
        <header>
            <div class="row">
                <div class="col-md-4">
                    <h2 class="h3 display">Activity Management</h2>
                </div>
                <div class="col-md-8">
                    
                    @if($Create_Activity)
                    <a href="{{route('activity.create_activity')}}" class="btn btn-primary pull-right rounded-pill">Add Activity</a>
                    @endif
                    <a class="btn btn-primary rounded-pill pull-right mr-2 " data-toggle="modal" data-target="#modal_download">
                        <span class="fa fa-download fa-lg"></span> Download
                    </a>
                    @if($Delete_Activity )
                    <a id="mass_delete_id" class="btn btn-primary pull-right rounded-pill mr-2">
                        <i class="fa fa-trash"></i> Mass Delete
                    </a>
                    @endif

                    @if($move_activity_report )
                    <a class="btn btn-primary rounded-pill pull-right mr-2 " data-toggle="modal" data-target="#move_jobcart">
                        <span class="fa fa-arrows-alt fa-lg"></span> Move jobcart
                    </a>
                    @endif
                    @can('Update Activity Bulkupdate')
                        <a class="btn btn-primary rounded-pill pull-right mr-2"  href="{{ route('admin.activity_bulk_update.index') }}">
                            <i class="fa fa-upload fa-lg"></i>Bulk Update
                        </a>
                    @endcan
                    
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
            @if($errors->any())
                @foreach ($errors->all() as $error)
                <div class="alert alert-danger alert-dismissible fade show center-block" role="alert">
                    <strong>{{$error}}</strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @endforeach
            @endif
            <div class="card-body">
                <div class="">
                    <form action="{{route('activity.index.filter')}}" method="post">
                    @csrf
                        <div class="row">
                            <div class="col-sm-6 col-md-2">
                                <select id="branch" name="branch" class="form-control" required="">
                                    <option value="" >Select Branch</option>
                                    @foreach($branchs as $key=>$branch)
                                    @if($key ==0)
                                        @php continue; @endphp
                                    @endif
                                        <option value="{{$key}}" {{( isset($search_branch) && ($key == $search_branch) )?'selected':''}}  >{{$branch}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-6 col-md-2">
                                <select id="customer_id" name="customer_id[]" class="form-control select" multiple required>
                                    @foreach($customer_options as $key=>$customer_option)
                                        <option value="{{$key}}" {{(in_array($key,$search_customer_ids)?'selected':'')}} >{{$customer_option}}</option>
                                    @endforeach
                                </select>
                            </div>
                             <div class="col-sm-6 col-md-2">
                                <input type="checkbox" id="today_checkbox" name="today" {{( isset($today_data) && ($today_data == true) )?"checked":""}}  value="true"> Today
                            </div>
                            <div class="col-sm-6 col-md-2">
                                <input type="text" name="start" class="form-control datepicker" id="s_date" value="{{(isset($search_sdate)?$search_sdate:'')}}" autocomplete="off" placeholder="Enter Start Date" >
                            </div>
                            <div class="col-sm-6 col-md-2">
                                <input type="text" name="end" class="form-control datepicker" id="e_date" value="{{(isset($search_edate)?$search_edate:'')}}" autocomplete="off" placeholder="Enter End Date" >
                            </div>
                            <div class="col-sm-6 col-md-2">
                                <select id="status_id" name="status_id[]" class="form-control select" multiple required>
                                    @foreach($status as $key=>$status_row)
                                        <option value="{{$key}}" {{(in_array($key,$search_status_id)?'selected':'')}} >{{$status_row}}</option>
                                    @endforeach
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
                                <th>ID</th>
                                <th width="5%">Action</th>
                                <th width="5%">Transaction Id</th>
                                <th width="10%">Employee Name</th>
                                <th width="10%">Customer Name</th>
                                <th width="10%">Customer Code</th>
                                <th width="10%">Subject</th>
                                <th width="10%">Branch</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Start Time</th>
                                <th>End Time</th>
                                <th>Status</th>
                                <th>Frequency</th>
                                <th>Completion Date</th>
                                <th>Remark</th>
                                 <th>Download report</th>
                              
                                @role('customers_admin')
                                @else
                                 @if($see_activity_value)
                                        <th>Per Service Value</th>
                                    @endif
                                @endrole
                                @if($Access_Job_Cards)
                                    <th>Job Update</th>
                                    @if($create_job_cards_permission)
                                    <th>Job Cards</th>
                                    @endif
                                @endif
                                
                               @if($Access_Audit_Report)
                                <th>Audit Update</th>
                                <th>Send Audit</th>
                                    @if( $Create_Audit_Report)
                                    <th>Audit Report</th>
                                    @endif
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($details as $key => $data)
                            <tr>
                                <td>
                                    <label>
                                        <input type="checkbox" data-id="{{ $data->id }}"
                                               name="selected_row"/>
                                        <span></span>
                                    </label>
                                </td>
                                <td>{{$key+=1}}</td>
                                <td>
                                    @if($_is_employee_user)
                                    <input type="hidden" class="google_direction_button" data-lat="{{$customer_lat_lang[$data->customer_id]['lat']}}" data-lng="{{$customer_lat_lang[$data->customer_id]['lng']}}" >
                                    @endif
                                    @if($Read_Activity)
                                    <a href="{{ route('activity.show_activity', $data->id) }}"
                                       class="tooltipped mr-10"
                                       data-position="top"
                                       data-tooltip="View"
                                       target="_blank">
                                        <span class="fa fa-eye"></span>
                                    </a>
                                    @endif
                                    @if($Edit_Activity)
                                   
                                    @if($em_id == 1 or $em_id == 122)
                                    <a href="{{ route('activity.edit_activity', $data->id) }}"
                                       class="tooltipped mr-10"
                                       data-position="top"
                                       data-tooltip="Edit"
                                       target="_blank">
                                        <span class="fa fa-edit"></span>
                                    </a>
                                    @elseif((isset($status[$data->status])) && ($status[$data->status] != 'Completed'))
                                    <a href="{{ route('activity.edit_activity', $data->id) }}"
                                       class="tooltipped mr-10"
                                       data-position="top"
                                       data-tooltip="Edit"
                                       target="_blank">
                                        <span class="fa fa-edit"></span>
                                    </a>
                                    @endif
                                    @endif
                                    @if($Delete_Activity)
                                        @if((isset($status[$data->status])) &&  ($status[$data->status] != 'Completed'))
                                        <a href="" class="button" data-id="{{$data->id}}"><span class="fa fa-trash"></span></a>
                                        @endif
                                    @endif
                                </td>
                                <td> {{$data->id}} </td>
                                <td> {{$employees[$data->employee_id]}} </td>
                                <td> {{$customers[$data->customer_id]}} </td>
                                <td> {{$customer_code[$data->customer_id]}} </td>
                                
                                <td> {{$data->subject}} </td>
                                <td> {{ $branchs[$data->branch_name]}} </td>
                                
                                <td> {{$data->start_date}} </td>
                                <td> {{$data->end_date}} </td>
                                
                                <td> {{$data->start_time}} </td>
                                <td> {{$data->end_time}} </td>
                                
                                <td> {{(isset($status[$data->status]))?ucfirst($status[$data->status]):'-'}}</td>
                                <td>
                                    {{$data->frequency == "daily" ? 'Daily' : ''}}
                                    {{$data->frequency == "weekly" ? 'Weekly' : ''}}
                                    {{$data->frequency == "weekly_twice" ? 'Weekly Twice' : ''}}
                                    {{$data->frequency == "weekly_thrice" ? 'Weekly Thrice' : ''}}
                                    {{$data->frequency == "monthly" ? 'Monthly' : ''}}
                                    {{$data->frequency == "monthly_thrice" ? 'Monthly Thrice' : ''}}
                                    {{$data->frequency == "fortnightly" ? 'Fortnightly' : ''}}
                                    {{$data->frequency == "bimonthly" ? 'Bimonthly' : ''}}
                                    {{$data->frequency == "quarterly" ? 'Quarterly' : ''}}
                                    {{$data->frequency == "quarterly_twice" ? 'Quarterly twice' : ''}}
                                    {{$data->frequency == "thrice_year" ? 'Thrice in a Year' : ''}}
                                    {{$data->frequency == "onetime" ? 'One Time' : ''}}
                                </td>
                                <td>{{$data->complete_date}}</td>
                                <td>{{$data->remark}}</td>
                                    <td>
                                    @if(isset($jobcardupdated[$data->id]))
                                    <a  href="{{route('admin.activity.download_activity_report',['activity_id'=>$data->id])}}" class="btn btn-primary rounded p-1 ">
                                            <span class="fa fa-download"></span>Report
                                        </button>   
                                    @endif
                                </td>
                               
                                    @role('customers_admin')
                                    @else
                                         @if($see_activity_value)
                                            <th>{{$data->services_value}}</th>
                                        @endif
                                    @endrole
                                    
                                @if($Access_Job_Cards)
                                <td>{{ 
                                        (isset($jobcardupdated[$data->id]))
                                        ?
                                            $jobcardupdated[$data->id]
                                        :
                                            (
                                                (isset($hvl_job_cards[$data->id]))
                                                ?
                                                    $hvl_job_cards[$data->id]
                                                :
                                                ''
                                            ) 
                                    }}
                                </td>
                                    @if($create_job_cards_permission)
                                    <td>
                                        <button type="button" 
                                        class="btn btn-primary rounded p-1 addJob_button" data-id="{{$data->id}}" data-toggle="modal" 
                                            data-target=".addjob_Model">
                                            <span class="fa fa-upload"></span>Add Images
                                        </button>
                                    </td>
                                    @endif
                                @endif
                                
                                @if($Access_Audit_Report)
                                <td>{{(isset($hvl_audit_reports[$data->id]))?$hvl_audit_reports[$data->id]:''}}
                                </td>
                                <td>
                                    <a class="center send_audit_email" data-toggle="modal"  data-id="{{$data->id}}" data-end_date="{{$data->end_date}}"  data-start_date="{{$data->start_date}}" data-customer_id="{{$data->customer_id}}"  data-target=".email_div">
                                        <span class="fa fa-envelope fa-lg "></span>
                                    </a>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-primary rounded p-1 create_audit_report"  data-id="{{$data->id}}" data-toggle="modal" data-target=".modal_report">
                                        <span class="fa fa-upload"></span>Audit Report
                                    </button>
                                </td>
                                @endif
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
@if($create_job_cards_permission)
<!-- addjob_Model -->
<div class="modal fade addjob_Model"  tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
     @csrf
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4>Add Job Cards</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="{{route('activity.addbefore_pic')}}" enctype="multipart/form-data">
                    <input type="hidden" id="addJobId" name="activity_id" value="">
                    <div class="form-group col-sm-12 col-md-12">
                        <lable>Before Image</lable>
                        <input type="file" name="before_pic[]"  accept=".jpg, .png, .jpeg" required class="form-control-file before_file" multiple>
                        <p class="text-danger">Max File Size:<strong> 3MB</strong><br>Supported Format: <strong>.jpg .png .jpeg</strong></p>
                    </div>
                    <br>
                    <div class="form-group col-sm-12 col-md-12">
                        <lable>After Image</lable>
                        <input type="file" name="after_pic[]"  accept=".jpg, .png, .jpeg" class="form-control-file after_file" multiple>
                        <p class="text-danger">Max File Size:<strong> 3MB</strong><br>Supported Format: <strong>.jpg .png .jpeg</strong></p>
                    </div>
                    <div class="form-group col-sm-12 col-md-6">
                        <input type="submit" class="btn btn-success rounded" value="Upload">
                    </div>
                </form>
                <div class="row">
                    <div class="col">
                        <a href='javascript:;'  id="openServiesModel" >General Form</a>
                    </div>
                    <div class="col">
                       <a href='javascript:;'  id="openRelianceServiesModel"> Reliance - CSSR</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- addjob_Model  -->
@endif

@if($Access_Audit_Report)
<!-- email_div -->
<div  tabindex="-1" role="dialog" aria-hidden="true" class="modal fade text-left email_div">
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
                        <input type="hidden" name="customer" id="mail_customer" value="">
                        <input type="hidden" name="act_id"  id="mail_act_id" value="">
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
<!-- end email_div -->
@endif
<div class="modal fade modal_report"  tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
     @csrf
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
                    <input type="hidden" name="activity_id"  id="auditreport_id" value="">
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
@if($move_activity_report)
<div class="modal fade" id="move_jobcart" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="move_jobcartLabel">Jobcart Move</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>
          <div class="form-group">
            <label for="old_id" class="col-form-label">Current Transaction Id :</label>
            <input type="number" name="old_id" class="form-control" id="old_id">
          </div>
          <div class="form-group">
            <label for="new_id" class="col-form-label">New Transaction Id :</label>
            <input type="number" name="new_id" class="form-control" id="new_id">
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="move_activity_jobcart">Update</button>
      </div>
    </div>
  </div>
</div>
@endif
@include('hvl.activitymaster.service_report_model')
@include('hvl.activitymaster.relaince_service_report_model')

@include('hvl.activitymaster._pops')
@endsection
@section('page-script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.4/jspdf.min.js"></script>
<script type="text/javascript" async="" src="{{asset('asset/signature_pad_proparty/ga.js.download')}}"></script>
<!-- extenal excel file -->
@if($_is_employee_user)
<!--  this for google track button -->
    <!-- end google track button-->
    <script>
    $(document).ready(function() {
        getLocation(setDirectionButton);
    });
    function getLocation(callback) {
        navigator.geolocation.getCurrentPosition(function (pos) {
            callback({
                "latitude": pos.coords.latitude,
                "longitude": pos.coords.longitude,
                "status": 0,
                "description": ""});
        }, function (err) {
            callback({
                "latitude": 21.1702,//null
                "longitude": 72.8311,//null,
                "status": -1,
                "description": `ERROR (${err.code}): ${err.message}`});
        });
    }
    
    function setDirectionButton(pos){
        var elements = document.getElementsByClassName("google_direction_button");
        for (var i = 0, len = elements.length; i < len; i++) {
            var destination_lat = $(elements[i]).attr('data-lat'); 
            var destination_lng = $(elements[i]).attr('data-lng');
            if(!(destination_lat =='undefine' || destination_lng == 'undefine' || pos.latitude == 'undefine' || pos.longitude == 'undefine') ) {
                $(elements[i]).parent().append("<a class='card-link' href='https://www.google.com/maps/dir/?api=1&origin="+pos.latitude+","+pos.longitude+"&destination="+destination_lat+","+destination_lng+"'><img height='30px' src='{{asset("img/directions.png")}}' height='50px' ></a>");
            }
        }
    }


    </script>
@endif


<!-- surani ajit forbackend excel download -->
<script>
     $("#download_lead_button").click( function() {
        DownloadExcelFile();
    });
    $("#mail_form").submit( function(e) {
        $(this).append('<input type="hidden" name="search_start_date" value="'+$('#s_date').val()+'">');
        $(this).append('<input type="hidden" name="search_end_date" value="'+$('#e_date').val()+'">');
        $(this).append('<input type="hidden" name="search_status" value="'+$('#status_id').val()+'">');
        var limit = ($('#data_limit').prop('checked')==true)?1:0;
        $(this).append('<input type="hidden" name="data_limit" value="'+ limit +'">');
        var is_today = ($('#today_checkbox').prop('checked')==true)?1:0;
        $(this).append('<input type="hidden" name="is_today" value="'+ is_today +'">');
        $(this).append('<input type="hidden" name="branch" value="'+$('#branch').val()+'">');
        $(this).append('<input type="hidden" name="customers_id" value="'+$('#customer_id').val()+'">');
        
     
        return true;
    });
    
    function DownloadExcelFile() {
        var form = document.createElement("form");
        var branch = document.createElement("input"); 
        var customers_id = document.createElement("input"); 
        var search_start_date = document.createElement("input"); 
        var search_end_date = document.createElement("input");
        var search_status = document.createElement("input");
        var data_limit = document.createElement("input"); 
        var is_today = document.createElement("input");
        
        document.body.appendChild(form);
        form.method = "POST";
        form.action = "{{route('activity.download_excel')}}";
            branch.name="branch";
            customers_id.name = "customers_id";
            search_start_date.name="search_start_date";
            search_end_date.name="search_end_date";
            data_limit.name="data_limit";
            is_today.name = "is_today";
            search_status.name="search_status";

            branch.value=$('#branch').val();
            customers_id.value = $('#customer_id').val();
            search_start_date.value=$('#s_date').val();
            search_end_date.value= $('#e_date').val();
            is_today.value = ($('#today_checkbox').prop('checked')==true)?1:0;
            data_limit.value = ($('#data_limit').prop('checked')==true)?1:0;
            search_status.value = $('#status_id').val();

            form.appendChild(branch); 
            form.appendChild(customers_id); 
            form.appendChild(search_start_date); 
            form.appendChild(search_end_date);
            form.appendChild(data_limit);
            form.appendChild(is_today);
            form.appendChild(search_status);
            form.submit();
    }
</script>
<!-- end script -->





<script type="text/javascript">
    var _gaq = _gaq || [];
    _gaq.push(['_setAccount', 'UA-39365077-1']);
    _gaq.push(['_trackPageview']);

    (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
    })();
</script>   
<script src="{{asset('asset/signature_pad_proparty/signature_pad.umd.js.download')}}"></script>
<script src="{{asset('asset/signature_pad_proparty/app.js.download')}}"></script>
<script>
    function sendWavFiletoServer(wavFile) {
        var user_type = $('#user_type').val();
        var formdata = new FormData();
        formdata.append("image_file", wavFile);
        formdata.append("activity_id", $('#serviceform_acivity_id').val()); 
        formdata.append("user_type",user_type);//technican_sign_image  
        formdata.append("_token", $("meta[name='csrf-token']").attr("content")); 
        var ajax = new XMLHttpRequest();
        ajax.open("POST", "/activity-master/service_report_image");
        ajax.setRequestHeader('_token', $("meta[name='csrf-token']").attr("content"));
        ajax.send(formdata); 
        
        ajax.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                myFunction(this);
            }
        };
        $('#SignatureModal').modal('toggle');

    }
    function myFunction(xml){
       var response = JSON.parse(xml.response);
        if(response.data.user_type == 'client_sign_image'){
            $("#client_sign_image").attr("src",response.data.file);
            $('#client_sign_image_file').hide();
            $('#client_sign_file_name').val(response.data.file_name);
            $("#client_sign_image").show();
            
            $('#out_time').val(response.data.sign_time)
        }
        if(response.data.user_type == 'technican_sign_image'){
            $("#technican_sign_image").attr("src",response.data.file);
            $('#technican_sign_file').hide();
            $('#technician_sign_file_name').val(response.data.file_name);
            $("#technican_sign_image").show();
        }
        if(response.data.user_type == 'relaince_form'){
            $("#technican_sign_image").show();
            console.log(response.data.file);
            var signature_element_id = $('#relaince_form_signature_element').val();
           $('#image_'+signature_element_id).attr("src",response.data.file);
           $('#image_'+signature_element_id).show();
           $('#image_file_'+signature_element_id).val(response.data.file_name);
        }
        
    }
</script>
<script>
        $('.addJob_button').click(function () {
            var activity_id= $(this).attr('data-id');
            $('#serviceform_acivity_id').val(activity_id);
            $('#addJobId').val(activity_id);
        });
        
        $('.create_audit_report').click(function () {
            var activity_id= $(this).attr('data-id');
            $('#auditreport_id').val(activity_id);
        });
    // ajit 
    $('#move_activity_jobcart').click(function(){  
            var form_data = new FormData();                  
            form_data.append("_token", $("meta[name='csrf-token']").attr("content")); 
            form_data.append('current_id', $('#old_id').val());
            form_data.append('new_id', $('#new_id').val());
            $.ajax({
                url: "/activity-master/service_report/move",
                dataType: 'script',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,                         
                type: 'post',
                success: function(response){
                    response = JSON.parse(response);
                    if(response.status == 'success'){
                        swal("Greate!", response.message, "success");
                    }else{
                        swal("upps!",response.message, "error");
                    }
                    $('#move_jobcart').modal('toggle'); 
                },
                error: function (error) {
                    alert('something went to worng');
                } 
            });
    });
    // by ajit
        
    $('.submit_service_form').click(function(e){  
        if($('#service_spacification').val() == '' || (!$('#service_spacification').val())){
            swal('Opps..!',"Please fill Service Spacification", "error");
        }else if( $('#technican_name').val() =='' || (!$('#service_spacification').val())){
            swal('Opps..!',"Please fill Technican Name", "error");
        }else if( $('#client_name').val() =='' || (!$('#client_name').val())){
            swal('Opps..!',"Please fill Client Name", "error");
        }else if( $('#client_mobile').val() =='' || (!$('#client_mobile').val())){
            swal('Opps..!',"Please fill Client Mobile", "error");
        }else if( $('#technician_sign_file_name').val() =='' || (!$('#technician_sign_file_name').val()) || $('#technician_sign_file_name').val() == 0){
            swal('Opps..!',"Please fill Technician Sign", "error");
        }
        else if( $('#client_sign_file_name').val() =='' || (!$('#client_sign_file_name').val()) || $('#client_sign_file_name').val() == 0 ){
               swal('Opps..!',"Please fill Client Sign", "error");
        }else{
            var form_data = new FormData();                  
            form_data.append('activity_id', $('#serviceform_acivity_id').val());
            form_data.append('service_spacification', $('#service_spacification').val());
            form_data.append('in_time', $('#in_time').val());
            form_data.append('out_time', $('#out_time').val());
            form_data.append('technican_name', $('#technican_name').val());
            form_data.append('client_name', $('#client_name').val());
            form_data.append('client_mobile', $('#client_mobile').val());
            form_data.append('technician_sign_file_name', $('#technician_sign_file_name').val());
            form_data.append('client_sign_file_name', $('#client_sign_file_name').val());
            
            $.ajax({
                    url: "/activity-master/service_report/save",
                    dataType: 'script',
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: form_data,                         
                    type: 'post',
                    success: function(){
                        $('.service_report_Model').modal('toggle'); 
                }
            });
        }
       
            
    });
    $('#openServiesModel').click(function(){  
        $.ajax({
                url: "/activity-master/service_report_default_infomation/"+ $('#serviceform_acivity_id').val(),
                type: 'get',
                success: function(response){
                    $('#branch_name').val(response.data['name']);
                    $('#site_name').val(response.data['customer_name']);
                    $('#site_address').val(response.data['billing_address']);
                    $('#contact_person').val(response.data['contact_person']);
                    $('#contact_mobile').val(response.data['contact_person_phone']);
                    $('#mail').val(response.data['billing_email']);
                    $('#shipping_address').val(response.data['shipping_address']);
                        
                }
        });
        // saved information
        $.ajax({
            url: "/activity-master/service_report/"+ $('#serviceform_acivity_id').val(),
            type: 'get',
            success: function(response){
                // console.log(response);
                if(response.data.service_spacification != ''){
                    $('#service_spacification').val(response.data.service_spacification);
                }
                
                if(response.data.in_time != ''){
                    $('#in_time').val(response.data.in_time);
                }
                if(response.data.out_time != ''){
                    $('#out_time').val(response.data.out_time);
                }
                if(response.data.technican_name != ''){
                    $('#technican_name').val(response.data.technican_name);
                }
                if(response.data.technican_sign_image != ''){
                    $('#technican_sign_image').attr('src',response.data.technican_sign_image);
                    $('#technican_sign_image').show();
                }else{
                    $('#technican_sign_image').hide();
                }
                if(response.data.client_sign_image != ''){
                    $('#client_sign_image').attr('src',response.data.client_sign_image);
                    $('#client_sign_image').show();
                }else{
                    $('#client_sign_image').hide();
                }
                if(response.data.client_seal_image != ''){
                    $('#client_seal_image').attr('src',response.data.client_seal_image);
                    $('#client_seal_image').show();
                }else{
                    $('#client_seal_image').hide();
                }
                if(response.data.technican_name != ''){
                    $('#client_name').val(response.data.client_name);
                }
                if(response.data.client_mobile != ''){
                    $('#client_mobile').val(response.data.client_mobile);
                }
                swal({
                    title: "Are You Sure?",
                    text: "are you sure you filling report for "+$('#branch_name').val()+" at "+$('#shipping_address').val(),
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Yes",
                    cancelButtonText: "No",
                    closeOnConfirm: true,
                    closeOnCancel: true,
                },
                function(isConfirm){
                    if (isConfirm) {
                        $('.service_report_Model').modal('toggle');
                    }
                });         
            }
        });
       
    });
    
    // new by ajit 31-10-23
        $('.siganature_click_button').click(function(){
        $('#user_type').val('relaince_form');
        $('#relaince_form_signature_element').val($(this).attr('id'));
     });
        $('#openRelianceServiesModel').click(function(){  
        $.ajax({
                url: "/activity-master/service_report_default_infomation/"+ $('#serviceform_acivity_id').val(),
                type: 'get',
                success: function(response){
                    $('#shipping_address').val(response.data['shipping_address']);     
                }
        });
       //willl come from  saved data
       var all_activity_element = document.getElementsByClassName("rel_form");
        for (var i = 0, len = all_activity_element.length; i < len; i++) {
            $(all_activity_element[i]).val('');
        }
        var image_element = document.getElementsByClassName("image_display");
       for (var i = 0, len = image_element.length; i < len; i++) {
            $(image_element[i]).attr('src','');
            $(image_element[i]).hide();
            
        }
        
        
        $.ajax({
            url: "/activity-master/relaince_service_report/"+ $('#serviceform_acivity_id').val(),
            type: 'get',
            success: function(response){
                console.log(response);
                if(response.status == 'success'){
                    $('#store_name').val(response.data.main_form.store_name);
                    $('#store_code').val(response.data.main_form.store_code);
                    $('#forment').val(response.data.main_form.forment);
                    $('#state').val(response.data.main_form.state);
                    $('#carpet_area').val(response.data.main_form.carpet_area);
                    // $('#vendor_name').val(response.data.main_form.vendor_name);
                    $('#month').val(response.data.main_form.month);
                    $('#year').val(response.data.main_form.year);
                    if(response.data.third_element){
                        $('#last_observations_date').val(response.data.third_element.last_observations_date);
                    
                    $('#last_audit_suggestional').val(response.data.third_element.last_audit_suggestional);
                        $('#earlier_audit_recommended').val(response.data.third_element.earlier_audit_recommended);
                    }
                    
                    $.each(response.data.first_element, function( index, inner_array ) {
                        var first_activity_element = $('.'+index+'_first_element'); 
                        for (var i = 0,len = inner_array.length; i < len; i++) {
                            $(first_activity_element[i]).val(inner_array[i]);
                        }  
                    });
                    $.each(response.data.second_element, function( index, inner_array ) {
                        var second_element_element = $('.'+index+'_second_element'); 
                    for (var i = 0,len = inner_array.length; i < len; i++) {
                            $(second_element_element[i]).val(inner_array[i]);
                        }  
                    });
                    $.each(response.data.fourth_element, function( index, inner_array ) {
                        var fourth_element_element = $('.'+index+'_fourth_element'); 
                    for (var i = 0,len = inner_array.length; i < len; i++) {
                            if(index =='pco_sign_image'){
                                $(fourth_element_element[i]).attr('src',inner_array[i]);
                                if((inner_array[i]!= null) && (inner_array[i]) && (inner_array[i] != 'undefined') ){
                                    $(fourth_element_element[i]).show();
                                }
                            }else{
                                $(fourth_element_element[i]).val(inner_array[i]);
                            }
                        }  
                    });
                    $.each(response.data.fifth_element, function( index, inner_array ) {
                        var fifth_element_element = $('.'+index+'_fifth_element'); 
                    for (var i = 0,len = inner_array.length; i < len; i++) {
                            if(index =='store_manager_sign_image'){
                                $(fifth_element_element[i]).attr('src',inner_array[i]);
                                if((inner_array[i] != null) && (inner_array[i]) && (inner_array[i] != 'undefined')){
                                    $(fifth_element_element[i]).show();
                                }
                            }else if(index =='vender_sign_image'){
                                $(fifth_element_element[i]).attr('src',inner_array[i]);
                                if((inner_array[i] != null) && (inner_array[i]) && (inner_array[i] != 'undefined')){
                                    $(fifth_element_element[i]).show();
                                }
                            }
                            else{
                                $(fifth_element_element[i]).val(inner_array[i]);
                            }
                        }  
                    });
                }

                swal({
                    title: "Are You Sure?",
                    text: "are you sure you filling report for "+$('#branch_name').val()+" at "+$('#shipping_address').val(),
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Yes",
                    cancelButtonText: "No",
                    closeOnConfirm: true,
                    closeOnCancel: true,
                },
                function(isConfirm){
                    if (isConfirm) {
                        $('.relaince_service_report_model').modal('toggle');
                    }
                }); 
                       
            }
        });
    }); 
        $('.submit_relaince_service_form').click(function(){  
        var form_data = new FormData();
        form_data.append("activity_id", $('#serviceform_acivity_id').val()); 
        form_data.append('main[store_name]',$('#store_name').val());
        form_data.append('main[store_code]',$('#store_code').val());
        form_data.append('main[forment]',$('#forment').val());
        form_data.append('main[state]',$('#state').val());
        form_data.append('main[carpet_area]',$('#carpet_area').val());
        form_data.append('main[vendor_name]',$('#vendor_name').val());
        form_data.append('main[month]',$('#month').val());
        form_data.append('main[year]',$('#year').val());
        
        var first_activity_element = document.getElementsByClassName("first_element");
        for (var i = 0, len = first_activity_element.length; i < len; i++) {
            form_data.append('first['+$(first_activity_element[i]).attr('data-id')+'][]',$(first_activity_element[i]).val());
        }

        var second_activity_element = document.getElementsByClassName("second_element");
        for (var i = 0, len = second_activity_element.length; i < len; i++) {
            form_data.append('second['+$(second_activity_element[i]).attr('data-id')+'][]',$(second_activity_element[i]).val());
        }

        form_data.append('third[last_observations_date]',$('#last_observations_date').val());
        form_data.append('third[last_audit_suggestional]',$('#last_audit_suggestional').val());
        form_data.append('third[earlier_audit_recommended]',$('#earlier_audit_recommended').val());

        var fourth_activity_element = document.getElementsByClassName("fourth_element");
        for (var i = 0, len = fourth_activity_element.length; i < len; i++) {
            form_data.append('fourth['+$(fourth_activity_element[i]).attr('data-id')+'][]',$(fourth_activity_element[i]).val());
        }

        var fifth_activity_element = document.getElementsByClassName("fifth_element");
        for (var i = 0, len = fifth_activity_element.length; i < len; i++) {
            form_data.append('fifth['+$(fifth_activity_element[i]).attr('data-id')+'][]',$(fifth_activity_element[i]).val());
        }
        $.ajax({
            url: "/activity-master/relaince_service_report/save",
            dataType: 'script',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,                         
            type: 'post',
            success: function(){
                
            }
        });
    });
     // end new by ajit 31-10-23
    
    
    $('.technican_sign_image_button').click(function(){
        $('#user_type').val('technican_sign_image');
    });
    
    $('.client_sign_image_button').click(function(){
        $('#user_type').val('client_sign_image');
    });
   

</script>
<script>
    function getTodayActivities() {
        var url = new URL(window.location.href);
        url.searchParams.append('today', true);
        location.href = url.href;
    }
</script>
<script>
    @if( isset($today_data) && ($today_data == true) )
        $('#s_date').hide();
        $('#e_date').hide();
    @endif
    $("#today_checkbox").change(function() {
        if(this.checked) {
            $('#s_date').hide();
            $('#e_date').hide();
        }else{
            $('#s_date').show();
            $('#e_date').show();
        }
    });

    
</script>
<!-- end form -->
@include('hvl.activitymaster._footer_script')
@endsection


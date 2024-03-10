@extends('app.layout')
{{-- page title --}}
@section('title','Lead Management | HVL')
@section('vendor-style')
@endsection
@section('content')
@php
    $edit_leads =false;
    $read_leads =false;
    $delete_leads = false;
@endphp
@can('Edit leads')
    @php 
        $edit_leads = true;
    @endphp
@endcan
@can('Read leads')
    @php 
        $read_leads = true;
    @endphp
@endcan
@can('Delete leads')
    @php 
        $delete_leads = true;
    @endphp
@endcan

<section>
    <div class="container-fluid">
        <header>
            <div class="row">
                <div class="col-md-4">
                    <h2 class="h3 display">Lead Management</h2>
                </div>
                <div class="col-md-8">
                    @can('Create leads')
                    <a href="{{route('lead.create')}}" class="btn btn-primary pull-right rounded-pill">Add Lead</a>
                    @endcan
                    @can('Delete leads' )
                    <a id="mass_delete_id" class="btn btn-primary pull-right rounded-pill mr-2">
                        <i class="fa fa-trash"></i> Mass Delete
                    </a>
                    @endcan
                    <a class="btn btn-primary rounded-pill pull-right mr-2 " data-toggle="modal" data-target="#modal_download"><span class="fa fa-download fa-lg"></span> Download</a>
                     @can('Access Lead Bulkupload')
                        <a class="btn btn-primary rounded-pill pull-right mr-2"  href="{{ route('admin.leadmaster_bulkupload.index') }}">
                            <i class="fa fa-upload fa-lg"></i>Upload Lead
                        </a>
                    @endcan
                </div>
            </div>
        </header>

        <!-- Page Length Options -->
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
                <br>
                <div class="col-sm-6 col-md-12">
                     <form action="{{route('lead.index.filter')}}" method="post">
                        <div class="row">
                            <div class="col-sm-6 col-md-3">
                                <input type="text" name="start" id="search_start_date" value="{{(isset($search_start_date))?$search_start_date:''}}" class="form-control datepicker" placeholder="Enter Start Date" autocomplete="off" autofocus="off">
                            </div>

                            <div class="col-sm-6 col-md-3">
                                <input type="text" name="end" id="search_end_date" value="{{(isset($search_end_date))?$search_end_date:''}}" class="form-control datepicker" placeholder="Enter End Date" autocomplete="off" autofocus="off">
                            </div>
                             
                             <div class="col-sm-6 col-md-2">
                                <select id="status_id"  name="status_id[]" class="form-control select" multiple required>
                                    @foreach($status as $key=>$status_row)
                                        <option value="{{$key}}"  {{(in_array($key,$search_status)?'selected':'')}} >{{$status_row}}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="col-sm-6 col-md-1">
                                <button type="submit" class="btn btn-primary">Search</button>
                            </div>
                            <div class="col-sm-6 col-md-1">
                                <a class="btn btn-primary" href="{{route('lead.index')}}">Reset</a>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="table-responsive">
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
                                <th class="sorting_disabled" width="15%">Action</th>
                                <th width="10%"> Type</th>
                                <th width="10%">Company Name</th>
                                <th width="10%">First Name</th>
                                <th width="10%">Revenue Value </th>
                                <th width="8%">Email</th>
                                <th width="8%">Phone</th>
                                <th width="8%">Employee</th>
                                <th width="8%">Owner</th>
                                <th width="8%">Create Date</th>
                                <th width="8%">Follow Up Date</th>
                                <th width="7%">Status</th>
                                <th width="8%">Geographical Segment</th>
                                <th width="8%">Lead Source</th>
                                <th width="8%">Industry</th>
                                <th width="8%">Address</th>
                                <th width="8%">Comment 1</th>
                                <th width="8%">Comment 2</th>
                                <th width="8%">Comment 3</th>
                                <th width="8%">Lead Size</th>
                                <th width="8%">Proposal Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($leadDetails as $key => $Detailes)
                            <tr>
                                <td>
                                    <label>
                                        <input type="checkbox" data-id="{{ $Detailes->id }}"
                                               name="selected_row"/>
                                        <span></span>
                                    </label>
                                </td>
                                <td width="2%">
                                    <center>{{++$key}}</center>
                                </td>
                                <td>
                                    @if('edit_leads')
                                    <a href="{{ route('lead.edit', $Detailes->id) }}"
                                    class="tooltipped mr-10"
                                    data-position="top"
                                    data-tooltip="Edit Lead">
                                        <span class="fa fa-edit fa-lg"></span>
                                    </a>
                                    <a href="{{ route('lead.approve', $Detailes->id) }}"
                                    class="tooltipped mr-10"
                                    data-position="top"
                                    data-tooltip="Approve To Customer">
                                        <span class="fa fa-check fa-lg"></span>
                                    </a>
                                    @endif
                                    @if('read_leads')
                                    <a href="{{ route('lead.show', $Detailes->id) }}"
                                    class="tooltipped mr-10"
                                    data-position="top"
                                    data-tooltip="Show Lead">
                                        <span class="fa fa-eye fa-lg"></span>
                                    </a>
                                    @endif
                                    @if('delete_leads')
                                    <a href="" class="button" data-id="{{$Detailes->id}}"><span class="fa fa-trash fa-lg"></span></a>
                                    @endif
                                </td>
                                <td>{{$Detailes->company_type_name}}</td>
                                <td>{{$Detailes->last_company_name}}</td>
                                <td>{{$Detailes->f_name}}</td>
                                <td>{{$Detailes->revenue}}</td>
                                <td>{{$Detailes->email}}</td>
                                <td>{{$Detailes->phone}}</td>
                                <td>{{$Detailes->emp_name}}</td>
                                <td>{{$Detailes->owner_name}}</td>
                                <td>{{$Detailes->create_date}}</td>
                                <td>{{$Detailes->follow_date}}</td>
                                <td>{{$Detailes->lead_status}}</td>
                                <td>{{$Detailes->rating_name}}</td>
                                <td>{{$Detailes->lead_name}}</td>
                                <td>{{$Detailes->industry_name}}</td>
                                <td>{{$Detailes->address}}</td>
                                <td>{{$Detailes->comment}}</td>
                                <td>{{$Detailes->comment_2}}</td>
                                <td>{{$Detailes->comment_3}}</td>
                                @if(key_exists($Detailes->lead_size,$lead_sizes))
                                <td>{{ $lead_sizes[ $Detailes->lead_size ] }}</td>
                                @else
                                <td>-</td>
                                @endif
                                @if(isset($lead_proposal_date[$Detailes->id]))
                                <td>{{ $lead_proposal_date[$Detailes->id] }}</td>
                                @else
                                <td>-</td>
                                @endif
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div id="excel_file_download_form_place">
    </div>
    <div id="modal_download" tabindex="-1" role="dialog" aria-hidden="true" class="modal fade text-left">
        <div role="document" class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Download Report</h4>
                    <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body p-4 row">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="card">
                                <div class="card-body text-center ">
                                       <button class="btn btn-success " id="download_lead_button" >
                                            <span class="fa fa-file-excel-o fa-3x text-green"></span>
                                            CSV
                                        </button>
                                   
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="card">
                                <div class="card-body text-center">
                                    <button class="btn btn-primary center" data-toggle="modal" data-target="#email_div">
                                        <span class="fa fa-envelope fa-3x text-danger"></span>
                                        Email
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group " style="margin-left: 10px;">
                            <input type="checkbox" id="data_limit" checked name="data_limit" >    
                            <label for="">Excel File Limit 10000 Lead</label>
                            <div class="danger">
                                <p><strong>Note:-</strong> unlimited data able creas system</p>
                            </div>
                        </div> 
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="email_div" tabindex="-1" role="dialog" aria-hidden="true" class="modal fade text-left">
        <div role="document" class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Send Mail</h4>
                    <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body p-4 row">
                    <div class="col-sm-12">
                        <form action="{{ route('lead.mail_sheet') }}" method="post" id="mail_form" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="form-group col-sm-12 col-md-6">
                                    <label for="">To</label>
                                    <input type="email" class="form-control" name="to" required>
                                </div>
                                <div class="form-group col-sm-12 col-md-6">
                                    <label for="">CC</label>
                                    <input type="email" class="form-control" name="cc">
                                </div>
                                <div class="form-group col-sm-12 col-md-6">
                                    <label for="">BCC</label>
                                    <input type="email" class="form-control" name="bcc">
                                </div>
                                <div class="form-group col-sm-12 col-md-6">
                                    <label for="">Subject</label>
                                    <input type="text" class="form-control" name="subject" required>
                                </div>
                                <div class="form-group col-sm-12 col-md-6">
                                    <label for="">Body</label>
                                    <textarea class="form-control" name="body"></textarea>
                                </div>
                                <div class="col-sm-12">
                                    <input type="submit" class="btn btn-success rounded" id="submit_lead_mail_button" value="Send">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@section('page-script')
<!-- surani ajit forbackend excel download -->
<script>
     $("#download_lead_button").click( function() {
        DownloadExcelFile();
    });
    $("#mail_form").submit( function(e) {
        $(this).append('<input type="hidden" name="search_start_date" value="'+$('#search_start_date').val()+'">');
        $(this).append('<input type="hidden" name="search_end_date" value="'+$('#search_end_date').val()+'">');
        $(this).append('<input type="hidden" name="search_status" value="'+$('#status_id').val()+'">');
        var limit = ($('#data_limit').prop('checked')==true)?1:0;
        $(this).append('<input type="hidden" name="data_limit" value="'+ limit +'">');
        return true;
    });
    

 function DownloadExcelFile() {
    var form = document.createElement("form");
    var search_start_date = document.createElement("input"); 
    var search_end_date = document.createElement("input"); 
    var search_status = document.createElement("input"); 
    var data_limit = document.createElement("input"); 
    
        document.body.appendChild(form);
        form.method = "POST";
        form.action = "{{route('lead.download_lead')}}";
        search_start_date.name="search_start_date";
        search_end_date.name="search_end_date";
        search_status.name="search_status";
        data_limit.name="data_limit";

        search_start_date.value=$('#search_start_date').val();
        search_end_date.value= $('#search_end_date').val();
        search_status.value=$("#status_id").val();

        data_limit.value = ($('#data_limit').prop('checked')==true)?1:0;
        
        form.appendChild(search_start_date); 
        form.appendChild(search_end_date); 
        form.appendChild(search_status); 
        form.appendChild(data_limit); 
        form.submit();
    }
</script>
<!-- end script -->
<script>
    $(document).ready(function () {
        $('#page-length-option').DataTable({
            "scrollX": true,
            "fixedHeader": true,
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
    });
    $('.datepicker').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        todayHighlight: true
    });
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.4/jspdf.min.js"></script>
<script>
    $(document).ready(function () {
        var checkbox = $('.multiselect tbody tr td input');
        var selectAll = $('.multiselect .select-all');
        checkbox.on('click', function () {
            $(this).parent().parent().parent().toggleClass('selected');
        });
        checkbox.on('click', function () {
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
        // mass delete
        $('#mass_delete_id').click(function () {
            var checkbox_array = [];
            var token = $("meta[name='csrf-token']").attr("content");
            $.each($("input[name='selected_row']:checked"), function () {
                checkbox_array.push($(this).data("id"));
            });
            if (typeof checkbox_array !== 'undefined' && checkbox_array.length > 0) {
                swal({
                    title: "Are you sure, you want to delete? ",
                    text: "You will not be able to recover this record!",
                    type: 'warning',
                    showCancelButton: true,
                    customClass: 'swal-small',
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Yes, delete it!",
                    closeOnConfirm: false
                },
                        function (isConfirm) {
                            if (isConfirm) {
                                $.ajax({
                                    url: '{{route('lead.massdelete')}}',
                                    type: 'POST',
                                    data: {
                                        "_token": token,
                                        ids: checkbox_array,
                                    },
                                    success: function (result) {
                                        swal({
                                            title: "Record has been deleted!",
                                            type: "success",
                                        }, function () {
                                            location.reload();
                                        });
                                    }
                                });
                            }
                        });
            } else {
                swal({
                    title: "Please Select Atleast One Record",
                    type: 'warning',
                    customClass: 'swal-small',
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
            },
            function (isConfirm) {
                if (isConfirm) {
                    $.ajax({
                        url: "{{route('lead.delete')}}",
                        type: "get",
                        data: {
                            "id": id
                        },
                        success: function (result) {
                            swal({
                                title: "Record has been deleted!",
                                type: "success",
                            }, function () {
                                location.reload();
                            });
                        }
                    });
                }
            });
        });
    });
</script>
@endsection



@extends('app.layout')
@section('title','Activity Management | HVL')
@section('vendor-style')
<link rel="stylesheet" href="https://cdn.datatables.net/datetime/1.1.0/css/dataTables.dateTime.min.css">
@endsection
@section('content')
@php
  
   
    $generate_audit = false;
    $audit_send_mail =false;
@endphp
 
@can('generate audit')
    @php
        $generate_audit = true;
    @endphp
@endcan
@can('audit send_mail')
    @php
        $audit_send_mail = true;
    @endphp
@endcan



<section>
    <div class="container-fluid">
        <header>
            <div class="row">
                <div class="col-md-4">
                    <h2 class="h3 display">Customer Audit Scheduled</h2>
                    <p>
                        <b>Customer Name : {{$customer->name}}</b><br>
                        ({{$customer->address}})
                    </p>
                </div>
            </div>
        </header>
        <div class="card">
            @if(session()->has('success'))
                <div class="alert alert-success">
                    {{ session()->get('success') }}
                </div>
            @endif
            @if(session()->has('error'))
                <div class="alert alert-danger">
                    {{ session()->get('error') }}
                </div>
            @endif
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="card-body">
                <div class="">
                    <form action="{{route('admin.customer.audit_list',$customer->id)}}" method="post">
                    @csrf
                        <div class="row">
                           
                          
                            <div class="col-sm-6 col-md-2">
                                <input type="text" name="start" class="form-control datepicker" id="s_date" value="{{(isset($search_sdate)?$search_sdate:'')}}" autocomplete="off" placeholder="Enter Start Date" >
                            </div>
                            <div class="col-sm-6 col-md-2">
                                <input type="text" name="end" class="form-control datepicker" id="e_date" value="{{(isset($search_edate)?$search_edate:'')}}" autocomplete="off" placeholder="Enter End Date" >
                            </div>
                            <div class="col-sm-6 col-md-1">
                                <button type="submit" class="btn btn-primary"> Search</button>
                            </div>
                            <div class="col-sm-4 col-md-1" style="padding: 0px;">
                                <a class="btn btn-primary" href="{{route('admin.customer.audit_list',$customer->id)}}">Reset</a>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="table-responsive mt-4">
                    <table id="page-length-option" class="table table-striped table-hover multiselect">
                        <thead>
                            <tr>
                                <th width='5%'>ID</th>
                                @if($generate_audit)
                                    <th width='15%'>Generated</th>
                                @endif
                                @if($generate_audit)
                                    <th width='15%'>Download</th>
                                @endif
                                @if($audit_send_mail)
                                    <th width='15%'>Mail</th>
                                @endif
                                <th width='15%'>Audit Type</th>
                                <th width='25%'>Schedule At</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($audit_list as $key => $data)
                            <tr>
                                <td>{{$key+=1}}</td>
                                @if($generate_audit)
                                <td>
                                    <a href="{{route('admin.audit_generate.index',$data->id)}}" class="btn btn-primary rounded-pill mr-2 print_button" type="submit" target="_blank" >
                                        <i class="fa fa-eye"></i>
                                        View
                                    </a>
                                </td>
                                @endif
                                <!-- working area -->
                                @if($generate_audit)
                                <td>
                                    <a  class="btn btn-primary  rounded-pill mr-2 print_button" href="{{route('admin.audit_generate.pdf',$data->id)}}"  style="margin-top:0px;">
                                        <i class="fa fa-download"></i> Download
                                    </a>
                                </td>
                                @endif
                                @if($audit_send_mail)
                                <td>
                                    <button  class="btn btn-primary  rounded-pill mr-2 email_audit_report" data-toggle="modal" data-id="{{$data->id}}"  data-target="#email_div"  style="margin-top:0px;">
                                        <i class="fa fa-envelope"></i> Mail
                                    </button>
                                </td>
                                @endif
                                <!-- working area -->

                                <td  width='5%'>{{$data->getAuditTypeText($data->audit_type)}}</td>
                               <td  width='5%'>{{$data->schedule_date}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{$audit_list->links()}}
                </div>
            </div>
        </div>
    </div>
</section>
<div id="email_div" tabindex="-1" role="dialog" aria-hidden="true" class="modal fade text-left">
    <div role="document" class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Send Mail</h4>
                <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body p-4 row">
                <div class="col-sm-12">
                    <form action="{{route('admin.customer.send_customer_audit')}}" method="post">
                        @csrf
                        <input type="hidden" id="audit_id" name="audit_id" value="">
                        <div class="row">
                            <div class="form-group col-sm-12 col-md-6">
                                <label for="">To</label>
                                <input type="email" class="form-control" name="to" required>
                            </div>
                            <div class="form-group col-sm-12 col-md-6">
                                <label for="">Subject</label>
                                <input type="text" class="form-control" name="subject" value="Customer audit report" required>
                            </div>
                            <div class="form-group col-sm-12 col-md-12">
                                <label for="">Body</label>
                                <textarea class="form-control" name="body">Greetings From Hvl Pest Services !!
Please check the enclosed Audit Report.
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
@endsection
@section('page-script')
<script>
    $('.datepicker').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        todayHighlight: true
    });
</script>
<script>
    $(document).ready(function () {
        
        var checkbox = $('.multiselect tbody tr td input');
        var selectAll = $('.multiselect .select-all');
        checkbox.on('click', function () {
            $(this).parent().parent().parent().toggleClass('selected');
        });
        $('.select').multiselect({
            includeSelectAllOption: true,
            enableFiltering: true,
            enableCaseInsensitiveFiltering: true,
            filterPlaceholder: 'Search for Customer...',
            nonSelectedText: 'Select Customer',
            maxHeight: 450
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
       
        $('.email_audit_report').click(function () {
            $('#audit_id').val($(this).data('id'));

        }); 
    });
</script>
@endsection


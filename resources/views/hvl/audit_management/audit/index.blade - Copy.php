@extends('app.layout')
{{-- page title --}}
@section('title','Activity Management | HVL')
@section('vendor-style')
<link rel="stylesheet" href="https://cdn.datatables.net/datetime/1.1.0/css/dataTables.dateTime.min.css">
@endsection
@section('content')
@php
$model = $audit_list;
$index_start = $audit_list->perPage() * ($audit_list->currentPage() - 1);
@endphp
@php
    $create_audit = false;
    $read_audit = false;
    $edit_audit=false;
    $delete_audit =false;
    $generate_audit = false;
@endphp
@can('create audit')
    @php
        $create_audit=true;
    @endphp
@endcan
 
@can('read audit')
    @php
        $read_audit=true;
    @endphp 
@endcan   
@can('edit audit')  
    @php
        $edit_audit=true;
    @endphp
@endcan
@can('delete audit')
    @php
        $delete_audit=true;
    @endphp
@endcan
@can('generate audit')
    @php
        $generate_audit = true;
    @endphp
@endcan
<section>
    <div class="container-fluid">
        <header>
            <div class="row">
                <div class="col-md-4">
                    <h2 class="h3 display">Audit Schedule</h2>
                </div>
                <div class="col-md-8">
                    @if($create_audit)
                    <a href="{{route('admin.audit.create')}}" class="btn btn-primary pull-right rounded-pill">Add Schedule</a>
                    @endif
                    @if($delete_audit )
                    <a id="mass_delete_id" class="btn btn-primary pull-right rounded-pill mr-2">
                        <i class="fa fa-trash"></i> Mass Delete
                    </a>
                    @endif
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
                    <form action="{{route('admin.audit.filter')}}" method="post" >
                    @csrf
                        <div class="row">
                            <div class="col-sm-6 col-md-2">
                               <select class="form-control" name="branch_id" id="branch_id" autocomplete="off" autofocus="off" data-error=".errorTxtBranch">
                                    <option value=""> Select Branch</option>
                                        @foreach($all_branche as $key=>$branch_name)
                                            <option value="{{$key}}" {{(isset($search_branch) && $search_branch ==$key)?'selected':'' }} >{{$branch_name}}</option>
                                        @endforeach
                                </select>
                            </div>
                            <div class="col-sm-6 col-md-2">
                                <select class="form-control select" name="customers_id[]" id="customers" multiple>
                                        @foreach($search_branch_costomer as $key=>$customer_name)
                                                <option value="{{$key}}" {{(!empty($search_customer) && in_array($key,$search_customer))?'selected':'' }} >{{$customer_name}}</option>
                                        @endforeach
                                </select>
                            </div>
                            
                            <div class="col-sm-6 col-md-2">
                                <input type="hidden" name="search" id="search_box">
                            </div>
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
                                <a class="btn btn-primary" href="{{route('admin.audit.index')}}">Reset</a>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="table-responsive mt-4">
                <div id="page-length-option_filter" class="pull-right dataTables_filter">
                    <label>
                        Search:
                        <input type="search" id="__searchbox" class="form-control form-control-sm" placeholder="" aria-controls="page-length-option">
                    </label>
                </div>
                    <table id="page-length-option" class="table table-striped table-hover multiselect">
                        <thead>
                            <tr>
                                <th class="sorting_disabled" width="5%">
                                    <label>
                                        <input type="checkbox" class="select-all m-1"/>
                                        <span></span>
                                    </label>
                                </th>
                                <th width='5%'>ID</th>
                                <th width='15%'>Action</th>
                                @if($generate_audit)
                                    <th width='15%'>Generated</th>
                                @endif
                                <th width='15%'>Audit Type</th>
                                <th width='15%'>Branch</th>
                                <th width='15%'>Customer Code</th>
                                <th width='15%'>Customer</th>
                                <th width='25%'>Schedule At</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($audit_list as $key => $data)
                            <tr>
                                <td>
                                    @if($data->generated == 'no')
                                    <label>
                                        <input type="checkbox" data-id="{{ $data->id }}"
                                               name="selected_row"/>
                                        <span></span>
                                    </label>
                                    @endif
                                </td>
                                <td>{{$index_start + $key+1}}</td>
                                <td>
                                    @if($read_audit == true)
                                    <a href="{{ route('admin.audit.view', $data->id) }}"
                                       class="tooltipped mr-10"
                                       data-position="top"
                                       data-tooltip="View"
                                       target="_blank">
                                        <span class="fa fa-eye"></span>
                                    </a>
                                    @endif
                                    @if($data->generated == 'no')
                                        @if($edit_audit == true)
                                            <a href="{{ route('admin.audit.edit', $data->id) }}"
                                            class="tooltipped mr-10"
                                            data-position="top"
                                            data-tooltip="Edit"
                                            target="_blank">
                                                <span class="fa fa-edit"></span>
                                            </a>
                                        @endif
                                        @if($delete_audit)
                                            <a href="" class="button" data-id="{{$data->id}}"><span class="fa fa-trash"></span></a>
                                        @endif
                                    @endif
                                </td>
                                @if($generate_audit)    
                                    <td>
                                        <a href="{{route('admin.audit_generate.index',$data->id)}}" class="btn btn-primary mr-2" type="submit" target="_blank" >
                                            <i class="fa fa-save"></i>
                                            {{($data->generated == 'no')?'Generate':'Generated'}}
                                        </a>
                                    </td>
                                @endif
                                <td  width='5%'>{{$data->getAuditTypeText($data->audit_type)}}</td>
                                <td  width='5%'>{{$data->branch}}</td>
                                <td  width='5%'>{{$customer_codes[$data->customer_id]}}</td>
                                <td  width='5%'>{{$data->customer_name}}</td>
                                <td  width='5%'>{{$data->schedule_date}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <form method="POST" id="pagination_form" >
                        @csrf
                        @foreach($search_param as $key=>$values)
                            @if($key == 'customers_id')
                                @foreach($values as $value)
                                    <input type="hidden" name="{{$key}}[]" value="{{$value}}">
                                @endforeach
                            @else
                                <input type="hidden" name="{{$key}}" value="{{$values}}">
                            @endif
                        @endforeach
                        @php 
                            $helper = new Helper();
                        @endphp
                        <?=$helper->paginateLink($model)?>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

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
    $('.page-link').click(function(e){
        e.preventDefault();
        $('#pagination_form').attr('action', $(this).attr('data-page-url')).submit();

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
        $('#branch_id').change(function(){
            getCustomers($(this).val());
        });
        $('#__searchbox').keyup(function(){
           var search_text = $(this).val();
           if(search_text.length > 3){
            alert(search_text.length);
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
                                    url: '{{route("admin.audit.massdelete")}}',
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
                        url: "{{route('admin.audit.delete')}}",
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
    function getCustomers(branch_id){
        $.ajax({
            type: "post",
            url: "{{route('admin.audit.getBranchCustomers')}}",
            data: {
                branch_id : branch_id,
            }, 
            headers: {
                    'Authorization': 'Bearer ' ,
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            success: function(data)
            {    
                console.log(data);
                if(data.status == 'success'){
                    var htmlastr ='';
                    $.each(data.data.customer_list,function(key,value){
                        htmlastr = htmlastr+'<option value="'+key+'">'+value+'</option>';
                    });
                    $('#customers').html(htmlastr);
                    $('#customers').multiselect('rebuild');
                }
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) { 
                swal('Opps..!',"Something Went To Wong", "error");
            }
        });
    }

</script>
@endsection


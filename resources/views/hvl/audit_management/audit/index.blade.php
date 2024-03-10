@extends('app.layout')
{{-- page title --}}
@section('title','Activity Management | HVL')
@section('vendor-style')
<link rel="stylesheet" href="https://cdn.datatables.net/datetime/1.1.0/css/dataTables.dateTime.min.css">
@endsection
@section('content')

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
                                <input type="text" name="start" class="form-control datepicker" id="s_date" value="{{(isset($search_sdate)?$search_sdate:'')}}" autocomplete="off" placeholder="Enter Start Date" >
                            </div>
                            <div class="col-sm-6 col-md-2">
                                <input type="text" name="end" class="form-control datepicker" id="e_date" value="{{(isset($search_edate)?$search_edate:'')}}" autocomplete="off" placeholder="Enter End Date" >
                            </div>
                            <div class="col-sm-6 col-md-1">
                                <button type="submit" id="serach_button" class="btn btn-primary"> Search</button>
                            </div>
                            <div class="col-sm-6 col-md-1">
                                <button type="submit" id="reset_button" class="btn btn-primary">Reset</button>
                            </div>
                        </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 col-md-6">
                        <div id="per_page_limit_option">
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6 ">
                        <div class="pull-right dataTables_filter">
                            <label>
                                Search:
                                <input type="search" id="__searchbox" class="form-control form-control-sm" placeholder="" aria-controls="page-length-option">
                            </label>
                        </div>
                    </div>

                </div>
                <table class="table">
                    <thead class="thead-light">
                        <tr>
                            <th scope="col">
                                <label>
                                        <input type="checkbox" class="select-all m-1"/>
                                        <span></span>
                                </label>
                            </th>
                            <th scope="col">ID</th>
                            <th scope="col">Action</th>
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
                    <tbody class="grid-data">
                        <tr>
                            <td align="center" colspan="4">No Data Found</th>
                        </tr>
                    </tbody>
                </table>
                <div class="card">
                    <div class="card-body">
                        <div id="paginate">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<template id="audit-grid-template">
    <tr>
        <th class="checkbox"></th>
        <td class="id"></td>
        <td class="action"></td>
        @if($generate_audit)
        <td class="audit_action"></td>
        @endif
        <td class="audit_type"></td>
        <td class="branch"></td>
        <td class="customer_codes"></td>
        <td class="customer_name"></td>
        <td class="schedule_date"></td>         
    </tr>            
</template>

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
    $('#serach_button').click(function(e){
        loadPageGrid();
    });
    $('#reset_button').click(function(e){
        $('#s_date').val('');
        $('#e_date').val('');
        $('#__searchbox').val('');
        $('#branch_id').val('');
        $('#customers').val('');
        getCustomers(-1);
        $('.multiselect').val('');
        loadPageGrid();
    });
</script>
<script>
    $(document).ready(function () {
        var checkbox = $('.multiselect tbody tr td input');
        var selectAll = $('.multiselect .select-all');
        loadPageGrid();
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
            loadPageGrid();
        }); 
        $('#__searchbox').change(function(){
            console.log($('#__searchbox').val());
            if($('#__searchbox').val()=='' ){
                loadPageGrid();
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
                                            loadPageGrid();
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
                                loadPageGrid();
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

    function loadPageGrid(e){
            url = $(e).attr('data-page-url');
            url = (url)?url:"{{ url('') }}" +'/api/customer_audit';
            var token = window.localStorage.getItem('token'); 
            var data = {
                    user_id:"{{auth()->user()->id}}",
                    start:$('#s_date').val(),
                    end:$('#e_date').val(),
                    search_text: $('#__searchbox').val(),
                    search_branch_id:$('#branch_id').val(),
                    search_customers_id:$('#customers').val(),
            };
            $.ajax({
                type: 'post',
                url: url,
                data:data ,
                headers: {
                    'Authorization': 'Bearer ' ,
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    clientid: " ",
                    clientsecret: " ",
                    'APIAuthKey':token,
                },
                beforeSend: function() {},
                success: function(data) {
                    if (data.status == 'Success') {
                        $(".grid-data").html('');
                        const templ = document.getElementById("audit-grid-template");
                        for (i = 0; i < data.data.audit_list.data.length; i++) {
                            console.log(data.data.audit_list.data[i]);
                            const clone = templ.content.cloneNode(true);
                            var check_box_str = '';
                            if(data.data.audit_list.data[i].generated == 'no'){
                                check_box_str = '<label>';
                                check_box_str = check_box_str+'<input type="checkbox" data-id="'+data.data.audit_list.data[i].id+'" name="selected_row"/>';
                                check_box_str = check_box_str+'<span></span>';
                                check_box_str = check_box_str+'</label>';
                            }
                            clone.querySelector(".checkbox").innerHTML = check_box_str;
                            clone.querySelector(".id").innerHTML = ((data.data.audit_list.current_page-1) * data.data.audit_list.per_page) + i+1;
                            
                            clone.querySelector(".audit_type").innerHTML = data.data.audit_list.data[i].audit_type;
                            clone.querySelector(".branch").innerHTML = data.data.audit_list.data[i].branch;
                            clone.querySelector(".customer_codes").innerHTML = data.data.audit_list.data[i].customer_code;
                            clone.querySelector(".customer_name").innerHTML = data.data.audit_list.data[i].customer_name;
                            clone.querySelector(".schedule_date").innerHTML =data.data.audit_list.data[i].schedule_date;
                            clone.querySelector(".audit_action").innerHTML =data.data.audit_list.data[i].schedule_date;
                            var audit_gen_str ='';
                            @if($generate_audit)
                                var audit_gen_button_str = (data.data.audit_list.data[i].generated == 'no')?'Generate':'Generated';
                                audit_gen_str = audit_gen_str+'<td>'+
                                                    '<a href="customer_audit/generate/'+data.data.audit_list.data[i].id+'" class="btn btn-primary mr-2" type="submit" target="_blank" >'+
                                                    '<i class="fa fa-save"></i>'+
                                                        audit_gen_button_str + 
                                                    '</a>'+
                                                    '</td>';
                            @endif
                            clone.querySelector(".audit_action").innerHTML = audit_gen_str;
                            var action_str ='<div class="row">';
                            @if($read_audit == true)
                                action_str = action_str+'<a href="customer_audit/view/'+data.data.audit_list.data[i].id+'"'+
                                       'class="tooltipped mr-10"'+
                                       'data-position="top"'+
                                       'data-tooltip="View"'+
                                       'target="_blank">'+
                                        '<span class="fa fa-eye"></span>'+
                                    '</a>';
                            @endif
                            @if($edit_audit == true)
                                if(data.data.audit_list.data[i].generated == 'no'){
                                    action_str = action_str +'<a href="customer_audit/edit/'+data.data.audit_list.data[i].id+'"'+
                                        'class="tooltipped mr-10"'+
                                        'data-position="top"'+
                                        'data-tooltip="Edit"'+
                                        'target="_blank">'+
                                            '<span class="fa fa-edit"></span>'+
                                        '</a>';
                                }
                            @endif
                            @if($delete_audit)
                                if(data.data.audit_list.data[i].generated == 'no'){
                                    action_str = action_str +'<a href="" class="button" data-id="'+data.data.audit_list.data[i].id+'">'+
                                        '<span class="fa fa-trash"></span>'+
                                    '</a>';
                                }
                            @endif
                            clone.querySelector(".action").innerHTML = action_str;
                            $(".grid-data").append(clone);
                            
                            }
                            
                        $('#per_page_limit_option').html(data.data.per_page_limit)
                        $('#paginate').html(data.data.page_link);
                    }else{
                        swal({
                            title: "Please Try Somthing Went To Wrong",
                            type: 'warning',
                            customClass: 'swal-small',
                        });
                    }
                    
                },
                error: function(data) {
                        swal({
                            title: "Please Try Somthing Went To Wrong",
                            type: 'warning',
                            customClass: 'swal-small',
                        });
                },
            });
        }

</script>
@endsection


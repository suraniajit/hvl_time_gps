@extends('app.layout')
{{-- page title --}}
@section('title','Audit Schedule | HVL')
@section('vendor-style')
@endsection
@section('content')
<div class="breadcrumb-holder">
    <div class="container-fluid">
        <ul class="breadcrumb">
            <li class="breadcrumb-item active"><a href="{{route('admin.audit.index')}}">Audit Management </a></li>
            <li class="breadcrumb-item ">Update Audit Schedule</li>
        </ul>
    </div>
</div>
<section>
    <div class="container-fluid">
        @if(session()->has('success'))
            <div class="alert alert-success">
                {{ session()->get('success') }}
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
        <div class="card">
            <div class="card-body p-4">
                <header>
                    <div class="row">
                        <div class="col-md-7">
                            <h2 class="h3 display"> Update Audit Schedule</h2>
                            <p style="font-size: 12px;"><strong>Note:</strong> Comma is not allowed in any field.</p>
                        </div>
                    </div>
                </header>
                
                <form action="{{route('admin.audit.update',['id'=>$audit->id])}}" id="formValidate" method="post">
                    {{csrf_field()}}
                    <div class="row">
                        <div class="form-group col-sm-6 col-md-4" style="margin-bottom: 1px;">
                            <label>Audit Type<span class="text-danger">*</span></label>
                            <select class="form-control" name="audit_type" autocomplete="off" autofocus="off" data-error=".errorTxtAuditType">
                                <option value=""> Select Audit Type</option>
                                @foreach($audit_options as $key=>$option)
                                    <option {{($audit->audit_type==$key)?'selected':''}}  value="{{$key}}">{{$option}}</option>
                                @endforeach
                            </select>
                            <div class="errorTxtAuditType text-danger"></div>
                        </div>
                        <div class="form-group col-sm-6 col-md-4" style="margin-bottom: 1px;">
                            <label>Branch<span class="text-danger">*</span></label>
                            <select class="form-control" name="branch_id" id="branch_id" autocomplete="off" autofocus="off" data-error=".errorTxtBranch">
                                <option value=""> Select Branch</option>
                                @foreach($branches as $key=>$branch)
                                        <option value="{{$key}}" {{($selected_branch == $key )?'selected':''}} >{{$branch}}</option>
                                @endforeach
                            </select>
                            <div class="errorTxtBranch text-danger"></div>
                        </div>
                        <div class="form-group col-sm-6 col-md-4" style="margin-bottom: 1px;">
                            <label>Customer<span class="text-danger">*</span></label>
                            <select class="form-control" name="customer_id" id="customers"  autocomplete="off" autofocus="off" data-error=".errorTxtCustomerName">
                                @foreach($selected_branch_customer as $key=>$customer)
                                    <option value="{{$key}}" {{($audit->customer_id == $key )?'selected':''}} >{{$customer}}</option>
                                @endforeach
                            </select>
                            <div class="errorTxtCustomerName text-danger"></div>
                        </div>
                        <div class="form-group col-sm-6 col-md-4">
                            <label>Schedule Date <span class="text-danger">*</span></label>
                            <input type="text" name="schedule_date" value="{{date('Y-m-d',strtotime($audit->schedule_date))}}" class="form-control datepicker"  ondrop="return false;" onpaste="return false;" placeholder="Enter Audit Date" data-error=".errorTxtScheduleDate" autocomplete="off" autofocus="off">
                            <div class="errorTxtScheduleDate text-danger"></div>
                        </div>
                        <div class="form-group col-sm-6 col-md-4">
                            <label>Schedule Time<span class="text-danger">*</span></label>
                            <input type="time" name="schedule_time" value="{{date('H:i:s',strtotime($audit->schedule_date))}}" class="form-control timepicker"  ondrop="return false;" onpaste="return false;" placeholder="Enter Audit Time" data-error=".errorTxtScheduleTime" autocomplete="off" autofocus="off">
                            <div class="errorTxtScheduleTime text-danger"></div>
                        </div>
                        
                        <div class="form-group col-sm-6 col-md-4">
                            <label>Schedule Notes <span class="text-danger">*</span></label>
                                <textarea name="schedule_notes" style="height: 47px;" class="form-control" data-error=".errorTxtScheduleTime">{{$audit->schedule_notes}}</textarea>
                            <div class="errorTxtScheduleNote text-danger"></div>
                        </div>
                    </div>
                    <div class="row mt-4 pull-right">
                        <div class="col-sm-12 ">
                            <button class="btn btn-primary mr-2" type="submit" id="submit">
                                <i class="fa fa-save"></i>
                                Save
                            </button>
                            <a href="{{route('admin.audit.index')}}" class="text-white btn btn-secondary  mb-1">
                                <i class="fa fa-arrow-circle-left"></i>
                                Cancel
                            </a>
                        </div>
                    </div>
                </form>  
            </div>
        </div>
    </div>
</section>
@endsection
@section('page-script')
<script src="{{asset('js/hvl/audit_management/schedule/update.js')}}"></script>
<script>
    $('.datepicker').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        todayHighlight: true
    });
</script>
<script>
    $( document ).ready(function() {
        $('#branch_id').change(function(){
            getCustomers($(this).val());
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
                }
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) { 
                swal('Opps..!',"Something Went To Wong", "error");
            }
        });
    }

    
</script>

@endsection



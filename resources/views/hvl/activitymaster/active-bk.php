@extends('app.layout')

{{-- page title --}}
@section('title','Activity Management | HVL')

@section('vendor-style')

@endsection
@section('content')
    <div class="breadcrumb-holder">
        <div class="container-fluid">
            <ul class="breadcrumb">
                {{--                <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>--}}
                <li class="breadcrumb-item active"><a href="{{route('activity.index')}}">Activity Management </a></li>
                <li class="breadcrumb-item ">Add Activity </li>
            </ul>
        </div>
    </div>
    <section>
        <div class="container-fluid">
            <div class="card">
                <div class="card-body p-4">
                    <header>
                        <div class="row">
                            <div class="col-md-7">
                                <h2 class="h3 display"> Add Activity</h2>
                                <p style="font-size: 12px;"><strong>Note:</strong> Comma is not allowed in any field.</p>
                            </div>
                        </div>

                    </header>
            <form action="{{route('activity.activity_superadmin_store')}}" method="post" id="act_form" enctype="multipart/form-data">

                @csrf
                <div class="row">
                    <div class="form-group col-sm-6 col-md-4" style="margin-bottom: 1px;">

                            <label>Employee <span class="text-danger">*</span></label>
                            <select name="employee_id" id="employee_id" class="form-control" required data-error=".errorTxtEmployee" autocomplete="off" autofocus="off">
                                @if(empty($employee_id))
                                        <option value=""> Select Employee</option>
                                    @foreach($employees as $employee)
                                        <option value="{{$employee->id}}">{{$employee->Name}}</option>
                                    @endforeach
                                @else
                                    <option value="{{$employee_id->id}}" selected>{{$employee_id->Name}}</option>
                                @endif
                            </select>
                            <div class="errorTxtEmployee text-danger"></div>
                    </div>
                    <div class="form-group col-sm-6 col-md-4" style="margin-bottom: 1px;">
                        <label>Customer <span class="text-danger">*</span> </label>
                        <select name="customer_id" id="cust_id" class="form-control" required data-error=".errorTxtCustomer" autocomplete="off" autofocus="off">
                            <option value=""> Select Customer</option>
                            @if(!empty($customers))
                            @foreach($customers as $details)
                                <option value="{{$details->id}}">{{$details->customer_name}}</option>
                            @endforeach
                            @endif
                        </select>
                        <div class="errorTxtCustomer text-danger"></div>
                    </div>
                    <div class="form-group col-sm-6 col-md-4">
                        <label> Subject * </label>
                        <input type="text" name="subject"  class="form-control " onkeypress="return RestrictCommaSemicolon(event);" ondrop="return false;" onpaste="return false;"  required="" data-error=".errorTxtSubject" placeholder="Enter Subject" autocomplete="off" autofocus="off">
                        <div class="errorTxtSubject text-danger" ></div>
                    </div>
                    <div class="form-group col-sm-6 col-md-4">
                        <label>Start Date <span class="text-danger">*</span> </label>
                        <input type="text" name="txt_start_date" required class="form-control datepicker" data-error=".errorTxtStartDate" placeholder="Enter Start Date" autocomplete="off" autofocus="off">
                        <div class="errorTxtStartDate text-danger"></div>
                    </div>
                    <div class="form-group col-sm-6 col-md-4">
                        <label> End Date <span class="text-danger">*</span> </label>
                        <input type="text" name="txt_end_date" required class="form-control datepicker" data-error=".errorTxtEndDate" placeholder="Enter Date Date" autocomplete="off" autofocus="off">
                        <div class="errorTxtEndDate text-danger" ></div>
                    </div>
                    @role('customers_admin')
                    @else
                    <div class="form-group col-sm-6 col-md-4">
                        <label> Per Service Value<span class="text-danger">*</span> </label>
                        <input type="text" name="services_value" required class="form-control" data-error=".errorTxtServiceValue" placeholder="Enter Service value" autocomplete="off" autofocus="off">
                        <div class="errorTxtServiceValue text-danger" ></div>
                    </div> 
                    @endrole          
                     
                    <div class="form-group col-sm-6 col-md-4">
                        <label for="fn">Type <span class="text-danger">*</span></label>
                        <select class="form-control " data-error=".errorTxtType" name="ddl_type" id="ddl_type" required>

                            <option value="" >Select Type</option>
                            @foreach($types as $type)
                                <option value="{{$type->id}}">{{$type->Name}}</option>
                            @endforeach

                        </select>
                        <div class="errorTxtType text-danger"></div>
                    </div>
                    <div class="form-group col-sm-6 col-md-4">
                        <label for="fn">Select frequency <span class="text-danger">*</span></label>
                        <select class="form-control " data-error=".errorTxtFrequency" name="ddl_frequency" id="ddl_frequency" required>
                            <option value="" disable="" selected>Select frequency</option>
                            <option value="daily">Daily</option>
                            <option value="weekly">Weekly</option>
                            <option value="weekly_twice">Weekly Twice</option>
                            <option value="weekly_thrice">Weekly Thrice</option>
                            <option value="fortnightly">Fortnightly</option>
                            <option value="monthly">Monthly</option>
                            <option value="monthly_thrice">Monthly Thrice </option>
                            <option value="bimonthly">Bimonthly</option>
                            <option value="quarterly">Quarterly</option>
                            <option value="quarterly_twice">Quarterly twice</option>
                            <option value="thrice_year">Thrice in a Year</option>
                            <option value="onetime">One Time</option>
                        </select>
                        <div class="errorTxtFrequency text-danger"></div>
                    </div>

                    <div class="form-group col-sm-6 col-md-4">
                        <label for="fn">Status <span class="text-danger">*</span></label>
                        <select class="form-control " data-error=".errorTxtStatus" name="ddl_status" id="ddl_status" required>
                            <option value="" >Select Status</option>
                            @foreach($statuses as $status)
                                <option value="{{$status->id}}">{{$status->Name}}</option>
                            @endforeach
                        </select>
                        <div class="errorTxtStatus text-danger"></div>
                    </div>

                   
                    <div class="form-group col-sm-6 col-md-4">
                        <label for="fn">Created By</label>
                        <input type="text" class="form-control" onkeypress="return RestrictCommaSemicolon(event);" ondrop="return false;" onpaste="return false;" id="comment" data-error=".errorTxt8" name="created_by" readonly value="{{Auth()->user()->name}}">
                    </div>
                    <div class="form-group col-sm-6 col-md-4">
                        <label> Actual Completion Date </label>
                        <input type="text" name="complete_date"  class="form-control datepicker" data-error=".errorTxtCompletionDate" placeholder="Enter Completion Date" autocomplete="off" autofocus="off">
                        <div class="errorTxtCompletionDate text-danger" ></div>
                    </div>
                    <div class="form-group col-sm-6 col-md-4">
                        <label>Remark </label>
                        <input type="text" name="txt_remark" id="txt_remark" class="form-control"  data-error=".errorTxtRemark"  placeholder="Enter Remark" autocomplete="off" autofocus="off">
                        <div class="errorTxtRemark text-danger"></div>
                    </div>
                </div>
                    <div class="row mt-4 pull-right">
                        <div class="col-sm-12 ">
                            <button class="btn btn-primary mr-2" type="submit" >
                                <i class="fa fa-save"></i>
                                Save
                            </button>
                            <button type="reset" class="btn btn-secondary  mb-1">
                                <i class="fa fa-arrow-circle-left"></i>
                                <a href="{{url()->previous()}}" class="text-white">Cancel</a>
                            </button>
                        </div>
                    </div>
            </form>
        </div>
    </div>
        </div>
    </section>
@endsection

@section('page-script')
    <script>
        //***** */
        $(document).ready(function() {
            $("#act_form").validate({
                rules: {
                    txt_start_date: {
                        required: true,
                    },
                    txt_end_date: {
                        required: true,
                    },
                    services_value:{
                        required: true,
                        number: true
                    }
                },
                messages: {
                    txt_start_date: {
                        required: "Please Select Employee",
                    },
                    txt_end_date: {
                        required: "Pelase Enter Customer Name",
                    },
                    service_value:{
                        required: "Pelase Enter service value",
                        
                    }
                },
                errorElement: 'div',
                errorPlacement: function (error, element) {
                    var placement = $(element).data('error');
                    if (placement) {
                        $(placement).append(error)
                    } else {
                        error.insertAfter(element);
                    }
                }
            });

        });            //**** */

                    $('.datepicker').datepicker({
                        format: 'yyyy-mm-dd',
                        autoclose: true,
                        todayHighlight: true
                    })

                    $('#employee_id').change(function () {
                        var eid = $(this).val();
                        if (eid) {
                            $.ajax({
                                type: "get",
                                url: "/activity/getcustomer",
                                data: {
                                    eid: eid
                                },
                                success: function (res)
                                {
                                    if (res)
                                    {
                                        $("#cust_id").empty();
                                        $("#cust_id").append('<option value="">Select Customer</option>');
                                        $.each(res, function (key, value) {
                                            $("#cust_id").append('<option value="' + value.id + '">' + value.customer_name + '</option>');
                                        });
                                    }
                                }
                            });
                        }
                    });

                    function RestrictCommaSemicolon(e) {
                        var theEvent = e || window.event;
                        var key = theEvent.keyCode || theEvent.which;
                        key = String.fromCharCode(key);
                        var regex = /[^,;]+$/;
                        if (!regex.test(key)) {
                            theEvent.returnValue = false;
                            if (theEvent.preventDefault) {
                                theEvent.preventDefault();
                            }
                        }
                    }
                </script>
@endsection

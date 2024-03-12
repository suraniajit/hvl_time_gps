@extends('app.layout')

{{-- page title --}}
@section('title','Customer Management | HVL')

@section('vendor-style')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection
@section('content')
    <div class="breadcrumb-holder">
        <div class="container-fluid">
            <ul class="breadcrumb">
{{--                <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>--}}
                <li class="breadcrumb-item active"><a href="{{route('customer.index')}}">Customer Management </a></li>
                <li class="breadcrumb-item ">Add Customer </li>
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
                                <h2 class="h3 display"> Add Customer</h2>
                                <p style="font-size: 12px;"><strong>Note:</strong> Comma is not allowed in any field.</p>
                            </div>
                        </div>

                    </header>
            <form action="{{route('customer.store')}}" id="formValidate" method="post">

                {{csrf_field()}}

                <div class="row">
                    <div class=" form-group col-sm-6 col-md-4">
                        <label class="shift_name">Employee <span class="text-danger">*</span></label>
                        <select name="employee_id[]" id="employee_id" class="form-control select" multiple  autocomplete="off" autofocus="off" data-error=".errorTxt55">
{{--                            <option value=""> Select Employee</option>--}}
                            @foreach($employees as $employee)
                                <option value="{{$employee->id}}">{{$employee->Name}}</option>
                            @endforeach
                        </select>
                        <div class="errorTxt55 text-danger"></div>
                    </div>

                    <div class=" form-group col-sm-6 col-md-4">
                        <label >Customer Code <span class="text-danger">*</span></label>
                        <input type="text" name="customer_code" class="form-control " onkeypress="return RestrictCommaSemicolon(event);" ondrop="return false;" onpaste="return false;" placeholder="Enter Customer Name" data-error=".errorTxt1" autocomplete="off" autofocus="off">
                        <div class="errorTxt1 text-danger"></div>
                    </div>

                    <div class=" form-group col-sm-6 col-md-4">
                        <label class="shift_name">Customer Name <span class="text-danger">*</span></label>
                        <input type="text" name="customer_name" class="form-control " onkeypress="return RestrictCommaSemicolon(event);" ondrop="return false;" onpaste="return false;" placeholder="Enter Customer Name" data-error=".errorTxt2" autocomplete="off" autofocus="off">
                        <div class="errorTxt2 text-danger"></div>
                    </div>

                    <div class=" form-group col-sm-6 col-md-4" >
                        <label class="shift_name">Customer Alias Name <span class="text-danger">*</span></label>
                        <input type="text" name="customer_alias" class="form-control " onkeypress="return RestrictCommaSemicolon(event);" ondrop="return false;" onpaste="return false;" placeholder="Enter Customer Alias" data-error=".errorTxt3" autocomplete="off" autofocus="off">
                        <div class="errorTxt3 text-danger"></div>
                    </div>

                    <div class=" form-group col-sm-6 col-md-4">
                        <label class="shift_name">Billing Address <span class="text-danger">*</span></label>
                        <input type="text" name="billing_address" class="form-control " onkeypress="return RestrictCommaSemicolon(event);" ondrop="return false;" onpaste="return false;" placeholder="Enter Billing Address" data-error=".errorTxt4" autocomplete="off" autofocus="off">
                        <div class="errorTxt4 text-danger"></div>
                    </div>

                    <div class=" form-group col-sm-6 col-md-4">
                        <label class="shift_name">Billing State <span class="text-danger">*</span></label>
                        <select name="billing_state" id="billing_state" class="form-control" autocomplete="off" autofocus="off" data-error=".errorTxt5" >
                            <option>Select State</option>
                            @foreach($states as $state)
                                <option value="{{$state->id}}">{{$state->state_name}}</option>
                            @endforeach
                        </select>
                        <div class="errorTxt5 text-danger"></div>
                    </div>
                    <div class=" form-group col-sm-6 col-md-4" >
                        <label class="shift_name">Billing City <span class="text-danger">*</span></label>
                        <select name="billing_city" id="billing_city" class="form-control" autocomplete="off" autofocus="off" data-error=".errorTxt29" >
                        <option>Select city</option>
                        <option value="Indore">Indore</option>
                        <option value="bhopal">bhopal</option>
                      
                        </select>
                        <div class="errorTxt29 text-danger"></div>
                    </div>
                    <div class=" form-group col-sm-6 col-md-4">
                        <label >Billing Pincode</label>
                        <input type="number" name="billing_pincode" class="form-control" placeholder="Enter Billing Pincode" data-error=".errorTxt30" autocomplete="off" autofocus="off">
                        <div class="errorTxt30 text-danger"></div>
                    </div>
                    
                    <div class=" form-group col-sm-6 col-md-4">
                        <label for="">Billing Location<span class="text-danger">*</span> </label>
                        <input type="text" value="{{old('billing_location')}}"  name="billing_location" class="form-control" id="billing_location" placeholder="Enter Billing Location" data-error=".errorTxtBillingLocation">
                        <div class="errorTxtBillingLocation text-danger"></div>
                    </div>
                    <div class=" form-group col-sm-6 col-md-4">
                        <label for="">Billing Latitude<span class="text-danger">*</span> </label>
                        <input type="text" value="{{old('billing_latitude')}}"  readonly name="billing_latitude" class="form-control" id="billing_latitude" placeholder="Latitude" data-error=".errorTxtBillingLatitude">
                        <div class="errorTxtBillingLatitude text-danger"></div>
                    </div>
                    <div class=" form-group col-sm-6 col-md-4">
                        <label for="">Billing Longitude<span class="text-danger">*</span> </label>
                        <input type="text" value="{{old('billing_longitude')}}" readonly name="billing_longitude" class="form-control" id="billing_longitude" placeholder="Longitude" data-error=".errorTxtBillingLongitude">
                        <div class="errorTxtBillingLongitude text-danger"></div>
                    
                    </div>
                    
                    <div class=" form-group col-sm-6 col-md-4">
                        <label class="shift_name">Contact Person <span class="text-danger">*</span></label>
                        <input type="text" name="contact_person" class="form-control " onkeypress="return RestrictCommaSemicolon(event);" ondrop="return false;" onpaste="return false;" placeholder="Enter Contact Person" data-error=".errorTxt6" autocomplete="off" autofocus="off">
                        <div class="errorTxt6 text-danger"></div>
                    </div>

                    <div class=" form-group col-sm-6 col-md-4">
                        <label for="">Contact Person Phone <span class="text-danger">*</span></label>
                        <input type="number" name="contact_person_phone" class="form-control" placeholder="Enter Contact Person Phone" data-error=".errorTxt7" autocomplete="off" autofocus="off">
                        <div class="errorTxt7 text-danger"></div>
                    </div>

                    <div class=" form-group col-sm-6 col-md-4">
                        <label for="">Billing Email </label>
                        <input type="email"  name="billing_mail" class="form-control " onkeypress="return RestrictCommaSemicolon(event);" ondrop="return false;" onpaste="return false;" placeholder="Enter Billing Email" data-error=".errorTxt8" autocomplete="off" autofocus="off" onchange="return TimeCalculation();">
                        <div class="errorTxt8 text-danger"></div>
                    </div>

                    <div class=" form-group col-sm-6 col-md-4" >
                        <label class="shift_name">Billing Mobile <span class="text-danger">*</span></label>
                        <input type="number" name="billing_mobile" class="form-control" placeholder="Enter Billing Mobile" autocomplete="off" autofocus="off" data-error=".errorTxt9">
                        <div class="errorTxt9 text-danger"></div>
                    </div>
                    
                    <div class=" form-group col-sm-6 col-md-4" >
                        <label class="shift_name">Operator</label>
                        <input type="text" name="operator" class="form-control" placeholder="Enter Operator" autocomplete="off" autofocus="off" data-error=".errorOperator">
                        <div class="errorOperator text-danger"></div>
                    </div>
                    <div class=" form-group col-sm-6 col-md-4">
                        <label class="shift_name">Operation Executive</label>
                        <select name="operation_executive" class="form-control" autocomplete="off" autofocus="off" data-error=".errorOperationExecutive">
                            <option value=""> Select Operation Executive</option>
                            @foreach($employees as $employee)
                                <option value="{{$employee->Name}}">{{$employee->Name}}</option>
                            @endforeach
                        </select>
                        <div class="errorOperationExecutive text-danger"></div>
                    </div>
                    
                    <div class=" form-group col-sm-6 col-md-4">
                        <label class="shift_name">Sales Person <span class="text-danger">*</span></label>
                        <select name="sales_person" id="sales_person_id" class="form-control" autocomplete="off" autofocus="off" data-error=".errorTxt10">
                            <option value=""> Select Sales Person</option>
                            @foreach($employees as $employee)
                                <option value="{{$employee->Name}}">{{$employee->Name}}</option>
                            @endforeach
                        </select>
                        <div class="errorTxt10 text-danger"></div>
                    </div>
                    <div class=" form-group col-sm-6 col-md-4">
                        <label class="shift_name">Reference </label>
                        <select name="reference" class="form-control" id="reference_id" autocomplete="off" autofocus="off" data-error=".errorTxt22">
                            <option value=""> Select  Person</option>
                            @foreach($employees as $employee)
                                <option value="{{$employee->Name}}">{{$employee->Name}}</option>
                            @endforeach
                        </select>
                        <div class=""></div>
                    </div>

{{--                    <div class=" form-group col-sm-6 col-md-4">--}}
{{--                        <label class="shift_name">Status<span class="text-danger">*</span></label>--}}
{{--                        <input type="text" name="status" class="form-control" placeholder="Enter Status" data-error=".errorTxt11" autocomplete="off" autofocus="off">--}}
{{--                        <div class="errorTxt11 text-danger"></div>--}}
{{--                    </div>--}}
                    <div class=" form-group col-sm-6 col-md-4">
                        <label for="">Create Date <span class="text-danger">*</span></label>
                        <input type="text" class="datepicker form-control"  name="create_date" placeholder="Enter Create Date" data-error=".errorTxt12" autocomplete="off" autofocus="off">
                        <div class="errorTxt12 text-danger"></div>
                    </div>

                    <div class=" form-group col-sm-6 col-md-4">
                        <label class="shift_name">Shipping Address <span class="text-danger">*</span></label>
                        <input type="text" name="shipping_adress" class="form-control " onkeypress="return RestrictCommaSemicolon(event);" ondrop="return false;" onpaste="return false;"  placeholder="Enter Shipping Address" autocomplete="off" autofocus="off" data-error=".errorTxt13">
                        <div class="errorTxt13 text-danger"></div>
                    </div>

                    <div class=" form-group col-sm-6 col-md-4" >
                        <label class="shift_name">Shipping State <span class="text-danger">*</span></label>
                        <select name="shipping_state" id="shipping_state" class="form-control" autocomplete="off" autofocus="off" data-error=".errorTxt14" >
                            <option>Select State</option>
                            @foreach($states as $state)
                                <option value="{{$state->id}}">{{$state->state_name}}</option>
                            @endforeach
                        </select>
                        <div class="errorTxt14 text-danger"></div>
                    </div>
                    <div class=" form-group col-sm-6 col-md-4" >
                        <label class="shift_name">Shipping City <span class="text-danger">*</span></label>
                        <select name="shipping_city" id="shipping_city" class="form-control" autocomplete="off" autofocus="off" data-error=".errorTxt27" >

                        </select>
                        <div class="errorTxt27 text-danger"></div>
                    </div>
                    <div class=" form-group col-sm-6 col-md-4">
                        <label class="shift_name">Shipping Pincode</label>
                        <input type="number" name="shipping_pincode" class="form-control" placeholder="Enter Shipping Pincode" data-error=".errorTxt28" autocomplete="off" autofocus="off">
                        <div class="errorTxt28 text-danger"></div>
                    </div>
                    <div class=" form-group col-sm-6 col-md-4">
                        <label class="shift_name">Credit Limit </label>
                        <input type="text" name="credit_limit" class="form-control" onkeypress="return RestrictCommaSemicolon(event);" ondrop="return false;" onpaste="return false;" placeholder="Enter Credit Limit comma" data-error=".errorTxt16" autocomplete="off" autofocus="off">
                        <div class="errorTxt16 text-danger"></div>
                    </div>

                    <div class=" form-group col-sm-6 col-md-4" >
                        <label class="shift_name">Gst Registration Type <span class="text-danger">*</span></label>
                        <select name="gst_reges_type" id="reges_type" class="form-control" data-error=".errorTxt17" autocomplete="off" autofocus="off">
                            <option value="">Select Type</option>
                            <option value="Yes">Yes</option>
                            <option value="No">No</option>
                        </select>
                        <div class="errorTxt17 text-danger"></div>
                    </div>

                     <div class=" form-group col-sm-6 col-md-4" id="gst_in" style="display: none;">
                        <label class="shift_name">GSTIN <span class="text-danger">*</span></label>
                        <input type="text" name="gstin" class="form-control" placeholder="Enter GSTIN Number" data-error=".errorTxt18" autocomplete="off" autofocus="off">
                        <div class="errorTxt18 text-danger"></div>
                    </div>

                    <div class=" form-group col-sm-6 col-md-4" >
                        <label class="shift_name">Branch <span class="text-danger">*</span></label>
                        <select name="branch" id="" class="form-control" data-error=".errorTxt19" autocomplete="off" autofocus="off">
                            <option value=""> Select Branch</option>
                            @foreach($branchs as $branch)
                                <option value="{{$branch->id}}">{{$branch->Name}}</option>
                            @endforeach
                        </select>
                        <div class="errorTxt19 text-danger"></div>
                    </div>

                    <div class=" form-group col-sm-6 col-md-4">
                        <label class="shift_name">Payment Mode </label>
                        <select name="payment_mode" id="" class="form-control" data-error=".errorTxt20" autocomplete="off" autofocus="off">
                            <option value="">Select Type</option>
                            <option value="Cash">Cash</option>
                            <option value="Online">Online</option>
                        </select>
                        <div class="errorTxt20 text-danger"></div>
                    </div>
                    <div class=" form-group col-sm-6 col-md-4">
                        <label class="shift_name">Contract Start Date  <span class="text-danger">*</span> </label>
                        <input type="text" name="con_start_date" class="form-control datepicker" placeholder="Select Contract Start Date" data-error=".errorTxt22" autocomplete="off" autofocus="off">
                        <div class="errorTxt22 text-danger"></div>
                    </div>
                    <div class=" form-group col-sm-6 col-md-4">
                        <label class="shift_name">Contract End Date  <span class="text-danger">*</span> </label>
                        <input type="text" name="con_end_date" class="form-control datepicker" placeholder="Select Contract End Date" data-error=".errorTxt23" autocomplete="off" autofocus="off">
                        <div class="errorTxt23 text-danger"></div>
                    </div>
                    <div class=" form-group col-sm-6 col-md-4">
                        <label class="shift_name">Value <span class="text-danger">*</span> </label>
                        <input type="number" name="cust_value" class="form-control" placeholder="Enter Value" data-error=".errorTxt31" autocomplete="off" autofocus="off">
                        <div class="errorTxt31 text-danger"></div>
                    </div>
                    <div class=" form-group col-sm-6 col-md-4">
                        <label class="shift_name">Status <span class="text-danger">*</span></label>
                        <select name="is_active" class="form-control" autocomplete="off" autofocus="off" data-error=".errorTxt21">
                            <option value="">Select Status</option>
                            <option value="0">Active</option>
                            <option value="1">InActive</option>
                        </select>
                        <div class="errorTxt21 text-danger"></div>
                    </div>

                </div>

                <div class="row mt-4 pull-right">
                    <div class="col-sm-12 ">
                        <button class="btn btn-primary mr-2" type="submit" name="action">
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


{{-- page scripts --}}
@section('page-script')
    <!-- for billing latlang -->
    <script src="https://maps.googleapis.com/maps/api/js?key={{env('GOOGLE_MAP_KEY')}}&callback=initAutocomplete&libraries=places&v=weekly" defer ></script>
    <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
    <script>
        let autocomplete;
        let address1Field;
        function initAutocomplete() {
        address1Field = document.querySelector("#billing_location");
        autocomplete = new google.maps.places.Autocomplete(address1Field, {
            componentRestrictions: { country: ["in"] },
            fields: ["ALL"],
            // types: ["atm","airport","amusement_park","aquarium","art_gallery","art_gallery"],
        });
        address1Field.focus();
        autocomplete.addListener("place_changed", fillInAddress);
        }

    function fillInAddress() {
        const place = autocomplete.getPlace();
        $('#billing_latitude').val(place.geometry.location.lat());
        $('#billing_longitude').val(place.geometry.location.lng());
    }
    window.initAutocomplete = initAutocomplete;
</script>


    <!--end billing-->





    <script src="{{asset('js/hvl/customermaster/create.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function () {
             $("#sales_person_id").select2();
              $("#reference_id").select2();
            $('.select').multiselect({
                includeSelectAllOption: true,
                enableFiltering: true,
                maxHeight: 450
            });

            $('.datepicker').datepicker({
                format: 'yyyy-mm-dd',
                autoclose: true,
                todayHighlight: true
            });

            $('#reges_type').change(function(){
                if($('#reges_type').val() == 'Yes') {
                    $('#gst_in').show();
                } else {
                    $('#gst_in').hide();
                }
            });
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
        
        // update
        $('#billing_state').change(function () {
    var sid = $(this).val();
    if (sid) {
        $.ajax({
            type: "get",
            url: "/city/getCity",
            data: {
                state_id: sid
            },
            success: function (res)
            {
                if (res)
                {
                    $("#billing_city").empty();
                    $("#billing_city").append('<option value="">Select Billing City</option>');
                    $.each(res, function (key, value) {
                        $("#billing_city").append('<option value="' + value.id + '">' + value.city_name + '</option>');
                    });
                    $('select').formSelect();
                }
            }
        });
    }
});
$('#shipping_state').change(function () {
    var sid = $(this).val();
    if (sid) {
        $.ajax({
            type: "get",
            url: "/city/getCity",
            data: {
                state_id: sid
            },
            success: function (res)
            {
                if (res)
                {
                    $("#shipping_city").empty();
                    $("#shipping_city").append('<option value="">Select Shipping City</option>');
                    $.each(res, function (key, value) {
                        $("#shipping_city").append('<option value="' + value.id + '">' + value.city_name + '</option>');
                    });
                    $('select').formSelect();
                }
            }
        });
    }
});


        
    </script>

@endsection

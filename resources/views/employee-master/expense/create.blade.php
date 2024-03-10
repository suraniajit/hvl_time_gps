@extends('app.layout')

{{-- page title --}}
@section('title','Expense Management | HVL')

@section('vendor-style')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>


<style>
    .error{
        text-transform: capitalize;
        position: relative;
        top: 0rem;
        left: 0rem;
        font-size: 0.8rem;
        color: red;
        transform: translateY(0%);
    }
</style>
@endsection


@section('content')
<div class="breadcrumb-holder">
    <div class="container-fluid">
        <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
            <li class="breadcrumb-item active"><a href="{{route('expense')}}">Expense Master</a></li>
            <li class="breadcrumb-item ">Add Expense</li>
        </ul>
    </div>
</div>

<div class="container-fluid">
    <div class="card">
        <div class="card-body p-4">
            <header>
                <div class="row">
                    <div class="col-md-7">
                        <h2 class="h3 display">Create Expense</h2>
                    </div>
                </div>
            </header>
            <form action="{{route('expense.store')}}" method="post" enctype="multipart/form-data" onsubmit="return(submitFrm());">
                {{csrf_field()}}

                <div class="row" style="text-align: end;">
                    <div class="col s12 display-flex justify-content-end form-action">

                        <?php if ($combined_submission == '2') { ?>
                            <button class="btn btn-primary mr-2" id="button_d" type="submit" name="is_save" value="2" >Save as Draft
                                <i class="fa fa-save"></i>
                            </button>
                        <?php } ?>
                        <button class="btn btn-primary mr-2" id="button_s" type="submit" name="is_save" value="1" >Submit 
                            <i class="fa fa-save"></i>
                        </button>

                        <button type="reset" class="btn btn-secondary  mb-1">
                            <i class="fa fa-arrow-circle-left"></i>
                            <a href="{{url()->previous()}}" class="text-white">Cancel</a>
                        </button>                 
                    </div>
                </div>
                <div class="row">

                    <div class="col-md-8">
                        <?php if (Auth::id() == '122') { ?>


                            <h4 class="card-title">Admin Expense Action</h4>
                            <div class="row">
                                <div class="form-group col-sm-6 col-md-3">
                                    <label>Employee Name* </label>
                                    <select name="employee_id" class="employee_id  form-control select">
                                        <option disabled="" value="0">Employee Name</option>
                                        @foreach($employee_master as $employee)
                                        <option value="{{$employee->user_id}}" >{{$employee->Name}}</option>
                                        @endforeach
                                    </select>
                                    <div class="employee_id_error"></div>
                                </div>
                                <div class="form-group col-sm-6 col-md-3">
                                    <label>Payment Status </label>
                                    <select name="payment_status_id" id="payment_status_id" class="payment_status_id form-control select">
                                        <option disabled="" value="0">Payment Status</option>
                                        @foreach($payment_status_master as $payment_status)
                                        <option value="{{$payment_status->id}}" {{$payment_status->id == '1' ? 'selected' : ''}}>{{$payment_status->name}}</option>
                                        @endforeach
                                    </select>
                                    <div class="payment_status_id_error"></div>
                                </div>


                            </div>
                        <?php } ?>

                        <div class="row">
                            <div class="form-group col-sm-6 col-md-3">
                                <label> Expense Type* </label>
                                <select name="expense_type" data-error=".errorTxt1" class="expense_type form-control select" onchange="expance_type();">
                                    <option disabled=""  value="999">Expense Type</option>
                                    <option value="0" data-id="0" selected="">Cash </option>
                                    <!--<option value="1" data-id="1">Mileage </option>-->
                                </select>
                                <div class="expense_type_error"></div>
                            </div>
                            <div class="input-field  form-group col-sm-6 col-md-4">
                                <label>Payment Method* </label>
                                <select name="payment_method_id" id="payment_method_id" class="payment_method_id form-control select" data-error=".errorTxt15">
                                    <option  disabled=""  value="0">Payment Method*</option>
                                    @foreach($payment_method_master as $payment)
                                    <option value="{{$payment->id}}">{{$payment->name}}</option>
                                    @endforeach
                                </select>
                                <div class="payment_method_id_error"></div>
                            </div>

                            <div class="form-group col-sm-6 col-md-3">
                                <label>Status </label>
                                <select name="is_active" class="is_active form-control select">
                                    <option disabled="" value="999"> Status</option>
                                    <option value="0" selected="">Active</option>
                                    <option value="1">Inactive</option>
                                </select>
                                <div class="is_active_error"></div>
                            </div>


                            <?php if (Auth::id() == '1395') { ?>
                                <div class="form-group col-sm-6 col-md-4">
                                    <label>Update On combination* </label>

                                    <?php
                                    $combinations_list = DB::table('api_expenses')
                                            ->select('api_expenses.*')
                                            ->where('is_process', '!=', '3')
                                            ->where('is_save', '!=', '2')
                                            ->where('is_user', '=', Auth::id())
                                            ->get();
                                    ?>
                                    <select name="txt_combination_name" id="txt_combination_name" class="form-control select" >
                                        <option selected="" value="0">Report Name</option>
                                        @foreach($combinations_list as $combinations_)
                                        <option value="{{$combinations_->combination_name}}">{{$combinations_->combination_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            <?php } ?>

                        </div>
                        <div class="row">
                            <!--include('employee-master.expense._cashFlow')-->
                            <!--====_cashFlow=========================================================================================================================================================-->
                            <div class="card-content cash_flow">
                                <h4 class="card-title">Cash Flow</h4>
                                <div class="row">
                                    <div class="form-group col-sm-6 col-md-4">
                                        <label>Currency </label>
                                        <input type="text" placeholder="currency" class="form-control" value="INR" disabled="">
                                    </div>
                                    <div class="form-group col-sm-6 col-md-4">
                                        <label>Amount* </label>
                                        <input type="number" class="form-control"  required="" oninput="this.value = !!this.value && Math.abs(this.value) >= 0 ? Math.abs(this.value) : null" name="total_amount_cash" class="total_amount_cash form-control" placeholder="Enter Amount" >
                                        <div class="total_amount_cash_error"></div>
                                    </div>
                                    <div class="form-group col-sm-6 col-md-4">
                                        <label>Spent at*</label>
                                        <input type="text" name="spent_at_cash" class="form-control spent_at_cash" placeholder="ie:Mettro">
                                        <div class="spent_at_cash_error"></div>
                                    </div>
                                    <div class="form-group col-sm-6 col-md-4">
                                        <label>Date of Expense* </label>
                                        <input type="text" class="form-control datepicker date_of_expense" name="date_of_expense_cash" placeholder="Select Date of Expense">
                                        <div class="date_of_expense_cash_error"></div>

                                    </div>
                                    <div class="form-group col-sm-6 col-md-4">
                                        <label>Time of Expense </label>
                                        <input type="text" name="date_of_expense_time" class="date_of_expense_time form-control timepicker" data-time-format="H:i" placeholder="Select Time of Expense">
                                        <!--<div class="date_of_expense_time_error"></div>-->
                                    </div>
                                    <div class="form-group col-sm-6 col-md-4">
                                        <label>City Name* </label>
                                        <input type="text"  name="city_id_cash" class="city_id_cash form-control" placeholder="Enter City Name" >
                                        <div class="city_id_cash_error"></div>
                                    </div>
                                </div>
                                <div class="row">


                                    <div class="form-group col-sm-6 col-md-4">
                                        <label>Account / Premises No</label>
                                        <input type="text"  name="account_premises_no_cash" class="form-control account_premises_no_cash" placeholder="Enter Account / Premises No">
                                        <!--<div class="account_premises_no_cash_error"></div>-->
                                    </div>
                                    <div class="form-group col-sm-6 col-md-4">
                                        <label>Card Used</label>
                                        <input type="text" name="card_used_cash" class="card_used_cash form-control" placeholder="Enter Card Used">
                                        <!--<div class="card_used_cash_error"></div>-->
                                    </div>
                                    <div class="form-group col-sm-6 col-md-4">
                                        <label>Account Name </label>
                                        <input type="text"  name="account_name_cash"  class="form-control account_name_cash" placeholder="Enter Account Name">
                                        <!--<div class="account_name_cash_error"></div>-->
                                    </div>
                                </div>
                                <div class="row">

                                    <div class="form-group col-sm-6 col-md-4">
                                        <label>Department* </label>
                                        <select name="ddl_department_cash" id="ddl_department" class="ddl_department_cash form-control select" >
                                            <option disabled="" selected="" value="0">Department</option>
                                            @foreach($departments_master as $department)
                                            <option value="{{$department->id}}">{{$department->Name}}</option>
                                            @endforeach
                                        </select>
                                        <div class="ddl_department_cash_error"></div>
                                    </div>
                                    <div class="input-field form-group col-sm-6 col-md-4">
                                        <label>Category</label>
                                        <select name="category_id_cash" id="category_id_cash" class="category_id_cash form-control select">
                                            <option disabled="" selected="" value="0">Category</option>
                                            @foreach($category_master as $category)
                                            <option value="{{$category->id}}">{{$category->name}}</option>
                                            @endforeach
                                        </select>
                                        <div class="category_id_cash_error"></div>
                                    </div>
                                    <div class="input-field form-group col-sm-6 col-md-4">
                                        <label for="">Sub Category </label>
                                        <select name="sub_category_id_cash" id="sub_category_id_cash" class="sub_category_id_cash form-control select">
                                            <option value="0" selected=""> Sub Category</option>
                                        </select>
                                        <div class="sub_category_id_cash_error"></div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-sm-6 col-md-4">
                                        <label>Description *</label>
                                        <textarea name="description_cash" class="description_cash materialize-textarea form-control" data-length="50" ></textarea>
                                        <div class="description_cash_error"></div>
                                    </div>
                                    <div class="form-group col-sm-6 col-md-4">
                                        <label>Property Address </label>
                                        <textarea name="property_address_cash" class="property_address_cash materialize-textarea form-control" data-length="50" ></textarea>
                                        <!--<div class="errorTxt3"></div>-->
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6 col-md-4" style="margin-top: 35px;">
                                        <input type="checkbox" name="expance_multi_day" class="expance_multi_day"/>
                                        Is Multi Day Expense
                                    </div>
                                    <div class="form-group col-sm-6 col-md-4 multi_day_div">
                                        <label>From Date</label>
                                        <input type="text" name="multi_day_from_date_cash" class="multi_day_from_date form-control datepicker" placeholder="YYYY-MM-DD">
                                        <div class="multi_day_from_date_error"></div>
                                    </div>
                                    <div class="form-group col-sm-6 col-md-4 multi_day_div">
                                        <label>To Date </label>
                                        <input type="text" name="multi_day_to_date_cash" class="multi_day_to_date form-control datepicker" placeholder="YYYY-MM-DD" >
                                        <div class="multi_day_to_date_error"></div>
                                    </div>

                                </div>
                            </div>
                            <!--=============================================================================================================================================================-->
                            <!--include('employee-master.expense._mileageFlow')-->
                            <!--====_mileageFlow=========================================================================================================================================================-->
                            <div class="card-content mailage_flow" style="display: none;">
                                <h4 class="card-title">Mileage Flow</h4>
                                <div class="row">
                                    <div class="form-group col-sm-6 col-md-4">
                                        <label>Currency * </label>
                                        <input type="text" value="INR" disabled="" class="form-control">
                                        <!--<div class="errorTxt3"></div>-->
                                    </div>
                                    <div class="form-group col-sm-6 col-md-4">
                                        <select name="vehicle_type_mile" id="vehicle_type_mile" class="txtCal vehicle_type_mile form-control select" data-error=".errorTxt20" onchange="calculation();">
                                            <option disabled="" selected="" value="0">Type of Vehicle*</option>
                                            @foreach($vehicles_master as $vehicles)
                                            <option value="{{$vehicles->id}}">{{$vehicles->name}}</option>
                                            @endforeach
                                        </select>
                                        <label>Type of Vehicle* </label>
                                        <div class="vehicle_type_mile_error"></div>
                                    </div>
                                    <div class="form-group col-sm-6 col-md-3">
                                        <label for="">Rate Per Km</label>
                                        <input readonly="" type="number" oninput="this.value = !!this.value && Math.abs(this.value) >= 0 ? Math.abs(this.value) : null" name="vehicle_rate_mile" class="vehicle_rate_mile txtCal form-control" placeholder="Enter Rat Per km." onchange="calculation();" min="0" >
                                    </div>
                                    <div class="form-group col-sm-6 col-md-3">
                                        <label>Distance* </label>
                                        <input type="number" name="distance_mile" oninput="this.value = !!this.value && Math.abs(this.value) >= 0 ? Math.abs(this.value) : null" class="distance_mile txtCal form-control"  placeholder="Enter Distance" onchange="calculation();">
                                        <div class="distance_mile_error"></div>
                                    </div>
                                </div>
                                <div class="row">

                                    <div class="form-group col-sm-6 col-md-4">
                                        <label>Spent at</label>
                                        <input type="text" name="spent_at_mile" class="spent_at_mile form-control" placeholder="ie:Mettro">
                                        <div class="spent_at_mile_error"></div>
                                    </div>
                                    <div class="form-group col-sm-6 col-md-4">
                                        <label>Date of Expense* </label>
                                        <input type="text" name="date_of_expense_mile" class="date_of_expense date_of_expense_mile form-control" placeholder="Select Date of Expense" data-error=".errorTxt24">
                                        <div class="date_of_expense_error"></div>
                                    </div>
                                    <div class="form-group col-sm-6 col-md-4">
                                        <label>Time of Expense* </label>
                                        <input type="text" name="date_of_expense_time_mile" class="date_of_expense_time form-control"  placeholder="Select Time of Expense">
                                        <div class="date_of_expense_time_mile_error"></div>
                                    </div>
                                    <div class="form-group col-sm-6 col-md-4">
                                        <label>City Name</label>
                                        <input type="text" name="city_name_mile" class="city_name_mile form-control" placeholder="City Name" >
                                        <div class="city_name_mile_error"></div>
                                    </div>
                                    <div class="form-group col-sm-6 col-md-4">
                                        <label>Total Amount(<i>Amount = Rate per Km * Distance</i>) </label>
                                        <input type="text" readonly="" name="total_amount_mile" placeholder="Total Amount" class="total_amount_mile form-control" id="total_amount_mile">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="input-field  form-group col-sm-6 col-md-4">
                                        <select name="category_id_mile" id="category_id_mile" class="category_id_mile form-control select" data-error=".errorTxt27">
                                            <option value="0" selected disabled="">Category</option>
                                            @foreach($category_master as $category)
                                            <option value="{{$category->id}}">{{$category->name}}</option>
                                            @endforeach
                                        </select>
                                        <label>Category</label>
                                        <div class="category_id_mile_error"></div>
                                    </div>
                                    <div class="form-group col-sm-6 col-md-3">
                                        <select name="subcategory_id_mile" id="subcategory_id_mile" class="subcategory_id_mile form-control select" >
                                            <option value="0" disabled="" selected=""> Sub Category</option>
                                        </select>
                                        <label for="">Sub Category</label>
                                        <div class="subcategory_id_mile_error"></div>
                                    </div>

                                    <div class="form-group col-sm-6 col-md-4">
                                        <label>Description </label>
                                        <textarea id="description_mile" class="materialize-textarea form-control" data-length="50" name="description_mile"></textarea>
                                        <!--<div class="errorTxt3"></div>-->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--====_mileageFlow=========================================================================================================================================================-->
                    </div>


                    <div class="col-md-4">
                        <div id="file-upload" class="section" style="margin-top: 100px;">
                            <div class="section" style="text-align: center;">

                                <h4 class="card-title">
                                    Upload Bills / Documents
                                </h4>
                                <input type="file" 
                                       name="expense_type_document[]" 
                                       id="input-file-max-fs" 
                                       maxlength="5" 
                                       class="input-file-max-fs dropify expense_type_document" 
                                       data-max-file-size="15M" 
                                       accept="jpeg|jpg|png|pdf|doc|xls|ppt|docx|xlsx|pptx|tif|bmp|eml|msg"
                                       maxlength="3"
                                       data-maxfile="1024"
                                       multiple />
                                <p style="font-size: 10px;color: red;">
                                    Allow to upload Bills/Documents  (* File size - 15 MB/file; max upload - 5 files<br>
                                    File types - .jpg, .jpeg, .png, .pdf, .doc, .xls, .ppt, .docx, .xlsx, .pptx, .tif, .bmp, .eml, .msg)
                                    </span>
                            </div>
                            <div class="file_upload_error"></div>
                        </div>
                    </div>
                </div>
                <br>
                <div class="row" style="text-align: end;display: none;">
                    <div class="col s12 display-flex justify-content-end form-action">
                        <?php if ($combined_submission == '2') { ?>
                            <button class="btn btn-primary mr-2" type="submit" name="is_save" value="2" >Save as Draft
                                <i class="fa fa-save"></i>
                            </button>
                        <?php } ?>
                        <button class="btn btn-primary mr-2" type="submit" name="is_save" value="1" >Submit 
                            <i class="fa fa-save"></i>
                        </button>

                        <button type="reset" class="btn btn-secondary  mb-1">
                            <i class="fa fa-arrow-circle-left"></i>
                            <a href="{{url()->previous()}}" class="text-white">Cancel</a>
                        </button>            
                    </div>
                </div>
                <br>
            </form>
        </div>
    </div>
</div>

</section>
@endsection



{{-- page scripts --}}
@section('page-script')
<script src="{{asset('js/scripts/form-file-uploads.js')}}"></script>
<script src="{{asset('vendors/dropify/js/dropify.min.js')}}"></script>

@include('employee-master.expense.cjs')
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">
<script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>
<script>
                                            // capturing the button using its id
                                            const button_d = document.getElementById("button_d");
                                            const button_s = document.getElementById("button_s");

                                            // function to disable the button
                                            const disableButton = () => {
                                                button_s.disabled = true;
                                            };
                                            const disableButton = () => {
                                                button_d.disabled = true;
                                            };

                                            // calling the disableButton() function when the click event happens
                                            button_s.addEventListener("click", disableButton);
                                            button_d.addEventListener("click", disableButton);
</script>
<script type="text/javascript">
    function expance_type() {
        $(".mailage_flow").hide();
        let flow = $(".expense_type option:selected").val();
        if (flow == 0) {
            blank();
            $(".cash_flow").show();
            $(".mailage_flow").hide();
        } else if (flow == 1) {
            blank();
            $(".cash_flow").hide();
            $(".mailage_flow").show();
        }
//                            alert($(".expense_type option:selected").val());
    }
    function submitFrm() {
$("#load").css({"visibility": ""});

        console.log('call');
        $(".expense_type_error").html('');
        $(".payment_method_id_error").html('');
        $(".is_active_error").html('');
        $(".total_amount_cash_error").html('');
        $(".spent_at_cash_error").html('');
        $(".description_cash_error").html('');
        var total_amount_cash = $('.total_amount_cash').val();
        var spent_at_cash = $('.spent_at_cash').val();
        var date_of_expense = $('.date_of_expense').val();
        var city_id_cash = $('.city_id_cash').val();
        var description_cash = $('.description_cash').val();

        $(".error").remove();
        //                                e.preventDefault();
        let flow = $(".expense_type option:selected").val();
        if (flow == '0') {

            if (($('.total_amount_cash').val() == '') || ($('.total_amount_cash').val() == '0')) {
                $('.total_amount_cash_error').html("<span class='error'>Enter Total Amount</span>");
                $("#load").css({"visibility": "hidden"});
                return false;
            }
            if ($('.date_of_expense').val() == 0) {
                $('.date_of_expense_cash_error').html("<span class='error'>Select Date Of Expense</span>");
                $("#load").css({"visibility": "hidden"});
                return false;
            }
//                                                    if ($('.date_of_expense_time').val() == 0) {
//                                                        $('.date_of_expense_time_error').html("<span class='error'>Select Time Of Expense</span>");
//                                                        return false;
//                                                    }
            if ($('.spent_at_cash').val().length < 1) {
                $('.spent_at_cash_error').html("<span class='error'>Enter Spent Name</span>");
                $("#load").css({"visibility": "hidden"});
                return false;
            }

            if ($('.description_cash').val().length < 1) {
                $('.description_cash_error').html("<span class='error'>Enter Description </span>");
                $("#load").css({"visibility": "hidden"});
                return false;
            }

            if ($('.city_id_cash').val().length < 1) {
                $('.city_id_cash_error').html("<span class='error'>Enter City Name</span>");
                $("#load").css({"visibility": "hidden"});
                return false;
            }
//                                                    if ($('.account_premises_no_cash').val().length < 1) {
//                                                        $('.account_premises_no_cash_error').html("<span class='error'>Enter Account/Premise No</span>");
//                                                        return false;
//                                                    }
//                                                    if ($('.card_used_cash').val().length < 1) {
//                                                        $('.card_used_cash_error').html("<span class='error'>Enter Card Used</span>");
//                                                        return false;
//                                                    }
//                                                    if ($('.account_name_cash').val().length < 1) {
//                                                        $('.account_name_cash_error').html("<span class='error'>Enter Account Name</span>");
//                                                        return false;
//                                                    }
            if ($(".ddl_department_cash option:selected").val() == '0') {
                $(".ddl_department_cash_error").html("<span class='error'>Select Department</span>");
                $("#load").css({"visibility": "hidden"});
                return false;
            }
            //                                if ($(".category_id_cash option:selected").val() == '0') {
            //                                    $(".category_id_cash_error").html("<span class='error'>Select Category</span>");
            //                                    return false;
            //                                }
            //                                if ($(".sub_category_id_cash option:selected").val() == '0') {
            //                                    $(".sub_category_id_cash_error").html("<span class='error'>Select Sub Category</span>");
            //                                    return false;
            //                                }
            //                                if ($(".payment_status_id_cash option:selected").val() == '0') {
            //                                    $(".payment_status_id_cash_error").html("<span class='error'>Select Payment Status</span>");
            //                                    return false;
            //                                }
            if ($('.expance_multi_day').is(':checked')) {

                if ($('.multi_day_from_date').val() == 0) {
                    $('.multi_day_from_date_error').html("<span class='error'>Select Start Date Of Expense</span>");
                    return false;
                }
                if ($('.multi_day_to_date').val() == 0) {
                    $('.multi_day_to_date_error').html("<span class='error'>Select End Date Of Expense</span>");
                    return false;
                }
            } else {
                $('.multi_day_from_date_error').html('');
                $('.multi_day_to_date_error').html('');
                return true;
            }
            //                                if ($(".payment_method_id option:selected").val() == '0') {
            //                                    $(".payment_method_id_error").html("<span class='error'>Select Payment Method</span>");
            //                                    return false;
            //                                }
            if ($(".is_active option:selected").val() == '999') {
                $(".is_active_error").html("<span class='error'>Select Status</span>");
                return false;
            }
            
            return true;
            console.log('it is cash flow');
        } else if (flow == '1') {
            if ($(".vehicle_type_mile option:selected").val() == '0') {
                $(".vehicle_type_mile_error").html("<span class='error'>select Vehicle Type</span>");
                return false;
            }
            if (($('.distance_mile').val() == '') || ($('.distance_mile').val() == '0') || ($('.distance_mile').val() < 0)) {
                $('.distance_mile_error').html("<span class='error'>Enter Distance</span>");
                return false;
            }
            if ($('.distance_mile').val().length > 1) {
                $('.distance_mile_error').html("<span class='error'>Amount should be more than 0</span>");
                return false;
            }
            //                                if ($('.spent_at_mile').val().length < 1) {
            //                                    $('.spent_at_mile_error').html("<span class='error'>Enter Spent At</span>");
            //                                    return false;
            //                                }
            if ($('.date_of_expense_mile').val() == 0) {
                $('.date_of_expense_error').html("<span class='error'>Select Date Of Expense</span>");
                return false;
            }
            if ($('.date_of_expense_time_mile').val() == 0) {
                $('.date_of_expense_time_mile_error').html("<span class='error'>Select Time Of Expense</span>");
                return false;
            }
            //                                if ($('.city_name_mile').val().length < 1) {
            //                                    $('.city_name_mile_error').html("<span class='error'>Enter City Name</span>");
            //                                    return false;
            //                                }
            //                                if ($(".category_id_mile option:selected").val() == '0') {
            //                                    $(".category_id_mile_error").html("<span class='error'>Select Category</span>");
            //                                    return false;
            //                                }
            //                                if ($(".subcategory_id_mile option:selected").val() == '0') {
            //                                    $(".subcategory_id_mile_error").html("<span class='error'>Select Sub Category</span>");
            //                                    return false;
            //                                }
            //                                if ($(".payment_method_id option:selected").val() == '0') {
            //                                    $(".payment_method_id_error").html("<span class='error'>Select Payment Method</span>");
            //                                    return false;
            //                                }
            if ($(".is_active option:selected").val() == '999') {
                $(".is_active_error").html("<span class='error'>Select Status</span>");
                return false;
            }
            return true;
            console.log('it is mailage flow');
        } else {
            if ($(".expense_type option:selected").val() == '999') {
                $(".expense_type_error").html("<span class='error'>Select Expance Type</span>");
                return false;
            }
            if ($(".payment_method_id option:selected").val() == '0') {
                $(".payment_method_id_error").html("<span class='error'>Please payment_method_id_error#</span>");
                return false;
            }
            //                                if ($(".is_active option:selected").val() == '999') {
            //                                    $(".is_active_error").html("<span class='error'>Please is_active_error#</span>");
            //                                    return false;
            //                                }
            if ($(".employee_id option:selected").val() == '0') {
                $(".employee_id_error").html("<span class='error'>Select Employee</span>");
                return false;
            }
            if ($(".payment_status_id option:selected").val() == '999') {
                $(".payment_status_id_error").html("<span class='error'>Select Payment Status</span>");
                return false;
            }
            return true;
        }
    }
</script>
<script type="text/javascript">
    $(document).ready(function () {
        $('.datepicker').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            todayHighlight: true
        });
        $('.timepicker').timepicker({
            timeFormat: 'h:mm p',
            interval: 60,
            minTime: '10',
            maxTime: '6:00pm',
            defaultTime: '11',
            startTime: '10:00',
            dynamic: false,
            dropdown: true,
            scrollbar: true
        });
    });
</script>

@endsection
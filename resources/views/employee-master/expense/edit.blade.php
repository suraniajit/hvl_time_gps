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
            <li class="breadcrumb-item ">Edit Expense</li>
        </ul>
    </div>
</div>

<div class="container-fluid">
    <div class="card">
        <div class="card-body p-4">
            <header>
                <div class="row">
                    <div class="col-md-7">
                        <h2 class="h3 display">Edit Expense</h2>
                        <?php
                        if (($edit_details->is_process == 12)) {
                            echo "<span style='color: red;font-weight: 600'>Expenses are  Partially Approved  by the Account please correct and resubmit expense" . '<br>' . 'Settlement amount should not more  ' . $edit_details->reject_amount . "</span>";
                        } else if (($edit_details->is_save == 3)) {
                            echo "<span style='color: red;font-weight: 600'>Expenses are  Partially Approved  by the Account please correct and resubmit expense" . '<br>' . 'Settlement amount should not more  ' . $edit_details->reject_amount . "</span>";
                        } else if (($edit_details->is_process == 2)) {
                            echo "<span style='color: red;font-weight: 600'>Expenses are Rejected by the Manager please correct and resubmit expense</span>";
                        } else if (($edit_details->is_process == 4)) {
                            echo "<span style='color: red;font-weight: 600'>Expenses are Rejected by the Accountant please correct and resubmit expense</span>";
                        }
                        ?>
                    </div>
                </div>
            </header>
            <form id="formEditValidate" action="{{ route('expense.update', $edit_details->id) }}" method="POST" enctype="multipart/form-data" onsubmit="return(submitFrm());">
                {{csrf_field()}}
                <div class="row" style="text-align: end;">
                    <div class="col s12 display-flex justify-content-end form-action">

                        <?php
                        
                        if (($edit_details->is_process == 11) || ($edit_details->is_process == 2) || ($edit_details->is_process == 4) || ($edit_details->is_process == 4)) {
                            ?>
                            <button id="button_1" class="btn btn-primary mr-2" type="submit" name="is_save" value="3" >
                                <!--Resubmit Expance-->
                                Submit
                                <i class="fa fa-save"></i>
                            </button>
                        <?php } else if ($edit_details->is_save == 3) { ?>
                            <button id="button_2" class="btn btn-primary mr-2" type="submit" name="is_save" value="3" >
                                <!--Account Resubmit Expance-->
                                Submit
                                <i class="fa fa-save"></i>
                            </button>

                        <?php } else if ($edit_details->is_save == 2) { ?>

                            <button id="button_3" class="btn btn-primary mr-2" type="submit" name="is_save" value="2" >Submit 
                                <i class="fa fa-save"></i>
                            </button>
                        <?php }
                        ?>

                        <button type="reset" class="btn btn-secondary  mb-1">
                            <i class="fa fa-arrow-circle-left"></i>
                            <a href="{{url()->previous()}}" class="text-white">Cancel</a>
                        </button>  
                    </div>
                </div>

                <?php if (Auth::id() == '122') { ?>
                    <h4 class="card-title">
                        Admin Expense Action
                    </h4>
                    <div class="row">
                        <div class="form-group col-sm-6 col-md-3">
                            <label>Employee Name* </label>
                            <select name="employee_id" class="employee_id form-control select" disabled="">
                                <option disabled="" value="0">Employee Name</option>
                                @foreach($employee_master as $employee)
                                <option value="{{$employee->user_id}}" {{$employee->user_id == $edit_details->is_user ? 'selected' : ''}}>{{$employee->Name}}</option>
                                @endforeach
                            </select>
                            <div class="employee_id_error"></div>
                        </div>
                        <div class="form-group col-sm-6 col-md-2" style="display:none;">
                            <label>Payment Status </label>
                            <select name="payment_status_id" id="payment_status_id" class="payment_status_id form-control select">
                                <option disabled="" value="0">Payment Status</option>
                                @foreach($payment_status_master as $payment_status)
                                <option value="{{$payment_status->id}}" {{$payment_status->id == $edit_details->payment_status_id ? 'selected' : ''}}>{{$payment_status->name}}</option>
                                @endforeach
                            </select>
                            <div class="payment_status_id_error"></div>
                        </div>
                        <div class="form-group col-sm-6 col-md-2">
                            <label>Action by Admin </label>
                            <select name="is_status_admin" required="" class="form-control select">
                                <option disabled="" selected="">Action by Admin</option>
                                <option value="5" {{$edit_details->is_process=='5' ? 'selected' : ''}} >Accept</option>
                                <option value="6" {{$edit_details->is_process=='6' ? 'selected' : ''}} >Reject</option>
                            </select>
                        </div>


                        <div class="form-group col-sm-6 col-md-3">
                            <label>
                                <a href="{{ route('expense.view_expances', $edit_details->id) }}"
                                   data-position="top"
                                   data-tooltip="View All Settlement">Settlement Amount Total </a> <?php
                                   echo $edit_details->currency . ' ';
                                   $amount_ = 0;
                                   if ($edit_details->settlement_amount == 0) {
                                       echo $amount_ = $edit_details->claim_amount;
                                   } else {
                                       echo $amount_ = $edit_details->settlement_amount;
                                   }
                                   //   if ($edit_details->claim_amount - $edit_details->settlement_amount == 0) {
                                   //       echo 'Full ' . $edit_details->settlement_amount;
                                   //   } else {
                                   //       echo $edit_details->settlement_amount;
                                   //   }
                                   ?>
                            </label>
                            <input type="number" <?php echo ($edit_details->payment_status_id == '4') ? "readonly" : ""; ?>
                                   name="settlement_amount" 
                                   oninput="this.value = !!this.value && Math.abs(this.value) >= 0 ? Math.abs(this.value) : null"
                                   id="settlement_amount" 
                                   value="<?php echo $amount_; ?>"
                                   class="form-control"
                                   placeholder=""
                                   min="0"
                                   max="<?php echo $amount_; ?>" 
                                   >
                                    <!--max="<?php // echo ($edit_details->claim_amount - $edit_details->settlement_amount);                                                                                                             ?>"--> 
                        </div>
                        <div class="form-group col-sm-6 col-md-2">
                            <label>Note  </label>
                            <input type="text" name="note_by_admin" placeholder="Note" class="form-control">
                        </div>
                    </div>
                <?php } ?>


                <div class="row">
                    <div class="form-group col-sm-6 col-md-2">
                        <input type="hidden" name="expense_type" value="{{$edit_details->expense_type}}" id="expense_type">
                        <label> Expense Type* </label>
                        <select disabled="" class="form-control select">
                            <option disabled="" value="999"> Expense Type*</option>
                            <option value="0" data-id="0" {{$edit_details->expense_type == 0 ? 'selected' : ''}}>Cash</option>
                            <option value="1" data-id="1" {{$edit_details->expense_type == 1 ? 'selected' : ''}}>Mileage</option>
                        </select>
                        <div class="expense_type_error"></div>
                    </div>
                    <div class="form-group col-sm-6 col-md-2">
                        <label>Payment Method* </label>
                        <select name="payment_method_id" id="payment_method_id" class="payment_method_id form-control select">
                            <option  disabled="" value="0">Payment Method*</option>
                            @foreach($payment_method_master as $payment)
                            <option value="{{$payment->id}}" {{$payment->id == $edit_details->payment_method_id ? 'selected' : ''}}>{{$payment->name}}</option>
                            @endforeach
                        </select>
                        <div class="payment_method_id_error"></div>
                    </div>
                    <div class="form-group col-sm-6 col-md-2">
                        <label>Status </label>
                        <select name="is_active" class="form-control select" >
                            <option disabled="" value="999"> Status</option>
                            <option value="0" {{$edit_details->is_active == 0 ? 'selected' : ''}}>Active</option>
                            <option value="1" {{$edit_details->is_active == 1 ? 'selected' : ''}}>Inactive</option>
                        </select>
                        <div class="is_active_error"></div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-8">

                        <!--=======================================================cash Expense=======================================================-->
                        <div class="card-content cash_flow">
                            <h4 class="card-title">Cash Expense</h4>
                            <div class="row">
                                <div class="form-group col-sm-6 col-md-4">
                                    <label>Currency </label>
                                    <input type="text" value="{{$edit_details->currency}}" disabled="" class="form-control">
                                    <!--<div class="errorTxt3"></div>-->
                                </div>
                                <div class="form-group col-sm-6 col-md-4">
                                    <!--if (Auth::id() !== 1)  readonly="" -->

                                    <?php
                                    echo $edit_details->is_process;
                                    if (($edit_details->is_process == 12)) {
                                        ?>
                                        <label style="color: red;">Amount* <br></label>
                                        <input type="number" name="total_amount_cash"  oninput="this.value = !!this.value && Math.abs(this.value) >= 0 ? Math.abs(this.value) : null" class="total_amount_cash form-control" placeholder="Enter Amount" value="{{$edit_details->reject_amount}}" min="0" max="{{$edit_details->reject_amount}}" readonly="">
                                    <?php } else if (($edit_details->is_process == 2) || ($edit_details->is_process == 4)) { ?>
                                        <label style="color: red;">Amount* <br></label>
                                        <input type="number" name="total_amount_cash"  oninput="this.value = !!this.value && Math.abs(this.value) >= 0 ? Math.abs(this.value) : null" class="total_amount_cash form-control" placeholder="Enter Amount" value="{{$edit_details->reject_amount}}" min="0" max="{{$edit_details->reject_amount}}" readonly="">
                                        <?php
                                    } else if (($edit_details->is_save == 3)) {
                                        $first_claim_amount = app('App\Http\Controllers\Controller')->getConditionDynamicNameTable('api_expenses', 'id', $edit_details->is_resubmit_expance_id, 'claim_amount');
                                        ?>
                                        <label style="color: red;">Account Amount* <br>[ Approved only from INR <?php echo $edit_details->total_amount_cash ?> to INR <?php echo $edit_details->claim_amount ?> ]</label>
                                        <input type="number" name="total_amount_cash"  oninput="this.value = !!this.value && Math.abs(this.value) >= 0 ? Math.abs(this.value) : null" class="total_amount_cash form-control" placeholder="Enter Amount" value="{{$edit_details->claim_amount}}" min="0" max="{{$edit_details->claim_amount}}" readonly="">
                                    <?php } else { ?>
                                        <label>Amount* </label>
                                        <input type="number" name="total_amount_cash"  oninput="this.value = !!this.value && Math.abs(this.value) >= 0 ? Math.abs(this.value) : null" class="total_amount_cash form-control" placeholder="Enter Amount" value="{{$edit_details->claim_amount}}" min="0" >
                                    <?php } ?>



                                    <div class="total_amount_cash_error"></div>
                                </div>
                                <div class="form-group col-sm-6 col-md-4">
                                    <label>Spent At *</label>
                                    <input type="text" name="spent_at_cash" class="spent_at_cash form-control " placeholder="ie:Mettro" value="{{$edit_details->spent_at}}">
                                    <div class="spent_at_cash_error"></div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-sm-6 col-md-4">
                                    <label>Date of Expense* </label>
                                    <input type="text" name="date_of_expense_cash" class="date_of_expense datepicker form-control" placeholder="Select Date of Expense" value="{{$edit_details->date_of_expense_cash}}">
                                    <div class="date_of_expense_cash_error"></div>
                                </div>
                                <div class="form-group col-sm-6 col-md-4">
                                    <label>Time of Expense </label>
                                    <input type="text" name="date_of_expense_time" class="date_of_expense_time form-control timepicker"  placeholder="Select Time of Expense" value="{{$edit_details->date_of_expense_time}}">
                                    <!--<div class="date_of_expense_time_error"></div>-->
                                </div>

                                <div class="form-group col-sm-6 col-md-4">
                                    <label>City Name * </label>
                                    <input type="text" name="city_id_cash" class="city_id_cash form-control" placeholder="Enter City Name" value="{{$edit_details->city_id_cash}}">
                                    <div class="city_id_cash_error"></div>
                                </div>
                            </div>
                            <div class="row">

                                <div class="form-group col-sm-6 col-md-4">
                                    <label>Account / Premises No</label>
                                    <input type="text" name="account_premises_no_cash" class="account_premises_no_cash form-control" placeholder="Enter Account / Premises No" value="{{$edit_details->account_premises_no_cash}}">
                                    <!--<div class="account_premises_no_cash_error"></div>-->
                                </div>
                                <div class="form-group col-sm-6 col-md-4">
                                    <label>Card Used </label>
                                    <input type="text" name="card_used_cash" class="card_used_cash form-control" placeholder="Enter Card Used" value="{{$edit_details->card_used_cash}}">
                                    <!--<div class="card_used_cash_error"></div>-->
                                </div>

                                <div class="form-group col-sm-6 col-md-4">
                                    <label>Account Name </label>
                                    <input type="text" name="account_name_cash" class="account_name_cash form-control" placeholder="Enter Account Name" value="{{$edit_details->account_name_cash}}">
                                    <!--<div class="account_name_cash_error"></div>-->
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-sm-6 col-md-4">
                                    <label>Department *</label>
                                    <select name="ddl_department_cash" id="ddl_department" class="ddl_department_cash form-control select">
                                        <option selected="" value="0">Department</option>
                                        @foreach($departments_master as $department)
                                        <option value="{{$department->id}}" {{$department->id == $edit_details->department_id ? 'selected' : ''}}>{{$department->Name}}</option>
                                        @endforeach
                                    </select>
                                    <div class="ddl_department_cash_error"></div>
                                </div>
                                <div class="form-group col-sm-6 col-md-4">
                                    <label>Category</label>
                                    <select name="category_id_cash" id="category_id_cash" class="category_id_cash form-control select">
                                        <option selected="" value="0">Category</option>
                                        @foreach($category_master as $category)
                                        <option value="{{$category->id}}" {{$category->id == $edit_details->category_id_cash ? 'selected' : ''}}>{{$category->name}}</option>
                                        @endforeach
                                    </select>
                                    <div class="category_id_cash_error"></div>
                                </div>

                                <div class="form-group col-sm-6 col-md-4">
                                    <label for="">Sub Category</label>
                                    <select name="sub_category_id_cash" id="sub_category_id_cash" class="sub_category_id_cash form-control select" >
                                        <option value="0" selected="">Sub Category</option>
                                        @foreach($subcategory_master as $subcategory)
                                        <option value="{{$subcategory->id}}" {{$subcategory->id == $edit_details->sub_category_id_cash ? 'selected' : ''}}>{{$subcategory->name}}</option>
                                        @endforeach
                                    </select>
                                    <div class="sub_category_id_cash_error"></div>
                                </div>
                            </div>
                            <div class="row">

                                <div class="form-group col-sm-6 col-md-4">
                                    <label>Description * </label>
                                    <textarea name="description_cash" class="description_cash materialize-textarea form-control" data-length="50">{{$edit_details->description_cash}}</textarea>
                                    <div class="description_cash_error"></div>
                                </div>
                                <div class="form-group col-sm-6 col-md-4">
                                    <label>Property Address </label>
                                    <textarea name="property_address_cash" class="property_address_cash materialize-textarea   form-control " data-length="50">{{$edit_details->property_address_cash}}</textarea>
                                    <!--<div class="errorTxt3"></div>-->
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-sm-6 col-md-4" style="margin-top: 35px;">
                                    <input type="checkbox" name="expance_multi_day" class="expance_multi_day" onclick="expance_multi_day();"/>
                                    Is Multi Day Expense
                                </div>
                                <div class="form-group col-sm-6 col-md-4 multi_day_div">
                                    <label>From Date</label>
                                    <input type="text" name="multi_day_from_date_cash" class="multi_day_from_date form-control " placeholder="YYYY-MM-DD" value="{{$edit_details->multi_day_from_date}}">
                                    <div class="multi_day_from_date_error"></div>
                                </div>
                                <div class="form-group col-sm-6 col-md-4 multi_day_div">
                                    <label>To Date </label>
                                    <input type="text" name="multi_day_to_date_cash" class="multi_day_to_date form-control " placeholder="YYYY-MM-DD"  value="{{$edit_details->multi_day_to_date}}">
                                    <div class="multi_day_to_date_error"></div>
                                </div>
                            </div>
                        </div>

                        <!--=======================================================cash Expense=======================================================-->
                        <!--=======================================================Mileage Expense=======================================================-->
                        <div class="card-content mailage_flow" style="display: none;">
                            <h6 class="card-title">Mileage Expense</h6>
                            <div class="row">
                                <div class="form-group col-sm-6 col-md-4">
                                    <label>Currency</label>
                                    <input type="text" value="INR" disabled="">
                                    <!--<div class="errorTxt3"></div>-->
                                </div>
                                <div class="input-field  form-group col-sm-6 col-md-4">
                                    <select name="vehicle_type_mile" id="vehicle_type_mile" class="txtCal vehicle_type_mile" onchange="calculation();">
                                        <option disabled="">Type of Vehicle</option>
                                        @foreach($vehicles_master as $vehicles)
                                        <option value="{{$vehicles->id}}" {{$vehicles->id == $edit_details->vehicle_type_mile ? 'selected' : ''}}>{{$vehicles->name}}</option>
                                        @endforeach
                                    </select>
                                    <label>Type of Vehicle* </label>
                                    <div class="vehicle_type_mile_error"></div>
                                </div>
                                <div class="form-group col-sm-6 col-md-4">
                                    <label for="">Rate Per Km</label> 
                                    <input type="number" readonly="" name="vehicle_rate_mile" oninput="this.value = !!this.value && Math.abs(this.value) >= 0 ? Math.abs(this.value) : null" id="vehicle_rate_per_km" class="vehicle_rate_per_km txtCal" placeholder="Enter Rat Per km." value="{{$edit_details->vehicle_rate_mile}}" onchange="calculation();" min="0">
                                </div>
                                <div class="form-group col-sm-6 col-md-4">
                                    <label>Distance* </label>
                                    <input type="number" name="distance_mile" oninput="this.value = !!this.value && Math.abs(this.value) >= 0 ? Math.abs(this.value) : null" class="distance_mile txtCal" placeholder="Enter Distance" value="{{$edit_details->distance_mile}}" onchange="calculation();" min="0">
                                    <div class="distance_mile_error"></div>
                                </div>
                            </div>
                            <div class="row">

                                <div class="col s3">
                                    <label>Spent at</label>
                                    <input type="text" name="spent_at_mile" placeholder="ie:Mettro" class="spent_at_mile" value="{{$edit_details->spent_at_mile}}">
                                    <div class="spent_at_mile_error"></div>
                                </div>
                                <div class="form-group col-sm-6 col-md-4">
                                    <label>Date of Expense* </label>
                                    <input type="text" name="date_of_expense_mile" class="date_of_expense date_of_expense_mile" placeholder="Select Date of Expense" value="{{$edit_details->date_of_expense_mile}}"  >
                                    <div class="date_of_expense_error"></div>
                                </div>
                                <div class="form-group col-sm-6 col-md-4">
                                    <label>Time of Expense* </label>
                                    <input type="text" name="date_of_expense_time_mile" class="date_of_expense_time_mile" placeholder="Select Date of Expense" value="{{$edit_details->date_of_expense_time}}"  >
                                    <div class="date_of_expense_time_mile_error"></div>
                                </div>

                                <div class="form-group col-sm-6 col-md-4">
                                    <label>City Name</label>
                                    <input type="text" name="city_name_mile" placeholder="City Name" class="city_name_mile" value="{{$edit_details->city_name_mile}}" >
                                    <div class="city_name_mile_error"></div>
                                </div>
                                <div class="col s3">
                                    <label>Total Amount(<i>Amount = Rate per Km * Distance</i>) </label>
                                    <input type="text" readonly="" name="total_amount_mile" placeholder="Total Amount" value="{{$edit_details->total_amount_mile}}" class="total_amount_mile">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-sm-6 col-md-4">
                                    <select name="category_id_mile" id="category_id_mile" class="category_id_mile">
                                        <option value="" selected disabled="">Category</option>
                                        @foreach($category_master as $category)
                                        <option value="{{$category->id}}" {{$category->id == $edit_details->category_id_mile ? 'selected' : ''}}>{{$category->name}}</option>
                                        @endforeach
                                    </select>
                                    <label>Category</label>
                                    <div class="category_id_mile_error"></div>
                                </div>
                                <div class="form-group col-sm-6 col-md-4">
                                    <select name="subcategory_id_mile" id="subcategory_id_mile" class="subcategory_id_mile">
                                        <option value="0" disabled=""> Sub Category</option>
                                        @foreach($subcategory_master as $subcategory)
                                        <option value="{{$subcategory->id}}" {{$subcategory->id == $edit_details->subcategory_id_mile ? 'selected' : ''}}>{{$subcategory->name}}</option>
                                        @endforeach
                                    </select>
                                    <label for="">Sub Category </label>
                                    <div class="subcategory_id_mile_error"></div>
                                </div>

                                <div class="form-group col-sm-6 col-md-4">
                                    <label>Description </label>
                                    <textarea id="description_mile" name="description_mile " class="materialize-textarea" data-length="50">{{$edit_details->description_mile}}</textarea>
                                </div>
                            </div>
                        </div>
                        <!--=======================================================mailage flow=======================================================/-->

                    </div>

                    <div class="col-md-4">
                        <div class="row">
                            <div id="file-upload" class="section" style="margin-top: 100px;">
                                <div class="section" style="text-align: center;">
                                    <h4 class="card-title">
                                        Upload Bills / Documents
                                    </h4>
                                    <input type="file" 
                                           id="input-file-max-fs" 
                                           name="expense_type_document[]"
                                           maxlength="5" 
                                           class="input-file-max-fs dropify expense_type_document" 
                                           data-max-file-size="15M" 
                                           accept="jpeg|jpg|png|pdf|doc|xls|ppt|docx|xlsx|pptx|tif|bmp|eml|msg"
                                           maxlength="5"
                                           data-maxfile="1024"
                                           multiple />
                                    <p style="font-size: 10px;color: red;">Allow to upload Bills/Documents  (* File size - 15 MB/file; max upload - 5 files<br>
                                        File types - .jpg, .jpeg, .png, .pdf, .doc, .xls, .ppt, .docx, .xlsx, .pptx, .tif, .bmp, .eml, .msg)
                                    </p>
                                </div>
                                <div class="file_upload_error"></div>
                            </div>
                            <?php foreach ($edit_details_file as $key => $files) { ?>
                                <div class="form-group col-sm-6 col-md-4" style="text-align: center;">
                                    @include('employee-master.expense.__file_extension')
                                    <br>
                                    <span class="fa fa-trash" data-id="{{ $files->id }}" data-name="holiday_details" style="margin-top: 13px;" onclick="remove_document({{ $files->id }})">
                                    </span>
                                </div>
                            <?php } ?>  
                        </div>
                    </div>
                </div>

                <br>

                <br>
            </form>
        </div>
    </div>
</div>
@endsection

{{-- page scripts --}}
@section('page-script')
<script src="{{asset('js/expense/edit.js')}}"></script>
<script src="{{asset('js/scripts/form-file-uploads.js')}}"></script>
@include('employee-master.expense.ejs')
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">
<script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>

<script>
                                            // capturing the button using its id
                                            const button_1 = document.getElementById("button_1");
                                            const button_2 = document.getElementById("button_2");
                                            const button_3 = document.getElementById("button_3");
 
                                            // function to disable the button
                                            const disableButton = () => {
                                                button_2.disabled = true;
                                            };
                                            const disableButton = () => {
                                                button_1.disabled = true;
                                            };
                                            const disableButton = () => {
                                                button_3.disabled = true;
                                            };

                                            // calling the disableButton() function when the click event happens
                                            button_3.addEventListener("click", disableButton);
                                            button_2.addEventListener("click", disableButton);
                                            button_1.addEventListener("click", disableButton);
</script>
<script type="text/javascript">
                                    submitFrm();
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
                                    //                            let flow = $(".expense_type option:selected").val();
                                    let flow = $("#expense_type").val();
                                    if (flow == '0') {
                                    if ((total_amount_cash.length < 1) || ($('.total_amount_cash').val() == '0')) {
                                    $('.total_amount_cash_error').html("<span class='error'>Enter Total Amount</span>");
                                    return false;
                                    }
                                    //                                if ($('.total_amount_cash').val().length > 1) {
                                    //                                    $('.total_amount_cash_error').html("<span class='error'>Amount should be more than 0</span>");
                                    //                                    return false;
                                    //                                }
                                    if ($('.spent_at_cash').val().length < 1) {
                                    $('.spent_at_cash_error').html("<span class='error'>Enter Spent At</span>");
                                    return false;
                                    }
                                    if ($('.description_cash').val().length < 1) {
                                    $('.description_cash_error').html("<span class='error'>Enter Description </span>");
                                    return false;
                                    }
                                    if ($('.date_of_expense').val() == 0) {
                                    $('.date_of_expense_cash_error').html("<span class='error'>Select Date Of Expense</span>");
                                    return false;
                                    }
                                    if ($('.date_of_expense_time').val() == 0) {
                                    $('.date_of_expense_time_error').html("<span class='error'>Select Time Of Expense</span>");
                                    return false;
                                    }
                                    if ($('.city_id_cash').val().length < 1) {
                                    $('.city_id_cash_error').html("<span class='error'>Enter City Name</span>");
                                    return false;
                                    }
                                    // if ($('.account_premises_no_cash').val().length < 1) {
                                    //     $('.account_premises_no_cash_error').html("<span class='error'>Enter Account/Premise No</span>");
                                    //     return false;
                                    // }
                                    // if ($('.card_used_cash').val().length < 1) {
                                    //     $('.card_used_cash_error').html("<span class='error'>Enter Card Used</span>");
                                    //     return false;
                                    // }
                                    // if ($('.account_name_cash').val().length < 1) {
                                    //     $('.account_name_cash_error').html("<span class='error'>Enter Account Name</span>");
                                    //     return false;
                                    // }
                                    if ($(".ddl_department_cash option:selected").val() == '0') {
                                    $(".ddl_department_cash_error").html("<span class='error'>Select Department</span>");
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
                                    if ($(".payment_method_id option:selected").val() == '0') {
                                    $(".payment_method_id_error").html("<span class='error'>Select Payment Method</span>");
                                    return false;
                                    }
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
                                    if (($('.distance_mile').val().length < 1) || ($('.distance_mile').val() == '0')) {
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
                                    $('.date_of_expense_error').html("<span class='error'>Select Time Of Expense</span>");
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
                                    if ($(".payment_method_id option:selected").val() == '0') {
                                    $(".payment_method_id_error").html("<span class='error'>Select Payment Method</span>");
                                    return false;
                                    }
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
                                    //                                if ($(".payment_method_id option:selected").val() == '0') {
                                    //                                    $(".payment_method_id_error").html("<span class='error'>Please payment_method_id_error#</span>");
                                    //                                    return false;
                                    //                                }
                                    //                                if ($(".is_active option:selected").val() == '999') {
                                    //                                    $(".is_active_error").html("<span class='error'>Please is_active_error#</span>");
                                    //                                    return false;
                                    //                                }
                                    return true;
                                    }
                                    //                            return false;
                                    }
</script>

<script>
    $(document).ready(function () {
    //        $('.distance_mile').val(0);
    //        $('.vehicle_rate_per_km').val(0);
    //        $('.total_amount_mile').val(0);
    calculation();
    });
    function calculation() {
    $('.total_amount_mile').val('');
    var sum = vehicle_rate_per_km = 0;
    var distance = $('.distance_mile').val();
    var vehicle_rate_per_km = $(".vehicle_rate_per_km").val();
    var sum = (distance * vehicle_rate_per_km);
    $(".total_amount_mile").val(sum);
    }

    $('#vehicle_type_mile').change(function () {
    calculation();
    var cid = $(this).val();
    if (cid) {
    $.ajax({
    type: "get",
            url: "/expense/getvehicalRat",
            data: {
            id: cid
            },
            success: function (res)
            {
            if (res)
            {
            calculation();
            $(".vehicle_rate_per_km").empty();
            $(".distance_mile").val(0);
            $.each(res, function (key, value) {
            $(".vehicle_rate_per_km").val(value.rate_per_km);
            $("#vehicle_rate_per_km").val(value.rate_per_km);
            });
            calculation();
            }
            }
    });
    }
    });
    $('#category_id_mile').change(function () {
    var cid = $(this).val();
    if (cid) {
    $.ajax({
    type: "get",
            url: "/expense/getsubcategory",
            data: {
            id: cid
            },
            success: function (res)
            {
            if (res)
            {
            $("#subcategory_id_mile").empty();
            $("#subcategory_id_mile").append('<option value="0">Sub Category</option>');
            $.each(res, function (key, value) {
            $("#subcategory_id_mile").append('<option value="' + value.id + '">' + value.name + '</option>');
            });
            $('select').formSelect();
            }
            }
    });
    }
    });</script>

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
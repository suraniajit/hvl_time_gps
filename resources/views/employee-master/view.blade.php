{{-- layout extend --}}
@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title','Employee Management')

{{-- vendor styles --}}
@section('vendor-style')
<link rel="stylesheet" type="text/css" href="{{asset('vendors/select2/select2.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/select2/select2-materialize.css')}}">
<script src="{{asset('js/ajax/jquery.min.js')}}"></script>
@endsection



{{-- page content --}}
@section('content')

<div class="card">
    <div class="card-content">
        <h6 class="title-color"><span>Employee Summary</span></h6>

        <form id="formValidate" action="" method="POST" enctype="multipart/form-data">
            {{csrf_field()}}
            @method('PUT')
            <div class="row">
                <div class="input-field col s6 m3 l3">
                    <label>Employee Full name * </label>
                    <input disabled="" type="text" name="name" id="name" data-error=".errorTxt1" placeholder="Employee name" value="{{$view_details->name}}">
                    <div class="errorTxt1"></div>
                </div>
                <div class="input-field col s6 m3 l3">
                    <label>Email ID * </label>
                    <input disabled="" type="text" name="email" id="email" data-error=".errorTxt2" placeholder="Email ID" value="{{$view_details->email}}">
                    <div class="errorTxt2"></div>
                </div>
                <div class="input-field col s6 m3 l3">
                    <label>Contact * </label>
                    <input disabled="" type="text" name="contact_no" id="contact_no" data-error=".errorTxt3" placeholder="Contact no" value="{{$view_details->contact_no}}">
                    <div class="errorTxt3"></div>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s6 m3 l3"> 
                    <label>Nationality</label>
                    <input  readonly="" type="text" name="nationality" id="nationality" placeholder="Enter Nationality" autocomplete="off" autofocus="off" value="{{$view_details->nationality}}">
                </div>
                <div class="input-field col s6 m3 l3"> 
                    <label>Address</label>
                    <input  readonly="" type="text" name="address" id="address" placeholder="Enter Address" autocomplete="off" autofocus="off" value="{{$view_details->address}}">
                </div>
                <div class="input-field col s6 m3 l3"> 
                    <label>Home Country Address</label>
                    <input  readonly="" type="text" name="home_country_address" placeholder="Enter Home Country Address" autocomplete="off" autofocus="off" value="{{$view_details->home_country_address}}">
                </div>
                <div class="input-field col s6 m3 l3"> 
                    <label>Home Country Contact Number</label>
                    <input  readonly="" type="text" name="contact_number_home" placeholder="Enter Contact Number of Home" autocomplete="off" autofocus="off" value="{{$view_details->contact_number_home}}">
                </div>
                <div class="input-field col s6 m3 l3"> 
                    <label>Emergency Contact Name</label>
                    <input  readonly="" type="text" name="emergency_contact_name" placeholder="Enter Emergency Contact Name" autocomplete="off" autofocus="off" value="{{$view_details->emergency_contact_name}}">
                </div>
                <div class="input-field col s6 m3 l3"> 
                    <label>Emergency Contact Number</label>
                    <input  readonly="" type="text" name="emergency_contact_number" placeholder="Enter Emergency Contact Number" autocomplete="off" autofocus="off" value="{{$view_details->emergency_contact_number}}">
                </div>
                
                <div class="input-field col s6 m3 l3"> 
                    <select disabled="" name="ddl_marital_status" id="ddl_marital_status">
                        <option value="-">Marital Status</option>
                        <option value="single" {{$view_details->ddl_marital_status == 'single' ? 'selected' : ''}} >Single</option>
                        <option value="married" {{$view_details->ddl_marital_status == 'married' ? 'selected' : ''}} >Married</option>
                        <option value="widowed" {{$view_details->ddl_marital_status == 'widowed' ? 'selected' : ''}} >Widowed</option>
                        <option value="divorced" {{$view_details->ddl_marital_status  == 'divorced'? 'selected' : ''}} >Divorced</option>
                        <option value="separated" {{$view_details->ddl_marital_status == 'separated' ? 'selected' : ''}} >Separated</option>
                        <option value="registered_partnership" {{$view_details->ddl_marital_status == 'registered_partnership' ? 'selected' : ''}} >Registered Partnership</option>
                    </select>
                    <label>Marital Status</label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s6 m3 l3"> 
                    <label>Date of Birth</label>
                    <input disabled="" type="text" name="dob" id="dob" data-error=".errorTxt4" placeholder="select dob" autocomplete="off" autofocus="off" value="{{$view_details->dob}}">
                    <div class="errorTxt4"></div>
                </div>
                <div class="input-field col s6 m3 l3"> 
                    <label>Date of Appointment</label>
                    <input disabled="" type="text" name="date_of_appointment" id="date_of_appointment" data-error=".errorTxt5" placeholder="select date of appointment" autocomplete="off" autofocus="off" value="{{$view_details->date_of_appointment}}">
                    <div class="errorTxt5"></div>
                </div> 
                <div class="input-field col s6 m3 l3"> 
                    <label>Date of Increment</label>
                    <input disabled="" type="text" name="date_of_increment" id="date_of_increment" placeholder="select date of increment" autocomplete="off" autofocus="off" value="{{$view_details->date_of_increment}}">
                </div> 

                <div class="input-field col s6 m3 l3">
                    <select disabled="" name="ddl_team" id="ddl_team" data-error=".errorTxt6" disabled="">
                        <option value="" selected disabled="">Teams</option>
                        @foreach($teams_master as $team)
                        <option value="{{$team->id}}" {{$team->id == $view_details->team ? 'selected' : ''}} >{{$team->name}}</option>
                        @endforeach
                    </select>
                    <label>Team* </label>
                    <div class="errorTxt6"></div>
                </div>
            </div>
            <div class="row">

                <div class="input-field col s6 m3 l3">
                    <select disabled="" name="ddl_department" id="ddl_department" data-error=".errorTxt7">
                        <option value="" selected disabled="">Departments</option>
                        @foreach($departments_master as $department)
                        <option value="{{$department->id}}" {{$department->id == $view_details->department ? 'selected' : ''}}>{{$department->name}}</option>
                        @endforeach
                    </select>
                    <label>Department * </label>
                    <div class="errorTxt7"></div>
                </div>

                <div class="input-field col s6 m3 l3">
                    <select disabled="" name="ddl_designation" id="ddl_designation" data-error=".errorTxt8">
                        <option value="" selected disabled="">Designation</option>
                        @foreach($designations_master as $designation)
                        <option value="{{$designation->id}}" {{$designation->id == $view_details->designation ? 'selected' : ''}}>{{$designation->name}}</option>
                        @endforeach
                    </select>
                    <label>Designation * </label>
                    <div class="errorTxt8"></div>
                </div>
                <div class="input-field col s6 m3 l3">
                    <select disabled="" name="dd_hr" id="dd_hr" data-error=".errorTxt9">
                        <option value="" selected disabled="">HR</option>
                        @foreach($employeesDetails as $employees)
                        <option value="{{$employees->id}}"  {{$employees->id == $view_details->hr ? 'selected' : ''}}>{{$employees->name}}</option>
                        @endforeach
                    </select>
                    <label>HR * </label>
                    <div class="errorTxt9"></div>
                </div>
                <div class="input-field col s6 m3 l3">
                    <select disabled="" name="ddl_team_lead" id="ddl_team_lead">
                        <option value="" selected disabled="">Team lead</option>
                        @foreach($employeesDetails as $employees)
                        <option value="{{$employees->id}}" {{$employees->id == $view_details->team_lead ? 'selected' : ''}} >{{$employees->name}}</option>
                        @endforeach
                    </select>
                    <label>Team lead </label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s6 m3 l3">
                    <select disabled="" name="ddl_employee_type" id="ddl_employee_type" data-error=".errorTxt10">
                        <option value="" selected disabled="">Employee Type</option>
                        @foreach($employee_types_master as $employee_type)
                        <option value="{{$employee_type->id}}" {{$employee_type->id == $view_details->employee_type ? 'selected' : ''}}>{{$employee_type->name}}</option>
                        @endforeach
                    </select>
                    <label>Employee Type * </label>
                    <div class="errorTxt10"></div>
                </div>
                <div class="input-field col s6 m3 l3">
                    <select disabled="" name="dd_department_lead" id="dd_department_lead">
                        <option value="" selected disabled="">Department Lead</option>
                        @foreach($employeesDetails as $employees)
                        <option value="{{$employees->id}}" {{$employees->id == $view_details->department_lead ? 'selected' : ''}} >{{$employees->name}}</option>
                        @endforeach
                    </select>
                    <label>Department Lead * </label>
                </div>
                <div class="input-field col s6 m3 l3">
                    <select disabled="" name="ddl_shift" id="ddl_shift" data-error=".errorTxt11">
                        <option value="" selected disabled="">Shift</option>
                        @foreach($shifts_master as $shift)
                        <option value="{{$shift->id}}" {{$shift->id == $view_details->shift ? 'selected' : ''}}>{{$shift->name}}</option>
                        @endforeach
                    </select>
                    <label>Shift*</label>
                    <div class="errorTxt11"></div>
                </div>
                <div class="input-field col s6 m3 l3">
                    <select disabled="" name="ddl_recruiter" id="ddl_recruiter" data-error=".errorTxt12">
                        <option value="" selected disabled="">Recruiter</option>
                        @foreach($recruiters_master as $recruiter)
                        <option value="{{$recruiter->id}}" {{$recruiter->id == $view_details->recruiter ? 'selected' : ''}} >{{$recruiter->name}}</option>
                        @endforeach
                    </select>
                    <label>Recruiter * </label>
                    <div class="errorTxt12"></div>
                </div>
            </div>
            <div class="row">
                <?php
                if (Auth::id() == '1') {
                    ?>
                    <div class="input-field col s6 m3 l3">
                        <select disabled="" class="select" name="ddl_salary_type" id="ddl_salary_type" data-error=".errorTxt13">
                            <option value="" selected disabled="">Salary Type</option>
                            @foreach($salaryTypeDetails as $salaryType)
                            <option value="{{$salaryType->id}}" {{$salaryType->id == $view_details->salary_type ? 'selected' : ''}} >{{$salaryType->name}}</option>
                            @endforeach
                        </select>
                        <label>Salary Type</label>
                        <div class="errorTxt13"></div>
                    </div>
                    <div class="input-field col s6 m3 l3">
                        <label>Salary*</label>
                        <input disabled="" type="text" name="salary" id="salary" data-error=".errorTxt14" placeholder="Enter salary" value="{{$view_details->salary}}">
                        <div class="errorTxt14"></div>
                    </div>
                <?php } else if ($hr_roles == Auth::id()) { ?>
                    <div class="input-field col s6 m3 l3">
                        <select disabled="" class="select" name="ddl_salary_type" id="ddl_salary_type" data-error=".errorTxt13">
                            <option value="" selected disabled="">Salary Type</option>
                            @foreach($salaryTypeDetails as $salaryType)
                            <option value="{{$salaryType->id}}" {{$salaryType->id == $view_details->salary_type ? 'selected' : ''}} >{{$salaryType->name}}</option>
                            @endforeach
                        </select>
                        <label>Salary Type</label>
                        <div class="errorTxt13"></div>
                    </div>
                    <div class="input-field col s6 m3 l3">
                        <label>Salary*</label>
                        <input disabled="" type="text" name="salary" id="salary" data-error=".errorTxt14" placeholder="Enter salary" value="{{$view_details->salary}}">
                        <div class="errorTxt14"></div>
                    </div>
                <?php } ?>

                <div class="input-field col s6 m3 l3">
                    <select disabled="" class="select" name="ddl_issuance_type" id="ddl_issuance_type">
                        <option value="" selected disabled="">Insurance Type</option>
                        @foreach($issuanceDetails as $issuance)
                        <option value="{{$issuance->id}}" {{$issuance->id == $view_details->insurance_category ? 'selected' : ''}}>{{$issuance->name}}</option>
                        @endforeach
                    </select>
                    <label>Insurance (Category)</label>
                    <div class="errorTxt8"></div>
                </div>

            </div>
            
            <div class="row">
                <div class="input-field col s6 m3 l3">
                    <label>Target</label>
                    <input  disabled="" type="text" name="target" id="target" placeholder="Enter Target" value="{{$view_details->target}}">
                </div>

                <div class="input-field col s6 m3 l3">
                    <label>Commission(%)</label>
                    <input  disabled="" type="number" name="commission" id="commission" placeholder="Enter Commission" value="{{$view_details->commission}}" oninput="this.value = !!this.value && Math.abs(this.value) >= 0 ? Math.abs(this.value) : null">
                </div>

                <div class="input-field col s6 m3 l3"> 
                    <label>Date of Resignation</label>
                    <input  disabled="" type="text" name="date_of_resignation" id="date_of_resignation" placeholder="Select Date of Resignation" autocomplete="off" autofocus="off" value="{{$view_details->date_of_resignation}}">
                </div> 
            </div>
            
            
            <div class="row">
                <div class="input-field col s6 m3 l3">
                    <select disabled="" class="select2 browser-default" data-error=".errorTxt15" multiple name="ddl_equipment[]" data-placeholder="Equipment/s issued to the employee" id="ddl_equipment">
                        @foreach($equipmentDetails as $equipment)
                        <option value="{{$equipment->id}}" {{in_array($equipment->id, $employee_shift) ? ' selected ="" ' : ''}} > {{$equipment->name}}</option>
                        @endforeach
                    </select>
                    <!--<label>Equipment issued to the employee***** </label>-->
                    <div class="errorTxt15"></div>
                </div>
                <div class="input-field col s6 m3 l3">
                    <label>Equipment Note</label>
                    <input readonly="" type="text" name="equipment_note" placeholder="Enter Equipment Note" autocomplete="off" autofocus="off" value="{{$view_details->equipment_note}}">
                </div>
                <div class="input-field col s6 m3 l3">
                    <select disabled="" name="employee_status" id="employee_status" data-error=".errorTxt16">
                        <option value="" disabled="">Employee Status</option>
                        <option value="0" {{$view_details->employee_status == 0 ? 'selected' : ''}} >Active</option>
                        <option value="1" {{$view_details->employee_status == 1 ? 'selected' : ''}}>Inactive</option>
                    </select>
                    <label>Employee Status </label>
                    <div class="errorTxt16"></div>
                </div>
            </div>
            <?php if (count($password_details) > 0) { ?>
                <h6 class="card-title">Password Details</h6>
                <div id="password_type">
                    <?php
                    foreach ($password_details as $key => $value) {
                        ?>
                        <div class="row">
                            <div class="pass_type" style=" border: 0px solid red;">
                                <div class="input-field col s6 m3 l3">
                                    <label>Password Type *</label>
                                    <select disabled="" name="pass_type[]" id="pass_type" class="select"><option value="" disable>password type</option>
                                        @foreach($PtypeDetails as $Pdetails)<option value="{{$Pdetails->id}}" {{$Pdetails->id == $value->pass_type ? 'selected' : ''}} >{{$Pdetails->name}}</option>@endforeach
                                    </select>

                                </div>
                                <div class="input-field col s6 m3 l3">
                                    <label>Password *</label>
                                    <input disabled="" type="text" name="pass_name[]" id="pass_name" placeholder="enter password*" value="{{$value->password}}" required="" />
                                </div>
                                <div class="input-field col s6 m3 l3">
                                    <label>Note</label>
                                    <input disabled="" type="text" name="pass_note[]" id="pass_note" class="input-field" placeholder="Note" autofocus="off" autocomplete="off" value="{{$value->pass_note}}" />
                                </div>
                                <br>
                            </div>
                        </div>
                    <?php } ?>
                </div>    
            <?php } if (count($document_details) > 0) { ?>
                <h6 class="card-title">Document Details</h6>
                <div id="upload_document_type">
                    <?php
                    foreach ($document_details as $key => $value) {
                        ?>
                        <div class="row">
                            <div class="doc_type" style=" border: 0px solid red;">
                                <div class="input-field col s6 m3 l3">
                                    <label>Document Name*</label>
                                    <input disabled="" type="text" name="document_name[]" id="document_name" class="input-field" value="{{$value->document_name}}" placeholder="document name" required="" />
                                </div>
                                <div class="input-field col s6 m3 l3">
                                    <label>Expiry Date *</label>
                                    <input disabled="" type="text"  name="document_expiry[]" id="document_expiry" class="date" value="{{$value->document_expiry}}" placeholder="document expiry date" required="" />
                                </div>
                                <div class="input-field col s6 m3 l3">

                                    <label>Note </label>
                                    <input disabled="" type="text"  name="pass_note[]" id="pass_note" class="input-field"  value="{{$value->document_not}}" placeholder="enter note"/>
                                </div>
                                <div class="input-field col s6 m3 l3">
                                    
                                    <?php  if ($value->is_flag == 0) { if (($value->file_extension == 'pdf') || $value->file_extension == 'PDF') { ?>
                                        <a target="_blank" href="/public/uploads/hherp/apiemp/{{$view_details->id}}/{{$value->document_file}}">
                                            <img src="https://upload.wikimedia.org/wikipedia/commons/8/87/PDF_file_icon.svg" height="50" width="50"/>
                                        </a>
                                    <?php } else { ?>
                                        <a target="_blank" href="/public/uploads/hherp/apiemp/{{$view_details->id}}/{{$value->document_file}}">
                                            <img src="/public/uploads/hherp/apiemp/{{$view_details->id}}/{{$value->document_file}}" height="50" width="50"/>
                                        </a>
                                    <?php }} ?>
                                </div>
                                <br>
                            </div>
                        </div>
                    <?php } ?>
                </div>    
            <?php } if (count($bank_details) > 0) { ?>
                <h6 class="card-title"> Bank Details </h6>
                <div class="row">
                    <div id="upload_bank_type">
                        <?php
                        foreach ($bank_details as $key => $value) {
                            ?>
                            <div class="input-field col s6 m3 l3 bank_type" style=" border: 0px solid red">
                                <input type="text" disabled=""  value="{{$value->bank_name}}" name="bank_name[]" id="bank_name" class="input-field" placeholder="Bank name" autocomplete="off" autofocus="off" />
                                <select disabled="" name="bank_type[]" class="select" required="">
                                    <option value="" disable>Account Type</option>
                                    <option value="0" {{$value->bank_type == 0 ? 'selected' : ''}} >Saving</option>
                                    <option value="1" {{$value->bank_type == 1 ? 'selected' : ''}} >current</option>
                                </select>
                                <input disabled="" type="number" value="{{$value->bank_account_number}}" name="bank_account_number[]" id="bank_account_number" class="input-field" placeholder="Account Number" autocomplete="off" autofocus="off" />
                                <input disabled="" type="text" value="{{$value->bank_customer_name}}" name="bank_customer_name[]" id="bank_customer_name" class="input-field" placeholder="Account Holder Name" autocomplete="off" autofocus="off" />
                                <input disabled="" type="text" value="{{$value->IBAN}}" name="IBAN[]" id="IBAN" class="input-field" placeholder="IBAN*" autocomplete="off" autofocus="off" />
                                <input disabled="" type="text" value="{{$value->bank_note}}" name="bank_note[]" id="bank_note" placeholder="Note" autofocus="off" autocomplete="off" />

                            </div>
                        <?php } ?>
                    </div>    
                </div>
            <?php } if (count($vehicleDetails) > 0) { ?>

                <h6 class="card-title">Vehicle Details </h6>
                <div id="vehicle_type">
                    <?php
                    foreach ($vehicleDetails as $key => $value) {
                        ?>
                        <div class="input-field col s6 m3 l3 vehical_type" style=" border: 0px solid red">
                            <input disabled="" type="text" value="{{$value->vehicle_name}}" name="vehicle_name[]" id="vehicle_name"  placeholder="Vehicle Name*"  required="" />
                            <input disabled="" type="text" value="{{$value->vehicle_number}}" name="vehicle_number[]" id="vehicle_number"  placeholder="Vehicle Number*"  required="" />
                            <input disabled="" type="number" value="{{$value->vehicle_mileage}}" name="vehicle_mileage[]" id="vehicle_mileage"  placeholder="Vehicle Mileage*"  required="" />
                            <input disabled="" type="number" value="{{$value->vehicle_run_start}}" name="vehicle_run_start[]" id="vehicle_run_start" placeholder="Run Start" />
                            <input disabled="" type="number" value="{{$value->vehicle_run_end}}" name="vehicle_run_end[]" id="vehicle_run_end" placeholder="Run End" />
                            <input disabled="" type="text" value="{{$value->vehicle_note}}" name="vehicle_note[]" id="vehicle_note" placeholder="Note" />

                        </div>
                    <?php } ?>
                </div>    
            <?php } ?>
            <br>
            @include('employee-master.holidays._view_holiday')

        </form>
    </div>
</div>
@endsection

{{-- vendor script --}}
@section('vendor-script')

<script src="{{asset('js/ajax/angular.min.js')}}"></script>
<script src="{{asset('js/materialize.js')}}"></script>
<script src="{{asset('js/ajax/jquery.validate.min.js')}}"></script>
<script src="{{asset('vendors/select2/select2.full.min.js')}}"></script>
<script src="{{asset('js/scripts/form-select2.js')}}"></script>
<script src="{{asset('vendors/dropify/js/dropify.min.js')}}"></script>



@endsection

{{-- page scripts --}}
@section('page-script')
<script src="{{asset('ckeditor/ckeditor.js')}}"></script>
@include('employee-master._js_password')
@include('employee-master._js_document')
@include('employee-master._js_bank')
@include('employee-master._js_vehicle')
<script type="text/javascript">


$(document).ready(function () {
    jQuery.datetimepicker.setLocale('en');
    jQuery('#date_of_appointment').datetimepicker({
        timepicker: false,
        format: 'Y-m-d',
        defaultDate: new Date(),
        maxDate: new Date(),
//                formatDate: 'Y-m-d',
        scrollInput: false

    });
    jQuery('#date_of_increment').datetimepicker({
        timepicker: false,
        format: 'Y-m-d',
        minDate: -1,
        defaultDate: new Date(),
        formatDate: 'Y-m-d',
        scrollInput: false

    });



    jQuery('#dob').datetimepicker({
        timepicker: false,
        format: 'Y-m-d',
        defaultDate: new Date(),
        maxDate: new Date(),
//                formatDate: 'Y-m-d',
        scrollInput: false

    });



    var myfile = "";

    $("#file_error").html("<p style='color:#FF0000'>File Size: Upto 1MB (.PDF/.DOC/.DOCX)</p>");

    $("#attachment").change(function () {
        $("#file_error").html("");
        $(".file_error").css("border-color", "#F0F0F0");
        var file_size = $('#attachment')[0].files[0].size;
        myfile = $(this).val();
        var ext = myfile.split('.').pop();
        if (ext == "pdf" || ext == "docx" || ext == "doc") {
            //alert('1' + ext);
        } else {
            alert('Supported Files: .PDF/.Doc/.Docx');
            return false;
        }
        if (file_size > 300000) {
            $("#file_error").html("<p style='color:#FF0000'>File Size: Upto 1MB (.PDF/.DOC/.DOCX)</p>");
            $(".file_upload1").css("border-color", "#FF0000");
            return false;
        }

        return true;
    });



    $('.rmv').click(function () {
        var id = $(this).data("id");
        var password_details = $(this).data("name");
        alert(password_details);
        var name = 'Candidates';
        var token = $("meta[name='csrf-token']").attr("content");
        $.ajax({
            url: '/emp/removedata/',
            type: 'DELETE',
            data: {
                "_token": token,
                'id': id,
                'delete': password_details,
            },
            success: function (result) {
//                        swal("Record has been deleted!", {
//                            icon: "success",
//                        }).then(function () {
//                           // location.reload();
//                        });
            }
        });
    });

});
</script>
@endsection



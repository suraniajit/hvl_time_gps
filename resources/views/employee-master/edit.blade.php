{{-- layout extend --}}
@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title','Employee Management')

{{-- vendor styles --}}
@section('vendor-style')
<link rel="stylesheet" type="text/css" href="{{asset('vendors/select2/select2.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/select2/select2-materialize.css')}}">
<script src="{{asset('js/ajax/jquery.min.js')}}"></script>
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


{{-- page content --}}
@section('content')

<div class="card">
    <div class="card-content">
        <h5 class="title-color"><span>Edit Employee</span></h5>
        <div class=" ">
            <!--success message start-->
            @if ($message = Session::get('success'))
            <div class="card-alert card green lighten-5" id="message">
                <div class="card-content green-text">
                    <p>{{ $message }}</p>
                </div>
                <button type="button" class="close green-text close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            @endif
            <!--success message end-->
        </div>
        <form id="formEditValidate" action="{{ route('emp.update', $edit_details->id) }}" method="POST" enctype="multipart/form-data">
            {{csrf_field()}}
            <div class="row">
                <div class="col s12 display-flex justify-content-end form-action">
                    <button type="submit" class="btn btn-small indigo waves-light mr-1"> Update </button>
                    <button type="reset" class="btn btn-small indigo waves-light mr-1" onclick="goBack();">
                        <i class="material-icons right">settings_backup_restore</i>Cancel
                    </button>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="input-field col s6 m3 l3">
                    <label>Employee Name * </label>
                    <input type="text" name="name" id="name" data-error=".errorTxt1" placeholder="Employee Name" value="{{$edit_details->name}}">
                    <div class="errorTxt1"></div>
                </div>
                <div class="input-field col s6 m3 l3">
                    <label>Email ID * </label>
                    <input type="text" name="email" id="email" data-error=".errorTxt2" placeholder="Email ID" value="{{$edit_details->email}}">
                    <input type="hidden" name="edit_email_user_id" value="{{$edit_details->user_id}}">
                    <div class="errorTxt2"></div>
                </div>
                <div class="input-field col s6 m3 l3">
                    <label>Contact No* </label>
                    <input type="number" name="contact_no" data-error=".errorTxt3" placeholder="Contact No" value="{{$edit_details->contact_no}}" oninput="this.value = !!this.value && Math.abs(this.value) >= 0 ? Math.abs(this.value) : null">
                    <input type="hidden" name="edit_contact_id" value="{{$edit_details->id}}">
                    <div class="errorTxt3"></div>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s6 m3 l3"> 
                    <label>Nationality</label>
                    <input type="text" name="nationality" id="nationality" placeholder="Enter Nationality" autocomplete="off" autofocus="off" value="{{$edit_details->nationality}}">
                </div>
                <div class="input-field col s6 m3 l3"> 
                    <label>Address</label>
                    <input type="text" name="address" id="address" placeholder="Enter Address" autocomplete="off" autofocus="off" value="{{$edit_details->address}}">
                </div>
                <div class="input-field col s6 m3 l3"> 
                    <label>Home Country Address</label>
                    <input type="text" name="home_country_address" placeholder="Enter Home Country Address" autocomplete="off" autofocus="off" value="{{$edit_details->home_country_address}}">
                </div>
                <div class="input-field col s6 m3 l3"> 
                    <label>Home Country Contact Number</label>
                    <input type="number" name="contact_number_home" placeholder="Enter Contact Number of Home Country" autocomplete="off" autofocus="off" value="{{$edit_details->contact_number_home}}" oninput="this.value = !!this.value && Math.abs(this.value) >= 0 ? Math.abs(this.value) : null">
                </div>
                <div class="input-field col s6 m3 l3"> 
                    <label>Emergency Contact Name</label>
                    <input type="text" name="emergency_contact_name" placeholder="Enter Emergency Contact Name" autocomplete="off" autofocus="off" value="{{$edit_details->emergency_contact_name}}">
                </div>
                <div class="input-field col s6 m3 l3"> 
                    <label>Emergency Contact Number</label>
                    <input type="number" name="emergency_contact_number" placeholder="Enter Emergency Contact Number" autocomplete="off" autofocus="off" value="{{$edit_details->emergency_contact_number}}" oninput="this.value = !!this.value && Math.abs(this.value) >= 0 ? Math.abs(this.value) : null">
                </div>

                <div class="input-field col s6 m3 l3"> 
                    <select name="ddl_marital_status" id="ddl_marital_status">
                        <option value="0">Marital Status</option>
                        <option value="single" {{$edit_details->ddl_marital_status == 'single' ? 'selected' : ''}} >Single</option>
                        <option value="married" {{$edit_details->ddl_marital_status == 'married' ? 'selected' : ''}} >Married</option>
                        <option value="widowed" {{$edit_details->ddl_marital_status == 'widowed' ? 'selected' : ''}} >Widowed</option>
                        <option value="divorced" {{$edit_details->ddl_marital_status  == 'divorced'? 'selected' : ''}} >Divorced</option>
                        <option value="separated" {{$edit_details->ddl_marital_status == 'separated' ? 'selected' : ''}} >Separated</option>
                        <option value="registered_partnership" {{$edit_details->ddl_marital_status == 'registered_partnership' ? 'selected' : ''}} >Registered Partnership</option>
                    </select>
                    <label>Marital Status</label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s6 m3 l3"> 
                    <label>Date of Birth*</label>
                    <input type="text" name="dob" id="dob" data-error=".errorTxt4" placeholder="Select Date of Birth" autocomplete="off" autofocus="off" value="{{$edit_details->dob}}">
                    <div class="errorTxt4"></div>
                </div>
                <div class="input-field col s6 m3 l3"> 
                    <label>Date of Appointment*</label>
                    <input type="text" name="date_of_appointment" id="date_of_appointment" data-error=".errorTxt5" placeholder="Select Date of Appointment" autocomplete="off" autofocus="off" value="{{$edit_details->date_of_appointment}}">
                    <div class="errorTxt5"></div>
                </div> 
                <div class="input-field col s6 m3 l3"> 
                    <label>Date of Increment*</label>
                    <input type="text" name="date_of_increment" id="date_of_increment" placeholder="Select Date of Increment" autocomplete="off" autofocus="off" value="{{$edit_details->date_of_increment}}">
                </div> 

                <div class="input-field col s6 m3 l3">
                    <select name="ddl_team" id="ddl_team" data-error=".errorTxt6">
                        <option value="" selected disabled="">Teams*</option>
                        @foreach($teams_master as $team)
                        <option value="{{$team->id}}" {{$team->id == $edit_details->team ? 'selected' : ''}} >{{$team->name}}</option>
                        @endforeach
                    </select>
                    <label>Team* </label>
                    <div class="errorTxt6"></div>
                </div>
            </div>
            <div class="row">

                <div class="input-field col s6 m3 l3">
                    <select name="ddl_department" id="ddl_department" data-error=".errorTxt7">
                        <option value="" selected disabled="">Departments</option>
                        @foreach($departments_master as $department)
                        <option value="{{$department->id}}" {{$department->id == $edit_details->department ? 'selected' : ''}}>{{$department->name}}</option>
                        @endforeach
                    </select>
                    <label>Department * </label>
                    <div class="errorTxt7"></div>
                </div>

                <div class="input-field col s6 m3 l3">
                    <select name="ddl_designation" id="ddl_designation" data-error=".errorTxt8">
                        <option value="" selected disabled="">Designation</option>
                        @foreach($designations_master as $designation)
                        <option value="{{$designation->id}}" {{$designation->id == $edit_details->designation ? 'selected' : ''}}>{{$designation->name}}</option>
                        @endforeach
                    </select>
                    <label>Designation * </label>
                    <div class="errorTxt8"></div>
                </div>
                <div class="input-field col s6 m3 l3">
                    <select name="dd_hr" id="dd_hr" data-error=".errorTxt9">
                        <option value="" selected disabled="">HR</option>
                        @foreach($employeesDetails as $employees)
                        <option value="{{$employees->id}}"  {{$employees->id == $edit_details->hr ? 'selected' : ''}}>{{$employees->name}}</option>
                        @endforeach
                    </select>
                    <label>HR * </label>
                    <div class="errorTxt9"></div>
                </div>
                <div class="input-field col s6 m3 l3">
                    <select name="ddl_team_lead" id="ddl_team_lead">
                        <option value="" selected disabled="">Team Lead</option>
                        @foreach($employeesDetails as $employees)
                        <option value="{{$employees->id}}" {{$employees->id == $edit_details->team_lead ? 'selected' : ''}} >{{$employees->name}}</option>
                        @endforeach
                    </select>
                    <label>Team Lead </label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s6 m3 l3">
                    <select name="ddl_employee_type" id="ddl_employee_type" data-error=".errorTxt10">
                        <option value="" selected disabled="">Employee Type</option>
                        @foreach($employee_types_master as $employee_type)
                        <option value="{{$employee_type->id}}" {{$employee_type->id == $edit_details->employee_type ? 'selected' : ''}}>{{$employee_type->name}}</option>
                        @endforeach
                    </select>
                    <label>Employee Type * </label>
                    <div class="errorTxt10"></div>
                </div>
                <div class="input-field col s6 m3 l3">
                    <select name="dd_department_lead" id="dd_department_lead">
                        <option value="" selected disabled="">Department Lead</option>
                        @foreach($employeesDetails as $employees)
                        <option value="{{$employees->id}}" {{$employees->id == $edit_details->department_lead ? 'selected' : ''}} >{{$employees->name}}</option>
                        @endforeach
                    </select>
                    <label>Department Lead * </label>
                </div>
                <div class="input-field col s6 m3 l3">
                    <select name="ddl_shift" id="ddl_shift" data-error=".errorTxt11">
                        <option value="" selected disabled="">Shift</option>
                        @foreach($shifts_master as $shift)
                        <option value="{{$shift->id}}" {{$shift->id == $edit_details->shift ? 'selected' : ''}}>{{$shift->name}}</option>
                        @endforeach
                    </select>
                    <label>Shift*</label>
                    <div class="errorTxt11"></div>
                </div>
                <div class="input-field col s6 m3 l3">
                    <select name="ddl_recruiter" id="ddl_recruiter" data-error=".errorTxt12">
                        <option value="" selected disabled="">Recruiter</option>
                        @foreach($recruiters_master as $recruiter)
                        <option value="{{$recruiter->id}}" {{$recruiter->id == $edit_details->recruiter ? 'selected' : ''}} >{{$recruiter->name}}</option>
                        @endforeach
                    </select>
                    <label>Recruiter * </label>
                    <div class="errorTxt12"></div>
                </div>
            </div>
            <div class="row">

                <?php if (Auth::id() == '1') { ?>
                    <div class="input-field col s6 m3 l3">
                        <select class="select" name="ddl_salary_type" id="ddl_salary_type" data-error=".errorTxt13">
                            <option value="" selected disabled="">Salary type</option>
                            @foreach($salaryTypeDetails as $salaryType)
                            <option value="{{$salaryType->id}}" {{$salaryType->id == $edit_details->salary_type ? 'selected' : ''}} >{{$salaryType->name}}</option>
                            @endforeach
                        </select>
                        <label>Salary Type</label>
                        <div class="errorTxt13"></div>
                    </div>
                    <div class="input-field col s6 m3 l3">
                        <label>Salary * </label>
                        <input type="number" name="salary" id="salary" data-error=".errorTxt14" placeholder="Enter salary" value="{{$edit_details->salary}}" oninput="this.value = !!this.value && Math.abs(this.value) >= 0 ? Math.abs(this.value) : null">
                        <div class="errorTxt14"></div>
                    </div>
                <?php } else if ($hr_roles == Auth::id()) { ?>
                    <div class="input-field col s6 m3 l3">
                        <select class="select" name="ddl_salary_type" id="ddl_salary_type" data-error=".errorTxt13">
                            <option value="" selected disabled="">Salary type</option>
                            @foreach($salaryTypeDetails as $salaryType)
                            <option value="{{$salaryType->id}}" {{$salaryType->id == $edit_details->salary_type ? 'selected' : ''}} >{{$salaryType->name}}</option>
                            @endforeach
                        </select>
                        <label>Salary Type</label>
                        <div class="errorTxt13"></div>
                    </div>
                    <div class="input-field col s6 m3 l3">
                        <label>Salary * </label>
                        <input type="number" name="salary" id="salary" data-error=".errorTxt14" placeholder="Enter salary" value="{{$edit_details->salary}}" oninput="this.value = !!this.value && Math.abs(this.value) >= 0 ? Math.abs(this.value) : null">
                        <div class="errorTxt14"></div>
                    </div>
                <?php } ?>


                <div class="input-field col s6 m3 l3">
                    <select class="select" name="ddl_issuance_type" id="ddl_issuance_type">
                        <option value="" selected disabled="">Insurance Type</option>
                        @foreach($issuanceDetails as $issuance)
                        <option value="{{$issuance->id}}" {{$issuance->id == $edit_details->insurance_category ? 'selected' : ''}}>{{$issuance->name}}</option>
                        @endforeach
                    </select>
                    <label>Insurance (Category)</label>

                </div>

            </div>
            <div class="row">
                <div class="input-field col s6 m3 l3">
                    <label>Target</label>
                    <input type="text" name="target" id="target" placeholder="Enter Target" value="{{$edit_details->target}}">
                </div>

                <div class="input-field col s6 m3 l3">
                    <label>Commission(%)</label>
                    <input type="number" name="commission" id="commission" placeholder="Enter Commission" value="{{$edit_details->commission}}" oninput="this.value = !!this.value && Math.abs(this.value) >= 0 ? Math.abs(this.value) : null">
                </div>

                <div class="input-field col s6 m3 l3"> 
                    <label>Date of Resignation</label>
                    <input type="text" name="date_of_resignation" id="date_of_resignation" placeholder="Select Date of Resignation" autocomplete="off" autofocus="off" value="{{$edit_details->date_of_resignation}}">
                </div> 
            </div>
            <div class="row">
                <div class="col s4">
                    <select class="select2 browser-default" multiple name="ddl_equipment[]" data-placeholder="Equipment/s Issued To Employee" id="ddl_equipment">
                        @foreach($equipmentDetails as $equipment)
                        <option value="{{$equipment->id}}" {{in_array($equipment->id, $employee_shift) ? ' selected ="" ' : ''}} > {{$equipment->name}}</option>
                        @endforeach
                    </select>
                    <!--<label>Equipment/s issued To The Employee</label>-->
                    <!--<div class="errorTxt15"></div>-->
                </div>
                <div class="col s4">
                    <label>Equipment Note</label>
                    <input type="text" name="equipment_note" placeholder="Enter Equipment Note" autocomplete="off" autofocus="off" value="{{$edit_details->equipment_note}}">
                </div>
                <div class="input-field col s6 m3 l3">
                    <select name="employee_status" id="employee_status" data-error=".errorTxt16">
                        <option value="" disabled="">Employee Status</option>
                        <option value="0" {{$edit_details->employee_status == 0 ? 'selected' : ''}} >Active</option>
                        <option value="1" {{$edit_details->employee_status == 1 ? 'selected' : ''}}>Inactive(employee leaves)</option>
                    </select>
                    <label>Employee Status </label>
                    <div class="errorTxt16"></div>
                </div>
            </div>

            @include('employee-master._edit_password')

            @include('employee-master._edit_mandatory_documents')

            @include('employee-master._edit_upload_document')

            @include('employee-master._edit_bank_details')

            @include('employee-master._edit_vehicle_details')

            <br>
            <div class="row">
                <div class="col s12 display-flex justify-content-end form-action">
                    <button type="submit" class="btn btn-small indigo waves-light mr-1"> Update </button>
                    <button type="reset" class="btn btn-small indigo waves-light mr-1" onclick="goBack();">
                        <i class="material-icons right">settings_backup_restore</i>Cancel
                    </button>
                </div>
            </div>
            <br>
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
<script src="{{asset('js/employee-master/edit.js')}}"></script>

@endsection

{{-- page scripts --}}
@section('page-script')
@include('employee-master._js_password')
@include('employee-master._js_document')
@include('employee-master._js_bank')
@include('employee-master._js_vehicle')
<script type="text/javascript">


                        $(document).ready(function () {


                            $('#ddl_team').change(function () {
                                var cid = $(this).val();
                                if (cid) {
                                    $.ajax({
                                        type: "get",
                                        url: "/emp/getCallTeamDepartment",
                                        data: {
                                            id: cid
                                        },
                                        success: function (res)
                                        {
                                            console.log(res);
                                            if (res)
                                            {
//                                                console.log((res.departments_name).length);
//                                                console.log(res.departments_name);
//                                                alert(res.department);
//===========================================================================================================================
                                                if (res.departments_name) {
                                                    if (((res.departments_name).length) == "1") {
                                                        $("#ddl_department").empty();
                                                        $.each(res.departments_name, function (key, value) {
                                                            $("#ddl_department").append('<option value="' + value.id + '" selected="">' + value.name + '</option>');
                                                        });
                                                    } else {
                                                        $.each(res.departments_name, function (key, value) {
                                                            $("#ddl_department").append('<option value="' + value.id + '">' + value.name + '</option>');
                                                        });
                                                    }
                                                }
//===========================================================================================================================
                                                if (res.departments_lead_name) {
                                                    if (((res.departments_lead_name).length) == "1") {
                                                        $("#dd_department_lead").empty();
                                                        $.each(res.departments_lead_name, function (key1, value1) {
                                                            $("#dd_department_lead").append('<option value="' + value1.id + '" selected="">' + value1.name + '</option>');
                                                        });
                                                    } else {
                                                        $.each(res.departments_lead_name, function (key1, value1) {
                                                            $("#dd_department_lead").append('<option value="' + value1.id + '">' + value1.name + '</option>');
                                                        });
                                                    }
                                                }
//===========================================================================================================================
                                                if (res.team_lead_name) {
                                                    if (((res.team_lead_name).length) == "1") {
                                                        $("#ddl_team_lead").empty();
                                                        $.each(res.team_lead_name, function (key2, value2) {
                                                            $("#ddl_team_lead").append('<option value="' + value2.id + '" selected="">' + value2.name + '</option>');
                                                        });
                                                    } else {
                                                        $("#ddl_team_lead").empty();
                                                        $.each(res.team_lead_name, function (key2, value2) {
                                                            $("#ddl_team_lead").append('<option value="' + value2.id + '">' + value2.name + '</option>');
                                                        });
                                                    }
                                                }
//===========================================================================================================================
                                                if (res.hr_name) {
                                                    if (((res.hr_name).length) == "1") {

                                                        $("#dd_hr").empty();
                                                        $.each(res.hr_name, function (key3, value3) {
                                                            $("#dd_hr").append('<option value="' + value3.id + '" selected="">' + value3.name + '</option>');
                                                        });
                                                    } else {
                                                        $.each(res.hr_name, function (key3, value3) {
                                                            $("#dd_hr").append('<option value="' + value3.id + '">' + value3.name + '</option>');
                                                        });
                                                    }
                                                }
//===========================================================================================================================
                                                $('select').formSelect();
                                            }
                                        }
                                    });
                                }
                            });


                            jQuery.datetimepicker.setLocale('en');
                            jQuery('#date_of_appointment').datetimepicker({
                                timepicker: false,
                                format: 'Y-m-d',
                                minDate: 1,
                                defaultDate: new Date(),
                                formatDate: 'Y-m-d',
                                scrollInput: false
                            });
                            jQuery('#date_of_resignation').datetimepicker({
                                timepicker: false,
                                format: 'Y-m-d',
                                minDate: 1,
                                defaultDate: new Date(),
                                formatDate: 'Y-m-d',
                                scrollInput: false
                            });
                            jQuery('#date_of_increment').datetimepicker({
                                timepicker: false,
                                format: 'Y-m-d',
                                minDate: 1,
                                defaultDate: new Date(),
                                formatDate: 'Y-m-d',
                                scrollInput: false

                            });
                            jQuery('#dob').datetimepicker({
                                timepicker: false,
                                format: 'Y-m-d',
                                maxDate: 0,
                                defaultDate: new Date(),
                                formatDate: 'Y-m-d',
                                scrollInput: false
                            });
                            jQuery('.date').datetimepicker({
                                timepicker: false,
                                format: 'Y-m-d',
                                minDate: 1,
                                defaultDate: new Date(),
                                formatDate: 'Y-m-d',
                                scrollInput: false
                            });



                            $('.rmv').click(function () {
                                var id = $(this).data("id");
                                var password_details = $(this).data("name");
                                var token = $("meta[name='csrf-token']").attr("content");
                                $.ajax({
                                    url: '/emp/removedata/',
                                    type: 'get',
                                    data: {
                                        "_token": token,
                                        'id': id,
                                        'delete': password_details,
                                    },
                                    success: function (result) {
                                        swal("Record has been deleted!", {
                                            icon: "success",
                                        }).then(function () {
                                            location.reload();
                                        });
                                    }
                                });
                            });

                        });
</script>
<script type="text/javascript">
    function send_document_mail()
    {
        var agreeement_id = $("#agreeement_id").val();
        var email_id = $("#email_id").val();
        var agriemnt_note_send = $("#agriemnt_note_send").val();
        var token = $("meta[name='csrf-token']").attr("content");

        $.ajax({
            url: '/emp/sendDocument_email/',
            type: 'get',
            data: {
                "_token": token,
                'agreeement_id': agreeement_id,
                'email_id': email_id,
                'agriemnt_note_send': agriemnt_note_send,
            },
            success: function (res) {
                swal("Agreement Document Send to Employee has been sent Successfully", {
                    icon: "success",
                }).then(function () {
                    location.reload();
                });
            }
        });
    }
</script>
@endsection



{{-- layout extend --}}

@extends('layouts.contentLayoutMaster')

{{-- page Title --}}
@section('title','Vehicle Managment')

{{-- vendor styles --}}
@section('vendor-style')
<link rel="stylesheet" type="text/css" href="{{asset('vendors/flag-icon/css/flag-icon.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/materialize.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('css/pages/form-select2.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/select2/select2.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/select2/select2-materialize.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/dropify/css/dropify.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('js/ajax/jquery-datetimepicker/jquery.datetimepicker.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('js/ajax/jquery-datetimepicker/jquery.datetimepicker.min.css')}}">
@endsection


{{-- page content --}}
@section('content')

<div class="card">
    <div class="card-content">
        <h5 class="title-color"><span>Update Vehicle</span></h5>
        <form  action="{{route('vehicles.update',['id' => $vehicles->id])}}" method="post" id="formValidateEdit">
            {{csrf_field()}}
            <input type="hidden" id="vehicles_id" name="vehicles_id" value="<?php echo $vehicles->id ?>">
            <div class="row">
                <div class="input-field col s3">
                    <label>Vehicle User *</label>
                    <input type="text" name="name" placeholder="Enter Vehicle User" value="{{$vehicles->name}}" data-error=".errorTxt1" />
                    <div class="errorTxt1"></div>
                </div>
                <div class="input-field col s3">
                    <label>Rate per Km*</label>
                    <input type="number" oninput="this.value = !!this.value && Math.abs(this.value) >= 0 ? Math.abs(this.value) : null"  name="rate_per_km" placeholder="Enter Rat Km" value="{{$vehicles->rate_per_km}}" data-error=".errorTxt2" />
                    <div class="errorTxt2"></div>
                </div>
                <div class="input-field col s3"> 
                    <label>Expiry Date of Vehicle Banding Permit</label>
                    <input type="text"  class="date" name="expiry_date_permit" id="expiry_date_permit" value="{{$vehicles->expiry_date_permit}}" placeholder="Select Expiry Date of Vehicle Banding Permit" >
                </div> 
                <div class="input-field col s3"> 
                    <label>Contract to Shift</label>
                    <input type="text"  class="date" name="contract_to_shift" id="contract_to_shift" value="{{$vehicles->contract_to_shift}}" placeholder="Select Contract to Shift" >
                </div> 
            </div>
            <div class="row">
                <div class="input-field col s3"> 
                    <label>Registration Date</label>
                    <input type="text"  class="date" name="registration_date" id="registration_date" value="{{$vehicles->registration_date}}" placeholder="Select Registration Date" >
                </div> 
                <div class="input-field col s3"> 
                    <label>Insurance Date</label>
                    <input type="text" class="date" name="insurance_date" id="insurance_date" value="{{$vehicles->insurance_date}}" placeholder="Select Insurance Date" >
                </div> 
                <div class="input-field col s3">
                    <label>Sticker Number </label>
                    <input type="number" oninput="this.value = !!this.value && Math.abs(this.value) >= 0 ? Math.abs(this.value) : null"  name="sticker_number" id="sticker_number" value="{{$vehicles->sticker_number}}" placeholder="Enter Sticker Number " />
                </div>
                <div class="input-field col s3"> 
                    <label>Next Service Date </label>
                    <input type="text" class="date" name="next_service_date" id="next_service_date" value="{{$vehicles->next_service_date}}" placeholder="Select Next Service Date" >
                </div> 
                <div class="input-field col s3"> 
                    <label>Handover Date </label>
                    <input type="text" class="date" name="handover_date" id="handover_date" placeholder="Select Handover Date" value="{{$vehicles->handover_date}}">
                </div>
                <div class="input-field col s3"> 
                    <label>Surrender Date</label>
                    <input type="text" class="date" name="surrender_date" id="surrender_date" placeholder="Select Handover Date" value="{{$vehicles->surrender_date}}">
                </div>
            </div>

            <div class="row">

                <div class="input-field col s3">
                    <select id="is_active" name="is_active" data-error=".errorTxt3">
                        <option value="" disabled="" >Select Status</option>
                        <option value="0" {{ $vehicles->is_active=='0' ? ' selected="" ' : '' }} > Active  </option>
                        <option value="1" {{ $vehicles->is_active=='0' ? 'Active' : ' selected="" ' }}>Inactive </option>
                    </select>
                    <label>Select Status</label>
                    <div class="errorTxt3"></div>
                </div>
            </div>
            <div class=" ">
                <h5 class="card-title">
                    Month by Month Mileage
                    <a class="pass_type_add_btn">
                        <i class="material-icons">add_circle_outline</i>
                    </a>
                </h5>
                <div id="password_type">
                    <?php foreach ($vehiclesMailageMaster as $key => $val) { ?>
                        <div class="row">
                            <div class="pass_type" style=" border: 0px solid red;">
                                <div class="col"><span class="material-icons rmv"  data-id="{{ $val->id }}" style="margin-top: 13px;">delete</span></div>
                                <div class="col s3"><label>Month Name</label>
                                    <input type="text" name="month_name[]" id="month_name" class="" placeholder="Enter Month Name" value="{{$val->month_name}}" />
                                </div>
                                <div class="col s2"> 
                                    <label>To Date</label>
                                    <input type="text" class="date" name="to_date[]" placeholder="To Date" value="{{$val->to_date}}">
                                </div>
                                <div class="col s2"> 
                                    <label>From Date</label>
                                    <input type="text" class="date" name="from_date[]" placeholder="From Date" value="{{$val->from_date}}">
                                </div> 
                                <div class="col s2"> 
                                    <label>Current Mileage</label>
                                    <input name="current_mileage[]" id="current_mileage" value="{{$val->current_mileage}}" type="number" oninput="this.value = !!this.value && Math.abs(this.value) >= 0 ? Math.abs(this.value) : null" ">
                                </div> 
                                <div class="col s2"><label>Note</label>
                                    <input type="text"  name="vehicles_note[]" id="vehicles_note" value="{{$val->vehicles_note}}"  class="" placeholder="Note" autofocus="off" autocomplete="off" />
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>   
            </div>
            <div class="row">
                <div class="col s12 display-flex justify-content-end form-action">
                    <button type="submit" name="action" class="btn btn-color mr-1">Update
                        <i class="material-icons right">send</i>
                    </button>
                    <button type="reset" class="btn btn-color mb-1" onclick="goBack();">
                        <i class="material-icons right">settings_backup_restore</i>Cancel
                    </button>
                </div>
            </div>
        </form>
    </div>
</div> 



@endsection

{{-- vendor script --}}
@section('vendor-script')
<script src="{{asset('js/ajax/jquery.min.js')}}"></script>
<script src="{{asset('js/materialize.js')}}"></script>
<script src="{{asset('js/ajax/jquery.validate.min.js')}}"></script>
@endsection

{{-- page script --}}
@section('page-script')

<script src="{{asset('js/vehicles/edit.js')}}"></script>

<script type="text/javascript">

                        $(document).ready(function () {

                            $('.rmv').click(function () {
                                var id = $(this).data("id");
                                var password_details = $(this).data("name");
                                var token = $("meta[name='csrf-token']").attr("content");
                                $.ajax({
                                    url: '/vehicles/mailage_remove',
                                    type: 'get',
                                    data: {
                                        "_token": token,
                                        'id': id,
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


                            jQuery.datetimepicker.setLocale('en');
                            jQuery('.date').datetimepicker({
                                timepicker: false,
                                format: 'Y-m-d',
                                minDate: 1,
                                defaultDate: new Date(),
                                formatDate: 'Y-m-d',
                                scrollInput: false
                            });
                        });
                        var count = 1;
                        $(document).on('click', '.pass_type_add_btn', function () {
                            dynamic_field_password_typ(count);
                            function dynamic_field_password_typ(number) {
                                var html = '';
                                html += '<div class="row">';
                                html += ' <div class="pass_type" style=" border: 0px solid red;">';
                                html += '<div class="col"><span class="material-icons remove_password" style="margin-top: 13px;">delete</span></div>';
                                html += '<div class="col s3"><label>Month Name</label>';
                                html += '<input type="text" name="month_name[]" id="month_name" class="" placeholder="Enter Month Name" autofocus="off" autocomplete="off" />';
                                html += '</div>';
                                html += '<div class="col s2"> ';
                                html += '<label>From Date</label>';
                                html += '<input type="text" class="date" name="from_date[]" placeholder="From Date">';
                                html += '</div> ';
                                html += '<div class="col s2"> ';
                                html += '<label>To Date</label>';
                                html += '<input type="text" class="date" name="to_date[]" placeholder="To Date">';
                                html += '</div>';
                                html += '<div class="col s2"> ';
                                html += '<label>Current Mileage</label>';
                                html += '<input name="current_mileage[]" id="current_mileage" type="number" oninput="this.value = !!this.value && Math.abs(this.value) >= 0 ? Math.abs(this.value) : null" ">';
                                html += '</div> ';
                                html += '<div class="col s2"><label>Note</label>';
                                html += '<input type="text"  name="vehicles_note[]" id="vehicles_note" class="" placeholder="Note" autofocus="off" autocomplete="off" />';
                                html += '</div>';
                                html += '</div>';
                                html += '</div>';
                                $('#password_type').append(html);
                                $('select').formSelect();
                                jQuery('.date').datetimepicker({
                                    timepicker: false,
                                    format: 'Y-m-d',
                                    minDate: 1,
                                    defaultDate: new Date(),
                                    formatDate: 'Y-m-d',
                                    scrollInput: false
                                });
                            }
                        });
                        $(document).on('click', '.remove_password', function () {
                            $(this).closest('div .pass_type').remove();
                        });


</script>
@endsection

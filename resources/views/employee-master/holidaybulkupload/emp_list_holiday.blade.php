{{-- layout extend --}}
@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title','Holiday Management')

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
        <h5 class="title-color"><span>Employee Holiday : {{$name}} </span></h5>
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
        <h5 class="card-title">
            <div class="row">
                <div class="col s5">
                    Holiday Details 
                    <a class="holiday_emp_add_btn">
                        <i class="material-icons">add_circle_outline</i>
                    </a>
                </div>
                <div class="col s7" style="text-align: end;">
                    <a href="{{route('empbulk.holidaybulkupload.index',['id'=>$emp_id])}}" class="btn btn-small pull-left rounded-pill mr-1">
                        <i class="material-icons left">file_upload</i>
                        Excel Upload Holidays 
                    </a>
                    <a href="{{route('emp.holidaysPdfView.upload',['id'=>$emp_id])}}" class="btn btn-small pull-left rounded-pill mr-1">
                        <i class="material-icons left">file_upload</i>
                        Upload Form
                    </a>
                </div>
            </div>
        </h5>

        <form id="frmHoliday" action="{{ route('emp.holidayupdate', $emp_id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div id="holiday_type_frm">
                <?php
                if ((count($holidaysDetails) > 0) && (count($holidaysDetails) != 0)) {

                    foreach ($holidaysDetails as $key => $holidays) {
                        ?>
                        <div class="row">
                            <div class="holiday_emp_type" style=" border: 0px solid red;">
                                <div class="col">
                                    <span class="material-icons rmv" data-id="{{ $holidays->id }}" data-name="holiday_details" style="margin-top: 13px;">delete</span>
                                </div>
                                <div class="col s3">
                                    <label>Holiday Name *</label>
                                    <input type="text" name="holiday_name[]" placeholder="Enter Holiday Name*" value="{{$holidays->holiday_name}}" data-error=".errorTxt1" required="" />
                                    <div class="errorTxt1"></div>
                                </div>
                                <div class="col s2">
                                    <label>Holiday Type *</label>
                                    <input type="text" name="holiday_type[]" placeholder="Enter Holiday Type*" value="{{$holidays->holiday_type}}"  data-error=".errorTxt2" required=""/>
                                    <div class="errorTxt2"></div>
                                </div>
                                <div class="col s3">
                                    <label>Holiday Date *</label>
                                    <input type="text" name="holiday_date[]" class="holiday_date" placeholder="Select Holiday Date*" value="{{$holidays->holiday_date}}" data-error=".errorTxt3" required=""/>
                                    <div class="errorTxt3"></div>
                                </div>
                                <div class="col s3">
                                    <label>Note</label>
                                    <input type="text" name="holiday_note[]" class="input-field" placeholder="Note" autofocus="off" autocomplete="off" value="{{$holidays->holiday_note}}" />
                                </div>
                                <br>
                            </div>
                        </div>
                        <?php
                    }
                } else {
                    echo 'No data available';
                }
                ?>

            </div>
            <div class="row0 " >
                <div class="col s12 display-flex justify-content-end form-action">
                    <button type="submit" class="btn indigo  waves-light mr-1">
                        Update Holiday
                    </button>
                </div>
            </div>
            <br>
            <br> 
            <?php if (count($holidaysPDFDetails) > 0) { ?>
                <h5 class="card-title">
                    Holiday PDF History 
                </h5>
                <div id="upload_document_type">
                    <div class="row">
                        <div class="doc_type" style=" border: 0px solid red;">
                            <?php
                            foreach ($holidaysPDFDetails as $key => $valuePDF) {
                                if ($valuePDF->file_extension == "pdf") {
                                    ?>
                                    <div class="col s2" style="text-align: center;">
                                        <a target="_bl ank" href="/public/uploads/hherp/holidayPDF/{{$emp_id}}/{{$valuePDF->document_file}}">
                                            <img src="https://upload.wikimedia.org/wikipedia/commons/8/87/PDF_file_icon.svg" height="50" width="50"/>
                                        </a>
                                        <input style="    text-align: center;" disabled="" value="{{$valuePDF->upload_date}}" />
                                        <span class="material-icons rmvPDF" data-id="{{ $valuePDF->id }}" data-name="holiday_details" style="margin-top: 13px;">delete</span>

                                    </div>
                                <?php } else if ($valuePDF->file_extension == "xlsx") { ?>
                                    <div class="col s2" style="text-align: center;">
                                        <a target="_bl ank" href="/public/uploads/hherp/holidayPDF/{{$emp_id}}/{{$valuePDF->document_file}}">
                                            <img src="https://cdn3.iconfinder.com/data/icons/document-icons-2/30/647702-excel-512.png" height="50" width="50"/>
                                        </a>
                                        <input style="    text-align: center;" disabled="" value="{{$valuePDF->upload_date}}" />
                                        <span class="material-icons rmvPDF" data-id="{{ $valuePDF->id }}" data-name="holiday_details" style="margin-top: 13px;">delete</span>

                                    </div>
                                <?php } else if ($valuePDF->file_extension == "docx") { ?>

                                    <div class="col s2" style="text-align: center;">
                                        <a target="_bl ank" href="/public/uploads/hherp/holidayPDF/{{$emp_id}}/{{$valuePDF->document_file}}">
                                            <img src="https://cdn4.iconfinder.com/data/icons/logos-and-brands/512/381_Word_logo-512.png" height="50" width="50"/>
                                        </a>
                                        <input style="    text-align: center;" disabled="" value="{{$valuePDF->upload_date}}" />
                                        <span class="material-icons rmvPDF" data-id="{{ $valuePDF->id }}" data-name="holiday_details" style="margin-top: 13px;">delete</span>

                                    </div>
                                <?php } else { ?>

                                    <div class="col s2" style="text-align: center;">
                                        <a target="_bl ank" href="/public/uploads/hherp/holidayPDF/{{$emp_id}}/{{$valuePDF->document_file}}">
                                            <img src="/public/uploads/hherp/holidayPDF/{{$emp_id}}/{{$valuePDF->document_file}}" height="50" width="50"/>
                                        </a>
                                        <input style="    text-align: center;" disabled="" value="{{$valuePDF->upload_date}}" />
                                        <span class="material-icons rmvPDF" data-id="{{ $valuePDF->id }}" data-name="holiday_details" style="margin-top: 13px;">delete</span>

                                    </div>
                                <?php } ?>



                            <?php } ?>
                            <br>
                        </div>
                    </div>
                </div>
            <?php } ?>
            
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
<script src="{{asset('js/employee-master/holidys/holiday')}}"></script>



@endsection

{{-- page scripts --}}
@section('page-script')
<script type="text/javascript">
var count = 1;
$(document).on('click', '.holiday_emp_add_btn', function () {

    dynamic_field_password_typ(count);
    function dynamic_field_password_typ(number) {
        var html = '';
        html += '<div class="row">';
        html += '<div class="holiday_emp_type" style=" border: 0px solid red;">';
        html += '<div class="col">';
        html += '<span class="material-icons remove_password" data-name="holiday_details" style="margin-top: 13px;">delete</span>';
        html += '</div>';
        html += '<div class="col s3">';
        html += '<label>Holiday Name *</label>';
        html += '<input type="text" name="holiday_name[]" id="holiday_name" placeholder="Enter Holiday Name*"  />';
        html += '</div>';
        html += '<div class="col s2">';
        html += '<label>Holiday Type *</label>';
        html += '<input type="text" name="holiday_type[]" id="holiday_type" placeholder="Enter Holiday Type*"  />';
        html += '</div>';
        html += '<div class="col s3">';
        html += '<label>Select Holiday Date *</label>';
        html += '<input type="text" name="holiday_date[]" id="holiday_date" class="holiday_date" placeholder="Select Holiday Date*"  />';
        html += '</div>';
        html += '<div class="col s3">';
        html += '<label>Note</label>';
        html += '<input type="text" name="holiday_note[]" id="holiday_note" class="input-field" placeholder="Note" autofocus="off" autocomplete="off" />';
        html += '</div>';
        html += '<br>';
        html += '</div>';
        html += '</div>';
        $('#holiday_type_frm').append(html);
        $('select').formSelect();
        jQuery.datetimepicker.setLocale('en');
        jQuery('.holiday_date').datetimepicker({
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
    $(this).closest('div .holiday_emp_type').remove();
});</script>
<script type="text/javascript">


    $(document).ready(function () {
        jQuery.datetimepicker.setLocale('en');
        jQuery('.holiday_date').datetimepicker({
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
            var name = 'Candidates';
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
                    location.reload();
//                        swal("Record has been deleted!", {
//                            icon: "success",
//                        }).then(function () {
                    // location.reload();
//                        });
                }
            });
        });
        $('.rmvPDF').click(function () {
            var id = $(this).data("id");
            var token = $("meta[name='csrf-token']").attr("content");
            swal({
                title: "Are you sure, you want to delete Holiday Form?",
                icon: 'warning',
                dangerMode: true,
                buttons: {
                    cancel: 'No, Please!',
                    delete: 'Yes, Delete It'
                }
            }).then(function (willDelete) {
                if (willDelete) {
                    $.ajax({
                        url: '/emp/removedata/',
                        type: 'get',
                        data: {
                            "_token": token,
                            'id': id,
                            'delete': 'employee_holiday_pdf',
                        },
                        success: function (result) {
                            swal("Record has been deleted!", {
                                icon: "success",
                            }).then(function () {
                                location.reload();
                            });
                        }
                    });
                } else {
//                swal(name + " Record is safe", {
//                    title: 'Cancelled',
//                    icon: "error",
//                });
                }
            });
        });
    });
</script>
@endsection

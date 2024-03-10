{{-- layout --}}
@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title','Employee Management')

{{-- vendor styles --}}
@section('vendor-style')

<link rel="stylesheet" type="text/css" href="{{ asset('vendors/flag-icon/css/flag-icon.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('vendors/data-tables/css/jquery.dataTables.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('vendors/data-tables/extensions/responsive/css/responsive.dataTables.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('vendors/data-tables/css/select.dataTables.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('css/datatable/colReorder.dataTables.min.css') }} ">
<link rel="stylesheet" type="text/css" href="{{ asset('css/datatable/buttons.dataTables.min.css') }} ">
<link rel="stylesheet" type="text/css" href="{{ asset('css/pages/data-tables.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('css/pages/form-select2.css') }}">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.4/jspdf.min.js"></script>


@endsection


@section('content')
<div class="section section-data-tables">
    <div class="card">
        <div class="card-content">
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
            <div class="row">
                <div class="col s12 m6 l6">
                    <h5 class="title-color"><span>Employee Management</span></h5>
                </div>
            </div>
            @include('employee-master._filter_employee')
            <!-- Page Length Options -->
            <div class="section section-data-tables">
                <div class="row">
                    <div class="col s12">
                        <div class="  ">
                            <div class="row">
                                <div class="col s12">

                                    <table id="page-length-option" class="display multiselect">
                                        <thead>
                                            <tr>
                                                <th class="sorting_disabled" width="4%">
                                                    <label>
                                                        <input type="checkbox" class="select-all"/>
                                                        <span></span>
                                                    </label>
                                                </th>
                                                <th class="sorting_disabled" width="8%">Action</th>
                                                <th class="sorting_disabled">Off. letter</th>
                                                <th>#ID</th>
                                                <th>Name</th>
                                                <th>DOB</th>
                                                <th>Email Id</th>
                                                <th>Recruiter</th>
                                                <th>Date of Barth</th>
                                                <th>Date Of Appointment</th>
                                                <th>Date Of Increment</th>
                                                <th>HR</th>
                                                <th>Team</th>
                                                <th>Department</th>
                                                <th>Designation</th>
                                                <th>Contact No</th>
                                                <?php if (Auth::id() == '1') { ?>
                                                    <th>Salary</th>
                                                <?php } ?>
                                                <th>Holidays</th>
                                                <th>Account Name</th>
                                                <th>Manager Name</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($employee_details as $key => $detaile)
                                            <tr>
                                                <td width="4%">
                                                    <label>
                                                        <input type="checkbox" data-id="{{ $detaile->id }}"
                                                               name="selected_row"/>
                                                        <span></span>
                                                    </label>
                                                </td>
                                                <td width="8%">
                                                    <a href="{{ route('emp.view', $detaile->id) }}"
                                                       class="tooltipped mr-10"
                                                       data-position="top"
                                                       data-tooltip="view">
                                                        <span class="material-icons">visibility</span>
                                                    </a>
                                                    <a href="{{ route('emp.edit', $detaile->id) }}"
                                                       class="tooltipped mr-10"
                                                       data-position="top"
                                                       data-tooltip="Edit">
                                                        <span class="material-icons">edit</span>
                                                    </a>
                                                    <a href="{{ route('emp.delete_', $detaile->id) }}"
                                                       class="tooltipped mr-10 delete-record-click"
                                                       data-position="top"
                                                       data-tooltip="Delete" data-id="{{ $detaile->id }}">
                                                        <span class="material-icons">delete</span>
                                                    </a>
                                                </td>
                                                <td>
                                                    <a href="{{ route('emp.send_mail_offer_latter', $detaile->user_id) }}"
                                                       class="tooltipped mr-10 send_mail_button"
                                                       data-position="top"
                                                       data-tooltip="send">
                                                        <span class="material-icons dp48">email</span>
                                                    </a>
                                                    <a href="{{ route('emp.download_pdf', $detaile->user_id) }}"
                                                       class="tooltipped mr-10 download_button"
                                                       data-position="top"
                                                       data-tooltip="Download PDF">
                                                        <span class="material-icons dp48">picture_as_pdf</span>
                                                    </a>
                                                </td> 
                                                <td width="2%"> <center>{{$key+1}}</center> </td>
                                        <td> 
                                            <u>
                                                <a href="{{ route('emp.view', $detaile->id) }}"
                                                   class="tooltipped mr-10"
                                                   data-position="top"
                                                   data-tooltip="Employee Summary">
                                                    {{$detaile->name}}
                                                </a>
                                            </u>
                                        </td>

                                        <td>{{$detaile->dob}}</td>
                                        <td>{{strtolower($detaile->email)}}</td>
                                        <td>
                                            <?php echo app('App\Http\Controllers\Controller')->getConditionDynamicNameTable('recruiter', 'id', $detaile->recruiter, 'name'); ?>
                                        </td>
                                        <td>
                                            {{strtolower($detaile->dob)}}
                                        </td>
                                        <td>
                                            {{strtolower($detaile->date_of_appointment)}}
                                        </td>
                                        <td>
                                            {{strtolower($detaile->date_of_increment)}}
                                        </td>
                                        <td>
                                            <?php echo app('App\Http\Controllers\Controller')->getConditionDynamicNameTable('employees', 'id', $detaile->hr, 'Name'); ?>
                                        </td>
                                        <td>
                                            <?php echo app('App\Http\Controllers\Controller')->getConditionDynamicNameTable('teams', 'id', $detaile->team, 'Name'); ?>
                                        </td>
                                        <td>
                                            <?php echo app('App\Http\Controllers\Controller')->getConditionDynamicNameTable('departments', 'id', $detaile->department, 'Name'); ?>
                                        </td>
                                        <td>
                                            <?php echo app('App\Http\Controllers\Controller')->getConditionDynamicNameTable('designations', 'id', $detaile->designation, 'Name'); ?>
                                        </td>
                                        <td>{{$detaile->contact_no}}</td>
                                        <?php if (Auth::id() == '1') { ?>
                                            <td>{{$detaile->salary}}</td>
                                        <?php } ?>
                                        <td>
                                            <?php
                                            $daa = app('App\Http\Controllers\Controller')->getConditionDynamicTableAll('apiemp_holidays_master', 'emp_id', $detaile->id);
                                            if (count($daa) > 0) {
                                                ?>
                                                <a href="{{ route('emp.holidayshow', $detaile->id) }}">
                                                    show
                                                </a>
                                            <?php } else { ?>
                                                <a href="{{route('empbulk.holidaybulkupload.index',['id'=>$detaile->id])}}">
                                                    <i class="material-icons left">file_upload</i>
                                                </a>
                                            <?php } ?>
                                        </td>
                                        <td>
                                            <?php echo app('App\Http\Controllers\Controller')->getConditionDynamicNameTable('employees', 'user_id', $detaile->account_id, 'name'); ?>
                                        </td>
                                        <td>
                                            <?php echo app('App\Http\Controllers\Controller')->getConditionDynamicNameTable('employees', 'user_id', $detaile->manager_id, 'name'); ?>
                                        </td>
                                        <td>
                                            <?php if ($detaile->employee_status == 0) { ?>
                                                Active
                                            <?php } else { ?>
                                                Inactive
                                            <?php } ?>
                                        </td>
                                        </tr>

                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
{{-- vendor script --}}
@section('vendor-script')

<script src = "{{ asset('js/ajax/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('js/ajax/datatables/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('vendors/data-tables/js/dataTables.select.min.js') }}"></script>
<script src="{{ asset('vendors/select2/select2.full.min.js') }}"></script>
<!-- END THEME  JS-->
<script src="{{ asset('js/scripts/data-tables.js') }}"></script>
<script src="https://cdn.datatables.net/colreorder/1.5.2/js/dataTables.colReorder.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.colVis.min.js"></script>

<!-- BEGIN PAGE LEVEL JS-->
<script src="{{ asset('js/scripts/extra-components-sweetalert.js') }}"></script>
<script src="{{ asset('js/scripts/form-select2.js') }}"></script>
<script src="{{ asset('js/scripts/ui-alerts.js') }}"></script>
<script src="{{ asset('js/download-table.js') }}"></script>
@endsection


{{-- page script --}}
@section('page-script')
<script>


ddl_filter();
function ddl_filter() {
    var cid = $(".ddl_filter option:selected").val();
    //alert(cid);
    if (cid == "dob") {
        $(".filter").show();
    } else if (cid == "date_of_appointment") {
        $(".filter").show();
    } else if (cid == "date_of_increment") {
        $(".filter").show();
    } else if (cid == "0") {
        $(".filter").hide();
    } else {
        $(".filter").hide();
    }
}
$(document).ready(function () {


//    $('.ddl_filter').change(function () {
//        var cid = $(this).val();
//        alert(cid);
//
//        $(".filter").show();
//    }
//    );
    jQuery('.date').datetimepicker({
        timepicker: false,
        format: 'Y-m-d',
        minDate: 1,
        defaultDate: new Date(),
        formatDate: 'Y-m-d',
        scrollInput: false
    });
    $('.collapsible').collapsible({
        accordion: true
    });
    $('#mass_delete_id').click(function () {
        var checkbox_array = [];
        var token = $("meta[name='csrf-token']").attr("content");
        $.each($("input[name='selected_row']:checked"), function () {
            checkbox_array.push($(this).data("id"));
        });
// console.log(checkbox_array);
        if (typeof checkbox_array !== 'undefined' && checkbox_array.length > 0) {

            swal({
                title: "Are you sure, You will not be able to recover these record!",
                icon: 'warning',
                dangerMode: true,
                buttons: {
                    cancel: 'No, Please!',
                    delete: 'Yes, Delete It'
                }
            }).then(function (willDelete) {
                if (willDelete) {
                    $.ajax({
                        url: '/emp/massremove/',
                        mehtod: "get",
                        data: {
                            "_token": token,
                            id: checkbox_array
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
//                    swal(name + " Record is safe", {
//                        title: 'Cancelled',
//                        icon: "error",
//                    });
                }
            });
        } else {
//            swal({
//                title: "0 Row selected!",
//                text: "Select any record from the list",
//                icon: 'warning',
//            });
        }
    });
    var checkbox = $('.multiselect tbody tr td input');
    var selectAll = $('.multiselect .select-all');
    checkbox.on('click', function () {
// console.log($(this).attr("checked"));
        $(this).parent().parent().parent().toggleClass('selected');
    });
    checkbox.on('click', function () {
// console.log($(this).attr("checked"));
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
    $('.delete-record-click').click(function () {
        var id = $(this).data("id");
        var name = 'Employee';
        var token = $("meta[name='csrf-token']").attr("content");
        swal({
            title: "Are you sure, you want to delete " + name.substring(0, name.length - 1) + "/s ?",
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
                        'delete': 'employee_details',
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


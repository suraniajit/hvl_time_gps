{{-- layout --}}
@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title','User Profile Page')

{{-- vendor styles --}}
@section('vendor-style')
{{--Calendar--}}
<link rel="stylesheet" type="text/css" href="{{asset('vendors/select2/select2.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/select2/select2-materialize.css')}}">

<link rel="stylesheet" type="text/css" href="{{ asset('vendors/flag-icon/css/flag-icon.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('css/datatable/colReorder.dataTables.min.css') }} ">
<link rel="stylesheet" type="text/css" href="{{ asset('css/datatable/buttons.dataTables.min.css') }} ">

<link rel="stylesheet" type="text/css" href="{{asset('vendors/fullcalendar/daygrid/daygrid.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/fullcalendar/timegrid/timegrid.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/fullcalendar/css/fullcalendar.min.css')}}">

<link rel="stylesheet" type="text/css" href="{{asset('css/pages/page-account-settings.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/materialize.min.css')}}">


@endsection

{{-- page style --}}
@section('page-style')
<style>
    .task-cat {
        padding: 9px 7px;
        /*font-size: 1.0rem;*/
    }

    .time {
        /*        padding-left: 1% !important;
                padding-right: 1% !important;*/
    }

    .btn-text {
        margin-left: 5px !important;
    }

    #rel {
        margin-top: 2%;
    }

    .badge {
        position: initial !important;
    }
    .image123{
        color: #ff5a92;
        font-size: 12px;
    }
    .title-color{
        font-size: 23px !important;
    }
</style>
<link rel="stylesheet" type="text/css" href="{{asset('css/pages/app-calendar.css')}}">
@endsection

{{-- page content --}}
@section('content')
<div class="section">
    @if ($message = Session::get('success'))
    <div class="card-alert card green lighten-5" id="message">
        <div class="card-content green-text">
            <p>{{ $message }}</p>
        </div>
        <button type="button" class="close green-text close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
    </div>
    @elseif($message = Session::get('error'))
    <div class="card-alert card red lighten-5" id="message">
        <div class="card-content red-text">
            <p>{{ $message }}</p>
        </div>
        <button type="button" class="close red-text close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
    </div>
    @endif
    <!--success message end-->
    <!-- Account settings -->
    <section class="tabs-vertical mt-0 section">
        <div class="row">
            <?php if (Session::get('user_id') == '1') { ?>
                @include('user-profile._admin-profile')
            <?php } else { ?>
                <div class="col s3">
                    <!-- tabs  -->
                    <div class="card-panel">
                        <ul class="tabs">
                            <?php if (Session::get('user_id') == '1') { ?>
                                <li class="tab ">
                                    <a href="#general" class="menu-color">
                                        <i class="material-icons">brightness_low</i>
                                        <span class="">My Info</span>
                                    </a>
                                </li>
                            <?php } else { ?>
                                <li class="tab ">
                                    <a href="#general" class="menu-color">
                                        <i class="material-icons">brightness_low</i>
                                        <span class="">My Info</span>
                                    </a>
                                </li>
                                <li class="tab" style="display: none;">
                                    <a href="#Calendar-View" class="cal" >
                                        <i class="material-icons">brightness_low</i>
                                        <span>Absence Request</span>
                                    </a>
                                </li>
                                <li class="tab">
                                    <a href="#my_expance_action" class="">
                                        <i class="material-icons">lock_open</i>
                                        <span class="">My Expense</span>
                                    </a>
                                </li>

                                <li class="tab" style="display: none;">
                                    <a href="#Leave-Summary" class="">
                                        <i class="material-icons">lock_open</i>
                                        <span class="">Leave Summary</span>
                                    </a>
                                </li>
                                <li class="tab" style="display: none;">
                                    <a href="#MyCourses" class="">
                                        <i class="material-icons">chat_bubble_outline</i>
                                        <span class="">My Courses</span>
                                    </a>
                                </li>

                                <li class="tab">
                                    <a href="#MyTeam">
                                        <i class="material-icons">link</i>
                                        <span class="">My Team</span>
                                    </a>
                                </li>

                                <li class="tab" style="display: none;">
                                    <a href="#MyRequest">
                                        <i class = "material-icons">link</i>
                                        <span class = "">My Request</span>
                                    </a>
                                </li>
                                <li class="tab" style="display: none;">
                                    <a href="#penalty">
                                        <i class="material-icons">link</i>
                                        <span class="">penalty</span>
                                    </a>
                                </li>
                                <li class="tab">
                                    <a href="#holiday">
                                        <i class="material-icons">link</i>
                                        <span class="">Holiday</span>
                                    </a>
                                </li>
                                <li class="tab">
                                    <a href="#attendance">
                                        <i class="material-icons">brightness_low</i>
                                        <span>Attendance</span>
                                    </a>
                                </li>
                                <li class="tab">
                                    <a href="#leaveApproveLead">
                                        <i class="material-icons">brightness_low</i>
                                        <span>Leave Approve Lead</span>
                                    </a>
                                </li>
                                <li class="tab">
                                    <a href="#leaveApproveHR">
                                        <i class="material-icons">brightness_low</i>
                                        <span>Leave Approve HR</span>
                                    </a>
                                </li>
                                <li class="tab" style="display: none;">
                                    <a href="#TraninerAudioCheck">
                                        <i class="material-icons">brightness_low</i>
                                        <span>Course's Audio</span>
                                    </a>
                                </li>
                                <li class="tab">
                                    <a href="#lead_approval">
                                        <i class="material-icons">brightness_low</i>
                                        <span>Lead Approval</span>
                                    </a>
                                </li>
                                <li class="tab" style="display: none;">
                                    <a href="#salary_history">
                                        <i class="material-icons">brightness_low</i>
                                        <span>Salary History</span>
                                    </a>
                                </li>
                                <li class="indicator" style="left: 0px; right: 0px;"></li>
                            </ul>

                        <?php } ?>
                    </div>
                </div>

            <?php } ?>

            <div class="col s9">
                <!-- tabs content -->
                <div id="general" class="active" style="display: block;">

                    <!--$users_roles_name[0]->user_role-->
                    <?php if (Session::get('user_id') == '1') { ?>
                        @include('user-profile._admin-profile')
                    <?php } else { ?>
                        @include('user-profile._user-profile')
                    <?php } ?>

                </div>

                <div id="my_expance_action" class="">
                    @include('user-profile._my_expance')
                </div>

                <div id="Leave-Summary" class="" style="display: none;">
                    @include('user-profile._leave-summary')
                </div>
                <div id="Calendar-View" style="display: none;">
                    @include('user-profile._calendar-view')
                </div>
                <div id="MyCourses" class="" style="display: none;">
                    @include('user-profile._my-courses')
                </div>
                <div id="MyTeam">
                    @include('user-profile._my-team')
                </div>
                <div id="MyRequest" style="display: none;">
                    @include('user-profile._my-request')
                </div>
                <div id="penalty" style="display: none;">
                    @include('user-profile._penalty')
                </div>

                <div id="holiday">
                    @include('user-profile._holiday')
                </div>
                <div id="attendance" style="display: none;">
                    @include('user-profile._attendance')
                </div>
                <div id="leaveApproveHR">
                    @include('user-profile._leaveApproveHR')
                </div>
                <div id="leaveApproveLead">
                    @include('user-profile._leaveApproveLead')

                </div>
                <div id="TraninerAudioCheck" style="display: none;">
                    @include('user-profile._tranier_audio_check')

                </div>
                <div id="lead_approval">
                    @include('user-profile._lead_Approve')

                </div>
                <div id="salary_history" style="display: none;">
                    @include('user-profile._employee_salary')

                </div>
            </div>
        </div>
    </section> 
</div>
@endsection


{{-- page scripts --}}
@section('vendor-script')
<script src="{{asset('vendors/select2/select2.full.min.js')}}"></script>
<script src="{{asset('vendors/jquery-validation/jquery.validate.min.js')}}"></script>

<script src="{{asset('js/ajax/jquery.min.js')}}"></script>
<script src="{{asset('js/ajax/angular.min.js')}}"></script>
<script src="{{asset('js/materialize.js')}}"></script>
<script src="{{asset('js/ajax/sweetalert.min.js')}}"></script>

<script src="{{asset('vendors/fullcalendar/js/fullcalendar.min.js')}}"></script>
<script src="{{asset('vendors/fullcalendar/daygrid/daygrid.min.js')}}"></script>
<script src="{{asset('vendors/fullcalendar/timegrid/timegrid.min.js')}}"></script>
<script src="{{asset('vendors/fullcalendar/interaction/interaction.min.js')}}"></script>

@endsection

{{-- page script --}}
@section('page-script')
<script src="{{asset('js/scripts/advance-ui-modals.js')}}"></script>
<script src="{{asset('js/scripts/page-account-settings.js')}}"></script>
<script src="{{asset('js/user-profile/index.js')}}"></script>
<script>
$(document).ready(function () {


    $('#select_file').bind('change', function () {
        //this.files[0].size gets the size of your file.
//        alert(this.files[0].size);
        if (this.files[0].size > 1000000) {
            alert("Allowed JPG, PNG. Max size of 1 MB Thanks!!");
            $(this).val('');
        }
    });

    $('#upload_form').on('submit', function (event) {
        event.preventDefault();
        $.ajax({
            url: "{{ route('ajaxupload.action') }}",
            method: "POST",
            data: new FormData(this),
            dataType: 'JSON',
            contentType: false,
            cache: false,
            processData: false,
            success: function (data)
            {
                $('#message').css('display', 'block');
                $('#message').html(data.message);
                $('#message').addClass(data.class_name);
                $('#uploaded_image').html(data.uploaded_image);
                location.reload();
            }
        })
    });



    jQuery('#to').datetimepicker({
        timepicker: false,
        format: 'Y-m-d',
        //        minDate: 0,
        //        defaultDate: new Date(),
        formatDate: 'Y-m-d',
        scrollInput: false

    });
    jQuery('#from').datetimepicker({
        timepicker: false,
        format: 'Y-m-d',
        //        minDate: 0,
        defaultDate: new Date(),
        formatDate: 'Y-m-d',
        scrollInput: false

    });

});
</script>
<style>
    /*    td, th {
            padding: 15px 5px;
            display: table-cell;
            text-align: center !important ;
            vertical-align: middle;
            border-radius: 2px;
        }*/
</style>



<script>
    function closer(closerId) {
//        alert(cityName);
        $("#" + closerId).modal('close');
    }
    myepanceTab(event, 'account_tab');
    function myepanceTab(evt, cityName) {
        var i, tabcontent, tablinks;
        tabcontent = document.getElementsByClassName("tabcontent");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }
        tablinks = document.getElementsByClassName("tablinks");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" active", "");
        }
        document.getElementById(cityName).style.display = "block";
        evt.currentTarget.className += " active";
    }
</script>
<script>
    $(document).ready(function () {
        $(".modal-overlay").css({"z-index": "0"});
    });
</script>


@endsection


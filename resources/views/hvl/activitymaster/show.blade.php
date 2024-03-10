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
                <li class="breadcrumb-item ">View Activity</li>
            </ul>
        </div>
    </div>
    <section>
        <div class="container-fluid">
            <div class="card">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show center-block" role="alert">
                        <strong>{!! Session::get('success') !!} </strong>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                <div class="card-body p-4">
                    <header>
                        <div class="row">
                            <div class="col-md-7">
                                <h2 class="h3 display"> Activity of: {{$customer_activity->customer_id}} </h2>
                            </div>
                        </div>

                    </header>

                    <div class="row">
                        <div class="form-group col-sm-6 col-md-4">
                            <label> Subject  </label>
                            <input type="text" name="subject" disabled class="form-control "  value="{{$customer_activity->subject}}">
                            <div class="errorTxt8 text-danger"></div>
                        </div>

                        <div class="form-group col-sm-6 col-md-4">
                            <label>Start Date </label>
                            <input type="text" disabled name="txt_start_date" id="txt_start_date" class="form-control" value="{{$customer_activity->start_date}}">
                            <div class="errorTxt6"></div>
                        </div>
                        <div class="form-group col-sm-6 col-md-4">
                            <label> End Date </label>
                            <input type="text" disabled name="txt_end_date" id="txt_end_date" class="form-control" data-error=".errorTxt7" placeholder="Enter Job Closing Date" autocomplete="off" autofocus="off" value="{{$customer_activity->end_date}}">

                            <div class="errorTxt7"></div>
                        </div>
                        @role('customers_admin')
                        @else 
                            @role('Operators')
                            @else 
                            <div class="form-group col-sm-6 col-md-4">
                                    <label>Per Service Value <span class="text-danger">*</span> </label>
                                    <input disabled type="number" name="services_value" required class="form-control" data-error=".errorTxtServiceValue" placeholder="Enter Service value" value="{{$customer_activity->services_value}}" autocomplete="off" autofocus="off">
                                    <div class="errorTxtServiceValue text-danger" ></div>
                            </div>
                            @endrole
                        @endrole
                        
                        <div class="form-group col-sm-6 col-md-4">
                            <label for="fn">Type</label>
                            <select class="form-control " disabled data-error=".errorTxt5" name="ddl_type" id="ddl_type">

                                @foreach($types as $type)
                                    <option value="{{$type->id}}" @if($type->id == $customer_activity->type) selected @endif>{{$type->Name}}</option>
                                @endforeach
                            </select>
                            <div class="errorTxt5"></div>
                        </div>

                        <div class="form-group col-sm-6 col-md-4">
                            <label for="fn">Status</label>
                            <select class="form-control" disabled data-error=".errorTxt5" name="ddl_status" id="ddl_status">
                                @foreach($statuses as $status)
                                    <option value="{{$status->id}}" @if($status->id == $customer_activity->status) selected @endif>{{$status->Name}}</option>
                                @endforeach
                            </select>
                            <div class="errorTxt5"></div>
                        </div>

                        <div class="form-group col-sm-6 col-md-4">
                            <label for="fn">Select frequency</label>
                            <select class="form-control " disabled data-error=".errorTxt5" name="ddl_frequency" id="ddl_frequency">
                                <option value="" disable="" selected>Select frequency</option>
                                <option value="daily" {{$customer_activity->frequency == "daily" ? 'selected' : ''}} >Daily</option>
                                <option value="weekly" {{$customer_activity->frequency == "Weekly" ? 'selected' : ''}} >Weekly</option>
                                <option value="monthly" {{$customer_activity->frequency == "monthly" ? 'selected' : ''}} >Monthly</option>
                                <option value="fortnightly" {{$customer_activity->frequency == "fortnightly" ? 'selected' : ''}} >Fortnightly</option>
                                <option value="bimonthly" {{$customer_activity->frequency == "bimonthly" ? 'selected' : ''}} >Bimonthly</option>
                                <option value="quarterly" {{$customer_activity->frequency == "quarterly" ? 'selected' : ''}} >Quarterly</option>
                                <option value="quarterly_twice" {{$customer_activity->frequency == "quarterly_twice" ? 'selected' : ''}} >Quarterly twice</option>
                                <option value="thrice_year" {{$customer_activity->frequency == "thrice_year" ? 'selected' : ''}} >Thrice in a Year</option>
                                <option value="onetime" {{$customer_activity->frequency == "onetime" ? 'selected' : ''}} >One Time</option>
                            </select>
                            <div class="errorTxt5"></div>
                        </div>


                        <div class="form-group col-sm-6 col-md-4">
                            <label for="fn">Created By</label>
                            <input type="text" class="form-control" disabled value="{{$customer_activity->created_by}}">
                        </div>

                        <div class="form-group col-sm-6 col-md-4">
                            <label> Actual Completion Date  </label>
                            <input type="text" name="complete_date" disabled class="form-control datepicker"  value="{{$customer_activity->complete_date}}">
                            <div class="errorTxt8 text-danger"></div>
                        </div>
                    </div>
                    
                    
                    <hr style="border: 1px solid red">

                    @can('Access Job Cards')
                        <div class="row">
                            <div class="col-sm-12 col-md-6">
                                <h3>Job Cards</h3>
                                @can('Create Job Cards')
                                <button type="button" class="btn btn-primary rounded p-1" data-toggle="modal" data-target="#modal">
                                    <span class="fa fa-upload"></span>Add Job Card
                                </button>
                                @endcan
                                @php
                                    $date = \Illuminate\Support\Facades\DB::table('hvl_job_cards')
                                            ->where('activity_id',$customer_activity->id)
                                            ->orderBy('id','DESC')
                                             ->value('added');

                                @endphp
                                @if(!empty($date))
                                <span class="pull-right badge badge-primary p-2">{{$date}}</span><h4 class="pull-right badge badge-primary p-2"> Job Card Update Date :</h4>
@endif
                            </div>
                            <div class="col-sm-12 col-md-12">
                                <div class="row">
                                    @foreach($jobcards as $jobcard)
                                        @if(!empty($jobcard->before_pic))
                                            <div class="col-sm-6 col-md-2 m-2">
                                                <label>Before Image</label>
                                                @can('Delete Job Cards')
                                                    <a href="" class="button pull-right" data-id="{{$jobcard->id}}"><span class="fa fa-close fa-lg "></span></a>
                                                @endcan
                                                <a href="{{$helper->getGoogleDriveImage($jobcard->before_pic)}}" target="_blank">
                                                    <img height="150" width="150" src="{{$helper->getGoogleDriveImage($jobcard->before_pic)}}">
                                                    {{$jobcard->before_pic}}
                                                </a>
                                                <br>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>

                            <br>

                            <div class="col-sm-12 col-md-12">
                                <div class="row">
                                    @foreach($jobcards as $jobcard)
                                        @if(!empty($jobcard->after_pic))
                                            <div class="col-sm-6 col-md-2 m-2">
                                                <label>After Image</label>
                                                @can('Delete Job Cards')
                                                    <a href="" class="button pull-right" data-id="{{$jobcard->id}}"><span class="fa fa-close fa-lg "></span></a>
                                                @endcan
                                                <a href="{{$helper->getGoogleDriveImage($jobcard->after_pic)}}" target="_blank">
                                                    <img height="150" width="150" src="{{$helper->getGoogleDriveImage($jobcard->after_pic)}}">
                                                    {{$jobcard->after_pic}}
                                                </a>
                                                <br>
                                            </div>
                                        @endif
                                    @endforeach

                                </div>
                            </div>
                        </div>
                    
                    <!--ajit-->
                    <div class="row">
                        <div class="form-group col-sm-6 col-md-6">
                            <lable>Branch</lable>
                            <input type="text" disabled  name="branch_name" id="branch_name" class="form-control-file">
                        </div>
                    </div>
                    <b>Customer Details</b>
                    <hr>
                    <div class="row">
                        <div class="form-group col-sm-6 col-md-6">
                            <lable>Site Name</lable>
                            <input type="text" disabled name="site_name" id="site_name"  class="form-control-file">
                        </div>
                        <div class="form-group col-sm-6 col-md-6">
                            <lable>Shipping Address</lable>
                            <textarea  disabled id="shipping_address"  class="form-control-file"></textarea>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-sm-6 col-md-6">
                            <lable>Contact Person</lable>
                            <input type="text" disabled name="contact_person" id="contact_person" class="form-control-file">
                        </div>
                        <div class="form-group col-sm-6 col-md-6">
                            <lable>Contact no</lable>
                            <input type="text" disabled name="contact_mobile" id="contact_mobile"  class="form-control-file">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-6 col-md-6">
                            <lable>Mail</lable>
                            <input type="mail" disabled name="mail" id="mail"  class="form-control-file">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-6 col-md-6">
                            <lable>Service Detail</lable>
                            <textarea name="service_spacification" id="service_spacification"  class="form-control-file"></textarea>
                        </div>
                        <div class="form-group col-sm-3 col-md-3">
                            <lable>In</lable>
                            <input type="time" name="in_time" id="in_time" disabled class="form-control-file">
                        </div>
                        <div class="form-group col-sm-3 col-md-3">
                            <lable>Out</lable>
                            <input type="time" name="out_time" id="out_time" disabled class="form-control-file">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-6 col-md-6">
                            <b>Technican Detail</b>
                            <hr>
                            <div class="row">
                                <div class="form-group col-sm-4 col-md-4">
                                    <lable>Name</lable>
                                </div>
                                <div class="form-group col-sm-8 col-md-8">
                                    <input type="text" name="technican_name" id="technican_name" class="form-control-file">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-sm-4 col-md-4">
                                    <lable>sign</lable>
                                </div>
                                <div class="form-group col-sm-8 col-md-8">
                                    <img src="" id="technican_sign_image" width="100">
                                </div>
                            </div>            
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-6 col-md-6">
                            <b>Client</b>
                            <hr>
                            <div class="row">
                                <div class="form-group col-sm-4 col-md-4">
                                    <lable>Client Name</lable>
                                </div>
                                <div class="form-group col-sm-8 col-md-8">
                                    <input type="text" name="technican_name" id="client_name" class="form-control-file">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-sm-4 col-md-4">
                                    <lable>Client Mobile</lable>
                                </div>
                                <div class="form-group col-sm-8 col-md-8">
                                    <input type="text" name="client_mobile" id="client_mobile" class="form-control-file">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-sm-4 col-md-4">
                                    <lable>sign</lable>
                                </div>
                                <div class="form-group col-sm-8 col-md-8">
                                    <img src="" id="client_sign_image" width="100">
                                </div>
                            </div>
                            <input type="hidden" name="user_type" id="user_type" class="form-control-file" >
                        </div>
                    </div>
                        <!-- ajit -->
                    @endcan
                    <hr style="border: 1px solid red;">

                    @can('Access Audit Report')
                        <div class="row">
                            <div class="col-sm-12 col-md-6">
                                <h3>Audit Reports</h3>
                                @can('Create Audit Report')
                                    <button type="button" class="btn btn-primary rounded p-1" data-toggle="modal" data-target="#modal_report">
                                        <span class="fa fa-upload"></span>Audit Report
                                    </button>
                                @endcan
                                @php
                                    $date = \Illuminate\Support\Facades\DB::table('hvl_audit_reports')
                                            ->where('activity_id',$customer_activity->id)
                                            ->orderBy('id','DESC')
                                             ->value('added');

                                @endphp
                                @if(!empty($date))
                                    <span class="pull-right badge badge-primary p-2">{{$date}}</span><h4 class="pull-right badge badge-primary p-2"> Audit Report Update Date :</h4>
                                @endif
                            </div>
                            <div class="col-sm-12 col-md-12">
                                <div class="form-group col-sm-6 col-md-3 mt-4">
                                    @if(!empty($audit_report))
                                        @foreach($audit_report as $report)
                                            <label>Audit Report </label>
                                            <br>
                                            @if($report->type == 'pdf')
                                                <a href="{{$helper->getGoogleDriveImage($report->report)}}" target="_blank">
                                                    <img height="100" width="90" src="{{asset('public/uploads/pdf-icon.png')}}"><br>
                                                    {{$report->report}}
                                                </a>
                                            @endif
                                            @if($report->type == 'xls' or $report->type == 'xlsx' or $report->type == 'csv')
                                                <a href="{{$helper->getGoogleDriveImage($report->report)}}" target="_blank">
                                                    <img height="110" width="120" src="{{asset('public/uploads/excel-logo.png')}}"><br>
                                                    {{$report->report}}
                                                </a>
                                            @endif
                                        @endforeach
                                            <a class="text-center btn btn-primary rounded" data-toggle="modal" data-target="#email_div">
                                                Send
                                                <span class="fa fa-envelope fa-lg "></span>
                                            </a>
                                    @endif

                                </div>
                            </div>
                        </div>
                    @endcan


                    <div class="row mt-4 pull-right">
                        <div class="col-sm-12 ">
                            <button type="reset" class="btn btn-secondary  mb-1">
                                <i class="fa fa-arrow-circle-left"></i>
                                <a href="" class="text-white" onclick="closeWin();">Cancel</a>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{--    Job card modal Start--}}
    <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4>Add Job Cards</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" action="{{route('activity.addbefore_pic')}}" enctype="multipart/form-data">
                        <input type="hidden" name="activity_id" value="{{$customer_activity->id}}">
                        <div class="form-group">
                            <lable>Before Image</lable>
                            <input type="file" name="before_pic[]" id="before_file" accept=".jpg, .png, .jpeg" required class="form-control-file" multiple>
                            <p class="text-danger">Max File Size:<strong> 3MB</strong><br>Supported Format: <strong>.jpg .png .jpeg</strong></p>
                        </div>
                        <br>
                        <div class="form-group">
                            <lable>After Image</lable>
                            <input type="file" name="after_pic[]" id="after_file" accept=".jpg, .png, .jpeg" class="form-control-file" multiple>
                            <p class="text-danger">Max File Size:<strong> 3MB</strong><br>Supported Format: <strong>.jpg .png .jpeg</strong></p>
                        </div>

                        <div class="form-group">
                            <input type="submit" class="btn btn-success rounded" value="Upload">
                        </div>
                    </form>
                    <a href='javascript:;' data-toggle="modal" data-dismiss="modal"  id="openServiesModel" data-target=".service_report_Model"> Open Service From</a>
                </div>
            </div>
        </div>
    </div>
    {{--    Job card modal End--}}

    {{--    Audit Report Modal Start--}}
    <div class="modal fade" id="modal_report" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">--}}
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4>Add Audit Report</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" action="{{route('activity.auditreport')}}" enctype="multipart/form-data">
                        <input type="hidden" name="activity_id" value="{{$customer_activity->id}}">
                        <div class="form-group">
                            <lable>Report File (only pdf and excel)</lable>
                            <input type="file" name="audit_report" id="audit_file" required class="form-control-file" accept=".pdf, .xls, .xlsx, .csv">
                            <p class="text-danger">Max File Size:<strong> 5MB</strong><br>Supported Format: <strong>.pdf, .xls, .xlsx, .csv</strong></p>
                            <br>
                            <input type="submit" class="btn btn-success rounded" value="Upload">
                        </div>
                    </form>
          
                </div>
            </div>
        </div>
    </div>

    {{--    Audit Report Modal End--}}

    {{--    Email modal start--}}

    <div id="email_div" tabindex="-1" role="dialog" aria-hidden="true" class="modal fade text-left">
        <div role="document" class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Send Mail</h4>
                    <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body p-4 row">
                    <div class="col-sm-12">
                        <form action="{{ route('mail.sendaudit') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="customer" value="{{$customer_activity->customer_id}}">
                            <input type="hidden" name="act_id" value="{{$customer_activity->id}}">
                            <div class="row">
                                <div class="form-group">
                                    <label for="">To</label>
                                    <input type="email" class="form-control" name="to" required>
                                </div>

                                <div class="form-group">
                                    <label for="">Subject</label>
                                    <input type="text" class="form-control" name="subject" value="" required>
                                </div>
                                <div class="form-group">
                                    <label for="">Body</label>
                                    <textarea class="form-control" name="body">Start Date : {{$customer_activity->start_date}} End Date : {{$customer_activity->end_date}}     Customer : {{$customer_activity->customer_id}}
                                                                                                        </textarea>
                                </div>
{{--                                <div class="form-group">--}}
{{--                                    <input type="file" name="attach" class="form-control-file" required>--}}
{{--                                </div>--}}
                                <div class="col-sm-12">
                                    <input type="submit" class="btn btn-success rounded" value="Send">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{--    Email modal End--}}

@endsection
{{-- vendor script --}}
@section('vendor-script')
    <script src="{{asset('js/ajax/jquery.min.js')}}"></script>
    <script src="{{asset('js/ajax/angular.min.js')}}"></script>
    <script src="{{asset('js/materialize.js')}}"></script>
    <script src="{{asset('js/ajax/jquery.validate.min.js')}}"></script>
    <script src="{{asset('vendors/select2/select2.full.min.js')}}"></script>
    <script src="{{asset('js/scripts/form-select2.js')}}"></script>
    <script src="{{asset('vendors/dropify/js/dropify.min.js')}}"></script>

@endsection


{{-- page scripts --}}
@section('page-script')
<script>
    $(document).ready(function () {
        getdata();
        
        $(document).on('click', '.button', function (e) {
            e.preventDefault();
            var id = $(this).data("id");

            swal({
                    title: "Are you sure? ",
                    text: "You will not be able to recover this record!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Yes, delete it!",
                    closeOnConfirm: false
                },
                function (isConfirm) {
                    if (isConfirm) {
                        $.ajax({
                            url: "{{route('activity.image_delete')}}",
                            type: "get",
                            data: {
                                "id": id
                            },
                            success: function (result) {
                                swal({
                                    title: "Record has been deleted!",
                                    type: "success",
                                }, function () {
                                    location.reload();
                                });
                            }
                        });
                    }
                });
        });
    });
    var uploadbefore = document.getElementById("before_file");
    var uploadafter = document.getElementById("after_file");
    var uploadaudit = document.getElementById("audit_file");
    uploadbefore.onchange = function() {
        if(this.files[0].size > 3145728){
            alert("File is too big!");
            this.value = "";
        };
    };
    uploadafter.onchange = function() {
        if(this.files[0].size > 3145728){
            alert("File is too big!");
            this.value = "";
        };
    };
    uploadaudit.onchange = function() {
        if(this.files[0].size > 5242880){
            alert("File is too big!");
            this.value = "";
        };
    };
    function closeWin() { 
        window.top.close();
    }
</script>
<script type="text/javascript">
    var _gaq = _gaq || [];
    _gaq.push(['_setAccount', 'UA-39365077-1']);
    _gaq.push(['_trackPageview']);
    (function() {
        var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
        ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
    })();
</script>   
<script>
    function getdata(){
        $.ajax({
            url: "/activity-master/service_report_default_infomation/"+ {{$customer_activity->id}},
            type: 'get',
            success: function(response){
                console.log("check default data");
                console.log(response);
                
                $('#branch_name').val(response.data['name']);
                $('#site_name').val(response.data['customer_name']);
                $('#site_address').val(response.data['billing_address']);
                $('#contact_person').val(response.data['contact_person']);
                $('#contact_mobile').val(response.data['contact_person_phone']);
                $('#mail').val(response.data['billing_email']);
                $('#shipping_address').val(response.data['shipping_address']);
            }
        });
        $.ajax({
            url: "/activity-master/service_report/"+ {{$customer_activity->id}},
            type: 'get',
            success: function(response){
                console.log("save data");
                console.log(response);
                
                if(response.data.service_spacification != ''){
                    $('#service_spacification').val(response.data.service_spacification);
                }
                if(response.data.in_time != ''){
                    $('#in_time').val(response.data.in_time);
                }
                if(response.data.out_time != ''){
                    $('#out_time').val(response.data.out_time);
                }
                if(response.data.technican_name != ''){
                    $('#technican_name').val(response.data.technican_name);
                }
                if(response.data.technican_sign_image != ''){
                    $('#technican_sign_image').attr('src',response.data.technican_sign_image);
                    $('#technican_sign_image').show();
                }else{
                    $('#technican_sign_image').hide();
                }
                if(response.data.client_sign_image != ''){
                    $('#client_sign_image').attr('src',response.data.client_sign_image);
                    $('#client_sign_image').show();
                }else{
                    $('#client_sign_image').hide();
                }
                if(response.data.technican_name != ''){
                    $('#client_name').val(response.data.client_name);
                }
                if(response.data.client_mobile != ''){
                    $('#client_mobile').val(response.data.client_mobile);
                }
            }
        });
    }
</script>

@endsection

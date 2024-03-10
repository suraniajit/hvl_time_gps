@extends('app.layout')

{{-- page title --}}
@section('title','Lead Management | HVL')

@section('vendor-style')

@endsection
@section('content')
    <div class="breadcrumb-holder">
        <div class="container-fluid">
            <ul class="breadcrumb">
                {{--                <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>--}}
                    <li class="breadcrumb-item active"><a href="{{route('lead.index')}}">Lead Management  </a></li>
                    <li class="breadcrumb-item ">Add Lead</li>
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
                                <h2 class="h3 display"> Add Lead</h2>
                                <p style="font-size: 12px;"><strong>Note:</strong> Comma is not allowed in any field.</p>
                            </div>
                        </div>

                    </header>
                    <form action="{{route('lead.store')}}" id="formValidate" method="post" enctype="multipart/form-data">

                        {{csrf_field()}}

                        <div class="row">
                            <div class="form-group col-sm-6 col-md-4" style="margin-bottom: 1px;">
                                <label>Company Type <span class="text-danger">*</span></label>
                                <select class="form-control" name="company_type" id="company_type" autocomplete="off" autofocus="off" data-error=".errorTxt1">
                                    <option value=""> Select Company Type</option>
                                    @foreach($company_types as $company)
                                        <option value="{{$company->id}}">{{$company->Name}}</option>
                                    @endforeach
                                </select>
                                
                                <div class="errorTxt1 text-danger"></div>
                            </div>

                            <div class="form-group col-sm-6 col-md-4">
                                <label>Last/Company Name <span class="text-danger">*</span></label>
                                <input type="text" name="compnay_name" class="form-control " onkeypress="return RestrictCommaSemicolon(event);" ondrop="return false;" onpaste="return false;" placeholder="Enter Last/Company Name" data-error=".errorTxt2" autocomplete="off" autofocus="off">
                                <div class="errorTxt2 text-danger"></div>
                            </div>

                            <div class="form-group col-sm-6 col-md-4">
                                <label>First Name <span class="text-danger">*</span></label>
                                <input type="text" name="f_name" class="form-control " onkeypress="return RestrictCommaSemicolon(event);" ondrop="return false;" onpaste="return false;" placeholder="Enter First Name" data-error=".errorTxt3" autocomplete="off" autofocus="off">
                                <div class="errorTxt3 text-danger"></div>
                            </div>

                            <div class="form-group col-sm-6 col-md-4">
                                <label>Email </label> <label id="emailvlid"><span class="text-danger">*</span></label>
                                <input type="email" name="email" id="email_valid" class="form-control" onkeypress="return RestrictCommaSemicolon(event);" ondrop="return false;" onpaste="return false;" placeholder="Enter Email" data-error=".errorTxt4" autocomplete="off" autofocus="off">
                                <!--<div class="errorTxt4 text-danger"></div>-->
                                <div id="file_error"></div>
                            </div>
                            
                            <div class="form-group col-sm-6 col-md-4">
                                <label>Email 2 </label> </label>
                                <input type="email" name="email_2" class="form-control"   onpaste="return false;" placeholder="Enter Email 2 " data-error=".errorTxtEmail2" autocomplete="off" autofocus="off">
                                <div class="errorTxtEmail2 text-danger"></div>
                            </div>

                            <div class="form-group col-sm-6 col-md-4">
                                <label>Phone <span class="text-danger">*</span></label>
                                <input type="text" name="phone" class="form-control " onkeypress="return RestrictCommaSemicolon(event);" ondrop="return false;" onpaste="return false;" placeholder="Enter Phone" data-error=".errorTxt5" autocomplete="off" autofocus="off">
                                <div class="errorTxt5 text-danger"></div>
                            </div>

                            <div class="form-group col-sm-6 col-md-4">
                                <label>Employee <span class="text-danger">*</span></label>
                                <select class="form-control" name="employee" class="form-control" autocomplete="off" autofocus="off" data-error=".errorTxt6">
                                    <option value=""> Select Employee</option>
                                    @foreach($employees as $employee)
                                        <option value="{{$employee->id}}">{{$employee->Name}}</option>
                                    @endforeach
                                </select>

                                <div class="errorTxt6 text-danger"></div>
                            </div>

                            <div class="form-group col-sm-6 col-md-4">
                                <label>Owner <span class="text-danger">*</span></label>
{{--                                <input type="text" name="owner" class="form-control comma" placeholder="Enter Owner" data-error=".errorTxt7" autocomplete="off" autofocus="off">--}}
                                <select class="form-control" name="owner" class="form-control" autocomplete="off" autofocus="off" data-error=".errorTxt7">
                                    <option value=""> Select Owner</option>
                                    @foreach($employees as $employee)
                                        <option value="{{$employee->id}}">{{$employee->Name}}</option>
                                    @endforeach
                                </select>
                                <div class="errorTxt7 text-danger"></div>
                            </div>

                            <div class="form-group col-sm-6 col-md-4">
                                <label for="">Creation Date <span class="text-danger">*</span></label>
                                <input type="text" id="start_time" class="form-control datepicker" name="create_date" placeholder="Enter Creation Date" data-error=".errorTxt8" autocomplete="off" autofocus="off">
                                <div class="errorTxt8 text-danger"></div>
                            </div>

                            <div class="form-group col-sm-6 col-md-4">
                                <label for="">Follow Up Date <span class="text-danger">*</span></label>
                                <input type="text" id="end_time" class="form-control datepicker" name="follow_date" placeholder="Enter FollowUp Date" data-error=".errorTxt9" autocomplete="off" autofocus="off" onchange="return TimeCalculation();">
                                <div class="errorTxt9 text-danger"></div>
                            </div>

                            
                            <div class="form-group col-sm-6 col-md-4" style="margin-bottom: 1px;">
                                <label>Status <span class="text-danger">*</span></label>
                                <select class="form-control" name="status" id="status" autocomplete="off" autofocus="off" data-error=".errorTxt10">
                                    <option value=""> Select Lead Status</option>
                                    @foreach($statuses as $status)
                                        <option value="{{$status->id}}">{{$status->Name}}</option>
                                    @endforeach
                                </select>
                                <div class="errorTxt10 text-danger"></div>
                            </div>
                            
                            <div class="form-group col-sm-6 col-md-4" style="margin-bottom: 1px;">
                                <label>Geographical Segment <span class="text-danger">*</span></label>
                                <select class="form-control" name="rating" autocomplete="off" autofocus="off" data-error=".errorTxt11">
                                    <option value=""> Select Geographical Segment</option>
                                    @foreach($ratings as $rating)
                                        <option value="{{$rating->id}}">{{$rating->Name}}</option>
                                    @endforeach
                                </select>
                                <div class="errorTxt11 text-danger"></div>
                            </div>

                            <div class="form-group col-sm-6 col-md-4">
                                <label>Lead Source <span class="text-danger">*</span></label>
                                <select class="form-control" name="lead_source" autocomplete="off" autofocus="off" data-error=".errorTxt12">
                                    <option value=""> Select Lead Source</option>
                                    @foreach($leadsources as $leadsource)
                                        <option value="{{$leadsource->id}}">{{$leadsource->Name}}</option>
                                    @endforeach
                                </select>
                                <div class="errorTxt12 text-danger"></div>
                            </div>

                            <div class="form-group col-sm-6 col-md-4" style="margin-bottom: 1px;">
                                <label>Industry <span class="text-danger">*</span></label>
                                <select class="form-control" name="industry" autocomplete="off" autofocus="off" data-error=".errorTxt13">
                                    <option value=""> Select Industry</option>
                                    @foreach($industrys as $industry)
                                        <option value="{{$industry->id}}">{{$industry->Name}}</option>
                                    @endforeach
                                </select>
                                <div class="errorTxt13 text-danger"></div>
                            </div>

                            <div class="form-group col-sm-6 col-md-4">
                                <label>Address <span class="text-danger">*</span></label>
                                <input type="text" name="address" class="form-control " onkeypress="return RestrictCommaSemicolon(event);" ondrop="return false;" onpaste="return false;" placeholder="Enter Address" data-error=".errorTxt14" autocomplete="off" autofocus="off">
                                <div class="errorTxt14 text-danger"></div>
                            </div>

                            {{--
                            <div class="form-group col-sm-6 col-md-4">
                                <label>Credit Value <span class="text-danger">*</span></label>
                                <input type="number" name="value" required="" class="form-control " onkeypress="return RestrictCommaSemicolon(event);"  ondrop="return false;" onpaste="return false;" placeholder="Credit Value" data-error=".errorTxt17" autocomplete="off" autofocus="off">
                                <div class="errorTxt17 text-danger" ></div>
                            </div>
                            --}}

                            <div class="form-group col-sm-6 col-md-4">
                                <label>Revenue<span class="text-danger">*</span></label>
                                       <input type="number" name="revenue" id="revenue" class="form-control" onkeypress="return RestrictCommaSemicolon(event);"  ondrop="return false;" onpaste="return false;" placeholder="Revenue Value" data-error=".errorTxtRevenue"  required="true" autocomplete="off" autofocus="off" min="1">
                                <div class="errorTxtRevenue text-danger" ></div>
                            </div>
                            
                            <!-- for comments  -->
                            <div class="form-group col-sm-6 col-md-4">
                                <label>Comment 1 <span class="text-danger">*</span></label>
                                <input type="text" name="comment" class="form-control " onkeypress="return RestrictCommaSemicolon(event);" ondrop="return false;" onpaste="return false;" placeholder="Enter Comment" data-error=".errorTxt15" autocomplete="off" autofocus="off">
                                <div class="errorTxt15 text-danger"></div>
                            </div>
                            
                            <div class="form-group col-sm-6 col-md-4">
                                <label>Comment 2</label>
                                <input type="text" name="comment_2" class="form-control " onkeypress="return RestrictCommaSemicolon(event);" ondrop="return false;" onpaste="return false;" placeholder="Enter Comment" data-error=".errorTxtComment2" autocomplete="off" autofocus="off">
                                <div class="errorTxtComment2 text-danger"></div>
                            </div>
                            
                            <div class="form-group col-sm-6 col-md-4">
                                <label>Comment 3</label>
                                <input type="text" name="comment_3" class="form-control " onkeypress="return RestrictCommaSemicolon(event);" ondrop="return false;" onpaste="return false;" placeholder="Enter Comment" data-error=".errorTxtComment3" autocomplete="off" autofocus="off">
                                <div class="errorTxtComment3 text-danger"></div>
                            </div>
                            <!-- end comments -->
                            <div class="form-group col-sm-6 col-md-4">
                                <label>Is Active <span class="text-danger">*</span></label>
                                <select name="is_active" class="form-control" autocomplete="off" autofocus="off" data-error=".errorTxt16">
                                    <option value="">Select Status</option>
                                    <option value="0">Active</option>
                                    <option value="1">InActive</option>
                                </select>
                                <div class="errorTxt16 text-danger"></div>
                            </div>
                            <div class="form-group col-sm-6 col-md-4" style="margin-bottom: 1px;">
                                <label> Size <span class="text-danger">*</span></label>
                                <select class="form-control" name="lead_size" autocomplete="off" autofocus="off" data-error=".errorTxtLeadSize">
                                    <option value=""> Select Lead Size </option>
                                    @foreach($lead_size as $key=>$size)
                                        <option value="{{$key}}">{{$size}}</option>
                                    @endforeach
                                </select>
                                <div class="errorTxtLeadSize text-danger"></div>
                            </div>
                            <input type="hidden" name="flag"  id="proposal_count" data-error=".errorTxtflag"  value="0">
                            <div class="form-group col-sm-6 col-md-4 proposal_ids" style="margin-bottom: 1px;">
                                
                            </div>
                        </div>
                        <div class="row mt-4 pull-right">
                            <div class="col-sm-12 ">
                                <button class="btn btn-primary mr-2" type="submit" id="submit" onclick="return validateForm();">
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
                    <hr>
                    <div class="container-fluid">
                        <header>
                            <div class="row">
                                <div class="col-md-7">
                                    <h2 class="h3 display"> Proposal</h2>
                                </div>
                            </div>
                        </header>
                    </div>    
                    <div class="container-fluid">
                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#exampleModalCenter">
                          New Proposal
                        </button>
                        <div class="errorTxtflag text-danger"></div>
                
                    </div>
                    
                    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLongTitle">New Proposal</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                      <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <input type="file" id="proposal_file" name="proposal">
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary" data-dismiss="modal" id="saveProposal">Save</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="container-fluid proposan-image-gird">
                        <div class="row proposal-image-row-0">
                        </div>
                    </div>    
                </div>
            </div>
        </div>
    </section>
@endsection


{{-- page scripts --}}
@section('page-script')
    <script src="{{asset('js/hvl/leadmaster/create.js')}}"></script>
    <script>
        $(document).ready(function () {
            $('.datepicker').datepicker({
                format: 'yyyy-mm-dd',
                autoclose: true,
                todayHighlight: true
            });
        });
        $('#saveProposal').click(function(){
            var formData = new FormData();
            formData.append('file', $('#proposal_file')[0].files[0]);
            $.ajax({
                   url : '{{route("lead.proposal.save")}}',
                   type : 'POST',
                   data : formData,
                   processData: false,  
                   contentType: false,  
                   success : function(data) {
                       if(data.status="success"){
                            console.log(data);
                            var proposalElement = '<input type="hidden" name="proposal[]" value="'+data.data.proposal_id+'">'; 
                            var proposal_image_count = $('.proposal_image').length;
                            
                            var count = $('#proposal_count').val() + 1;
                            $('#proposal_count').val(count);
                            
                            $('.proposal_ids').append(proposalElement);
                            if(proposal_image_count != 0)
                            {
                                var html_string = '';
                                proposal_image_row = Math.floor($('.proposal_image').length / 4);
                                if($('.proposal_image').length % 4 != 0 ){
                                    html_string =   '<div class="col-12 col-md-3 proposal_image" >';
                                    html_string +=      '<a href="'+data.data.file_path+'" target="_blank">';
                                    html_string +=          '<img weight="150" height="150" src="'+data.data.image+'">';
                                    html_string +=      '</a>';
                                    html_string +=  '</div>';
                                    
                                    $('.proposal-image-row-'+ proposal_image_row).append(html_string);
                                }
                                else{
                                    html_string =   '<div class="row proposal-image-row-'+proposal_image_row+'">';
                                    html_string +=      '<div class="col-12 col-md-3 proposal_image" >';
                                    html_string +=          '<a href="'+data.data.file_path+'" target="_blank">';
                                    html_string +=              '<img weight="150" height="150" src="'+data.data.image+'">';
                                    html_string +=          '</a>';
                                    html_string +=      '</div>';
                                    html_string +=  '</div>';
                                    
                                    $('.proposan-image-gird').append(html_string);
                                }
                            }else{
                                    html_string =   '<div class="col-12 col-md-3 proposal_image" >';
                                    html_string +=      '<a href="'+data.data.file_path+'" target="_blank">'
                                    html_string +=          '<img weight="150" height="150" src="'+data.data.image+'">';
                                    html_string +=      '</a>';
                                    html_string +=  '</div>';
                                    
                                    $('.proposal-image-row-0').append(html_string);
                            }
                             swal("Saved!", "Your Proposal Has Atteched!", "success");
                        }
                   },
                   error: function (error) {
                        swal("Upps..!", error.responseJSON.message, "error");
                    }
            });
        });

  function validateForm() {
       if ($("#company_type").val() == "1") {
        //    alert($("#company_type").val());
           $('#emailvlid').show();
           if($("#email_valid").val() == ""){
                $("#file_error").html("<p style='color: #dc3545;'>Please Enter Valid Email id</p>");
                return false;
           }
      }
      $("#file_error").html('');
    $('#emailvlid').hide();  
         
  }
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
</script>

@endsection


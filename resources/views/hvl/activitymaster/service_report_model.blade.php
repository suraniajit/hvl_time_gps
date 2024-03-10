<div class="modal fade bd-example-modal-lg service_report_Model" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
            <img src="{{asset('img/hvl-logo.png')}}" class="img-responsive" height="50" width="100" alt="">
            <h4 style="padding-left:19px;padding-top:15px;">Service Report</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="service_form" name="service_form" enctype="multipart/form-data">
                    @csrf 
                    <input type="hidden" id="serviceform_acivity_id" name="activity_id" value="">
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
                                    <a href='javascript:;' class="technican_sign_image_button" data-toggle="modal" data-target="#SignatureModal"> Take New Signature</a>
                                </div>
                            </div>            
                        </div>
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
                                    <a href='javascript:;' class="client_sign_image_button"  data-toggle="modal" data-target="#SignatureModal"> Take New Signature</a>
                                </div>
                            </div>
                            <input type="hidden" name="technician_sign_file_name" id="technician_sign_file_name" >
                            <input type="hidden" name="client_sign_file_name" id="client_sign_file_name" >
                            <input type="hidden" name="user_type" id="user_type" class="form-control-file" >
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-12 col-md-6">
                            <a class="btn btn-success rounded submit_service_form"  data-action="save-jpg">Submit</a>
                        </div>
                    </div>
                </form>
            </div>
             <div class="info note_div">
                <p><strong>Note :</strong> Its computer generated service report no need seal</p>
            </div>
        </div>
    </div>
</div>
@include('hvl.activitymaster.signature_model')

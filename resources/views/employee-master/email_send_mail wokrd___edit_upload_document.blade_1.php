<h5 class="card-title">
    Document Details 
    <a class="doc_type_add_btn">
        <i class="material-icons">add_circle_outline</i>
    </a>
</h5>
<div id="upload_document_type">
    <?php
    foreach ($document_details as $key => $value) {
        ?>
        <div class="row">
            <div class="doc_type" style=" border: 0px solid red;">
                <div class="col"> 
                    <?php
                    if (($value->document_name == "Emirates ID") || ($value->document_name == "Agreeement") || ($value->document_name == "Passport") || ($value->document_name == "Visa") || ($value->document_name == "Broker Card Number")) {
                        echo "&nbsp";
                    } else {
                        ?>
                        <span class="material-icons remove_document rmv" data-id="{{ $value->id }}" data-name="document_details" style="margin-top: 13px;">delete</span>
                    <?php } ?>
                    <a style="display: none;" class="modal-trigger" href="#mail_send{{$value->id}}">
                        <span style="margin-top: 13px;" class="material-icons right">send</span>
                    </a>

                    <div id="mail_send{{$value->id}}" class="modal">
                        <div class="modal-content">
                            <h4>Send Document <span style="font-size: 13px;color: blue;"># {{$edit_details->name}}</span></h4>
                            <div class="row">
                                <form id="" action="{{ route('emp.sendDocument_email', $value->id) }}" method="POST" enctype="multipart/form-data">
                                    <div class="row">
                                        <div class=" ">
                                            <div class="col s3">
                                                <label>Name</label>
                                                <input type="text" readonly="" name="emp_name" id="emp_name" value="{{$edit_details->name}}">
                                            </div>
                                            <div class="col s3">
                                                <label>Document Name</label>
                                                <input readonly="" type="text" value="{{$value->document_name}}" id="document_name"  name="document_name"/>
                                            </div>
                                            <div class="col s3">
                                                <label>Document Expiry</label>
                                                <input readonly="" type="text" value="{{$value->document_expiry}}" id="document_expiry" name="document_expiry" />
                                            </div>
                                            <div class="col s3">
                                                <label>Email ID </label>
                                                <input type="text" readonly="" name="email_id" id="email_id" value="{{$edit_details->email}}">
                                            </div>
                                            <div class="col s3">
                                                <label>Note</label>
                                                <input type="text" name="note_send" id="note_send">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col s12 display-flex justify-content-end form-action">
                                            <button type="submit" class="btn btn-small indigo waves-light mr-1">
                                                <i class="material-icons right">send</i>  Update
                                            </button>
                                            <a href="#" class="modal-action modal-close btn btn-small indigo waves-light mr-1">
                                                <i class="material-icons right">settings_backup_restore</i>Close
                                            </a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col s2">
                    <label>Document Name*</label>
                    <input disabled="" type="text" class="input-field" value="{{$value->document_name}}" placeholder="Document Name" required="" />
                </div>
                <div class="col s2">
                    <label>Expiry Date *</label>
                    <input type="text" class="date" value="{{$value->document_expiry}}" placeholder="Document Expiry Date" required="" />
                </div>
                <div class="col s2">
                    <label>Document Note </label>
                    <input disabled="" type="text" class="input-field" value="{{$value->document_not}}" placeholder="Note"/>
                </div>
                <!--                <div class="col s2">
                                    <label>Document File (.pdf,.jpeg,.png,)*</label>
                                    <input type="hidden" class="document_file" value="/public/uploads/hherp/apiemp/{{$edit_details->id}}/{{$value->document_file}}" /><br>
                                </div>-->
                <div class="col s2" style="float: initial;">
                    <?php if (($value->file_extension == 'pdf') || $value->file_extension == 'PDF') { ?>

                        <a target="_blank" href="/public/uploads/hherp/apiemp/{{$edit_details->id}}/{{$value->document_file}}">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/8/87/PDF_file_icon.svg" height="50" width="50"/>
                        </a>
                    <?php } else { ?>
                        <a target="_blank" href="/public/uploads/hherp/apiemp/{{$edit_details->id}}/{{$value->document_file}}">
                            <img src="/public/uploads/hherp/apiemp/{{$edit_details->id}}/{{$value->document_file}}" height="50" width="50"/>
                        </a>
                    <?php } ?>
                </div>
                <br>
            </div>
        </div>
    <?php } ?>
</div>    
<script type="text/javascript">
    $('.document').bind('change', function () {
        //this.files[0].size gets the size of your file.

//        var ext = $('.document').val().split('.').pop().toLowerCase();
//        if ($.inArray(ext, ['gif', 'png', 'jpg', 'jpeg']) == -1) {
//            alert('invalid extension!');
//            $(".document").val('');
//            return false;
//        }
//        if (this.files[0].size > 3000) {
//            alert('file size between 1MB to 3MB');
//            $(".document").val('');
//            return false;
//        }

    });
</script>
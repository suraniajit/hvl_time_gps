<h5 class="card-title">
    Mandatory Documents Details 
</h5>
<div id="mandatory_documents_div">

    <div id="mandatory_documents_div">
        <div class="row">
            <div class="doc_type" style=" border: 0px solid red;">

                <div class="col s2"><label>Document Name*</label>
                    <input readonly="" type="text" name="document_passport"  required="" value="{{$document_mandatory_details[0]->document_name}}"   />
                </div>

                <div class="col s2"><label>Expiry Date </label>
                    <input type="text" name="document_passport_exp" value="{{($document_mandatory_details[0]->document_expiry) ? $document_mandatory_details[0]->document_expiry : ""}}" class="date" placeholder="Document Expiry Date" />
                </div>
                <div class="col s2"><label>Document Note </label>
                    <input type="text" name="document_passport_not" value="{{$document_mandatory_details[0]->document_not}}" placeholder="Note" />
                </div>
                <div class="col s2"><label>Document File (.pdf,.jpeg,.png,)</label>
                    <input type="file" name="document_passport_file" accept=".pdf,.png,.jpg,.jpeg" />
                </div>
                <div class="col s2" style="float: initial;">
                    <?php
                    if ($document_mandatory_details[0]->is_upload == 1) {
                        ?>
                        <?php
                        if (($document_mandatory_details[0]->file_extension == 'pdf') || $document_mandatory_details[0]->file_extension == 'PDF') {
                            ?>
                            <a target="_blank" href="/public/uploads/hherp/apiemp/{{$document_mandatory_details[0]->emp_id}}/{{$document_mandatory_details[0]->document_file}}">
                                <img src="https://upload.wikimedia.org/wikipedia/commons/8/87/PDF_file_icon.svg" height="50" width="50"/>
                            </a>
                        <?php } else { ?>
                            <a target="_blank" href="/public/uploads/hherp/apiemp/{{$document_mandatory_details[0]->emp_id}}/{{$document_mandatory_details[0]->document_file}}">
                                <img src="/public/uploads/hherp/apiemp/{{$document_mandatory_details[0]->emp_id}}/{{$document_mandatory_details[0]->document_file}}" height="50" width="50"/>
                            </a>
                            <?php
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="doc_type" style=" border: 0px solid red;">

                <div class="col s2"><label>Document Name*</label>
                    <input readonly="" type="text" name="document_visa"  value="{{$document_mandatory_details[1]->document_name}}" />
                </div>
                <div class="col s2"><label>Expiry Date </label>
                    <input type="text" value="{{($document_mandatory_details[1]->document_expiry) ? $document_mandatory_details[1]->document_expiry : ""}}"  name="document_visa_exp" class="date" placeholder="Document Expiry Date" />
                </div>
                <div class="col s2"><label>Document Note </label>
                    <input type="text" name="document_visa_not" value="{{$document_mandatory_details[1]->document_not}}" placeholder="Note" />
                </div>
                <div class="col s2"><label>Document File (.pdf,.jpeg,.png,)</label>
                    <input type="file" name="document_visa_file" accept=".pdf,.png,.jpg,.jpeg" />
                </div>
                <div class="col s2" style="float: initial;">
                    <?php
                    if ($document_mandatory_details[1]->is_upload == 1) {
                        if (($document_mandatory_details[1]->file_extension == 'pdf') || $document_mandatory_details[1]->file_extension == 'PDF') {
                            ?>
                            <a target="_blank" href="/public/uploads/hherp/apiemp/{{$document_mandatory_details[1]->emp_id}}/{{$document_mandatory_details[1]->document_file}}">
                                <img src="https://upload.wikimedia.org/wikipedia/commons/8/87/PDF_file_icon.svg" height="50" width="50"/>
                            </a>
                        <?php } else { ?>
                            <a target="_blank" href="/public/uploads/hherp/apiemp/{{$document_mandatory_details[1]->emp_id}}/{{$document_mandatory_details[1]->document_file}}">
                                <img src="/public/uploads/hherp/apiemp/{{$document_mandatory_details[1]->emp_id}}/{{$document_mandatory_details[1]->document_file}}" height="50" width="50"/>
                            </a>
                            <?php
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="doc_type" style=" border: 0px solid red;">

                <div class="col s2"><label>Document Name*</label>
                    <input readonly="" type="text" name="document_emirates" value="{{$document_mandatory_details[2]->document_name}}" />
                </div>
                <div class="col s2"><label>Expiry Date </label>
                    <input type="text" value="{{($document_mandatory_details[2]->document_expiry)? $document_mandatory_details[2]->document_expiry : ""}}"  name="document_emirates_exp" class="date" placeholder="Document Expiry Date" />
                </div>
                <div class="col s2"><label>Document Note </label>
                    <input type="text" name="document_emirates_not" value="{{$document_mandatory_details[2]->document_not}}" placeholder="Note" />
                </div>
                <div class="col s2"><label>Document File (.pdf,.jpeg,.png,)</label>
                    <input type="file" name="document_emirates_file" accept=".pdf,.png,.jpg,.jpeg" />
                </div>
                <div class="col s2" style="float: initial;">
                    <?php
                    if ($document_mandatory_details[2]->is_upload == 1) {
                        if (($document_mandatory_details[2]->file_extension == 'pdf') || $document_mandatory_details[2]->file_extension == 'PDF') {
                            ?>
                            <a target="_blank" href="/public/uploads/hherp/apiemp/{{$document_mandatory_details[2]->emp_id}}/{{$document_mandatory_details[2]->document_file}}">
                                <img src="https://upload.wikimedia.org/wikipedia/commons/8/87/PDF_file_icon.svg" height="50" width="50"/>
                            </a>
                        <?php } else { ?>
                            <a target="_blank" href="/public/uploads/hherp/apiemp/{{$document_mandatory_details[2]->emp_id}}/{{$document_mandatory_details[2]->document_file}}">
                                <img src="/public/uploads/hherp/apiemp/{{$document_mandatory_details[2]->emp_id}}/{{$document_mandatory_details[2]->document_file}}" height="50" width="50"/>
                            </a>
                            <?php
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="doc_type" style=" border: 0px solid red;">

                <div class="col s2"><label>Document Name*</label>
                    <input readonly="" type="text" name="document_broker" value="{{$document_mandatory_details[3]->document_name}}" />
                </div>

                <div class="col s2"><label>Expiry Date </label>
                    <input type="text" value="{{($document_mandatory_details[3]->document_expiry) ? $document_mandatory_details[3]->document_expiry : ""}}"  name="document_broker_exp" class="date" placeholder="Document Expiry Date" />
                </div>
                <div class="col s2"><label>Document Note </label>
                    <input type="text" name="document_broker_not" value="{{$document_mandatory_details[3]->document_not}}" placeholder="Note" />
                </div>
                <div class="col s2"><label>Document File (.pdf,.jpeg,.png,)</label>
                    <input type="file" name="document_broker_file" accept=".pdf,.png,.jpg,.jpeg" />
                </div>
                <div class="col s2" style="float: initial;">
                    <?php
                    if ($document_mandatory_details[3]->is_upload == 1) {
                        if (($document_mandatory_details[3]->file_extension == 'pdf') || $document_mandatory_details[3]->file_extension == 'PDF') {
                            ?>
                            <a target="_blank" href="/public/uploads/hherp/apiemp/{{$document_mandatory_details[3]->emp_id}}/{{$document_mandatory_details[3]->document_file}}">
                                <img src="https://upload.wikimedia.org/wikipedia/commons/8/87/PDF_file_icon.svg" height="50" width="50"/>
                            </a>
                        <?php } else { ?>
                            <a target="_blank" href="/public/uploads/hherp/apiemp/{{$document_mandatory_details[3]->emp_id}}/{{$document_mandatory_details[3]->document_file}}">
                                <img src="/public/uploads/hherp/apiemp/{{$document_mandatory_details[3]->emp_id}}/{{$document_mandatory_details[3]->document_file}}" height="50" width="50"/>
                            </a>
                            <?php
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="doc_type" style=" border: 0px solid red;">
                <div class="col s2"><label>Document Name*</label>
                    <input readonly="" type="text" name="document_agreement" value="{{$document_mandatory_details[4]->document_name}}"  />
                </div>
                <div class="col" style="margin-top: 28px;margin-left: -53px;">
                    <a class="modal-trigger" href="#mail_send{{$document_mandatory_details[4]->id}}">
                        <i class="material-icons dp48">email</i>
                    </a>
                </div>
                <div class="col s2"><label>Expiry Date </label>
                    <input type="text" value="{{(isset($document_mandatory_details[4]->document_expiry) ? $document_mandatory_details[4]->document_expiry : "")}}"  name="document_agreement_exp" class="date" placeholder="Document Expiry Date" />
                </div>
                <div class="col s2"><label>Document Note </label>
                    <input type="text" name="document_agreement_not" value="{{$document_mandatory_details[4]->document_not}}" placeholder="Note" />
                </div>
                <div class="col s2"><label>Document File (.pdf,.jpeg,.png,)</label>
                    <input type="file" name="document_agreement_file" accept=".pdf,.png,.jpg,.jpeg" />
                </div>

                <div class="col s2" style="float: initial;">
                    <?php
                    if ($document_mandatory_details[4]->is_upload == 1) {
                        if (($document_mandatory_details[4]->file_extension == 'pdf') || $document_mandatory_details[4]->file_extension == 'PDF') {
                            ?>
                            <a target="_blank" href="/public/uploads/hherp/apiemp/{{$document_mandatory_details[4]->emp_id}}/{{$document_mandatory_details[4]->document_file}}">
                                <img src="https://upload.wikimedia.org/wikipedia/commons/8/87/PDF_file_icon.svg" height="50" width="50"/>
                            </a>
                        <?php } else { ?>
                            <a target="_blank" href="/public/uploads/hherp/apiemp/{{$document_mandatory_details[4]->emp_id}}/{{$document_mandatory_details[4]->document_file}}">
                                <img src="/public/uploads/hherp/apiemp/{{$document_mandatory_details[4]->emp_id}}/{{$document_mandatory_details[4]->document_file}}" height="50" width="50"/>
                            </a>
                            <?php
                        }
                    }
                    ?>
                </div>

            </div>
        </div>
    </div>     
</div>     
<div id="mail_send{{$document_mandatory_details[4]->id}}" class="modal">

    <div class="modal-content">
        <h4>Agreeement Document <span style="font-size: 13px;color: blue;"># {{$edit_details->name}}</span></h4>
        <div class="row">
            <div class="row">
                <div class=" ">
                    <input type="hidden" 
                           name="agreeement_id"
                           id="agreeement_id"
                           value="{{$document_mandatory_details[4]->id}}" />

                    <div class="col s3">
                        <label>Name</label>
                        <input type="text" readonly="" name="emp_name" id="emp_name" value="{{$edit_details->name}}">
                    </div>
                    <div class="col s3">
                        <label>Document Name</label>
                        <input readonly="" type="text" value="{{$document_mandatory_details[4]->document_name}}" id="document_name"  name="document_name"/>
                    </div>
                    <div class="col s3">
                        <label>Document Expiry</label>
                        <input readonly="" type="text" value="{{$document_mandatory_details[4]->document_expiry}}" id="document_expiry" name="document_expiry" />
                    </div>
                    <div class="col s3">
                        <label>Email ID </label>
                        <input type="text" readonly="" name="email_id" id="email_id" value="{{$edit_details->email}}">
                    </div>
                    <div class="col s12">
                        <label>Note</label>
                        <textarea id="agriemnt_note_send" name="agriemnt_note_send" class="materialize-textarea" data-length="50"></textarea>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col s12 display-flex justify-content-end">
                    <button type="button" class="btn btn-small indigo waves-light mr-1" onclick="send_document_mail();">
                        <i class="material-icons right">send</i> Send Message
                    </button>
                    <a href="#" class="modal-action modal-close btn btn-small indigo waves-light mr-1">
                        <i class="material-icons right">settings_backup_restore</i>Close
                    </a>
                </div>
            </div>
            <br>
            <!--            </form>-->
        </div>
    </div>
</div>

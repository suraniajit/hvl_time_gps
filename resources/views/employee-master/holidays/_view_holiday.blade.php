<?php
$holidaysPDFDetails = DB::table('apiemp_holiday_document_master')->where('emp_id', '=', $view_details->id)->get();
$holidaysDetails = DB::table('apiemp_holidays_master')->where('emp_id', '=', $view_details->id)->get();
?>

<h6 class="card-title">Holiday Details </h6>
<div id="holiday_type_frm">
    <?php
    if ((count($holidaysDetails) > 0) && (count($holidaysDetails) != 0)) {

        foreach ($holidaysDetails as $key => $holidays) {
            ?>
            <div class="row">
                <div class="holiday_emp_type" style=" border: 0px solid red;">
                    <div class="col">
                    </div>
                    <div class="col s3">
                        <label>Holiday Name *</label>
                        <input type="text" disabled="" name="holiday_name[]" placeholder="Enter Holiday Name*" value="{{$holidays->holiday_name}}" data-error=".errorTxt1" required="" />
                        <div class="errorTxt1"></div>
                    </div>
                    <div class="col s2">
                        <label>Holiday Type *</label>
                        <input type="text" disabled="" name="holiday_type[]" placeholder="Enter Holiday Type*" value="{{$holidays->holiday_type}}"  data-error=".errorTxt2" required=""/>
                        <div class="errorTxt2"></div>
                    </div>
                    <div class="col s3">
                        <label>Holiday Date *</label>
                        <input type="text" disabled="" name="holiday_date[]" class="holiday_date" placeholder="Select Holiday Date*" value="{{$holidays->holiday_date}}" data-error=".errorTxt3" required=""/>
                        <div class="errorTxt3"></div>
                    </div>
                    <div class="col s3">
                        <label>Note</label>
                        <input type="text" disabled="" name="holiday_note[]" class="input-field" placeholder="Note" autofocus="off" autocomplete="off" value="{{$holidays->holiday_note}}" />
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
<?php if (count($holidaysPDFDetails) > 0) { ?>
    <h6 class="card-title">
        Holiday PDF History 
    </h6>
    <div id="upload_document_type">
        <div class="row">
            <div class="doc_type" style=" border: 0px solid red;">
                <?php
                foreach ($holidaysPDFDetails as $key => $valuePDF) {
                    if ($valuePDF->file_extension == "pdf") {
                        ?>
                        <div class="col s2" style="text-align: center;">
                            <a target="_bl ank" href="/public/uploads/hherp/holidayPDF/{{$view_details->user_id}}/{{$valuePDF->document_file}}">
                                <img src="https://upload.wikimedia.org/wikipedia/commons/8/87/PDF_file_icon.svg" height="50" width="50"/>
                            </a>
                            <input style="    text-align: center;" disabled="" value="{{$valuePDF->upload_date}}" />
                        </div>
                    <?php } else if ($valuePDF->file_extension == "xlsx") { ?>
                        <div class="col s2" style="text-align: center;">
                            <a target="_bl ank" href="/public/uploads/hherp/holidayPDF/{{$view_details->user_id}}/{{$valuePDF->document_file}}">
                                <img src="https://cdn3.iconfinder.com/data/icons/document-icons-2/30/647702-excel-512.png" height="50" width="50"/>
                            </a>
                            <input style="    text-align: center;" disabled="" value="{{$valuePDF->upload_date}}" />
                        </div>
                    <?php } else if ($valuePDF->file_extension == "docx") { ?>
                        <div class="col s2" style="text-align: center;">
                            <a target="_bl ank" href="/public/uploads/hherp/holidayPDF/{{$view_details->user_id}}/{{$valuePDF->document_file}}">
                                <img src="https://cdn4.iconfinder.com/data/icons/logos-and-brands/512/381_Word_logo-512.png" height="50" width="50"/>
                            </a>
                            <input style="    text-align: center;" disabled="" value="{{$valuePDF->upload_date}}" />

                        </div>
                    <?php } else { ?>
                        <div class="col s2" style="text-align: center;">
                            <a target="_bl ank" href="/public/uploads/hherp/holidayPDF/{{$view_details->user_id}}/{{$valuePDF->document_file}}">
                                <img src="/public/uploads/hherp/holidayPDF/{{$view_details->user_id}}/{{$valuePDF->document_file}}" height="50" width="50"/>
                            </a>
                            <input style="    text-align: center;" disabled="" value="{{$valuePDF->upload_date}}" />
                        </div>
                    <?php } ?>
                <?php } ?>
                <br>
            </div>
        </div>
    </div>
<?php } ?>
<h5 class="card-title">
    Optional Document Details 
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
                    <span class="material-icons remove_document rmv" data-id="{{ $value->id }}" data-name="document_details" style="margin-top: 13px;">delete</span>
                </div>

                <div class="col s2">
                    <label>Document Name*</label>
                    <input disabled="" name="document_name[]" type="text" class="input-field" value="{{$value->document_name}}" placeholder="Document Name" required="" />
                </div>
                <div class="col s2">
                    <label>Expiry Date *</label>
                    <input disabled=""  type="text" name="document_expiry[]" class="date" value="{{$value->document_expiry}}" placeholder="Document Expiry Date" />
                </div>
                <div class="col s2">
                    <label>Document Note </label>
                    <input  disabled=""  name="pass_note[] "type="text" class="input-field" value="{{$value->document_not}}" placeholder="Note"/>
                </div>
                 <div class="col s2" style="float: initial;">
                    <?php
                    if (($value->file_extension == 'pdf') || $value->file_extension == 'PDF') {
                        ?>

                        <a target="_blank" href="/public/uploads/hherp/apiemp/{{$edit_details->id}}/{{$value->document_file}}">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/8/87/PDF_file_icon.svg" height="50" width="50"/>
                        </a>
                    <?php } else { ?>
                        <a target="_blank" href="/public/uploads/hherp/apiemp/{{$edit_details->id}}/{{$value->document_file}}">
                            <img src="/public/uploads/hherp/apiemp/{{$edit_details->id}}/{{$value->document_file}}" height="50" width="50"/>
                        </a>
                        <?php
                    }
                    ?>
                </div>
                <br>
            </div>
        </div>
    <?php } ?>
</div>    
<script>
//    function uploadfile(no) {
//        alert(no);
//    }
//    $(document).ready(function () {
//        $(document).on('change', '#file', function () {
//            alert('document');
//            formData = new FormData(this);
//            $.ajax({
//                url: '/emp/document_file_upload/',
//                mehtod: "get",
//                data: {
//                    "_token": token,
//                    formData: formData
//                },
//                success: function (result) {
//                    alert('result' + result);
//                }
//            });
//        });
//    });
</script>


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
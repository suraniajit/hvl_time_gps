<script type="text/javascript">
    $('#category_id_cash').change(function () {
        var cid = $(this).val();
        if (cid) {
            $.ajax({
                type: "get",
                url: "/expense/getsubcategory",
                data: {
                    id: cid
                },
                success: function (res)
                {
                    if (res)
                    {
                        $("#sub_category_id_cash").empty();
                        $("#sub_category_id_cash").append('<option value="0">Sub Category</option>');
                        $.each(res, function (key, value) {
                            $("#sub_category_id_cash").append('<option value="' + value.id + '">' + value.name + '</option>');
                        });
                        $('select').formSelect();
                    }
                }
            });
        }
    });

    function blank() {
        $('.amount_cash').val('');
        $('.spent_at_cash').val('');
        $('.date_of_expense_cash').val('');
        $('.city_name_cash').val('');
        $('.account_premises_no_cash').val('');
        $('.card_used_cash').val('');
        $('.account_name_cash').val('');
        $('.ddl_department').val('');
        $('.ddl_category_cash').val('');
        $('.subcategory_id_cash').val('');
        $('.ddl_payment_method_cash').val('');
        $('.ddl_payment_status_cash').val('');
        $('.description_cash').val('');
        $('.expance_multi_day').val('');
        $('.multi_day_from_date').val('');
        $('.multi_day_to_date').val('');

    }
  
    $(document).ready(function () {
        jQuery.datetimepicker.setLocale('en');
        $(".multi_day_div").hide();
        $(".cash_flow").show();
        $(".mailage_flow").hide();
        $('input[type="checkbox"]').click(function () {
            jQuery('.multi_day_from_date').datetimepicker({
                timepicker: false,
                format: 'Y-m-d',
                minDate: 0,
                defaultDate: new Date(),
                formatDate: 'Y-m-d',
                scrollInput: false
            });
            jQuery('.multi_day_to_date').datetimepicker({
                timepicker: false,
                format: 'Y-m-d',
                minDate: 0,
                defaultDate: new Date(),
                formatDate: 'Y-m-d',
                scrollInput: false
            });
            if ($(this).is(":checked")) {
                console.log("Checkbox is checked.");
                $(".multi_day_div").show();
            } else if ($(this).is(":not(:checked)")) {
                $(".multi_day_div").hide();
                console.log("Checkbox is unchecked.");
            }
        });

        jQuery('.date_of_expense').datetimepicker({
            timepicker: false,
            format: 'Y-m-d',
            minDate: 1,
            defaultDate: new Date(),
            formatDate: 'Y-m-d',
            scrollInput: false
        });
        $('.date_of_expense_time').timepicker({
            timeFormat: 'h:mm p',
            interval: 60,
            minTime: '10',
            maxTime: '6:00pm',
            defaultTime: '11',
            startTime: '10:00',
            dynamic: false,
            dropdown: true,
            scrollbar: true
        });
    });

    /* this function will call when onchange event fired */
    $('.file_upload_error').val('');
    $('#input-file-max-fs').change(function () {
        var fp = $("#input-file-max-fs");
        var lg = fp[0].files.length;
        var items = fp[0].files;
        var fileSize = 0;
        if (lg > 0) {
            for (var i = 0; i < lg; i++) {
                fileSize = fileSize + items[i].size;

                var filename = items[i].name;

                /* getting file extenstion eg- .jpg,.png, etc */
                var extension = filename.substr(filename.lastIndexOf("."));

                /* define allowed file types */

                var allowedExtensionsRegx = /(\.jpg|\.jpeg|\.png|\.pdf|\.doc|\.xls|\.ppt|\.docx|\.xlsx|\.pptx| \.tif|\.bmp|\.eml|\.msg)$/i;

                /* testing extension with regular expression */
                var isAllowed = allowedExtensionsRegx.test(extension);

                if (isAllowed) {
                    //alert("File type is valid for the upload");
                    /* file upload logic goes here... */
                } else {
//                    alert("Invalid File Type.");
                    $('.dropify-clear').click();
                    $('.file_upload_error').html('<p style="text-transform: capitalize;position: relative;top: 0rem;left: 0rem; font-size: 0.8rem;color: red;transform: translateY(0%);">File Types - .jpg, .jpeg, .png, .pdf, .doc, .xls, .ppt, .docx, .xlsx, .pptx, .tif, .bmp, .eml, .msg).</p>');
                    return false;
                }


            }
            if (fileSize > 15728640) {
//                alert('File size must not be more than 15 MB');
                $('.dropify-clear').click();
                $('.file_upload_error').html('<p style="text-transform: capitalize;position: relative;top: 0rem;left: 0rem; font-size: 0.8rem;color: red;transform: translateY(0%);">File Size - 15 MB/file</p>');
                return false;
            }
            if (lg > 5) {
//                alert('file not more then 5');
                $('.dropify-clear').click();
                $('.file_upload_error').html('<p style="text-transform: capitalize;position: relative;top: 0rem;left: 0rem; font-size: 0.8rem;color: red;transform: translateY(0%);">Upload Max 5 Files</p>');
                return false;
            }
            return true;
        }

    });


    $(document).ready(function () {
        $('.distance_mile').val(0);
        $('.vehicle_rate_per_km').val(0);
        calculation();
    });
    function calculation() {
        var sum = vehicle_rate_per_km = 0;
        var distance = $('.distance_mile').val();
        var vehicle_rate_per_km = $(".vehicle_rate_mile").val();

        var sum = (distance * vehicle_rate_per_km);
        $(".total_amount_mile").val(sum);
    }

    $('#vehicle_type_mile').change(function () {
        calculation();
        var cid = $(this).val();
        if (cid) {
            $.ajax({
                type: "get",
                url: "/expense/getvehicalRat",
                data: {
                    id: cid
                },
                success: function (res)
                {
                    if (res)
                    {
                        $(".vehicle_rate_mile").empty();
                        $.each(res, function (key, value) {
                            $(".vehicle_rate_mile").val(value.rate_per_km);
                            $(".vehicle_rate_mile").html(value.rate_per_km);
                        });
                    }
                }
            });
        }
    });


    $('#category_id_mile').change(function () {
        var cid = $(this).val();
        if (cid) {
            $.ajax({
                type: "get",
                url: "/expense/getsubcategory",
                data: {
                    id: cid
                },
                success: function (res)
                {
                    if (res)
                    {
                        $("#subcategory_id_mile").empty();
                        $("#subcategory_id_mile").append('<option value="0">Sub Category</option>');
                        $.each(res, function (key, value) {
                            $("#subcategory_id_mile").append('<option value="' + value.id + '">' + value.name + '</option>');
                        });
                        $('select').formSelect();
                    }
                }
            });
        }
    });
</script>
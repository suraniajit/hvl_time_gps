<script type="text/javascript">


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
                            
                              
    $(document).ready(function () {
        @if($edit_details->expance_multi_day == "on")
        $('.expance_multi_day').trigger('click');
        $('#ddl_vehicle_type').trigger('click');
        $(".multi_day_div").show();
        @endif
        
        @if($edit_details->expense_type == "0")
           $(".cash_flow").show();
           $(".mailage_flow").hide();
        @endif
        
        @if($edit_details->expense_type == "1")
           $(".mailage_flow").show();
           $(".cash_flow").hide();
        @endif
    });

        jQuery('.date_of_expense').datetimepicker({
            timepicker: false,
            format: 'Y-m-d',
            minDate: 1,
            defaultDate: new Date(),
            formatDate: 'Y-m-d',
            scrollInput: false
        });
        $('.date_of_expense_time_mile').timepicker({
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

                       $('#input-file-max-fs').change(function () {
    $('.file_upload_error').val('');
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
                        $('.remove_document').click(function () {
                            var id = $(this).data("id");
                            var token = $("meta[name='csrf-token']").attr("content");
                            swal({
                                title: "Are you sure, you want to delete Expens Document?",
                                icon: 'warning',
                                dangerMode: true,
                                buttons: {
                                    cancel: 'No, Please!',
                                    delete: 'Yes, Delete It'
                                }
                            }).then(function (willDelete) {
                                if (willDelete) {
                                    $.ajax({
                                       url: '/emp/removedata/',
                                        type: 'get',
                                        data: {
                                            "_token": token,
                                            'id': id,
                                            'delete': 'expance_document',
                                        },
                                        success: function (result) {
                                            swal("Record has been deleted!", {
                                                icon: "success",
                                            }).then(function () {
                                                location.reload();
                                            });
                                        }
                                    });
                                }
                            });
                        });
                        
                        
                        function remove_document(id) {
                            
                            
                            
                            
                             
            
            
            
                            //var id = $(this).data("id");
                            var token = $("meta[name='csrf-token']").attr("content");
                            // alert(id);
                            swal({
            title: "Are you sure? ",
            title: "Are you sure, you want to delete Expens Document?",
            type: 'warning',
            showCancelButton: true,
            confirmButtonClass: "btn-danger",
            confirmButtonText: "Yes, delete it!",
            closeOnConfirm: false
        }, function (isConfirm) {
                                if (isConfirm) {
                                    $.ajax({
                                       url: '/expense/remove_document/',
                                        type: 'get',
                                        data: {
                                            "_token": token,
                                            'id': id,
                                            'delete': 'expance_document',
                                        },
                                        success: function (result) {
                                             location.reload();
                                            // swal("Record has been deleted!", {
                                            //     icon: "success",
                                            // }).then(function () {
                                               
                                            // });
                                        }
                                    });
                                }
                            });
                            
                        }
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
                        function expance_type() {
                            let flow = $(".expense_type option:selected").val();
                            if (flow == 0) {
                                blank();
                                $(".cash_flow").show();
                                $(".mailage_flow").hide();
                            } else if (flow == 1) {
                                blank();
                                $(".cash_flow").hide();
                                $(".mailage_flow").show();
                            }
                            //                            alert($(".expense_type option:selected").val());
                        }

</script>
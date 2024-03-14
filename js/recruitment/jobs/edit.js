$(document).ready(function () {

     
    jQuery.datetimepicker.setLocale('en');
    jQuery('#open_date').datetimepicker({
        timepicker: false,
        format: 'Y-m-d',
        minDate: 0,
        defaultDate: new Date(),
        formatDate: 'Y-m-d',
        scrollInput: false

    });
    jQuery('#close_date').datetimepicker({
        timepicker: false,
        format: 'Y-m-d',
        defaultDate: new Date(),
        minDate: 0,
        formatDate: 'Y-m-d',
        scrollInput: false,
    });
    var myfile = "";
    $("#file_error").html("<p style='color:#FF0000'>File Size: Upto 1MB (.PDF/.DOC/.DOCX)</p>");
    
    $("#attachment").change(function () {
        $("#file_error").html("");
        $(".file_error").css("border-color", "#F0F0F0");
        var file_size = $('#attachment')[0].files[0].size;
        myfile = $(this).val();
        var ext = myfile.split('.').pop();
        if (ext == "pdf" || ext == "docx" || ext == "doc") {
            //alert('1' + ext);
        } else {
            alert('Supported Files: .PDF/.Doc/.Docx');
            return false;
        }
        if (file_size > 300000) {
             $("#file_error").html("<p style='color:#FF0000'>File Size: Upto 1MB (.PDF/.DOC/.DOCX)</p>");
            $(".file_upload1").css("border-color", "#FF0000");
            return false;
        }
        return true;
    });
    
    
    $('#country_id').on('change', function () {
        var cid = $(this).val();
        if (cid) {
            $.ajax({
                type: "GET",
                url: "/hrms/city/getstate",
                data: {
                    id: cid,
                    _token: '{{csrf_token()}}'
                },
                dataType: 'json',
                success: function (res)
                {
                    if (res)
                    {
                        $('#state_id').html('<option value="">Select State</option>');
                        $.each(res, function (key, value) {
                            $("#state_id").append('<option value="' + value.id + '"  >' + value.state_name + '</option>');
                        });
                        $('#city_id').html('<option value="">Select State First</option>');


//                                                $("#city_id").empty();
//                                                $("#state_id").empty();
//                                                $("#state_id").append('<option value="" selected="">Select State</option>');
//                                                $.each(res, function (key, value) {
//                                                    $("#state_id").append('<option value="' + value.id + '" selected>' + value.state_name + '</option>');
//                                                });
                        $('select').formSelect();
                    }
                }
            });
        }
    });

    $('#state_id').on('change', function () {
        var state_id = $(this).val();
        $("#city_id").html('');
        var country_id = $('#country_id').val();
        if (state_id) {
            $.ajax({
                type: "get",
                url: "/hrms/city/getCity",
                data: {
                    state_id: state_id,
                    country_id: country_id,
                    _token: '{{csrf_token()}}'
                },
                dataType: 'json',
                success: function (res)
                {
                    if (res)
                    {
                        $('#city_id').html('<option value="">Select City</option>');
                        $.each(res, function (key, value) {
                            $("#city_id").append('<option value="' + value.id + '"  >' + value.city_name + '</option>');
                        });

//                                                $("#city_id").empty();
//                                                $("#city_id").append('<option value="" selected="">Select City</option>');
//                                                $.each(res, function (key, value) {
//                                                    $("#city_id").append('<option value="' + value.id + '" selected>' + value.city_name + '</option>');
//                                                });
                        $('select').formSelect();
                    }
                }
            });
        }
    });


    $("#Job_Edit_Form").validate({
        rules: {
            job_status: {
                required: true,
            },
            job_title: {
                required: true,
            },
            // recruiter: {
            //     required: true,
            // },
            department: {
                required: true,
            },
            position: {
                required: true,
                number: true
            },
            hire_manager: {
                required: true,
            },
            job_type: {
                required: true,
            },
//            work_experience: {
//                required: true,
//            },
            open_date: {
                required: true,
            },
            close_date: {
                required: true,
            },
//            salary: {
//                required: true,
//                number: true,
//            },
            country: {
                required: true,
            },
            state: {
                required: true,
            },
            city: {
                required: true,
            },
            zipcode: {
                required: true,
            },
            street_name: {
                required: true,
            },
            job_description: {
                required: true,
            },
            "attachment": {
//                required: true,
                accept: "docx|pdf|doc"
            }
        },
        messages: {
            job_status: {
                required: 'Select Job Status',
            },
            job_title: {
                required: 'Enter Job Title',
            },
            // recruiter: {
            //     required: 'Select Recruiter',
            // },
            department: {
                required: 'Select Department',
            },
            position: {
                required: 'Enter Positions',
                number: 'Please Enter Only Digits'
            },
            hire_manager: {
                required: 'Select Hiring Manager',
            },
            job_type: {
                required: 'Select Job Type',
            },
//            work_experience: {
//                required: 'Select Work Experience',
//            },
            open_date: {
                required: 'Select Open Date',
            },
            close_date: {
                required: 'Select Close Date',
            },
//            salary: {
//                required: 'Enter Salary',
//                number: 'Please Enter Only Number',
//            },
            country: {
                required: 'Select Country',
            },
            state: {
                required: 'Select State',
            },
            city: {
                required: 'Select City',
            },
            zipcode: {
                required: 'Enter Zip-Code',
            },
            street_name: {
                required: 'Enter Street Name',
            },
            "job_description": {
                required: 'Enter Job Description',
            },
            "attachment": {
//                required: "input type is required",
                accept: "Extension Is Not Allowed.only pdf|doc|png"
            }
        },
        errorElement: 'div',
        errorPlacement: function (error, element) {
            var placement = $(element).data('error');
            if (placement) {
                $(placement).append(error)
            } else {
                error.insertAfter(element);
            }
        }
    });
});

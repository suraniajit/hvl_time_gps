$(document).ready(function () {
    $("#Job_Form").validate({
        rules: {
            "job_title": {
                required: true,
            },
            "job_status": {
                required: true,
            },
            "department": {
                required: true,
            },
            "position": {
                required: true,
                number: true
            },
            "hire_manager": {
                required: true,
            },
            "job_type": {
                required: true,
            },
//            "work_experience": {
//                required: true,
//            },
            "open_date": {
                required: true,
            },
            "close_date": {
                required: true,
            },
//            "salary": {
//                required: true,
//                //number: true,
//            },
            "country_id": {
                required: true,
            },
            "state_id": {
                required: true,
            },
            "city_id": {
                required: true,
            },
            "zipcode": {
                required: true,
                number: true
            },
            "street_name": {
                required: true,
            },
            "job_description": {
                required: true,
            },
            "attachment": {
//                required: true,
                accept: "docx|pdf|doc|png"
            }
        },
        messages: {
            "job_title": {
                required: 'Enter Job Title',
            },
            "job_status": {
                required: 'Select Job Status',
            },

            "department": {
                required: 'Select Department',
            },
            "position": {
                required: 'Please Enter Positions',
                number: 'Please Enter Only Digits'
            },
            "hire_manager": {
                required: 'Select Hiring Manager',
            },
            "job_type": {
                required: 'Select Job Type',
            },
//            "work_experience": {
//                required: 'Select Work Experience',
//            },
            "open_date": {
                required: 'Select Open Date',
            },
            "close_date": {
                required: 'Select Close Date',
            },
//            "salary": {
//                required: 'Enter Salary',
//                number: 'Please Enter Only Number',
//            },
            "country_id": {
                required: 'Select Country',
            },
            "state_id": {
                required: 'Select State',
            },
            "city_id": {
                required: 'Select City',
            },
            "zipcode": {
                required: 'Enter Zip-Code',
                number: 'Please Enter Only Digits'
            },
            "street_name": {
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

// Script for Validating the Edit data
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
                accept: "docx|pdf|doc|png"
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


$('#country_id').change(function () {
    var cid = $(this).val();
    if (cid) {
        $.ajax({
            type: "get",
            url: "/hrms/city/getstate",
            data: {
                id: cid
            },
            success: function (res)
            {
                if (res)
                {
                    $("#city_id").empty();
                    $("#state_id").empty();
                    $("#state_id").append('<option value="">Select State</option>');
                    $.each(res, function (key, value) {
                        $("#state_id").append('<option value="' + value.id + '" selected>' + value.state_name + '</option>');
                    });
                    $("#city_id").append('<option value="">Select City</option>');
                    $('select').formSelect();
                }
            }
        });
    }
});
$('#state_id').change(function () {
    var state_id = $(this).val();
    var country_id = $('#country_id').val();
    if (state_id) {
        $.ajax({
            type: "get",
            url: "/hrms/city/getCity",
            data: {
                state_id: state_id,
                country_id: country_id,
            },
            success: function (res)
            {
                if (res)
                {
                    $("#city_id").empty();
                    $("#city_id").append('<option value="">Select City</option>');
                    $.each(res, function (key, value) {
                        $("#city_id").append('<option value="' + value.id + '" selected>' + value.city_name + '</option>');
                    });
                    $('select').formSelect();
                }
            }
        });
    }
});
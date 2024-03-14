// script for validation of edit page

$(document).ready(function () {

    jQuery.datetimepicker.setLocale('en');
    jQuery('#start_date').datetimepicker({
        timepicker: false,
        format: 'Y-m-d',
        minDate: 0,
        scrollInput: false
    });
    jQuery('#end_date').datetimepicker({
        timepicker: false,
        format: 'Y-m-d',
        minDate: 0,
        scrollInput: false,
    });
    $("#SimulateCourse_Form_Edit").validate({

        rules: {
            course_image: {
                accept: "jpg|jpeg|png",
            },
            course_name: {
                required: true,
                maxlength: 30,
                remote: {
                    url: "/training/simulate_course/editvalidname/",
                    type: "get",
                    data: {
                        id: function () {
                            return $('#SimulateCourse_Form_Edit :input[name="simulate_course_id"]').val();
                        }
                    }
                }
            },
            "pass_criteria": {
                required: true,
                range: [1, 100],
                number: true
            },
            "add_pass_criteria": {
                required: true,
                range: [1, 100],
                number: true
            },
            "start_date": {
                required: true,
            },
            "end_date": {
                required: true,
            },
            "assign": {
                required: true,
            },
            "employee[]": {
                required: true,
            },
            "questionnaire_ids[]": {
                required: true,
            },
//            "course_media[]": {
//                required: true,
//            },
            "is_active": {
                required: true,
            }
        },
        messages: {
            course_image: {
//                required: "Please Select One Image",
                accept: "Image With This Type Of Extension Is Not Allowed"
            },
            course_name: {
                required: "Enter Course Title",
                remote: " This Course Already Exist"
            },
            "pass_criteria": {
                required: "Enter Passing Criteria",
                number: "Only Numbers Are Allowed"
            },
            "add-pass_criteria": {
                required: "Enter Passing Criteria by",
                number: "Only Numbers Are Allowed"
            },
            "start_date": {
                required: "Select Start Date",
            },
            "end_date": {
                required: "Select Close Date",
            },
            "assign": {
                required: "Select Assign To",
            },
            "is_active": {
                required: "Please Select Status",
            },
            "employee[]": {
                required: "Please Select Employees",
            },
            "questionnaire_ids[]": {
                required: "Select Questionnaire",
            },
//            "course_media[]": {
//                required: "Please Select course media",
//            }
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
$(document).ready(function () {
// script for validation in create page
    $("#Course_Form").validate({
        rules: {
            "course_image": {
//                required: true,
                accept: "jpg|jpeg|PNG|png"
            },
            "course_title": {
                required: true,
                maxlength: 25,
                remote: {
                    url: "/training/course/validname/",
                    type: "get",
                }
            },
            "pass_criteria": {
                required: true,
                number: true
            },
            "add_pass_criteria": {
                required: true,
                number: true
            },
            "is_active": {
                required: true,
            },
            "category_id": {
                required: true,
            },
            "questionnaire": {
                required: true,
            },
            "trainer": {
                required: true,
            },
            "start_date": {
                required: true,
            },
            "end_date": {
                required: true,
            },
            "assign_to": {
                required: true,
            },
        },
        messages: {
            "course_image": {
//                required: "Please Select One Image",
                accept: "Image With This Type Of Extension Is Not Allowed. jpg|jpeg|PNG|png "
            },
            "course_title": {
                required: "Please Enter Course Title",
                remote: " This Course Title Already Exist"
            },
            "pass_criteria": {
                required: "Please Enter Passing Criteria",
                number: "Only Numbers Are Allowed"
            },
            "add_pass_criteria": {
                required: "Please Increasing Criteria",
                number: "Only Numbers Are Allowed"
            },
            "is_active": {
                required: "Please Select Status",
            },
            "category_id": {
                required: "Please Select Category",
            },
            "questionnaire": {
                required: "Select Any One Questionnaire",
            },
            "trainer": {
                required: "Please Select Trainer",
            },
            "start_date": {
                required: "select Start date please",
            },
            "end_date": {
                required: "select close date please",
            },
            "assign_to": {
                required: "Please Select Any One",
            },
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



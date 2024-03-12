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
                range: [1, 100],
                number: true
            },
            "add_pass_criteria": {
                required: true,
                range: [1, 100],
                number: true
            },
            "is_active": {
                required: true,
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
            "trainer": {
                required: true,
            },

//            "teams": {
//                required: true,
//            },
//            "departments": {
//                required: true,
//            },
            "employee[]": {
                required: true,
            },

        },
        messages: {
            "course_image": {
//                required: "Select One Image",
                accept: "Image With This Type Of Extension Is Not Allowed. jpg|jpeg|PNG|png "
            },
            "course_title": {
                required: "Enter Course Title",
                remote: " This Course Title Already Exist"
            },
            "pass_criteria": {
                required: "Enter Passing Criteria",
                number: "Only Numbers Are Allowed"
            },
            "add_pass_criteria": {
                required: "Enter Passing Criteria by",
                number: "Only Numbers Are Allowed"
            },
            "is_active": {
                required: "Select Status",
            },

            "questionnaire": {
                required: "Select Any One Questionnaire",
            },
            "trainer": {
                required: "Select Trainer",
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
//            "teams": {
//                required: "Select Team ",
//            },
//            "departments": {
//                required: "Select Departments ",
//            },
            "employee[]": {
                required: "Select Employee ",
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



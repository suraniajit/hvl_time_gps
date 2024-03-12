$(document).ready(function () {

// script for validation in create page
    $("#simulate_questionnaire_form").validate({
        rules: {
            "questionnaire_name": {
                required: true,
                maxlength: 25,
                remote: {
                    url: "/training/simulation_questionnaire/validname",
                    type: "get",
                }
            },
            "question": {
                required: true
            },
            "answer": {
                required: true
            },
            "option": {
                required: true
            },
            "bg_image": {
                required: true
            },
            "question_image": {
                required: true
            },
            "right_answer_image": {
                required: true
            },
            "wrong_answer_image": {
                required: true
            },
            "is_active": {
                required: true,
            }
        },
        messages: {
            "questionnaire_name": {
                required: "Enter Questionnaire Name",
                remote: "This Questionnaire Already Exists"
            },
            "question": {
                required: "Enter Question"
            },
            "answer": {
                required: "Enter Answer"
            },
            "option": {
                required: "Enter Option"
            },
            "bg_image": {
                required: "Select Background Image"
            },
            "question_image": {
                required: "Select Question Image"
            },
            "right_answer_image": {
                required: "Select Right Aanswer Image"
            },
            "wrong_answer_image": {
                required: "Select Wrong Answer Image"
            },
            "is_active": {
                required: "Select Status",
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

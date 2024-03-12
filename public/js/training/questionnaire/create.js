$(document).ready(function () {
    

//******************************************************************************

    $("#questionnaire_form").validate({
        rules: {
            "questionnaire_name": {
                required: true,
                maxlength: 35,
                remote: {
                    url: "/training/questionnaire/validname",
                    type: "get",
                    data: {
                        _token: function () {
                            return "{{csrf_token()}}";
                        }
                    }
                }
            },
            "is_question_type": {
//                required: true,
            },
            "question_name": {
                required: true,
            },
            "que_options[]": {
                required: true,
            },
            "checkBox[]": {
//                required: "#checkbox:checked",
//                minlength: 2
            },
            "audio": {
                required: true,
                accept: "aac|mp3|oga"
            },
            "is_active": {
                required: true,
            }
        },
        messages: {
            "questionnaire_name": {
                required: "Enter Questionnaire Name",
                remote: "This Questionnaire Name Already Exist"
            },
            "is_question_type": {
//                required: "please select Question Type",
            },
            "question_name": {
                required: "Enter Question Name",
            },
            "que_options[]": {
                required: "Enter Question Answer",
            },
            "checkBox[]": {
//                required: "Please select at least 2 topics"
            },
            "is_active": {
                required: "Select Status",
            },
            "audio": {
                required: "Please upload audio .mp3/.aac/.oga format",
                accept: "Please upload audio .mp3/.aac/.oga format",
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
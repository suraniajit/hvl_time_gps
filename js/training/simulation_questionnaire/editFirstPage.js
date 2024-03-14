$(document).ready(function () {
    $("#simulatEdit").validate({
        rules: {
            "questionnaire_name": {
                required: true,
                maxlength: 25,
                remote: {
                    url: "/training/simulate_course/editvalidname/",
                    type: "get",
                    data: {
                        id: function () {
                            return $('#simulatEdit :input[name="questionnaire_id"]').val();
                        }
                    }
                }
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
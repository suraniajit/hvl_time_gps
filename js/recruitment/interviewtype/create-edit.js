// script for validation in create page
$("#InterviewType_Form").validate({
    rules: {
        interview_name: {
            required: {
                depends: function () {
                    $(this).val($.trim($(this).val()));
                    return true;
                }
            },
            remote: {
                url: "/recruitment/interviewtype/validname/",
                type: "get"
            }
        },
        is_active: {
            required: true,
        }
    },
    messages: {
        interview_name: {
            required: "Please Enter Interview Name",
            remote: "This Interview Name Already Exist",

        },
        is_active: {
            required: "Please Select Status",
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

// script for validation of edit page
$("#interviewtypeEdit").validate({
    rules: {
        interview_name: {
            required: {
                depends: function () {
                    $(this).val($.trim($(this).val()));
                    return true;
                }
            },
            remote: {
                url: "/recruitment/interviewtype/editvalidname/",
                type: "get",
                data: {
                    id: function () {
                        return $('#interviewtypeEdit :input[name="interview_id"]').val();
                    }
                }
            }
        },
        is_active: {
            required: true,
        }
    },
    messages: {
        interview_name: {
            required: "Please Enter Interview Name",
            remote: "This Interview Name Already Exist",

        },
        is_active: {
            required: "Please Select Status",
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

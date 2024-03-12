// script for validation in create page
$("#workexperienceFrm").validate({
    rules: {
        experience_name: {
            required: {
                depends: function () {
                    $(this).val($.trim($(this).val()));
                    return true;
                }
            },
            remote: {
                url: "/recruitment/workexperience/validname/",
                type: "get",

            }
        },
        is_active: {
            required: true,
        }
    },
    messages: {
        experience_name: {
            required: "Please Enter Work Experience",
            remote: "Work Experience Already Exist"
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
$("#workexperience_edit").validate({
    rules: {
        experience_name: {
            required: {
                depends: function () {
                    $(this).val($.trim($(this).val()));
                    return true;
                }
            },
            remote: {
                url: "/recruitment/workexperience/editvalidname",
                type: "get",
                data: {
                    id: function () {
                        return $('#workexperience_edit :input[name="experience_id"]').val();
                    }
                }
            }
        },
        is_active: {
            required: true,
        }

    },
    messages: {
        experience_name: {
            required: "Please Enter Work Experience",
            remote: " Work Experience Already Exist"
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

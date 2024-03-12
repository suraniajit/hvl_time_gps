// script for validation in create page
$("#statuses").validate({
    rules: {
        status_name: {
            required: {
                depends: function () {
                    $(this).val($.trim($(this).val()));
                    return true;
                }
            },
            remote: {
                url: "/recruitment/status/validname/",
                type: "get",
                data: {
                    _token: function () {
                        return "{{csrf_token()}}";
                    }
                }
            }
        },
        is_active: {
            required: true,
        }
    },
    messages: {
        status_name: {
            required: "Please Enter Status Name",
            remote: "This Status Name Already Exist"
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
$("#statuses_edit").validate({
    rules: {
        status_name: {
            required: true,
            remote: {
                url: "/recruitment/status/editvalidname",
                type: "get",
                data: {
                    id: function () {
                        return $('#statuses_edit :input[name="status_id"]').val();
                    }
                }
            }
        },
        is_active: {
            required: true,
        }
    },
    messages: {
        status_name: {
            required: "Please Enter Status Name",
            remote: "This Status Name Already Exist"
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

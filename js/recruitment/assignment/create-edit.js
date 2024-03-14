// script for validation in create page
$("#assignments").validate({
    rules: {
        assignment_name: {
            required: true,
            remote: {
                url: "/recruitment/assignments/validname/",
                type: "get",
                data: {
                    _token: function () {
                        return "{{csrf_token()}}";
                    }
                }
            }
        },
    },
    messages: {
        assignment_name: {
            required: "Please Enter Assignment Name",
            remote: "This Assignment Name Already Exist"
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

// script for validation of edit page
$("#assignments_edit").validate({
    rules: {
        assignment_name: {
            required: true,
            remote: {
                url: "/recruitment/assignments/editvalidname",
                type: "get",
                data: {
                    id: function () {
                        return $('#assignments_edit :input[name="assignment_id"]').val();
                    }
                }
            }
        },

    },
    messages: {
        assignment_name: {
            required: "Please Enter Assignment Name",
            remote: "This Assignment Name Already Exist"
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

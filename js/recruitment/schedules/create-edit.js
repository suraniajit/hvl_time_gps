// script for validation in create page
$("#schedulesfrm").validate({
    rules: {
        schedule_name: {
            required: true,
            remote: {
                url: "/recruitment/schedules/validname/",
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
        schedule_name: {
            required: "Please Enter Schedule Name",
            remote: "This Schedule Name Already Exist"
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
$("#schedulesfrm_edit").validate({
    rules: {
        schedule_name: {
            required: true,
            remote: {
                url: "/recruitment/schedules/editvalidname",
                type: "get",
                data: {
                    id: function () {
                        return $('#schedulesfrm_edit :input[name="schedule_id"]').val();
                    }
                }
            }
        },

    },
    messages: {
        schedule_name: {
            required: "Please Enter Schedule Name",
            remote: "This Schedule Name Already Exist"
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

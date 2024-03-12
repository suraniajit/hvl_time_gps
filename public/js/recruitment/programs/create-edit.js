// script for validation in create page
$("#programs").validate({
    rules: {
        program_name: {
            required: true,
            remote: {
                url:  "/recruitment/programs/validname/",
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
        program_name: {
            required: "Please Enter program Name",
            remote: "This Program Name Already Exist"
        },
        // is_active:{
        //     required:    "Please Select Status",
        // }
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
$("#programs_edit").validate({
    rules: {
        program_name: {
            required: true,
            remote: {
                url:  "/recruitment/programs/editvalidname",
                type: "get",
                data: {
                    id: function () {
                        return $('#programs_edit :input[name="program_id"]').val();
                    }
                }
            }
        },
        // is_active:{
        //     required: true,
        // }
    },
    messages: {
        program_name: {
            required: "Please Enter Program Name",
            remote: "This Program Name Already Exist"
        },
        // is_active:{
        //     required:   "Please Select Status",
        // }
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

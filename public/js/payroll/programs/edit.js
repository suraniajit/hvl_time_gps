// script for validation in create page
$("#frm_programs_edit").validate({
    rules: {
        "program_name": {
            required: true,
            remote: {
                url: "/payroll/programs/editvalidname/",
                type: "get",
                data: {
                    _token: function () {
                        return "{{csrf_token()}}";
                    },
                    id: function () {
                        return $('#frm_programs_edit :input[name="program_id"]').val();
                    }
                }
            }
        },
        "is_active": {
            required: true,
        },
        "lead_1": {
            required: true,
            number: true,
        },
        "employee[]": {
            required: true,
        }
    },
    messages: {
        program_name: {
            required: "Enter Program Name",
            remote: "Program Name Already Exist"
        },
        // is_active:{
        //     required:    "Select Status",
        // }
        lead_1: {
            required: "Enter Amount",
        },
        "employee": {
           required: "Select Employees",
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
$("#programs_edit").validate({
    rules: {
        program_name: {
            required: true,
            remote: {
                url: "/payroll/programs/editvalidname",
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
            required: "Enter Program Name",
            remote: "This Program Name Already Exist"
        },
        // is_active:{
        //     required:   "Select Status",
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

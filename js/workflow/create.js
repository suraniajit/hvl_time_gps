// script for validation in create page
$("#frmworkflowCreate").validate({
    rules: {
        rules_name: {
            required: true,
            remote: {
                url: "/workflow/validname",
                type: "get",
            }
        },

        module_id: {
            required: true,
        },
        is_active: {
            required: true,
        }
    },
    messages: {
        rules_name: {
            required: "Enter Workflow Name",
            remote: "This Already Exist"
        },
        module_id: {
            required: "Select Module",

        },
        is_active: {
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
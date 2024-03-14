// script for validation in create page
$("#frmSubmitCreate").validate({
    rules: {
        module_id: {
            required: true,
            remote: {
                url: "/workflow/validname_submit_rules",
                type: "get",
            }
        },
        ddl_rule_action: {
            required: true,
        }
    },
    messages: {
        module_id: {
            required: "Submit Rules Module",
            remote: "This Already Exist"
        },
        ddl_rule_action: {
            required: "Select Rule Action Module",
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
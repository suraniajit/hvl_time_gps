// script for validation of edit page
$("#frmedit").validate({
    rules: {
        "module_id": {
            remote: {
                url: "/workflow/editvalidname_submit_rules/",
                type: "get",
                data: {
                    id: function () {
                        return $('#frmedit :input[name="submit_rules_id"]').val();
                    }
                }
            }
        },
        ddl_rule_action: {
            required: true,
        }

    },
    messages: {
        "module_id": {
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

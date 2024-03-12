// script for validation in create page
$("#frmedit").validate({
    rules: {
        "name": {
            required: {
                depends: function () {
                    $(this).val($.trim($(this).val()));
                    return true;
                }
            },
            remote: {
                url: "/workflow/editvalidname/",
                type: "get",
                data: {
                    id: function () {
                        return $('#frmedit :input[name="workflow_id"]').val();
                    }
                }
            }
        },

        "is_active": {
            required: true,
        }
    },
    messages: {
        name: {
            required: "Enter Workflow name",
            remote: "This Already Exist"
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
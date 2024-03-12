// script for validation in create page
$("#frmedit").validate({
    rules: {
        "Name": {
            required: {
                depends: function () {
                    $(this).val($.trim($(this).val()));
                    return true;
                }
            },
            remote: {
                url: "/hrms/employee_type/editvalidname/",
                type: "get",
                data: {
                    id: function () {
                        return $('#frmedit :input[name="employee_type_id"]').val();
                    }
                }
            }
        },

        "is_active": {
            required: true,
        }
    },
    messages: {
        Name: {
            required: "Please Employee Type Name",
            remote: "This Already Exist"
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
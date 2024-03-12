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
                url: "/payroll/salary_type/editvalidname/",
                type: "get",
                data: {
                    id: function () {
                        return $('#frmedit :input[name="salary_type_id"]').val();
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
            required: "Enter Salary Type",
            remote: "Salary Type Already Exist"
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
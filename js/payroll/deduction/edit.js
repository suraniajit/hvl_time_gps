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
                url: "/payroll/deduction/editvalidname/",
                type: "get",
                data: {
                    id: function () {
                        return $('#frmedit :input[name="deduction_id"]').val();
                    }
                }
            }
        },
        "deduction_effective_date": {
            required: true,
        },
        "team_id": {
            required: true,
        },
        "deduction_type_id": {
            required: true,
        },
        "txt_value": {
            required: true,
            number: true
        },
        "is_active": {
            required: true,
        }
    },
    messages: {
        "Name": {
            required: "Enter Deduction Name",
            remote: "This Already Exist"
        },
         "deduction_effective_date": {
           required: "Enter Deduction Effective Date",
        },
        "team_id": {
            required: "Select Team",
        },
        "deduction_type_id": {
             required: "Select Deduction Type",
        },
        "txt_value": {
            required: "Enter Value",
            number: "Only Numbers Are Allowed"
        },
        "is_active": {
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
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
                url: "/payroll/allowance/editvalidname/",
                type: "get",
                data: {
                    id: function () {
                        return $('#frmedit :input[name="allowance_id"]').val();
                    }
                }
            }
        },
        "allowance_effective_date": {
            required: true,
        },
        "team_id": {
            required: true,
        },
        "allowance_type_id": {
            required: true,
        },
        "txt_value": {
            required: true,
            number: true,
        },
        "is_active": {
            required: true,
        },
    },
    messages: {
        "Name": {
            required: "Enter Allowance Name",
            remote: "This Already Exist"
        },
        "allowance_effective_date": {
            required: "Enter Allowance Effective Date",
        },
        "team_id": {
            required: "Select Team",
        },
        "allowance_type_id": {
            required: "Select Allowance Type",
        },
        "txt_value": {
            required: "Enter Value",
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
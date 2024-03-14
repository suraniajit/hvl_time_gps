// script for validation in create page
$("#frmAllowanceCreate").validate({
    rules: {
        "Name": {
            required: true,
            remote: {
                url: "/payroll/allowance/validname",
                type: "get",
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
            required: " Enter Value",
            number: true,
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
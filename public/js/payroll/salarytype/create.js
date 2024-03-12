// script for validation in create page
$("#frmCreate").validate({
    rules: {
        Name: {
            required: true,
            remote: {
                url: "/payroll/salary_type/validname",
                type: "get",
            }
        },
        is_active: {
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
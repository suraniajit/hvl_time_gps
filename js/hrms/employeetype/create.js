// script for validation in create page
$("#frmCreate").validate({
    rules: {
        Name: {
            required: true,
            remote: {
                url: "/hrms/employee_type/validname",
                type: "get",
            }
        },
        is_active: {
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
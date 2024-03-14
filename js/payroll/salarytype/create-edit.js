// script for validation in create page
$("#frmCreate").validate({
    rules: {
        Name: {
            required: {
                depends: function () {
                    $(this).val($.trim($(this).val()));
                    return true;
                },
                remote: {
                    url: "/training/category/validname/",
                    type: "get",
                }
            },
        },
        is_active: {
            required: true,
        }
    },
    messages: {
        Name: {
            required: "Please Enter Salary Type",
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
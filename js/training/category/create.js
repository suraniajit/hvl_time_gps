$(document).ready(function () {

    $('.select2').select2({
        dropdownAutoWidth: true,
        placeholder: "Select Course Please",
    });
});

// script for validation in create page
$("#Category_Form").validate({
    rules: {
        "category_name": {
            required: {
                depends: function () {
                    $(this).val($.trim($(this).val()));
                    return true;
                }
            },
            remote: {
                url: "/training/category/validname/",
                type: "get",
            }
        },
        "course_name[]": {
            required: true,
        },
        is_active: {
            required: true,
        }
    },
    messages: {
        "category_name": {
            required: "Please Enter Category Name",
            remote: "Category Already Exist"
        },
        "course_name[]": {
            required: "Please Add Course",

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

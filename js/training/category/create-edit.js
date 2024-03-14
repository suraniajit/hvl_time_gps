$(document).ready(function () {

    $('.select2').select2({
        dropdownAutoWidth: true,
        placeholder: "Select Employee",
    });

});

// script for validation in create page
$("#Category_Form").validate({
    rules: {
        category_name: {
            required: true,
            remote: {
                url: "/training/category/validname/",
                type: "get",
            }
        },
        course_name: {
            required: true,

        },
        is_active: {
            required: true,
        }
    },
    messages: {
        category_name: {
            required: "Please Enter Category Name",
            remote: "This Category Already Exist"
        },
        course_name: {
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

// script for validation of edit page
$("#Category_Form_Edit").validate({
    rules: {
        category_name: {
            required: true,
            remote: {
                url: "/training/category/editvalidname/",
                type: "get",
                data: {
                    id: function () {
                        return $('#Category_Form_Edit :input[name="category_id"]').val();
                    }
                }
            }
        },
        course_name: {
            required: true,

        },
        is_active: {
            required: true,
        }
    },
    messages: {
        category_name: {
            required: "Please Enter Category Name",
            remote: "This Category Already Exist"
        },
        course_name: {
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

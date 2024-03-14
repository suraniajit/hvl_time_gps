
// script for validation
$("#job_type").validate({
    rules: {
        job_type_name: {
            required: {
                depends: function () {
                    $(this).val($.trim($(this).val()));
                    return true;
                }
            },
            remote: {
                url: "/recruitment/jobtype/editvalidname",
                type: "get",
                data: {
                    id: function () {
                        return $('#job_type :input[name="job_id"]').val();
                    }
                }
            }
        },
        is_active: {
            required: true,
        }
    },
    messages: {
        job_type_name: {
            required: "Please Enter Job Type Name",
            remote: "This Job Type Already Exist"
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


$("#formValidate").validate({
    rules: {

        state_name: {
            required: {
                depends: function () {
                    $(this).val($.trim($(this).val()));
                    return true;
                }
            },
                remote: {
                    url: "/state/editvalidname",
                        type: "get",
                    data: {
                        id: function () {
                            return $('#formValidate :input[name="state_id"]').val();
                        }
                    }
                }
        },
        is_active: {
            required: true,
        }
    },
    messages: {

        state_name: {
            required: "Please Enter State Name",
            remote: "Record Already Exist"
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

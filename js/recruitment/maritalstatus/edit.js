//script to allow only digits for marital code
function Validate(event) {
    var regex = new RegExp("^[0-9]");
    var key = String.fromCharCode(event.charCode ? event.which : event.charCode);
    if (!regex.test(key)) {
        event.preventDefault();
        return false;
    }
}
// script for validation
$("#marital_status").validate({
    rules: {
        marital_name: {
            required: {
                depends: function () {
                    $(this).val($.trim($(this).val()));
                    return true;
                }
            },
            remote: {
                url: "/recruitment/maritalstatus/editvalidname",
                type: "get",
                data: {
                    id: function () {
                        return $('#marital_status :input[name="marital_id"]').val();
                    }
                }
            }
        },
        is_active: {
            required: true,
        }
    },
    messages: {
        marital_name: {
            required: "Please Enter Status Name",
            remote: "Marital Status Already Exist"
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

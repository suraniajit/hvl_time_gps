
$(document).ready(function () {
    $('input.maxlength, textarea.maxlength').characterCounter();
// Basic Select2 select
    $(".select2").select2({
        dropdownAutoWidth: true,
        width: '100%'
    });
    $('.dynamic_datepicker').datepicker({
        format: 'yyyy-mm-dd'
    });

    /*password validate start hear*/
    $("#create_user").validate({

        rules: {
            "password": {
                required: true,
                minlength: 8,
            },

            "password": "regex",
        },
        messages: {
            password: {
                required: "Please provide a password",
                minlength: "Your password must be at least 8 characters long",
            },
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

    $.validator.addMethod("regex", function (value, element, regexp) {
        var regexp = /^(?=.*[0-9])(?=.*[!@#$%^&*])[a-zA-Z0-9!@#$%^&*]{6,16}$/;
        var re = new RegExp(regexp);
        return this.optional(element) || re.test(value);
    }, "Please check your password (8-12 Chars, 1 Capital letter, 1 small letter, 1 number, 1 special char).");

});
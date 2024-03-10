/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready(function () {
    $("#formValidate").validate({
        rules: {
            country_name: {
                required: {
                    depends: function () {
                        $(this).val($.trim($(this).val()));
                        return true;
                    }
                },
                remote: {
                    url: "/hrms/country/validname",
                    type: "get",
                }
            },
            is_active: {
                required: true,
            }
        },
        messages: {
            country_name: {
                required: "Please Enter Country Name",
                remote: "This Country Already Exist"
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
});



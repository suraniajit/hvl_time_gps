/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready(function () {
    $("#formValidate").validate({
        rules: {
            country_id: {
                required: true,
            },
            state_name: {
                required: {
                    depends: function () {
                        $(this).val($.trim($(this).val()));
                        return true;
                    }
                },
                remote: {
                    url: "/hrms/state/validname",
                    type: "get",
                    data: {
                        _token: function () {
                            return "{{csrf_token()}}"
                        },
                        id: function ()
                        {
                            return $('#formValidate :input[name="country_id"]').val();
                        }
                    }
                }
            },
            is_active: {
                required: true,
            }
        },
        messages: {
            country_id: {
                required: "Please Select Country"
            },
            state_name: {
                required: "Please Enter Country Name",
                remote: "This State Name Already Exist In These Country"
            },
            is_active: {
                required: "Please Select Status",
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
        }
    });
});

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready(function () {
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
                    url: "/state/validname",
                    type: "get",
                    data: {
                        _token: function () {
                            return "{{csrf_token()}}"
                        },
                        id: function ()
                        {
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
});

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
                    url: "/hrms/country/editvalidname",

                    type: "get",
                    data: {
                        id: function () {
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
            country_name: {
                required: "Please Enter Country Name",
                remote: "This Country Name Already Exist"
            },
            is_active: {
                required: "Please Select Status",
            }
        }
    });
});



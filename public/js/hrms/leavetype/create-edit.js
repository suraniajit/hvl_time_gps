
$(document).ready(function () {
    $("#LeaveTypefrm").validate({
        rules: {

            leaveytype_name: {
                required: {
                    depends: function () {
                        $(this).val($.trim($(this).val()));
                        return true;
                    }
                },
                remote: {
                    url: "/hrms/leavetype/validname/",
                    type: "get",
                }
            },
            Number: {
                required: true,
                number: true
            },
            is_active: {
                required: true,
            }
        },
        messages: {
            leaveytype_name: {
                required: "Please Leave Type Name",
                remote: "This Leave Type Already Exist"
            },
            Number: {
                required: "Please Enter number",
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



    $("#LeaveTypefrmedit").validate({
        rules: {
            leaveytype_name: {
                required: {
                    depends: function () {
                        $(this).val($.trim($(this).val()));
                        return true;
                    }
                },
                remote: {
                    url: "/hrms/leavetype/editvalidname/",
                    type: "get",
                    data: {
                        id: function () {
                            return $('#LeaveTypefrmedit :input[name="leavetype_id"]').val();
                        }
                    }
                },
            },
            Number: {
                required: true,
                number: true
            },
            is_active: {
                required: true,
            }
        },
        messages: {
            leaveytype_name: {
                required: "Please Leave Type Name",
                remote: "This Leave Type Already Exist"
            },
            Number: {
                required: "Please Enter number",
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
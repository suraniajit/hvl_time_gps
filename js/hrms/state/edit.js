
$("#contact_us").validate({
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
                        return $('#contact_us :input[name="country_id"]').val();
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
            required: "Please Select Country First"
        },
        state_name: {
            required: "Please Enter Country Name",
            remote: "This State Name Already Exist In These Country"
        },
        is_active: {
            required: "Please Select Status",
        }
    }
});

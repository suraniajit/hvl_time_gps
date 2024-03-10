
// for fetching states
$('#country_id').change(function () {
    var cid = $(this).val();
    if (cid) {
        $.ajax({
            type: "get",
            url: "/city/getstate",
            data: {
                id: cid
            },
            success: function (res)
            {
                if (res)
                {
                    $("#state_id").empty();
                    $("#state_id").append('<option value="">Select State</option>');
                    $.each(res, function (key, value) {
                        $("#state_id").append('<option value="' + value.id + '">' + value.state_name + '</option>');
                    });
                    $('select').formSelect();
                }
            }
        });
    }
});

// for validation
$("#formValidate").validate({
    rules: {
        country_id: {
            required: true,
        },
        state_id: {
            required: true,
        },
        city_name: {
            required: {
                depends: function () {
                    $(this).val($.trim($(this).val()));
                    return true;
                }
            },
            remote: {
                url: "/city/validname",
                type: "get",
                data: {
                    _token: function () {
                        return "{{csrf_token()}}"
                    },
                    country_id: function ()
                    {
                        return $('#contact_us :input[name="country_id"]').val();
                    },
                    state_id: function ()
                    {
                        return $('#contact_us :input[name="state_id"]').val();
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
        state_id: {
            required: "Please Select State First"
        },
        city_name: {
            required: "Please Enter City Name",
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


// for fetching states
$('#country_id').change(function () {
    var cid = $(this).val();
    if (cid) {
        $.ajax({
            type: "get",
            url: "/hrms/city/getstate",
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
        },
         location:{
            required: true
        },
        latitude:{
            required: true
        },
        longitude:{
            required: true
        },
        is_active: {
            required: true,
        },
    },
    messages: {
        country_id: {
            required: "Please Select Country First"
        },
        state_id: {
            required: "Please Select State First"
        },
        city_name: {
            required: "Please enter city name",
            remote: "This City Name Already Exist In These State"
        },
        location:{
            required: "Please select location from dropdown",
        },
        latitude:{
            required: "Please select location from dropdown"
        },
        longitude:{
            required: "Please select location from dropdown"
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

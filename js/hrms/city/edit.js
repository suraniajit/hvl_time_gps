$('#country').change(function () {
    var cid = $(this).val();
    if (cid) {
        $.ajax({
            type: "get",
            url: "/state/getstate",
            data: {
                id: cid
            },
            success: function (res)
            {
                if (res)
                {
                    $("#state").empty();
                    $("#state").append('<option value="">Select State</option>');
                    $.each(res, function (key, value) {
                        $("#state").append('<option value="' + value.state_id + '">' + value.state_name + '</option>');
                    });
                    $('select').formSelect();
                }
            }

        });
    }
});

// for validation
$("#contact_us").validate({
    rules: {

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
            // remote: {
            //     url: "/city/editvalidname",
            //     type: "get",
            //     data: {
            //         _token: function () {
            //             return "{{csrf_token()}}"
            //         },
            //         country_id: function ()
            //         {
            //             return $('#contact_us :input[name="country_id"]').val();
            //         },
            //         state_id: function ()
            //         {
            //             return $('#contact_us :input[name="state_id"]').val();
            //         }
            //     }
            // }
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
        }
    },
    messages: {
        state_id: {
            required: "Please select state first"
        },
        city_name: {
            required: "Please enter city name",
            remote: "Record Already Exist"
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
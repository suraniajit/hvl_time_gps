$('#billing_state').change(function () {
    var sid = $(this).val();
    if (sid) {
        $.ajax({
            type: "get",
            url: "/city/getCity",
            data: {
                state_id: sid
            },
            success: function (res)
            {
                if (res)
                {
                    $("#billing_city").empty();
                    $("#billing_city").append('<option value="">Select Billing City</option>');
                    $.each(res, function (key, value) {
                        $("#billing_city").append('<option value="' + value.id + '">' + value.city_name + '</option>');
                    });
                    $('select').formSelect();
                }
            }
        });
    }
});
$('#state_id').change(function () {
    var sid = $(this).val();
    if (sid) {
        $.ajax({
            type: "get",
            url: "/city/getCity",
            data: {
                state_id: sid
            },
            success: function (res)
            {
                if (res)
                {
                    $("#city_id").empty();
                    $("#city_id").append('<option value="">Select Shipping City</option>');
                    $.each(res, function (key, value) {
                        $("#city_id").append('<option value="' + value.id + '">' + value.city_name + '</option>');
                    });
                    $('select').formSelect();
                }
            }
        });
    }
});

$("#projectcrea_validate").validate({
    rules: {
         
        project_name: {
            required: true,

        },
        state_id: {
            required: true,

        },
         
        city_id: {
            required: true,

        },
        txt_location: {
            required: true,
        },
    
        is_active: {
            required: true,
        }
    },
    messages: {
        project_name: {
            required: "Please Enter Project Name",
        },
        state_id: {
            required: "Pelase Select State",
        },
        city_id: {
            required: "Pelase Select City",
        },
        txt_location: {
            required: "Please Enter Location",
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
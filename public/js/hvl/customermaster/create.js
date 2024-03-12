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
$('#shipping_state').change(function () {
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
                    $("#shipping_city").empty();
                    $("#shipping_city").append('<option value="">Select Shipping City</option>');
                    $.each(res, function (key, value) {
                        $("#shipping_city").append('<option value="' + value.id + '">' + value.city_name + '</option>');
                    });
                    $('select').formSelect();
                }
            }
        });
    }
});

$("#formValidate").validate({
    rules: {
        'employee_id[]': {
            required: true,
            minlength: 1
        },
        customer_name: {
            required: true,
        },
        customer_code: {
            required: true,
        },
        customer_alias: {
            required: true,
        },
        billing_address: {
            required: true,
        },
        billing_status: {
            required: true,

        },
        contact_person: {
            required: true,

        },
        contact_person_phone: {
            required: true,

        },
        billing_mail: {
            email:true
        },
        billing_mobile: {
            required: true,

        },
        sales_person: {
            required: true,

        },
        status: {
            required: true,

        },
        create_date: {
            required: true,

        },
        shipping_adress: {
            required: true,

        },
        billing_state: {
            required: true,

        },
        billing_city: {
            required: true,

        },
        billing_pincode: {
            required: true,

        },
        
        billing_location:{
            required: true,
        },
        billing_latitude:{
            required: true,
        },
        billing_longitude:{
            required: true,
        },

        shipping_state: {
            required: true,

        },
        shipping_city: {
            required: true,

        },
        shipping_pincode: {
            required: true,

        },
        gst_reges_type: {
            required: true,

        },
        branch: {
            required: true,

        },
        con_start_date: {
            required: true,
        },
        con_end_date: {
            required: true,
        },
        cust_value: {
            required: true
        },
        is_active: {
            required: true,
        }
    },
    messages: {
        employee_id: {
            required: "Please Select Employee",
        },
        customer_name: {
            required: "Pelase Enter Customer Name",
        },
        customer_code: {
            required: "Pelase Enter Customer Code",
        },
        customer_alias: {
            required: "Please Enter Customer Alias",
        },
        billing_address: {
            required: "Please Enter Billing Address",
        },
        billing_status: {
            required: "Please Enter Billing Status",

        },
        contact_person: {
            required: "Please Enter Contact Person",

        },
        contact_person_phone: {
            required: "Please Enter Contact Person PHone",

        },
        billing_mail: {
            email:"Email Should be proper format"
        },
        billing_mobile: {
            required: "Please Enter Billing Mobile",

        },
        billing_location:{
            required: "Please select location from dropdown",
        },
        billing_latitude:{
            required: "Please select location from dropdown",
        },
        billing_longitude:{
            required: "Please select location from dropdown",
        },
        sales_person: {
            required: "Please Enter Sales Person",

        },
        status: {
            required: "Please Select Status",

        },
        create_date: {
            required: "Please Select Create Date",

        },
        shipping_adress: {
            required: "Please Enter Shipping address",

        },
        billing_state: {
            required: "Please Select Billing State",

        },
        billing_city: {
            required: "Please Select Billing City",

        },
        billing_pincode: {
            required: "Please Select Billing Pincode",

        },
        shipping_state: {
            required: "Please Select Shipping State",

        },
        shipping_city: {
            required: "Please Select Shipping City",

        },
        shipping_pincode: {
            required: "Please Select Shipping Pincode",

        },
        gst_reges_type: {
            required: "Please Select GST Regestration",

        },
        branch: {
            required: "Please Select Branch",

        },
        con_start_date: {
            required: "Please Select Contract Start Date",
        },
        con_end_date: {
            required: "Please Select Contract End Date",
        },
        cust_value: {
            required: "Please Enter Value",
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
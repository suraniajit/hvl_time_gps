
$("#formValidate").validate({
    ignore: [],
    rules: {
        company_type: {
            required: true,
        },
        compnay_name: {
            required: true,
        },
        f_name: {
            required: true,
        },
        email: {
            email:true,
        },
        phone: {
            required: true,

        },
        // flag:{
        //     proposalcheck:true,
        // },

        employee: {
            required: true,

        },
        // owner: {
        //     required: true,

        // },
        create_date: {
            required: true,

        },
        // follow_date: {
        //     required: true,
        // },
        // status: {
        //     required: true,
        // },
        // rating: {
        //     required: true,
        // },
        // lead_source: {
        //     required: true,
        // },
        // industry: {
        //     required: true,
        // },
        // address: {
        //     required: true,
        // },
        // comment: {
        //     required: true,
        // },
        revenue: {
            // required: true,
            minlength:4,
            digits: true,
        },
        
        // lead_size: {
        //     required: true,
        // },
        is_active: {
            required: true,
        }
    },
    messages: {

        company_type: {
            required: "Please Select Company Type",
            // remote: "This Already Exist"
        },
        compnay_name: {
            required: "Please Enter Company Name",
        },
        f_name: {
            required: "Please Enter First Name",
        },
        // email: {
        //     required: "Please Enter Email",
        //     email:"Email Format Is Not Proper"
        // },
        phone: {
            required: "Please Enter Phone Number",
        },
        employee: {
            required: "Please Select Employee",
        },
        owner: {
            required: "Please Enter Owner Name",
        },
        create_date: {
            required: "Please Select Create Date",
        },
        follow_date: {
            required: "Please Select Follow Up Date",
        },
        status: {
            required: "Please Select Lead Status",
        },
        rating: {
            required: "Please Select Rating",
        },
        lead_source: {
            required: "Please Enter Lead Source",
        },
        industry: {
            required: "Please Select Industry",
        },
        address: {
            required: "Please Enter Address",
        },
        comment: {
            required: "Please Enter Comment",
        },
        revenue:{
            required: "Please Enter Revenue",
        },
        lead_size: {
            required: "Please Select Lead Size",
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

jQuery.validator.addMethod("proposalcheck", function(value) {
    if(value === '0'){
            if($('#status').val()==='4'){
                return false;
            }
            return true;
     }
    return true;
}, 'please select proposal');
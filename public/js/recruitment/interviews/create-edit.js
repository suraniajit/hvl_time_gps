// script for validation in create page
$("#Interview_Form").validate({
    rules: {
        interview_type: {
            required: true,

        },
        interview_date: {
            required: true,
        },
        interviewer_name: {
            required: true,

        },
        interview_note: {
            required: true,

        },
        interview_status:{
            required: true,
        }
    },
    messages: {

        interview_type: {
            required: "Please Select Interview Name",
        },
        interview_date: {
            required: "Please Enter Date",
        },
        interviewer_name: {
            required: "Please Select Interviewer",

        },
        interview_note: {
            required: "Please Add A Note",

        },
        interview_status:{
            required: "Please Select Status",
        }
    },
    errorElement: 'div',
    errorPlacement: function(error, element) {
        var placement = $(element).data('error');
        if (placement) {
            $(placement).append(error)
        } else {
            error.insertAfter(element);
        }
    }
});

// script for validation of edit page
$("#Interview_Form_Edit").validate({
    rules: {
        interview_date: {
            required: true,
        },
        interviewer_name: {
            required: true,

        },
        interview_note: {
            required: true,

        },
        interview_status:{
            required: true,
        }
    },
    messages: {
        interview_date: {
            required: "Please Enter Date",
        },
        interviewer_name: {
            required: "Please Select Interviewer",

        },
        interview_note: {
            required: "Please Add A Note",

        },
        interview_status:{
            required: "Please Select Status",
        }
    },
    errorElement: 'div',
    errorPlacement: function(error, element) {
        var placement = $(element).data('error');
        if (placement) {
            $(placement).append(error)
        } else {
            error.insertAfter(element);
        }
    }
});


// Script for Validating the insert data
$("#inter_viewface_frm").validate({
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
             maxlength: 200
        },
        interview_status: {
            required: true,
        },
        program_id: {
            required: true,
        },
        schedule_id: {
            required: true,
        },
        compensation: {
//            required: true,
        }
    },
    messages: {
        interview_type: {
            required: 'Please select Interview type ',
        },
        interview_date: {
            required: 'Enter Interview Date first',
        },
        interviewer_name: {
            required: 'Enter Email Id',
        },
        interview_note: {
            required: 'Enter interview not please',
        },
        interview_status: {
            required: 'Enter interview status',
        },
        program_id: {
            required: 'Enter program name',
        },
        schedule_id: {
            required: 'Enter sheduale name',
        },
        compensation: {
            required: 'Enter compensation amount',
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
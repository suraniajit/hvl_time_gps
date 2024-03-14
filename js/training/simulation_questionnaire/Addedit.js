$("#SimulateCourse_Form_Edit").validate({
    rules: {
        "question": {
            required: true,
            maxlength: 25
        },
        "answer": {
            required: true
        },
        "option": {
            required: true
        },
        "bg_image": {
            required: true
        },
        "question_image": {
            required: true
        },
        "right_answer_image": {
            required: true
        },
        "wrong_answer_image": {
            required: true
        }
    },
    messages: {
        "question": {
            required: "Enter Question"
        },
        "answer": {
            required: "Enter Answer"
        },
        "option": {
            required: "Enter Option"
        },
        "bg_image": {
            required: "Select Background Image"
        },
        "question_image": {
            required: "Select Question Image"
        },
        "right_answer_image": {
            required: "Select Right Answer Image"
        },
        "wrong_answer_image": {
            required: "Select Wrong Answer Image"
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

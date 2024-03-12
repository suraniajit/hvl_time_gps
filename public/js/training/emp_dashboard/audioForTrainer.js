
user_audio_answers_id = $('#user_audio_answers_id').val();

function rightAnswer(id) {
    $('.right').each(function ()
    {
        if ($(this).attr('id') == id)
        {
            
            var course_id = $('#course_id' + id).val();
            var user_id = $('#user_id' + id).val();
            var questionnaire_id = $('#questionnaire_id' + id).val();
            var audio_question_id = $('#audio_question' + id).val();
            var set_name = $('#set_name' + id).val();
            var comment = $('#comment').val();
            var result = 1;

//            alert('comment' + result);
//            $(this).attr('disabled', true);

            swal({
                title: "Are you sure that answer is correct?",
                icon: 'warning',
                dangerMode: true,
                buttons: {
                    cancel: 'No',
                    delete: 'Yes'
                }
            }).then(function (willDelete) {
                if (willDelete) {
                    $.ajax({
                        type: "get",
                        url: '/training/useraudioanswer',
                        data: {
                            'couserId': course_id,
                            'userId': user_id,
                            'questionnaireId': questionnaire_id,
                            'audioQuestionId': audio_question_id,
                            'SetName': set_name,
                            'comment': comment,
                            'result': result
                        }, success: function () {
//                            swal("Poof! Your has been deleted.", {
//                                icon: "success",
//                            });


//                            var split_id = id.split("_");
//                            var deleteindex = split_id[1];
                            $("#div_" + id).hide();

                            location.reload();
                        },
                    });
                } else {
//                    swal("Your " + textMassage + " is safe", {
//                        title: 'Cancelled',
//                        icon: "error",
//                    });
//                    return false;
                }

            });
        }
    });
//    $('.wrong').each(function ()
//    {
//        if ($(this).attr('id') == id) {
//            $(this).attr('disabled', true);
//        }
//    });
}
function wrongAnswer(id) {

    $('.wrong').each(function ()
    {
        if ($(this).attr('id') == id)
        {
            var course_id = $('#course_id' + id).val();
            var user_id = $('#user_id' + id).val();
            var questionnaire_id = $('#questionnaire_id' + id).val();
            var audio_question_id = $('#audio_question' + id).val();
            var set_name = $('#set_name' + id).val();
//            var comment = $('#comment' + id).val();
            var comment = $('#comment').val();
            var result = 2;
//            alert('fail' + result);
//            $(this).attr('disabled', true);

            swal({
                title: "Are you sure that answer is wrong?",
                icon: 'warning',
                dangerMode: true,
                buttons: {
                    cancel: 'No',
                    delete: 'Yes'
                }
            }).then(function (willDelete) {
                if (willDelete) {
                    $.ajax({
                        type: "get",
                        url: '/training/useraudioanswer',
                        data: {
                            'couserId': course_id,
                            'userId': user_id,
                            'questionnaireId': questionnaire_id,
                            'audioQuestionId': audio_question_id,
                            'SetName': set_name,
                            'comment': comment,
                            'result': result
                        }, success: function () {
//                            swal("Poof! Your has been deleted.", {
//                                icon: "success",
//                            });
                            $("#div_" + id).hide();
                            location.reload();
                        },
                    });
                } else {
//                    swal("Your " + textMassage + " is safe", {
//                        title: 'Cancelled',
//                        icon: "error",
//                    });
//                    return false;
                }
            });
        }
    });
//    $('.right').each(function ()
//    {
//        if ($(this).attr('id') == id) {
//            $(this).attr('disabled', true);
//        }
//    });
}

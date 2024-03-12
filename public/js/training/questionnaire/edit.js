$(document).ready(function () {
    $('.modal').modal();
    var no = 0;
    var count = 0;
    var html = '';
    var Audio = '';
    var max = 9;
    var min = 2;
    $('#recording_ui').hide();
    $('#add').click(function () {
        var is_question_type = $('#is_question_type option:selected').val();
//        alert(is_question_type);
        $("#item_table").empty();
        if (is_question_type == 1) {
             $('#recording_ui').hide();
            no += 1;
            if (no == 1) {
//                console.log(no);

                html += '<div class="row"><div class="input-field col s6">' +
                        '<input type="text" name="question_name" id="question_name" Placeholder="Enter MCQ Quesiton">';
                html += '</div>';
                $("#file_error").html('');
                $(document).on('click', '.add', function () {
                    $("#file_error").html('');
//                    html += '<span id="newsletter_topics"><label for="checkBox" class="error">Please select at least one option as an answer</label>';
                    count += 1;

                    console.log('count' + count);
                    if (count < max) {

                        html += '<div class="element" id="div_' + count + '"> <label>' +
                                '<input type="checkbox"  class="filled-in" name="checkBox[]" id="checkBox" value="' + count + '" />' +
                                '<span><input type="text" name="que_options[]" id="que_options[]" Placeholder="Enter Answer Please" required="" style="width: 564px;" ></span>' +
                                '</label><span id="' + count + '" class="remove">X</span></div>';
                        $('#item_table').append(html);
                        html = '';
                    } else {
//                        alert('Not More then 8');
                        $("#file_error").html("<p style='color: #FF4081;font-size: smaller;'>Not More then 8 option</p>");
                    }

                });
//                html += '</span>';
                html += '<button type="button" name="add" class="btn btn-success add" style="    margin-top: 19px;">' +
                        '<i class="material-icons dp48">add</i>' +
                        '</button>';
                html += '</div>';
                $('#item_table').append(html);
            } else {
                $("#item_table").empty();
                location.reload();
//                alert('One by one please..');
            }


        } else if (is_question_type == 2) {
            $("#file_error").html('');
            $("#item_table").empty();
             $('#recording_ui').show();
//            html = ' <div class="row">' +
//                    ' <div class="col s6">' +
//                    '  <input type="text" name="question_name" id="question_name" Placeholder="Enter Audio Quesiton Name ">' +
//                    ' </div>' +
//                    '  <div class="col s2">' +
//                    '  <label>Recordings</label><br>' +
//                    ' <button type="button" class="btn-small" id="start-btn">Start </button> ' +
//                    ' <button type="button" class="btn-small" id="stop-btn" disabled>Stop </button>' +
//                    ' <ul id="recordingslist"></ul>' +
//                    ' </div>' +
//                    '  <div class="col s4">' +
//                    ' <label>Upload File</label><br>' +
//                    ' <input type="file" name="audio" id="audio" accept=".wav,.aac,.mp3,audio/*"><br>' +
//                    ' </div>' +
//                    '</div>';
            $('#item_table').append(html);
        } else {
            $("#item_table").empty();
            $("#file_error").html("<p style='color: #FF4081;font-size: smaller;'>Select Question Type</p>");
//            alert('Select Question Type !.');
        }

        html = '';
//        return false;


        $(document).on('click', '.remove', function () {
            var id = this.id;
            // alert(id);
            var split_id = id.split("_");
            var deleteindex = split_id[1];
//            alert(deleteindex);
            // Remove <div> with id
            $("#div_" + id).remove();
//            if (count < max) {
//            } else {
//                alert('Not More then 8');
//            }

        });
    });
//******************************************************************************


// script for validation in create page
    $("#questionnaire_edit_form").validate({
        rules: {
            "questionnaire_name": {
                required: true,
                maxlength: 35,
                remote: {
                    url: "/training/questionnaire/editvalidname",
                    type: "get",
                    data: {
                        id: function () {
                            return $('#questionnaire_edit_form :input[name="questionnaire_id"]').val();
                        }
                    }
                }
            },
            "is_question_type": {
//                required: true,
            },
            "question_name": {
                required: true,
            },
            "que_options[]": {
                required: true,
            },
            "checkBox[]": {
//                required: "#checkbox:checked",
//                minlength: 2
            },
            "audio": {
                required: true,
                accept: "aac|mp3|oga"
            },
            "is_active": {
                required: true,
            }
        },
        messages: {
            "questionnaire_name": {
                required: "Enter Questionnaire Name",
                remote: "This Questionnaire Name Already Exist"
            },
            "is_question_type": {
//                required: "please select Question Type",
            },
            "question_name": {
                required: "Enter Question Name",
            },
            "que_options[]": {
                required: "Enter Question Answer",
            },
            "checkBox[]": {
//                required: "Please select at least 2 topics"
            },
            "is_active": {
                required: "Select Status",
            },
            "audio": {
                required: "Please upload audio .mp3/.aac/.oga format",
                accept: "Please upload audio .mp3/.aac/.oga format",
            }
        },
//        highlight: function (label) {
//            $(label).closest('.control-group').addClass('error');
//        },
//        success: function (label) {
//            label.text('Please select at least one option as an answer111').addClass('valid').closest('.control-group').addClass('success');
//        },
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
}); 
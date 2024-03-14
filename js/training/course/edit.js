
$(document).ready(function () {
// script for validation of edit page
    $("#Course_Form_Edit").validate({
        rules: {
            "course_image": {
                accept: "jpg|jpeg|png",
            },
            "course_title": {
                required: true,
                maxlength: 25,
                remote: {
                    url: "/training/course/editvalidname/",
                    type: "get",
                    data: {
                        id: function () {
                            return $('#Course_Form_Edit :input[name="course_id"]').val();
                        }
                    }
                }
            },
            "pass_criteria": {
                required: true,
                range: [1, 100],
                number: true
            },
            "add_pass_criteria": {
                required: true,
                range: [1, 100],
                number: true
            },
            "is_active": {
                required: true,
            },
            "start_date": {
                required: true,
            },
            "end_date": {
                required: true,
            },
            "assign": {
                required: true,
            },
            "trainer": {
                required: true,
            },

//            "teams": {
//                required: true,
//            },
//            "departments": {
//                required: true,
//            },
            "employee[]": {
                required: true,
            },
        },
        messages: {
            "course_image": {
                required: "Select One Image",
                accept: "Image With This Type Of Extension Is Not Allowed"
            },
            "course_title": {
                required: "Enter Course Title",
                remote: " This Course Title Already Exist"
            },
            "pass_criteria": {
                required: "Enter Passing Criteria",
                number: "Only Numbers Are Allowed"
            },
            "add_pass_criteria": {
                required: "Enter Passing Criteria by",
                number: "Only Numbers Are Allowed"
            },
            "is_active": {
                required: "Select Status",
            },

            "questionnaire": {
                required: "Select Any One Questionnaire",
            },
            "trainer": {
                required: "Select Trainer",
            },
            "start_date": {
                required: "Select Start Date",
            },
            "end_date": {
                required: "Select Close Date",
            },
            "assign": {
                required: "Select Assign To",
            },
//            "teams": {
//                required: "Select Team ",
//            },
//            "departments": {
//                required: "Select Departments ",
//            },
            "employee[]": {
                required: "Select Employee ",
            },
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









    /* Script ot add new media with questionnaire */

//    var count = $('#old_set_id').val();
//    var no = count = '1';
//            console.log(count);
    var count = -1;
    var no = 0;
    $(document).on('click', '.add2', function () {
//        alert();
        var html = '';
        count++;
        no++;

        dynamic_field(count);

        function dynamic_field(count) {

            html += '<div class="col s12 m6 main">' +
                    '<div class="card">' +
                    '   <div class="card-content">' +
                    '   <span class="card-title">Media </span>' +
                    '       <div class="input-field col s6">' +
                    '           <span class="col s12 m8 l9">' +
                    '               <input id="files" type="file" name="files[' + count + '][]"  class="dropify-event" multiple>' +
                    '           </span>' +
                    '       </div>' +
                    '       <div class=" col s12">' +
                    // '    <label>Enter Set Name *</label>' +
                    '            <input type="text" id="set_id" name="set_id[' + count + '][]" autocomplete="off" class="set_name" placeholder="Enter Set Name" onkeyup="myFunction()" >' +
                    '       </div>' +
                    '<div class="col s12">' +
                    '    <select name="questionnaire[' + count + '][]" id="questionnaire' + count + '" class="select2 browser-default questionnaires" multiple  data-error=".errorTxt3">' +
                    '   </select>' +
                    '</div>' +
                    ' <div class="card-action center">' +
                    '    <button type="button" name="remove" class="btn btn-danger btn-sm remove" style="background-color: red;"><i class="material-icons dp48">delete</i></button>' +
                    ' </div>' +
                    '</div>' +
                    '</div>' +
                    '</div>'
                    ;
            $('#Education_Table').append(html);
            $('.select2').select2();
        }

        $.ajax({
            type: "get",
            url: "/training/course/fetchquestionnaire",
            success: function (res) {
                if (res) {
                    $("#questionnaire" + count).empty();
                    // $(".questionnaires").append('<option value="">Select questionnaire</option>');
                    $.each(res, function (key, value) {
                        $("#questionnaire" + count).append('<option value="' + value.id + '">' + value.questionnaire_name + '</option>');
                    });
                    $('.select2').select2({
                        dropdownAutoWidth: true,
                        placeholder: "Select Questionnaire",
                    });
                }
            }

        });
    });
    $(document).on('click', '.remove', function () {
        $(this).closest('.main').remove();
    });



});
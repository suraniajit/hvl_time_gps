$(document).ready(function () {

    var questionnaire_id = $('#questionnaire_id').val();

    $('#simulation_questions_datatable').DataTable({
        "processing": true,
        "serverSide": false,
        "ajax": "/training/simulation_questionnaire/get_questions_data/"+questionnaire_id,
        "columns": [
            {"data": "question_id"},
            {"data": "question"},
            {"data": "answer"},
            {"data": "option"},
            {"data": "action", orderable: false, searchable: false},
        ],
        "order": [[0, "asc"]],
        "lengthMenu": [
            [10, 25, 50, -1],
            [10, 25, 50, "All"]
        ],
        "fnRowCallback": function (nRow, aData, iDisplayIndex) {
            $("td:nth-child(1)", nRow).html(iDisplayIndex + 1);
            return nRow;
        },
    });
});
$(document).on('click', '.delete', function () {
    var question_id = $(this).attr('id');
    var questionnaire_id = $('#questionnaire_id').val();
    console.log(question_id);
    console.log(questionnaire_id);
    swal({
        title: "Are you sure?",
        text: "Are You Sure You Want To Delete This Question?",
        icon: 'warning',
        dangerMode: true,
        buttons: {
            cancel: 'No, Please!',
            delete: 'Yes, Delete It'
        }
    }).then(function (willDelete) {
        if (willDelete) {
            $.ajax({
                url: "/training/simulation_questionnaire/delete_question",
                method: "get",
                data: {"Question_id": question_id},
                success: function (data)
                {
                    $('#simulation_questions_datatable').DataTable().ajax.reload();
                    swal("Poof! Your Question has been deleted.", {
                        icon: "success",
                    });
                }
            })
        } else {
            swal("Your Question is safe", {
                title: 'Cancelled',
                icon: "error",
            });
            $('input[type=checkbox]').each(function ()
            {
                $(this).prop('checked', false);
            });
            return false;
        }
    });
});

$("#simulation_questionnaire_form_edit").validate({
    rules: {
        questionnaire_name: {
            required: true,
            maxlength: 25,
            remote: {
                url: "/training/simulation_questionnaire/editvalidname",
                type: "get",
                data: {
                    id: function () {
                        return $('#simulation_questionnaire_form_edit :input[name="questionnaire_id"]').val();
                    }
                }
            }
        },
        is_active: {
            required: true,
        }

    },
    messages: {
        questionnaire_name: {
            required: "Please Enter Questionnaire Name",
            remote: "This Questionnaire Already Exists"
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



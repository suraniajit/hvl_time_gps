$(document).ready(function () {

    $('#course_datatable').DataTable({
        "processing": true,
        "serverSide": false,
        "ajax": "/training/course/getdata",
        "columns": [
            {"data": "id"},
            {"data": "course_title"},
            {"data": "full_Name"},
            {"data": "total_media"},
            {"data": "assign_to"},
            // {"data": "assign_to_employees"},
            {"data": "is_active"},
            {"data": "action", orderable: true},
            {"data": "checkbox", orderable: true},
            {"data": "preview"}
        ],
        "order": [[0, "desc"]],
        "oLanguage": {
            "sInfo": "Showing _START_ to _END_ of _TOTAL_ items."
        },
        "lengthMenu": [
            [10, 25, 50, -1],
            [10, 25, 50, "All"]
        ], "fnRowCallback": function (nRow, aData, iDisplayIndex) {
            $("td:nth-child(1)", nRow).html(iDisplayIndex + 1);
            return nRow;
        }
    }
    );
});

var textMassage = 'Course';
//single data delete
$(document).on('click', '.delete', function () {

    var id = $(this).attr('id');
    swal({
        title: "Are you sure?",
        text: "Are You Sure You Want To Delete This " + textMassage + "?",
        icon: 'warning',
        dangerMode: true,
        buttons: {
            cancel: 'No, Please!',
            delete: 'Yes, Delete It'
        }
    }).then(function (willDelete) {
        if (willDelete) {
            $.ajax({
                url: "/training/course/removedata",
                mehtod: "get",
                data: {id: id},
                success: function (data) {
                    $('#course_datatable').DataTable().ajax.reload();
                    swal("Poof! Your " + textMassage + " has been deleted.", {
                        icon: "success",
                    });
                }
            })
        } else {
            swal("Your " + textMassage + " is safe", {
                title: 'Cancelled',
                icon: "error",
            });
            $('input[type=checkbox]').each(function () {
                $(this).prop('checked', false);
            });
            return false;
        }
    });
});


// multipule delete
$(document).on('click', '#bulk_delete', function () {


    var id = [];
    /**/
    swal({
        title: "Are you sure?",
        text: "Are You Sure You Want To Delete This All " + textMassage + "s?",
        icon: 'warning',
        dangerMode: true,
        buttons: {
            cancel: 'No, Please!',
            delete: 'Yes, Delete It'
        }
    }).then(function (willDelete) {
        if (willDelete) {
            $('#CourseCheckbox:checked').each(function () {
                id.push($(this).val());
            });
            if (id.length > 0) {
                $.ajax({
                    url: "/training/course/massremove",
                    method: "get",
                    data: {id: id},
                    success: function (data) {
                        $('#course_datatable').DataTable().ajax.reload();
                        swal("Poof! Your " + textMassage + " has been deleted.", {
                            icon: "success",
                        });
                    }
                });
            } else {
                swal('Please select atleast one checkbox', {
                    title: 'Warning',
                    icon: 'warning'
                })
            }
        } else {

            swal("Your " + textMassage + "s are safe", {
                title: 'Cancelled',
                icon: "error",
            });
            $('input[type=checkbox]').each(function () {
                $(this).prop('checked', false);
            });
        }
    });
});

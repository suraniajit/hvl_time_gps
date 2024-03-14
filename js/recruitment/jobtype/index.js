$(document).ready(function () {


    $('#jobtype_datatable').DataTable({
        "processing": true,
        "serverSide": false,
        "ajax": "/recruitment/jobtype/getdata",
        "columns": [
            {"data": "id"},
            {"data": "job_type_name"},
            {"data": "name"},
            {"data": "action", orderable: false, searchable: false},
            {"data": "checkbox", orderable: false, searchable: false}
        ],
        "order": [[1, "desc"]],
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

var textMassage = 'Job-Type';
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
                url: "/recruitment/jobtype/removedata",
                mehtod: "get",
                data: {id: id},
                success: function (data)
                {
                    $('#jobtype_datatable').DataTable().ajax.reload();
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
            $('input[type=checkbox]').each(function ()
            {
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
            $('.jobtype_checkbox:checked').each(function () {
                id.push($(this).val());
            });
            if (id.length > 0)
            {
                $.ajax({
                    url: "/recruitment/jobtype/massremove",
                    method: "get",
                    data: {id: id},
                    success: function (data)
                    {
                        $('#jobtype_datatable').DataTable().ajax.reload();
                        swal("Poof! Your " + textMassage + "s has been deleted.", {
                            icon: "success",
                        });
                    }
                });
            } else
            {
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
            $('input[type=checkbox]').each(function ()
            {
                $(this).prop('checked', false);
            });
        }
    });
});

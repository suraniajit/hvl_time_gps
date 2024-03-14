$(document).ready(function () {


    $('#candidate_datatable').DataTable({
        "processing": true,
        "serverSide": false,
        "ajax": "/recruitment/candidate/getdataAllCandidate",
        "columns": [
            {"data": "id"},
            {"data": "created_at",
                render: function (data, type, row) {
                    return data;
                }
            },
            {"data": "full_name"},
            {"data": "phone"},
            {"data": "email"},
            {"data": "gender_name"},
            {"data": "current_salary"},
            {"data": "status_name"},
            {"data": "action", orderable: false, searchable: false},
            {"data": "checkbox", orderable: false, searchable: false}
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
    });


    /*Shortlisted*/
    $('#candidate_shortlisted_datatable').DataTable({
        "processing": true,
        "serverSide": false,
        "ajax": "/recruitment/candidate/getdataShortListed",
        "columns": [
            {"data": "id"},
            {"data": "hire_date"},
            {"data": "full_name"},
            {"data": "phone"},
            {"data": "email"},
            {"data": "gender_name"},
            {"data": "current_salary"},
            {"data": "name"},
            {"data": "action", orderable: false, searchable: false},
            {"data": "checkbox", orderable: false, searchable: false}
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
    });

    /*NotshortList*/
    $('#candidate_NotshortList_datatable').DataTable({
        "processing": true,
        "serverSide": false,
        "ajax": "/recruitment/candidate/getdataNotShortListed",
        "columns": [
            {"data": "id"},
            {"data": "full_name"},
            {"data": "phone"},
            {"data": "email"},
            {"data": "gender_name"},
            {"data": "current_salary"},
            {"data": "name"},
            {"data": "action", orderable: false, searchable: false},
            {"data": "checkbox", orderable: false, searchable: false}
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
    });

    $('#candidate_datatable').DataTable().ajax.reload();
    $('#candidate_shortlisted_datatable').DataTable().ajax.reload();
    $('#candidate_NotshortList_datatable').DataTable().ajax.reload();



});



var textMassage = 'Candidate';
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
                url: "/recruitment/candidate/removedata",
                mehtod: "get",
                data: {id: id},
                success: function (data)
                {
                    $('#candidate_datatable').DataTable().ajax.reload();
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
            $('#CandidateCheckbox:checked').each(function () {
                id.push($(this).val());
            });
            if (id.length > 0)
            {
                $.ajax({
                    url: "/recruitment/candidate/massremove",
                    method: "get",
                    data: {id: id},
                    success: function (data)
                    {
                        $('#candidate_datatable').DataTable().ajax.reload();
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
 
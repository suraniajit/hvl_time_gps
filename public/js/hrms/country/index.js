$(document).ready(function () {
    $('#student_table').dataTable({
        "dom": 'Blfrtip',
        "lengthMenu": [10, 25, 50, 75, 100],
        "processing": true,
        "serverSide": false,
        ajax: route + "/hrms/country/getdata",
        columns: [
            {"data": "DT_RowIndex"},
            {"data": "country_name"},
            {"data": "is_active"},
            {"data": "action", orderable: false, searchable: false},
            {"data": "checkbox", orderable: false, searchable: false}
        ],
    });
});
//single data delete
$(document).on('click', '.delete', function () {
    var id = $(this).attr('id');
    swal({
        title: "Are you sure?",
        text: "You will not be able to recover this imaginary file!",
        icon: 'warning',
        dangerMode: true,
        buttons: {
            cancel: 'No, Please!',
            delete: 'Yes, Delete It'
        }
    }).then(function (willDelete) {
        if (willDelete) {
            $.ajax({
                url: route + "/hrms/country/removedata",
                mehtod: "get",
                data: {id: id},
                success: function (data) {
                    swal("Poof! Your Country has been deleted!",
                            {
                                icon: "success",
                            });
                    $('#student_table').DataTable().ajax.reload();
                }
            })

        } else {
            return false;
        }
    });
});

// multipule delete
$(document).on('click', '#bulk_delete', function () {
    var id = [];

    $('#CountryCheckbox:checked').each(function () {
        id.push($(this).val());
    });
    if (id.length > 0)
    {
        swal({
            title: "Are you sure?",
            text: "You will not be able to recover this imaginary file!",
            icon: 'warning',
            dangerMode: true,
            buttons: {
                cancel: 'No, Please!',
                delete: 'Yes, Delete It'
            }
        }).then(function (willDelete)
        {
            if (willDelete)
            {
                $.ajax({
                    url: route + "/hrms/country/massremove",
                    method: "get",
                    data: {id: id},
                    success: function (data)
                    {
                        swal("Poof! Your imaginary file has been deleted!", {
                            icon: "success",
                        });
                        $('#student_table').DataTable().ajax.reload();
                    }
                });
            } else
            {
                swal("Your imaginary file is safe", {
                    title: 'Cancelled',
                    icon: "error",
                });
                $('#student_table').DataTable().ajax.reload();
            }
        });

    } else
    {
        swal('Please select atleast one checkbox', {
            title: 'Warning',
            icon: 'warning'
        });

    }

});

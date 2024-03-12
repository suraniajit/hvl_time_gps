$(document).ready(function () {
    $('#student_table').DataTable({
        "responsive": true,
        searchable: false,
        "lengthMenu": [
            [10, 25, 50, -1],
            [10, 25, 50, "All"]
        ],

        "processing": true,
        "serverSide": false,
        "ajax": route + "/hrms/state/getdata",
        "columns": [
            {"data": "DT_RowIndex"},
            {"data": "state_name"},
            {"data": "country_name"},
            {"data": "is_active"},
            {"data": "action", orderable: false, searchable: false},
            {"data": "checkbox", orderable: false, searchable: false}
        ]
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
                url: route + "/hrms/state/removedata",
                mehtod: "get",
                data: {id: id},
                success: function (data) {
                    swal("Poof! Your State has been deleted!",
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
    if (confirm("Are you sure you want to Delete this data?"))
    {
        $('#stateCheckbox:checked').each(function () {
            id.push($(this).val());
        });
        if (id.length > 0)
        {
            $.ajax({
                url: route + "/hrms/state/massremove",
                method: "get",
                data: {id: id},
                success: function (data)
                {
                    alert(data);
                    $('#student_table').DataTable().ajax.reload();
                }
            });
        } else
        {
            alert("Please select atleast one checkbox");
        }
    }
});

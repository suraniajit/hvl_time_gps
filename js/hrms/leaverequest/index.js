$(document).ready(function () {

    $('#leaverequest_dataTable').DataTable({
        "processing": true,
        "serverSide": false,
        "ajax": "/hrms/leaverequest/getdata",
        "type":'GET',
        "columns": [
            {"data":"id","width":"5%",},
            {"data": "leavetype_name"},
            {"data": "from_date"},
            {"data": "end_date"},
            {"data": "total_days"},
            {"data": "remark"},
            {"data": "status", render : function(data) {
                    if(data==1){
                        return '<span class="badge green">Approved</span>';
                    }
                    else if(data==0){
                        return '<span class="badge red">Rejected</span>';
                    }
                    else if(data==2){
                        return '<span class="badge brown darken-1">Pending</span>';
                    }
                    else if(data==3){
                        return '<span class="badge brown darken-1">Pending</span>';
                    }
                }
            },
            {"data": "action", orderable: false, searchable: false},
            {"data": "checkbox", orderable: false, searchable: false}

        ],
        "order": [[0, "desc"]],

        "lengthMenu": [
            [10, 25, 50, -1],
            [10, 25, 50, "All"]
        ],
        "fnRowCallback": function (nRow, aData, iDisplayIndex) {
            $("td:nth-child(1)", nRow).html(iDisplayIndex + 1);
            return nRow;
        },
        "info": false   ,
        //"dom": '<"top"f>irt<"bottom"lp><"clear">',
//        "bPaginate": false,
        "paginate":false,
        "bLengthChange": false,
        "bFilter": false,
        "bInfo": false,
        "bAutoWidth": false

    });

});

//single data delete
var textMassage = 'Leave Request';
$(document).on('click', '.delete', function () {
    var id = $(this).attr('id');
    swal({
        title: "Are you sure?",
        text: "Are you sure you want to Delete this " + textMassage + "!",
        icon: 'warning',
        dangerMode: true,
        buttons: {
            cancel: 'No, Please!',
            delete: 'Yes, Delete It'
        }
    }).then(function (willDelete) {
        if (willDelete) {
            $.ajax({
                url: "/hrms/leaverequest/delete/",
                mehtod: "get",
                data: {id: id},
                success: function (data)
                {
                    $('#leaverequest_dataTable').DataTable().ajax.reload();
                    swal("Poof! Leave Request has been deleted!", {
                        icon: "success",
                    });
                }
            })
        } else {
            swal("Your Leave Request is safe", {
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

// multiple delete
$(document).on('click', '#bulk_delete', function () {
    var id = [];
    /**/
    swal({
        title: "Are you sure?",
        text: "Are you sure you want to Delete these Leave Requests ?!",
        icon: 'warning',
        dangerMode: true,
        buttons: {
            cancel: 'No, Please!',
            delete: 'Yes, Delete It'
        }
    }).then(function (willDelete) {
        if (willDelete) {
            $('.leaverequest_checkbox:checked').each(function () {
                id.push($(this).val());
            });
            if (id.length > 0)
            {
                $.ajax({
                    url: "/hrms/leaverequest/multidelete/",
                    method: "get",
                    data: {id: id},
                    success: function (data)
                    {
                        $('#leaverequest_dataTable').DataTable().ajax.reload();
                        swal("Poof! Your Leave Requests have been deleted!", {
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
            swal("Your Leave Requests are safe", {
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




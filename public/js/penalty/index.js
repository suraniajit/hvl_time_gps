$(document).ready(function () {


});

//single data delete
var textMessage = 'Penalty';
$(document).on('click', '.delete', function () {
    var id = $(this).attr('id');
    swal({
        title: "Are you sure?",
        text: "Are you sure you want to Delete this " + textMessage + "!",
        icon: 'warning',
        dangerMode: true,
        buttons: {
            cancel: 'No, Please!',
            delete: 'Yes, Delete It'
        }
    }).then(function (willDelete) {
        if (willDelete) {
            $.ajax({
                url: "penalty/delete/",
                method: "get",
                data: {id: id},
                success: function (data)
                {
                    swal("Poof! "+textMessage+" has been deleted!", {
                        icon: "success",
                    });
                }
            })
        } else {
            swal("Your "+textMessage+" is safe", {
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
        text: "Are you sure you want to Delete these "+textMessage+"s ?!",
        icon: 'warning',
        dangerMode: true,
        buttons: {
            cancel: 'No, Please!',
            delete: 'Yes, Delete It'
        }
    }).then(function (willDelete) {
        if (willDelete) {
            $('.penalty_checkbox:checked').each(function () {
                id.push($(this).val());
            });
            if (id.length > 0)
            {
                $.ajax({
                    url: "penalty/multidelete/",
                    method: "get",
                    data: {id: id},
                    success: function (data)
                    {
                        swal("Poof! Your "+textMessage+"s have been deleted!", {
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
            swal("Your "+textMessage+"s are safe", {
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




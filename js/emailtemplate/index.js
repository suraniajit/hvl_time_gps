//Change Favourites
$(document).on('click', '.fav', function () {
    var id = $(this).attr('id');
    $.ajax({
        url: "emailtemplate/changefav/"+id,
        mehtod: "get",
        data: {id: id},
        success: function (data)
        {
            location.reload();
            swal("Data Updated", {
                icon: "success",
                buttons:false,
                timer:1000,
            });
        }
    })
});


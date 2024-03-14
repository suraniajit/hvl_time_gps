/*================================================================================
 Item Name: Materialize - Material Design Admin Template
 Version: 5.0
 Author: PIXINVENT
 Author URL: https://themeforest.net/user/pixinvent/portfolio
 ================================================================================
 
 NOTE:
 ------
 PLACE HERE YOUR OWN JS CODES AND IF NEEDED.
 WE WILL RELEASE FUTURE UPDATES SO IN ORDER TO NOT OVERWRITE YOUR CUSTOM SCRIPT IT'S BETTER LIKE THIS. */

function goBack() {
    window.history.back();
}

$(document).ready(function () {
    if ($('.collapsible').collapsible()) {
        $('.collapsible').collapsible()
    }

//    $('.collapsible').dropdown();
    $('.progress').fadeIn('slow', function () {
        $('.progress').delay(1500).fadeOut();
    });
    $('#message').fadeIn('slow', function () {
        $('#message').delay(5000).fadeOut();
    });
    $('.close').click(function () {
        $('#message').hide();
        return false;
    });
    $('#msg').fadeIn('slow', function () {
        $('#msg').delay(5000).fadeOut();
    });
    $('.close').click(function () {
        $('#msg').hide();
        return false;
    });
//    setTimeout(function () {
//        M.toast({html: "Hey! Welcome " + $('#hdnSession').val()});
//    }, 2000);

    $(".logout").click(function () {
        swal({
            title: "Are you sure, you want to logout?",
            icon: 'warning',
            icon: '/images/icon/logout-icon.png',

            buttons: {
                cancel: "Cancel",
                catch : {
                    text: "Logout",
                    value: "catch",
                },
            }
        }).then((value) => {
            switch (value) {
                case "catch":
//                    swal("Successful!", "Logging Out", "success");
                    window.location.href = "/user-logout";
                    break;
                default:
//                    swal("Got away safely!");
//                    break;
            }
        });
    });
    var updateDropdown = function (id_ele) {
        var elem = document.getElementById(id_ele);
        var instance = M.Dropdown.getInstance(elem);
        if (instance) {
            if (!instance.isOpen)
                instance.open();
            instance.recalculateDimensions();
        }
    }
});

 
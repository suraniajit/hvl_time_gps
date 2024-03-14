(function (window, document, $) {
    setTimeout(function () {
        M.toast({html: "Hey! Welcome : " + $('#hdnSession').val()});
    }, 2000);

//    setTimeout(function () {
//        M.toast({html: "Hey! Your Role : " + $('#user_role').val()});
//    }, 2000);
})(window, document, jQuery);

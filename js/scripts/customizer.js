/*
 * Theme customizer puclic
 */

var menuBgDefault = false;
$(document).ready(function () {
    /***************START*****************/
//Code to retain Color Font and Size Value



    $.getJSON('/getcustomizerdata', function (result) {

        $.each(result, function (i, field) {
            localStorage.setItem('new_menu', field.menu_color);




            menuColor(field.menu_color);
            navbarColor(field.navbar_color);
            breadcrumbColor(field.breadcrumb_color);
            titleColor(field.title_color);
            btnColor(field.button_color);
            menuDark(field.dark_menu);
            menuSelection(field.menu_selection);
            fontfamily(field.font_family);
            menusize(field.menu_size);
            breadcrumbsize(field.breadcrumb_size);
            titlesize(field.title_size);
            tablesize(field.table_size);
            labelsize(field.label_size);
            iconColor(field.icon_color);





            if (field.menu_color.includes("#")) {
                $("#menu_color").val(field.menu_color);
            } else {
                $(".menu-color-option." + field.menu_color).addClass('selected');
            }

            if (field.navbar_color.includes("#")) {
                $("#navbar_color").val(field.navbar_color);
            } else {
                $(".navbar-color-option." + field.navbar_color).addClass('selected');
            }

            if (field.breadcrumb_color.includes("#")) {
                $("#breadcrumb_color").val(field.breadcrumb_color);
            } else {
                $(".breadcrumb-color-option." + field.breadcrumb_color).addClass('selected');
            }

            if (field.title_color.includes("#")) {
                $("#title_color").val(field.title_color);
            } else {
                $(".title-color-option." + field.title_color).addClass('selected');
            }

            if (field.button_color.includes("#")) {
                $("#button_color").val(field.button_color);
            } else {
                $(".btn-color-option." + field.button_color).addClass('selected');
            }

            if (field.icon_color.includes("#")) {
                $("#icon_color").val(field.icon_color);
            } else {
                $(".icon-color-option." + field.icon_color).addClass('selected');
            }

            $("." + field.menu_selection).attr('checked', 'checked');
        });
    });
    /*************END***************/



    /*************START***************/
    //Getting Value from Color Palette

    $("#icon_color").on("change", function () {
        var icon_color = $("#icon_color").val();
        localStorage.setItem('icon_color', icon_color);
        iconColor(icon_color);
    });
    $("#menu_color").on("change", function () {
        var menu_color = $("#menu_color").val();
        localStorage.setItem('menu_color', menu_color);
        menuColor(menu_color);
    });
    $("#navbar_color").on("change", function () {
        var navbar_color = $("#navbar_color").val();
        localStorage.setItem('navbar_color', navbar_color);
        navbarColor(navbar_color);
    });
    $("#breadcrumb_color").on("change", function () {
        var breadcrumb_color = $("#breadcrumb_color").val();
        localStorage.setItem('breadcrumb_color', breadcrumb_color);
        breadcrumbColor(breadcrumb_color);
    });
    $("#title_color").on("change", function () {
        var title_color = $("#title_color").val();
        localStorage.setItem('title_color', title_color);
        titleColor(title_color);
    });
    $("#button_color").on("change", function () {
        var button_color = $("#button_color").val();
        localStorage.setItem('button_color', button_color);
        btnColor(button_color);
    });
    /*************END***************/


    // Trigger customizer options stat
    $(".theme-cutomizer").sidenav({
        edge: "right"
    });
    // end

    var ps_theme_customiser;
    ps_theme_customiser = new PerfectScrollbar(".theme-cutomizer", {
        suppressScrollX: true
    });
    if ($("body").hasClass("vertical-modern-menu") || $("body").hasClass("vertical-menu-nav-dark")) {
        $(".menu-bg-color").hide();
    } else if ($("body").hasClass("vertical-gradient-menu") || $("body").hasClass("vertical-dark-menu")) {
        $(".menu-color").hide();
        menuBgDefault = true;
    } else if ($("body").hasClass("horizontal-menu")) {
        $(".menu-options").hide();
    }

// Menu Options
// ------------

//Set menu color on select color
    $(".menu-color-option, .menu-bg-color-option").click(function (e) {
        $(".menu-color .menu-color-option, .menu-bg-color .menu-bg-color-option").removeClass("selected");
        $(this).addClass("selected");
        var menu_color = $(this).attr("data-color");
        localStorage.setItem('menu_color', menu_color);
        if (menuBgDefault) {
            /*  menuDark(true);*/
            menuBGColor(menu_color);
        } else {
            menuColor(menu_color);
        }
    });
    //Set menu dark/light
    $(".menu-dark-checkbox").click(function (e) {
        if ($(".menu-dark-checkbox").prop("checked")) {
            localStorage.setItem('menu_dark', 1);
            menuDark(1);
        } else {
            localStorage.setItem('menu_dark', 0);
            menuDark(0);
        }
    });
    //Set menu selection type on select
    $(".menu-selection-radio").click(function (e) {
        var menu_selection = $(this).val();
        localStorage.setItem('menu_selection', menu_selection);
        menuSelection(menu_selection);
    });
    //Set menu selection type on select
    $(".menu-collapsed-checkbox").click(function (e) {
        if ($(".menu-collapsed-checkbox").prop("checked")) {
            menuCollapsed(true);
        } else {
            menuCollapsed(false);
        }
    });
    $(".icon-color-option").click(function (e) {
        $(".icon-color-option").removeClass("selected");
        $(this).addClass("selected");
        var icon_color = $(this).attr("data-color");
        localStorage.setItem('icon_color', icon_color);
        iconColor(icon_color);
    });

    function iconColor(icon_color) {
        removeColorClass(".icon-color");
        $('.icon-color').addClass(icon_color);
        $('.icon-color').css('color', icon_color);
    }



//Function to set menu color
    function menuColor(menu_color) {
        removeColorClass(".sidenav-main .sidenav li a.active");
        $(".sidenav-main .sidenav li a.active").css({background: "none", "box-shadow": "none"});
        $(".sidenav-main .sidenav li a.active").addClass(menu_color + " gradient-shadow");
        $('.sidenav-main .sidenav li a.active').css('background-color', menu_color)
        $('li.tab>.active').addClass(menu_color + " gradient-shadow");

//        $('li.tab>.active').addClass('white-text');
//        $('li.tab>span').addClass('white-text');
//        $('li.tab>.active>span').addClass('white-text');

        // $('li.tab>*').addClass('white-text');



    }
    $('li.tab>span').addClass('black-text');

    $(document).on('click', '.tab', function () {
        removeColorClass('li.tab>a');
        menuColor(localStorage.getItem('new_menu'));
    });


//Function to set  menu bg color
    function menuBGColor(menu_color) {
        removeColorClass(".sidenav-main");
        $(".sidenav-main").addClass(menu_color + " sidenav-gradient");
    }

//Function menu dark/light
    function menuDark(isDark) {
        if (isDark == '1') {
            $(".menu-dark-checkbox").prop("checked", true);
            $(".sidenav-main")
                    .removeClass("sidenav-light")
                    .addClass("sidenav-dark");
            $(".black-icon").css("display", 'none');
            $(".white-icon").css("display", 'inline-block');
        } else if (isDark == '0') {
            $(".menu-dark-checkbox").prop("checked", false);
            $(".sidenav-main")
                    .addClass("sidenav-light")
                    .removeClass("sidenav-dark");
            $(".black-icon").css("display", 'inline-block');
            $(".white-icon").css("display", 'none');
        }
    }

//Menu Selection Type
    function menuSelection(menu_selection) {
        $(".sidenav-main")
                .removeClass("sidenav-active-square sidenav-active-rounded")
                .addClass(menu_selection);
    }


// On click of navbar color
    $(".navbar-color-option").click(function (e) {
        $(".navbar-color .navbar-color-option").removeClass("selected");
        $(this).addClass("selected");
        var navbar_color = $(this).attr("data-color");
        localStorage.setItem('navbar_color', navbar_color);
        navbarDark(true);
        navbarColor(navbar_color);
    });
    //BreadCrumb Settings
    // On click of breadcrumb color
    $(".breadcrumb-color-option").click(function (e) {
        $(".breadcrumb-color-option").removeClass("selected");
        $(this).addClass("selected");
        var breadcrumb_color = $(this).attr("data-color");
        localStorage.setItem('breadcrumb_color', breadcrumb_color);
        breadcrumbColor(breadcrumb_color);
    });
    //Button Color
    $(".btn-color-option").click(function (e) {
        $(".btn-color-option").removeClass("selected");
        $(this).addClass("selected");
        var button_color = $(this).attr("data-color");
        localStorage.setItem('button_color', button_color);
        btnColor(button_color);
    });
    // On click of title color
    $(".title-color-option").click(function (e) {
        $(".title-color-option").removeClass("selected");
        $(this).addClass("selected");
        var title_color = $(this).attr("data-color");
        localStorage.setItem('title_color', title_color);
        titleColor(title_color);
    });
    //Function to set  Title color
    function titleColor(title_color) {
        removeColorClass(".title-color");
        $(".title-color").addClass(title_color);
        $('.title-color').css('color', title_color)
    }

    //Function to set  Breadcrumb color
    function breadcrumbColor(breadcrumb_color) {
        removeColorClass(".breadcrumb-color");
        $(".breadcrumb-color").addClass(breadcrumb_color);
        $('.breadcrumb-color').css('color', breadcrumb_color);
    }

    //Function to set button color
    function btnColor(button_color) {
        removeColorClass(".btn-color");
        $(".btn-color").addClass(button_color);
        $('.btn-color').css('background-color', button_color);
        /*new*/
        $(".paginate_button.current").addClass(button_color);
        $('.paginate_button.current').css('background-color', button_color);
//        $('.paginate_button:hover').addClass(button_color);
//        $('.paginate_button:hover').css('background-color', button_color);
        /*new*/
        $(".paginate_button").hover(function () {
            $(this).addClass(button_color);
            $(this).css(button_color);
        });
    }

    //Function to set navbar dark checkbox
    function navbarDark(isDark) {
        removeColorClass(".navbar-main");
        if (isDark) {
            $(".navbar-dark-checkbox").prop("checked", true);
            $(".navbar-main")
                    .removeClass("navbar-light")
                    .addClass("navbar-dark");
        } else {
            $(".navbar-dark-checkbox").prop("checked", false);
            $(".navbar-main")
                    .addClass("navbar-light")
                    .removeClass("navbar-dark");
        }
    }



    //Function to set  navbar color
    function navbarColor(navbar_color) {
        removeColorClass(".navbar-main");
        removeColorClass(".page-footer");
        $(".navbar-main").addClass(navbar_color);
        $('.navbar-main').css('background-color', navbar_color);
        if ($("body").hasClass("vertical-modern-menu")) {
            removeColorClass(".content-wrapper-before");
            removeColorClass(".page-footer");
            $(".page-footer").addClass(navbar_color);
            $(".page-footer").css('background-color', navbar_color);
            $(".content-wrapper-before").addClass(navbar_color);
            $(".content-wrapper-before").css('background-color', navbar_color);
        }
    }

    //Function to set FontFamily
    function fontfamily(fontfamily) {
        localStorage.setItem('font_family', fontfamily);
        $('html').css('font-family', fontfamily);
    }

    //Function to set MenuSize
    function menusize(size) {
        $('.sidenav li > a').css('font-size', size);
    }

    //Function to set TitleSize
    function titlesize(size) {
        $('.title-color').css('font-size', size);
    }

    //Function to set BreadcrumbSize
    function breadcrumbsize(size) {
        $('.breadcrumb-color').css('font-size', size);
    }

    //Function to set TableSize
    function tablesize(size) {
        $('table').css('font-size', size);
    }

    //Function to set LabelSize
    function labelsize(size) {
        $('label').css('font-size', size);
    }


    //Function to remove set colors
    function removeColorClass(el) {
        $(el).removeClass(
//                "footer-dark gradient-45deg-indigo-purple gradient-45deg-indigo-blue gradient-45deg-purple-deep-orange gradient-45deg-light-blue-cyan gradient-45deg-purple-amber gradient-45deg-purple-deep-purple gradient-45deg-deep-orange-orange gradient-45deg-green-teal gradient-45deg-indigo-light-blue gradient-45deg-red-pink red purple pink deep-purple cyan teal light-blue amber darken-3 brown darken-2 gradient-45deg-indigo-purple gradient-45deg-deep-purple-blue " +
//                "red-text purple-text pink-text deep-purple-text cyan-text teal-text light-blue-text amber brown amber-text brown-text white-text indigo-text pink-text black-text"
                "footer-dark gradient-45deg-indigo-purple gradient-45deg-indigo-blue gradient-45deg-purple-deep-orange gradient-45deg-light-blue-cyan gradient-45deg-purple-amber gradient-45deg-purple-deep-purple gradient-45deg-deep-orange-orange gradient-45deg-green-teal gradient-45deg-indigo-light-blue gradient-45deg-red-pink red purple pink deep-purple cyan teal light-blue amber darken-3 brown darken-2 gradient-45deg-indigo-purple gradient-45deg-deep-purple-blue " +
                "red-text purple-text pink-text deep-purple-text cyan-text teal-text light-blue-text amber brown amber-text brown-text white-text indigo-text pink-text black-text"
                );
    }

    // for rtl
    if ($("html[data-textdirection='rtl']").length > 0) {
        // Trigger customizer options
        $(".theme-cutomizer").sidenav({
            edge: "left"
        });
    }

    /*************START***************/
    //Code to set fontfamily and Font Size

    $('#fontfamily').change(function () {
        localStorage.setItem('font_family', $(this).val());
        fontfamily(localStorage.getItem('font_family'));
    });
    $('#menusize').change(function () {
        var size = $(this).val();
        localStorage.setItem('menu_size', $(this).val());
        menusize(localStorage.getItem('menu_size'));
    });
    $('#breadcrumbsize').change(function () {
        var size = $(this).val();
        localStorage.setItem('breadcrumb_size', $(this).val());
        breadcrumbsize(localStorage.getItem('breadcrumb_size'));
    });
    $('#titlesize').change(function () {
        var size = $(this).val();
        localStorage.setItem('title_size', $(this).val());
        titlesize(localStorage.getItem('title_size'));
    });
    $('#tablesize').change(function () {
        var size = $(this).val();
        localStorage.setItem('table_size', $(this).val());
        tablesize(localStorage.getItem('table_size'));
    });
    $('#labelsize').change(function () {
        var size = $(this).val();
        localStorage.setItem('label_size', $(this).val());
        labelsize(localStorage.getItem('label_size'));
    });
    /*************END***************/

    /*************START***************/
    //Getting Set Colors and adding to DB
    $('#submit').click(function (e) {
        e.preventDefault();
        var menu_color = localStorage.getItem('menu_color');
        if (menu_color === null) {
            menu_color = 'gradient-45deg-purple-deep-purple';
        }
        var menu_selection = localStorage.getItem('menu_selection');
        if (menu_selection === null) {
            menu_selection = 'sidenav-active-square';
        }
        var navbar_color = localStorage.getItem('navbar_color');
        if (navbar_color === null) {
            navbar_color = 'gradient-45deg-purple-deep-purple';
        }
        var breadcrumb_color = localStorage.getItem('breadcrumb_color');
        if (breadcrumb_color === null) {
            breadcrumb_color = 'white-text';
        }
        var menu_dark = localStorage.getItem('menu_dark');
        if (menu_dark === null) {
            menu_dark = '0';
        }
        var title_color = localStorage.getItem('title_color');
        if (title_color === null) {
            title_color = 'black-text';
        }
        var button_color = localStorage.getItem('button_color');
        if (button_color === null) {
            button_color = '#ff4081';
        }
        var menu_size = localStorage.getItem('menu_size');
        if (menu_size === null) {
            menu_size = '12px';
        }
        var breadcrumb_size = localStorage.getItem('breadcrumb_size');
        if (breadcrumb_size === null) {
            breadcrumb_size = '14px';
        }
        var title_size = localStorage.getItem('title_size');
        if (title_size === null) {
            title_size = '32px';
        }
        var table_size = localStorage.getItem('table_size');
        if (table_size === null) {
            table_size = '15px';
        }
        var label_size = localStorage.getItem('label_size');
        if (label_size === null) {
            label_size = '10px';
        }
        var font_family = localStorage.getItem('font_family');
        if (font_family === null) {
            font_family = 'Muli';
        }
        var icon_color = localStorage.getItem('icon_color');
        if (icon_color === null) {
            icon_color = 'blue-text';
        }
        /*Ajax Request Header setup*/
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "/storecustomizer",
            type: 'post',
            data: {
                "menu_color": menu_color,
                "navbar_color": navbar_color,
                "breadcrumb_color": breadcrumb_color,
                "title_color": title_color,
                "button_color": button_color,
                "menu_dark": menu_dark,
                "menu_selection": menu_selection,
                "menu_size": menu_size,
                "title_size": title_size,
                "breadcrumb_size": breadcrumb_size,
                "table_size": table_size,
                "label_size": label_size,
                "font_family": font_family,
                "icon_color": icon_color,
            },
            success: function (response) {
//                alert('Thank you .!! you selected option updated successfully.');
                location.reload();
            },
            error: function (xhr, status, error) {
//                alert('Ohh .!! please retry .' + error + '' + status);
                //location.reload();
            }
        });
    });
    //    /*new logic*/
    //    $('#default').click(function (e) {
//        e.preventDefault();
//        $.ajaxSetup({
//            headers: {
//                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//            }
//        });
//        $.ajax({
//            url: "",
//            type: 'post',
//            success: function (response) {
////                alert('Thank you .!! you selected option updated successfully.');
//                location.reload();
//            },
//            error: function (xhr, status, error) {
////                alert(error);
////                alert('Ohh .!! please retry .' + error + '' + status);
//                location.reload();
//            }
//        });
//    });

    /**************START***************/
    //Google Fonts API
    var api = 'https://www.googleapis.com/webfonts/v1/webfonts?key=AIzaSyDI6Tr7J_5E4s_5exj4Gv57kv3wzVQ_Xv0';
    $.getJSON(api, function (data) {
        for (var i = 0; i < data.items.length; i++) {
            $("#fontfamily").append($('<option></option>').attr('value', data.items[i].family)
                    .text(data.items[i].family)
                    .css('font-family', data.items[i].family));
        }
        $('select').formSelect();
    });
    /*************END***************/

    $('.defaultTheme').click(function () {
        var token = $("meta[name='csrf-token']").attr("content");
        swal({
            title: "Are you sure you want to Default Theme !",
            icon: 'warning',
            dangerMode: true,
            buttons: {
                cancel: 'No, Please!',
                delete: 'Yes, change it'
            }
        }).then(function (willDelete) {
            if (willDelete) {
                $.ajax({
                    type: 'post',
                    url: "/customizerdefault",
                    data: {
                        "_token": token
                    },
                    success: function (data) {
                        swal("Theme is default successfully !", {
                            icon: "success",
                        }).then(function () {
                            location.reload();
                        });
                    }
                })
            } else {
                return false;
            }
        });
    });

});


 
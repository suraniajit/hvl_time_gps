$(document).ready(function () {

    $('.txteditor').mousedown(function () {
        var cmd = $(this).attr('id');
        document.execCommand(cmd);
    });
    $('#hiliteColor').mousedown(function () {
        document.execCommand('hiliteColor', false, 'yellow');
    });
    $('#insertlink').mousedown(function () {
        var linkURL = prompt('Enter a URL:', 'http://');
        document.execCommand('createlink', false, linkURL);
    });
    $('#openbtn').mousedown(function () {
        $("#foreColor").trigger("click");
        $('#foreColor').change(function () {
            var colorr = $(this).val();
            document.execCommand('foreColor', false, colorr);
        });
    });
    $('#openbtn1').mousedown(function () {
        $("#backColor").trigger("click");
        $('#backColor').change(function () {
            var colorr = $(this).val();
            document.execCommand('backColor', false, colorr);
        });
    });


//    $('.selfontsize13').mousedown(function () {
//        var selfontsize13 = $(".selfontsize13").find("option:selected").text();
//        document.execCommand('fontSize', false, selfontsize13);
//    });


    $('.selfontsize').mousedown(function () {
        var size = $(this).attr('id');
         document.execCommand('fontSize', false, size);
    });
    $('.selfonttype').mousedown(function () {
        var fonttype = $(this).attr('id');
        document.execCommand('fontName', false, fonttype);
    });
    document.onselectionchange = function () {
        getSelectedText();
    };
    function getSelectedText() {
        var text = "";
        if (window.getSelection) {
            text = window.getSelection().toString();
        }
//        console.log(text);
        return text;
    }

});


var emailBuilder = new $.EmailBuilder({theme: 'default'});
emailBuilder.init();


$(document).ready(function(){

    $('.modal').modal();

    /********START*********/
    //Save and Clear
    $('#save').click(function () {

        document.getElementById("ckk_hidden").value = document.getElementById("ckk").innerHTML;
        $('#temp').submit();
    });


    $('#clear').click(function () {
        $('[data-type="editor"]').html('');

    });
    /********END*********/

    /********START*********/
    //Modal Open close and Submit values
    $(document).on('click','#open',function(){
        $('#modal1').show();
        $('#modal').leanModal({
            dismissible: true,
        });
    });

    $(document).on('click','#close',function(){
        $('#modal1').hide();
    });

    $(document).on('click','#submit',function(){
        q1 = $("#text").val();
        $('#open').text(q1);
        q2 = $("#link").val();
        $("#open").attr("href","http://"+q2);
        $("#modal1").hide();
    });
    /********END*********/


    /********START*********/
    //Remove Button
    var cancelbtn = '<a class="del" style="position:absolute;\n' +
        '    top:1%;\n' +
        '    right:2%;color:red"><i class="tiny material-icons" >cancel</i></a>';


    $(document).on('mouseenter', '.module-container', function () {
        $('.del').css('display','block');
        $('.srt').css('display','block');
        $(this).children('div').append(cancelbtn);
        $('.del',this).click(function () {
            $(this).parent().remove();
        });
    }).
    on('mouseleave', '.module-container', function () {
        $('.del', this).remove();
        $('.srt', this).remove();
    });
    /********END*********/


    $(document).on('click', '.clickme', function () {
        $('.imgg').click();
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {

                    $('.imgshow').css("background-image", "url('" + e.target.result + "')");
                    $('.imgshow').css("background-repeat", "no-repeat");
                    $('.imgshow').css("background-position", "center");
                    $('.imgshow').css("border", "");
                    $('#remove').remove();
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        $(".imgg").change(function () {
            readURL(this);
        });
    });

    $(document).on('click', '.clickme1', function () {
            $('.imgg1').click();
            function readURL(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        $('.imgshow1').css("background-image", "url('" + e.target.result + "')");
                        $('.imgshow1').css("background-repeat", "no-repeat");
                        $('.imgshow1').css("background-position", "center");
                        $('.imgshow1').css("border", "");
                        $('#remove1').remove();
                    }
                    reader.readAsDataURL(input.files[0]);
                }
            }

            $(".imgg1").change(function () {
                readURL(this);
            });
        });

    $(document).on('click', '.clickme2', function () {
        $('.imgg2').click();
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {

                    $('.imgshow2').css("background-image", "url('" + e.target.result + "')");
                    $('.imgshow2').css("background-repeat", "no-repeat");
                    $('.imgshow2').css("background-position", "center");
                    $('.imgshow2').css("border", "");
                    $('#remove2').remove();
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        $(".imgg2").change(function () {
            readURL(this);
        });
    });

    $(document).on('click', '.clickme3', function () {
        $('.imgg3').click();
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('.imgshow3').css("background-image", "url('" + e.target.result + "')");
                    $('.imgshow3').css("background-repeat", "no-repeat");
                    $('.imgshow3').css("background-position", "center");
                    $('.imgshow3').css("border", "");
                    $('#remove3').remove();
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        $(".imgg3").change(function () {
            readURL(this);
        });
    });

    $(document).on('click', '.clickme4', function () {
        $('.imgg4').click();
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('.imgshow4').css("background-image", "url('" + e.target.result + "')");
                    $('.imgshow4').css("background-repeat", "no-repeat");
                    $('.imgshow4').css("background-position", "center");
                    $('.imgshow4').css("border", "");
                    $('#remove4').remove();
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        $(".imgg4").change(function () {
            readURL(this);
        });
    });

    $(document).on('click', '.clickme5', function () {
        $('.imgg5').click();
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('.imgshow5').css("background-image", "url('" + e.target.result + "')");
                    $('.imgshow5').css("background-repeat", "no-repeat");
                    $('.imgshow5').css("background-position", "center");
                    $('.imgshow5').css("border", "");
                    $('#remove5').remove();
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        $(".imgg5").change(function () {
            readURL(this);
        });
    });
});


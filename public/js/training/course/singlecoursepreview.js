$('#questions').on('click',function () {
    $('#questions_show').show();
    $(this).replaceWith(
        '<button class="btn deep-orange white-text mt- right" id="questions" >In Progress</button>');
});

$('#start_button').on('click',function()
{
    $('#show_course').show();
    $(this).attr('disabled',true)
    $(this).replaceWith(
        '<button class="btn deep-orange white-text mt- right" id="questions" >In Progress</button>');
});

$('#start_button').on('click', function ()
{
    $('#show_course').show();
    var course_id = $('#courseId').val();
    var employee_id = $('#employeeId').val();
    $.ajax({
        type: "get",
        url: '/training/simulation_singlecourse/course_status',
        data: {
            courseId: course_id,
            employeeId: employee_id,
        },
    });
    console.log(course_id, employee_id);
    $(this).attr('disabled', true);
    $(this).replaceWith('<button class="btn deep-orange white-text mt-2 right" id="questions" >In Progress</button>');
});

$('html, body').animate({
    scrollTop: $('#media_slider').offset().top
}, 'slow');

// $('#questions').on('click',function () {
//     $('#questions_show').show();
//     $(this).replaceWith(
//         '<button class="btn orange black-text mt-2 right" id="questions" >In Progress</button>');
// });


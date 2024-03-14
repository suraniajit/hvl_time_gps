function readURL(input, id) {
    id = id || '#courseImage';
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $(id).attr('src', e.target.result).width(200).height(150);
        };
        reader.readAsDataURL(input.files[0]);
    }
}

$('#dept').hide();
$('#team').hide();
$("#emp").hide();
//Show/Hide Teams, Departments
$('#assign').change(function () {
    var name = $(this).val();
    if (name == 'teams') {
        $('#dept').hide();
        $('#team').show();
        $(".file_error").html('');
        $("#employee").empty();
    } else if (name == 'departments') {
        $('#dept').show();
        $('#team').hide();
        $(".file_error").html('');
        $("#employee").empty();
    } else if (name == 'all') {
        $('#dept').hide();
        $('#team').hide();
        $("#employee").empty();
        $.ajax({
            type: "get",
            url: "/training/course/fetchemployee",
            data: {
                all: '1'
            },
            success: function (res) {
                $("#emp").show();
                $(".file_error").html('');
                $("#employee").append('<option value="">Select Employee</option>');
                $.each(res, function (key, value) {

                    $("#employee").append('<option value="' + value.user_id + '">' + value.Name + '</option>');
                });
            },
        });
    }
});
//Show Employees if team is selected
$('#teams').change(function () {
    var team_id = $(this).val();
    $("#employee").empty();
    $.ajax({
        type: "get",
        url: "/training/course/fetchemployee",
        data: {
            team_id: team_id
        },
        success: function (res) {

            $("#emp").show();
            $(".file_error").html('');
            $("#employee").append('<option value="">Select Employee</option>');
            $.each(res, function (key, value) {

                $("#employee").append('<option value="' + value.user_id + '">' + value.Name + '</option>');
            });
        },
    });
});
//Show employees if department is selected
$('#departments').change(function () {
    var department_id = $(this).val();
    $("#employee").empty();
    $.ajax({
        type: "get",
        url: "/training/course/fetchemployee",
        data: {
            department_id: department_id
        },
        success: function (res) {
            $("#emp").show();
            $(".file_error").html('');
            $("#employee").append('<option value="">Select Employee</option>');
            $.each(res, function (key, value) {
                $("#employee").append('<option value="' + value.user_id + '">' + value.Name + '</option>');
            });
        },
    });
});



$(document).ready(function () {
    var count = -1;
    var no = 0;
    $(document).on('click', '.add2', function () {
        //        alert();
        var html = '';
        count++;
        no++;
        dynamic_field(count);
        function dynamic_field(count) {

            html += '<div class="col s12 m6 main">' +
                    '<div class="card">' +
                    '   <div class="card-content">' +
                    //                    '   <span class="card-title">Media ' + no + '</span>' +
                    '   <span class="card-title">Media</span>' + '       <div class="input-field col s6">' +
                    '           <span class="col s12 m8 l9">' +
                    '               <input id="files" type="file" name="files[' + count + '][]"  class="dropify-event" multiple required="" >' +
                    '           </span>' +
                    '       </div>' +
                    '       <div class=" col s12">' + // '    <label>Enter Set Name *</label>' +
                    '            <input type="text" id="set_id" name="set_id[' + count + '][]" autocomplete="off" placeholder="Enter Set Name" required="" >' +
                    '       </div>' +
                    '<div class="col s12">' +
                    '    <select name="questionnaire[' + count + '][]" id="questionnaire' + count + '" class="select2 browser-default questionnaires" multiple  data-error=".errorTxt3">' +
                    '   </select>' +
                    '</div>' +
                    ' <div class="card-action center">' +
                    '    <button type="button" name="remove" class="btn btn-danger btn-sm remove" style="background-color: red;"><i class="material-icons dp48">delete</i></button>' +
                    ' </div>' +
                    '</div>' + '</div>' +
                    '</div>';
            $('#Education_Table').append(html);
            $('.select2').select2();
        }
        $.ajax({
            type: "get",
            url: "/training/course/fetchquestionnaire",
            success: function (res)
            {
                if (res)
                {
                    $("#questionnaire" + count).empty();
// $(".questionnaires").append('<option value="">Select questionnaire</option>');
                    $.each(res, function (key, value) {
                        $("#questionnaire" + count).append('<option value="' + value.id + '">' + value.questionnaire_name + '</option>');
                    });
                    $('.select2').select2({
                        dropdownAutoWidth: true,
                        placeholder: "Select Questionnaire",
                    });
                }
            }

        });
    });
    $(document).on('click', '.remove', function () {
        $(this).closest('.main').remove();
    });
});
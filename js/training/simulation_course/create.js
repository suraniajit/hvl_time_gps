$(document).ready(function () {
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
});

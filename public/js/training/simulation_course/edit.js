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

    $('#olddepartments').hide();
    $('#oldteam').hide();
    $("#emp").hide();
//Show/Hide Teams, Departments
    $('#assign').change(function () {
//        var name = $(this).val();
        var name = $('#assign option:selected').val();

        if (name == 'teams') {
            $('.newteam').show();
            $('.newdepartments').hide();
            $('.olddepartments').hide();

            $(".file_error").html('');
            $("#employee").empty();
        } else if (name == 'departments') {
            $('.newdepartments').show();
            $('.newteam').hide();
            $('.oldteam').hide();

            $(".file_error").html('');
            $("#employee").empty();

        } else if (name == 'all') {

            $('.olddepartments').hide();
            $('.oldteam').hide();

            $('.newteam').hide();
            $('.newdepartments').hide();

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
    $('#newteam').change(function () {
//        var team_id = $(this).val();
        var team_id = $('#newteam option:selected').val();
        $('#oldteam').empty();
        $('#newdepartments').val('');
        $('#olddepartments').empty();

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
//Show Employees if team is selected
    $('#oldteam').change(function () {
//        var team_id = $(this).val();
        var team_id = $('#oldteam option:selected').val();

        $('#newdepartments').val('');
        $('#olddepartments').empty();

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
    $('#newdepartments').change(function () {
//        var department_id = $(this).val();
        var department_id = $('#newdepartments option:selected').val();
        // alert(department_id);
        $('#olddepartments').empty();
        $('#newteam').val('');
        $('#oldteam').empty();
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
    //Show employees if department is selected
    $('#olddepartments').change(function () {
//        var department_id = $(this).val();
        var department_id = $('#olddepartments option:selected').val();
//        alert(department_id);
        $('#newteam').val('');
        $('#oldteam').empty();
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
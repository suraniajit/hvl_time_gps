$(document).ready(function () {

    $("#formValidate").validate({
        rules: {
            shift_name: {
                required: {
                    depends: function () {
                        $(this).val($.trim($(this).val()));
                        return true;
                    }
                },
                remote: {
                    url: "/hrms/shift/validname/",
                    type: "get",
                }
            },
            start_time: {
                required: true,
            },
            end_time: {
                required: true,
            },
            shift_type: {
                required: true,
            },
            total_days: {
                required: true,
            },
            is_active: {
                required: true,
            },
            "employee[]": {
                required: true,
            }

        },
        messages: {
            shift_name: {
                required: "Please Enter Shift Name",
                remote: "This Shift Already Exist",
            },
            start_time: {
                required: "Please Enter Start Time",
            },
            end_time: {
                required: "Please Enter End Time",
            },
            shift_type: {
                required: "Please Enter Shift Type "
            },
            total_days: {
                required: "Please Select Total Days ",
            },
            is_active: {
                required: "Please Select Status",
            },
            "employee[]": {
                required: "Please Select Employee",
            },
        },
        errorElement: 'div',
        errorPlacement: function (error, element) {
            var placement = $(element).data('error');
            if (placement) {
                $(placement).append(error)
            } else {
                error.insertAfter(element);
            }
        }
    });
    $('#dept').hide();
    $('#team').hide();
    $("#emp").hide();
    //Show/Hide Teams, Departments
    $('#assign').change(function () {
        var name = $(this).val();
        if (name == 'teams') {
            $('#dept').hide();
            $('#team').show();
        } else if (name == 'departments') {
            $('#dept').show();
            $('#team').hide();
        } else if (name == 'all') {
            $('#dept').hide();
            $('#team').hide();
            $("#employee").empty();
            $.ajax({
                type: "get",
                url: "/hrms/shift/getemployees",
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
            url: "/hrms/shift/getemployees",
            data: {
                team_id: team_id
            },
            success: function (res) {
               
                $("#emp").show();
                $("#employee").append('<option value="">Select Employee</option>');
                $.each(res, function (key, value) {
                    
                    $("#employee").append('<option value="' + value[0].user_id + '">' + value[0].Name + '</option>');
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
            url: "/hrms/shift/getemployees",
            data: {
                department_id: department_id
            },
            success: function (res) {
                $("#emp").show();
                $("#employee").append('<option value="">Select Employee</option>');
                $.each(res, function (key, value) {
                    $("#employee").append('<option value="' + value[0]['user_id'] + '">' + value[0]['Name'] + '</option>');
                });
            },
        });
    });
});
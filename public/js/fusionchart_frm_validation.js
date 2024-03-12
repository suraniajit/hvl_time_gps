$(document).ready(function () {
    $("#d").validate({
        rules: {
            "component_name": {
                required: true,
            },
            "select_module": {
                required: true,
            },
            "primary_module_id": {
                required: true,
            },
//            "secondary_module_id": {
//                required: true,
//            },
            "module_measure": {
                required: true,
            },
            "module_grouping": {
                required: true,
            },
            "chart_type": {
                required: true,
            },
            "chart_design": {
                required: true,
            }
        },
        messages: {
            "component_name": {
                required: "Please Dashboard Title",
            },
            "select_module": {
                required: "Please Select Parent Module",
            },
            "primary_module_id": {
                required: "Please Select Primary Module",
            },
//            "secondary_module_id": {
//                required: "Please secondary_module_id Name",
//            },
            "module_measure": {
                required: "Please Select Measure ",
            },
            "module_grouping": {
                required: "Please Select Grouping Name",
            },
            "chart_type": {
                required: "Please Select Chart Type",
            },
            "chart_design": {
                required: "Please Select Chart Layout",
            }

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
});
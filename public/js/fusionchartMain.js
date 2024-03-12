$(document).ready(function () {
    var textMassage = 'Data';
    $(document).on('click', '.delete_chart', function () {
        var char_del_id = $(this).attr('data-id');
        var data_name = $(this).attr('data-name');
        var data_name1 = $('#title').val();
        var textMassage = data_name1;
          swal({
            title: "Are you sure, are you sure you want to Delete this " + textMassage + "!",
            icon: 'warning',
            dangerMode: true,
            buttons: {
                cancel: 'No, Please!',
                delete: 'Yes, Delete It'
            }
        }).then(function (willDelete) {
            if (willDelete) {
                $.ajax({
                    url: '/getchartdestroy',
                    type: "GET",
                    data: {
                        "id": char_del_id,
                    },
                    success: function (data)
                    {
                        swal("Poof! Your " + textMassage + " has been deleted!", {
                            icon: "success",
                        });
                        location.reload();
                    }
                })
            } else {
//                swal("Your " + textMassage + " is safe", {
//                    title: 'Cancelled',
//                    icon: "error",
//                });
                $('input[type=checkbox]').each(function ()
                {
                    $(this).prop('checked', false);
                });
                return false;
            }
        });
    });




//
//    $(function () {
//        $(".delete_chart").click(function () {
//            var char_del_id = $(this).attr('data-id');
////            alert($(this).attr('data-id'));
////            console.log($(this).attr('data-id'));
//            $.ajax({
//                type: "GET",
//                url: "/getchartdestroy",
//                data: {
//                    "id": char_del_id,
////                    "_token": token,
//                },
//                success: function (res) {
//                    if (res) {
//                        alert('your chart is delete successfully');
//                        location.reload();
//                    } else {
//
//                    }
//                }
//            });
//        });
//    });
    $('#select_filter_primary').on('change', function () {
//        var select_filter_primary = $('#select_filter_primary option:selected').data('id');
        var select_filter_primary = $('#select_filter_primary').val();
//        alert(select_filter_primary);
        var module_grouping = $('.module_grouping').val();
        var component_id = $('#component_id').val(); //getChartfilter
        var select_filter = $('#select_filter option:selected').val();
        var primary_module_id = $('.primary_module_id').val();
        if (select_filter_primary) {
            $.ajax({
                type: "GET",
                url: "/getChartfilterByPrimaryTable",
                data: {
                    "select_filter_primary": select_filter_primary,
                    "primary_module_id": primary_module_id,
                    "module_grouping": module_grouping,
                    "component_id": component_id,
                    "select_chart": select_filter,
//                    "_token": token,
                },
                success: function (res) {
                    console.log(res);
                    location.reload();
                }
            });
        }
    });
    $('#select_filter').on('change', function () {
        var select_filter = $('#select_filter option:selected').val();
        var component_id = $('#component_id').val(); //getChartfilter
        var select_filter_primary = $('#select_filter_primary option:selected').val();
        if (select_filter) {
            console.log(component_id);
            $.ajax({
                type: "GET",
                url: "getChartfilter",
                data: {
                    "component_id": component_id,
                    "select_chart": select_filter,
                    "select_filter_primary": select_filter_primary,
//                    "_token": token,
                },
                success: function (res) {
                    console.log(res);
                    if (res) {
                        alert('your chart is update successfully');
                        location.reload();
                    }
//                    res_measure = res.measure;
//                    if (res_measure) {
                    /*module_grouping*/

                    /*module_grouping*/
//                    }
                }
//                $('select').formSelect();
            });
        }

    });
    /*secondary_module_id start*/
    $('#secondary_module_id').on('change', function () {
        var secondary_module_name = $('#secondary_module_id option:selected').val();
        if (secondary_module_name) {
//            alert(secondary_module_name);
            $.ajax({
                type: "GET",
                url: "/getTableColumns",
                data: {
                    "secondary_module_name": secondary_module_name,
//                    "_token": token,
                },
                success: function (res) {
                    console.log(res);
                    res_measure = res.measure;
                    if (res_measure) {
                        /*module_grouping*/
                        $.each(res_measure, function (measure, measure_value) {
                            $("#module_measure").append('<option value="' + measure_value + '">' + measure_value.toUpperCase().replaceAll('_', ' ').toLowerCase().replaceAll(/\b[a-z]/g, function (letter) {
                                return letter.toUpperCase();
                            }) + '</option>');
                        });
                        $('select').formSelect();
                        /*module_grouping*/
                    }
                }
            });
        }
    });
    /*secondary_module_id end*/


    $('#primary_module_id').on('change', function () {
        var primary_module_name = $('#primary_module_id option:selected').data('id');
        var secondary_module_name = $('#secondary_module_id option:selected').val();
        if (primary_module_name) {

            $.ajax({
                type: "GET",
                url: "/getTableColumns",
                data: {
                    "primary_module_name": primary_module_name,
                    "secondary_module_name": secondary_module_name,
//                      "_token": token,
                },
                success: function (res) {
//                console.log(res);
//                console.log(res.relatetable);
//                console.log(res.measure);
//                console.log(res.grouping);
//                
                    res_relatetable = res.relatetable;
                    res_measure = res.measure;
                    res_grouping = res.grouping;
                    if (res) {
                        $("#secondary_module_id").empty();
                        $("#module_measure").empty();
                        $("#module_grouping").empty();
                        $("#secondary_module_id").append('<option value="" disabled selected>Select Related Module</option>');
                        $.each(res_relatetable, function (key, value) {
                            $("#secondary_module_id").append('<option value="' + value + '">' + value.toUpperCase().replaceAll('_', ' ').toLowerCase().replaceAll(/\b[a-z]/g, function (letter) {
                                return letter.toUpperCase();
                            }) + '</option>'
                                    );
                        });
                        /*module_measure*/
                        $.each(res_measure, function (measure, measure_value) {
                            $("#module_measure").append('<option value="' + measure_value + '">' + measure_value.toUpperCase().replaceAll('_', ' ').toLowerCase().replaceAll(/\b[a-z]/g, function (letter) {
                                return letter.toUpperCase();
                            }) + '</option>');
                        });
                        /*module_measure*/

                        /*grouping*/
                        $.each(res_grouping, function (grouping, grouping_value) {
                            $("#module_grouping").append('<option value="' + grouping_value + '">' + grouping_value.toUpperCase().replaceAll('_', ' ').toLowerCase().replaceAll(/\b[a-z]/g, function (letter) {
                                return letter.toUpperCase();
                            }) + '</option>');
                        });
                        /*module_grouping*/
                        $('select').formSelect();
                        $('.secondary-module-class').show();
                    } else {
                        $("#d")[0].reset()
                        $("#secondary_module_id").empty();
                        $("#module_measure").empty();
                        $("#module_grouping").empty();
                    }
                }
            });
        }
        /*second table it working */
    });
    $('#select_module').on('change', function () {
        var select_module = $(this).val();
        var select_module = $('#select_module option:selected').data('id');
        if (select_module) {
            //alert(select_module);
        }

    });
    /*reset the from start*/
    $('.reset').on('click', function () {
        $('.secondary-module-class').hide();
        $("#d")[0].reset()
        return false;
    });
    /*reset the from end*/
    $('.secondary-module-class').hide();
    $('select').formSelect();
    /**/
});

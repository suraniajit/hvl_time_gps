
$(document).ready(function () {


    CKEDITOR.replace('job_description');

 




    $('#country_id').change(function () {
        var cid = $(this).val();

        if (cid) {
            $.ajax({
                type: "get",
                url: "/hrms/city/getstate",
                data: {
                    id: cid
                },
                success: function (res)
                {
                    if (res)
                    {
                        $("#city_id").empty();
                        $("#state_id").empty();
                        $("#state_id").append('<option disabled="" selected="">Select State</option>');
                        $.each(res, function (key, value) {
                            $("#state_id").append('<option value="' + value.id + '">' + value.state_name + '</option>');
                        });
                        $("#city_id").append('<option value="" disabled="">Select City</option>');
                        $('select').formSelect();
                    }
                }
            });
        }
    });
    $('#state_id').change(function () {
        var state_id = $(this).val();
        var country_id = $('#country_id').val();
        if (state_id) {
            $.ajax({
                type: "get",
                url: "/hrms/city/getCity",
                data: {
                    state_id: state_id,
                    country_id: country_id,
                },
                success: function (res)
                {
                    if (res)
                    {
                        $("#city_id").empty();
                        $("#city_id").append('<option value="" disabled="" selected="">Select City</option>');
                        $.each(res, function (key, value) {
                            $("#city_id").append('<option value="' + value.id + '">' + value.city_name + '</option>');
                        });
                        $('select').formSelect();
                    }
                }
            });
        }
    });


});
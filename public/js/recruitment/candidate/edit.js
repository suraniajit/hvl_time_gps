 $('#country_id').on('change', function () {
        var cid = $(this).val();
        if (cid) {
            $.ajax({
                type: "GET",
                url: "/hrms/city/getstate",
                data: {
                    id: cid,
                    _token: '{{csrf_token()}}'
                },
                dataType: 'json',
                success: function (res)
                {
                    if (res)
                    {
                        $('#state_id').html('<option value="">Select State</option>');
                        $.each(res, function (key, value) {
                            $("#state_id").append('<option value="' + value.id + '"  >' + value.state_name + '</option>');
                        });
                        $('#city_id').html('<option value="">Select State First</option>');


//                                                $("#city_id").empty();
//                                                $("#state_id").empty();
//                                                $("#state_id").append('<option value="" selected="">Select State</option>');
//                                                $.each(res, function (key, value) {
//                                                    $("#state_id").append('<option value="' + value.id + '" selected>' + value.state_name + '</option>');
//                                                });
                        $('select').formSelect();
                    }
                }
            });
        }
    });

    $('#state_id').on('change', function () {
        var state_id = $(this).val();
        $("#city_id").html('');
        var country_id = $('#country_id').val();
        if (state_id) {
            $.ajax({
                type: "get",
                url: "/hrms/city/getCity",
                data: {
                    state_id: state_id,
                    country_id: country_id,
                    _token: '{{csrf_token()}}'
                },
                dataType: 'json',
                success: function (res)
                {
                    if (res)
                    {
                        $('#city_id').html('<option value="">Select City</option>');
                        $.each(res, function (key, value) {
                            $("#city_id").append('<option value="' + value.id + '"  >' + value.city_name + '</option>');
                        });

//                                                $("#city_id").empty();
//                                                $("#city_id").append('<option value="" selected="">Select City</option>');
//                                                $.each(res, function (key, value) {
//                                                    $("#city_id").append('<option value="' + value.id + '" selected>' + value.city_name + '</option>');
//                                                });
                        $('select').formSelect();
                    }
                }
            });
        }
    });

// Script for Validating the Edit data
$("#Candidate_Edit_Form").validate({
    rules: {
        name: {
            required: true,
        },
        email: {
            required: true,
            email: true,
            remote: {
                url: "/recruitment/candidate/editcheckUserEmailvalidate/",
                type: "get",
                data: {
                    id: function () {
                        return $('#Candidate_Edit_Form :input[name="candidate_id"]').val();
                    }
                }
            },

        },
        address: {
            required: true,
        },
        phone: {
            required: true,
        },
        cell_number: {
            required: true,
        },
        cnic: {
            required: true,
        },
        gender: {
            required: true,
        },
        dob: {
            required: true,
        },
        country_id: {
            required: true,
        },
        state_id: {
            required: true,
        },
        city_id: {
            required: true,
        },
        marital_status: {
            required: true,
        },
//        current_salary: {
//            required: true,
//            // number: true,
//        },
        total_experience: {
            required: true,
            number: true,
        },
        high_education: {
            required: true,
        }
    },
    messages: {
        name: {
            required: 'Enter Name',
        },
        email: {
            required: 'Enter Email Id',
            email: 'Enter Proper Email Id',
            remote: 'This Email Already Exist'
        },
        address: {
            required: 'Enter Address',
        },
        phone: {
            required: 'Enter Phone Number',
        },
        cell_number: {
            required: 'Enter Cell Number',
        },
        cnic: {
            required: 'Enter CNIC Number',
        },
        gender: {
            required: 'please select Gender',
        },
        dob: {
            required: 'Enter Date Of Birth',
        },

        country_id: {
            required: 'please select country',
        },
        state_id: {
            required: 'please select state',
        },
        city_id: {
            required: 'please select city',
        },
        marital_status: {
            required: 'Select Marital Status',
        },
//        current_salary: {
//            required: 'Enter Salary',
//            number: 'Enter Only Number',
//        },
        total_experience: {
            required: 'Enter Total Experience',
            number: 'Please Enter Only Numbers',
        },
        high_education: {
            required: 'Select Your Education',
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

var count = -1;
$(document).on('click', '.add1', function () {

    count += 1;
    dynamic_field(count);
    // var text = '';
    function dynamic_field(number) {
        var html = '';
        html += '<div class=" col s4">';
        html += '' +
                '<input type="text" name="job_title[]" required="" placeholder="Enter Job Title" class="input-field" autocomplete="off" autofocus="off" />';
        html += '<input type="text" name="company[]" required="" placeholder="Enter Company Name" class="input-field" autocomplete="off" autofocus="off" />';
        html += '<input type="text" name="summary[]" required="" placeholder="Enter Summary" class="input-field" autocomplete="off" autofocus="off" />';
        html += '<input type="text" class="date" name="join_date[]" required="" placeholder="Enter Date of Join" autofocus="off" autocomplete="off"  />';
        // html += '<label class=""><input type="checkbox" class="filled-in" id="current' + count + '" /><span>Currently Working</span></label>';
        html += '<div id="leave_date' + count + '"><input type="text" required="" class="date dependent_dob" name="exit_date[]" placeholder="Enter Leave Date"  autofocus="off" autocomplete="off" /></div>';
        html += '<button type="button" name="remove" class="btn btn-danger btn-sm remove"><i class="material-icons dp48">delete</i></button>';
        html += '</div>';
        $('#Experience_Table').append(html);
        jQuery.datetimepicker.setLocale('en');
        jQuery('.date').datetimepicker({
            timepicker: false,
            format: 'Y-m-d',
            maxDate: new Date(),
            defaultDate: new Date(),
            formatDate: 'Y-m-d',
            scrollInput: false
        });
    }
});
$(document).on('click', '.remove', function () {
    $(this).closest('div').remove();
});

/* Dynamic fields of education*/
$(document).on('click', '.add2', function () {

    var count = 1;
    dynamic_field(count);
    // var text = '';
    function dynamic_field(number) {
        var html = '';
        html += '<div class=" col s4">';
        html += '<input type="text" name="school_name[]" required=""  class="input-field" placeholder="Enter School Name " autocomplete="off" autofocus="off" />';
        html += '<select name="degree[]" class="select" >' +
                '<option value="0">None</option>' +
                '<option value="1">Post Graduate</option>' +
                '<option value="2">Graduate</option>' +
                '<option value="3">Under Graduate</option>' +
                '<option value="4">Phd</option>' +
                '<option value="5">Mphil</option>' +
                '</select>';
        html += '<input type="text" name="field[]" required="" class="input-field" placeholder="Enter Field Of Study" autocomplete="off" autofocus="off"/>';
        html += '<input type="text"  name="start_year[]" required="" class="date" placeholder="Enter Start Date" autofocus="off" autocomplete="off" />';
        html += '<input type="text"  name="end_year[]" required="" class="date" placeholder="Enter Exit Date" autofocus="off" autocomplete="off" />';
        html += '<button type="button" name="remove" required="" class="btn btn-danger btn-sm remove"><i class="material-icons dp48">delete</i></button>';
        html += '</div>';
        $('#Education_Table').append(html);
        $('select').formSelect();
        jQuery.datetimepicker.setLocale('en');
        jQuery('.date').datetimepicker({
            timepicker: false,
            format: 'Y-m-d',
            defaultDate: new Date(),
            maxDate: new Date(),
            formatDate: 'Y-m-d',
            scrollInput: false
        });

    }
});
$(document).on('click', '.remove', function () {
    $(this).closest('div').remove();
});

/* Dynamic fields of other Attachment*/
$(document).on('click', '.add3', function () {

    var count = 1;
    dynamic_field(count);
    // var text = '';
    function dynamic_field(number) {
        var html = '';
        html += '<div class=" col s12">';
        html += '<input type="file" name="attachment[]" class="input-field" accept=".pdf,.doc,.docx,application/msword" /><small style="color:red;margin-right: 28px;">File Size: Upto 1MB (.PDF/.DOC/.DOCX)</small>';
        html += '<button type="button" name="remove" class="btn btn-danger btn-sm remove"><i class="material-icons dp48">delete</i></button>';
        html += '</div>';
        $('#other_attachment').append(html);

    }
});
$(document).on('click', '.remove', function () {
    $(this).closest('div').remove();
});

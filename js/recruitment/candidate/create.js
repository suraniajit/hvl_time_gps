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

// Script for Validating the insert data
$("#Candidate_Form").validate({
    rules: {
        f_name: {
            required: true,
        },
        l_name: {
            required: true,
        },
        email: {
            required: true,
            email: true,
            remote: {
                url: "/recruitment/candidate/checkUserEmailvalidate",
                type: "get",
            }
        },
        address: {
            required: true,
        },
        country: {
            required: true,
        },
        state: {
            required: true,
        },
        city: {
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
        marital_status: {
            required: true,
        },
        total_experience: {
            required: true,
            number: true,
        },
        high_education: {
            required: true,
        },
        resume: {
            required: true,
        },
        cover_letter: {
            required: true,
        },
//        current_salary: {
//            required: true,
//            // number: true,
//        },
    },
    messages: {
        f_name: {
            required: 'Enter Candidate First Name',
        },
        l_name: {
            required: 'Enter Candidate Last Name',
        },
        email: {
            required: 'Enter Email Id',
            email: 'Enter Proper Email Id',
            remote: "This Email Already Exist"

        },
        address: {
            required: 'Enter Address',
        },
        country: {
            required: 'please select country',
        },
        state: {
            required: 'please select state',
        },
        city: {
            required: 'please select city',
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
        marital_status: {
            required: 'Select Marital Status',
        },
        total_experience: {
            required: 'Enter Total Experience',
            number: 'Please Enter Only Numbers',
        },
        high_education: {
            required: 'Select Your Education',
        },
        resume: {
            required: 'Please Upload Resume',
        },
        cover_letter: {
            required: 'Please Upload Cover Letter',
        },
//        current_salary: {
//            required: 'Enter Salary',
//            number: 'Enter Only Number',
//        }
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
    function dynamic_field(count) {

        var html = '';
        html += '<div class="input-field col s4" style=" border: 0px solid red;">';
        html += '<input type="text" id="job_title"  required=""name="job_title[]" placeholder="Enter Job Title" class="input-field" autocomplete="off" autofocus="off" />';
        html += '<input type="text" name="company[]" required="" placeholder="Enter Company Name" class="input-field" autocomplete="off" autofocus="off" />';
        html += '<input type="text" name="summary[]" required="" placeholder="Enter Summary" class="input-field" autocomplete="off" autofocus="off" />';
        html += '<input type="text" class="date" required="" name="join_date[]" placeholder="Enter Date of Join" autocomplete="off" autofocus="off" />';
        // html += '<label ><input type="checkbox" class="filled-in " id="current'+count+'" /><span>Currently Working</span></label>';
        html += '<div id="leave_date' + count + '"><input type="text" required="" name="exit_date[]" class="date" placeholder="Enter Leave Date" autocomplete="off" autofocus="off" /></div>';
        html += '<center><button type="button" name="remove" class="btn btn-danger btn-sm remove"><i class="material-icons dp48">delete</i></button>';
        html += '</center></div>';
        $('#Experience_Table').append(html);


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

/* Dynamic fields of education*/
$(document).on('click', '.add2', function () {
    var count = 1;
    dynamic_field(count);
    // var text = '';
    function dynamic_field(number) {
        var html = '';
        html += '<div class="input-field col s4" style=" border: 0px solid red;">';
        html += '<input type="text" name="school_name[]" required="" class="input-field" placeholder="Enter School Name " autocomplete="off" autofocus="off" />';
        html += '<select name="degree[]" class="select" required="">' +
                '<option value="" disable>Select Degree</option>' +
                '<option value="0">None</option>' +
                '<option value="1">Post Graduate</option>' +
                '<option value="2">Graduate</option>' +
                '<option value="3">Under Graduate</option>' +
                '<option value="4">Phd</option>' +
                '<option value="5">Mphil</option>' +
                '</select>';
        html += '<input type="text" name="field[]" required="" class="input-field" placeholder="Enter Field Of Study" autocomplete="off" autofocus="off" />';
        html += '<input type="text"  name="start_year[]" required="" class="date" placeholder="Enter Start Date" autofocus="off" autocomplete="off" />';
        html += '<input type="text"  name="end_year[]" required="" class="date" placeholder="Enter Exit Date" autofocus="off" autocomplete="off" />';
        html += '<center>';
        html += '<button type="button" name="remove" class="btn btn-danger btn-sm remove"><i class="material-icons dp48">delete</i></button>';
        html += '</center>';
        html += '<br>';
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

});

function dynamic_field(number) {

    var html = '';
    html += '<div class="main row">';
    html += '   <div class="col s4">';
    html += '       <button style="margin-top: 0px;" type="button" name="remove" class="btn btn-danger btn-sm delete"><i class="material-icons dp48">delete</i></button>';
    html += '   </div>';
    html += '   <div class="col s8 main">';
    html += '       <input type="file" name="attachment[]" id="attachment" class="" accept=".pdf,.doc,.docx,application/msword" />  <br><small style="color:red;">File Size: Upto 1MB (.PDF/.DOC/.DOCX)</small>';
    html += '   </div>';
    html += '   <div class=""></div>';
    html += '</div>';

    $('#other_attachment').append(html);

}
$(document).on('click', '.delete', function () {
    $(this).closest('.main').remove();
});
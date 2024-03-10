$(document).ready(function () {

    timestamp();
    btn_check();
    setInterval(timestamp, 10000);
    //Gets time
    function timestamp() {
        $.ajax({
            url: '/clock',
            success: function (data) {
                $('#hidden_time').text(data[0]);
                $('#hidden_time').val(data[0]);
                /*$('#navbar_time').text(data[0]+data[1]);*/
                $('#navbar_time').text(data[0]);
            },
        });
    }

    function btn_check() {

        $.ajax({
            url: '/btn_check',
            success: function (data) {
//                alert(data[0]);
                $('#hidden_shift').val(data[1]);
                $('#hidden_date').val(data[2]);
                
                if (data[0] == '1') {
                    $('#navbar_checkin').hide();
                    $('#checkout_disabled').hide();
                    $('#navbar_checkout_btn').show();
                    $('#checkout_disabled').hide();
                } else if (data[0] == '0') {
                    $('#navbar_checkin').show();
                    $('#checkout_disabled').hide();
                    $('#checkout_disabled').hide();
                } else if (data[0] == 'none') {
                    $('#navbar_checkin').hide();
                    $('#navbar_checkout_btn').hide();
                    $('#checkout_disabled').show();
                } else if (data[0] == '3') {
                    $('#navbar_checkin').hide();
                    $('#navbar_checkout_btn').hide();
                    $('#checkout_disabled').hide();
                    $('#shift_not_assign_disabled_btn').show();
                }
            },
        });
    }

    $(document).on('click', '#checkout_disabled', function () {
        swal("You have already Checked Out", {
            icon: "error",
            buttons: false,
            timer: 2000,
        });
    });
    $(document).on('click', '#shift_not_assign_disabled_btn', function () {
        swal("You are not assign to any shift", {
            icon: "error",
            buttons: false,
            timer: 2000,
        });
    });

    $(document).on('click', '#navbar_checkin', function () {

        var check = $('#navbar_in').attr('data-id');
        var shift_start = $('#hidden_shift').val();
        var now = $('#hidden_time').val();
        var date = $('#hidden_date').val();

        now_split = now.split(':');
        shift_start_split = shift_start.split(':');
        //If user checks in before shift time, shift time is used as checkin time
        if (parseInt(now_split[0]) == parseInt(shift_start_split[0])) {
            if (parseInt(now_split[1]) <= parseInt(shift_start_split[1])) {
                now = shift_start;
            } else {
                now = now;
            }
        } else if (parseInt(now_split[0]) < parseInt(shift_start_split[0])) {
            now = now;
        }

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "/attendance/store",
            type: 'post',
            data: {
                now: now,
                check: check,
                date: date,
            },
            success: function (response) {
                swal("successfully Checked in!", {
                    icon: "success",
                    timer: 2000,
                    buttons: false,
                }).then(function () {
                    btn_check();
                });
            },
            error: function (xhr, status, error) {
                alert(xhr.responseText);
            }
        });
    });

    function new1(total_hours) {
        var status = 1;
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    }
    $(document).on('click', '#navbar_checkout_btn', function () {

        var check = $('#navbar_out').attr('data-id');
        var now = $('#hidden_time').val();
        var date = $('#hidden_date').val();

        swal({
            title: "Are you sure you want Check out!",
            icon: 'warning',
            dangerMode: true,
            buttons: {
                cancel: 'No, Please!',
                delete: 'Yes, checkout !'
            }
        }).then(function (willDelete) {
            if (willDelete) {
                //Function to send checkout data to controller



                $.getJSON("/attendance/getstarttime/" + date, function (result) {
                    $.each(result, function (i, field) {
                        var start_time = field.check_in;
                        localStorage.setItem('start_time', field.check_in);
                        if (localStorage.getItem('start_time') != null) {
                            var total_hours = differenceHours.diff_hours(start_time, now);
                            new1(total_hours);

                            $.ajax({
                                url: "/attendance/store",
                                type: 'post',
                                data: {
                                    now: now,
                                    check: check,
                                    date: date,
                                    total_hours: total_hours,
                                    status: status,
                                },
                                success: function (data) {
                                    swal("successfully check-out !", {
                                        icon: "success",
                                    }).then(function () {
//                                        location.reload();
                                    });
                                }
                            });

                        }
                    });
                });




            } else {
                return false;
            }
        });
        /**/

    });


    var DifferenceHours = function (options) {

        /*
         * Variables
         * in the class
         */
        const vars = {
            first_hour_split: null,
            second_hour_split: null,
            $el: null
        };

        let _this = this;

        this.construct = function (options) {
            $.extend(vars, options);
        };

        this.diff_hours = function (start_time, end_time) {

            vars.first_hour_split = start_time.split(':');
            vars.second_hour_split = end_time.split(':');


            let hours;
            let minute;

            if (parseInt(vars.first_hour_split[0]) < parseInt(vars.second_hour_split[0]) && parseInt(vars.first_hour_split[1]) < parseInt(vars.second_hour_split[1])) {

                hours = parseInt(vars.second_hour_split[0]) - parseInt(vars.first_hour_split[0]);
                minute = parseInt(vars.second_hour_split[1]) - parseInt(vars.first_hour_split[1]);

                let _hours = '';
                let _minute = '';

                if (hours < 10) {
                    _hours = '0' + hours;
                } else {
                    _hours = hours;
                }

                if (minute < 10) {
                    _minute = '0' + minute;
                } else {
                    _minute = minute;
                }

                return _hours + ' H ' + _minute + ' M ';

            } else if (parseInt(vars.second_hour_split[0]) > parseInt(vars.first_hour_split[0])) {
                if (parseInt(vars.second_hour_split[1]) < parseInt(vars.first_hour_split[1])) {

                    let _hours = parseInt(vars.second_hour_split[0]) - 1;
                    let _minute = parseInt(vars.second_hour_split[1]) + 60;
                    let final_hours = '';
                    let final_min = '';

                    hours = _hours - parseInt(vars.first_hour_split[0]);
                    minute = _minute - parseInt(vars.first_hour_split[1]);

                    if (hours < 10) {
                        final_hours = '0' + hours;
                    } else {
                        final_hours = hours;
                    }

                    if (minute < 10) {
                        final_min = '0' + minute;
                    } else {
                        final_min = minute;
                    }

                    return final_hours + ' H ' + final_min + ' M ';
                }

                if (parseInt(vars.second_hour_split[1]) === parseInt(vars.first_hour_split[1])) {
                    hours = parseInt(vars.second_hour_split[0]) - parseInt(vars.first_hour_split[0]);
                    let final_hours = '';

                    if (hours < 10) {
                        final_hours = '0' + hours;
                    } else {
                        final_hours = hours;
                    }

                    return final_hours + ' H ' + ' 00 M';
                }

            } else if (parseInt(vars.first_hour_split[0]) > parseInt(vars.second_hour_split[0])) {
                let first_hour_only_hour = parseInt(vars.first_hour_split[0]);
                let second_hour_only_hour = parseInt(vars.second_hour_split[0]);

                let first_hour_only_min = parseInt(vars.first_hour_split[1]);
                let second_hour_only_min = parseInt(vars.second_hour_split[1]);

                let tmp_hour = 24 - first_hour_only_hour;
                let tmp_ttl_hour = tmp_hour + second_hour_only_hour;

                let tmp_ttl_min = first_hour_only_min + second_hour_only_min;
                let tmp_new_hour = 0;
                let tmp_new_min_mod = 0;

                let _hours = '';
                let _min = '';

                if (tmp_ttl_min > 59) {
                    tmp_new_hour = parseInt(tmp_ttl_min / 60);
                    tmp_new_min_mod = tmp_ttl_min % 60;

                    tmp_ttl_hour += tmp_new_hour;
                } else {
                    tmp_new_min_mod = tmp_ttl_min
                }

                if (tmp_ttl_hour < 10) {
                    _hours = '0' + tmp_ttl_hour;
                } else {
                    _hours = tmp_ttl_hour
                }

                if (tmp_new_min_mod < 10) {
                    _min = '0' + tmp_new_min_mod
                } else {
                    _min = tmp_new_min_mod
                }

                return _hours + ' H ' + _min + ' M ';
            } else if (parseInt(vars.first_hour_split[0]) === parseInt(vars.second_hour_split[0])) {
                hours = '00';
                let minute = 0;
                if (parseInt(vars.first_hour_split[1]) < parseInt(vars.second_hour_split[1])) {
                    minute = parseInt(vars.second_hour_split[1]) - parseInt(vars.first_hour_split[1]);
                }

                if (minute < 10) {
                    return hours + 'H 0' + minute + ' M';
                } else {
                    return hours + ' H ' + minute + ' M';
                }
            } else if (parseInt(vars.first_hour_split[0]) === 0 && parseInt(vars.first_hour_split[1]) === 0) {
                hours = parseInt(vars.second_hour_split[0]);
                minute = parseInt(vars.second_hour_split[1]);

                if (hours === 0) {
                    return '00 H ' + minute + ' M';
                } else if (minute === 0) {
                    if (hours < 10) {
                        return '0' + hours + ' H 00 M ';
                    } else {
                        return hours + ' H 00 M';
                    }
                } else {
                    return hours + ' H ' + minute + ' M ';
                }
            }
        };
        this.construct(options);
    };
    const differenceHours = new DifferenceHours();

    var timeToRound = new Date();
    var hh = timeToRound.getHours();
    var mm = Math.round(timeToRound.getMinutes() / 15) * 15;
    var froMin = 0;
    if (hh >= 8 && hh < 19 || (hh == 19 && mm == 0)) {
        froMin = (hh - 8) * 4 + (mm / 15);
    }
});

$(document).ready(function () {
    timestamp();
    setInterval(timestamp, 1000);

    var Calendar = FullCalendar.Calendar;
    //  Basic Calendar Initialize
    document.getElementById('basic-calendar').innerHTML = "";
    var basicCal = document.getElementById('basic-calendar');
    var fcCalendar = new FullCalendar.Calendar(basicCal, {
        editable: true,
        buttonText: {
            today: 'Today',
        },
        plugins: ["dayGrid", "interaction"],
        showNonCurrentDates: false,

    });
    fcCalendar.render();


    btn_check();
    function btn_check() {
        $.ajax({
            url: '/btn_check',
            success: function (data) {

                if (data[0] == '1') {
                    $('#checkin').hide();
                    $('#check_in_notes').hide();
                    $('#checkout_btn').show();
                    $('#check_out_notes').show();
                    $('#checkout_disabled').hide();
                } else if (data[0] == '0') {
                    $('#checkin').hide();
                    $('#check_in_notes').hide();
                    $('#checkin').show();
                    $('#check_in_notes').show();
                    $('#checkout_disabled').hide();
                } else if (data[0] == 'none') {
                    $('#checkin').hide();
                    $('#check_in_notes').hide();
                    $('#checkin').hide();
                    $('#check_in_notes').hide();
                    $('#checkout_disabled').show();
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

    $(document).on('change', '#sel', function () {
        //Makes Calendar Selectable to add Leave request
        if ($('#sel').is(":checked")) {
            var Calendar = FullCalendar.Calendar;
            //  Basic Calendar Initialize
            document.getElementById('basic-calendar').innerHTML = "";
            var basicCal = document.getElementById('basic-calendar');
            var fcCalendar = new FullCalendar.Calendar(basicCal, {

                editable: true,
                buttonText: {
                    today: 'Today',
                },
                plugins: ["dayGrid", "interaction"],
                selectable: true,
                weekends: false,
                showNonCurrentDates: false,

                //Opens Create leave request modal
                select: function (info) {
                    isWeekend = false;
                    $('#leaverequest_modal').modal('open');
                    $.getJSON("/hrms/leaverequest/create", function (result) {
                        console.log(result);
                        var endDate = new Date(info.endStr);
                        beforeDay = new Date(endDate.getFullYear(), endDate.getMonth(), endDate.getDate() - 1);
                        var month = checkTime(beforeDay.getMonth() + 1);
                        var dte = checkTime(beforeDay.getDate());
                        var full_date = beforeDay.getFullYear() + '-' + month + '-' + dte;
                        $("#end_date").val(full_date);

                        //Fills data in leave request modal
                        $.each(result, function (i, field) {
                            $('#leaverequest_modal').find('#emp_name').val(field.emp[0]['full_Name']);
                            $('#leaverequest_modal').find('#from_date').val(info.startStr);
                            $('#leaverequest_modal').find('#employee_id').val(field.emp[0]['user_id']);

                            $('#leaverequest_modal').find('#is_confirm').val(field.emp[0]['Select_employee_type']);
                            $('#leaverequest_modal').find('#emp_date').val(field.emp[0]['date_of_appointment']);
                            $('#leaverequest_modal').find('#team_lead').val(field.emp[0]['team_lead']);
                            $('#leaverequest_modal').find('#hr').val(field.emp[0]['hr']);
                            $('#leave_type').find('option').remove().end();

                            for (var i = 0; i < field.leavetype.length; i++) {
                                console.log(field.leavetype.length);
                                $('#leave_type').append($('<option></option>')
                                        .attr('value', field.leavetype[i]['id'])
                                        .text(field.leavetype[i]['Name']));
                            }
                            $('select').formSelect();
                            //Calculates Date Difference
                            $.ajax
                                    ({
                                        type: "get",
                                        url: "/hrms/leaverequest/date_difference",
                                        data: {
                                            from_date: info.startStr,
                                            end_date: info.endStr
                                        },
                                        success: function (msg)
                                        {
                                            $('#leaverequest_modal').find('#result').text(msg);
                                            $('#leaverequest_modal').find('#total_days').val(msg);
                                        },
                                    });
                        });
                    });
                }
            });
            fcCalendar.render();
            changedata();
            modaldata();
        }
        //Unselectable Calendar
        else {
            var Calendar = FullCalendar.Calendar;
            //  Basic Calendar Initialize
            document.getElementById('basic-calendar').innerHTML = "";
            var basicCal = document.getElementById('basic-calendar');
            var fcCalendar = new FullCalendar.Calendar(basicCal, {
                editable: true,
                plugins: ["dayGrid", "interaction"],
                showNonCurrentDates: false,
            });
            fcCalendar.render();
            changedata();
            modaldata();
        }
    });

    //Shift Time
    var min_time = $('#total_time').val();
    min_time = min_time.split('H');
    min_hours = parseInt(min_time[0]);
    min_min = parseInt(min_time[1]);

    var id = $('#id').val();
    var date = $('#date').val();

    //Opens modal and fills data for a particular date of that employee on clicking
    function modaldata() {
        //Opens Modal
        $('.fc-day').click(function () {
            var date = $(this).attr('data-date');
            var cl = $(this).attr('class');
            $('#modal1').modal('open');

            //Adds Day after Date in Modal
            if (cl.includes("fc-mon")) {
                $('#modal1').find('#modal_date').text(date + ", Monday");
            } else if (cl.includes("fc-tue")) {
                $('#modal1').find('#modal_date').text(date + ", Tuesday");
            } else if (cl.includes("fc-wed")) {
                $('#modal1').find('#modal_date').text(date + ", Wednesday");
            } else if (cl.includes("fc-thu")) {
                $('#modal1').find('#modal_date').text(date + ", Thursday");
            } else if (cl.includes("fc-fri")) {
                $('#modal1').find('#modal_date').text(date + ", Friday");
            } else if (cl.includes("fc-sat")) {
                $('#modal1').find('#modal_date').text(date + ", Saturday");
            } else if (cl.includes("fc-sun")) {
                $('#modal1').find('#modal_date').text(date + ", Sunday");
            }

            $('#modal1').find('#modal_checkin').text('');
            $('#modal1').find('#modal_checkout').text('');
            $('#modal1').find('#modal_checkin_notes').removeClass('red-text').text('');
            $('#modal1').find('#modal_checkout_notes').removeClass('red-text').text('');
            $('#modal1').find('#modal_total_hours').text('');

            $('#modal1').find('#penalty_amount').text('');

            //Fills data in Modal
            $.getJSON("/attendance/modaldata/" + date, function (result) {
                $.each(result, function (i, field) {
                    field.check_in != null ? $('#modal1').find('#modal_checkin').text(field.check_in) : $('#modal1').find('#modal_checkin').text('None');
                    field.check_out != null ? $('#modal1').find('#modal_checkout').text(field.check_out) : $('#modal1').find('#modal_checkout').text('None');
                    field.check_in_notes != null ? $('#modal1').find('#modal_checkin_notes').text(field.check_in_notes) : $('#modal1').find('#modal_checkin_notes').addClass('red-text').text('None');
                    field.check_out_notes != null ? $('#modal1').find('#modal_checkout_notes').text(field.check_out_notes) : $('#modal1').find('#modal_checkout_notes').addClass('red-text').text('None');
                    field.total_hours != null ? $('#modal1').find('#modal_total_hours').text(field.total_hours) : $('#modal1').find('#modal_total_hours').text('None');
                    field.location != null ? $('#modal1').find('#location').val(field.location) : $('#modal1').find('#location').val('None');

                    $('#modal1').find('#penalty').css('display', 'none');
                    if (field.checkout_type == 0) {
                        $('#modal1').find('#penalty').css('display', 'table-cell');
                        field.amount != null ? $('#modal1').find('#penalty_amount').text(field.amount) : $('#modal1').find('#penalty_amount').val('None');
                    }

                });
            });
        });

    }

    $(document).on('click', '#checkin', function () {
        $('.red.time').show();
        var check_in_notes = $('#check_in_notes').val();
        var check = $('#in').attr('data-id');
        var start = $('#txt').text();
        var shift_start = $('#shift_start').val();
        localStorage.setItem('start', start);
        $('#start0').text(start);
        var now = $('#normaltime').text();
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
            url: "attendance/store",
            type: 'post',
            data: {
                now: now,
                check: check,
                date: date,
                check_in_notes: check_in_notes,
                start: start,
            },
            success: function (response) {
                swal("Success", {
                    icon: "success",
                    buttons: false,
                    timer: 2000,
                });
                btn_check();
//                    window.document.location.reload(true);
            },
            error: function (xhr, status, error) {
                alert(xhr.responseText);
            }
        });
    });

    $(document).on('click', '#checkout', function () {
        $('.red.time').hide();
        $('#check_out_notes').hide();
        var check = $('#out').attr('data-id');
        var stop = $('#txt').text();
        var check_out_notes = $('#check_out_notes').val();
        var now = $('#normaltime').text();
        localStorage.setItem('start_time', null);
        $.getJSON("/attendance/getstarttime/" + date, function (result) {
            $.each(result, function (i, field) {
                var start_time = field.check_in;
                localStorage.setItem('start_time', field.check_in);
                if (localStorage.getItem('start_time') != null) {
                    var total_hours = differenceHours.diff_hours(start_time, now);
                    new1(total_hours);
                }
            });
        });

        //Function to send checkout data to controller
        function new1(total_hours) {
            total = total_hours.split('H');
            if ((parseInt(total[0]) >= min_hours) && (parseInt(total[1]) >= min_min)) {
                var status = 1;
            } else {
                var status = 1;
            }
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: "attendance/store",
                type: 'post',
                data: {
                    now: now,
                    check: check,
                    date: date,
                    check_out_notes: check_out_notes,
                    stop: stop,
                    total_hours: total_hours,
                    status: status,

                },
                success: function (response) {
                    swal("Success", {
                        icon: "success",
                        buttons: false,
                        timer: 2000,
                    });
                    btn_check();
//                    location.reload();
                },
                error: function (xhr, status, error) {
                    alert(xhr.responseText);
                }
            });
        }
    });

    //Function to add 0 in date
    function checkTime(i) {
        if (i < 10) {
            i = "0" + i
        }
        ;
        return i;
    }

    changedata();
    modaldata();
    $('td').append('<span class="hours"></span>');
    $(document).on('click', '.fc-prev-button,.fc-next-button,.fc-today-button', function () {
        $('td').append('<span class="hours"></span>');
        changedata();
        modaldata();
    });

    //Tags on top of Calendar
    $(".fc-center").append('' +
            '<span class="task-cat green lighten-2 black-text"><b>On Leave</b></span>' +
            '<span class="task-cat red lighten-2 black-text"><b>Absent</b></span>' +
            '<span class="task-cat" style="background-color: rgb(219 222 255);color:black"><b>Weekend</b></span>' +
            '<span class="task-cat" style="background-color: #ffcc80;color:black"><b>Holiday</b></span>' +
            '<span class="task-cat teal lighten-5 black-text"><b>Pending Leave</b></span>'
            );

    $('.fc-day').addClass('modal-trigger');

    //Fills Color based on type of data in calendar
    function changedata() {
        //Red for Absent
        $.getJSON("/attendance/getdata/" + id, function (result) {
            $.each(result, function (i, field) {
                $('.fc-day.fc-widget-content.fc-sun').css('background-color', 'rgb(219 222 255)');
                $('.fc-day.fc-widget-content.fc-sat').css('background-color', 'rgb(219 222 255)');
                $('.fc-other-month').css('background-color', 'white');
                if (field.status == 0) {
                    $('[data-date=' + field.date + ']').css('background-color', '#e57373');
                }
            });
        });
        //Light Blue for Pending Leave
        $.getJSON("/attendance/pendingleave/" + id, function (result) {
            $.each(result, function (i, field) {
                $('[data-date=' + field + ']').css('background-color', '#e0f2f1');
            });
        });
        //Green for approved leave
        $.getJSON("/attendance/getleavedata/"+id, function (result) {
                var x=0;
                $.each(result, function (i, field) {
                    var total_leave_types = field[1].length;
                    var leave_name = new Array();
                    for(var l=0;l<total_leave_types;l++){
                        leave_name[l] = field[1][l].Name;
                    }
                    var in_date = new Array();
                    for(var ch=0;ch<leave_name.length;ch++){
                        in_date[ch] = field[0][leave_name[ch]].length;
                    }
                    for (var c=0;c<total_leave_types;c++){
                        for(dd=0;dd<in_date[c];dd++){
                            $('[data-date=' + field[0][leave_name[c]][dd] + ']').css('background-color', '#81C784');
                            $('td[data-date=' + field[0][leave_name[c]][dd] + ']>.hours').text(leave_name[c]);
                            $('[data-date=' + field[0][leave_name[c]][dd] + ']').css('pointer-events', 'none');
                        }
                    }
                });
            });
        //Yellow for Holidays
        $.getJSON("/attendance/holidays/getdata", function (result) {
            $.each(result, function (i, field) {

                $('[data-date=' + field.Date + ']').css('background-color', '#ffcc80');
                $('td[data-date=' + field.Date + ']>.hours').text(field.Name);

            });
        });

    }
    //Gets time
    function timestamp() {
        $.ajax({
            url: '/clock',
            success: function (data) {
                $('#normaltime').text(data[0]);
                $('#seconds').text(data[1]);
            },
        });
    }

    /*----------------------------------------------------------------------------------------------*/
//Code to calculate time difference
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


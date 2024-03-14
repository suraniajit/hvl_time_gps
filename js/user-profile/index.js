$(document).ready(function () {

    $(document).on('click', '.cal', function () {


        var id = $('#id').val();
        $('.fc-today-button').text('Today');
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
            eventRender: function (info) {
                element.find('button.fc-prev-button').addClass('btn-color');
            },
        });
        fcCalendar.render();

        //Function to add 0 in date
        function checkTime(i) {
            if (i < 10) {
                i = "0" + i
            }
            ;
            return i;
        }

        $(document).on('change', '#sel', function () {
            //Makes Calendar Selectable to add Leave request

            if ($('#sel').is(":checked")) {
                var Calendar = FullCalendar.Calendar;
                //  Basic Calendar Initialize
                document.getElementById('basic-calendar').innerHTML = "";
                var basicCal = document.getElementById('basic-calendar');
                var fcCalendar = new FullCalendar.Calendar(basicCal, {

                    editable: true,
                    plugins: ["dayGrid", "interaction"],
                    selectable: true,
                    buttonText: {
                        today: 'Today',
                    },
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

                                $('#leave_type').append($('<option disabled selected>Select Leave Type</option>'));
                                for (var i = 0; i < field.leavetype.length; i++) {
                                    console.log(field.leavetype.length);
                                    $('#leave_type').append($('<option></option>').attr('value', field.leavetype[i]['id']).text(field.leavetype[i]['Name']));
                                }
                                $('select').formSelect();
                                //Calculates Date Difference
                                $.ajax({
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
                $('td').append('<span class="hours" style="font-size: 10px;color: white"></span>');
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
                $('td').append('<span class="hours" style="font-size: 10px;color: white"></span>');
                changedata();
                modaldata();
            }
        });


        //Opens modal and fills data for a particular date of that employee on clicking
        function modaldata() {
            //Opens Modal
            $('.fc-day').click(function () {
                var date = $(this).attr('data-date');
                var cl = $(this).attr('class');


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

                $('#modal1').find('#penalty_title').css('display', 'none');

                //Fills data in Modal
                $.getJSON("/attendance/modaldata/" + date, function (result) {
                    $.each(result, function (i, field) {
                        if (field != null) {
                            $('#modal1').modal('open');
                        }
                        field.check_in != null ? $('#modal1').find('#modal_checkin').text(field.check_in) : $('#modal1').find('#modal_checkin').text('None');
                        field.check_out != null ? $('#modal1').find('#modal_checkout').text(field.check_out) : $('#modal1').find('#modal_checkout').text('None');
                        field.check_in_notes != null ? $('#modal1').find('#modal_checkin_notes').text(field.check_in_notes) : $('#modal1').find('#modal_checkin_notes').addClass('red-text').text('None');
                        field.check_out_notes != null ? $('#modal1').find('#modal_checkout_notes').text(field.check_out_notes) : $('#modal1').find('#modal_checkout_notes').addClass('red-text').text('None');
                        field.total_hours != null ? $('#modal1').find('#modal_total_hours').text(field.total_hours) : $('#modal1').find('#modal_total_hours').text('None');
                        field.location != null ? $('#modal1').find('#location').val(field.location) : $('#modal1').find('#location').val('None');
                        if (field.checkout_type == 0) {
                            $('#modal1').find('#penalty_title').css('display', 'table-cell');
                            field.penalty != null ? $('#modal1').find('#penalty_amount').text(field.penalty) : $('#modal1').find('#penalty_amount').val('None');
                        }
                    });
                });
            });

        }

        changedata();
        modaldata();
        $('td').append('<span class="hours" style="font-size:10px;font-weight:800;color:white;margin-left:6px;"></span>');
        $(document).on('click', '.fc-prev-button,.fc-next-button,.fc-today-button', function () {
            $('td').append('<span class="hours" style="font-size:10px;font-weight:800;color:white;margin-left:6px;"></span>');
            changedata();
            modaldata();
        });

        //Tags on top of Calendar
        $(".fc-center").append('' +
                '<span class="task-cat green lighten-2 black-text"><b>Leaves</b></span>' +
                '<span class="task-cat red lighten-2 black-text"><b>Absent</b></span>' +
                '<span class="task-cat" style="background-color: rgb(219 222 255);color:black"><b>Weekend</b></span>' +
                '<span class="task-cat" style="background-color: #ffcc80;color:black"><b>Public Holiday</b></span>' +
                '<span class="task-cat teal lighten-5 black-text"><b>Pending Leaves</b></span>'
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
                var x = 0;
                $.each(result, function (i, field) {
                    var total_leave_types = field[1].length;
                    var leave_name = new Array();
                    for (var l = 0; l < total_leave_types; l++) {
                        leave_name[l] = field[1][l].Name;
                    }
                    var in_date = new Array();
                    for (var ch = 0; ch < leave_name.length; ch++) {
                        in_date[ch] = field[0][leave_name[ch]].length;
                    }
                    for (var c = 0; c < total_leave_types; c++) {
                        for (dd = 0; dd < in_date[c]; dd++) {
                            $('[data-date=' + field[0][leave_name[c]][dd] + ']').css('background-color', '#e0f2f1');
                            $('td[data-date=' + field[0][leave_name[c]][dd] + ']>.hours').text(leave_name[c]);
                            $('td[data-date=' + field[0][leave_name[c]][dd] + ']>.hours').css('font-size', '11px');
                            $('td[data-date=' + field[0][leave_name[c]][dd] + ']>.hours').css('color', 'black');
                            $('[data-date=' + field[0][leave_name[c]][dd] + ']').css('pointer-events', 'none');
                        }
                    }
                });

            });
            //Green for approved leave
            $.getJSON("/attendance/getleavedata/" + id, function (result) {
                var x = 0;
                $.each(result, function (i, field) {
                    var total_leave_types = field[1].length;
                    var leave_name = new Array();
                    for (var l = 0; l < total_leave_types; l++) {
                        leave_name[l] = field[1][l].Name;
                    }
                    var in_date = new Array();
                    for (var ch = 0; ch < leave_name.length; ch++) {
                        in_date[ch] = field[0][leave_name[ch]].length;
                    }
                    for (var c = 0; c < total_leave_types; c++) {
                        for (dd = 0; dd < in_date[c]; dd++) {
                            $('[data-date=' + field[0][leave_name[c]][dd] + ']').css('background-color', '#81C784');
                            $('td[data-date=' + field[0][leave_name[c]][dd] + ']>.hours').text(leave_name[c]);
                            $('[data-date=' + field[0][leave_name[c]][dd] + ']').css('pointer-events', 'none');
                        }
                    }
                });
            });
            /* //Yellow for Holidays
             $.getJSON("/attendance/holidays/getdata", function (result) {
             $.each(result, function (i, field) {
             console.log(field);
             $('[data-date=' + field.Date + ']').css('background-color', '#ffcc80');
             $('td[data-date=' + field.Date + ']>.hours').text(field.Name);
             
             });
             });*/
            $.getJSON("/attendance/leave_holidays/getdata", function (result) {
                $.each(result, function (i, field) {
                    console.log(field);
                    $('[data-date=' + field[0].Date + ']').css('background-color', '#ffcc80');
                    $('[data-date=' + field[0].Date + ']').css('pointer-events', 'none');
                    $('td[data-date=' + field[0].Date + ']>.hours').text(field[0].Name);
                });
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

                    return _hours + 'H' + _minute + 'M';

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

                        return final_hours + 'H' + final_min + 'M';
                    }

                    if (parseInt(vars.second_hour_split[1]) === parseInt(vars.first_hour_split[1])) {
                        hours = parseInt(vars.second_hour_split[0]) - parseInt(vars.first_hour_split[0]);
                        let final_hours = '';

                        if (hours < 10) {
                            final_hours = '0' + hours;
                        } else {
                            final_hours = hours;
                        }

                        return final_hours + 'H' + ' 00 M';
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

                    return _hours + 'H' + _min + 'M';
                } else if (parseInt(vars.first_hour_split[0]) === parseInt(vars.second_hour_split[0])) {
                    hours = '00';
                    let minute = 0;
                    if (parseInt(vars.first_hour_split[1]) < parseInt(vars.second_hour_split[1])) {
                        minute = parseInt(vars.second_hour_split[1]) - parseInt(vars.first_hour_split[1]);
                    }

                    if (minute < 10) {
                        return hours + 'H 0' + minute + ' M';
                    } else {
                        return hours + 'H' + minute + ' M';
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
                        return hours + 'H' + minute + 'M';
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
});

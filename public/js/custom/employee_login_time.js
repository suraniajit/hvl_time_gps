$.ajax({
    type: "get",
    url: url_for_getting_timing, 
    success: function(data){ 
        setstartTimeFrom(data.data.time);
        if(data.data.clock_status == 'stoped'){
            showStopwatchTime();
            $('.activity_no_list_message').show();
        }else 
        if(data.data.clock_status == 'running'){
            startStopwatch();
            $('#__pause_clock').show();
            $('#__stop_clock').show();
            $('.activity_root_div').show();
        }else{
            showStopwatchTime();
            $('#__start_clock').show();
            $('#__stop_clock').show();
            $('.activity_no_list_message').show();
        }
    }
});
function locationSysnc() {
  navigator.geolocation.getCurrentPosition(function (pos) {
    saveCurrentLocation(pos);
    }, function (err) {
      // callback({
      //     "latitude": 21.1702,//null
      //     "longitude": 72.8311,//null,
      //     "status": -1,
      //     "description": `ERROR (${err.code}): ${err.message}`});
  });
}
function saveCurrentLocation(pos){
  $.ajax({
      type: 'post',
      url: url_for_location_share,
      data: {
          "latitude": pos.coords.latitude,
          "longitude": pos.coords.longitude
      },
      headers: {
          'Authorization': 'Bearer ',
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
          clientid: " ",
          clientsecret: " ",
      },
      success: function(data) {
          // if (data.status) {
          //     $('#box_reg_id').val(data.data.next_box_reg_id);
          // } else {
          //     alert('Something Went To Wrong');
          // }
      },
      error: function(data) {
          alert('Something went wrong!');
      },
  });
}
$(document).ready(function () {
  setInterval(locationSysnc, 3000);
});
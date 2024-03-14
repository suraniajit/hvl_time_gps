$(document).on('click', '.add2', function () {

    var count = 1;
    dynamic_field(count);
    // var text = '';
    function dynamic_field(number) {
        var html = '';
        html += '<div class="col s12">' +
            '       <label for="document">Add Media:</label>' +
            '       <div class="file-loading">' +
            '           <input id="file-1" type="file" name="file[]" multiple class="file" >' +
            '       </div>' +
            '    </div>';
        alert(html);
        // html += '<select name="degree[]" class="select" >' +
        //     '<option value="">Select Degree</option>' +
        //     '<option value="0">None</option>' +
        //     '<option value="1">Post Graduate</option>' +
        //     '<option value="2">Graduate</option>' +
        //     '<option value="3">Under Graduate</option>' +
        //     '<option value="4">Phd</option>' +
        //     '<option value="5">Mphil</option>' +
        //     '</select>';
        // html += '<input type="text" name="field[]" class="input-field" placeholder="Enter Field Of Study"  />';
        // html += '<input type="text"  name="start_year[]" class="datepicker" placeholder="Enter Start Date"  />';
        // html += '<input type="text"  name="end_year[]" class="datepicker" placeholder="Enter Exit Date"/>';
        html += '<button type="button" name="remove" class="btn btn-danger btn-sm remove"><i class="material-icons dp48">delete</i></button>';
        html += '</div>';
        $('#Education_Table').append(html);
        $('select').formSelect();

    }
});
$(document).on('click', '.remove', function () {
    $(this).closest('div').remove();
});


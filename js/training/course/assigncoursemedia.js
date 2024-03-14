$(document).on('click', '.add2', function () {
    var html = '';
    var count = 1;
    dynamic_field(count);
     function dynamic_field(number) {
        html +='<label for="document">Add Media:</label>';
        html +='<input id="file-1" type="file" name="file[]" multiple class="file">';
        html +='<div class="file-loading">';
        html +='</div>';
        html +='</div>';
        html += '<button type="button" name="remove" class="btn btn-danger btn-sm remove"><i class="material-icons dp48">delete</i></button>';
        html += '</div>';
        $('#Education_Table').append(html);
        $('select').formSelect();
    }
});
$(document).on('click', '.remove', function () {
    $(this).closest('div').remove();
});


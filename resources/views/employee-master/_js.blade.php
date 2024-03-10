
<script>
    $(document).on('click', '.pass_type_add_btn', function () {
        var count = 1;
        dynamic_field(count);
        // var text = '';
        function dynamic_field(number) {
            var html = '';
            html += '<div class="row"><div class="" style=" border: 0px solid red;">';
            html += '<div class="col s3"><select name="pass_type[]" id="pass_type" class="select" required="">' +
                    '@foreach($PtypeDetails as $Pdetails)<option value="{{$Pdetails->id}}">{{$Pdetails->name}}</option>@endforeach' +
                    '</select><label>Password Type</label></div>';
            html += '<div class="col s3"><input type="text" name="pass_name[]" required="" class="input-field" placeholder="Enter Password*" autocomplete="off" autofocus="off" /></div>';
            html += '<div class="col s3"><input type="text" name="pass_note[]" required="" class="input-field"   placeholder="Note" autofocus="off" autocomplete="off" /></div>';
            html += '<div class="col s3"><button type="button" name="remove" class="btn btn-danger btn-sm remove"><i class="material-icons dp48">delete</i></button></div>';
            html += '<br>';
            html += '</div></div>';


            $('#password_type').append(html);
            $('select').formSelect();
        }
    });
</script>
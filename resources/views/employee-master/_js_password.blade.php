<script type="text/javascript">
    var count = 1;
    $(document).on('click', '.pass_type_add_btn', function () {

        dynamic_field_password_typ(count);
        function dynamic_field_password_typ(number) {
            var html = '';
            html += '<div class="row"><div class="pass_type" style=" border: 0px solid red;">';
            html += '<div class="col"><span class="material-icons remove_password" style="margin-top: 13px;">delete</span></div>';
            html += '<div class="col s3"><label>Password Type *</label><select name="pass_type[]" id="pass_type" class="select"><option value="" disable>Password Type</option>' +
                    '@foreach($PtypeDetails as $Pdetails)<option value="{{$Pdetails->id}}">{{$Pdetails->name}}</option>@endforeach' +
                    '</select></div>';
            html += '<div class="col s4">';
            html += '<label>Password *</label>';
            html += '<input type="text" name="pass_name[]" id="pass_name"  placeholder="Enter Password*" required=""/>';
            html += '</div>';
            html += '<div class="col s4"><label>Note</label><input type="text"  name="pass_note[]" id="pass_note" class="input-field" placeholder="Note" autofocus="off" autocomplete="off" /></div>';
            
            html += '</div></div>';
            $('#password_type').append(html);
            $('select').formSelect();
        }
    });
    $(document).on('click', '.remove_password', function () {
        $(this).closest('div .pass_type').remove();
    });


</script>
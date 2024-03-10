<script type="text/javascript">
    var count = 1;
    $(document).on('click', '.doc_type_add_btn', function () {

        dynamic_field_password_typ(count);
        function dynamic_field_password_typ(number) {
            var html = '';
            html += '<div class="row"><div class="doc_type" style=" border: 0px solid red;">';
            html += '<div class="col"><span class="material-icons remove_document" style="margin-top: 13px;">delete</span></div>';
            html += '<div class="col s2"><label>Document Name*</label><input type="text" name="document_name[]"  required="" placeholder="Document Name" /></div>';
            html += '<div class="col s2"><label>Expiry Date *</label><input type="text"  name="document_expiry[]"  class="date" placeholder="Document Expiry Date" required="" /></div>';
            html += '<div class="col s2"><label>Document Note </label><input type="text" name="pass_note[]" placeholder="Note" /></div>';
            html += '<div class="col s2"><label>Document File (.pdf,.jpeg,.png,)*</label><input type="file" name="document_file[]" class="document_file" accept=".pdf,.png,.jpg,.jpeg" required="" /></div>';

            html += '</div></div>';
            $('#upload_document_type').append(html);
            $('select').formSelect();
            jQuery.datetimepicker.setLocale('en');
            jQuery('.date').datetimepicker({
                timepicker: false,
                format: 'Y-m-d',
             minDate: 1,
                defaultDate: new Date(),
                formatDate: 'Y-m-d',
                scrollInput: false
            });
        }
    });
    $(document).on('click', '.remove_document', function () {
        $(this).closest('div .doc_type').remove();
    });
</script>
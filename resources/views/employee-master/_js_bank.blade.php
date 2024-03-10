<script type="text/javascript">
    var count = 1;
    $(document).on('click', '.bank_type_add_btn', function () {

        dynamic_field_bank_typ(count);
        function dynamic_field_bank_typ(number) {
            var html = '';
            html += '<div class="col s4 bank_type" style=" border: 0px solid red;">';
            html += '<input type="text" name="bank_name[]" id="bank_name" class="input-field" placeholder="Bank Name*"  required="" />';
            html += '<select required name="bank_type[]" class="select">' +
                    '<option disable>Account Type</option>' +
                    '<option value="0">Saving</option>' +
                    '<option value="1">Current</option>' +
                    '</select>';
            html += '<input type="number" name="bank_account_number[]" id="bank_account_number" class="input-field" placeholder="Account Number*"  required="" oninput="this.value = !!this.value && Math.abs(this.value) >= 0 ? Math.abs(this.value) : null"/>';
            html += '<input type="text" name="bank_customer_name[]" id="bank_customer_name" class="input-field" placeholder="Account Holder Name*"  required="" />';
            html += '<input type="text" name="IBAN[]" id="IBAN" class="input-field" placeholder="IBAN*" minlength="23" maxlength="23" required="" />';
            html += '<input type="text" name="bank_note[]" id="bank_note" placeholder="Note"  />';
            html += '<center> ';
            html += '<span class="material-icons remove_bank" style="margin-top: 13px;">delete</span>';
            html += '</center>';
            html += '</div>';
            

            $('#upload_bank_type').append(html);
            $('select').formSelect();
            jQuery.datetimepicker.setLocale('en');
            jQuery('.date').datetimepicker({
                timepicker: false,
                format: 'Y-m-d',
                minDate: 0,
                defaultDate: new Date(),
                formatDate: 'Y-m-d',
                scrollInput: false
            });
        }
    });
    $(document).on('click', '.remove_bank', function () {
        $(this).closest('div .bank_type').remove();
    });
</script>
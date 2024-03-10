<script type="text/javascript">
    var count = 1;
    $(document).on('click', '.vehicle_type_add_btn', function () {
        vehicle_field_bank_typ(count);
        function vehicle_field_bank_typ(number) {
            var html = '';
            html += '<div class="input-field col s4 vehical_type" style=" border: 0px solid red;">';
            html += '<input type="text" name="vehicle_name[]" id="vehicle_name"  placeholder="Name*" required="" />';
            html += '<input type="text" name="vehicle_number[]" id="vehicle_number"  placeholder="Number*" required="" />';
            html += '<input type="number" oninput="this.value = !!this.value && Math.abs(this.value) >= 0 ? Math.abs(this.value) : null" name="vehicle_mileage[]" id="vehicle_mileage"  placeholder="Mileage*" required="" />';
            html += '<input type="number" oninput="this.value = !!this.value && Math.abs(this.value) >= 0 ? Math.abs(this.value) : null" name="vehicle_run_start[]" id="vehicle_run_start"  placeholder="Run Start" />';
            html += '<input type="number" oninput="this.value = !!this.value && Math.abs(this.value) >= 0 ? Math.abs(this.value) : null" name="vehicle_run_end[]" id="vehicle_run_end" placeholder="Run End"  />';
            html += '<input type="text" name="vehicle_note[]" id="vehicle_note" placeholder="Note" />';
            html += '<center> ';
            html += '<span class="material-icons remove_vehicle" style="margin-top: 13px;">delete</span>';
            html += '</center>';
            html += '</div>';
            html += '</div>';

            $('#vehicle_bank_type').append(html);
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
    $(document).on('click', '.remove_vehicle', function () {
        $(this).closest('div .vehical_type').remove();
    });
</script>
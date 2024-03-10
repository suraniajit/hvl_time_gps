<h5 class="card-title">
    Vehicle Details 
    <a class="vehicle_type_add_btn">
        <i class="material-icons">add_circle_outline</i>
    </a>
</h5>
<div id="vehicle_bank_type" class="row">
    <?php
    foreach ($vehicleDetails as $key => $value) {
        ?>
        <div class="input-field col s4 vehical_type" style=" border: 0px solid red">
            <input type="text" value="{{$value->vehicle_name}}" name="vehicle_name[]" id="vehicle_name"  placeholder="Name*"  required="" />
            <input type="text" value="{{$value->vehicle_number}}" name="vehicle_number[]" id="vehicle_number"  placeholder="Number*"  required="" />
            <input type="number" value="{{$value->vehicle_mileage}}" name="vehicle_mileage[]" id="vehicle_mileage"  placeholder="Mileage*"  required="" oninput="this.value = !!this.value && Math.abs(this.value) >= 0 ? Math.abs(this.value) : null"/>
            <input type="number" value="{{$value->vehicle_run_start}}" name="vehicle_run_start[]" id="vehicle_run_start" placeholder="Run Start" oninput="this.value = !!this.value && Math.abs(this.value) >= 0 ? Math.abs(this.value) : null"/>
            <input type="number" value="{{$value->vehicle_run_end}}" name="vehicle_run_end[]" id="vehicle_run_end" placeholder="Run End" oninput="this.value = !!this.value && Math.abs(this.value) >= 0 ? Math.abs(this.value) : null"/>
            <input type="text" value="{{$value->vehicle_note}}" name="vehicle_note[]" id="vehicle_note" placeholder="Note" />
            <center> 
                <span class="material-icons remove_bank rmv"  data-id="{{ $value->id }}" data-name="vehicle_details" style="margin-top: 13px">delete</span>
            </center>
        </div>
    <?php } ?>
</div>
<br>

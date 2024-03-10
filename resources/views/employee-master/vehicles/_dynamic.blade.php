<h5 class="card-title">
    Month by Month Mileage
    <a class="pass_type_add_btn">
        <i class="material-icons">add_circle_outline</i>
    </a>
</h5>
<div id="password_type">
    <div class="row">
        <div class="pass_type" style=" border: 0px solid red;">
            <div class="col"><span class="material-icons remove_password" style="margin-top: 13px;">delete</span></div>
            <div class="col s3"><label>Month Name</label>
                <input type="text" name="month_name[]" id="month_name" class="" placeholder="Enter Month Name" autofocus="off" autocomplete="off" />
            </div>
            <div class="col s2"> 
                <label>From Date</label>
                <input type="text" class="date" name="from_date[]" placeholder="From Date">
            </div> 
            <div class="col s2"> 
                <label>To Date</label>
                <input type="text" class="date" name="to_date[]" placeholder="To Date">
            </div>
            <div class="col s2"> 
                <label>Current Mileage</label>
                <input name="current_mileage[]" id="current_mileage" type="number" oninput="this.value = !!this.value && Math.abs(this.value) >= 0 ? Math.abs(this.value) : null" ">
            </div> 
            <div class="col s2"><label>Note</label>
                <input type="text"  name="vehicles_note[]" id="vehicles_note" class="" placeholder="Note" autofocus="off" autocomplete="off" />
            </div>
        </div>
    </div>
</div>    

<div class="input-field col s4">
    <label>Start Date  </label>
    <input type="text" name="txt_start_date" id="txt_start_date" class="txt_start_date" data-error=".errorTxt6" placeholder="Enter Job Opening Date" autocomplete="off" autofocus="off" >
    <div class="errorTxt6"></div>
</div>
<div class="input-field col s4">
    <label> End Date </label>
    <input type="text" name="txt_end_date" id="txt_end_date" class="txt_end_date" data-error=".errorTxt7" placeholder="Enter Job Closing Date" autocomplete="off" autofocus="off">
    <div class="errorTxt7"></div>
</div>
<div class="input-field col s4">
    <select class="select-dropdown " data-error=".errorTxt5" name="ddl_type" id="ddl_type">
        <option value="" disable="" selected>Type</option>
        <option value="Service" >Service</option>
        <option value="Call" >Call</option>
        <option value="Meeting" >Meeting</option>
    </select>
    <label for="fn">Type</label>
    <div class="errorTxt5"></div>
</div>
<div class="input-field col s4">
    <select class="select-dropdown " data-error=".errorTxt5" name="ddl_frequency" id="ddl_frequency">
        <option value="" disable="" selected>Select frequency</option>
        <option value="daily">Daily</option>
        <option value="weekly">Weekly</option>
        <option value="fortnightly">Fortnightly</option>
        <option value="monthly">Monthly</option>
        <option value="bimonthly">Bimonthly</option>
        <option value="quarterly">Quarterly</option>
        <option value="quarterly_twice">Quarterly twice</option>
        <option value="thrice_year">Thrice in a Year</option>
        <option value="onetime">One Time</option>
    </select>
    <label for="fn">Select frequency</label>
    <div class="errorTxt5"></div>
</div>
<div class="input-field col s4">
    <select class="select-dropdown " data-error=".errorTxt5" name="ddl_status" id="ddl_status">
        <option value="" disable="">Status</option>
        <option value="Not Started" selected>Not Started</option>
        <option value="In Progress">In Progress</option>
        <option value="Completed">Completed</option>
    </select>
    <label for="fn">Status</label>
    <div class="errorTxt5"></div>
</div>
<div class="input-field col s4">
    <label for="fn">Activity</label>
    <textarea class="materialize-textarea" id="comment" name="comment"></textarea>
</div>

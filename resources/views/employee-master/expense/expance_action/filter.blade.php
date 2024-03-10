<form id="formValidateEmployee" action="{{ route('expance_action.expance_action_search') }}" method="get" enctype="multipart/form-data">
    {{csrf_field()}}
    <div class="row" style="margin-top: 27px;margin-bottom: 27px;">
        <div class="col-sm-6 col-md-3"> 
            <!--<label>From Date</label>-->
            <input type="text" class="datepicker" name="from_date_search" placeholder="Select From Date" value="<?php echo isset($from_date) ? $from_date : '' ?>">
        </div> 
        <div class="col-sm-6 col-md-3"> 
            <!--<label>To Date</label>-->
            <input type="text" class="datepicker" name="to_date_search" placeholder="Select To Date" value="<?php echo isset($to_date) ? $to_date : '' ?>">
        </div>
        <div class="col-sm-6 col-md-4"> 
            <button class="btn btn-primary mr-1" type="submit">Search</button>
            <button type="reset" class="btn btn-secondary  mb-1"><a href="/expance_action/" class="text-white">Reset</a></button>
        </div>
    </div>
</form>
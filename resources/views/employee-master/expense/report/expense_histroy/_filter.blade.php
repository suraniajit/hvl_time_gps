
{{csrf_field()}}
<div class="container-fluid1">
    <div class="card1">
        <div class="card-content">
            <div class="row">
                <div class="col-sm-6 col-md-2"> 
                    <!--<label>From Date</label>-->
                    <input type="text" class="datepicker" name="from_date_search" placeholder="Select From Date" value="<?php echo isset($from_date) ? $from_date : '' ?>">
                </div> 
                <div class="col-sm-6 col-md-2"> 
                    <!--<label>To Date</label>-->
                    <input type="text" class="datepicker" name="to_date_search" placeholder="Select To Date" value="<?php echo isset($to_date) ? $to_date : '' ?>">
                </div>
                <div class="col-sm-6 col-md-8 " style="text-align: end;">
                    <button class="btn btn-primary mr-1" type="submit">Search</button>
                    <button type="reset" class="btn btn-secondary  mb-1">
                        <a href="/report_history_index" class="text-white">Reset</a>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
</form>
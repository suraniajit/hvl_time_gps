<div class="container-fluid1">
    <div class="card1" style="display: none;">
        <div class="card-content">
 
            <form id="formValidateEmployee" action="{{ route('expense.search_details', $emp_id) }}" method="get" enctype="multipart/form-data">
                <input type="hidden" name="is_user" value="{{Auth::id()}}" />
                {{csrf_field()}}
                <div class="row">
                    <div class="col-sm-6 col-md-2"> 
                        <!--<label>To Date</label>-->
                        <input type="text" class="datepicker" name="to_date_search" placeholder="Select To Date" value="<?php echo isset($to_date) ? $to_date : '' ?>">
                    </div>
                    <div class="col-sm-6 col-md-2"> 
                        <!--<label>From Date</label>-->
                        <input type="text" class="datepicker" name="from_date_search" placeholder="Select From Date" value="<?php echo isset($from_date) ? $from_date : '' ?>">
                    </div> 
                    <div class="col-sm-6 col-md-2">
                        <select name="payment_method_id_search" class="form-control select">
                            <option  selected="" value="0">Payment Method</option>
                            @foreach($payment_method_master as $payment)
                            <?php if (isset($payment_method_id)) { ?>
                                <option value="{{$payment->id}}" {{$payment->id == $payment_method_id ? 'selected' : ''}}>{{$payment->name}}</option>
                            <?php } else { ?>
                                <option value="{{$payment->id}}">{{$payment->name}}</option>
                            <?php } ?>
                            @endforeach
                        </select>
                        <!--<label>Payment Method</label>-->
                    </div>

                    <div class="col-sm-6 col-md-2">
                        <select name="payment_status_id_search" class="form-control select">
                            <option selected="" value="0">Payment Status</option>
                            @foreach($payment_status_master as $payment_status)
                            <?php if (isset($payment_status_id)) { ?>
                                <option value="{{$payment_status->id}}" {{$payment_status->id == $payment_status_id ? 'selected' : ''}}>{{$payment_status->name}}</option>
                            <?php } else { ?>
                                <option value="{{$payment_status->id}}">{{$payment_status->name}}</option>
                            <?php } ?>
                            @endforeach
                        </select>
                        <!--<label>Payment Status</label>-->
                    </div>
                    <div class="col-sm-6 col-md-2">
                    </div>
                    <div class="mt-0 col-sm-6 col-md-2">
                        <div class="col-sm-12 ">
                            <button class="btn btn-primary mr-2" type="submit" >

                                Search
                            </button>
                            <button type="reset" class="btn btn-secondary  mb-1">

                                <a href="/expense/" class="text-white">Reset</a>
                            </button>
                        </div>
                    </div>
                </div>
        </div>
    </div>
</div>


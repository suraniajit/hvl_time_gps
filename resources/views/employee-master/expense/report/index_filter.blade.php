<div class="container-fluid1">
    <div class="card1">
        <div class="card-content">


            <form id="formValidateEmployee" action="{{ route('expense_report.search_details') }}" method="get" enctype="multipart/form-data">
                {{csrf_field()}}
                <div class="row">

                    <div class="col-sm-6 col-md-2">   
                        <select name="employee_id[]" id="employee_id" class="form-control select" multiple>


                            @foreach($employee_master as $key=>$employee)
                            <?php if (isset($employee_id)) { ?>
                                <option value="{{$employee->user_id}}" {{(in_array($employee->user_id,$employee_id)?'selected':'')}} >{{$employee->Name}}</option>
                            <?php } else { ?>
                                <option value="{{$employee->user_id}}" selected>{{$employee->Name}}</option>
                            <?php } ?>
                            @endforeach
                        </select>
                        <!--<label>Payment Method</label>-->
                    </div>

                    <div class="col-sm-6 col-md-2"> 
                        <!--<label>To Date</label>-->
                        <input type="text" class="datepicker" name="to_date_search" placeholder="Select To Date" value="<?php echo isset($to_date) ? $to_date : '' ?>">
                    </div>
                    <div class="col-sm-6 col-md-2"> 
                        <!--<label>From Date</label>-->
                        <input type="text" class="datepicker" name="from_date_search" placeholder="Select From Date" value="<?php echo isset($from_date) ? $from_date : '' ?>">
                    </div> 

                    <div class="col-sm-6 col-md-2" style="display: none;">

                        <select name="payment_status[]" id="payment_status" class="form-control select">
                            <option  disabled="">Payment Status</option>
                            <?php if (isset($payment_status)) { ?>
                                <option value="2" {{(in_array(2,$payment_status)?'selected':'')}} >In Process 2</option>
                                <option value="4" {{(in_array(4,$payment_status)?'selected':'')}} >Completed 4</option>
                            <?php } else { ?>
                                <option value="2">In Process 2</option>
                                <option value="4">Completed 4</option>
                            <?php } ?>
                        </select>
                        <!--<label>Payment Method</label>-->
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <select name="process_status[]" id="process_status" class="form-control select" >
                            <option  selected="" value="0">Process Status</option>
                            <?php if (isset($process_status)) { ?>
                                <option value="1" {{(in_array(1,$process_status)?'selected':'')}} >Accepted from Manager</option>
                                <option value="2" {{(in_array(2,$process_status)?'selected':'')}} >Rejected from Manager</option>
                                <option value="3" {{(in_array(3,$process_status)?'selected':'')}} >Accepted from Account</option>
                                <option value="4" {{(in_array(4,$process_status)?'selected':'')}} >Rejected from Account</option>
                                <!--<option value="5" {{(in_array(5,$process_status)?'selected':'')}} >Accepted from Admin</option>-->
                                <!--<option value="6" {{(in_array(6,$process_status)?'selected':'')}} >Rejected from Admin </option>-->
                                <option value="12" {{(in_array(12,$process_status)?'selected':'')}} >Partially Approved from Account</option>
                                <option value="11" {{(in_array(11,$process_status)?'selected':'')}} >Partially Approved from Manager</option>
                            <?php } else { ?>
                                <option value="1">Accepted from Manager</option>
                                <option value="2">Rejected from Manager</option>
                                <option value="3">Accepted from Account</option>
                                <option value="4">Rejected from Account</option>
                                <option value="12">Partially Approved from Account</option>
                                <option value="11">Partially Approved from Manager</option>
                            <?php } ?>
                        </select>
                        <!--<label>Payment Method</label>-->
                    </div>
                    <div class="col-sm-6 col-md-2" style="display: none;">
                        <select name="payment_method_id_search" id="payment_method_id_search" class="form-control select">
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

                    <div class="col-sm-6 col-md-2" style="display: none;">
                        <select name="payment_status_id_search[]" id="payment_status_id_search" class="form-control select" multiple>
                            @foreach($payment_status_master as $payment_status)
                            <?php if (isset($payment_status_id)) { ?>
                                <option value="{{$payment_status->id}}" {{(in_array($payment_status->id,$payment_status_id)?'selected':'')}} >{{$payment_status->name}}</option>
                            <?php } else { ?>
                                <option value="{{$payment_status->id}}" >{{$payment_status->name}}</option>
                            <?php } ?>
                            @endforeach
                        </select>
                        <!--<label>Payment Status</label>-->
                    </div>
                </div>
                <div class="row" style="float: right;margin: 10px;">

                    <div class="col-sm-12 ">
                        <button class="btn btn-primary mr-1" type="submit">Search</button>
                        <button type="reset" class="btn btn-secondary  mb-1"><a href="/expense_report/" class="text-white">Reset</a></button>
                    </div>

                </div>
        </div>
    </div>
</div>

<br><br>
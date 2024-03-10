<?php $__env->startSection('title','Customer Management | HVL'); ?>

<?php $__env->startSection('vendor-style'); ?>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="breadcrumb-holder">
    <div class="container-fluid">
        <ul class="breadcrumb">
            <!--<li class="breadcrumb-item"><a href="<?php echo e(url('/')); ?>">Home</a></li>-->
            <li class="breadcrumb-item active"><a href="<?php echo e(route('customer.index')); ?>">Customer Management </a></li>
            <li class="breadcrumb-item ">Update Customer</li>
        </ul>
    </div>
</div>
<section>
    <div class="container-fluid">
        <div class="card">
            <div class="card-body p-4">
                <header>
                    <div class="row">
                        <div class="col-md-7">
                            <h2 class="h3 display"> Update Customer</h2>
                            <p style="font-size: 12px;"><strong>Note:</strong> Comma is not allowed in any field.</p>
                        </div>
                    </div>

                </header>
                <form action="<?php echo e(route('customer.update',['id' => $details->id])); ?>" id="formValidate" method="post">

                    <?php echo e(csrf_field()); ?>


                    <div class="row">
                        <div class=" form-group col-sm-6 col-md-4">
                            <label >Employee <span class="text-danger">*</span></label>
                            <select name="employee_id[]" id="" class="select form-control" multiple required data-error=".errorTxt22" autocomplete="off" autofocus="off">
                                <?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($employee->id); ?>" <?php echo e(in_array($employee->id , $customer_employees) ? 'selected'  : ''); ?> > <?php echo e($employee->Name); ?> </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                            </select>
                            <div class="errorTxt22text-danger"></div>
                        </div>

                        <div class=" form-group col-sm-6 col-md-4">
                            <label >Customer Code <span class="text-danger">*</span></label>
                            <input type="text" name="customer_code" class="form-control" onkeypress="return RestrictCommaSemicolon(event);" ondrop="return false;" onpaste="return false;" placeholder="Enter Customer Name" value="<?php echo e($details->customer_code); ?>" data-error=".errorTxt1" autocomplete="off" autofocus="off">
                            <div class="errorTxt1 text-danger"></div>
                        </div>

                        <div class=" form-group col-sm-6 col-md-4">
                            <label >Customer Name <span class="text-danger">*</span></label>
                            <input type="text" name="customer_name" class="form-control" onkeypress="return RestrictCommaSemicolon(event);" ondrop="return false;" onpaste="return false;" placeholder="Enter Customer Name" value="<?php echo e($details->customer_name); ?>" data-error=".errorTxt2" autocomplete="off" autofocus="off">
                            <div class="errorTxt2 text-danger"></div>
                        </div>

                        <div class=" form-group col-sm-6 col-md-4">
                            <label >Customer Alias Name <span class="text-danger">*</span></label>
                            <input type="text" name="customer_alias" class="form-control" onkeypress="return RestrictCommaSemicolon(event);" ondrop="return false;" onpaste="return false;" placeholder="Enter Customer Alias" value="<?php echo e($details->customer_alias); ?>" data-error=".errorTxt3" autocomplete="off" autofocus="off">
                            <div class="errorTxt3 text-danger"></div>
                        </div>

                        <div class=" form-group col-sm-6 col-md-4">
                            <label >Billing Address <span class="text-danger">*</span></label>
                            <input type="text" name="billing_address" class="form-control" onkeypress="return RestrictCommaSemicolon(event);" ondrop="return false;" onpaste="return false;" placeholder="Enter Billing Address" value="<?php echo e($details->billing_address); ?>" data-error=".errorTxt4" autocomplete="off" autofocus="off">
                            <div class="errorTxt4 text-danger"></div>
                        </div>

                        <div class=" form-group col-sm-6 col-md-4">
                            <label >Billing State <span class="text-danger">*</span></label>
                            <select name="billing_state" class="form-control" id="billing_state" autocomplete="off" autofocus="off" data-error=".errorTxt5">
                                <?php $__currentLoopData = $states; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $state): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($state->id); ?>" <?php if($details->billing_state == $state->id): ?> selected <?php endif; ?>><?php echo e($state->state_name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <div class="errorTxt5 text-danger"></div>
                        </div>
                        <div class=" form-group col-sm-6 col-md-4">
                            <label >Billing City <span class="text-danger">*</span></label>
                            <select name="billing_city" id="billing_city" class="form-control" autocomplete="off" autofocus="off" data-error=".errorTxt29">
                                <?php $__currentLoopData = $billing_cities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $city): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($city->id); ?>" <?php if($details->billing_city == $city->id): ?> selected <?php endif; ?>><?php echo e($city->city_name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <div class="errorTxt29 text-danger"></div>
                        </div>
                        <div class=" form-group col-sm-6 col-md-4">
                            <label class="shift_name">Billing Pincode</label>
                            <input type="number" name="billing_pincode" class="form-control" data-error=".errorTxt30" value="<?php echo e($details->billing_pincode); ?>">
                            <div class="errorTxt30 text-danger"></div>
                        </div>

                        <div class=" form-group col-sm-6 col-md-4">
                            <label for="">Billing Location<span class="text-danger">*</span> </label>
                            <input type="text" value="<?php echo e(old('billing_location',$details->billing_location)); ?>"  name="billing_location" class="form-control" id="billing_location" placeholder="Enter Billing Location" data-error=".errorTxtBillingLocation">
                            <div class="errorTxtBillingLocation text-danger"></div>
                        </div>
                        <div class=" form-group col-sm-6 col-md-4">
                            <label for="">Billing Latitude<span class="text-danger">*</span> </label>
                            <input type="text" value="<?php echo e(old('billing_latitude',$details->billing_latitude)); ?>"  readonly name="billing_latitude" class="form-control" id="billing_latitude" placeholder="Latitude" data-error=".errorTxtBillingLatitude">
                            <div class="errorTxtBillingLatitude text-danger"></div>
                        
                        </div>
                        <div class=" form-group col-sm-6 col-md-4">
                            <label for="">Billing Longitude<span class="text-danger">*</span> </label>
                            <input type="text" value="<?php echo e(old('billing_longitude',$details->billing_longitude)); ?>" readonly name="billing_longitude" class="form-control" id="billing_longitude" placeholder="Longitude" data-error=".errorTxtBillingLongitude">
                            <div class="errorTxtBillingLongitude text-danger"></div>
                        
                        </div>
                        <div class=" form-group col-sm-6 col-md-4">
                            <label >Contact Person <span class="text-danger">*</span></label>
                            <input type="text" name="contact_person" class="form-control " onkeypress="return RestrictCommaSemicolon(event);" ondrop="return false;" onpaste="return false;" placeholder="Enter Contact Person" value="<?php echo e($details->contact_person); ?>" data-error=".errorTxt6" autocomplete="off" autofocus="off">
                            <div class="errorTxt6 text-danger"></div>
                        </div>

                        <div class=" form-group col-sm-6 col-md-4">
                            <label for="">Contact Person Phone <span class="text-danger">*</span></label>
                            <input type="number" name="contact_person_phone" class="form-control" placeholder="Enter Contact Person Phone" value="<?php echo e($details->contact_person_phone); ?>" data-error=".errorTxt7" autocomplete="off" autofocus="off">
                            <div class="errorTxt7 text-danger"></div>
                        </div>

                        <div class=" form-group col-sm-6 col-md-4">
                            <label for="">Billing Email </label>
                            <input type="email" name="billing_mail" class="form-control " onkeypress="return RestrictCommaSemicolon(event);" ondrop="return false;" onpaste="return false;" placeholder="Enter Billing Email" value="<?php echo e($details->billing_email); ?>" data-error=".errorTxt8" autocomplete="off" autofocus="off" onchange="return TimeCalculation();">
                            <div class="errorTxt8 text-danger"></div>
                        </div>

                        <div class=" form-group col-sm-6 col-md-4">
                            <label >Billing Mobile <span class="text-danger">*</span></label>
                            <input type="number" name="billing_mobile" class="form-control" placeholder="Enter Billing Mobile" value="<?php echo e($details->billing_mobile); ?>" autocomplete="off" autofocus="off" data-error=".errorTxt9">
                            <div class="errorTxt9 text-danger"></div>
                        </div>
                        
                        <div class=" form-group col-sm-6 col-md-4" >
                            <label class="shift_name">Operator</label>
                            <input type="text" name="operator" class="form-control" placeholder="Enter Operator" value="<?php echo e($details->operator); ?>" autocomplete="off" autofocus="off" data-error=".errorOperator">
                            <div class="errorOperator text-danger"></div>
                        </div>
                        <div class=" form-group col-sm-6 col-md-4">
                            <label class="shift_name">Operation Executive</label>
                            <select name="operation_executive" class="form-control" autocomplete="off" autofocus="off"  data-error=".errorOperationExecutive">
                                <option value=""> Select Operation Executive</option>
                                <?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($employee->Name); ?>" <?php echo e((($employee->Name == $details->operation_executive))?'selected':''); ?>><?php echo e($employee->Name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <div class="errorOperationExecutive text-danger"></div>
                        </div>
                        <div class=" form-group col-sm-6 col-md-4">
                            <label >Sales Person <span class="text-danger">*</span></label>
                            <select name="sales_person" id="sales_person_id" class="form-control" autocomplete="off" autofocus="off" data-error=".errorTxt10">
                                <option value=""> Select Sales Person</option>
                                <?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($employee->Name); ?>" <?php echo e($employee->Name == $details->sales_person ? 'selected'  : ''); ?> > <?php echo e($employee->Name); ?> </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <div class="errorTxt10 text-danger"></div>
                        </div>
                        <div class=" form-group col-sm-6 col-md-4">
                            <label >Reference </span></label>
                            <select name="reference" id="reference_id" class="form-control" autocomplete="off" autofocus="off" data-error=".errorTxtreference">
                                <option value=""> Reference Person</option>
                                <?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($employee->Name); ?>" <?php echo e($employee->Name == $details->reference ? 'selected'  : ''); ?> > <?php echo e($employee->Name); ?> </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <div class="errorTxtreference text-danger"></div>
                        </div>


                        <div class=" form-group col-sm-6 col-md-4">
                            <label for="">Create Date <span class="text-danger">*</span></label>
                            <input type="text" class="datepicker form-control" disabled name="create_date" value="<?php echo e($details->create_date); ?>" placeholder="Enter Create Date" data-error=".errorTxt12" autocomplete="off" autofocus="off">
                            <div class="errorTxt12 text-danger"></div>
                        </div>

                        <div class=" form-group col-sm-6 col-md-4">
                            <label >Shipping Address <span class="text-danger">*</span></label>
                            <input type="text" name="shipping_adress" class="form-control " onkeypress="return RestrictCommaSemicolon(event);" ondrop="return false;" onpaste="return false;" value="<?php echo e($details->shipping_address); ?>" placeholder="Enter Shipping Address" autocomplete="off" autofocus="off" data-error=".errorTxt13">
                            <div class="errorTxt13 text-danger"></div>
                        </div>

                        <div class="form-group col-sm-6 col-md-4">
                            <label >Shipping State <span class="text-danger">*</span></label>
                            <select name="shipping_state" id="shipping_state" class="form-control" autocomplete="off" autofocus="off" data-error=".errorTxt14">
                                <option>Select State</option>
                                <?php $__currentLoopData = $states; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $state): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($state->id); ?>" <?php if($details->shipping_state == $state->id): ?> selected <?php endif; ?>><?php echo e($state->state_name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <div class="errorTxt14 text-danger"></div>
                        </div>
                        <div class=" form-group col-sm-6 col-md-4">
                            <label >Shipping City <span class="text-danger">*</span></label>
                            <select name="shipping_city" id="shipping_city" class="form-control" autocomplete="off" autofocus="off" data-error=".errorTxt15">
                                <?php $__currentLoopData = $shipping_cities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $city): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($city->id); ?>" <?php if($details->shipping_city == $city->id): ?> selected <?php endif; ?>><?php echo e($city->city_name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <div class="errorTxt15 text-danger"></div>
                        </div>
                        <div class=" form-group col-sm-6 col-md-4">
                            <label class="shift_name">Shipping Pincode</label>
                            <input type="number" name="shipping_pincode" class="form-control" data-error=".errorTxt28" value="<?php echo e($details->shipping_pincode); ?>">
                            <div class="errorTxt28 text-danger"></div>
                        </div>

                        <div class=" form-group col-sm-6 col-md-4">
                            <label >Credit Limit </label>
                            <input type="number" name="credit_limit" class="form-control" value="<?php echo e($details->credit_limit); ?>" placeholder="Enter Credit Limit" data-error=".errorTxt16" autocomplete="off" autofocus="off">
                            <div class="errorTxt16 text-danger"></div>
                        </div>

                        <div class=" form-group col-sm-6 col-md-4">
                            <label >Gst Registration Type <span class="text-danger">*</span></label>
                            <select name="gst_reges_type" id="reges_type" class="form-control" data-error=".errorTxt17" autocomplete="off" autofocus="off">
                                <option value="Yes" <?php if($details->gst_reges_type == 'Yes'): ?> selected <?php endif; ?>>Yes</option>
                                <option value="No" <?php if($details->gst_reges_type == 'No'): ?> selected <?php endif; ?>>No</option>
                            </select>
                            <div class="errorTxt17 text-danger"></div>
                        </div>

                        <div class=" form-group col-sm-6 col-md-4" id="gst_in" <?php if(empty($details->gstin)): ?> style="display: none;" <?php endif; ?>>
                             <label >GSTIN <span class="text-danger">*</span></label>
                            <input type="text" name="gstin" class="form-control " onkeypress="return RestrictCommaSemicolon(event);" ondrop="return false;" onpaste="return false;" placeholder="Enter GSTIN Number" value="<?php echo e($details->gstin); ?>" data-error=".errorTxt18" autocomplete="off" autofocus="off">
                            <div class="errorTxt18 text-danger"></div>
                        </div>

                        <div class=" form-group col-sm-6 col-md-4">
                            <label >Branch <span class="text-danger">*</span></label>
                            <select name="branch" id="" class="form-control" data-error=".errorTxt19" autocomplete="off" autofocus="off">
                                <option value=""> Select Branch</option>
                                <?php $__currentLoopData = $branchs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $branch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($branch->id); ?>" <?php if($details->branch_name == $branch->id): ?> selected <?php endif; ?>><?php echo e($branch->Name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <div class="errorTxt19 text-danger"></div>
                        </div>

                        <div class=" form-group col-sm-6 col-md-4">
                            <label >Payment Mode </label>
                            <select name="payment_mode" class="form-control" id="" data-error=".errorTxt20" autocomplete="off" autofocus="off">
                                <option value="Cash" <?php echo e(($details->payment_mode == 'Cash')?'selected':''); ?>>Cash</option>
                                <option value="Online" <?php echo e(($details->payment_mode == 'Online')?'selected':''); ?>>Online</option>
                            </select>
                            <div class="errorTxt20 text-danger"></div>
                        </div>

                        <div class=" form-group col-sm-6 col-md-4">
                            <label class="shift_name">Contract Start Date  <span class="text-danger">*</span> </label>
                            <input type="text" name="con_start_date" class="form-control datepicker" value="<?php echo e($details->con_start_date); ?>" data-error=".errorTxtcon_start_date">
                            <div class="errorTxtcon_start_date text-danger"></div>
                        </div>
                        <div class=" form-group col-sm-6 col-md-4">
                            <label class="shift_name">Contract End Date  <span class="text-danger">*</span> </label>
                            <input type="text" name="con_end_date" class="form-control datepicker" value="<?php echo e($details->con_end_date); ?>" data-error=".errorTxt23" >
                            <div class="errorTxt23 text-danger"></div>
                        </div>
                        <div class=" form-group col-sm-6 col-md-4">
                            <label class="shift_name">Value <span class="text-danger">*</span> </label>
                            <input type="text" name="cust_value" class="form-control " onkeypress="return RestrictCommaSemicolon(event);" ondrop="return false;" onpaste="return false;" value="<?php echo e($details->cust_value); ?>" data-error=".errorTxt31" >
                            <div class="errorTxt31 text-danger"></div>
                        </div>
                        <div class=" form-group col-sm-6 col-md-4">
                            <label >Status <span class="text-danger">*</span></label>
                            <select name="is_active" class="form-control" autocomplete="off" autofocus="off" id="is_active" data-error=".errorTxt21">
                                <option value="0" <?php echo e(($details->is_active == '0')?'selected':''); ?> >Active</option>
                                <option value="1" <?php echo e(($details->is_active == '1')?'selected':''); ?>>Inactive</option>
                            </select>
                            <div class="errorTxt21 text-danger"></div>
                        </div>
                        <div class=" form-group col-sm-6 col-md-4" id="inactive_remark" >
                             <label >Remark</label>
                            <input type="text" name="inactive_remark" class="form-control " placeholder="Enter Remark" value="<?php echo e($details->inactive_remark); ?>" data-error=".errorTxtRemark" >
                            <div class="errorTxtRemark text-danger"></div>
                        </div>
                        <div class=" form-group col-sm-6 col-md-4" id="inactive_date" >
                             <label >Inactive Date</label>
                            <input type="text" name="inactive_date" class="form-control datepicker" placeholder="Enter Inactive Date" value="<?php echo e($details->inactive_date); ?>" data-error=".errorTxtInactiveDate" >
                            <div class="errorTxtRemark text-danger"></div>
                        </div>
                        
                    </div>
                    <div class="row mt-4 pull-right">
                        <div class="col-sm-12 ">
                            <button class="btn btn-primary mr-2" id="submit_edit_form" type="submit" name="action">
                                <i class="fa fa-arrow-circle-up"></i>
                                Update
                            </button>
                            <button type="reset" class="btn btn-secondary  mb-1">
                                <i class="fa fa-arrow-circle-left"></i>
                                <a href="<?php echo e(url()->previous()); ?>" class="text-white">Cancel</a>
                            </button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</section>

<?php $__env->stopSection(); ?>


<?php $__env->startSection('page-script'); ?>
<script src="<?php echo e(asset('js/hvl/customermaster/edit.js')); ?>"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBxKK1ePS2LinpV1r09ctx6rWLP6TLuW0s&callback=initAutocomplete&libraries=places&v=weekly" defer ></script>
<script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
<script>
        let autocomplete;
        let address1Field;
        function initAutocomplete() {
        address1Field = document.querySelector("#billing_location");
        autocomplete = new google.maps.places.Autocomplete(address1Field, {
            componentRestrictions: { country: ["in"] },
            fields: ["ALL"],
            // types: ["atm","airport","amusement_park","aquarium","art_gallery","art_gallery"],
        });
        address1Field.focus();
        autocomplete.addListener("place_changed", fillInAddress);
        }

    function fillInAddress() {
        const place = autocomplete.getPlace();
        $('#billing_latitude').val(place.geometry.location.lat());
        $('#billing_longitude').val(place.geometry.location.lng());
    }
    window.initAutocomplete = initAutocomplete;
    $("#billing_location").keyup(function(){
        $('#billing_latitude').val('');
        $('#billing_longitude').val('');
    });
</script>





<script>

    $(document).ready(function () {
        $("#sales_person_id").select2();
        $("#reference_id").select2();
        $('.select').multiselect({
            includeSelectAllOption: true,
            enableFiltering: true,
            maxHeight: 450
        });
        <?php if($details->is_active == 1): ?>
            $('#inactive_date').show();
            $('#inactive_remark').show();
        
        <?php else: ?>
            $('#inactive_date').hide();
            $('#inactive_remark').hide();
        <?php endif; ?>
        

        $('.datepicker').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            todayHighlight: true
        });

        $('#reges_type').change(function () {
           if ($('#reges_type').val() == 'Yes') {
                $('#gst_in').show();
            } else {
                $('#gst_in').hide();
            }
        });
        $('#is_active').change(function () {
            if ($('#is_active').val() == 1) {
                $('#inactive_date').show();
                $('#inactive_remark').show();
                
            } else {
                $('#inactive_date').hide();
                $('#inactive_remark').hide();
            }
        });
    });

    function RestrictCommaSemicolon(e) {
        var theEvent = e || window.event;
        var key = theEvent.keyCode || theEvent.which;
        key = String.fromCharCode(key);
        var regex = /[^,;]+$/;
        if (!regex.test(key)) {
            theEvent.returnValue = false;
            if (theEvent.preventDefault) {
                theEvent.preventDefault();
            }
        }
    }
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('app.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp_7.4.19\htdocs\web_project\HVL_Mar2024\resources\views/hvl/customermaster/edit.blade.php ENDPATH**/ ?>
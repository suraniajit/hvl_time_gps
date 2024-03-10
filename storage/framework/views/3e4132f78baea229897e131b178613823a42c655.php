<?php $__env->startSection('title','City Management | HVL'); ?>

<?php $__env->startSection('vendor-style'); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="breadcrumb-holder">
        <div class="container-fluid">
            <ul class="breadcrumb">
                
                <li class="breadcrumb-item active"><a href="<?php echo e(route('city.index')); ?>">City Management </a></li>
                <li class="breadcrumb-item ">Add City</li>
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
                                <h2 class="h3 display"> Add City</h2>
                            </div>
                        </div>

                    </header>
                    <form id="formValidate" action="<?php echo e(route('city.store')); ?>" method="post">
                        <?php echo e(csrf_field()); ?>

                        <div class="row">
                            <div class="form-group col-sm-6 col-md-4 ">
                                <label for="">Select Country Name: </label>
                                <input type="hidden" name="country_id" value="1">
                                <select  class="form-control" id="country_id" data-error=".errorTxt1" disabled>
                                    <option  value="1">India</option>
                                </select>
                                <div class="errorTxt1"><?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><?php echo e($message); ?><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></div>
                            </div>
                            <div class="form-group col-sm-6 col-md-4">
                                <label for="">Select State Name <span class="text-danger">*</span> </label>
                                <select name="state_id" class="form-control" id="state_id" data-error=".errorTxt2">
                                    <option value="" disabled=""> Select State</option>
                                    <?php $__currentLoopData = $states; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $state): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option <?php echo e(($state->id == old('state_id'))?'selected':''); ?> value="<?php echo e($state->id); ?>"><?php echo e($state->state_name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <div class="errorTxt2 text-danger"><?php $__errorArgs = ['state_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><?php echo e($message); ?><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></div>
                            </div>
                            <div class=" form-group col-sm-6 col-md-4">
                                <label for="">City Name <span class="text-danger">*</span> </label>
                                <input type="text" name="city_name" value="<?php echo e(old('city_name')); ?>" class="form-control" id="city_name" placeholder="Enter City Name" data-error=".errorTxt3">
                                <div class="errorTxt3 text-danger"><?php $__errorArgs = ['city_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><?php echo e($message); ?><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></div>
                            </div>
                            <div class=" form-group col-sm-6 col-md-4">
                                <label for="">Location<span class="text-danger">*</span> </label>
                                <input type="text" value="<?php echo e(old('location')); ?>"  name="location" class="form-control" id="location" placeholder="Enter City Location" data-error=".errorTxtLocation">
                                <div class="errorTxtLocation text-danger"><?php $__errorArgs = ['location'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><?php echo e($message); ?><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></div>
                            </div>
                            <div class=" form-group col-sm-6 col-md-4">
                                <label for="">Latitude<span class="text-danger">*</span> </label>
                                <input type="text" value="<?php echo e(old('latitude')); ?>"  readonly name="latitude" class="form-control" id="latitude" placeholder="Latitude" data-error=".errorTxtLatitude">
                                <div class="errorTxtLatitude text-danger"><?php $__errorArgs = ['latitude'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><?php echo e($message); ?><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></div>
                            </div>
                            <div class=" form-group col-sm-6 col-md-4">
                                <label for="">Longitude<span class="text-danger">*</span> </label>
                                <input type="text" value="<?php echo e(old('longitude')); ?>" readonly name="longitude" class="form-control" id="longitude" placeholder="Longitude" data-error=".errorTxtLongitude">
                                <div class="errorTxtLongitude text-danger"><?php $__errorArgs = ['longitude'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><?php echo e($message); ?><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></div>
                            </div>
                            <div class="form-group col-sm-6 col-md-4">
                                <label>Select Status <span class="text-danger">*</span></label>
                                <select id="is_active" class="form-control" name="is_active" data-error=".errorTxt4">
                                    <option value="" disabled="">Select Status</option>
                                    <option value="0"  <?php echo e((old('is_active',0)== 0)?'selected':''); ?>>Active</option>
                                    <option value="1" <?php echo e((old('is_active') == 1)?'selected':''); ?>>Inactive</option>
                                </select>
                                <div class="errorTxtStatus text-danger"><?php $__errorArgs = ['is_active'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><?php echo e($message); ?><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></div>
                            </div>
                        </div>
                        <div class="row mt-4 pull-right">
                            <div class="col-sm-12 ">
                                <button class="btn btn-primary mr-2" type="submit" name="action">
                                    <i class="fa fa-save"></i>
                                    Save
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
<script src="<?php echo e(asset('js/hrms/city/create.js')); ?>"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBxKK1ePS2LinpV1r09ctx6rWLP6TLuW0s&callback=initAutocomplete&libraries=places&v=weekly" defer ></script>
<script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
<script>
        let autocomplete;
        let address1Field;
        function initAutocomplete() {
        address1Field = document.querySelector("#location");
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
        $('#latitude').val(place.geometry.location.lat());
        $('#longitude').val(place.geometry.location.lng());
    }
    window.initAutocomplete = initAutocomplete;
    $("#location").keyup(function(){
        $('#latitude').val('');
        $('#longitude').val('');
    });
</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('app.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp_7.4.19\htdocs\web_project\HVL_Mar2024\resources\views/hrms/city/create.blade.php ENDPATH**/ ?>
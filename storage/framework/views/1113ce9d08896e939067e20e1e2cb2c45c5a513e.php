<?php $__env->startSection('title','Customer Management | HVL'); ?>

<?php $__env->startSection('vendor-style'); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="breadcrumb-holder">
        <div class="container-fluid">
            <ul class="breadcrumb">
                
                <li class="breadcrumb-item active"><a href="<?php echo e(route('state.index')); ?>">States </a></li>
                <li class="breadcrumb-item ">Add State</li>
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
                                <h2 class="h3 display"> Add State</h2>
                            </div>
                        </div>

                    </header>
                    <form id="formValidate" action="<?php echo e(route('state.store')); ?>" method="post">
                        <?php echo e(csrf_field()); ?>

                        <div class="row">
                            <div class="form-group col-sm-6 col-md-4">
                                <label for="">Country </label>
                                <input type="hidden" name="country_id" value="1">
                                <select  class="form-control" id="country_id"  disabled>
                                    <option value="1">India</option>
                                </select>
                            </div>

                            <div class="form-group col-sm-6 col-md-4">
                                <label class="">State Name <span class="text-danger">*</span> </label>
                                <input type="text" name="state_name" class="form-control" id="state_name" placeholder="Enter State Name" data-error=".errorTxt2">
                                <div class="errorTxt2 text-danger"></div>
                            </div>


                            <div class="form-group col-sm-6 col-md-4">
                                <label>Select Status <span class="text-danger">*</span></label>
                                <select id="is_active" class="form-control" name="is_active" data-error=".errorTxt3">
                                    <option value="" disabled="">Select Status</option>
                                    <option value="0" selected="">Active</option>
                                    <option value="1">Inactive</option>
                                </select>
                                <div class="errorTxt3 text-danger"></div>
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

    <script src="<?php echo e(asset('js/hrms/state/create.js')); ?>"></script>

<?php $__env->stopSection(); ?>


<?php echo $__env->make('app.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp_7.4.19\htdocs\web_project\HVL_Mar2024\resources\views/hrms/state/create.blade.php ENDPATH**/ ?>
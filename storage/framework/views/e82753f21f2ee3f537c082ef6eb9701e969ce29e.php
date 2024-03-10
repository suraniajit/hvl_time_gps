;


<?php $__env->startSection('title','Dashboard | Asset Management'); ?>
<?php $__env->startSection('css-stack'); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            
            <div class="card-header">
                <div class="row">
                    <div class="col-10">
                        <h5 class="card-title mb-0">Activity Log</h5>        
                    </div>
                    <div class="col-2">
                        <a href="<?php echo e(route('activity.index')); ?>" class="btn btn-primary pull-right rounded-pill">Back To Potal</a>
                    </div>
                </div>
                
            
            </div>
            <div class="card-body">
                <table id="fixed-header" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Date & Time </th>
                            <th>Activity By</th>
                            <th>Module</th>
                            <th>Activity</th>
                            <th>Details</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $logs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($log->id); ?></td>
                            <td><?php echo e($log->created_at); ?></td>
                            <td><?php echo e($log->action_by); ?></td>
                            <td><?php echo e($log->module); ?></td>
                            <td><?php echo e($log->action); ?></td>
                            <td>
                                <a href="<?php echo e(route('system_log detail',[$log->id])); ?>">
                                    <i class="ri-eye-line"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
                <?php echo e($logs->links()); ?>

            </div>
        </div>
    </div>
</div><!--end row-->
<?php $__env->stopSection(); ?>
<?php $__env->startSection('js-stack'); ?>

<?php $__env->stopSection(); ?>



<?php echo $__env->make('new_themes.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp_7.4.19\htdocs\web_project\HVL_Mar2024\resources\views/log/log.blade.php ENDPATH**/ ?>
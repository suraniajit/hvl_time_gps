<?php $__env->startSection('title','Roles | HVL'); ?>
<?php $__env->startSection('content'); ?>
    <div class="breadcrumb-holder">
        <div class="container-fluid">
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo e(url('/')); ?>">Dashboard</a></li>
                <li class="breadcrumb-item active">Role Management      </li>
            </ul>
        </div>
    </div>
    <section>
        <div class="container-fluid">
            <header>
                <div class="row">
                    <div class="col-md-7">
                        <h2 class="h3 display">Role Management</h2>
                    </div>
                    <div class="col-md-5">
                        <a href="<?php echo e(route('role.all_view')); ?>" class="btn btn-primary pull-right rounded-pill mr-2">View All Assign Role</a>

                        <a href="<?php echo e(url('roles/create')); ?>" class="btn btn-primary pull-right rounded-pill mr-2">Add Role</a>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Access Role Bulkupload')): ?>
                            <a href="<?php echo e(route('admin.role_bulkupload.index')); ?>" class="btn btn-primary pull-right rounded-pill mr-2"><i class="fa fa-upload"></i>Upload Roles</a>
                        <?php endif; ?>
                       
                   </div>
                </div>
            </header>

            <div class="card">
                <?php if(session('success')): ?>
                    <div class="alert alert-success alert-dismissible fade show center-block" role="alert">
                        <strong><?php echo Session::get('success'); ?> </strong>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                <?php endif; ?>
                <div class="card-body p-4">

                    <div class="table-responsive">
                        <table id="page-length-option" class="table table-striped table-hover multiselect">
                                <thead>
                                    <tr>
                                        <th>Action</th>
                                        <th>No</th>
                                        <th>Name</th>
                                        <th>Permissions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td width="10%">
                                            <a href="<?php echo e(route('roles.view', $role->id)); ?>?rolname=<?php echo e($role->name); ?>"
                                               class="p-2">
                                                <span class="fa fa-eye"></span>
                                            </a>
                                            <!--                                            <a href="<?php echo e(route('role.assign', ['id'=>$role->id])); ?>"
                                                                                           class=""
                                                                                           data-position="top"
                                                                                           data-tooltip="Employees Assign">
                                                                                            <span class="material-icons left">accessibility</span>
                                                                                        </a>-->
                                            <?php if($role->name !== 'administrator'): ?>
                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Edit Role')): ?>
                                            <a href="<?php echo e(route('roles.edit', $role->id)); ?>"
                                               class="p-2">
                                                <span class="fa fa-edit"></span>
                                            </a>
                                            <?php endif; ?>

                                                <?php if($role->name !== 'employees' && $role->name !== 'department' && $role->name !== 'designation' && $role->name !== 'team'): ?>
                                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Delete Role')): ?>
                                                     <a href="" class="button" data-id="<?php echo e($role->id); ?>"><span class="fa fa-trash"></span></a>
                                                <?php endif; ?>

                                                <?php endif; ?>
                                            <?php endif; ?>


                                        </td>
                                        <td width="1%">
                                            <?php echo e($key+1); ?>

                                        </td>
                                        <td width="10%">
                                            <?php echo e(ucfirst($role->name)); ?>

                                        </td>
                                        <td width="50%">
                                            <?php if($role->name === 'administrator'): ?>
                                            <span class="badge badge-info">All Permissions</span>
                                            <?php else: ?>
                                            <?php $__currentLoopData = $role->permissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $per): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <span class="badge badge-info"><?php echo e($per->name); ?></span>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php endif; ?>
                                        </td>

                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>




<?php $__env->startSection('page-script'); ?>

<script>
$(document).ready(function () {
    $('#page-length-option').DataTable({
        "scrollX": true
    });
});

$(document).ready(function () {
    $(document).on('click', '.button', function (e) {
        e.preventDefault();
        var id = $(this).data("id");
        var token = $("meta[name='csrf-token']").attr("content");
        swal({
                title: "Are you sure you want to delete? ",
                text: "You will not be able to recover this record!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Yes, delete it!",
                closeOnConfirm: false
            },
            function (isConfirm) {
                if (isConfirm) {
                    $.ajax({
                        url: "roles/" + id,
                        type: 'DELETE',
                        data: {
                            "_token": token,
                        },
                        success: function (result) {
                            swal({
                                title: "Record has been deleted!",
                                type: "success",
                            }, function () {
                                location.reload();
                            });
                        }
                    });
                }
            });
    });
});
</script>



<?php $__env->stopSection(); ?>

<?php echo $__env->make('app.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp_7.4.19\htdocs\web_project\HVL_Mar2024\resources\views/role/index.blade.php ENDPATH**/ ?>
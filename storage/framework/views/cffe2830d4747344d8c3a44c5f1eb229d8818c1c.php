<?php $__env->startSection('title','State Management | HVL'); ?>

<?php $__env->startSection('content'); ?>

    <section>
        <div class="container-fluid">
            <header>
                <div class="row">
                    <div class="col-md-7">
                        <h2 class="h3 display">States</h2>
                    </div>
                    <div class="col-md-5">
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Create leads')): ?>
                            <a href="<?php echo e(route('state.create')); ?>" class="btn btn-primary pull-right rounded-pill">Add State</a>
                        <?php endif; ?>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Delete State' )): ?>
                            <a id="mass_delete_id" class="btn btn-primary pull-right rounded-pill mr-2">
                                <i class="fa fa-trash"></i> Mass Delete
                            </a>
                        <?php endif; ?>
                    </div>
                </div>

            </header>

            <!-- Page Length Options -->
            <div class="card">
                <?php if(session('success')): ?>
                    <div class="alert alert-success alert-dismissible fade show center-block" role="alert">
                        <strong><?php echo \Session::get('success'); ?> </strong>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                <?php endif; ?>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="page-length-option" class="table table-striped table-hover multiselect">
                            <thead>
                            <tr>
                                <th class="sorting_disabled" width="4%">
                                    <label>
                                        <input type="checkbox" class="select-all"/>
                                        <span></span>
                                    </label>
                                </th>
                                <th>ID</th>
                                <th>Action</th>
                                
                                <th>State Name</th>
                                <th>Status</th>
                            </tr>
                            </thead>

                            <tbody>
                            <?php $__currentLoopData = $StateDetails; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $Detailes): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td width="2%">
                                        <center><?php echo e(++$key); ?></center>
                                    </td>
                                    <td width="4%">
                                        <label>
                                            <input type="checkbox" data-id="<?php echo e($Detailes->id); ?>"
                                                   name="selected_row"/>
                                            <span></span>
                                        </label>
                                    </td>
                                    <td width="8%">
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Edit State')): ?>
                                            <a href="<?php echo e(route('state.edit', $Detailes->id)); ?>"
                                               class="tooltipped mr-10"
                                               data-position="top"
                                               data-tooltip="Edit">
                                                <span class="fa fa-edit"></span>
                                            </a>
                                        <?php endif; ?>
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Delete State')): ?>
                                            <a href="" class="button" data-id="<?php echo e($Detailes->id); ?>"><span class="fa fa-trash fa-lg"></span></a>
                                        <?php endif; ?>

                                    </td>
                                    
                                    <td><?php echo e($Detailes->state_name); ?></td>
                                    <td>
                                        <?php if ($Detailes->is_active == '0') { ?>
                                        <span class="badge badge-success">active</span>
                                        <?php } else { ?>
                                        <span class="badge badge-danger">Inactive</span>
                                        <?php } ?>
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
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.4/jspdf.min.js"></script>
    <script>
        $(document).ready(function () {
            var checkbox = $('.multiselect tbody tr td input');
            var selectAll = $('.multiselect .select-all');

            checkbox.on('click', function () {
                // console.log($(this).attr("checked"));
                $(this).parent().parent().parent().toggleClass('selected');
            });

            checkbox.on('click', function () {
                // console.log($(this).attr("checked"));
                if ($(this).attr("checked")) {
                    $(this).attr('checked', false);
                } else {
                    $(this).attr('checked', true);
                }
            });


            // Select Every Row

            selectAll.on('click', function () {
                $(this).toggleClass('clicked');
                if (selectAll.hasClass('clicked')) {
                    $('.multiselect tbody tr').addClass('selected');
                } else {
                    $('.multiselect tbody tr').removeClass('selected');
                }

                if ($('.multiselect tbody tr').hasClass('selected')) {
                    checkbox.prop('checked', true);
                } else {
                    checkbox.prop('checked', false);
                }
            });
            // mass delete
            $('#mass_delete_id').click(function () {
                var checkbox_array = [];
                var token = $("meta[name='csrf-token']").attr("content");
                $.each($("input[name='selected_row']:checked"), function () {
                    checkbox_array.push($(this).data("id"));
                });
                // console.log(checkbox_array);
                if (typeof checkbox_array !== 'undefined' && checkbox_array.length > 0) {

                    swal({
                            title: "Are you sure, you want to delete? ",
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
                                    url: '<?php echo e(route('lead.massdelete')); ?>',
                                    type: 'POST',
                                    data: {
                                        "_token": token,
                                        ids: checkbox_array,
                                    },
                                    success: function (result) {
                                        if (result === 'error') {
                                            swal({
                                                title: "State can't be delete as city or customer is assigned!",
                                                type: "warning",
                                            })

                                        } else {
                                            swal({
                                                title: "Record has been deleted!",
                                                type: "success",
                                            }, function () {
                                                location.reload();
                                            });
                                        }
                                    }
                                });
                            }
                        });
                } else {
                    swal({
                        title: "Please Select Atleast One Record",
                        type: 'warning',

                    });
                }

            });
            $(document).on('click', '.button', function (e) {
                e.preventDefault();
                var id = $(this).data("id");

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
                                url: "<?php echo e(route('state.delete')); ?>",
                                type: "get",
                                data: {
                                    "id": id
                                },
                                success: function (result) {
                                    if (result === 'error') {
                                        swal({
                                            title: "State can't be delete as city or customer is assigned!",
                                            type: "warning",
                                        })

                                    } else {
                                        swal({
                                            title: "Record has been deleted!",
                                            type: "success",
                                        }, function () {
                                            location.reload();
                                        });
                                    }
                                }
                            });
                        }
                    });
            });

        });

    </script>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('app.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp_7.4.19\htdocs\web_project\HVL_Mar2024\resources\views/hrms/state/index.blade.php ENDPATH**/ ?>
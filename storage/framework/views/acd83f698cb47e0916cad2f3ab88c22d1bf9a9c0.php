<?php $__env->startSection('title','Dashboard Management '); ?>

<?php $__env->startSection('vendor-style'); ?>
<!--https://codeactually.com/googlecharts.html-->
<style>
    .anychart-credits:{
            display: none;
    }
</style>
 <style type="text/css">
    g[class$='creditgroup'] {
         display:none !important;
    }
</style>
<link href="https://cdn.anychart.com/fonts/2.7.2/anychart.css" rel="stylesheet" type="text/css">

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="card">
        <div class=" p-4">
            <div class="card-body">
                <u><h2 class="h3 display hed">Reports</h2></u>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <a class="btn btn-primary pull-right" data-toggle="collapse" href="#serachFilter" role="button" aria-expanded="false" aria-controls="multiCollapseExample1"><i class="fa fa-search" aria-hidden="true"></i></a>
        </div>
    </div>
    <div class="row">
    <div class="col">
        <div class="collapse multi-collapse" id="serachFilter">
        <div class="card card-body">
                <form action="<?php echo e(route('dashboard.filter')); ?>" method="post">
                    <div class="row ">
                        <div class="col ">
                            <input type="text" name="end_date" class="form-control datepicker" value="<?php echo e($search_end_date); ?>" placeholder="Enter Start Date" autocomplete="off" autofocus="off" >
                        </div>
                        <div class="col">
                            <select class="form-control"  name="day_counter" id="ddl_date">
                                <option value="" disable="" selected>Select Interval</option>
                                <option value="30" <?php if($search_day_counter == '30'): ?> selected <?php endif; ?> >Last 30 days</option>
                                <option value="60" <?php if($search_day_counter == '60'): ?> selected <?php endif; ?> >Last 60 days</option>
                                <option value="90" <?php if($search_day_counter == '90'): ?> selected <?php endif; ?> >Last 90 days</option>
                                <option value="120" <?php if($search_day_counter == '120'): ?> selected <?php endif; ?> >Last 120 days</option>
                                <option value="180" <?php if($search_day_counter == '180'): ?> selected <?php endif; ?> >Last 180 days</option>
                                <option value="360" <?php if($search_day_counter == '360'): ?> selected <?php endif; ?> >Last 360 days</option>
                                <option value="420" <?php if($search_day_counter == '420'): ?> selected <?php endif; ?> >Last 420 days</option>
                            </select>
                        </div>
                        <div class=" col">
                            <button type="submit" class="btn btn-primary">Search</button>
                            <a class="btn btn-primary" href="/dashboard">Reset</a>
                        </div>
                    </div>
                </form>
        </div>
        </div>
    </div>
    </div>
    <!-- start stryal -->
    <div class="row">
        <div class="col-xl-5">
            <div class="card card-height-100">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Lead Source Wise Lead</h4>
                </div>
                <div class="card-body">
                    <div id="source_lead"></div>
                </div>
            </div>
        </div>
        <div class="col-xl-5 col-md-6">
            <div class="card">
                <table class="table">
                    <thead class="thead-dark">
                        <tr>
                            <th>Lead Source</th>
                            <th>Lead count</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $lead_source_wise_data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$lead_source): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>    
                                <td><?php echo e($lead_source['x']); ?></td>
                                <td><?php echo e($lead_source['value']); ?></td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-5">
            <div class="card card-height-100">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Employee Wise Lead</h4>
                </div>
                <div class="card-body">
                    <div id="employee_lead"></div>
                </div>
            </div>
        </div>
        <div class="col-xl-5 col-md-6">
            <div class="card">
                <table class="table">
                        <thead class="thead-dark">
                            <tr>
                            <th>Employee</th>
                            <th>Lead count</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $employee_wise_lead_data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>    
                                <td><?php echo e($employee['x']); ?></td>
                                <td><?php echo e($employee['value']); ?></td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-5">
            <div class="card card-height-100">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Employee Wise Revenue </h4>
                </div>
                <div class="card-body">
                    <div id="employee_wise_revenue"></div>
                </div>
            </div>
        </div>
        <div class="col-xl-5 col-md-6">
            <div class="card">
                <table class="table">
                    <thead class="thead-dark">
                        <tr>
                            <th>Employee</th>
                            <th>Revenue</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $employee_wise_revenue_data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $revenue): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>    
                                <td><?php echo e($revenue['x']); ?></td>
                                <td><?php echo e($revenue['value']); ?></td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
   
</div>


<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-script'); ?>
    <script>
    $(document).ready(function () {
        $(".anychart-credits").each(function(index, element) {
            $(element).remove();
        });
         $('.datepicker').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            todayHighlight: true
        });
    });
    </script>
    <script>
        source_chart =  anychart.pie3d( <?=json_encode($lead_source_wise_data)?>);
        source_chart.innerRadius("50%");
        source_chart.container("source_lead");
        source_chart.draw();        
    </script>
    <script>
        employee_chart =  anychart.pie3d( <?=json_encode($employee_wise_lead_data)?>);
        employee_chart.innerRadius("50%");
        employee_chart.container("employee_lead");
        employee_chart.draw();        
    </script>
    <script>
        employee_revenue_chart =  anychart.pie3d( <?=json_encode($employee_wise_revenue_data)?>);
        employee_revenue_chart.innerRadius("50%");
        employee_revenue_chart.container("employee_wise_revenue");
        employee_revenue_chart.draw();        
    </script>
    
<?php $__env->stopSection(); ?>









<?php echo $__env->make('app.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp_7.4.19\htdocs\web_project\HVL_Mar2024\resources\views/hvl/dashboard/index.blade.php ENDPATH**/ ?>
<?php $__env->startSection('title','Activity Management '); ?>

<?php $__env->startSection('vendor-style'); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="breadcrumb-holder">
        <div class="container-fluid">
            <ul class="breadcrumb">
                <li class="breadcrumb-item active"><a href="<?php echo e(route('activity.index')); ?>">Activity Management </a></li>
                <li class="breadcrumb-item ">Update Activity</li>
            </ul>
        </div>
    </div>
    <section>
        <div class="container-fluid">
            <div class="card">
                <?php if(session('success')): ?>
                <div class="alert alert-success alert-dismissible fade show center-block" role="alert">
                    <strong><?php echo Session::get('success'); ?> </strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <?php endif; ?>
                <?php if($errors->any()): ?>
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="alert alert-danger alert-dismissible fade show center-block" role="alert">
                        <strong><?php echo e($error); ?></strong>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
                <div class="card-body p-4">            
                    <header>
                        <div class="row">
                            <div class="col-md-7">
                                <h2 class="h3 display"> Update Activity : <?php echo e($customer_activity->customer_id); ?> </h2>
                                <p style="font-size: 12px;"><strong>Note:</strong> Comma is not allowed in any field.</p>
                            </div>
                        </div>
                    </header>
                    <form action="<?php echo e(route('activity.update_activity',['id'=>$customer_activity->id])); ?>" method="post" id="Candidate_Edit_Form" enctype="multipart/form-data">
                        <input type="hidden" id="customer_id" name="customer_id" value="<?php echo e($customer_activity->customer_id); ?>">
                        <?php echo e(csrf_field()); ?>

                        <div class="row">
                            <div class="form-group col-sm-6 col-md-4">
                                <label> Subject * </label>
                                <input type="text" name="subject" class="form-control " onkeypress="return RestrictCommaSemicolon(event);" ondrop="return false;" onpaste="return false;" data-error=".errorTxt12" value="<?php echo e($customer_activity->subject); ?>" required="" >
                                <div class="errorTxt12 text-danger">
                                </div>
                            </div>
                            <?php
                            $helper = new Helper(); 
                            $super_admin = $helper->getSuperAdmin();

                            ?>
                            <?php   date_default_timezone_set("Asia/Kolkata"); ?>
                            <?php  $desable = 
                            (Auth::user()->email!=$super_admin && (!Auth::user()->hasRole('Coordinator')))
                                ?
                                (in_array(date('d') , Config::get('app.edit_start_end_date_date_enable_activity')))
                                    ?
                                    (date('m',strtotime($customer_activity->start_date))== date('m') )
                                        ?
                                            ''
                                        :
                                           'disabled' 
                                    :'disabled'
                                : 
                                ''
                            ;

                             ?>
                            <div class="form-group col-sm-6 col-md-4">
                                <label>Start Date <span class="text-danger">*</span> </label>
                                    <input type="text" <?php echo e($desable); ?>  class="datepicker form-control" data-error=".errorTxt1"  name="txt_start_date" autocomplete="off" autofocus="off" value="<?php echo e($customer_activity->start_date); ?>" required>
                                <div class="errorTxt1 text-danger"></div>
                            </div>
                            <div class="form-group col-sm-6 col-md-4">
                                <label> End Date <span class="text-danger">*</span> </label>
                                <input type="text" <?php echo e($desable); ?>  class="datepicker form-control" data-error=".errorTxt2"  name="txt_end_date" autocomplete="off" autofocus="off" value="<?php echo e($customer_activity->end_date); ?>" required>
                                <div class="errorTxt2 text-danger"></div>
                            </div>
                            <div class="form-group col-sm-6 col-md-4">
                                <label>Start Time <span class="text-danger">*</span> </label>
                                <input type="time" name="txt_start_time" required class="form-control " data-error=".errorTxtStartTime" placeholder="Enter Start Time" autocomplete="off" autofocus="off" value="<?php echo e($customer_activity->start_time); ?>">
                                <div class="errorTxtStartTime text-danger"></div>
                            </div>
                            <div class="form-group col-sm-6 col-md-4">
                                <label> End Time <span class="text-danger">*</span> </label>
                                <input type="time" name="txt_end_time" required class="form-control" data-error=".errorTxtEndTime" placeholder="Enter Date Date" autocomplete="off" autofocus="off" value="<?php echo e($customer_activity->end_time); ?>"">
                                <div class="errorTxtEndTime text-danger" ></div>
                            </div>

                            <?php if(auth()->check() && auth()->user()->hasRole('customers_admin')): ?>
                            <?php else: ?>
                                <?php if(auth()->check() && auth()->user()->hasRole('Operators')): ?>
                                <?php else: ?>  
                                <div class="form-group col-sm-6 col-md-4">
                                        <label>Per Service Value <span class="text-danger">*</span> </label>
                                        <input type="text" name="services_value" required class="form-control" data-error=".errorTxtServiceValue" placeholder="Enter Service value" value="<?php echo e($customer_activity->services_value); ?>" autocomplete="off" autofocus="off">
                                        <div class="errorTxtServiceValue text-danger" ></div>
                                </div>
                                <?php endif; ?>
                            <?php endif; ?>
                            <div class="form-group col-sm-6 col-md-4">
                                <label for="fn">Type <span class="text-danger">*</span></label>
                                <select class="form-control " data-error=".errorTxt3" name="ddl_type" id="ddl_type" required>
                                    <?php $__currentLoopData = $types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($type->id); ?>" <?php if($type->id == $customer_activity->type): ?> selected <?php endif; ?>><?php echo e($type->Name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <div class="errorTxt3 text-danger"></div>
                            </div>
                            <div class="form-group col-sm-6 col-md-4">
                                <label >Status <span class="text-danger">*</span></label>
                                <select class="form-control" data-error=".errorTxt4" name="ddl_status" id="ddl_status" required>
                                    <?php $__currentLoopData = $statuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($status->id); ?>" <?php if($status->id == $customer_activity->status): ?> selected <?php endif; ?>><?php echo e($status->Name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <div class="errorTxt4 text-danger"></div>
                            </div>
                            <div class="form-group col-sm-6 col-md-4">
                                <label for="fn">Select frequency <span class="text-danger">*</span></label>
                                <input type="hidden" class="form-control" name="ddl_frequency" value="<?php echo e($customer_activity->frequency); ?>">
                                <input type="text" class="form-control" readonly value="<?php echo e(ucfirst($customer_activity->frequency)); ?>">
                                <div class="errorTxt5 text-danger"></div>
                            </div>
                            <div class="form-group col-sm-6 col-md-4">
                                <label for="fn">Created By</label>
                                <input type="text" class="form-control " onkeypress="return RestrictCommaSemicolon(event);" ondrop="return false;" onpaste="return false;" data-error=".errorTxt6" value="<?php echo e($customer_activity->created_by); ?>" name="created_by">
                                <div class="errorTxt6 text-danger"></div>
                            </div>
                            <div class="form-group col-sm-6 col-md-4">
                                <label> Actual Completion Date </label>
                                <input type="text" name="complete_date"  class="form-control datepicker" data-error=".errorTxt8" value="<?php echo e($customer_activity->complete_date); ?>">
                                <div class="errorTxt8 text-danger"></div>
                            </div>
                            <div class="form-group col-sm-6 col-md-4">
                                <label>Remark </label>
                                <input type="text" name="txt_remark" id="txt_remark" class="form-control" placeholder="Enter Remark" autocomplete="off" autofocus="off" value="<?php echo e($customer_activity->remark); ?>">
                            </div>
                        </div>
                        <hr style="border: 1px solid red">
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Access Job Cards')): ?>
                            <div class="row">
                                <div class="col-sm-12 col-md-6">
                                    <h3>Job Cards</h3>
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Create Job Cards')): ?>
                                            <button type="button" class="btn btn-primary rounded p-1" data-toggle="modal" data-target="#modal">
                                                <span class="fa fa-upload"></span>Add Job Card
                                            </button>
                                        <?php endif; ?>
                                        <?php
                                            $date = \Illuminate\Support\Facades\DB::table('hvl_job_cards')
                                                    ->where('activity_id',$customer_activity->id)
                                                    ->orderBy('id','DESC')
                                                    ->value('added');
                                        ?>
                                    <?php if(!empty($date)): ?>
                                        <span class="pull-right badge badge-primary p-2"><?php echo e($date); ?></span><h4 class="pull-right badge badge-primary p-2"> Job Card Update Date :</h4>
                                    <?php endif; ?>
                                </div>
                                <div class="col-sm-12 col-md-12">
                                    <div class="row">
                                        <?php $__currentLoopData = $jobcards; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $jobcard): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php if(!empty($jobcard->before_pic)): ?>
                                                <div class="col-sm-6 col-md-2 m-2">
                                                    <label>Before Image</label>
                                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Delete Job Cards')): ?>
                                                        <a href="" class="button pull-right" data-id="<?php echo e($jobcard->id); ?>"><span class="fa fa-close fa-lg "></span></a>
                                                    <?php endif; ?>
                                                        <a href="<?php echo e($helper->getGoogleDriveImage($jobcard->before_pic)); ?>">
                                                            <img height="150" width="150" src="<?php echo e($helper->getGoogleDriveImage($jobcard->before_pic)); ?>">
                                                            <?php echo e($jobcard->before_pic); ?>

                                                        </a>
                                                    <br>
                                                </div>
                                            <?php endif; ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                </div>
                                <br>
                                <div class="col-sm-12 col-md-12">
                                    <div class="row">
                                        <?php $__currentLoopData = $jobcards; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $jobcard): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php if(!empty($jobcard->after_pic)): ?>
                                                <div class="col-sm-6 col-md-2 m-2">
                                                    <label>After Image</label>
                                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Delete Job Cards')): ?>
                                                        <a href="" class="button pull-right" data-id="<?php echo e($jobcard->id); ?>"><span class="fa fa-close fa-lg "></span></a>
                                                    <?php endif; ?>
                                                        <img height="150" width="150" src="<?php echo e($helper->getGoogleDriveImage($jobcard->after_pic)); ?>">
                                                        <?php echo e($jobcard->after_pic); ?>

                                                    <br>
                                                </div>
                                            <?php endif; ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div> 
                                </div>
                            </div>
                        <?php endif; ?>
                        <hr style="border: 1px solid red;">
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Access Audit Report')): ?>
                            <div class="row">
                                <div class="col-sm-12 col-md-6">
                                    <h3>Audit Reports</h3>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Create Audit Report')): ?>
                                        <button type="button" class="btn btn-primary rounded p-1" data-toggle="modal" data-target="#modal_report">
                                            <span class="fa fa-upload"></span>Audit Report
                                        </button>
                                    <?php endif; ?>
                                    <?php
                                        $date = \Illuminate\Support\Facades\DB::table('hvl_audit_reports')
                                                ->where('activity_id',$customer_activity->id)
                                                ->orderBy('id','DESC')
                                                ->value('added');

                                    ?>
                                    <?php if(!empty($date)): ?>
                                        <span class="pull-right badge badge-primary p-2"><?php echo e($date); ?></span><h4 class="pull-right badge badge-primary p-2"> Audit Report Update Date :</h4>
                                    <?php endif; ?>
                                </div>
                                <div class="col-sm-12 col-md-12">
                                    <div class="row">
                                        <?php if(count($audit_report) > 0): ?> 
                                            <?php if(!empty($audit_report)): ?> 
                                                
                                                <?php $__currentLoopData = $audit_report; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $report): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    
                                                    <?php if($report->type == 'pdf'): ?>
                                                        <div class="col-sm-6 col-md-3 mt-4">
                                                            <a href="<?php echo e($helper->getGoogleDriveImage($report->report)); ?>" target="_blank">
                                                                <img height="100" width="90" src="<?php echo e(asset('public/uploads/pdf-icon.png')); ?>"><br>
                                                                    <?php echo e(ltrim(substr($report->report, strpos($report->report, "_")), '_')); ?>

                                                            </a>
                                                        </div>
                                                    <?php endif; ?>
                                                    <?php if($report->type == 'xls' or $report->type == 'xlsx' or $report->type == 'csv'): ?> 
                                                        <div class="col-sm-6 col-md-3 mt-4">
                                                            <a href=" <?php echo e($helper->getGoogleDriveImage($report->report)); ?>" target="_blank">
                                                                <img height="110" width="120" src="<?php echo e(asset('public/uploads/excel-logo.png')); ?>"><br>
                                                                <?php echo e(ltrim(substr($report->report, strpos($report->report, "_")), '_')); ?>

                                                            </a>
                                                        </div>
                                                    <?php endif; ?>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-sm-6 col-md-6">
                                    <lable>Branch</lable>
                                    <input type="text" disabled  name="branch_name" id="branch_name" class="form-control-file">
                                </div>
                            </div>
                            <b>Customer Details</b>
                            <hr>
                            <div class="row">
                                <div class="form-group col-sm-6 col-md-6">
                                    <lable>Site Name</lable>
                                    <input type="text" disabled name="site_name" id="site_name"  class="form-control-file">
                                </div>
                                <div class="form-group col-sm-6 col-md-6">
                                    <lable>Shipping Address</lable>
                                    <textarea  disabled id="shipping_address"  class="form-control-file"></textarea>
                                </div>
                            </div>

                    <div class="row">
                        <div class="form-group col-sm-6 col-md-6">
                            <lable>Contact Person</lable>
                            <input type="text" disabled name="contact_person" id="contact_person" class="form-control-file">
                        </div>
                        <div class="form-group col-sm-6 col-md-6">
                            <lable>Contact no</lable>
                            <input type="text" disabled name="contact_mobile" id="contact_mobile"  class="form-control-file">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-6 col-md-6">
                            <lable>Mail</lable>
                            <input type="mail" disabled name="mail" id="mail"  class="form-control-file">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-6 col-md-6">
                            <lable>Service Detail</lable>
                            <textarea name="service_spacification" id="service_spacification"  class="form-control-file"></textarea>
                        </div>
                        <div class="form-group col-sm-3 col-md-3">
                            <lable>In</lable>
                            <input type="time" name="in_time" id="in_time" disabled class="form-control-file">
                        </div>
                        <div class="form-group col-sm-3 col-md-3">
                            <lable>Out</lable>
                            <input type="time" name="out_time" id="out_time" disabled class="form-control-file">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-6 col-md-6">
                            <b>Technican Detail</b>
                            <hr>
                            <div class="row">
                                <div class="form-group col-sm-4 col-md-4">
                                    <lable>Name</lable>
                                </div>
                                <div class="form-group col-sm-8 col-md-8">
                                    <input type="text" name="technican_name" id="technican_name" class="form-control-file">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-sm-4 col-md-4">
                                    <lable>sign</lable>
                                </div>
                                <div class="form-group col-sm-8 col-md-8">
                                    <img src="" id="technican_sign_image" width="100">
                                </div>
                            </div>            
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-6 col-md-6">
                            <b>Client</b>
                            <hr>
                            <div class="row">
                                <div class="form-group col-sm-4 col-md-4">
                                    <lable>Client Name</lable>
                                </div>
                                <div class="form-group col-sm-8 col-md-8">
                                    <input type="text" name="technican_name" id="client_name" class="form-control-file">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-sm-4 col-md-4">
                                    <lable>Client Mobile</lable>
                                </div>
                                <div class="form-group col-sm-8 col-md-8">
                                    <input type="text" name="client_mobile" id="client_mobile" class="form-control-file">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-sm-4 col-md-4">
                                    <lable>sign</lable>
                                </div>
                                <div class="form-group col-sm-8 col-md-8">
                                    <img src="" id="client_sign_image" width="100">
                                </div>
                            </div>
                            <input type="hidden" name="user_type" id="user_type" class="form-control-file" >
                        </div>
                    </div>
                        <!-- ajit -->
                    <?php endif; ?>
                <div class="row mt-4 pull-right">
                    <div class="col-sm-12 ">
                        <button class="btn btn-primary mr-2" type="submit" name="action">
                            <i class="fa fa-arrow-circle-up"></i>
                            Update
                        </button>
                        <button type="reset" class="btn btn-secondary  mb-1">
                            <i class="fa fa-arrow-circle-left"></i>
                            <a href="" class="text-white" onclick="closeWin();">Cancel</a>
                        </button>
                    </div>
                </div>
              
                
        </form>
    </div>
</div>
        </div>
    </section>
    
    <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4>Add Job Cards</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" action="<?php echo e(route('activity.addbefore_pic')); ?>" enctype="multipart/form-data">
                        <input type="hidden" name="activity_id" value="<?php echo e($customer_activity->id); ?>">
                        <div class="form-group">
                            <lable>Before Image</lable>
                            <input type="file" name="before_pic[]" id="before_file" accept=".jpg, .png, .jpeg" required class="form-control-file" multiple>
                            <p class="text-danger">Max File Size:<strong> 3MB</strong><br>Supported Format: <strong>.jpg .png .jpeg</strong></p>
                        </div>
                        <br>
                        <div class="form-group">
                            <lable>After Image</lable>
                            <input type="file" name="after_pic[]" id="after_file" accept=".jpg, .png, .jpeg" class="form-control-file" multiple>
                            <p class="text-danger">Max File Size:<strong> 3MB</strong><br>Supported Format: <strong>.jpg .png .jpeg</strong></p>
                        </div>

                        <div class="form-group">
                            <input type="submit" class="btn btn-success rounded" value="Upload">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    

    
    <div class="modal fade" id="modal_report" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">--}}
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4>Add Audit Report</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" action="<?php echo e(route('activity.auditreport')); ?>" enctype="multipart/form-data">
                        <input type="hidden" name="activity_id" value="<?php echo e($customer_activity->id); ?>">
                        <div class="form-group">
                            <lable>Report File (only pdf and excel)</lable>
                            <input type="file" name="audit_report" id="audit_file" required class="form-control-file" accept=".pdf, .xls, .xlsx, .csv">
                            <p class="text-danger">Max File Size:<strong> 5MB</strong><br>Supported Format: <strong>.pdf, .xls, .xlsx, .csv</strong></p>
                            <br>
                            <input type="submit" class="btn btn-success rounded" value="Upload">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    
    <div id="email_div" tabindex="-1" role="dialog" aria-hidden="true" class="modal fade text-left">
        <div role="document" class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Send Mail</h4>
                    <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body p-4 row">
                    <div class="col-sm-12">
                        <form action="<?php echo e(route('mail.sendaudit')); ?>" method="post" enctype="multipart/form-data">
                            <?php echo csrf_field(); ?>
                            <input type="hidden" name="customer" value="<?php echo e($customer_activity->customer_id); ?>">
                            <input type="hidden" name="act_id" value="<?php echo e($customer_activity->id); ?>">
                            <div class="row">
                                <div class="form-group">
                                    <label for="">To</label>
                                    <input type="email" class="form-control" name="to" required>
                                </div>
                                <div class="form-group">
                                    <label for="">Subject</label>
                                    <input type="text" class="form-control" name="subject" value="" required>
                                </div>
                                <div class="form-group">
                                    <label for="">Body</label>
                                    <textarea class="form-control" name="body">Start Date : <?php echo e($customer_activity->start_date); ?> End Date : <?php echo e($customer_activity->end_date); ?>     Customer : <?php echo e($customer_activity->customer_id); ?></textarea>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('vendor-script'); ?>
    <script src="<?php echo e(asset('js/ajax/jquery.min.js')); ?>"></script>
    <script src="<?php echo e(asset('js/ajax/angular.min.js')); ?>"></script>
    <script src="<?php echo e(asset('js/materialize.js')); ?>"></script>
    <script src="<?php echo e(asset('js/ajax/jquery.validate.min.js')); ?>"></script>
    <script src="<?php echo e(asset('vendors/select2/select2.full.min.js')); ?>"></script>
    <script src="<?php echo e(asset('js/scripts/form-select2.js')); ?>"></script>
    <script src="<?php echo e(asset('vendors/dropify/js/dropify.min.js')); ?>"></script>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-script'); ?>


<?php $__env->startSection('page-script'); ?>
<script>
        $( document ).ready(function() {
            $('.datepicker').datepicker({
                format: 'yyyy-mm-dd',
                autoclose: true,
                todayHighlight: true
            });
            $("#Candidate_Edit_Form").validate({
                rules: {
                    txt_start_date: {
                        required: true,
                    },
                    txt_end_date: {
                        required: true,
                    },
                    services_value:{
                        required: true,
                        number: true
                    }
                },
                messages: {
                    txt_start_date: {
                        required: "Please Select Start Date",
                    },
                    txt_end_date: {
                        required: "Please Select End Date",
                    },
                    service_value:{
                        required: "Pelase Enter service value",
                        
                    }
                },
                errorElement: 'div',
                errorPlacement: function (error, element) {
                    var placement = $(element).data('error');
                    if (placement) {
                        $(placement).append(error)
                    } else {
                        error.insertAfter(element);
                    }
                }
            });
        })
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
    <script>
        $(document).ready(function () {
            getdata();
            $(document).on('click', '.button', function (e) {
                e.preventDefault();
                var id = $(this).data("id");
                var name = $(this).data("name");
                

                swal({
                        title: "Are you sure? ",
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
                                url: "<?php echo e(route('activity.image_delete')); ?>",
                                type: "get",
                                data: {
                                    "id": id,
                                    "name":name
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

        var uploadbefore = document.getElementById("before_file");
        var uploadafter = document.getElementById("after_file");
        var uploadaudit = document.getElementById("audit_file");

        uploadbefore.onchange = function() {
            if(this.files[0].size > 3145728){
                alert("File is too big!");
                this.value = "";
            };
        };
        uploadafter.onchange = function() {
            if(this.files[0].size > 3145728){
                alert("File is too big!");
                this.value = "";
            };
        };
        uploadaudit.onchange = function() {
            if(this.files[0].size > 5242880){
                alert("File is too big!");
                this.value = "";
            };
        };
        function closeWin() { 
     window.top.close();
}
    </script>
    <script>
    function getdata(){
        $.ajax({
            url: "/activity-master/service_report_default_infomation/"+ <?php echo e($customer_activity->id); ?>,
            type: 'get',
            success: function(response){
                $('#branch_name').val(response.data['name']);
                $('#site_name').val(response.data['customer_name']);
                $('#site_address').val(response.data['billing_address']);
                $('#contact_person').val(response.data['contact_person']);
                $('#contact_mobile').val(response.data['contact_person_phone']);
                $('#mail').val(response.data['billing_email']);
                $('#shipping_address').val(response.data['shipping_address']);
            }
        });
        $.ajax({
            url: "/activity-master/service_report/"+ <?php echo e($customer_activity->id); ?>,
            type: 'get',
            success: function(response){
                console.log("save data");
                console.log(response);
                
                if(response.data.service_spacification != ''){
                    $('#service_spacification').val(response.data.service_spacification);
                }
                if(response.data.in_time != ''){
                    $('#in_time').val(response.data.in_time);
                }
                if(response.data.out_time != ''){
                    $('#out_time').val(response.data.out_time);
                }
                if(response.data.technican_name != ''){
                    $('#technican_name').val(response.data.technican_name);
                }
                if(response.data.technican_sign_image != ''){
                    $('#technican_sign_image').attr('src',response.data.technican_sign_image);
                    $('#technican_sign_image').show();
               }else{
                    $('#technican_sign_image').hide();
                }
                if(response.data.client_sign_image != ''){
                    $('#client_sign_image').attr('src',response.data.client_sign_image);
                    $('#client_sign_image').show();
                }else{
                    $('#client_sign_image').hide();
                }
                if(response.data.technican_name != ''){
                    $('#client_name').val(response.data.client_name);
                }
                if(response.data.client_mobile != ''){
                    $('#client_mobile').val(response.data.client_mobile);
                }
            }
        });
    }
</script>
<?php $__env->stopSection(); ?>
    
<?php $__env->stopSection(); ?>


<?php echo $__env->make('app.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp_7.4.19\htdocs\web_project\HVL_Mar2024\resources\views/hvl/activitymaster/activity_edit.blade.php ENDPATH**/ ?>
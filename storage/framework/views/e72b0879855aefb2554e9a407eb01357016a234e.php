<?php

use App\Module;use Illuminate\Support\Facades\DB;

$user = auth()->user();
// $user_profile = DB::table('users')->where('id','=','1')->get();
$helper = new Helper(); 
$super_admin = $helper->getSuperAdmin();

$user_role_name = App\Http\Controllers\UserProfileController::find_user_role($user['id']);


$modules = Module::orderBy('name')->get();
?>

<nav class="side-navbar">
    <div class="side-navbar-wrapper">
        <!-- Sidebar Header    -->
        <div class="sidenav-header d-flex align-items-center justify-content-center">
            <!-- User Info-->
             <?php if($user->email == $super_admin || $user->email == 'probsoltechnology@gmail.com'): ?>
           <a href="<?php echo e(route('admin-profile-page')); ?>">
                <div class="sidenav-header-inner text-center"><img src="<?php echo $profile_image; ?>" alt="person" class="img-fluid rounded-circle">
                    <h2 class="h5"><?php echo e(ucfirst($user_role_name[0]->usersname)); ?></h2><span class="text-black"><?php echo e(ucfirst($user_role_name[0]->user_role)); ?> <?php //echo $user['id']; ?></span>
                </div>
            </a>
            <?php else: ?>
            <a href="<?php echo e(url('/')); ?>">
                <div class="sidenav-header-inner text-center"><img src="<?php echo e(asset('img/user-icon.png')); ?>" alt="person" class="img-fluid rounded-circle">
                    <h2 class="h5"><?php echo e($user->name); ?></h2><span class="text-white"><?php echo e(ucfirst($user_role_name[0]->user_role)); ?></span>
                </div>
            </a>  
            <?php endif; ?>
            <div class="sidenav-header-logo">
                <?php if($user->email == $super_admin || $user->email == 'probsoltechnology@gmail.com'): ?>
                    <a href="<?php echo e(route('admin-profile-page')); ?>" class="brand-small text-center"> 
                        <strong class="text-primary">
                                <?php echo e(strtoupper(env('APP_NAME'))); ?>

                        </strong>
                    </a>
                <?php else: ?>
                    <a href="<?php echo e(url('/')); ?>" class="brand-small text-center"> 
                        <strong class="text-primary">
                            <?php echo e(strtoupper(env('APP_NAME'))); ?>

                        </strong>
                    </a>
                <?php endif; ?>
            </div>
        </div>
        <div class="main-menu">
            <ul id="side-main-menu" class="side-menu list-unstyled">
                        <?php if($user->email == $super_admin || $user->email == 'probsoltechnology@gmail.com'): ?>
                            <li class="">
                                <a href="/dashboard" class=" ">

                                    <span>Dashboard</span>
                                </a>
                            </li>
                        <?php endif; ?>
                         <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Access Customer Dashboad')): ?>
                          <li class="<?php echo e(Request::routeIs('customer.dashboad.index') ? 'active' : ''); ?>">
                                <a href="<?php echo e(route('customer.dashboad.index')); ?>" class=" ">
                                    <span>Customer Dashboard</span>
                                </a>
                            </li>
                        <?php endif; ?>
                          <?php if($user->email == $super_admin || $user->email == 'probsoltechnology@gmail.com'): ?>
                      
                         <li class="<?php echo e(Request::routeIs('system_log view') ? 'active' : ''); ?>">
                                <a href="<?php echo e(route('system_log view')); ?>" class=" ">
                                    <span>System Logs</span>
                                </a>
                            </li>
                        <?php endif; ?>  
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Access Activity')): ?>
                        <li class=" " text='Reports'>
                            <a href="#exampledropdownDropdown1" aria-expanded="false" data-toggle="collapse">
                                Activity Management </a>
                            <ul id="exampledropdownDropdown1" class="collapse list-unstyled <?php echo e(Request::routeIs('activity.index') ? 'show' : ''); ?> <?php echo e(request()->is('modules/module/activitystatus') ? 'show' : ""); ?> <?php echo e(request()->is('modules/module/activitytype') ? 'show' : ""); ?> ">
                                <li class="<?php echo e(Request::routeIs('activity.index') ? 'active' : ''); ?>">
                                    <a href="<?php echo e(route('activity.index')); ?>" class=" ">

                                        <span>Activities</span>
                                    </a>
                                </li>

                                <?php $__currentLoopData = $modules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $module): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if($module->name == 'activitystatus'): ?>
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Access '.$module->name)): ?>

                                            <li class="<?php echo e(request()->is('modules/module/'.$module->name) ? 'active' : ""); ?>">
                                                <a href="/modules/module/<?php echo e($module->name); ?>">

                                                    <span>Activity Status</span>
                                                </a>
                                            <li>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                    <?php if($module->name == 'activitytype'): ?>
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Access '.$module->name)): ?>
                                            <li class="<?php echo e((request()->is('modules/module/'.$module->name)) ? 'active' : ''); ?>">
                                                <a href="/modules/module/<?php echo e($module->name); ?>">
                                                    <span>Activity Type</span>
                                                </a>
                                            <li>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </li>
                    <?php endif; ?>
                    <!-- by surani -->
                        <?php
                            $audit_index = false; 
                            $audit_dashboard = false;
                        ?>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('index audit')): ?>
                        <!-- aa -->
                            <?php 
                                $audit_index = true;
                            ?> 
                        <?php endif; ?>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('audit dashboard')): ?>
                           <!-- bb -->
                            <?php 
                                $audit_dashboard = true;
                            ?> 
                        <?php endif; ?>
                        
                        <?php if($audit_index == true || $audit_dashboard == true): ?>
                        <li class=" " text='Reports'>
                            <a href="#audit_management_section" aria-expanded="false" data-toggle="collapse">
                                Audit Management 
                            </a>
                            <ul id="audit_management_section" class="collapse list-unstyled <?php echo e(Request::routeIs('admin.audit.index') ? 'show' : ''); ?> <?php echo e(Request::routeIs('admin.audit.dashboard') ? 'show' : ''); ?> ">
                                <?php if($audit_index): ?>
                                <li class="<?php echo e(Request::routeIs('admin.audit.index') ? 'active' : ''); ?>">
                                    <a href="<?php echo e(route('admin.audit.index')); ?>" class=" ">
                                        <span>Audit List</span>
                                    </a>
                                </li>
                                <?php endif; ?>
                                <?php if($audit_dashboard): ?>
                                <li class="<?php echo e(Request::routeIs('admin.audit.dashboard') ? 'active' : ''); ?>">
                                    <a href="<?php echo e(route('admin.audit.dashboard')); ?>" class=" ">
                                        <span>Audit Dashboard</span>
                                    </a>
                                </li>
                                <?php endif; ?>
                            </ul>
                        </li>
                        <?php endif; ?>
                    <!-- end surani -->

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Access Customer')): ?>
                    <li class=" " text='Reports'>
                        <a href="#exampledropdownDropdown2" aria-expanded="false" data-toggle="collapse">
                            Customer Management </a>
                        <ul id="exampledropdownDropdown2" class="collapse list-unstyled <?php echo e(Request::routeIs('customer.index') ? 'show' : ''); ?> <?php echo e(Request::routeIs('delete-customer') ? 'show' : ''); ?> <?php echo e(request()->is('modules/module/Branch') ? 'show' : ""); ?> <?php echo e(request()->is('modules/module/Zones') ? 'show' : ""); ?> <?php echo e(Request::routeIs('branch-customer') ? 'show' : ""); ?>">

                            <?php $__currentLoopData = $modules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $module): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($module->name == 'Branch'): ?>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Access '.$module->name)): ?>
                                        <li class="<?php echo e((request()->is('modules/module/'.$module->name)) ? 'active' : ''); ?>">
                                            <a href="/modules/module/<?php echo e($module->name); ?>">

                                                <span>Branch Management </span>
                                            </a>
                                        <li>
                                    <?php endif; ?>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Access Branch Wise Customer')): ?>
                            <li class="<?php echo e(Request::routeIs('branch-customer') ? 'active' : ''); ?>">
                                <a href="<?php echo e(route('branch-customer')); ?>" class=" ">

                                    <span>Zone wise Customer</span>
                                </a>
                            </li>
                                <?php endif; ?>
                                <li class="<?php echo e(Request::routeIs('customer.index') ? 'active' : ''); ?>">
                                    <a href="<?php echo e(route('customer.index')); ?>" class=" ">

                                        <span>Customers</span>
                                    </a>
                                </li>
                                <?php $__currentLoopData = $modules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $module): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if($module->name == 'Zones'): ?>
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Access '.$module->name)): ?>
                                            <li class="<?php echo e((request()->is('modules/module/'.$module->name)) ? 'active' : ''); ?>">
                                                <a href="/modules/module/<?php echo e($module->name); ?>">

                                                    <span>Zone Management </span>
                                                </a>
                                            <li>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>

                    </li>

                <?php endif; ?>


                <li class=" " text='Employee Management'>
                    <?php if(Gate::check('Access City') || Gate::check('Access departments') || Gate::check('Access designations') || Gate::check('Access employees') || Gate::check('Access State') || Gate::check('Access Teams') || Gate::check('Access User') ): ?>
                    <a href="#exampledropdownDropdown3" aria-expanded="false" data-toggle="collapse">
                        Employee Management</a>
                    <?php endif; ?>
                    <ul id="exampledropdownDropdown3" class="collapse list-unstyled <?php echo e(Request::routeIs('city.index') ? 'show' : ''); ?><?php echo e(Request::routeIs('state.index') ? 'show' : ''); ?> <?php echo e(request()->is('modules/module/departments') ? 'show' : ""); ?> <?php echo e(request()->is('modules/module/employees') ? 'show' : ""); ?><?php echo e(request()->is('modules/module/designations') ? 'show' : ""); ?><?php echo e(request()->is('users') ? 'show' : ""); ?><?php echo e(request()->is('modules/module/teams') ? 'show' : ""); ?> ">
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Access City')): ?>
                            <li class="<?php echo e(Request::routeIs('city.index') ? 'active' : ''); ?>">
                                <a href="<?php echo e(route('city.index')); ?>" class=" ">
                                    <span>City Management</span>
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php $__currentLoopData = $modules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $module): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if($module->name == 'departments'): ?>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Access '.$module->name)): ?>
                                        <li class="<?php echo e((request()->is('modules/module/'.$module->name)) ? 'active' : ''); ?>">
                                        <a href="/modules/module/<?php echo e($module->name); ?>">

                                            <span><?php echo e(ucfirst($module->name)); ?></span>
                                        </a>
                                    <li>
                                <?php endif; ?>
                            <?php endif; ?>
                            <?php if($module->name == 'designations'): ?>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Access '.$module->name)): ?>
                                        <li class="<?php echo e((request()->is('modules/module/'.$module->name)) ? 'active' : ''); ?>">
                                        <a href="/modules/module/<?php echo e($module->name); ?>">

                                            <span><?php echo e(ucfirst($module->name)); ?></span>
                                        </a>
                                    <li>
                                <?php endif; ?>
                            <?php endif; ?>
                            <?php if($module->name == 'employees'): ?>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Access '.$module->name)): ?>
                                    <li class="<?php echo e((request()->is('modules/module/'.$module->name)) ? 'active' : ''); ?>">
                                        <a href="/modules/module/<?php echo e($module->name); ?>">

                                            <span><?php echo e(ucfirst($module->name)); ?></span>
                                        </a>
                                    <li>
                                <?php endif; ?>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Access State')): ?>
                            <li class="<?php echo e(Request::routeIs('state.index') ? 'active' : ''); ?>">
                                <a href="<?php echo e(route('state.index')); ?>" class=" ">

                                    <span>State Management</span>
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php $__currentLoopData = $modules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $module): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if($module->name == 'teams'): ?>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Access '.$module->name)): ?>
                                        <li class="<?php echo e((request()->is('modules/module/'.$module->name)) ? 'active' : ''); ?>">
                                        <a href="/modules/module/<?php echo e($module->name); ?>">

                                            <span><?php echo e(ucfirst($module->name)); ?></span>
                                        </a>
                                    <li>
                                <?php endif; ?>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Access User')): ?>
                            <li class="<?php echo e((request()->is('users')) ? 'active' : ''); ?>">
                                <a href="/users" class=" ">

                                    <span>User Management</span>
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </li>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Access Module')): ?>
                    <?php if($user->email == 'probsoltechnology@gmail.com'): ?>
                    <li class="<?php echo e(Request::routeIs('module.index') ? 'active' : ''); ?>">
                        <a href="<?php echo e(route('module.index')); ?>" class=" ">

                            <span>Manage Module</span>
                        </a>
                    </li>
                    <?php endif; ?>
                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Access leads')): ?>

                    <li>
                        <a href="#exampledropdownDropdown4" aria-expanded="false" data-toggle="collapse">
                            Lead Management </a>
                        <ul id="exampledropdownDropdown4" class="collapse list-unstyled <?php echo e(Request::routeIs('lead.index') ? 'show' : ''); ?><?php echo e(request()->is('modules/module/Industry') ? 'show' : ""); ?> <?php echo e(request()->is('modules/module/LeadSource') ? 'show' : ""); ?><?php echo e(request()->is('modules/module/LeadStatus') ? 'show' : ""); ?><?php echo e(request()->is('modules/module/Rating') ? 'show' : ""); ?>">
                            <?php $__currentLoopData = $modules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $module): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($module->name == 'Industry'): ?>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Access '.$module->name)): ?>
                                        <li class="<?php echo e((request()->is('modules/module/'.$module->name)) ? 'active' : ''); ?>">
                                            <a href="/modules/module/<?php echo e($module->name); ?>">

                                                <span><?php echo e(ucfirst($module->name)); ?></span>
                                            </a>
                                        <li>
                                    <?php endif; ?>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <li class="<?php echo e(Request::routeIs('lead.index') ? 'active' : ''); ?>">
                                <a href="<?php echo e(route('lead.index')); ?>" class=" ">

                                    <span>Lead Management</span>
                                </a>
                            </li>

                            <?php $__currentLoopData = $modules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $module): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($module->name == 'Rating'): ?>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Access '.$module->name)): ?>
                                        <li class="<?php echo e((request()->is('modules/module/'.$module->name)) ? 'active' : ''); ?>">
                                            <a href="/modules/module/<?php echo e($module->name); ?>">
                                            <span>Geographical Segment</span>
                                            
                                            </a>
                                        <li>
                                    <?php endif; ?>
                                <?php endif; ?>
                                <?php if($module->name == 'LeadSource'): ?>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Access '.$module->name)): ?>
                                        <li class="<?php echo e((request()->is('modules/module/'.$module->name)) ? 'active' : ''); ?>">
                                            <a href="/modules/module/<?php echo e($module->name); ?>">

                                                <span>Lead Source</span>
                                            </a>
                                        <li>
                                    <?php endif; ?>
                                <?php endif; ?>
                                <?php if($module->name == 'LeadStatus'): ?>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Access '.$module->name)): ?>
                                        <li <?php echo e((request()->is('modules/module/LeadStatus')) ? 'active' : ''); ?>>
                                            <a href="/modules/module/<?php echo e($module->name); ?>">

                                                <span>Lead Status</span>
                                            </a>
                                        <li>
                                    <?php endif; ?>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        </ul>
                    </li>
            <?php endif; ?>
            <?php if($user->email == $super_admin || $user->email == 'probsoltechnology@gmail.com'): ?>
                    <li class="<?php echo e(Request::routeIs('admin.billing.index') ? 'active' : ''); ?>">
                        <a href="<?php echo e(route('admin.billing.index')); ?>" class=" ">
                            <span>Billing System</span>
                        </a>
                    </li>
            <?php endif; ?>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Access Role')): ?>
                    <li class="<?php echo e(Request::routeIs('roles.index') ? 'active' : ''); ?>">
                        <a href="<?php echo e(route('roles.index')); ?>" class=" ">

                            <span>Role Management</span>
                        </a>
                    </li>
            <?php endif; ?>

            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Access CustomerAdmin')): ?>
                <li class="<?php echo e(Request::routeIs('customer.login_system.index') ? 'active' : ''); ?>">
                    <a href="<?php echo e(route('customer.login_system.index')); ?>" class=" ">
                        <span>Customer Login System</span>
                    </a>
                </li>
            <?php endif; ?>   
            
            <?php $__currentLoopData = $modules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $module): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if($module->name != 'activitystatus' and $module->name != 'activitytype' and $module->name != 'Branch' and $module->name != 'departments' and $module->name != 'designations' and $module->name != 'employees' and $module->name != 'teams' and $module->name != 'CompanyType' and $module->name != 'Rating' and $module->name != 'Industry'  and $module->name != 'LeadSource' and $module->name != 'LeadStatus' and $module->name != 'Zones' ): ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Access '.$module->name)): ?>
                        <li class="<?php echo e((request()->is('modules/module/'.$module->name)) ? 'active' : ''); ?>">
                            <a href="/modules/module/<?php echo e($module->name); ?>"  >

                                <span> <?php echo e(ucfirst($module->name)); ?></span>
                            </a>
                        <li>
                    <?php endif; ?>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    
             <?php if($user->email == $super_admin): ?>
                    <li style="display:none;">
                        <a href="#exampledropdownDropdown5" aria-expanded="false" data-toggle="collapse">Settings </a>
                        <ul id="exampledropdownDropdown5" class="collapse list-unstyled <?php echo e(Request::routeIs('change-password') ? 'show' : ''); ?><?php echo e(request()->is('admin-profile-page') ? 'show' : ""); ?> <?php echo e(request()->is('change-password') ? 'show' : ""); ?><?php echo e(request()->is('change-password') ? 'show' : ""); ?><?php echo e(request()->is('change-password') ? 'show' : ""); ?>">
                            <li class="<?php echo e(Request::routeIs('change-password') ? 'active' : ''); ?>">
                                <a href="<?php echo e(route('change-password')); ?>" class=" ">
                                    <span>Reset Password</span>
                                </a>
                            </li>
                            <li class="<?php echo e(Request::routeIs('admin-profile-page') ? 'active' : ''); ?>">
                                <a href="<?php echo e(route('admin-profile-page')); ?>" class=" ">
                                    <span>My Profile</span>
                                </a>
                            </li>
                        </ul>
                    </li>
            <?php endif; ?>
            
            <?php echo $__env->make('panels._expances_nav', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            
            </ul>
        </div>
    </div>
</nav>
<?php /**PATH C:\xampp_7.4.19\htdocs\web_project\HVL_Mar2024\resources\views/panels/sidebar.blade.php ENDPATH**/ ?>
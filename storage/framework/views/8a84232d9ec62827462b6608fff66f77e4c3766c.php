<?php
use Illuminate\Support\Facades\DB;
use App\Module; 
    $user_profile = DB::table('users')->where('id','=','122')->first();
    $profile_image = '/public/uploads/profile/' . $user_profile->profile_image;
    $business_logo = '/public/uploads/profile/' . $user_profile->business_logo;
    $background_images = '/public/uploads/profile/' . $user_profile->background_images;
    $copyrite = $user_profile->copyright_label;
    $displayname = $user_profile->displayname;
    $user_role_name = App\Http\Controllers\UserProfileController::find_user_role($user_profile->id);
?>
<html lang="en" data-layout="semibox" data-sidebar-visibility="show" data-topbar="light" data-sidebar="light" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable">
    <head>    
        <meta charset="utf-8" />
        <title><?php echo $__env->yieldContent('title'); ?> | hvl </title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
        <meta content="Themesbrand" name="author" />
        <?php echo $__env->make('new_themes.partials.master_css', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </head>
    <body>
        <div id="layout-wrapper">
            
            
            
            <div class="vertical-overlay"></div>
            <!--<div class="main-content">-->
                <!--<div class="page-content">-->
                    <!--<div class="container-fluid">-->
                        <?php echo $__env->yieldContent('content'); ?>
                    <!--</div>-->
                <!--</div>-->
                
            <!--</div>-->
        </div>
        <button onclick="topFunction()" class="btn btn-danger btn-icon" id="back-to-top">
            <i class="ri-arrow-up-line"></i>
        </button>
        <?php echo $__env->make('new_themes.partials.extra.preloader', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>  
        <?php echo $__env->make('new_themes.partials.master_js', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>   
    </body>
</html><?php /**PATH C:\xampp_7.4.19\htdocs\web_project\HVL_Mar2024\resources\views/new_themes/master.blade.php ENDPATH**/ ?>
<?php
use Illuminate\Support\Facades\DB;
$user = DB::table('users')->where('id', '122')->first();
$business_logo = '/public/uploads/profile/' . $user->business_logo;
$background_images = '/public/uploads/profile/' . $user->background_images;
$copyrite = $user->copyright_label;
$displayname = $user->displayname;
?>
<!doctype html>
<html lang="en">

    <head>
        <title><?php echo $__env->yieldContent('title'); ?> | Hvl Management</title>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
     <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">


    <link rel="icon" href="<?php echo $business_logo; ?>" type="image/x-icon" />
    <link rel="shortcut icon" href="<?php echo $business_logo; ?>" type="image/x-icon" />
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="all,follow">
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&amp;display=swap" rel="stylesheet">
    <!--<link rel="stylesheet" href="asset('vendor/profile/font-awesome.min.css')">-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="<?php echo e(asset('vendor/profile/style.css')); ?>">
 

<style>
    a, a:hover{
        color:#333;
    }
    .input-group-addon {
        padding: 0.5rem 0.75rem;
        color: #495057;
        text-align: center;
        border: 1px solid rgba(0,0,0,.15);
        border-radius: -1.75rem;
    }
</style>
<body style="background-image: url('<?php echo $background_images; ?>');background-size: cover;">
    <section class="ftco-section">
        <div class="container">

            <div class="row justify-content-center">
                <div class="col-md-7 col-lg-5">
                    <div class="wrap">
                        <div class="col-sm-12 col-md-12" style="text-align: center;">
                            <img class="img-responsive" height="150"  src="<?php echo $business_logo; ?>">
                        </div>
                        <div class="login-wrap p-4 p-md-5">
                            <div class="d-flex">
                                <!--<div class="w-100">-->
                                <!--    <h3 class="mb-4" style="text-align: center;">Log In</h3>-->
                                <!--</div>-->
                                <!--                                    <div class="w-100">
                                                                        <p class="social-media d-flex justify-content-end">
                                                                            <a href="#" class="social-icon d-flex align-items-center justify-content-center"><span class="fa fa-facebook"></span></a>
                                                                            <a href="#" class="social-icon d-flex align-items-center justify-content-center"><span class="fa fa-twitter"></span></a>
                                                                        </p>
                                                                    </div>-->
                            </div>

                            <form  method="POST" action="<?php echo e(route('login')); ?>" class="signin-form">

                                <!--**-->
                                <div class="form-group mt-3">
                                    <label class="" for="username">Email ID/User ID</label>
                                    <input type="email" name="email" id="email" class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e(old('email')); ?>" autocomplete="email" autofocus placeholder="Email ID/User ID" data-error=".errorTxt1">
                                     <span class="errorTxt1" style="color: red;"></span>

                                </div>

                                <div class="form-group">
                                  <label class="" for="password">Password</label>
                                    <div class="input-group" id="show_hide_password">
                                        <input class="form-control" type="password" name="password" id="password" data-error=".errorTxt2">
                                        <div class="input-group-addon">
                                            <a href=""><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                                        </div>
                                    </div>
                                    <span class="errorTxt2" style="color: red;"></span>
                                    
                                <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <span class="invalid-feedback" role="alert">
                                    <strong><?php echo e($message); ?></strong>
                                </span>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                                <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <span class="invalid-feedback" role="alert">
                                    <strong><?php echo e($message); ?></strong>
                                </span>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                                <div class="form-group">
                                    <button type="submit" name="action" class="form-control btn btn-primary rounded submit px-3">Log In</button>
                                </div>
                            </form>
                            <!--<p class="text-center">Not a member? <a data-toggle="tab" href="#signup">Sign Up</a></p>-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <footer class="main-footer">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <p><?php echo $copyrite; ?></p>
                </div>
                <div class="col-sm-6 text-right">
                    <!--<p>Design by <a href="https://probsoltechnology.com" class="external">ProbSol Technology</a></p>-->
                </div>
            </div>
        </div>
    </footer>
    <script src="<?php echo e(asset('vendor/jquery/jquery.min.js')); ?>"></script>
            <!--<script src="https://preview.colorlib.com/theme/bootstrap/login-form-15/js/jquery.min.js"></script>-->
    <script src="https://preview.colorlib.com/theme/bootstrap/login-form-15/js/popper.js"></script>
    <!--<script src="https://preview.colorlib.com/theme/bootstrap/login-form-15/js/bootstrap.min.js"></script>-->
    <script src="https://preview.colorlib.com/theme/bootstrap/login-form-15/js/main.js"></script>

    <script src="https://dev.realestate.probsoltech.com/vendor/jquery-validation/jquery.validate.min.js"></script>

  

    <script src="<?php echo e(asset('vendor/bootstrap/js/bootstrap.bundle.min.js')); ?>"></script>
    <script src="<?php echo e(asset('js/grasp_mobile_progress_circle-1.0.0.min.js')); ?>"></script>



    <script>
        $(document).ready(function () {
            $(".invalid-feedback").show().delay(2000).fadeOut();
        $(".signin-form").validate({
        rules: {
        email: {
        required: true,
        },
                password: {
                required: true,
                },
        },
                messages: {
                email: {
                required: "Please enter valid Email Id",
                },
                        password: {
                        required: "Please enter valid password",
                        },
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
        });
        $(document).ready(function () {
        $("#show_hide_password a").on('click', function (event) {
        event.preventDefault();
        if ($('#show_hide_password input').attr("type") == "text") {
        $('#show_hide_password input').attr('type', 'password');
        $('#show_hide_password i').addClass("fa-eye-slash");
        $('#show_hide_password i').removeClass("fa-eye");
        } else if ($('#show_hide_password input').attr("type") == "password") {
        $('#show_hide_password input').attr('type', 'text');
        $('#show_hide_password i').removeClass("fa-eye-slash");
        $('#show_hide_password i').addClass("fa-eye");
        }
        });
        });
    </script>
</body>
</html>
<?php /**PATH C:\xampp_7.4.19\htdocs\web_project\HVL_Mar2024\resources\views/auth/login.blade.php ENDPATH**/ ?>
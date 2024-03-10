@php
use Illuminate\Support\Facades\DB;
use App\Module; 
    $user_profile = DB::table('users')->where('id','=','122')->first();
    $profile_image = '/public/uploads/profile/' . $user_profile->profile_image;
    $business_logo = '/public/uploads/profile/' . $user_profile->business_logo;
    $background_images = '/public/uploads/profile/' . $user_profile->background_images;
    $copyrite = $user_profile->copyright_label;
    $displayname = $user_profile->displayname;
    $user_role_name = App\Http\Controllers\UserProfileController::find_user_role($user_profile->id);
@endphp
<html lang="en" data-layout="semibox" data-sidebar-visibility="show" data-topbar="light" data-sidebar="light" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable">
    <head>    
        <meta charset="utf-8" />
        <title>@yield('title') | hvl </title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
        <meta content="Themesbrand" name="author" />
        @include('new_themes.partials.master_css')
    </head>
    <body>
        <div id="layout-wrapper">
            {{--
            <header id="page-topbar">
            </header>
            --}}
            
            {{--
            <div class="app-menu navbar-menu">
            </div>
            --}}
            <div class="vertical-overlay"></div>
            <!--<div class="main-content">-->
                <!--<div class="page-content">-->
                    <!--<div class="container-fluid">-->
                        @yield('content')
                    <!--</div>-->
                <!--</div>-->
                {{--
                <footer class="footer">
                    @include('new_themes.partials.master_footer')
                </footer>
                --}}
            <!--</div>-->
        </div>
        <button onclick="topFunction()" class="btn btn-danger btn-icon" id="back-to-top">
            <i class="ri-arrow-up-line"></i>
        </button>
        @include('new_themes.partials.extra.preloader')  
        @include('new_themes.partials.master_js')   
    </body>
</html>
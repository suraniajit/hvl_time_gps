<?php
use Illuminate\Support\Facades\DB;
use App\Module; 

$user_profile = DB::table('users')->where('id','=','122')->first();


$profile_image = '/public/uploads/profile/' . $user_profile->profile_image;
$business_logo = '/public/uploads/profile/' . $user_profile->business_logo;
$background_images = '/public/uploads/profile/' . $user_profile->background_images;
$copyrite = $user_profile->copyright_label;
$displayname = $user_profile->displayname;
?>
<html class="loading" lang="en">
<!-- BEGIN: Head-->
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">

    <title>@yield('title')</title>
    <link rel="icon" href="<?php echo $business_logo; ?>" type="image/x-icon"/>
    <link rel="shortcut icon" href="<?php echo $business_logo; ?>" type="image/x-icon"/>

    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="all,follow">
    <!-- Bootstrap CSS-->
    <link rel="stylesheet" href="{{asset('vendor/bootstrap/css/bootstrap.min.css')}}">
    <!-- Font Awesome CSS-->
    <link rel="stylesheet" href="{{asset('vendor/font-awesome/css/font-awesome.min.css')}}">
    <!-- Fontastic Custom icon font-->
    <link rel="stylesheet" href="{{asset('css/fontastic.css')}}">
    <!-- Google fonts - Roboto -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700">
    <!-- jQuery Circle-->
    <link rel="stylesheet" href="{{asset('css/grasp_mobile_progress_circle-1.0.0.min.css')}}">
    <!-- Custom Scrollbar-->
    <link rel="stylesheet" href="{{asset('vendor/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.css')}}">
    <!-- theme stylesheet-->
    <link rel="stylesheet" href="{{asset('css/style.red.css')}}" id="theme-stylesheet">
    <!-- Custom stylesheet - for your changes-->
    <link rel="stylesheet" href="{{asset('css/custom.css')}}">
    <link rel= "stylesheet" href = "https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.15/css/bootstrap-multiselect.css"/> <!-- for dropdown issue -->
    <!--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.16/css/bootstrap-multiselect.min.css" integrity="sha512-wHTuOcR1pyFeyXVkwg3fhfK46QulKXkLq1kxcEEpjnAPv63B/R49bBqkJHLvoGFq6lvAEKlln2rE1JfIPeQ+iw==" crossorigin="anonymous"/>-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/css/bootstrap-datepicker.css" crossorigin="anonymous"/>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.7/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.css" integrity="sha512-f8gN/IhfI+0E9Fc/LKtjVq4ywfhYAVeMGKsECzDUHcFJ5teVwvKTqizm+5a84FINhfrgdvjX8hEJbem2io1iTA==" crossorigin="anonymous"/>

    <!--<link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">-->
    <link rel="stylesheet" href="{{asset('css/datestyle.css')}}">
    <style>
        #load {
            width: 100%;
            height: 100%;
            position: fixed;
            z-index: 9999;
            
            background: url('<?php echo $business_logo; ?>') no-repeat rgba(255, 255, 255, 1) center ;

        }

    </style>
    @yield('vendor-style')


</head>
<!-- END: Head-->

<body>
<!-- BEGIN: SideNav-->
@include('panels.sidebar')
<!-- END: SideNav-->

<!-- BEGIN: Page Main-->
<div id="load">

</div>
<div id="contents">

    <div class="page">
    @include('panels.header-nav')

    {{-- main page content  --}}


    @yield('content')

    {{--    @if($configData["isFabButton"] === true)--}}
    {{--        @include('pages.sidebar.fab-menu')--}}
    {{--    @endif--}}



    <!-- END: Page Main-->

        {{-- main footer  --}}
        @include('panels.footer')
    </div>

</div>
<!--newchart js-->
<script src="https://cdn.anychart.com/releases/8.11.1/js/anychart-base.min.js" type="text/javascript"></script>

{{-- vendors and page scripts file   --}}
<script src="{{asset('vendor/jquery/jquery.min.js')}}"></script>
<script src="{{asset('vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('js/grasp_mobile_progress_circle-1.0.0.min.js')}}"></script>
{{--<script src="{{'vendor/jquery.cookie/jquery.cookie.js'}}"> </script>--}}
{{--<script src="{{asset('vendor/chart.js/Chart.min.js')}}"></script>--}}
<script src="{{asset('vendor/jquery-validation/jquery.validate.min.js')}}"></script>
<script src="{{asset('vendor/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js')}}"></script>
{{--<script src="{{asset('js/charts-home.js')}}"></script>--}}
{{--<script src="{{asset('js/charts-custom.js')}}"></script>--}}
<!-- Main File-->
<script src="{{asset('js/front.js')}}"></script>
<script src = "https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.15/js/bootstrap-multiselect.min.js"></script>
<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.16/js/bootstrap-multiselect.min.js" integrity="sha512-ljeReA8Eplz6P7m1hwWa+XdPmhawNmo9I0/qyZANCCFvZ845anQE+35TuZl9+velym0TKanM2DXVLxSJLLpQWw==" crossorigin="anonymous"></script>-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/js/bootstrap-datepicker.min.js" crossorigin="anonymous"></script>
{{--<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>--}}
{{--<script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js"></script>--}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.min.js" integrity="sha512-MqEDqB7me8klOYxXXQlB4LaNf9V9S0+sG1i8LtPOYmHqICuEZ9ZLbyV3qIfADg2UJcLyCm4fawNiFvnYbcBJ1w==" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
<!--<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>-->
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.colVis.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.7/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.7/js/responsive.bootstrap4.min.js"></script>
<script src="{{asset('js/custom/clock.js')}}"></script>
<script>
        let hour = 00; 
        let minute = 00; 
        let second = 00; 
        let count = 00;
        $('#__start_clock').click(function (){
            timer = true;  
            stopWatch(); 
        });
        $('#__stop_clock').click(function (){
            timer = false; 
        });
</script>

<script>
    document.onreadystatechange = function () {
        var state = document.readyState
        if (state == 'interactive') {
            document.getElementById('contents').style.visibility = "hidden";
        } else if (state == 'complete') {
            setTimeout(function () {
                document.getElementById('interactive');
                document.getElementById('load').style.visibility = "hidden";
                document.getElementById('contents').style.visibility = "visible";
            }, 1000);
        }
    }

    $(".logout").click(function () {
        var token = $("meta[name='csrf-token']").attr("content");
        swal({
                title: "Are you sure you want to logout?",
                type: 'warning',
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Yes",
                closeOnConfirm: false
            },
            function (isConfirm) {
                if (isConfirm) {
                    $.ajax({
                        url: "/user-logout",
                        type: "get",
                        success: function (result) {
                            window.location.href = "/login";
                        }
                    });
                }
            });
    });
     /*Developed by hitesh*/
        var allowPaste = function(e){
  e.stopImmediatePropagation();
  return true;
};
document.addEventListener('paste', allowPaste, true);
/*Developed by hitesh*/

</script>

@yield('page-script')


</body>

</html>

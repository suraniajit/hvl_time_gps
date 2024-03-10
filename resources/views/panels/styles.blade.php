<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="{{ asset('vendors/vendors.min.css') }}">
<!-- BEGIN: VENDOR CSS-->
@yield('vendor-style')
<!-- END: VENDOR CSS-->
<!-- BEGIN: Page Level CSS-->
@if(!empty($configData['mainLayoutType']) && isset($configData['mainLayoutType']))
<link rel="stylesheet" type="text/css"
      href="{{asset('css/themes/'.$configData['mainLayoutType'].'-template/materialize.css')}}">
<link rel="stylesheet" type="text/css"
      href="{{asset('css/themes/'.$configData['mainLayoutType'].'-template/style.css')}}">

@if($configData['mainLayoutType'] === 'horizontal-menu')
{{-- horizontal style file only for horizontal layout --}}
<link rel="stylesheet" type="text/css" href="{{asset('css/layouts/style-horizontal.css')}}">
@endif
@else
<h1>mainLayoutType option is either empty or not set in config custom.php file.</h1>
@endif

@yield('page-style')

@if($configData['direction'] === 'rtl')
{{-- rtl style file for rtl version --}}
<link rel="stylesheet" type="text/css" href="{{asset('css/style-rtl.css')}}">
@endif
<!-- END: Page Level CSS-->
<!-- BEGIN: Custom CSS-->
<link rel="stylesheet" type="text/css" href="{{asset('css/laravel-custom.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('css/custom/custom.css')}}">
<!-- END: Custom CSS-->

<!--date and timepicker-->
<link rel="stylesheet" type="text/css" href="{{asset('js/ajax/jquery-datetimepicker/jquery.datetimepicker.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('js/ajax/jquery-datetimepicker/jquery.datetimepicker.min.css')}}">
<!--
 BEGIN: Page Level CSS
<link rel="stylesheet" type="text/css"
      href="{{ asset('css/themes/vertical-modern-menu-template/materialize.css') }}">
<link rel="stylesheet" type="text/css"
      href="{{ asset('css/themes/vertical-modern-menu-template/style.css') }}">-->


<!--/*Home controller*/-->
<input type="hidden" id="hdnSession" name="hdnSession" value="{{Session::get('someKey')}}" />
<input type="hidden" id="user_id_sesssion" name="user_id_sesssion" value="{{Session::get('user_id')}}" />
<input type="hidden" id="user_role" name="user_role" value="{{Session::get('user_role')}}" />
 
<!-- BEGIN VENDOR JS-->
<script src="{{asset('js/vendors.min.js')}}"></script>
<script src="{{asset('js/ajax/sweetalert.min.js')}}"></script>

<!-- BEGIN VENDOR JS-->
<!-- BEGIN PAGE VENDOR JS-->
@yield('vendor-script')
<!-- END PAGE VENDOR JS-->


<!--date and time picker-->
<script src="{{asset('js/ajax/jquery-datetimepicker/jquery.datetimepicker.full.js')}}"></script>
<script src="{{asset('js/ajax/jquery-datetimepicker/jquery.datetimepicker.full.min.js')}}"></script>
<script src="{{asset('js/ajax/jquery-datetimepicker/jquery.datetimepicker.js')}}"></script>
<script src="{{asset('js/ajax/jquery-datetimepicker/jquery.datetimepicker.min.js')}}"></script>
<script src="{{asset('js/custom/clock.js')}}"></script>

<script>
</script>
<!-- BEGIN THEME  JS-->
<script src="{{asset('js/plugins.js')}}"></script>
<script src="{{asset('js/search.js')}}"></script>

@if ($configData['isCustomizer']=== true)
<script src="{{asset('js/scripts/customizer.js')}}"></script>
@endif
<!-- END THEME  JS-->
<!-- BEGIN PAGE LEVEL JS-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/js/materialize.min.js"></script>
@yield('page-script')
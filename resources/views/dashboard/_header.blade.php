{{-- vendor styles --}}
@section('vendor-style')
<script src="{{asset('js/materialize.js')}}"></script>
<script src="{{asset('js/ajax/jquery.min.js')}}"></script>
<script src="{{asset('js/ajax/jquery.validate.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>

<link rel="stylesheet" href="{{ asset('vendors/select2/select2.min.css') }}" type="text/css">
<link rel="stylesheet" href="{{ asset('vendors/select2/select2-materialize.css') }}" type="text/css">

<link href="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/css/select2.min.css" rel="stylesheet" />


<script type="text/javascript" src="{{ asset('js/fusioncharts/fusioncharts.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/fusioncharts/fusioncharts.charts.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/fusioncharts/fusioncharts.theme.fint.js') }}"></script>

<script src="{{asset('js/fusionchartMain.js')}}"></script>
<script src="{{asset('js/fusionchart_frm_validation.js')}}"></script>

 <script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.min.js"></script>


<script src="{{asset('js/fusioncharts/themes/fusioncharts.theme.fusion.js')}}" type="text/javascript"></script>
<script src="{{asset('js/fusioncharts/themes/fusioncharts.theme.candy.js')}}" type="text/javascript"></script>
<script src="{{asset('js/fusioncharts/themes/fusioncharts.theme.umber.js')}}" type="text/javascript"></script>
@endsection

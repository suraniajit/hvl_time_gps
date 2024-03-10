
@endsection

{{-- vendor scripts --}}
@section('vendor-script')

@endsection

{{-- page scripts --}}
@section('page-script')
<script>
    $(document).ready(function () {
// the "href" attribute of the modal trigger must specify the modal ID that wants to be triggered
        $('.modal').modal();
        
        $("select2").select2();

    });
</script>
@endsection


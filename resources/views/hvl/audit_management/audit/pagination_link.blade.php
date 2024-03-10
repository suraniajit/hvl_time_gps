<form method="POST" id="pagination_form" >
    @csrf
    @foreach($search_param as $key=>$values)
        @if($key == 'customers_id')
            @foreach($values as $value)
                <input type="hidden" name="{{$key}}[]" value="{{$value}}">
            @endforeach
        @else
            <input type="hidden" name="{{$key}}" value="{{$values}}">
        @endif
    @endforeach
    @php 
        $helper = new Helper();
    @endphp
    <?=$helper->paginateLink($model)?>
</form>
aa
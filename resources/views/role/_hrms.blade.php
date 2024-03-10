@php $i = 1 @endphp


@foreach($permissions as $key => $premission)

@if($i%5 == 1)
@php $name = explode(' ', $premission->name, 2) @endphp
@php  $path = $premission->path @endphp


    <div class="col-sm-12 col-md-6">
        <strong>{{ ucfirst($name[1]) }}</strong>
    </div>

@endif

<div class="col-sm-12 col-md-6">
    <div class="i-checks">
        <input type="checkbox" id="{{ $premission->name }}" name="permissions[]" value="{{ $premission->name }}"
               @if(isset($role)) @if($role->hasPermissionTo($premission->name)) checked @endif @endif
               onclick="if(document.getElementById('Access {{ $name[1] }}').checked === false){
            document.getElementById('Access {{ $name[1] }}').checked = this.checked
            }" >
        <label for="checkboxCustom1">{{ ucfirst($premission->name) }}</label>

    </div>
    <br>
</div>



@php $i++ @endphp

@endforeach

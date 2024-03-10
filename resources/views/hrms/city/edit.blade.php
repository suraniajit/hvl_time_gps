@extends('app.layout')

{{-- page title --}}
@section('title','Customer Management | HVL')

@section('vendor-style')

@endsection
@section('content')
    <div class="breadcrumb-holder">
        <div class="container-fluid">
            <ul class="breadcrumb">
                {{--                <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>--}}
                <li class="breadcrumb-item active"><a href="{{route('state.index')}}">City </a></li>
                <li class="breadcrumb-item ">Update City</li>
            </ul>
        </div>
    </div>
    <section>
        <div class="container-fluid">
            <div class="card">
                <div class="card-body p-4">
                    <header>
                        <div class="row">
                            <div class="col-md-7">
                                <h2 class="h3 display"> Update City</h2>
                            </div>
                        </div>

                    </header>
                    <form action="{{route('city.update',['id' => $CityMasters->id])}}" method="post" id="contact_us">
                        @csrf
                        <div class="row">
                            <div class="form-group col-sm-6 col-md-4">
                                <label for="">Select Country Name</label>
                                <input type="hidden" name="country_id" value="1">
                                <select id="country_id"  class="form-control" data-error=".errorTxt1" disabled>
                                    <option value="1">India</option>
                                </select>
                                <div class="errorTxt1"></div>
                            </div>
                            <div class="form-group col-sm-6 col-md-4">
                                <label for="">Select State Name <span class="text-danger">*</span> </label>
                                <select name="state_id" id="state_id" class="form-control" data-error=".errorTxt2">
                                    @foreach($states as $state)
                                        <option value="{{$state->id}}" @if($state->id == $CityMasters->state_id) selected @endif>{{$state->state_name}}</option>
                                    @endforeach
                                </select>
                                <div class="errorTxt2 text-danger">@error('state_id'){{ $message }}@enderror</div>
                            </div>

                            <div class="form-group col-sm-6 col-md-4">
                                <label for="">City Name <span class="text-danger">*</span> </label>
                                <input type="text" name="city_name" class="form-control" value="{{$CityMasters->city_name}}" data-error=".errorTxt3">
                                <div class="errorTxt3 text-danger">@error('city_name'){{ $message }}@enderror</div>
                            </div>

                            <div class=" form-group col-sm-6 col-md-4">
                                <label for="">Location<span class="text-danger">*</span> </label>
                                <input type="text" value="{{old('location',$CityMasters->location)}}"  name="location" class="form-control" id="location" placeholder="Enter City Location" data-error=".errorTxtLocation">
                                <div class="errorTxtLocation text-danger">@error('location'){{ $message }}@enderror</div>
                            </div>
                            <div class=" form-group col-sm-6 col-md-4">
                                <label for="">Latitude<span class="text-danger">*</span> </label>
                                <input type="text" value="{{old('latitude',$CityMasters->latitude)}}"  readonly name="latitude" class="form-control" id="latitude" placeholder="Latitude" data-error=".errorTxtLatitude">
                                <div class="errorTxtLatitude text-danger">@error('latitude'){{ $message }}@enderror</div>
                            </div>
                            <div class=" form-group col-sm-6 col-md-4">
                                <label for="">Longitude<span class="text-danger">*</span> </label>
                                <input type="text" value="{{old('longitude',$CityMasters->longitude)}}" readonly name="longitude" class="form-control" id="longitude" placeholder="Longitude" data-error=".errorTxtLongitude">
                                <div class="errorTxtLongitude text-danger">@error('longitude'){{ $message }}@enderror</div>
                            </div>
                            

                            <div class="form-group col-sm-6 col-md-4">
                                <label>Select Status <span class="text-danger">*</span></label>
                                <select id="is_active" class="form-control" name="is_active" data-error=".errorTxt4">
                                    <option value="">Select Status</option>
                                    <option value="0" {{ $CityMasters->is_active=='0' ? ' selected="" ' : '' }} > Active</option>
                                    <option value="1" {{ $CityMasters->is_active=='0' ? 'Active' : ' selected="" ' }}>Inactive</option>
                                </select>
                                <div class="errorTxt4 text-danger">@error('is_active'){{ $message }}@enderror</div>
                            </div>
                        </div>


                        <div class="row mt-4 pull-right">
                            <div class="col-sm-12 ">
                                <button class="btn btn-primary mr-2" type="submit" name="action">
                                    <i class="fa fa-arrow-circle-up"></i>
                                    Update
                                </button>
                                <button type="reset" class="btn btn-secondary  mb-1">
                                    <i class="fa fa-arrow-circle-left"></i>
                                    <a href="{{url()->previous()}}" class="text-white">Cancel</a>
                                </button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
{{-- page script --}}
@section('page-script')
<script src="{{asset('js/hrms/city/edit.js')}}"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBxKK1ePS2LinpV1r09ctx6rWLP6TLuW0s&callback=initAutocomplete&libraries=places&v=weekly" defer ></script>
<script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
<script>
        let autocomplete;
        let address1Field;
        function initAutocomplete() {
        address1Field = document.querySelector("#location");
        autocomplete = new google.maps.places.Autocomplete(address1Field, {
            componentRestrictions: { country: ["in"] },
            fields: ["ALL"],
            // types: ["atm","airport","amusement_park","aquarium","art_gallery","art_gallery"],
        });
        address1Field.focus();
        autocomplete.addListener("place_changed", fillInAddress);
        }

    function fillInAddress() {
        const place = autocomplete.getPlace();
        $('#latitude').val(place.geometry.location.lat());
        $('#longitude').val(place.geometry.location.lng());
    }
    window.initAutocomplete = initAutocomplete;
    $("#location").keyup(function(){
        $('#latitude').val('');
        $('#longitude').val('');
    });
</script>
@endsection

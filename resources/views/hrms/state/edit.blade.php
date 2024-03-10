@extends('app.layout')

{{-- page title --}}
@section('title','State Management | HVL')

@section('vendor-style')

@endsection
@section('content')
    <div class="breadcrumb-holder">
        <div class="container-fluid">
            <ul class="breadcrumb">
                {{--                <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>--}}
                <li class="breadcrumb-item active"><a href="{{route('state.index')}}">States </a></li>
                <li class="breadcrumb-item ">Update State</li>
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
                                <h2 class="h3 display"> Update State</h2>
                            </div>
                        </div>

                    </header>
                <form  id="formValidate" action="{{route('state.update',['id' => $StateMasters->id])}}" method="post" >
                    @csrf
                    <input type="hidden" name="state_id" value="{{$StateMasters->id}}">
                    <div class="row">
                        <div class="form-group col-sm-6 col-md-4">
                            <label for="">Country </label>
                            <input type="hidden" name="country_id" value="1">
                            <select class="form-control" id="country_id" data-error=".errorTxt1" disabled>
                                <option value="1">India</option>
                            </select>
                        </div>

                        <div class="form-group col-sm-6 col-md-4">
                            <label class="">State Name <span class="text-danger">*</span> </label>
                            <input type="text" name="state_name" class="form-control" value="{{$StateMasters->state_name}}" placeholder="Enter State Name" data-error=".errorTxt2">
                            <div class="errorTxt2 text-danger"></div>
                        </div>

                        <div class="form-group col-sm-6 col-md-4">
                            <label>Select Status</label>
                            <select id="is_active" name="is_active" class="form-control" data-error=".errorTxt3" >
                                <option value = ""  disabled="">Select Status</option>
                                <option value = "0" {{ $StateMasters->is_active=='0' ? ' selected="" ' : '' }} > Active  </option>
                                <option value = "1" {{ $StateMasters->is_active=='0' ? 'Active' : ' selected="" ' }}>Inactive </option>
                            </select>
                            <div class="errorTxt3 text-danger"></div>
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

@section('page-script')

<script src="{{asset('js/hrms/state/edit.js')}}"></script>
@endsection

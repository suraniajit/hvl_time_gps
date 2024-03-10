@extends('app.layout')

{{-- page title --}}
@section('title','Category Management | HVL')

@section('vendor-style')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<link rel="stylesheet" href="https://cdn.rawgit.com/jonthornton/jquery-timepicker/3e0b283a/jquery.timepicker.min.css">
<script src="https://cdn.rawgit.com/jonthornton/jquery-timepicker/3e0b283a/jquery.timepicker.min.js"></script>
<style>
    .error{
        text-transform: capitalize;
        position: relative;
        top: 0rem;
        left: 0rem;
        font-size: 0.8rem;
        color: red;
        transform: translateY(0%);
    }
</style>
@endsection


@section('content')
<div class="breadcrumb-holder">
    <div class="container-fluid">
        <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
            <li class="breadcrumb-item active"><a href="{{route('expense')}}">Category Master</a></li>
            <li class="breadcrumb-item">Create</li>
        </ul>
    </div>
</div>

<div class="container-fluid">
    <div class="card">
        <div class="card-body p-4">
            <header>
                <div class="row">
                    <div class="col-md-7">
                        <h2 class="h3 display">Create Category</h2>
                    </div>
                </div>
            </header>
            <form id="formValidate" action="{{route('category.store')}}" method="post">
                {{csrf_field()}}
                <div class="row">
                    <div class="input-field col s6">
                        <label>Category Name </label>
                        <input type="text" name="name" placeholder="Enter Category Name" data-error=".errorTxt1" class="form-control"  >
                        <div class="errorTxt1"></div>
                    </div>

                    <div class="input-field col s6">
                        <label>Select Status</label>
                        <select id="is_active" name="is_active" data-error=".errorTxt2" class="form-control select">
                            <option value = "" disabled="" >Select Status</option>
                            <option value = "0" selected="">Active</option>
                            <option value = "1">Inactive</option>
                        </select>
                        <div class="errorTxt2"></div>
                    </div>
                </div>

                <div class="row" style="text-align: end;">
                    <div class="col s12 display-flex justify-content-end form-action">
                        <button class="btn btn-primary mr-2" type="submit" name="is_save" value="1" >Submit 
                            <i class="fa fa-save"></i>
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

@endsection


{{-- page script --}}
@section('page-script')

<script src="{{asset('js/category/create.js')}}"></script>

@endsection

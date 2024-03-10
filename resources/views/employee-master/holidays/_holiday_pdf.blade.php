{{-- layout extend --}}
@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title','Holiday Management')

{{-- vendor styles --}}
@section('vendor-style')
<link rel="stylesheet" type="text/css" href="{{asset('vendors/select2/select2.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/select2/select2-materialize.css')}}">
<script src="{{asset('js/ajax/jquery.min.js')}}"></script>
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


{{-- page content --}}
@section('content')

<div class="card">
    <div class="card-content">
        <h5 class="title-color"><span>Upload Form : {{$name}}</span></h5>
        <div class=" ">
            @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show center-block" role="alert">
                <strong>{!! Session::get('success') !!} </strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif
            @if($errors->any())
            @foreach ($errors->all() as $error)

            <div class="card-alert card red" id="message">
                <div class="card-content">
                    <p>{{$error}}</p>
                </div>
                <button type="button" class="close green-text close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            @endforeach
            @endif

        </div>
        <form action="{{ route('emp.holidaysPdfUpdate', $emp_id) }}" method="post" enctype="multipart/form-data">
            {{csrf_field()}}
            <div class="row">
                <div class="col s4">
                    <label>File: ( .pdf only)</label>
                    <input type="file" name="pdf_file[]" class="document_file" accept=".pdf" required="">

                </div>
            </div>
            <div class="row">
                <div class="col s12 display-flex justify-content-end form-action">
                    <button type="submit" class="btn btn-small indigo waves-light mr-1">
                        Upload Form
                    </button>
                    <button class="btn btn-small indigo waves-light mr-1" onclick="goBack();">
                        <i class="material-icons right">settings_backup_restore</i>Cancel
                    </button>                </div>
            </div>
            <br>
        </form>






    </div>
</div>
@endsection

{{-- vendor script --}}
@section('vendor-script')

<script src="{{asset('js/ajax/angular.min.js')}}"></script>
<script src="{{asset('js/materialize.js')}}"></script>
<script src="{{asset('js/ajax/jquery.validate.min.js')}}"></script>
<script src="{{asset('vendors/select2/select2.full.min.js')}}"></script>
<script src="{{asset('js/scripts/form-select2.js')}}"></script>



@endsection

{{-- page scripts --}}
@section('page-script')



@endsection
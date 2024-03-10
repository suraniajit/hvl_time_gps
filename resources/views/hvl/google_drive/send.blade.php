{{-- extend layout --}}
@extends('layouts.contentLayoutMaster')

{{-- page Title --}}
@section('title','Email Template Management')


{{-- vendor styles --}}
@section('vendor-style')
<link rel="stylesheet" type="text/css" href="{{asset('vendors/select2/select2.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/select2/select2-materialize.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/materialize.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/vendors.min.css')}}">
@endsection
{{-- page style --}}
@section('page-style')
<link rel="stylesheet" type="text/css" href="{{asset('css/pages/form-select2.css')}}">
@endsection

{{-- page content --}}
@section('content')

<div class="card">
    <div class="card-content">
        <h5 class="title-color"><span>Sent Template :
                <?php
                if (!empty($_GET['name'])) {
                    echo $_GET['name'];
                }
                ?>
            </span>
        </h5>

        <form id="email-details" action="{{route('emailtemplate.sendemail',['id'=>$id])}}" method="post">
            @csrf


            <div class="row">
                <div class="input-field col s6">
                    <input placeholder="Enter Email Subject" class="input-field" name="subject" id="subject" autocomplete="off" autofocus="off"
                           type="text">
                    <label>Enter Email Subject</label>
                    @error('subject')
                    <div class="alert alert-danger red-text">{{ $message }}</div>
                    @enderror

                </div>
            </div>

            <div class="row">
                <div class="input-field col s12">
                    <select class="select2 browser-default" name="email[]" multiple="multiple" data-placeholder="Add Receivers Email">
                        @foreach($users as $user)
                        <option value="{{$user->email}},{{$user->Name}}">{{$user->email}}</option>
                        @endforeach
                    </select>
                    @error('email')
                    <div class="alert alert-danger red-text">{{ $message }}</div>
                    @enderror


                </div>
            </div>



            <div class="row">
                <div class="col s12 display-flex justify-content-end form-action">
                    <input type="hidden" name="id" id="id" value="{{$id}}">
                    <button type="submit" name="action" id="send" class="btn btn-color mr-1">Save
                        <i class="material-icons right">send</i>
                    </button>
                    <button type="reset" class="btn btn-color mb-1" onclick="goBack();">
                        <i class="material-icons right">settings_backup_restore</i>Cancel
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
</div>

@endsection



{{-- vendor script --}}
@section('vendor-script')
<script src="{{asset('js/ajax/jquery.min.js')}}"></script>
<script src="{{asset('js/ajax/angular.min.js')}}"></script>
<script src="{{asset('js/materialize.js')}}"></script>
<script src="{{asset('vendors/select2/select2.full.min.js')}}"></script>
@endsection

{{-- page script --}}
@section('page-script')
<script src="{{asset('js/scripts/advance-ui-modals.js')}}"></script>
<script src="{{asset('js/emailtemplate/send.js')}}"></script>

@endsection

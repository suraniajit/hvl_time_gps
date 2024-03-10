@extends('app.layout')

{{-- page title --}}
@section('title','Real Estate CRM Software | CRM for Real Estate Agents')

@section('vendor-style')
@endsection

@section('content')
<div class="breadcrumb-holder">
    <div class="container-fluid">
        <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
            <li class="breadcrumb-item active"><a href="#">Change Password</a></li>
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
                            <h2 class="h3 display">Change Password</h2>
                        </div>
                    </div>
                </header>
                <form action="{{ route('update-password') }}" method="POST" class="chang_password">
                    @csrf
                    <div class="card-body">
                        @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                        @elseif (session('error'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('error') }}
                        </div>
                        @endif

                        <div class="mb-3">
                            <label for="oldPasswordInput" class="form-label">Old Password</label>
                            <input name="old_password" type="text" class="form-control @error('old_password') is-invalid @enderror" id="oldPasswordInput"
                                   placeholder="Old Password" data-error=".errorTxt1">
                            <span class="errorTxt1" style="color: red;"></span>
                            @error('old_password')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="newPasswordInput" class="form-label">New Password</label>
                            <input name="new_password" type="text" class="form-control @error('new_password') is-invalid @enderror" id="newPasswordInput"
                                   placeholder="New Password" data-error=".errorTxt2">
                                   <span class="errorTxt2" style="color: red;"></span>
                            @error('new_password')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="confirmNewPasswordInput" class="form-label">Confirm Password</label>
                            <input name="new_password_confirmation" type="text" class="form-control" id="new_password_confirmation"
                                   placeholder="Confirm New Password" data-error=".errorTxt3">
                                   <span class="errorTxt3" style="color: red;"></span>
                        </div>

                    </div>
                    
                     <div class="row mt-4 pull-right">
                        <div class="col-sm-12 ">
                            <button class="btn btn-primary mr-2" type="submit" name="action">
                                <i class="fa fa-save"></i>
                                Submit
                            </button>
                            <button type="reset" class="btn btn-secondary  mb-1"> Cancel
                                <i class="fa fa-arrow-circle-left"></i>
                             </button>
                        </div>
                    </div>
                    
                </form>
            </div>
        </div>
    </div>
</div>
@endsection


@section('page-script')
<script>
$(document).ready(function() {
    $(".chang_password").validate({
        rules: {
            old_password: {
                required: true,
                 minlength: 10,
            },
            new_password: {
                required: true,
                minlength: 10,
                
            },
            new_password_confirmation: {
                required: true,
                minlength: 10,
                 equalTo: "#newPasswordInput"
            }
        },
        messages: {
            old_password: {
                required: "Please enter old password",
            },
            new_password: {
                required: "Please enter new password",
            },
            new_password_confirmation: {
                 required: "Please enter Confirm password",
            }
        },
        errorElement: 'div',
        errorPlacement: function(error, element) {
            var placement = $(element).data('error');
            if (placement) {
                $(placement).append(error)
            } else {
                error.insertAfter(element);
            }
        }
    });
});
</script>
@endsection
@extends('app.layout')

{{-- page title --}}
@section('title','HVL')

@section('vendor-style')

@endsection
@section('content')
<div class="breadcrumb-holder">
    <div class="container-fluid">
        <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
            <li class="breadcrumb-item active"><a href="{{url('/users')}}">Admin Management </a></li>
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
                            <h2 class="h3 display">My Profile</h2>
                        </div>
                    </div>
                    @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show center-block" role="alert">
                        <strong>{!! Session::get('success') !!} </strong>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @endif
                </header>

                <form class="create_user" action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row">
                        <div class="form-group col-sm-6 col-md-4">
                            <label for="first_name">Name<span class="text-danger">*</span></label>
                            <input id="name" name="name"  type="text" class="validate form-control" @if(isset($user)) value="{{ $user->name }}" @endif data-error=".errorTxt1" readonly>
                            <span class="errorTxt1" style="color: red;"></span>
                        </div>
                        <div class="form-group col-sm-6 col-md-4">
                            <label for="first_name">Copyright label<span class="text-danger">*</span></label>
                            <input id="copyright_label" name="copyright_label" type="text" class="validate form-control" @if(isset($user)) value="{{$user->copyright_label}}" @endif  data-error=".errorTxt2">
                              <span class="errorTxt2" style="color: red;"></span>
                        </div>
                        <div class="form-group col-sm-6 col-md-4" style="">
                            <label for="email">Email <span class="text-danger">*</span></label>
                            <input id="email" name="email" type="email"  class="validate form-control" @if(isset($user)) value="{{ $user->email }}" @endif required >
                        </div>


                        <div class="form-group col-sm-6 col-md-4">
                            <lable>Profile Image</lable>
                            <input type="file" name="profile_images" id="profile_images" accept=".jpg, .png, .jpeg" class="form-control-file">
                            <p class="text-danger">Max File Size:<strong> 3MB</strong><br>Supported Format: <strong>.jpg .png .jpeg</strong></p>
                            <?php if (isset($user->profile_image)) { ?>
                                <img src="<?php echo $location . $user->profile_image; ?>" style="height: 149px;" />
                            <?php } ?>

                        </div>
                        <div class="form-group col-sm-6 col-md-4">
                            <lable>Change Login Background Image</lable>
                            <input type="file" name="background_images" id="background_images" accept=".jpg, .png, .jpeg" class="form-control-file">
                            <p class="text-danger">Max File Size:<strong> 3MB</strong><br>Supported Format: <strong>.jpg .png .jpeg</strong></p>
                            <?php if (isset($user->background_images)) { ?>
                                <img src="<?php echo $location . $user->background_images; ?>" style="height: 149px;" />
                            <?php } ?>
                        </div>
                        <div class="form-group col-sm-6 col-md-4">
                            <lable>Business Logo</lable>
                            <input type="file" name="business_logo" id="business_logo" accept=".jpg, .png, .jpeg" class="form-control-file">
                            <p class="text-danger">Max File Size:<strong> 3MB</strong><br>Supported Format: <strong>.jpg .png .jpeg</strong></p>
                            <?php if (isset($user->business_logo)) { ?>
                                <img src="<?php echo $location . $user->business_logo; ?>" style="height: 149px;" />
                            <?php } ?>
                        </div>

                    </div>

                    <div class="row mt-4 pull-right">
                        <div class="col-sm-12 ">
                            <button class="btn btn-primary mr-2" type="submit" name="action">
                                <i class="fa fa-save"></i>
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

<script>
$(document).ready(function() {
    $(".create_user").validate({
        rules: {
            name: {
                required: true,
            },
            email: {
                required: true,
            }
            copyright_label: {
                required: true,
            },
        },
        messages: {
            name: {
                required: "Please enter name",
            },
            copyright_label: {
                required: "Please copyright label",
            },
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



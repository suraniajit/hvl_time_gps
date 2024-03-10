@extends('app.layout')

{{-- page title --}}
@section('title','Sub Category Management | HVL')

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
            <li class="breadcrumb-item active"><a href="{{route('expense')}}">Sub Category Master</a></li>
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
                        <h2 class="h3 display">Create Sub Category</h2>
                    </div>
                </div>
            </header>
            <form id="formValidate" action="{{route('subcategory.store')}}" method="post" >
                {{csrf_field()}}
                <div class="row">
                    <div class="input-field col s4">
                        <label>Sub Category Name </label>
                        <input type="text" name="name" class="name" placeholder="Enter Sub Category Name" data-error=".errorTxt1" />
                        <div class="errorTxt1"></div>
                    </div>
                    <div class="input-field col s4">
                        <label>Select Category</label>
                        <select  name="category_id" class="category_id" data-error=".errorTxt2" />
                        <option value="0" disabled="" selected="" >Select Category</option>
                        <?php foreach ($getcategoryList as $key => $categoryList) { ?>
                            <option value="{{$categoryList->id}}">{{$categoryList->name}}</option>
                        <?php } ?>
                        </select>
                        <div class="errorTxt2"></div>
                    </div>
                    <div class="input-field col s4">
                        <label>Select Status</label>
                        <select id="is_active" name="is_active" data-error=".errorTxt3">
                            <option value="" disabled=""  >Select Status</option>
                            <option value="0" selected="">Active</option>
                            <option value="1">Inactive</option>
                        </select>
                        <div class="errorTxt3"></div>
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
<script type="text/javascript">
$(document).ready(function () {
    $('.category_id').change(function () {

        var cid = $(this).val();
        if (cid) {
            $.ajax({
                type: "get",
                url: "/subcategory/validname_",
                data: {
                    name: $('.name').val(),
                    category_id: $(".category_id option:selected").val(),
                },
                success: function (res)
                {
                    if (res == '0')
                    {
                        $(".errorTxt1").empty();
                        $(".errorTxt1").html('<p style="text-transform: capitalize;position: relative;top: 0rem;left: 0rem; font-size: 0.8rem;color: red;transform: translateY(0%);">subcategory is same as category</p>');
                        return false;
                    } else if (res == '1') {
                        $(".errorTxt1").empty();

                    }
                    return true;
                }
            });
        }
    });
});
</script>
<script src="{{asset('js/subcategory/create.js')}}"></script>

@endsection

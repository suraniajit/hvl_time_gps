
@extends('app.layout')

{{-- page title --}}
@section('title','Customer Login System | HVL')

@section('vendor-style')
<style>
    /*.swal-small{*/
    /*    width: 450px !important;*/
    /*}*/
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.16/css/bootstrap-multiselect.min.css" integrity="sha512-wHTuOcR1pyFeyXVkwg3fhfK46QulKXkLq1kxcEEpjnAPv63B/R49bBqkJHLvoGFq6lvAEKlln2rE1JfIPeQ+iw==" crossorigin="anonymous">
</style>
@endsection
@section('content')
    <div class="breadcrumb-holder">
        <div class="container-fluid">
            <ul class="breadcrumb">
                <li class="breadcrumb-item active"><a href="{{route('customer.login_system.index')}}">Customer Login System</a></li>
                <li class="breadcrumb-item ">Show Customer Login </li>
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
                                <h2 class="h3 display"> Show Customer Login</h2>
                                <p style="font-size: 12px;"><strong>Note:</strong>Password Optional if Enter Then Update.</p>
                            </div>
                        </div>

                    </header>
                        <div class="row">
                            <div class="form-group col-sm-6 col-md-4">
                                <label>Customer Name<span class="text-danger">*</span></label>
                                <input type="text" disabled value="{{ $custeradmin->name }}"  name="customer_admin_name" required class="form-control"  placeholder="Enter Customer Name" data-error=".errorTxt2" autocomplete="off" autofocus="off">
                                <div class="errorTxt2 text-danger">{{ ($errors->has('customer_admin_name'))?$errors->first('customer_admin_name'):''}}</div>
                            </div>
                        
                            <div class="form-group col-sm-6 col-md-4">
                                <label>Customer Email<span class="text-danger">*</span></label>
                                <input type="email" disabled name="email" value="{{ $custeradmin->email }}" class="form-control" required  placeholder="Enter Customer Admin Emain" data-error=".errorTxt3" autocomplete="off" autofocus="off">
                                <div class="errorTxt3 text-danger">{{ ($errors->has('email'))?$errors->first('email'):''}}</div>
                            </div>
                           
                        </div>
                       
                        <div class="row">
                            <div class=" form-group col-sm-6 col-md-4">
                                <label class="shift_name">Customer<span class="text-danger">*</span></label>
                                <select name="customer_id[]" disabled id="customer_id" class="form-control select" multiple   autocomplete="off" autofocus="off" data-error=".errorTxt6">
                                    @foreach($customers as $key=>$customer)
                                        <option value="{{$key}}"  {{in_array($key ,json_decode($custeradmin->customers_id ) ) ? 'selected'  : ''}} >{{$customer}}</option>
                                    @endforeach
                                </select>
                                <div class="errorTxt6 text-danger">{{ ($errors->has('customer_id'))?$errors->first('customer_id'):''}}</div>
                            </div>
                        </div>
                        
                        <div class="row mt-4 pull-right">
                            <div class="col-sm-12 ">
                                <button type="reset" class="btn btn-secondary  mb-1">
                                    <i class="fa fa-arrow-circle-left"></i>
                                    <a href="{{route('customer.login_system.index')}}" class="text-white">Back</a>
                                </button>
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </section>
    
@endsection
@section('page-script')
 <script src="{{asset('js/hvl/customermaster/create.js')}}"></script>
 <script>
 $(document).ready(function () {
            $('.select').multiselect({
                includeSelectAllOption: true,
                enableFiltering: true,
                maxHeight: 450
            });
        });
        </script>
 @endsection



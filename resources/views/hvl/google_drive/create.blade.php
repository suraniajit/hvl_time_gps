@extends('app.layout')

{{-- page title --}}
@section('title','Google Drive Create')

@section('vendor-style')

@endsection

@section('content')
<section>
    <div class="container-fluid" >
        <div id="edotor" style="overflow:hidden;height:100%"></div>
    </div>
</section>
<section>
    <div class="container-fluid">
        <div class="card">
            <div class="card-body p-4">
                <form action="{{route('google_drive.store')}}" method="post">
                    @csrf
                    <div class="row">
                        <div class="form-group col-sm-12 col-md-12">
                            <label>Mail*</label>
                            <input type="mail"  name="mail"   value="{{old('mail')}}" class="form-control" placeholder="Enter Email">
                            <div class="error text-danger" >
                                @if($errors->has('mail'))
                                    <div class="error">{{ $errors->first('mail') }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="form-group col-sm-12 col-md-12">
                            <label> Client ID*</label>
                            <input type="text"   name="client_id"  value="{{old('client_id')}}"  class="form-control" placeholder="Enter Clint Id">
                            <div class="error text-danger" >
                                @if($errors->has('client_id'))
                                    <div class="error">{{ $errors->first('client_id') }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="form-group col-sm-12 col-md-12">
                            <label> Client SECRET KEY *</label>
                            <input type="text"  name="client_secret" value="{{old('client_secret')}}" class="form-control" placeholder="Enter Clint Key" >
                            <div class="text-danger" >
                                @if($errors->has('client_secret'))
                                    <div class="error">{{ $errors->first('client_secret') }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="form-group col-sm-12 col-md-12">
                            <label>Refresh Token *</label>
                            <input type="text"  name="refresh_token" value="{{old('refresh_token')}}" class="form-control" placeholder="Enter Refresh Token" >
                            <div class="text-danger" >
                                @if($errors->has('refresh_token'))
                                    <div class="error">{{ $errors->first('refresh_token') }}</div>
                                @endif
                            </div>                 
                        </div>
                        <div class="form-group col-sm-12 col-md-12">
                            <label>Folder Path *</label>
                            <input type="text"  name="folder_path" value="{{old('folder_path')}}" class="form-control" placeholder="Enter Folder Path" >
                            <div class="text-danger" >
                                @if($errors->has('folder_path'))
                                    <div class="error">{{ $errors->first('folder_path') }}</div>
                                @endif
                            </div>                 
                        </div>
                        <div class="form-group col-sm-12 col-md-12">
                            <label>Defualt Connect</label>
                            <select class="form-control" name="default_connect"  class="form-control" autocomplete="off" autofocus="off" data-error=".errorTxt6">
                                    <option value="0" {{(old('default_connect')==0)?'select':''}} >No</option>
                                    <option value="1" {{(old('default_connect')==1)?'select':''}}>Yes</option>
                            </select>
                            <div class="text-danger" ></div>
                        </div>
                    </div>
                    <div class="row mt-4 pull-right">
                        <div class="col-sm-12 ">
                            <button class="btn btn-primary mr-2" type="submit" id="submit" >
                                <i class="fa fa-save"></i>
                                Save
                            </button>
                            <a href="{{route('google_drive.index')}}" class="text-white btn btn-secondary  mb-1">
                                <i class="fa fa-arrow-circle-left"></i>
                                Cancel
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
<section>
@endsection
@section('page-script')

@endsection


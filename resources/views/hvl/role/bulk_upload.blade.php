@extends('app.layout')
@section('title','Dashboard | Asset Management')
@section('vendor-style')
@endsection
@section('content')
<section>
    <div class="container-fluid">
        <header>
            <div class="row">
                <div class="col-md-4">
                    <h2 class="h3 display">Role Bulk Upload</h2>
                </div>
            </div>
        </header>
        <!-- Page Length Options -->
        <div class="card">
            <div class="card-body">
                <form class="form-horizontal well" action="{{route('admin.role_bulkupload.save')}}"
                    method="post" name="upload_excel" enctype="multipart/form-data">
                    @csrf
                        <div class="form-group">
                        <label for="exampleFormControlFile1">Excel File</label>
                        (<a href="{{asset('example/bulkupload/role.xlsx')}}">Example File</a>)
                        <input type="file" required name="excel_file" class="form-control-file">
                    </div>
                    <div class="form-group">
                        <button class="btn btn-primary" type="submit">Start</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection

@extends('app.layout')

{{-- page title --}}
@section('title','Activity Management | HVL')

@section('vendor-style')

@endsection
@section('content')
    <div class="col-sm-12 col-md-6">
        <form action="{{ route('activity-import-excel') }}" method="POST" name="importform" enctype="multipart/form-data">
            @csrf
            <input type="file" name="import_file" class="form-control">
            <br>
            <button class="btn btn-success">Import File</button>
        </form>
    </div>
@endsection

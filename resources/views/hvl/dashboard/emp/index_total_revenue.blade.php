@extends('app.layout')

{{-- page title --}}
@section('title','User Management | HVL')

@section('content')

<section>
    <div class="container-fluid">
        <header>
            <div class="row">
                <div class="col-md-7">
                    <h2 class="h3 display">Employess Total Revenue{{$total_revenue}}</h2>
                </div>
            </div>
        </header>

        <!-- Page Length Options -->
        <div class="card">
            @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show center-block" role="alert">
                <strong>{!! \Session::get('success') !!} </strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            @endif
            <div class="card-body">
                <div class="table-responsive">
                    <table id="page-length-option" class="table table-striped table-hover multiselect">
                        <thead>
                            <tr>
                                <th>Revenue Name</th>
                                <th>Revenue</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($total_revenue_details as $key => $total_revenue_detail)
                            <tr>
                                <td>
                                    {{$total_revenue_detail->last_company_name}}
                                </td>
                                <td>
                                    {{$total_revenue_detail->revenue}}

                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@section('page-script')

@endsection

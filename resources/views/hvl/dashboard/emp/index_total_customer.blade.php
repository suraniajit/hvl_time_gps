@extends('app.layout')

{{-- page title --}}
@section('title','Employess Total Customer | HVL')

@section('content')

<section>
    <div class="container-fluid">
        <header>
            <div class="row">
                <div class="col-md-7">
                    <h2 class="h3 display">Employess Total Customer {{$totalCustomer}}</h2>
                </div>
            </div>
        </header>

        <!-- Page Length Options -->
        <div class="card">
          
            <div class="card-body">
                <div class="table-responsive">
                    <table id="page-length-option" class="table table-striped table-hover multiselect">
                        <thead>
                            <tr>
                                <th>customer_id</th>
                                <th>customer Name</th>
                                <th>customer Name</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($customer_employees_details as $key => $customer_employees_detail)
                            <tr>
                                <td>
                                    {{$customer_employees_detail->customer_id}}
                                </td>
                                <td>
                                    <?php
                                    echo $customer_code = app('App\Http\Controllers\DashboardController')->getCustomerNameCust_id($customer_employees_detail->customer_id, 'customer_code');
                                    echo ' - ' . app('App\Http\Controllers\DashboardController')->getCustomerNameCust_id($customer_employees_detail->customer_id, 'customer_name');
                                    ?>
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

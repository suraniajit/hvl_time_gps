<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <title>HVL PEST CONTROL</title>  
    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="col-8">
                    <img src="http://hvl.probsoltech.com/img/hvl-logo.png" width="200">
                </div>
            </div>
            <hr>
            <table>
                <tr>
                    <th>Branch Name :-</th>
                    <td>{{$activity_data->branch_name}}</td>
                    <th>Site Name :-</th>
                    <td>{{$activity_data->site_name}}</td>
                </tr>
                <tr>
                    <th>Customer Address :-</th>
                    <td>{{$activity_data->customer_add}}</td>
                    <th>Contact Parsone :-</th>
                    <td>{{$activity_data->contact_parson}}</td>
                </tr>
                <tr>
                    <th>Customer Parson Mobile :-</th>
                    <td>{{$activity_data->contact_person_phone}}</td>
                    <th>Contact Parson Mail :-</th>
                    <td>{{$activity_data->contact_person_mail}}</td>
                </tr>
                <tr>
                    <th>Shipping Address :-</th>
                    <td>{{$activity_data->shipping_address}}</td>
                    <th>Service Detail :-</th>
                    <td>{{$activity_data->service_detail}}</td>
                </tr>
                <tr>
                    <th>Time In :-</th>
                    <td>{{$activity_data->service_in_time}}</td>
                    <th>Time out :-</th>
                    <td>{{$activity_data->service_out_time}}</td>
                </tr>
                <tr>
                    <th>Technican Name :-</th>
                    <td>{{$activity_data->service_technican_name}}</td>
                    <th>Client Name :-</th>
                    <td>{{$activity_data->service_client_name}} </td>
                </tr>
                <tr>
                    <th>Client Mobile :-</th>
                    <td>{{$activity_data->service_client_mobile}}</td>
                    <th>Service Date :-</th>
                    <td>{{$activity_data->date_time}} </td>
                </tr>
                <tr>
                    <th>&nbsp;</th>
                    <td>&nbsp;</td>
                    <th>Client :-</th> 
                    <td><img src="data:image/png;base64,{{ base64_encode(file_get_contents( $helper->getGoogleDriveImage($activity_data->service_client_sign_image) )) }}"  height="100"> </td>
                    {{-- <td><img src="{{$activity_data->service_client_sign_image}}"  height="100"> </td> --}}
                </tr>
            </table>
            Note : Its computer generated service report no need seal
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    </body>
</html>
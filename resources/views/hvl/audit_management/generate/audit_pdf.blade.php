<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <style>
            body {
                height: 842px;
                width: 595px;
                margin-left: auto;
                margin-right: auto;
            }
        </style>
    </head>
    <body>
        <div  id ="print_doc" class="container">
            <div class="row">
                <div class="col-8">
                    <img  width="200" src="data:image/png;base64,{{ base64_encode(file_get_contents('https://hvl.probsoltech.com/public/uploads/profile/1678275604_hvl-logo.png')) }}">

                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-8">
                    <b>Customer:<?= $customer->customer ?></b><br>
                    (<?= $customer->address ?>)
                </div>
            </div>
            <br>
            <br>

            <section>
                <div class="container-fluid">        
                    @foreach($allGenerateDetails as $key=>$allGenerateDetail)
                    <div class="card text-center shadow p-3 mb-5 bg-white rounded">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-12 col-md-11">
                                    <section>
                                        @foreach($images as $image)
                                        @if($image->generate_report_id == $allGenerateDetail->id)
                                        <img  width="300" src="data:image/png;base64,{{ base64_encode(file_get_contents( $helper->getGoogleDriveImage($image->image) )) }}">
                                        @endif
                                        @endforeach
                                    </section>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-sm-12 col-md-6">                            
                                    <b>Description</b>
                                    <?= $allGenerateDetail->description; ?>
                                </div>
                                <div class="form-group col-sm-12 col-md-6">
                                    <b>Observation</b>
                                    <?= $allGenerateDetail->observation; ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-sm-12 col-md-6">
                                    <b>Action Taken By Hvl</b>
                                    <?= $allGenerateDetail->risk; ?>
                                </div>
                                <div class="form-group col-sm-12 col-md-6">
                                    <b>Action Taken By Client</b>
                                    <?= $allGenerateDetail->action; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    <div class="card">
                        <div class="card-body">
                            <div class="">
                                <div class="row">
                                    <div class="form-group col-sm-12 col-md-3">
                                        <label>In Time<span class="text-danger">*</span></label>
                                        <input type=text value="{{$audit_general->in_time}}" disabled>
                                    </div>
                                    <div class="form-group col-sm-12 col-md-3">
                                        <label>Out Time<span class="text-danger">*</span></label>
                                        <input type=text id="out_time" value="{{$audit_general->out_time}}" disabled>
                                    </div>
                                    <div class="form-group col-sm-12 col-md-3">

                                        <img  width="100" src="data:image/png;base64,{{ base64_encode(file_get_contents( $helper->getGoogleDriveImage($audit_general->technical_signature) )) }}">

                                        <?php
                                        /*
                                          @if(file_exists(base_path($audit_general->getTechnicianSignature($audit_general->technical_signature))))
                                          <img src="{{base_path($audit_general->getTechnicianSignature($audit_general->technical_signature))}}" id="technican_sign_image" width="100"><br>
                                          @endif
                                         */
                                        ?>
                                        <?= $audit_general->technical_name ?><br>
                                        <?= $audit_general->technical_mobile ?><br>
                                        <label>Operation Manager<span class="text-danger">*</span></label><br>
                                    </div>
                                    <div class="form-group col-sm-12 col-md-3">
                                        <img  width="100" src="data:image/png;base64,{{ base64_encode(file_get_contents( $helper->getGoogleDriveImage($audit_general->client_signature) )) }}" >

                                        <?php
                                        /*
                                          @if(file_exists(base_path($audit_general->getClientSignature($audit_general->client_signature))))
                                          <img src="{{base_path($audit_general->getClientSignature($audit_general->client_signature))}}" id="client_sign_image" width="100"><br>
                                          @endif
                                         */
                                        ?>
                                        <?= $audit_general->client_name ?><br>
                                        <?= $audit_general->client_mobile ?><br>
                                        <label>Client<span class="text-danger">*</span></label><br>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </body>
</html>

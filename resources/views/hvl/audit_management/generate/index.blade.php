@extends('app.layout')
{{-- page title --}}
@section('title','Activity Management | HVL')
@section('vendor-style')
<link rel="stylesheet" href="https://cdn.datatables.net/datetime/1.1.0/css/dataTables.dateTime.min.css">
<link rel="stylesheet" href="{{asset('css/slider.css')}}">
<link rel="stylesheet" href="{{asset('css/cropper.css')}}">
<style>
    .modal {
  overflow-y:auto;
}
    .label {
      cursor: pointer;
    }

    .progress {
      display: none;
      margin-bottom: 1rem;
    }

    .alert {
      display: none;
    }

    .img-container img {
      max-width: 100%;
    }
  </style>

@endsection
@section('content')
@php
    $generate_sign_audit = false;
    $audit_generate_save =false;
    $edit_audit_generate =false;
    $delete_audit_generate =false;
@endphp
@can('take audit generate signature')
    @php
        $generate_sign_audit=true;
    @endphp 
@endcan  
@can('create_audit_generate')
    @php
        $audit_generate_save=true;
    @endphp 
@endcan
@can('edit audit_generate')
    @php
        $edit_audit_generate=true;
    @endphp 
@endcan  
@can('delete audit_generate')
    @php
        $delete_audit_generate=true;
    @endphp 
@endcan  
@php
if($audit->generated=='yes' && (! in_array(auth()->user()->id ,[1,122,184]))) {
    $delete_audit_generate = false;
    $edit_audit_generate = false;
    $audit_generate_save = false;
    $generate_sign_audit = false;
}
$entry_flag =false;
@endphp

<div class="breadcrumb-holder">
    <div class="container-fluid">
        <ul class="breadcrumb">
            <li class="breadcrumb-item active"><a href="{{route('admin.audit.index')}}">Audit Management </a></li>
            <li class="breadcrumb-item ">Audit Schedule</li>
        </ul>
    </div>
</div>
<section>
    <div class="container-fluid">
        
        <header style="padding-bottom:0px;">
            <div class="row">
                <div class="col-md-4">
                    <h2 class="h3 display" style="text-align:left">Audit Schedule</h2>
                </div>
                <div class="col-md-8">
                    @if($audit_generate_save)
                        <button type="button" id="add_generate_entry" class="btn btn-primary pull-right rounded-pill" data-toggle="modal" data-target="#audit_general_entry">+ Add</button>
                    @endif
                    
                    <a  class="btn btn-primary pull-right rounded-pill mr-2 print_button" href="{{route('admin.audit_generate.pdf',$audit_general_id)}}"  style="margin-top:0px;">
                        <i class="fa fa-download"></i> Download
                    </a>
                </div>
            </div>
        </header>
        <div class="card">
            @if(session()->has('success'))
                <div class="alert alert-success">
                    {{ session()->get('success') }}
                </div>
            @endif
            @if(session()->has('error'))
                <div class="alert alert-danger">
                    {{ session()->get('error') }}
                </div>
            @endif
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
        
        @foreach($allGenerateDetails as $key=>$allGenerateDetail)
        <div class="card text-center shadow p-3 mb-5 bg-white rounded">
            <div class="card-header">
                    @if($delete_audit_generate)
                    <a id="mass_delete_id" class="btn btn-primary pull-right rounded-pill mr-2 delete_generate_entry" style="margin-top:0px;" data-url="{{route('admin.audit_generate.delete',[$allGenerateDetail->generate_id,$allGenerateDetail->id])}}">
                        <i class="fa fa-times"></i>
                    </a>
                    @endif
                    @if($edit_audit_generate)
                        <button  class="btn btn-primary pull-right rounded-pill mr-2 edit_generate_entry" data-url="{{route('admin.audit_generate.edit',[$allGenerateDetail->generate_id,$allGenerateDetail->id])}}" style="margin-top:0px;">
                            <i class="fa fa-pencil"></i>
                        </button>
                    @endif
                    
                    
                <div class="row">
                    <div class="col-12 col-md-11">
                        <section class="customer-logos slider">
                            @foreach($images as $image)
                                
                                @if($image->generate_report_id == $allGenerateDetail->id  && $image->image)
                                    <div class="slide">
                                        <img src="{{$helper->getGoogleDriveImage($image->image)}}">
                                    </div>
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
                        <?=$allGenerateDetail->description;?>
                    </div>
                    <div class="form-group col-sm-12 col-md-6">
                        <b>Observation</b>
                        <?=$allGenerateDetail->observation;?>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-sm-12 col-md-6">
                        <b>Action Taken By Hvl</b>
                        <?=$allGenerateDetail->risk;?>
                    </div>
                    <div class="form-group col-sm-12 col-md-6">
                        <b>Action Taken By Client</b>
                        <?=$allGenerateDetail->action;?>
                    </div>
                </div>
            </div>
        </div>
        @php
        $entry_flag=true;
        @endphp
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
                                <?php
                                /*
                                <img src="{{asset($audit_general->getTechnicianSignature($audit_general->technical_signature))}}" id="technican_sign_image" width="100"><br>
                                */
                                ?>
                               <img src="{{$helper->getGoogleDriveImage($audit_general->technical_signature)}}" id="technican_sign_image" width="100"><br>
                                <input type=text id="technican_name" placeholder="Name" {{($audit_general->technical_name)?'disabled':''}} value="{{$audit_general->technical_name}}"  ><br>
                                <input type="number" id="technican_mobile" placeholder="mobile" {{($audit_general->technical_mobile)?'disabled':''}} value="{{$audit_general->technical_mobile}}"  ><br>
                                <label>Operation Manager<span class="text-danger">*</span></label><br>
                                @if($generate_sign_audit)
                                    <a href='javascript:;' class="technican_sign_image_button" data-toggle="modal" data-target="#SignatureModal"> Take New Signature</a>
                                @endif

                            </div>
                            <div class="form-group col-sm-12 col-md-3">
                                <img src="{{$helper->getGoogleDriveImage($audit_general->client_signature)}}" id="client_sign_image" width="100"><br>
                                <?php /* <img src="{{asset($audit_general->getClientSignature($audit_general->client_signature))}}" id="client_sign_image" width="100"><br> */ ?>
                                <input type="text" id="client_name" placeholder="Name" {{($audit_general->client_name)?'disabled':''}} value="{{$audit_general->client_name}}"><br>
                                <input type="number" id="client_mobile" placeholder="mobile" {{($audit_general->client_mobile)?'disabled':''}} value="{{$audit_general->client_mobile}}"  ><br>
                                <input type="mail" id="client_mail" placeholder="mail" {{($audit_general->client_mail)?'disabled':''}} value="{{$audit_general->client_mail}}"><br>
                               
                                <label>Client<span class="text-danger">*</span></label><br>
                                @if($generate_sign_audit)
                                    <a href='javascript:;' class="client_sign_image_button"  data-toggle="modal" data-target="#SignatureModal"> Take New Signature</a>
                                @endif
                            </div>
                            <input type="hidden" name="user_type" id="user_type" >
                            <input type="hidden" name="image_crop_for" id="image_crop_for"  >
                            <input type="hidden" id="crop_image_path" value="">
                            <input type="hidden" id="technican_sign_added" value="0">
                            <input type="hidden" id="antry_available" value="0">
                        </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="row mt-4 pull-right" style="padding:1">
                    <a href="{{ redirect()->back()->getTargetUrl() }}" class="text-white btn btn-secondary  mb-1">
                        <i class="fa fa-arrow-circle-left"></i>
                        Back
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Modal -->

    @if($audit_generate_save)
        @include('hvl.audit_management.generate.modales.add_audit')
    @endif
    @if($edit_audit_generate)
        @include('hvl.audit_management.generate.modales.edit_audit')
    @endif
    @include('hvl.audit_management.generate.modales.crop_modal')
    @if($generate_sign_audit)
    @include('hvl.audit_management.generate.modales.signature_model')
    @endif
    @include('hvl.audit_management.generate.modales.image_mark_model')
    
@endsection
@section('page-script')

<script src="{{asset('asset/signature_pad_proparty/signature_pad.umd.js.download')}}"></script>
<script src="{{asset('asset/signature_pad_proparty/app.js.download')}}"></script>
<script src="{{asset('asset/image_pad_proparty/image_pad.umd.js.download')}}"></script>
<script src="{{asset('asset/image_pad_proparty/app.js.download')}}"></script>
<script src="{{asset('js/cropper.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.6.0/slick.js"></script>
<script>
    $('.datepicker').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        todayHighlight: true
    });
    $(document).ready(function(){
        @if(!$audit_general->client_signature)
            $('#client_sign_image').hide();
        @else
            $('.client_sign_image_button').hide();
        @endif
        @if(!$audit_general->technical_signature)
            $('#technican_sign_image').hide();   
        @else
            $('.technican_sign_image_button').hide();   
        @endif
        
        $('.customer-logos').slick({
            slidesToShow: 3,
            slidesToScroll: 1,
            autoplay: true,
            autoplaySpeed: 1500,
            arrows: false,
            dots: false,
            pauseOnHover: false,
            responsive: [{
                breakpoint: 768,
                settings: {
                    slidesToShow: 4
                }
            }, {
                breakpoint: 520,
                settings: {
                    slidesToShow: 3
                }
            }]
        });
    });
</script>
<script>
$(document).ready(function(){
    @if($audit_general->technical_signature != null && isset($audit_general->technical_signature))
        $('#technican_sign_added').val(1);
    @endif
    
    @if($audit->generated !='yes')
        $('.print_button').hide();
    @endif
    
    @if($entry_flag)
        $('#antry_available').val(1);
    @endif
    @if($delete_audit_generate)
    $('.delete_generate_entry').click(function(){
        var url =$(this).attr('data-url');
        swal({
                title: "Are you sure, you want to delete? ",
                text: "You will not be able to recover this record!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Yes, delete it!",
                closeOnConfirm: false
            }, 
            function (isConfirm) {      
                var token = $("meta[name='csrf-token']").attr("content");
                $.ajax({
                    type: "POST",
                    url: url,
                    data: [], 
                    success: function(data)
                    {
                        if(data.status=="success"){
                            swal({
                                title: "Greate",
                                text: data.message,
                                showCancelButton: false,
                                showConfirmButton: true,
                                confirmButtonText: 'ok',
                                icon: "success",
                                dangerMode: false,
                                }, function () {
                                    location.reload();
                            });
                        }
                        else{
                            swal('Opps..!',data.message, "error");
                        }
                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown) { 
                        swal('Opps..!',"something went to wang", "error");
                    }  
                }); 
            });        
        });
        /*  start signature pad script*/
        $('.technican_sign_image_button').click(function(e){
            
            if($("#antry_available").val() == 0 ){
                e.stopPropagation();
                swal('Opps..!',"Must Be One Entry Add ", "error");
                e.preventDefault();
            }
            if($("#technican_name").val() == '' || $("#technican_mobile").val()== '' ){
                e.stopPropagation();
                swal('Opps..!',"Please fill Operation Manager name and mobile no", "error");
                e.preventDefault();
            }
            $('#user_type').val('technican_sign_image');
            
        });
        
        $('.client_sign_image_button').click(function(e){
            if($("#antry_available").val() == 0 ){
                e.stopPropagation();
                swal('Opps..!',"Must Be One Entry Add ", "error");
                e.preventDefault();
            }
            if($("#client_name").val() == '' || $('#technican_sign_added').val() != 1 || $("#client_mobile").val()== '' || $("#client_mail").val()== '' ){
                e.stopPropagation();
                swal('Opps..!',"Please fill Technican Detail As Well As Operation  Manager name , mobile no and mail", "error");
                e.preventDefault();
            }
            $('#user_type').val('client_sign_image');
        
        });
    @endif 
    });  
</script>
<script>
    window.addEventListener('DOMContentLoaded', function () {
        var avatar = document.getElementById('avatar');
        var image = document.getElementById('image');
        var input2 = document.getElementById('edit_input');
        var input = document.getElementById('add_input');
        var $progress = $('.progress');
        var $progressBar = $('.progress-bar');
        var $alert = $('.alert');
        var $modal = $('#crop_modal');
        var cropper;

        $('[data-toggle="tooltip"]').tooltip();

        input.addEventListener('change', function (e) {
            var files = e.target.files;
            var done = function (url) {
            input.value = '';
            image.src = url;
            $alert.hide();
            $modal.modal('show');
            };
            var reader;
            var file;
            var url;

            if (files && files.length > 0) {
            file = files[0];

            if (URL) {
                done(URL.createObjectURL(file));
            } else if (FileReader) {
                reader = new FileReader();
                reader.onload = function (e) {
                done(reader.result);
                };
                reader.readAsDataURL(file);
            }
            }
            $('#crop_modal').modal('toggle');
        });
        input2.addEventListener('change', function (e) {
            var files = e.target.files;
            var done = function (url) {
            input.value = '';
            image.src = url;
            $alert.hide();
            $modal.modal('show');
            };
            var reader;
            var file;
            var url;

            if (files && files.length > 0) {
            file = files[0];

            if (URL) {
                done(URL.createObjectURL(file));
            } else if (FileReader) {
                reader = new FileReader();
                reader.onload = function (e) {
                done(reader.result);
                };
                reader.readAsDataURL(file);
            }
            }
            $('#crop_modal').modal('toggle');
        });
        
        $modal.on('shown.bs.modal', function () {
            cropper = new Cropper(image, {
            });
        }).on('hidden.bs.modal', function () {
            cropper.destroy();
            cropper = null;
        });
        document.getElementById('crop').addEventListener('click', function () {
            var initialAvatarURL;
            var canvas;
            $modal.modal('hide');
            if (cropper) {
            canvas = cropper.getCroppedCanvas({
                width: 1500,
                height: 1500,
            });
            initialAvatarURL = avatar.src;
            $progress.show();          
            canvas.toBlob(function (blob) {
            var blob__url = window.URL.createObjectURL(blob);
                $('#crop_image_path').val(blob__url);
                image_pad.clear();
                image_pad.penColor = "rgb(255,0,0)";
                image_pad.minWidth = Math.min(3,5.3);
                image_pad.maxWidth = Math.max(3,5.3);
                $('#image_mark_modal').modal('toggle'); 
            });
            }
        });
    });
</script>

// done method define bellow
<script>
    $(document).ready(function(){
        @if($audit_generate_save) 
            $('#add_generate_entry').click(function(){
                $('#image_crop_for').val('add');
                $('#add_form_data').html('');
            });
            $('#save_audit_general').click(function(){
                var new_gallary_images = $('input[name="add_time_new_uploaded[]"]').map(function () {
                    return this.value; 
                }).get();
                var url = "{{route('admin.audit_generate.save',$audit_general->audit_id)}}"; 
                var token = $("meta[name='csrf-token']").attr("content");
                var form_data = {
                    _token:$("meta[name='csrf-token']").attr("content"), 
                    description:$('#description').val(),
                    observation:$('#observation').val(),
                    risk:$('#risk').val(),
                    action:$('#action').val(),
                    new_gallary_images:new_gallary_images
                };
                $.ajax({
                    type: "POST",
                    url: url,
                    data: form_data, 
                    success: function(data)
                    {
                        $('#audit_general_entry').modal('hide');
                        if(data.status=="success"){
                            swal({
                                title: "Greate",
                                text: data.message,
                                showCancelButton: false,
                                showConfirmButton: true,
                                confirmButtonText: 'ok',
                                icon: "success",
                                dangerMode: false,
                                }, function () {
                                    location.reload();
                            });
                        }
                        else{
                            swal('Opps..!',data.message, "error");
                        }
                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown) { 
                        swal('Opps..!',data.message, "error");
                    }  
                });
                
            });
        @endif
        @if($edit_audit_generate)
            $('.edit_generate_entry').click(function(){
                $('#image_crop_for').val('edit');
                $('#edit_form_data').html('');
                var url =$(this).attr('data-url');
                $.ajax({
                    type: "get",
                    url: url,
                    data: [], 
                    success: function(data)
                    {
                        if(data.status == 'success'){
                            $('#generat_detail_id').val(data.data.id);
                            $('#description_id').val(data.data.description);
                            $('#observation_id').val(data.data.observation);
                            $('#risk_id').val(data.data.risk);
                            $('#action_id').val(data.data.action);
                            $('#audit_general_entry_edit').modal('toggle');
                            getimagegallaryGrid();
                        }else{
                            swal('Opps..!',data.message, "error");
                        }
                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown) { 
                        swal('Opps..!',"Something Went To Wong", "error");
                    } 
                });
            });
            $('#update_audit_general').click(function(){
                var url = "{{route('admin.audit_generate.update',$audit_general->audit_id)}}"; 
                var token = $("meta[name='csrf-token']").attr("content");
                var delete_db_images = $('input[name="removeDbImage[]"]').map(function () {
                        return this.value; 
                    }).get();
                var new_db_images = $('input[name="edit_time_new_uploaded[]"]').map(function () {
                        return this.value; 
                    }).get();
                var form_data = {
                    _token:$("meta[name='csrf-token']").attr("content"),
                    generat_detail_id:$('#generat_detail_id').val(),
                    description:$('#description_id').val(),
                    observation:$('#observation_id').val(),
                    risk:$('#risk_id').val(),
                    action:$('#action_id').val(),
                    delete_db_images:delete_db_images,
                    new_db_images:new_db_images,

                };
                $.ajax({
                    type: "POST",
                    url: url,
                    data: form_data, 
                    success: function(data)
                    {
                        $('#audit_general_entry_edit').modal('hide');
                        if(data.status=="success"){
                            swal({
                                title: "Greate",
                                text: data.message,
                                showCancelButton: false,
                                showConfirmButton: true,
                                confirmButtonText: 'ok',
                                icon: "success",
                                dangerMode: false,
                                }, function () {
                                    location.reload();
                            });
                        }
                        else{
                            swal('Opps..!',data.message, "error");
                        }
                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown) { 
                        swal('Opps..!',data.message, "error");
                    }  
                });
            });
        @endif
    });
    function imageRemoveFromTempDB(event){
        var removeimageimputstring = '<input type="hidden" name="removeDbImage[]" value="'+$(event).attr('data-id')+'">';
        $('#edit_form_data').append(removeimageimputstring);
        $(event).parent().remove();
    }
    function imageRemoveFromTemp(event){
        var url="{{route('admin.audit.index').'/audit_generate/gallery/images/temp_delete'}}"
        id = $(event).attr('data-id');
        $.ajax({
                type: "post",
                url: url,
                data: {
                    id :id,
                }, 
                success: function(data){    
                    if(data.status == 'success'){
                        $(event).parent().remove();
                    }
                }
            });
    }
    function getimagegallaryGrid(){
        var audit_general_id = $('#generat_detail_id').val();
        var url="{{route('admin.audit.index')}}"+'/audit_generate/'+audit_general_id+'/images';
        $.ajax({
            type: "get",
            url: url,
            data: [], 
            success: function(data)
            {               
                if(data.status == 'success'){
                    var image_str='';
                    if(data.data.images.length>0){
                        for (i = 0; i < data.data.images.length; i++) {
                            image_str =image_str+
                                        '<div class="col-md-3" style="padding:10px;outline:dashed; outline-offset:-10px;">'+
                                                '<img  width="250" src="'+data.data.images[i].image+'">'+
                                            '<button onclick="imageRemoveFromTempDB(this)" data-id="'+data.data.images[i].id +'"'+
                                                ' class="btn btn-sm btn-primary pull-right rounded-pill">'+
                                                '<span aria-hidden="true">&times;</span>'+
                                            '</button>'+
                                        '</div>'; 
                        }
                    }else{
                        image_str='No Images Found';
                    }
                    $(".edit_time_gallery_list").html(image_str);
                }else{
                    swal('Opps..!',data.message, "error");
                }
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) { 
                swal('Opps..!',"Something Went To Wong", "error");
            } 
        });
    }
    function imageSendWavFiletoServer(wavFile){
        var formdata = new FormData();
        formdata.append("image_file", wavFile);
        formdata.append("_token", $("meta[name='csrf-token']").attr("content")); 
        var ajax = new XMLHttpRequest();
        ajax.open("POST", "{{route('admin.audit.index').'/audit_generate/gallery/images/save'}}");
        ajax.setRequestHeader('_token', $("meta[name='csrf-token']").attr("content"));
        ajax.send(formdata); 
        ajax.onreadystatechange = function(data) {
            if (this.readyState == 4 && this.status == 200) {
                const obj = JSON.parse(this.responseText);
                if(obj.status == 'success'){
                    var image_str =
                            '<div class="col-md-3" style="padding:10px;outline:dashed; outline-offset:-10px;">'+
                                    '<img width="250px" src="'+obj.data.image+'">'+
                                '<button onclick="imageRemoveFromTemp(this)" data-id="'+obj.data.temp_id+'" class="btn btn-sm btn-primary pull-right rounded-pill">'+
                                    '<span aria-hidden="true">&times;</span>'+
                                '</button>'+
                            '</div>';
                            if($('#image_crop_for').val()=='edit'){
                                var inputstr = '<input type="hidden" name="edit_time_new_uploaded[]" value="'+obj.data.image_name+'">';
                                $('#edit_form_data').append(inputstr);
                                $('.edit_time_gallery_list').append(image_str);
                            }else{
                                var inputstr = '<input type="hidden" name="add_time_new_uploaded[]" value="'+obj.data.image_name+'">';
                                $('#add_form_data').append(inputstr);
                                $('.add_time_gallery_list').append(image_str);
                            }
                    $('#image_mark_modal').modal('toggle');
                    $('#audit_general_entry').focus();
                }
            }
        };
    }
    function sendWavFiletoServer(wavFile) {
        var user_type = $('#user_type').val();
        var formdata = new FormData();
        formdata.append("image_file", wavFile);
        formdata.append("user_type",user_type);
        formdata.append("_token", $("meta[name='csrf-token']").attr("content"));
        if($('#user_type').val()=='technican_sign_image'){
           
            formdata.append("name", $("#technican_name").val());
            formdata.append("mobile", $("#technican_mobile").val());
        }else{
            formdata.append("name", $("#client_name").val());
            formdata.append("mobile", $("#client_mobile").val());
            formdata.append("mail", $("#client_mail").val());
            
        }
        var ajax = new XMLHttpRequest();
        ajax.open("POST", "{{route('admin.audit_generate.save_sign',[$audit_general->id])}}");
        ajax.setRequestHeader('_token', $("meta[name='csrf-token']").attr("content"));
        ajax.send(formdata); 
        
        ajax.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                myFunction(this);
                
            }
        };
        $('#SignatureModal').modal('toggle');

    }
    function myFunction(xml){
            var response = JSON.parse(xml.response);
            if(response.data.user_type == 'client_sign_image'){
                $("#client_sign_image").attr("src",response.data.file);
                $('#client_sign_image_file').hide();
                $("#client_sign_image").show();
                $('.client_sign_image_button').hide();
                $("#client_name").val(response.data.name);
                $("#client_name").attr("disabled",true);
                $("#client_mobile").val(response.data.mobile);
                $("#client_mobile").attr("disabled",true);
                $("#client_mail").attr("disabled",true);
                
                $('.print_button').show();    
                @if(! in_array(auth()->user()->id ,[1,122,184]))
                   
                    $('.edit_generate_entry').hide();
                    $('.delete_generate_entry').hide();
                    $('#add_generate_entry').hide();
                @endif
                $('#out_time').val(response.data.sign_time)
            }
            if(response.data.user_type == 'technican_sign_image'){
                $("#technican_sign_image").attr("src",response.data.file);
                $('#technican_sign_file').hide();
                $("#technican_sign_image").show();
                $('.technican_sign_image_button').hide();
                $("#technican_sign_added").val(1);
                
                
                $("#technican_name").val(response.data.name);
                $("#technican_name").attr("disabled",true);
                $("#technican_mobile").val(response.data.mobile);
                $("#technican_mobile").attr("disabled",true);
            }

        }
</script>

@endsection
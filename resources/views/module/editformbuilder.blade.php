@extends('app.layout')

@section('title', 'Update Module')

@section('vendor-style')
    <style>
        input[type=text]:not(.browser-default) {
            box-sizing: border-box;
        }

        .file-field input[type=file] {
            position: initial;
        }

        [type='checkbox']:not(:checked), [type='checkbox']:checked {
            opacity: 1;
            position: relative;
            pointer-events: auto;
        }

        .form-wrap.form-builder .frmb > li:first-child:hover {
            box-shadow: none;
        }

        .form-wrap.form-builder .frmb > li:first-child {
            opacity: 1;
            position: relative !important;
        }

        .form-wrap.form-builder .frmb > li:first-child > .field-actions:first-child {
            display: none !important;
        }
        input[type="checkbox"] {
            -webkit-appearance: checkbox;
            border-radius: 0;
        }
    </style>
@endsection

{{-- page content --}}
@section('content')

    <div class="breadcrumb-holder">
        <div class="container-fluid">
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{url('/module')}}">Module Management</a></li>
                <li class="breadcrumb-item active">Edit Module</li>
            </ul>
        </div>
    </div>
    <section>
        <div class="container-fluid">

            <header>
                <div class="row">
                    <div class="col-md-7">
                        <h2 class="h3 display">Edit Module</h2>
                    </div>
                    <div class="col-md-5">

                    </div>
                </div>
            </header>

            <div class="card">
                <div class="card-body p-4">
                    <div class="form-group col-sm-12 col-md-4">
                        <label for="name">Module Name</label>
                        <input id="module-name" type="text" name="name" autocomplete="off" value="{{ $module_ori->name }}" disabled>
                    </div>

                    <div class="form-group col-sm-12 col-md-12">
                        <div id="fb-editor">

                        </div>
                    </div>

                <div class="row mt-4 pull-right">
                    <div class="col-sm-12 ">
                        <button id="saveFormData" class="btn btn-primary mr-2" type="submit" name="action">
                            <i class="fa fa-arrow-circle-up"></i>
                            Update
                        </button>
                        <button type="reset" class="btn btn-secondary  mb-1">
                            <i class="fa fa-arrow-circle-left"></i>
                            <a href="{{url()->previous()}}" class="text-white">Cancel</a>
                        </button>
                    </div>
                </div>




        </div>
    </div>
</div>

@endsection


{{-- page script --}}
@section('page-script')

<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
<script src="https://formbuilder.online/assets/js/form-builder.min.js"></script>

<script>
      $(document).ready(function () {
         jQuery(function ($) {
            var options = {
                controlPosition: 'left',
                disabledActionButtons: ['data', 'save', 'clear'],
                editOnAdd: true,
                typeUserDisabledAttrs: {
                    'checkbox-group': [
                        'toggle', 'inline', 'other'
                    ],
                    'date': [
                        'value'
                    ],
                    'file': [
                        'multiple', 'subtype'
                    ],

                    'radio-group': [
                        'inline', 'other'
                    ],
                    'textarea': ['subtype'],
                    'section': ['required', 'placeholder']
                },
                disableFields: ['button', 'hidden', 'autocomplete', 'header', 'paragraph'],
                disabledAttrs: ['access', 'className', 'name', 'value', 'description'],
                disabledSubtypes: {
                    'text': ['color'],
                    'textarea': ['quill', 'tinymce'],
                    'paragraph': ['output', 'canvas', 'address'],
                    'file': ['fineuploader']
                },

                templates: {
                    lookup: function (fieldData) {
                        return {
                            field: '<input type="text" id="' + fieldData.name + '" class="form-control">',
                        }
                    },
                    multiLookup: function (fieldData) {
                        return {
                            field: '<input type="text" id="' + fieldData.name + '" class="form-control">',
                        }
                    },
                    section: function (fieldData) {
                        return {
                            field: '<h4 type="text" id="' + fieldData.name + '" class="h3 display"></h4>',
                        }
                    },
                },

                fields: [
                    {
                        label: 'Lookup',
                        attrs: {
                            type: 'lookup',
                        },
                        icon: '&',
                    },
                    {
                        label: 'Multi-select Lookup',
                        attrs: {
                            type: 'multiLookup',
                        },
                        icon: '*',
                    },
                    {
                        label: 'Section',
                        attrs: {
                            type: 'section',
                        },
                        icon: '@',
                    },


                ],

                typeUserAttrs: {
                    lookup: {
                        module: {
                            label: 'Module',
                            options: {
                                @foreach($modules as $module)
                                    '{{ $module->name }}': '{{ ucfirst($module->name) }}',
                                @endforeach
                            },
                        }
                    },
                    multiLookup: {
                        module: {
                            label: 'Module',
                            options: {
                                @foreach($modules as $module)
                                    '{{ $module->name }}': '{{ ucfirst($module->name) }}',
                                @endforeach
                            },
                        },
                        fieldName: {
                            label: 'Field Label',
                            value: '',
                            placeholder: 'Field Label in Related Module',
                            required: true
                        }
                    }

                },
                defaultFields: {!! $module_ori->form !!}
            };
            var fbEditor = $(document.getElementById('fb-editor'));
            var formBuilder = $(fbEditor).formBuilder(options);
            document.getElementById('saveFormData').addEventListener('click', function (e) {
                e.preventDefault();
                var path = $('#path').val();
                var module_name = $('#module-name').val();
                if (module_name) {

                    $.ajax({

                        url: "{{ route('module.update', $module_ori->id) }}",
                        method: 'put',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "name": module_name,
                            "path": path,
                            "form_data": formBuilder.actions.getData('json', true),
                        },
                        success: function (result) {
                            console.log(result);
                            swal({
                                title: "Module " + module_name + " Updated!",
                                text: result.message,
                                icon: 'success',
                                dangerMode: true,
                                buttons: {
                                    cancel: 'Go To Manage Module',
                                    delete: 'Go to ' + module_name
                                }
                            }).then(function (willDelete) {
                                if (willDelete) {
                                    window.location = '/modules/module/' + module_name.replace(' ', '_')
                                } else {
                                    window.location = '/module';
                                }
                            });
                        },
                        error: function (result) {
                            swal({
                                title: result.responseJSON.message,
                                icon: 'error'
                            })
                        }
                    });
                } else {
                    swal({
                        title: 'You must enter module name!',
                        icon: 'error'
                    })
                }
            });
        });

        $('.form-wrap.form-builder .frmb>li:first-child').draggable({disabled: true});
        $('.form-field').draggable({disabled: true});
        });
    </script>


@endsection

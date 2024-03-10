@extends('app.layout')

@section('title', 'Create Module')

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
                <li class="breadcrumb-item active">Create Module</li>
            </ul>
        </div>
    </div>
    <section>
        <div class="container-fluid">

            <header>
                <div class="row">
                    <div class="col-md-7">
                        <h2 class="h3 display">Create Module</h2>
                    </div>
                    <div class="col-md-5">

                    </div>
                </div>
            </header>
            <div class="card">
                <div class="card-body p-4">

                    <div class="form-group col-sm-12 col-md-4">
                        <label for="name">Module Name </label>
                        <input id="module-name" type="text" class="form-control" name="name" autocomplete="off">
                    </div>
                    <div class="form-group col-sm-12 col-md-12">
                        <div id="fb-editor">

                        </div>
                    </div>





                <div class="row mt-4 pull-right">
                    <div class="col-sm-12 ">
                        <button id="saveFormData" type="submit" name="action" class="btn btn-primary mr-2">Create
                            <i class="fa fa-save"></i>
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

    </section>


@endsection

{{-- page script --}}
@section('page-script')


    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
    <script src="https://formbuilder.online/assets/js/form-builder.min.js"></script>
    <script>
        $('.form-wrap.form-builder .frmb .form-elements [contenteditable].form-control').click(function () {
            console.log('label click');
            $('.fld-label').empty();
        });

        function setOptionValue(evt) {
            evt.target.nextSibling.value = evt.target.value;
        }

        function applyOptionChanges(option) {
            option.removeEventListener("input", setOptionValue, false);
            option.addEventListener("input", setOptionValue, false);
            option.nextSibling.style.display = "none";
            option.placeholder = "Label / Value";
        }

        function selectOptions(fld) {
            const optionLabelInputs = fld.querySelectorAll(".option-label");
            for (i = 0; i < optionLabelInputs.length; i++) {
                applyOptionChanges(optionLabelInputs[i]);
            }
        }

        function createObserver(fld) {
            const callback = function (mutationsList) {
                for (var mutation of mutationsList) {
                    selectOptions(fld);
                }
            };
            const observer = new MutationObserver(callback);
            observer.observe(fld.querySelector(".sortable-options"), {childList: true});
            return observer
        }

        function onAddOptionInput(fld) {
            selectOptions(fld);
            const observer = createObserver(fld);
            // console.log(observer)
        }

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
                            field: '<h4 type="text" id="' + fieldData.name + '" class="form-control"></h4>',
                        }
                    },
                    time: function (fieldData) {
                        return {
                            field: '<input type="time" id="' + fieldData.name + '" class="form-control">',
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
                    {
                        label: 'Time',
                        attrs: {
                            type: 'time',
                        },
                        icon: '✓',
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
                defaultFields: [{
                    className: "form-control first-module-name-class",
                    label: "Name",
                    placeholder: "Enter name",
                    name: "name",
                    required: true,
                    type: "text",
                    id: "first_module_name_id"
                }],
                typeUserEvents: {
                    "checkbox-group": {
                        onadd: onAddOptionInput
                    },
                    "radio-group": {
                        onadd: onAddOptionInput
                    },
                    select: {
                        onadd: onAddOptionInput
                    }
                }
            };
            var fbEditor = $(document.getElementById('fb-editor'));
            var formBuilder = $(fbEditor).formBuilder(options);
            document.getElementById('saveFormData').addEventListener('click', function (e) {
                e.preventDefault();
                var module_name = $('#module-name').val();
                var path = $('#path').val();
                if (module_name) {

                    $.ajax({

                        url: "{{ route('module.store') }}",
                        method: 'post',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "name": module_name,
                            "path": path,
                            "form_data": formBuilder.actions.getData('json', true),
                        },
                        success: function (result) {
                            swal({
                                    title: "Module " + module_name,
                                    text: result.message,
                                    type: 'success',
                                    showCancelButton: true,
                                    cancelButtonText:"Create New Module",
                                    confirmButtonClass: "btn-danger",
                                    confirmButtonText: "Go to "+ module_name,
                                    closeOnConfirm: false
                                },function (isConfirm) {
                                if (isConfirm) {
                                    window.location = '/modules/module/' + module_name.replace(' ', '_')
                                } else {
                                    window.location.reload()
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

    </script>

@endsection

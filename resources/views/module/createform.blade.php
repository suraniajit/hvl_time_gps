@if(isset($module_name))
    @php $tableName = $module_name; @endphp
@elseif($table_name)
    @php $tableName = $table_name; @endphp
@endif

{{--@if($tableName === 'departments' || $tableName === 'teams' || $tableName === 'designations')--}}
{{--    @php $employees = \App\Employee::all(); @endphp--}}
{{--    @if(isset($table_data))--}}
{{--        @php $employeesIn = $table->employees->pluck('id')->toArray(); @endphp--}}
{{--    @endif--}}
{{--    <div class="input-field col s6">--}}
{{--        <label for="Employees"> </label>--}}
{{--        <select name="employees[]" class="form-control selectpicker" multiple="multiple">--}}
{{--                @foreach($employees as $employee)--}}
{{--                    <option value="{{ $employee->id }}" @if(isset($employeesIn)) @if(in_array($employee->id, $employeesIn)) selected @endif @endif>--}}
{{--                        {{ $employee->Name }}--}}
{{--                    </option>--}}
{{--                @endforeach--}}
{{--        </select>--}}
{{--    </div>--}}
{{--@endif--}}

@foreach($module_form as $forms)
    @foreach(json_decode($forms->form) as $form)
                @php $field_name = str_replace(' ', '_', $form->label) @endphp
                @if($form->type === 'text')
                    <div class="form-group col-sm-12 col-md-4">
                        <label for="{{$form->label}}">
                            {{$form->label}}
                                @if($form->required === true)<span class="text-danger">*</span>@endif</label>
                        @if($form->subtype === 'text')
                            <input type="text"
                                   name="{{ str_replace(' ', '_', $form->label) }}"
                                   class="form-control @if($form->required === true) validate @endif @if(isset($form->maxlength)) maxlength @endif"
                                   @if($form->required === true) required @endif
                                   @if(isset($form->placeholder)) placeholder="{{ $form->placeholder }}" @endif
                                   @if(isset($form->maxlength)) data-length="{{ $form->maxlength }}" @endif
                                   @if(isset($table_data)) value="{{ $table_data->$field_name }}" @endif
                                   @if(isset($form->maxlength)) maxlength="{{ $form->maxlength }}" @endif
                                autocomplete="off"
                            >
                        @elseif($form->subtype === 'email')
                            <input type="email"
                                   name="{{ str_replace(' ', '_', $form->label) }}"
                                   pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,63}$"
                                   class="form-control @if($form->required === true) validate @endif
                                   @if(isset($form->maxlength)) maxlength @endif"
                                   @if($form->required === true) required @endif
                                   @if(isset($form->placeholder)) placeholder="{{ $form->placeholder }}" @endif
                                   @if(isset($form->maxlength)) data-length="{{ $form->maxlength }}" @endif
                                   @if(isset($table_data)) value="{{ $table_data->$field_name }}" @endif
                                   @if(isset($form->maxlength)) maxlength="{{ $form->maxlength }}" @endif
                                   autocomplete="off"
                            >
                        @elseif($form->subtype === 'password')
                            <input type="password"
                                   name="{{ str_replace(' ', '_', $form->label) }}"
                                   class="form-control @if($form->required === true) validate @endif @if(isset($form->maxlength)) maxlength @endif"
                                   @if($form->required === true) required @endif
                                   @if(isset($form->placeholder)) placeholder="{{ $form->placeholder }}" @endif
                                   @if(isset($form->maxlength)) data-length="{{ $form->maxlength }}" @endif
                                   @if(isset($table_data)) value="{{ $table_data->$field_name }}" @endif
                                   @if(isset($form->maxlength)) maxlength="{{ $form->maxlength }}" @endif
                                   autocomplete="off"
                            >
                        @else
                            <input type="text"
                                   name="{{ str_replace(' ', '_', $form->label) }}"
                                   class="form-control @if($form->required === true) validate @endif @if(isset($form->maxlength)) maxlength @endif"
                                   @if($form->required === true) required @endif
                                   @if(isset($form->placeholder)) placeholder="{{ $form->placeholder }}" @endif
                                   @if(isset($form->maxlength)) data-length="{{ $form->maxlength }}" @endif
                                   @if(isset($table_data)) value="{{ $table_data->$field_name }}" @endif
                                   @if(isset($form->maxlength)) maxlength="{{ $form->maxlength }}" @endif
                                   autocomplete="off"
                            >
                        @endif
                    </div>
                @elseif($form->type === 'select')
                    <div class=" form-group col-sm-12 col-md-4">
                    <label for="{{ $form->label }}">{{ $form->label }}@if($form->required === true)<span class="text-danger">*</span>@endif</label>
                        @if($form->multiple === false)
                            <select name="{{ str_replace(' ', '_', $form->label) }}"
                                    class="form-control">
                                @foreach($form->values as $option)
                                    <option
                                            value="{{ $option->label }}"
                                            @if(isset($option->selected)) selected @endif
                                            @if(isset($table_data)) @if($table_data->$field_name === $option->label) selected @endif @endif
                                    >{{ $option->label }}</option>
                                @endforeach

                            </select>
                        @else
                            <br>
                            <select name="{{ str_replace(' ', '_', $form->label) }}[]"
                                    class="form-control selecpicker" multiple="multiple">
                                <optgroup label="{{$form->label}}">
                                    @foreach($form->values as $option)
                                        <option
                                                value="{{ $option->label }}"
                                                @if(isset($option->selected))  @endif
                                                @if(isset($table_data))
                                                @php $values = explode(',', $table_data->$field_name) @endphp
                                                @foreach($values as $value)
                                                @if($option->label === $value) selected @endif
                                                @endforeach
                                                @endif
                                        >{{ $option->label }}</option>
                                    @endforeach
                                </optgroup>
                            </select>
                        @endif
                    </div>
                @elseif($form->type === 'number')
                    <div class=" form-group col-sm-12 col-md-4">
                        <label for="{{$form->label}}">{{$form->label}} @if($form->required === true)<span class="text-danger">*</span>@endif</label>
                        <input type="number"
                               name="{{ str_replace(' ', '_', $form->label) }}"
                               class="form-control @if($form->required === true) validate @endif"
                               @if($form->required === true) required @endif
                               @if(isset($form->placeholder)) placeholder="{{ $form->placeholder }}" @endif
                               @if(isset($form->min)) min="{{ $form->min }}" @endif
                               @if(isset($form->max)) max="{{ $form->max }}" @endif
                               @if(isset($form->step)) step="{{ $form->step }}" @endif
                               @if(isset($table_data)) value="{{ $table_data->$field_name }}" @endif
                               autocomplete="off"
                        >
                    </div>
                @elseif($form->type === 'textarea')
                    <div class=" form-group col-sm-12 col-md-4">
                        <label for="{{ $form->label }}" class="">{{ $form->label }} @if($form->required === true)<span class="text-danger">*</span>@endif</label>
            <textarea name="{{ str_replace(' ', '_', $form->label) }}" style="height: 47px;"
                      class="form-control @if(isset($form->maxlength)) maxlength @endif"
                      @if(isset($form->maxlength)) data-length="{{ $form->maxlength }}" @endif
                      @if(isset($form->rows)) rows="{{ $form->rows }}" @endif
                      @if($form->required === true) required @endif
                      @if(isset($form->maxlength)) maxlength="{{ $form->maxlength }}" @endif
                >@if(isset($table_data)){{ $table_data->$field_name }}@endif</textarea>
                    </div>
                @elseif($form->type === 'checkbox-group')
                    <div class="form-group col-sm-12 col-md-4">
                        <label for="{{ $form->label }}">{{ $form->label }}</label>
                        @foreach($form->values as $option)
                            <p>
                                <label>
                                    <input type="checkbox" name="{{ str_replace(' ', '_', $form->label) }}[]"
                                           value=" {{ $option->label }}" @if(isset($option->selected)) checked @endif
                                           @if(isset($option->required)) class="form-control validate" required @endif
                                           @if(isset($table_data))
                                           @php $values = explode(',', $table_data->$field_name) @endphp
                                           @foreach($values as $value)
                                           @if($option->label === $value) checked @endif
                                            @endforeach
                                            @endif
                                    />
                                    <span>{{ $option->label }} @if($form->required === true)<span class="text-danger">*</span>@endif</span>
                                </label>
                            </p>
                            <div class="input-field">
                            </div>
                        @endforeach
                    </div>
                @elseif($form->type === 'radio-group')
                    <div class="form-group col-sm-12 col-md-4">
                        <p>{{ $form->label }} </p>
                        @foreach($form->values as $option)
                            <p>
                                <label>
                                    <input name="{{ str_replace(' ', '_', $form->label) }}" type="radio"
                                           value="{{ $option->label }}"
                                           @if(isset($option->selected)) checked @endif
                                           @if(isset($table_data)) @if($table_data->$field_name === $option->label) checked @endif @endif/>
                                    <span>{{ $option->label }}</span>
                                </label>
                            </p>
                        @endforeach

                        <div class="input-field">
                            <small class="errorTxt8"></small>
                        </div>
                    </div>
                @elseif($form->type === 'date')
                    <div class=" form-group col-sm-12 col-md-4">
                        <label for="date">{{ $form->label }}</label>
                        <input type="text" class="form-control dynamic_datepicker"
                               name="{{ str_replace(' ', '_', $form->label) }}"
                               @if(isset($table_data)) value="{{ $table_data->$field_name }}" @endif autocomplete="off">
                    </div>
                @elseif($form->type === 'time')
                    <div class=" form-group col-sm-12 col-md-4">
                        <label for="time">{{ $form->label }}</label>
                        <input type="text" class="form-control timepicker"
                               name="{{ str_replace(' ', '_', $form->label) }}"
                               @if(isset($table_data)) value="{{ $table_data->$field_name }}" @endif autocomplete="off">
                    </div>
                @elseif($form->type === 'section')
                    <div class=" col-sm-12 col-md-12">
                        <div class="row">
                            <div class="form-group col-sm-12 col-md-12">
                                <h4 class="card-title">
                                    {{ $form->label }}
                                </h4>
                            </div>
                        </div>
                    </div>
                @elseif($form->type === 'lookup')

                    <div class="form-group col-sm-12 col-md-4">
                    @php $table_datas = DB::table(str_replace(' ', '_', $form->module))->get(); @endphp

                    <!--/**/-->
                    <?php
                    $cl_name = DB::table('modules')
                        ->where('modules.name', $form->module)
                        ->value('column_name');

                    $column_names = DB::table('modules')
                        ->where('modules.name', $form->module)
                        ->crossjoin($form->module)
                        ->get();
                    //            @foreach($column_names as $key => $data)
                    //            <option>
                    //            {{ $data->$cl_name}}
                    //            </option>
                    //            @endforeach
                    ?>
                    <!--/**/-->
                        <label for="{{ $form->label }}">@if($form->label == 'Select Department')
                                Departments
                            @elseif($form->label == 'Select Designation')
                                Designation
                            @elseif($form->label == 'Select Team')
                                Team
                            @elseif($form->label == 'select city')
                                City
                            @elseif($form->label == 'zone')
                                Zone
                            @else
                                {{ $form->label }}
                            @endif</label>
                        <select name="{{ str_replace(' ', '_', $form->label) }}" class="form-control">
                            <option value="" disabled="">{{ ucfirst(str_replace('_', ' ', $form->label)) }}</option>
                            @foreach($column_names as $data)
                                <option value="{{ $data->id }}" @if(isset($table_data)) @if($table_data->$field_name == $data->id) selected @endif @endif>  {{ $data->$cl_name}}</option>
                            @endforeach
                        </select>
                    </div>
                @elseif($form->type === 'multiLookup')

                    <div class="form-group col-sm-12 col-md-4">
                        @php $table_datas = DB::table(str_replace(' ', '_', $form->module))->get(); @endphp
                        <i class="fa fa-eye"></i>
                        <label for="{{ $form->label }}">{{ str_replace('_', ' ', $form->label) }}</label>
                        <br>
                        <select name="{{ str_replace(' ', '_', $form->label) }}[]" class="selecpicker form-control" multiple="multiple">
                            <optgroup label="{{$form->label}}">
                                @foreach($table_datas as $data)
                                    <option value="{{ $data->Name }}" @if(isset($table_data)) @php $values = explode(',', $table_data->$field_name) @endphp @foreach($values as $value) @if($data->Name === $value) selected @endif @endforeach @endif>{{ $data->Name }}</option>
                                @endforeach
                            </optgroup>
                        </select>
                    </div>
                @elseif($form->type === 'file')
                    <div class="form-group col-sm-12 col-md-4">
                        <div class="btn">
                            <span>{{ $form->label }}</span>
                            <input type="file" class="form-control-file" name="{{ str_replace(' ', '_', $form->label) }}">
                        </div>
                        <div class="file-path-wrapper">
                            <input class="file-path validate" type="text">
                        </div>
                        @if(isset($table_data))
                            <span>{{ $table_data->$field_name }}</span>
                        @endif
                    </div>
                @endif
    @endforeach
@endforeach

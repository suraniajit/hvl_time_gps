
<div class="row">
    @if($table_name === 'employees')
    @php $employees = \App\Employee::find($table_data->id) @endphp
    @endif
    
    <?php
    print_r($employees);
    foreach ($fields as $field) {

        $i = 0;
        foreach (json_decode($field->form) as $column) {

            if ($column->type !== 'section') {
                $f = str_replace(' ', '_', $column->label);
                ?>
                <?php
                if ($column->type === 'lookup') {
                    if ($column->module == 'shifts') {
                        $module_form = DB::table('shifts')->where('id', $table_data->$f)->value('shift_name');
                        ?>
                        <div class="input-field col s4">
                            {{ucwords(str_replace('_', ' ', $column->label)) . ' : ' . $module_form}}
                        </div>
                        <?php
                    }
                    if ($column->module == 'employee_types') {
                        $module_form = DB::table('employee_types')->where('id', $table_data->$f)->value('Name');
                        ?>
                        <div class="input-field col s4">
                            {{ucwords(str_replace('_', ' ', $column->label)) . ' : ' . $module_form}}
                        </div>
                        <?php
                    }
                    if ($column->module == 'designations') {
                        $module_form = DB::table('designations')->where('id', $table_data->$f)->value('Name');
                        ?>
                        <div class="input-field col s4">
                            {{ucwords(str_replace('_', ' ', $column->label)). ' : ' . $module_form}}
                        </div>
                        <?php
                    }
                    if ($column->module == 'teams') {
                        $module_form = DB::table('teams')->where('id', $table_data->$f)->value('Name');
                        ?>
                        <div class="input-field col s4">
                            {{ucwords(str_replace('_', ' ', $column->label)) . ' : ' . $module_form}}
                        </div>
                        <?php
                    }
                    if ($column->module == 'departments') {
                        $module_form = DB::table('departments')->where('id', $table_data->$f)->value('Name');
                        ?>
                        <div class="input-field col s4">
                            {{ucwords(str_replace('_', ' ', $column->label)) . ' : ' . $module_form}}
                        </div>
                        <?php
                    }
                    if ($column->module == 'employees') {
                        $module_form = DB::table('employees')->where('id', $table_data->$f)->value('Name');
                        ?>
                        <div class="input-field col s4">
                            {{ucwords(str_replace('_', ' ', $column->label)) . ' : ' . $module_form}}
                        </div>
                        <?php
                    }
                } else {
                    ?>
                    <div class="input-field col s4">
                        {{ str_replace('_', ' ', $column->label) }} :  {{ $table_data->$f }}
                    </div>
                    <?php
                }
            }
            $i++;
        }
    }
    ?>
    <div class="input-field col s4">
        Shift :  
        <?php
//echo $table_data->user_id;
        $getshiftNameUser_id = app('App\Http\Controllers\hrms\ShiftController')->getshiftNameUser_id($table_data->user_id);
//print_r($getshiftNameUser_id);
        if (count($getshiftNameUser_id) > 0) {
//    echo 'shoft have';
            echo $getshiftNameUser_id[0]->Name;
        } else {
            echo 'Not assgin';
        }
        ?>

        <?php
        ?>
    </div>
</div>

<?php
foreach (json_decode($field->form) as $column) {
    if ($column->type !== 'section') {
        $f = str_replace(' ', '_', $column->label);
        ?>
        <?php
        if ($column->type === 'lookup') {
            if ($column->module == 'shifts') {
                $module_form = DB::table('shifts')->where('id', $table_data->$f)->value('shift_name');
                ?>
                <div class="col-sm-12 col-md-4">
                    {{ucwords(str_replace('_', ' ', $column->label)) . ' : ' . $module_form}}
                </div>
                <?php
            }
            if ($column->module == 'employee_types') {
                $module_form = DB::table('employee_types')->where('id', $table_data->$f)->value('Name');
                ?>
                <div class="col-sm-12 col-md-4">
                    {{ucwords(str_replace('_', ' ', $column->label)) . ' : ' . $module_form}}
                </div>
                <?php
            }
            if ($column->module == 'designations') {
                $module_form = DB::table('designations')->where('id', $table_data->$f)->value('Name');
                ?>
                <div class="col-sm-12 col-md-4">
                    {{ucwords(str_replace('_', ' ', $column->label)). ' : ' . $module_form}}
                </div>
                <?php
            }
            if ($column->module == 'teams') {
                $module_form = DB::table('teams')->where('id', $table_data->$f)->value('Name');
                ?>
                <div class="col-sm-12 col-md-4">
                    {{ucwords(str_replace('_', ' ', $column->label)) . ' : ' . $module_form}}
                </div>
                <?php
            }
            if ($column->module == 'departments') {
                $module_form = DB::table('departments')->where('id', $table_data->$f)->value('Name');
                ?>
                <div class="col-sm-12 col-md-4">
                    {{ucwords(str_replace('_', ' ', $column->label)) . ' : ' . $module_form}}
                </div>
                <?php
            }
            if ($column->module == 'employees') {
                $module_form = DB::table('employees')->where('id', $table_data->$f)->value('Name');
                ?>
                <div class="col-sm-12 col-md-4">
                    {{ucwords(str_replace('_', ' ', $column->label)) . ' : ' . $module_form}}
                </div>
                <?php
            }
        } else {
            ?>
            <div class="col-sm-12 col-md-4">
                {{ str_replace('_', ' ', $column->label) }} :  {{ $table_data->$f }}
            </div>
            <?php
        }
    }
    $i++;
}
?>

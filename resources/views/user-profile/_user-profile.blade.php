<style>
    thead{
        background-color: gainsboro;
    }
</style>
<div class="card-panel">
    @include('user-profile._header')
 
    
    <?php if (Session::get('user_id') != '1') { ?>

        <div class="row">
            <?php
            $i = 0;
            if (count($module_form) > 0) {
                ?>

                <!--foreach($module_form as $field)-->

                <!--include('module._emp-detail')-->

                <!--endforeach-->
                <!--                <div class="input-field col s4">
                                    Shift :  
                <?php
//echo $table_data->user_id;
//                    $getshiftNameUser_id = app('App\Http\Controllers\hrms\ShiftController')->getshiftNameUser_id(Session::get('user_id'));
////print_r($getshiftNameUser_id);
//                    if (count($getshiftNameUser_id) > 0) {
////    echo 'shoft have';
//                        echo $getshiftNameUser_id[0]->Name;
//                    } else {
//                        echo 'Not assgin';
//                    }
                ?>
                
                                 
                                </div>-->
            <?php } else { ?>
                @include('module.admin-profile')

            <?php } ?>
        </div>

    <?php } ?>
</div>



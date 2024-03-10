<div class="row">



    <form method="post" id="upload_form" enctype="multipart/form-data">   

        <div class="col s8">
            <div class="display-flex">
        <!--        <span id="uploaded_image"></span>-->
                <img src="{{asset('public/profile/'.$user['profile_image'])}}" class="border-radius-4" alt="profile image" height="75" width="75" />

                {{ csrf_field() }}
                <input type="hidden" name="user_id" id="user_id" value="<?php echo $user['id']; ?>" height="75" width="75" >
                <div class="media-body">
                    <div class="general-action-btn">
                        <input type="file" name="select_file" id="select_file" />
                        <input type="submit" value="Upload" class="btnSubmit btn-small btn-color" />

                    </div> 
                    <small>Allowed JPG, PNG. Max size of 1 MB ({{ucfirst($users_roles_name[0]->user_role)}} Role) <?php echo $user['id']; ?></small>
                    <div class="image123 alert" id="message" style="display: none"></div>      
                    <div class="upfilewrapper">
                        <input id="upfile" type="file">
                    </div>
                </div>

            </div>
        </div>
        <div class="col s4">
            <?php

            use Carbon\Carbon;

$today = Carbon::today()->format('Y-m-d');

//            $today = '2021-07-20';
//            $querys = DB::table('shift_employee')
//                    ->select('shift_dates.dates as dates')
//                    ->where('shift_employee.employee_id', '=', $user['id'])
//                    ->where('shift_dates.dates', '=', $today)
//                    ->join('shift_dates', 'shift_dates.shift_id', '=', 'shift_employee.shift_id')
//                    ->first();
            $querys = app('App\Http\Controllers\hrms\ShiftController')->checkshiftDates($user['id'], $today);
            if (isset($querys)) {
                echo $today . ' <br>Today is your shift';
            } else {
                echo $today . ' <br>Today is your Not shift';
            }
            ?>

        </div>

    </form>
</div> 
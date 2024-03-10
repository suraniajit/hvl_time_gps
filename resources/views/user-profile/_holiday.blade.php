<div class="card-panel">

    <div>
        <h4 class="title-color"><span>Holidays</span></h4>
        <table class="display striped">
            <thead>
                <tr>
                    <th style="width: 5%;text-align: center;">ID</th>
                    <th>Holiday Name</th>
                    <th>Date</th>
                    <td>Action</td>

                </tr>
            </thead>
            <tbody>
                @foreach($holidays as $key=>$holiday)
                <?php
                $holiday_approved = App\Http\Controllers\hrms\LeaveRequestController::holiday_leave_checking(Session::get('user_id'), $holiday->date);
                ?>

                <tr>
                    <td style="text-align: center;">{{++$key}}</td>
                    <td>{{$holiday->name}}</td>
                    <td>{{$holiday->date}}</td>
                    <td>
                        <?php
                        if ($holiday_approved == $holiday->date) {
                            ?>
                            <span class="badge green" style="width:79px;height: 24px;">Used</span>
                            <?php
                        } else {
                            ?>
                            <a href="{{route('holiday.leave',['id'=>$id,'date'=>$holiday->date])}}">
                                <span class="badge black" style="width:79px;height: 24px;">Apply</span>
                            </a>
                            <?php
                        }
                        ?>

                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
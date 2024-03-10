<div class="card-panel">



    <div>
        <h4 class="title-color">Attendance Summary</h4>
        
            <table class="display striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Date</th>
                        <th>Check In time</th>
                        <th>Check Out time</th>
                        <th>Total Hours</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody> <?php $i = 1 ?>
                    @foreach($attendance_table_data as $Details)
                    <tr>
                        <td>{{$i}}</td>
                        <td>{{$Details->date}}</td>
                        <td>{{$Details->check_in}}</td>
                        <td>{{$Details->check_out}}</td>
                        <td>{{$Details->total_hours}}</td>
                        <td>
                            <?php
                            if ($Details->status == '3') {
                                echo 'Inchecking';
                            } elseif ($Details->status == '2') {
                                echo 'Late Checkin Penalty';
                            } elseif ($Details->status == '1') {
                                echo 'Present';
                            } elseif ($Details->status == '0') {
                                echo 'Absent';
                            } else {
                                echo '**';
                            }
                            ?>
                        </td>
                        <?php $i++ ?>
                    </tr>

                    @endforeach


                </tbody>
            </table>
    </div>

</div>

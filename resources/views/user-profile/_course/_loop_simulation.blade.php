<?php
foreach ($SimulatedCourseDetails as $key => $SimualtionDetails) {
    $getresultby_SimulationId_emp_id_sumul = app('App\Http\Controllers\UserProfileController')->getresultby_SimulationId_emp_id($user['id'], $SimualtionDetails->course_id);
    $get_result_history_simulation = app('App\Http\Controllers\training\EmployeeSimulationCourseController')->get_result_history_simulation($user['id'], $SimualtionDetails->course_id);
    $get_result_history_simulation = count($get_result_history_simulation);
    ?>
    <tr>

        <td>
            <a href="/training/employee_simulation_course_single/{{$SimualtionDetails->course_id}}" target="_blank">
                {{ucfirst($SimualtionDetails->course_name)}}
            </a> 
        </td>

        <td>{{$SimualtionDetails->end_date}}</td>
        <td style="text-align: center;">{{$SimualtionDetails->pass_criteria}}</td>
        <td style="text-align: center;">{{$SimualtionDetails->add_pass_criteria}}</td>
        <?php
        if (count($getresultby_SimulationId_emp_id_sumul) > 0) {
            if ($getresultby_SimulationId_emp_id_sumul[0]->passing_status == 'Pass') {
                ?>
                <td>
                    <a href="training/simulation/UserResult/{{$user['id']}}/courseId/{{$SimualtionDetails->course_id}}">
                        <?php echo $getresultby_SimulationId_emp_id_sumul[0]->passing_status; ?>
                    </a> 
                </td>
                <td>
                    <?php
                    if ($getresultby_SimulationId_emp_id_sumul[0]->new_marks != '0.00') {
                        echo $getresultby_SimulationId_emp_id_sumul[0]->new_marks;
                    } else {
                        echo $getresultby_SimulationId_emp_id_sumul[0]->marks_obtain;
                    }
                    ?>
                </td>
                <td style="text-align: center;">
                    <!--++-->
                    <?php // echo $getresultby_SimulationId_emp_id_sumul[0]->user_attempts; ?>
                    <?php echo $get_result_history_simulation; ?>
                </td>
                <?php
            } elseif ($getresultby_SimulationId_emp_id_sumul[0]->passing_status == 'Fail') {
                ?>
                <td>
                    <a href="training/simulation/UserResult/{{$user['id']}}/courseId/{{$SimualtionDetails->course_id}}">
                        <?php echo $getresultby_SimulationId_emp_id_sumul[0]->passing_status; ?>
                    </a> 
                </td>
                <td>
                    <?php
                    if ($getresultby_SimulationId_emp_id_sumul[0]->new_marks != '0.00') {
                        echo $getresultby_SimulationId_emp_id_sumul[0]->new_marks;
                    } else {
                        echo $getresultby_SimulationId_emp_id_sumul[0]->marks_obtain;
                    }
                    ?>    
                </td>
                <td style="text-align: center;">
                    <!--**-->
                    <?php // echo $getresultby_SimulationId_emp_id_sumul[0]->user_attempts; ?>
                    <?php echo $get_result_history_simulation; ?>
                </td>
                <?php
            } else {
                echo '<td></td>';
                echo '<td></td>';
                echo '<td></td>';
            }
        } else {
            echo '<td></td>';
            echo '<td></td>';
            echo '<td style="text-align: center;">';
            if ($get_result_history_simulation > 0) {
                echo $get_result_history_simulation;
            } else {
//                echo '-';
            }
//            $getresultby_SimulationId_emp_id_sumul[0]->user_attempts .
            echo '</td>';
        }
        ?>


        <td>

            <?php $bttn = 0; ?>
            @if(!$EmployeeSimulatedCourses->isEmpty())
            @foreach($EmployeeSimulatedCourses as $status)
            @if($status->course_id == $SimualtionDetails->course_id)
            <?php $bttn = 1; ?>
            @endif
            @endforeach
            @if($bttn == 1)


            <?php
            if (count($getresultby_SimulationId_emp_id_sumul) > 0) {
                if ($getresultby_SimulationId_emp_id_sumul[0]->passing_status == 'Pass') {
                    echo 'Completed';
                } elseif ($getresultby_SimulationId_emp_id_sumul[0]->passing_status == 'Fail') {
                    ?>
                    <a href="{{route('training.simulation.retakecourse',['employee_id'=>$user['id'],'course_id'=>$SimualtionDetails->course_id])}}">Re-Take</a>
                    <?php
                } else {
                    ?>
                    <a href="{{route('training.simulation.employee_simulation_course_start',['id'=>$SimualtionDetails->course_id])}}">
                        In Progress
                    </a>
                    <?php
                }
            } else {
                ?>
                <a href="{{route('training.simulation.employee_simulation_course_start',['id'=>$SimualtionDetails->course_id])}}">
                    In Progress
                </a>
                <?php
            }
            ?>

            @elseif($bttn != 1)
            <a href="{{route('training.simulation.employee_simulation_course_start',['id'=>$SimualtionDetails->course_id])}}">
                Not Started
            </a>
            @endif
            @else
            <a href="{{route('training.simulation.employee_simulation_course_start',['id'=>$SimualtionDetails->course_id])}}">
                Not Started
            </a>
            @endif


        </td>
    </tr>
<?php } ?>
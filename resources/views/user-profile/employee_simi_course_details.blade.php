<?php
$getMyTeamSimulatedCourse_SMIN_POP = app('App\Http\Controllers\UserProfileController')->getMyTeamSimulatedCourse($details->user_id);
foreach ($getMyTeamSimulatedCourse_SMIN_POP as $key => $Crsdetails_smi) {

    $getresultby_SimulationId_emp_id_sumul = app('App\Http\Controllers\UserProfileController')->getresultby_SimulationId_emp_id($details->user_id, $Crsdetails_smi->course_id);
    $get_result_history_simulation = app('App\Http\Controllers\training\EmployeeSimulationCourseController')->get_result_history_simulation($details->user_id, $Crsdetails_smi->course_id);
    $get_result_history_simulation = count($get_result_history_simulation);
    ?>
    <tr>
        <td>
            <strong>
                Simulation Course
            </strong>
        </td>
        <td>{{$Crsdetails_smi->course_name}}</td>
        <td>{{$Crsdetails_smi->end_date}}</td>
        <td style="text-align: center;">{{$Crsdetails_smi->pass_criteria}}</td>
        <td style="text-align: center;">{{$Crsdetails_smi->add_pass_criteria}}</td>
        <?php
        if (count($getresultby_SimulationId_emp_id_sumul) > 0) {
            if ($getresultby_SimulationId_emp_id_sumul[0]->passing_status == 'Pass') {
                ?>
                <td>
                    <?php echo $getresultby_SimulationId_emp_id_sumul[0]->passing_status; ?>
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
                    <?php echo $getresultby_SimulationId_emp_id_sumul[0]->user_attempts; ?>
                </td>
                <?php
            } elseif ($getresultby_SimulationId_emp_id_sumul[0]->passing_status == 'Fail') {
                ?>
                <td>
                    <?php echo $getresultby_SimulationId_emp_id_sumul[0]->passing_status; ?>

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



            <?php
            $bttn = 0;
            $EmployeeSimulatedCourses_pop = app('App\Http\Controllers\UserProfileController')->getResumeEmployeeSimulatedCourse_pop($details->user_id);
            ?>

            @if(!$EmployeeSimulatedCourses_pop->isEmpty())
            @foreach($EmployeeSimulatedCourses_pop as $status)
            @if($status->course_id == $Crsdetails_smi->course_id)
            <?php $bttn = 1; ?>
            @endif
            @endforeach

            <?php
            if ($bttn == 1) {
                if (count($getresultby_SimulationId_emp_id_sumul) > 0) {
                    if ($getresultby_SimulationId_emp_id_sumul[0]->passing_status == 'Pass') {
                        echo 'Completed';
                    } elseif ($getresultby_SimulationId_emp_id_sumul[0]->passing_status == 'Fail') {
                        echo 'Re-Take';
                    } else {
                        echo 'In Progress';
                    }
                } else {
//                    echo 'Completed**';
                    echo 'In Progress';
                }
            } else {
                echo 'not started';
            }
            ?>
            @endif
        </td>
    </tr>
    <?php
}
?>





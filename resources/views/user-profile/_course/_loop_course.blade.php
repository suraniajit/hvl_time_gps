<?php

foreach ($CourseDetails as $key => $CouDetails) {
    $getresultby_CourseId_emp_id = app('App\Http\Controllers\UserProfileController')->getresultby_CourseId_emp_id($CouDetails->user_id, $CouDetails->course_id);
    $get_result_history = app('App\Http\Controllers\training\EmployeeCourse')->get_result_history($CouDetails->user_id, $CouDetails->course_id);
    $get_result_history_count = count($get_result_history);
    ?>
    <tr>
        <td>
            <a href="/training/employee_course_single/{{$CouDetails->course_id}}" target="_blank">
                {{ucfirst($CouDetails->course_title)}}
            </a> 
        </td>
        <!--<td>{{$CouDetails->category_name}}</td>-->
        <td>{{$CouDetails->end_date}}</td>
        <td style="text-align: center;">{{$CouDetails->pass_criteria}}</td>
        <td style="text-align: center;">{{$CouDetails->add_pass_criteria}}</td>

        <?php
//        print_r($get_result_history);

        if (count($getresultby_CourseId_emp_id) > 0) {
            if ($getresultby_CourseId_emp_id[0]->passing_status == 'Pass') {
                ?>
                <td>
                    <a href="/training/UserResult/{{$CouDetails->user_id}}/courseId/{{$CouDetails->course_id}}">
                        <?php echo 'Pass'; ?>
                    </a>   
                </td>
                <td>
                    <?php
                    if ($getresultby_CourseId_emp_id[0]->new_marks != '0.00') {
                        echo $getresultby_CourseId_emp_id[0]->new_marks;
                    } else {
                        echo $getresultby_CourseId_emp_id[0]->marks_obtain;
                    }
                    ?>
                </td>
                <td style="text-align: center;">
                    <?php echo $getresultby_CourseId_emp_id[0]->user_attempts; ?>
                </td>

            <?php } elseif ($getresultby_CourseId_emp_id[0]->passing_status == 'Fail') { ?>

                <td> 
                    <a href="/training/UserResult/{{$CouDetails->user_id}}/courseId/{{$CouDetails->course_id}}">
                        <?php echo 'Fail'; ?>
                    </a> 
                </td>
                <td>
                    <?php
                    if ($getresultby_CourseId_emp_id[0]->new_marks != '0.00') {
                        echo $getresultby_CourseId_emp_id[0]->new_marks;
                    } else {
                        echo $getresultby_CourseId_emp_id[0]->marks_obtain;
                    }
                    ?>
                </td>
                <td style="text-align: center;">
                    <?php
                    if ($get_result_history_count > 0) {
                        echo $data = $get_result_history_count;
                    } else {
                        echo $getresultby_CourseId_emp_id[0]->user_attempts;
                    }
                    ?>
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
//            if user was retack and attemps calculation
            if (count($get_result_history) > 0) {
                echo count($get_result_history);
            } else {
                //echo '0';
            }
            echo '</td>';
        }
        ?>

        <td>
            <!--1: start (in progress) | 0: not start || notstart-->
            <?php
            $course_status = 0;
            foreach ($CourseStatuses as $num => $status) {
                if ($CouDetails->course_id == $status->course_id) {
                    $course_status = 1;
                }
            }
            foreach ($CourseResults as $res => $result) {
                if ($CouDetails->course_id == $result->course_id) {
                    $course_status = 2;
                }
            }
            if ($course_status == 1) {
//                            echo '<span>In Progress</span>';

                /* waiting for reslut logic start */
                $getStatusof_Checked_Audio = DB::table('user_audio_answers')
                        ->where('course_id', '=', $CouDetails->course_id)
                        ->where('user_id', '=', $CouDetails->user_id)
                        ->where('result', '=', null)
                        ->count();
                /* waiting for reslut logic end */


                $CourseMediaDetails = DB::table('train_course_media')
                        ->where('course_id', '=', $CouDetails->course_id)
                        ->whereNull('deleted_at')
                        ->where('is_active', '=', '0')
                        ->get()
                        ->groupBy('set_id');
                $CompletedQuestionnires = DB::table('user_questionnaire_answers')
                        ->select('set_name', DB::raw('count(*) as total'))
                        ->where('user_id', '=', $CouDetails->user_id)
                        ->where('course_id', '=', $CouDetails->course_id)
                        ->groupBy('set_name')
                        ->get();

                $Total_questionaire = '';
                /* getting the total number of questionnaire and fetchng user completed questionnaire */
                foreach ($CourseMediaDetails as $Coursemedia => $Medias) {
                    $totalquestionnaire[] = count(json_decode($Medias[0]->questionnaire_ids));
                }
                if (!empty($totalquestionnaire)) {
                    $Total_questionaire = array_sum($totalquestionnaire);
                }
                $GetUserQuestionnaire = DB::table('user_questionnaire_answers')
                        ->where('course_id', '=', $CouDetails->course_id)
                        ->where('user_id', '=', $CouDetails->user_id)
                        ->count();



//                echo 'Total' . $Total_questionaire;
//                echo '<br>complietd' . $GetUserQuestionnaire;
//                echo '<br>';

                if ($getStatusof_Checked_Audio > 0) {
//                    echo 'Audio - Not Approved';
                    ?>
                    <a href="/training/employee_course_single/{{$CouDetails->course_id}}">Audio - Not Approved</a>
                    <?php
                } elseif ($Total_questionaire !== $GetUserQuestionnaire) {
//                    echo 'In Progress***';
                    ?>
                    <a href="/training/employee_course_single/{{$CouDetails->course_id}}">In Progress</a>

                    <?php
                } else {
                    echo 'Completed';
                }

//                if ($Total_questionaire === $GetUserQuestionnaire) {
//                    echo 'Complited';
//                } else if ($getStatusof_Checked_Audio > 0) {
//                    echo 'Audio - Not Approved';
//                } else {
//                    echo 'In Progress***';
//                }
                ?>



                <?php
            } else if ($course_status == 2) {

                if (count($getresultby_CourseId_emp_id) > 0) {
                    if ($getresultby_CourseId_emp_id[0]->passing_status == 'Pass') {
                        echo '<span >Completed</span>';
                        ?>
                        <?php
                    } elseif ($getresultby_CourseId_emp_id[0]->passing_status == 'Fail') {
                        ?>
                        <a href="/training/retakecourse/{{$CouDetails->user_id}}/courseId/{{$CouDetails->course_id}}"><span>
                                Retake 
                                <?php
                                if ($get_result_history_count > 0) {
//                                    echo $data = $get_result_history_count;
                                } else {
//                                    echo $data = 0;
                                }
                                ?>
                            </span></a>
                        <?php
                    } else {
                        echo 'Result Wait' . '<br>';
                    }
                } else {
//                            echo 'not found' . '<br>';
                }
            } else {
                ?>
                <a href="/training/employee_course_single/{{$CouDetails->course_id}}"><span> Not Started </span> </a>
            <?php } ?>
        </td>
    </tr>
<?php } ?>
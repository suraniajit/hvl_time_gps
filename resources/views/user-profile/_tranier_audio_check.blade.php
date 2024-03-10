<style>


    /* Style the tab */
    .tab {
        overflow: hidden;
        /*            border: 1px solid #ccc;
                    background-color: #f1f1f1;*/
    }

    /* Style the buttons inside the tab */
    .tab button {
        background-color: inherit;
        float: left;
        border: none;
        outline: none;
        cursor: pointer;
        padding: 14px 16px;
        transition: 0.3s;
        font-size: 17px;
    }

    /* Change background color of buttons on hover */
    .tab button:hover {
        background-color: #ddd;
    }

    /* Create an active/current tablink class */
    .tab button.active {
        background-color: #ccc;
    }

    /* Style the tab content */
    .tabcantent_audio {
        display: none;
        padding: 6px 12px;
        /*            border: 1px solid #ccc;
                    border-top: none;*/
    }
</style>

<div class="card-panel">
    <h4 class="title-color"><span>Course's Audio</span></h4>
    <div class="tab">
        <button class="tablink_audio" style=" border: 1px solid #ccc;" onclick="checkAudio(event, 'audio_for_checking')" id="defaultOpen_audio_check">User Audio</button>
        <button class="tablink_audio" style=" border: 1px solid #ccc;" onclick="checkAudio(event, 'audio_history')" >History</button>
    </div>

    <div id="audio_for_checking" class="tabcantent_audio">
        <!--<h2>Course</h2>-->
        <?php if (count($AudioDetails) > 0) { ?>


            <table class="display striped">
                <thead>
                    <tr>
                        <th>Course Name</th>
                        <th>Total Audio</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($AudioDetails as $key => $AudioDeta) { ?>
                        <tr>
                            <th>{{$AudioDeta[0]->course_title}}</th>
                            <th>{{count($AudioDeta)}}</th>
                            <th>
                                <a href="/training/employee_audios/{{$AudioDeta[0]->uid}}/course_id/{{$AudioDeta[0]->course_id}}">View</a>
                            </th>

                        </tr>
                    <?php } ?>
                </tbody>
            </table>


        <?php } else { ?>
            <div class="row">
                <div class="col 12">
                    <h6 class="title-color">You Have no Pending Audios</h6>
                </div>
            </div>
        <?php } ?>
    </div>
    <div id="audio_history" class="tabcantent_audio">
        <!--<h2>Course</h2>-->
        <table class="display striped">

            <?php
            $show_traniner_checked_history = App\Http\Controllers\training\EmployeeCourse::show_traniner_checked_history(Session::get('user_id'));

            if (count($show_traniner_checked_history) > 0) {
                ?>
                <thead>
                    <tr>
                        <th>Course Name</th>
                        <!--<th>Set Name</th>-->
                        <th>Employee Name</th>
                        <th>Questionnaire</th>
                        <th>Question Name</th>
                        <th>Date</th>
                        <th>Result</th>
                         <th>Courses’ Audio Notes</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($show_traniner_checked_history as $data => $historyResult) {
                        ?>
                        <tr>
                            <th>
                                <?php
                                $getCourseNameByID = App\Http\Controllers\training\CourseController::getCourseNameByID($historyResult->course_id);

                                if (count($getCourseNameByID) > 0) {
                                    echo $getCourseNameByID[0]->course_title;
                                } else {
                                    echo 'Course deleted';
                                }
                                ?>
                            </th>
                            <!--<th>{{$historyResult->set_name}}</th>-->
                            <th>
                                <?php
                                $user_employees = App\Http\Controllers\UserProfileController::user_employees($historyResult->user_id);
                                echo $user_employees[0]->Name;
                                ?>
                            </th>
                            <th>
                                <?php
                                $getQuestionNameByid = App\Http\Controllers\training\QuestionnaireController::getQuestionNameByid($historyResult->questionnaire_id);
                                echo $getQuestionNameByid[0]->questionnaire_name;
                                ?>
                            </th>
                            <th>
                                <?php
                                $getQuestionNameByid_Question_id = App\Http\Controllers\training\QuestionnaireController::getQuestionNameByid_Question_id($historyResult->audio_question, $historyResult->questionnaire_id);
                                echo $getQuestionNameByid_Question_id[0]->question;
                                ?>
                            </th>
                            <th>
                                {{$historyResult->que_checking_data}}
                            </th>
                            <th>
                                <?php
                                if (($historyResult->result == Null) || ($historyResult->result == '')) {
                                    echo 'Not Checked';
                                } else if ($historyResult->result == 1) {
//                                    echo 'Right';
                                    echo ' <i class="material-icons green-text ">check</i>';
                                } elseif ($historyResult->result == 2) {
//                                    echo 'Worng';
                                    echo '<i class="material-icons red-text ">close</i>';
                                } else {
                                    echo '-';
                                }
                                ?>
                            </th>
                            <th>
                                <!-- Modal Trigger -->
                                <a class="modal-trigger" href="#moda{{$historyResult->id}}_history">
                                    <span class="">View</span>
                                </a>
                                <?php if (!empty($historyResult->comment)) { ?>
                                    <!-- Modal Structure -->
                                    <div id="moda{{$historyResult->id}}_history" class="modal">
                                        <div class="modal-content">

                                            <div class="row">
                                                <h4 class="title-color">Course's Audio Notes</h4>
                                            </div>
                                            <hr>
                                          Date  {{$historyResult->que_checking_data}}   {{$historyResult->comment}}
                                        </div>
                                        <div class="modal-footer">
                                            <a href="#!" class="modal-action modal-close  btn-color btn-flat">Close</a>
                                        </div>
                                    </div>
                                <?php } ?>

                            </th>

                        </tr>
                        <?php
                    }
                } else {
                    ?>
                <div class="row">
                    <div class="col 12">
                        <h6 class="title-color">You Have no Pending Audios History</h6>
                    </div>
                </div>
                <?php
            }
            ?>
            </tbody>
        </table>
    </div>


    <script>
        function checkAudio(evt, cityName) {
            var i, tabcantent_audio, tablink_audio;
            tabcantent_audio = document.getElementsByClassName("tabcantent_audio");
            for (i = 0; i < tabcantent_audio.length; i++) {
                tabcantent_audio[i].style.display = "none";
            }
            tablink_audio = document.getElementsByClassName("tablink_audio");
            for (i = 0; i < tablink_audio.length; i++) {
                tablink_audio[i].className = tablink_audio[i].className.replace("active", "");
            }
            document.getElementById(cityName).style.display = "block";
            evt.currentTarget.className += " active";


        }
        document.getElementById("defaultOpen_audio_check").click();
    </script>

</div>

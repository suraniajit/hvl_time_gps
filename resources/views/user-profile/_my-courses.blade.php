<div class="card-panel">

    <style>


        /* Style the tab */
        .tab {
            overflow: hidden;

            /*background-color: #f1f1f1;*/
        }

        /* Style the buttons inside the tab */
        .tab button {
            border: 1px solid #ccc;
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
        .tabcontent_MyCource {
            display: none;
            /*padding: 6px 12px;*/
            /*            border: 1px solid #ccc;
                        border-top: none;*/
        }
    </style>


    <!--{{$user['id']}}-->
    <h4 class="title-color"><span>My Courses  </span></h4>

    <div class="tab" style="    margin-bottom: 15px;">
        <button class="tablinks_MyCource" style=" border: 1px solid #ccc;" onclick="openCity(event, 'all_cource')" id="defaultOpen">All Courses</button>
        <button class="tablinks_MyCource" style=" border: 1px solid #ccc;" onclick="openCity(event, 'Cource')" >Courses</button>
        <button class="tablinks_MyCource" style=" border: 1px solid #ccc;" onclick="openCity(event, 'simulate')">Simulation Courses</button>
    </div>

    <div id="all_cource" class="tabcontent_MyCource">
        <!--<h2>Course</h2>-->
        @include('user-profile._course._all_course')
    </div>
    <div id="Cource" class="tabcontent_MyCource">
        <!--<h2>Course</h2>-->
        @include('user-profile._course._course')
    </div>

    <div id="simulate" class="tabcontent_MyCource">
        <!--<h2>Simualtion</h2>-->
        @include('user-profile._course._simualtion')
    </div>


    <script>
        function openCity(evt, cityName) {
            var i, tabcontent_MyCource, tablinks_MyCource;
            tabcontent_MyCource = document.getElementsByClassName("tabcontent_MyCource");
            for (i = 0; i < tabcontent_MyCource.length; i++) {
                tabcontent_MyCource[i].style.display = "none";
            }
            tablinks_MyCource = document.getElementsByClassName("tablinks_MyCource");
            for (i = 0; i < tablinks_MyCource.length; i++) {
                tablinks_MyCource[i].className = tablinks_MyCource[i].className.replace("active", "");
            }
            document.getElementById(cityName).style.display = "block";
            evt.currentTarget.className += " active";


        }
        document.getElementById("defaultOpen").click();
    </script>




</div>

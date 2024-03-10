<style>
    #sticky {
        position: sticky;
        position: -webkit-sticky;
        background-color: #fff;
        /* background: #f83d23; */
        /* width: 100px; */
        /* height: 100px; */
        top: 70px;
        /* display: flex; */
        /* justify-content: center; */
        /* align-items: center; */
        /*box-shadow: 0 0 6px #000;*/
        box-shadow: 0 0 21px #000;
        font-size: 20px;
        /* color: #fff;*/
        z-index: 5;
        height: 42px;
        /*background-color: whitesmoke;*/
    }

    .extra,
    #wrapper {
        /*        width: 75%;
                margin: auto;*/
        /*background-color: #ccc;*/
    }

    #wrapper {
        height: auto;
    }

    .extra {
        height: 100px;
    }

    /*    @media (min-height: 768px) {
            #wrapper{
                height: 2000px;
            }
        }*/

    /* Style the tab */
    .tab {
        overflow: hidden;
        border: 1px solid #ccc;
        background-color: #f1f1f1;
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
    .tabcontent {
        display: none;
        padding: 6px 12px;
        border: 1px solid #ccc;
        border-top: none;
    }
</style>


<div class="col-sm-12">
    <div class="form-group">
        <label for="first_name">Role Name <span class="text-danger">*</span></label>
        <input id="first_name" name="name" type="text" class="form-control validate" value="@if(isset($role)) {{ $role->name }} @endif" required>
        <div class="errorTxt1"></div>
    </div>
</div>
@php $i = 1 @endphp


@foreach($permissions as $key => $premission)

    @if($i%5 == 1)
        @php $name = explode(' ', $premission->name, 2) @endphp
        @php  $path = $premission->path @endphp


        <div class="col-sm-12">
            <strong>
                @if(ucfirst($name[1]) == 'Module')
                    Manage Module
                @elseif(ucfirst($name[1]) == 'LeadSource')
                    Lead Source
                @elseif(ucfirst($name[1]) == 'LeadStatus')
                    Lead Status
                @elseif(ucfirst($name[1]) == 'Activitystatus')
                    Activity Status
                @elseif(ucfirst($name[1]) == 'Activitytype')
                    Activity Type
                @elseif(ucfirst($name[1]) == 'CompanyType')
                    Company Type
                @else
                    {{ ucfirst($name[1]) }}
                @endif
            </strong>
        </div>

    @endif

    <div class="col-sm-12 col-md-2">
        <div class="i-checks">
            <input type="checkbox" id="{{ $premission->name }}" name="permissions[]" value="{{ $premission->name }}"
                   @if(isset($role)) @if($role->hasPermissionTo($premission->name)) checked @endif @endif
                   onclick="if(document.getElementById('Access {{ $name[1] }}').checked === false){
                document.getElementById('Access {{ $name[1] }}').checked = this.checked
                }">
            <label for="checkboxCustom1">
                @if($premission->name == 'Access Module')
                   Access Manage Module
                @elseif($premission->name == 'Access LeadSource')
                    Access Lead Source
                @elseif($premission->name == 'Access LeadStatus')
                    Access Lead Status
                @elseif($premission->name == 'Access activitystatus')
                    Access Activity Status
                @elseif($premission->name == 'Access activitytype')
                    Access Activity Type
                @elseif($premission->name == 'Access CompanyType')
                    Access Company Type
                @elseif($premission->name == 'Access designations')
                    Access Designation
                @elseif($premission->name == 'Access departments')
                    Access Department
                @elseif($premission->name == 'Access teams')
                    Access Team
                @elseif($premission->name == 'Access employees')
                    Access Employees
                @elseif($premission->name == 'Access leads')
                    Access Leads

                @elseif($premission->name == 'Read Module')
                    Read Manage Module
                @elseif($premission->name == 'Read LeadSource')
                    Read Lead Source
                @elseif($premission->name == 'Read LeadStatus')
                    Read Lead Status
                @elseif($premission->name == 'Read activitystatus')
                    Read Activity Status
                @elseif($premission->name == 'Read activitytype')
                    Read Activity Type
                @elseif($premission->name == 'Read CompanyType')
                    Read Company Type
                @elseif($premission->name == 'Read designations')
                    Read Designation
                @elseif($premission->name == 'Read departments')
                    Read Department
                @elseif($premission->name == 'Read teams')
                    Read Team
                @elseif($premission->name == 'Read employees')
                    Read Employees
                @elseif($premission->name == 'Read leads')
                    Read Leads

                @elseif($premission->name == 'Create Module')
                    Create Manage Module
                @elseif($premission->name == 'Create LeadSource')
                    Create Lead Source
                @elseif($premission->name == 'Create LeadStatus')
                    Create Lead Status
                @elseif($premission->name == 'Create activitystatus')
                    Create Activity Status
                @elseif($premission->name == 'Create activitytype')
                    Create Activity Type
                @elseif($premission->name == 'Create CompanyType')
                    Create Company Type
                @elseif($premission->name == 'Create designations')
                    Create Designation
                @elseif($premission->name == 'Create departments')
                    Create Department
                @elseif($premission->name == 'Create teams')
                    Create Team
                @elseif($premission->name == 'Create employees')
                    Create Employees
                @elseif($premission->name == 'Create leads')
                    Create Leads

                @elseif($premission->name == 'Edit Module')
                    Edit Manage Module
                @elseif($premission->name == 'Edit LeadSource')
                    Edit Lead Source
                @elseif($premission->name == 'Edit LeadStatus')
                    Edit Lead Status
                @elseif($premission->name == 'Edit activitystatus')
                    Edit Activity Status
                @elseif($premission->name == 'Edit activitytype')
                    Edit Activity Type
                @elseif($premission->name == 'Edit CompanyType')
                    Edit Company Type
                @elseif($premission->name == 'Edit designations')
                    Edit Designation
                @elseif($premission->name == 'Edit departments')
                    Edit Department
                @elseif($premission->name == 'Edit teams')
                    Edit Team
                @elseif($premission->name == 'Edit employees')
                    Edit Employees
                @elseif($premission->name == 'Edit leads')
                    Edit Leads

                @elseif($premission->name == 'Delete Module')
                    Delete Manage Module
                @elseif($premission->name == 'Delete LeadSource')
                    Delete Lead Source
                @elseif($premission->name == 'Delete LeadStatus')
                    Delete Lead Status
                @elseif($premission->name == 'Delete activitystatus')
                    Delete Activity Status
                @elseif($premission->name == 'Delete activitytype')
                    Delete Activity Type
                @elseif($premission->name == 'Delete CompanyType')
                    Delete Company Type
                @elseif($premission->name == 'Delete designations')
                    Delete Designation
                @elseif($premission->name == 'Delete departments')
                    Delete Department
                @elseif($premission->name == 'Delete teams')
                    Delete Team
                @elseif($premission->name == 'Delete employees')
                    Delete Employees
                @elseif($premission->name == 'Delete leads')
                    Delete Leads
                @else
                    {{ ucfirst($premission->name )}}
                @endif</label>

        </div>
        <br>
    </div>



    @php $i++ @endphp

@endforeach



{{--<div id="wrapper">--}}
<!--    <div id="sticky">
            <div class="row">
                <div class="col s12 m6 l2"><p>Modules</p></div>
                <div class="col s12 m6 l2 center">Access</div>
                <div class="col s12 m6 l2 center"><p>Read</p></div>
                <div class="col s12 m6 l2 center"><p>Write</p></div>
                <div class="col s12 m6 l2 center"><p>Edit</p></div>
                <div class="col s12 m6 l2 center"><p>Delete</p></div>
            </div>
        </div><br>-->


<!--new desgin-->

{{--        <div id="test1" class="col s12">--}}
{{--            <br>--}}
{{--            @include('role.sticky')--}}
{{--            @include('role._hrms')--}}
{{--            <br>--}}
{{--        </div>--}}

<!--new desgin-->





{{--</div>--}}
<!--



<script>
    function openCity(evt, cityName) {
        var i, tabcontent, tablinks;
        tabcontent = document.getElementsByClassName("tabcontent");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }
        tablinks = document.getElementsByClassName("tablinks");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" active", "");
        }
        document.getElementById(cityName).style.display = "block";
        evt.currentTarget.className += " active";
    }
</script>-->

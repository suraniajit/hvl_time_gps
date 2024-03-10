@extends('app.layout')

@section('title','Roles | HVL')

@section('content')
    <div class="breadcrumb-holder">
        <div class="container-fluid">
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                <li class="breadcrumb-item "><a href="{{url('/roles')}}">Roles Management</a></li>
                <li class="breadcrumb-item active">Edit Roles</li>
            </ul>
        </div>
    </div>
    <?php
    use App\Module;

    $user = auth()->user();

    $user_role_name = App\Http\Controllers\UserProfileController::find_user_role($user['id']);
    ?>
    <section>
        <div class="container-fluid">
            <header>
                <div class="row">
                    <div class="col-md-7">
                        <h2 class="h3 display">Edit Role</h2>
                    </div>
                </div>
            </header>
<div class="card">
    <div class="card-body p-4">
        <div class="row">
            @if ($errors->any())
            @foreach ($errors->all() as $error)
            <div class="card-alert card gradient-45deg-red-pink">
                <div class="card-content white-text">
                    <p>
                        <i class="material-icons">error</i>{{ $error }}
                    </p>
                </div>
                <button type="button" class="close white-text" data-dismiss="alert"
                        aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            @endforeach
            @endif
        </div>




        <form action="{{ route('roles.update', $role->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row">

                <div class="col-sm-12">
                    <div class="form-group">
                        <label for="first_name">Role Name <span class="text-danger">*</span></label>
                        <input id="first_name" name="name" type="text" class="form-control validate" value="@if(isset($role)) {{ $role->name }} @endif" readonly>
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
                                    @if($user->email == 'probsoltechnology@gmail.com')
                                        Manage Module
                                    @endif
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
                            @if($premission->name == 'Access Module'  or $premission->name == 'Create Module' or $premission->name == 'Edit Module' or $premission->name == 'Read Module' or $premission->name == 'Delete Module')
                                @if($user->email == 'probsoltechnology@gmail.com')
                                    <input type="checkbox" id="{{ $premission->name }}" name="permissions[]" value="{{ $premission->name }}"
                                           @if(isset($role)) @if($role->hasPermissionTo($premission->name)) checked @endif @endif
                                           onclick="if(document.getElementById('Access {{ $name[1] }}').checked === false){
                                        document.getElementById('Access {{ $name[1] }}').checked = this.checked
                                        }">
                                    <label for="checkboxCustom1">
                                        @endif
                                        @else
                                            <input type="checkbox" id="{{ $premission->name }}" name="permissions[]" value="{{ $premission->name }}"
                                                   @if(isset($role)) @if($role->hasPermissionTo($premission->name)) checked @endif @endif
                                                   onclick="if(document.getElementById('Access {{ $name[1] }}').checked === false){
                                                document.getElementById('Access {{ $name[1] }}').checked = this.checked
                                                }">
                                            <label for="checkboxCustom1">
                                                @endif
                                                @if($premission->name == 'Access Module')
                                                    @if($user->email == 'probsoltechnology@gmail.com')
                                                        Access Manage Module
                                                    @endif
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
                                                    @if($user->email == 'probsoltechnology@gmail.com')
                                                        Read Manage Module
                                                    @endif
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
                                                    @if($user->email == 'probsoltechnology@gmail.com')
                                                        Create Manage Module
                                                    @endif
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
                                                    @if($user->email == 'probsoltechnology@gmail.com')
                                                        Edit Manage Module
                                                    @endif
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
                                                    @if($user->email == 'probsoltechnology@gmail.com')
                                                        Delete Manage Module
                                                    @endif
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
                                            </label>
                                @endif

                        </div>
                        <br>
                    </div>



                    @php $i++ @endphp

                @endforeach

            </div>

            <hr>
            <div class="row mt-4 pull-right">
                <div class="col-sm-12 ">
                    <button class="btn btn-primary mr-2" type="submit" name="action">
                        <i class="fa fa-arrow-circle-up"></i>
                        Update
                    </button>
                    <button type="reset" class="btn btn-secondary  mb-1">
                        <i class="fa fa-arrow-circle-left"></i>
                        <a href="{{url()->previous()}}" class="text-white">Cancel</a>
                    </button>
                </div>
            </div>

        </form>
    </div>
</div>
        </div>
    </section>


@endsection


<?php

use App\Module;use Illuminate\Support\Facades\DB;

$user = auth()->user();
// $user_profile = DB::table('users')->where('id','=','1')->get();
$helper = new Helper(); 
$super_admin = $helper->getSuperAdmin();

$user_role_name = App\Http\Controllers\UserProfileController::find_user_role($user['id']);


$modules = Module::orderBy('name')->get();
?>

<nav class="side-navbar">
    <div class="side-navbar-wrapper">
        <!-- Sidebar Header    -->
        <div class="sidenav-header d-flex align-items-center justify-content-center">
            <!-- User Info-->
             @if($user->email == $super_admin || $user->email == 'probsoltechnology@gmail.com')
           <a href="{{ route('admin-profile-page') }}">
                <div class="sidenav-header-inner text-center"><img src="<?php echo $profile_image; ?>" alt="person" class="img-fluid rounded-circle">
                    <h2 class="h5">{{ucfirst($user_role_name[0]->usersname)}}</h2><span class="text-black">{{ucfirst($user_role_name[0]->user_role)}} <?php //echo $user['id']; ?></span>
                </div>
            </a>
            @else
            <a href="{{url('/')}}">
                <div class="sidenav-header-inner text-center"><img src="{{asset('img/user-icon.png')}}" alt="person" class="img-fluid rounded-circle">
                    <h2 class="h5">{{$user->name}}</h2><span class="text-white">{{ucfirst($user_role_name[0]->user_role)}}</span>
                </div>
            </a>  
            @endif
            <div class="sidenav-header-logo">
                @if($user->email == $super_admin || $user->email == 'probsoltechnology@gmail.com')
                    <a href="{{ route('admin-profile-page') }}" class="brand-small text-center"> 
                        <strong class="text-primary">
                                {{strtoupper(env('APP_NAME'))}}
                        </strong>
                    </a>
                @else
                    <a href="{{url('/')}}" class="brand-small text-center"> 
                        <strong class="text-primary">
                            {{strtoupper(env('APP_NAME'))}}
                        </strong>
                    </a>
                @endif
            </div>
        </div>
        <div class="main-menu">
            <ul id="side-main-menu" class="side-menu list-unstyled">
                        @if($user->email == $super_admin || $user->email == 'probsoltechnology@gmail.com')
                            <li class="">
                                <a href="/dashboard" class=" ">

                                    <span>Dashboard</span>
                                </a>
                            </li>
                        @endif
                         @can('Access Customer Dashboad')
                          <li class="{{ Request::routeIs('customer.dashboad.index') ? 'active' : '' }}">
                                <a href="{{route('customer.dashboad.index')}}" class=" ">
                                    <span>Customer Dashboard</span>
                                </a>
                            </li>
                        @endcan
                          @if($user->email == $super_admin || $user->email == 'probsoltechnology@gmail.com')
                      
                         <li class="{{ Request::routeIs('system_log view') ? 'active' : '' }}">
                                <a href="{{route('system_log view')}}" class=" ">
                                    <span>System Logs</span>
                                </a>
                            </li>
                        @endif  
                        @can('Access Activity')
                        <li class=" " text='Reports'>
                            <a href="#exampledropdownDropdown1" aria-expanded="false" data-toggle="collapse">
                                Activity Management </a>
                            <ul id="exampledropdownDropdown1" class="collapse list-unstyled {{ Request::routeIs('activity.index') ? 'show' : '' }} {{request()->is('modules/module/activitystatus') ? 'show' : ""}} {{request()->is('modules/module/activitytype') ? 'show' : ""}} ">
                                <li class="{{ Request::routeIs('activity.index') ? 'active' : '' }}">
                                    <a href="{{ route('activity.index') }}" class=" ">

                                        <span>Activities</span>
                                    </a>
                                </li>

                                @foreach($modules as $module)
                                    @if($module->name == 'activitystatus')
                                        @can('Access '.$module->name)

                                            <li class="{{request()->is('modules/module/'.$module->name) ? 'active' : ""}}">
                                                <a href="/modules/module/{{ $module->name }}">

                                                    <span>Activity Status</span>
                                                </a>
                                            <li>
                                        @endcan
                                    @endif
                                    @if($module->name == 'activitytype')
                                        @can('Access '.$module->name)
                                            <li class="{{(request()->is('modules/module/'.$module->name)) ? 'active' : ''}}">
                                                <a href="/modules/module/{{ $module->name }}">
                                                    <span>Activity Type</span>
                                                </a>
                                            <li>
                                        @endcan
                                    @endif
                                @endforeach
                            </ul>
                        </li>
                    @endcan
                    <!-- by surani -->
                        @php
                            $audit_index = false; 
                            $audit_dashboard = false;
                        @endphp
                        @can('index audit')
                        <!-- aa -->
                            @php 
                                $audit_index = true;
                            @endphp 
                        @endcan
                        @can('audit dashboard')
                           <!-- bb -->
                            @php 
                                $audit_dashboard = true;
                            @endphp 
                        @endcan
                        
                        @if($audit_index == true || $audit_dashboard == true)
                        <li class=" " text='Reports'>
                            <a href="#audit_management_section" aria-expanded="false" data-toggle="collapse">
                                Audit Management 
                            </a>
                            <ul id="audit_management_section" class="collapse list-unstyled {{ Request::routeIs('admin.audit.index') ? 'show' : '' }} {{ Request::routeIs('admin.audit.dashboard') ? 'show' : '' }} ">
                                @if($audit_index)
                                <li class="{{ Request::routeIs('admin.audit.index') ? 'active' : '' }}">
                                    <a href="{{ route('admin.audit.index') }}" class=" ">
                                        <span>Audit List</span>
                                    </a>
                                </li>
                                @endif
                                @if($audit_dashboard)
                                <li class="{{ Request::routeIs('admin.audit.dashboard') ? 'active' : '' }}">
                                    <a href="{{ route('admin.audit.dashboard') }}" class=" ">
                                        <span>Audit Dashboard</span>
                                    </a>
                                </li>
                                @endif
                            </ul>
                        </li>
                        @endif
                    <!-- end surani -->

                @can('Access Customer')
                    <li class=" " text='Reports'>
                        <a href="#exampledropdownDropdown2" aria-expanded="false" data-toggle="collapse">
                            Customer Management </a>
                        <ul id="exampledropdownDropdown2" class="collapse list-unstyled {{ Request::routeIs('customer.index') ? 'show' : '' }} {{ Request::routeIs('delete-customer') ? 'show' : '' }} {{request()->is('modules/module/Branch') ? 'show' : ""}} {{request()->is('modules/module/Zones') ? 'show' : ""}} {{Request::routeIs('branch-customer') ? 'show' : ""}}">

                            @foreach($modules as $module)
                                @if($module->name == 'Branch')
                                    @can('Access '.$module->name)
                                        <li class="{{(request()->is('modules/module/'.$module->name)) ? 'active' : ''}}">
                                            <a href="/modules/module/{{ $module->name }}">

                                                <span>Branch Management </span>
                                            </a>
                                        <li>
                                    @endcan
                                @endif
                            @endforeach

                            @can('Access Branch Wise Customer')
                            <li class="{{ Request::routeIs('branch-customer') ? 'active' : '' }}">
                                <a href="{{ route('branch-customer') }}" class=" ">

                                    <span>Zone wise Customer</span>
                                </a>
                            </li>
                                @endcan
                                <li class="{{ Request::routeIs('customer.index') ? 'active' : '' }}">
                                    <a href="{{ route('customer.index') }}" class=" ">

                                        <span>Customers</span>
                                    </a>
                                </li>
                                @foreach($modules as $module)
                                    @if($module->name == 'Zones')
                                        @can('Access '.$module->name)
                                            <li class="{{(request()->is('modules/module/'.$module->name)) ? 'active' : ''}}">
                                                <a href="/modules/module/{{ $module->name }}">

                                                    <span>Zone Management </span>
                                                </a>
                                            <li>
                                        @endcan
                                    @endif
                                @endforeach
                        </ul>

                    </li>

                @endcan


                <li class=" " text='Employee Management'>
                    @if(Gate::check('Access City') || Gate::check('Access departments') || Gate::check('Access designations') || Gate::check('Access employees') || Gate::check('Access State') || Gate::check('Access Teams') || Gate::check('Access User') )
                    <a href="#exampledropdownDropdown3" aria-expanded="false" data-toggle="collapse">
                        Employee Management</a>
                    @endif
                    <ul id="exampledropdownDropdown3" class="collapse list-unstyled {{ Request::routeIs('city.index') ? 'show' : '' }}{{ Request::routeIs('state.index') ? 'show' : '' }} {{request()->is('modules/module/departments') ? 'show' : ""}} {{request()->is('modules/module/employees') ? 'show' : ""}}{{request()->is('modules/module/designations') ? 'show' : ""}}{{request()->is('users') ? 'show' : ""}}{{request()->is('modules/module/teams') ? 'show' : ""}} ">
                        @can('Access City')
                            <li class="{{ Request::routeIs('city.index') ? 'active' : '' }}">
                                <a href="{{ route('city.index') }}" class=" ">
                                    <span>City Management</span>
                                </a>
                            </li>
                        @endcan
                        @foreach($modules as $module)
                            @if($module->name == 'departments')
                                @can('Access '.$module->name)
                                        <li class="{{(request()->is('modules/module/'.$module->name)) ? 'active' : ''}}">
                                        <a href="/modules/module/{{ $module->name }}">

                                            <span>{{ucfirst($module->name)}}</span>
                                        </a>
                                    <li>
                                @endcan
                            @endif
                            @if($module->name == 'designations')
                                @can('Access '.$module->name)
                                        <li class="{{(request()->is('modules/module/'.$module->name)) ? 'active' : ''}}">
                                        <a href="/modules/module/{{ $module->name }}">

                                            <span>{{ucfirst($module->name)}}</span>
                                        </a>
                                    <li>
                                @endcan
                            @endif
                            @if($module->name == 'employees')
                                @can('Access '.$module->name)
                                    <li class="{{(request()->is('modules/module/'.$module->name)) ? 'active' : ''}}">
                                        <a href="/modules/module/{{ $module->name }}">

                                            <span>{{ucfirst($module->name)}}</span>
                                        </a>
                                    <li>
                                @endcan
                            @endif
                        @endforeach
                        @can('Access State')
                            <li class="{{ Request::routeIs('state.index') ? 'active' : '' }}">
                                <a href="{{ route('state.index') }}" class=" ">

                                    <span>State Management</span>
                                </a>
                            </li>
                        @endcan
                        @foreach($modules as $module)
                            @if($module->name == 'teams')
                                @can('Access '.$module->name)
                                        <li class="{{(request()->is('modules/module/'.$module->name)) ? 'active' : ''}}">
                                        <a href="/modules/module/{{ $module->name }}">

                                            <span>{{ucfirst($module->name)}}</span>
                                        </a>
                                    <li>
                                @endcan
                            @endif
                        @endforeach

                        @can('Access User')
                            <li class="{{ (request()->is('users')) ? 'active' : '' }}">
                                <a href="/users" class=" ">

                                    <span>User Management</span>
                                </a>
                            </li>
                        @endcan
                    </ul>
                </li>

                @can('Access Module')
                    @if($user->email == 'probsoltechnology@gmail.com')
                    <li class="{{ Request::routeIs('module.index') ? 'active' : '' }}">
                        <a href="{{ route('module.index') }}" class=" ">

                            <span>Manage Module</span>
                        </a>
                    </li>
                    @endif
                @endcan

                @can('Access leads')

                    <li>
                        <a href="#exampledropdownDropdown4" aria-expanded="false" data-toggle="collapse">
                            Lead Management </a>
                        <ul id="exampledropdownDropdown4" class="collapse list-unstyled {{ Request::routeIs('lead.index') ? 'show' : '' }}{{request()->is('modules/module/Industry') ? 'show' : ""}} {{request()->is('modules/module/LeadSource') ? 'show' : ""}}{{request()->is('modules/module/LeadStatus') ? 'show' : ""}}{{request()->is('modules/module/Rating') ? 'show' : ""}}">
                            @foreach($modules as $module)
                                @if($module->name == 'Industry')
                                    @can('Access '.$module->name)
                                        <li class="{{(request()->is('modules/module/'.$module->name)) ? 'active' : ''}}">
                                            <a href="/modules/module/{{ $module->name }}">

                                                <span>{{ucfirst($module->name)}}</span>
                                            </a>
                                        <li>
                                    @endcan
                                @endif
                            @endforeach
                            <li class="{{ Request::routeIs('lead.index') ? 'active' : '' }}">
                                <a href="{{ route('lead.index') }}" class=" ">

                                    <span>Lead Management</span>
                                </a>
                            </li>

                            @foreach($modules as $module)
                                @if($module->name == 'Rating')
                                    @can('Access '.$module->name)
                                        <li class="{{(request()->is('modules/module/'.$module->name)) ? 'active' : ''}}">
                                            <a href="/modules/module/{{ $module->name }}">
                                            <span>Geographical Segment</span>
                                            {{--
                                                    <span>{{ucfirst($module->name)}}</span>
                                            --}}
                                            </a>
                                        <li>
                                    @endcan
                                @endif
                                @if($module->name == 'LeadSource')
                                    @can('Access '.$module->name)
                                        <li class="{{(request()->is('modules/module/'.$module->name)) ? 'active' : ''}}">
                                            <a href="/modules/module/{{ $module->name }}">

                                                <span>Lead Source</span>
                                            </a>
                                        <li>
                                    @endcan
                                @endif
                                @if($module->name == 'LeadStatus')
                                    @can('Access '.$module->name)
                                        <li {{(request()->is('modules/module/LeadStatus')) ? 'active' : ''}}>
                                            <a href="/modules/module/{{ $module->name }}">

                                                <span>Lead Status</span>
                                            </a>
                                        <li>
                                    @endcan
                                @endif
                            @endforeach

                        </ul>
                    </li>
            @endcan
            @if($user->email == $super_admin || $user->email == 'probsoltechnology@gmail.com')
                    <li class="{{ Request::routeIs('admin.billing.index') ? 'active' : '' }}">
                        <a href="{{ route('admin.billing.index') }}" class=" ">
                            <span>Billing System</span>
                        </a>
                    </li>
            @endif
            @can('Access Role')
                    <li class="{{ Request::routeIs('roles.index') ? 'active' : '' }}">
                        <a href="{{ route('roles.index') }}" class=" ">

                            <span>Role Management</span>
                        </a>
                    </li>
            @endcan

            @can('Access CustomerAdmin')
                <li class="{{ Request::routeIs('customer.login_system.index') ? 'active' : '' }}">
                    <a href="{{ route('customer.login_system.index') }}" class=" ">
                        <span>Customer Login System</span>
                    </a>
                </li>
            @endcan   
            
            @foreach($modules as $module)
                @if($module->name != 'activitystatus' and $module->name != 'activitytype' and $module->name != 'Branch' and $module->name != 'departments' and $module->name != 'designations' and $module->name != 'employees' and $module->name != 'teams' and $module->name != 'CompanyType' and $module->name != 'Rating' and $module->name != 'Industry'  and $module->name != 'LeadSource' and $module->name != 'LeadStatus' and $module->name != 'Zones' )
                    @can('Access '.$module->name)
                        <li class="{{(request()->is('modules/module/'.$module->name)) ? 'active' : ''}}">
                            <a href="/modules/module/{{ $module->name }}"  >

                                <span> {{ucfirst($module->name)}}</span>
                            </a>
                        <li>
                    @endcan
                @endif
            @endforeach
                    
             @if($user->email == $super_admin)
                    <li style="display:none;">
                        <a href="#exampledropdownDropdown5" aria-expanded="false" data-toggle="collapse">Settings </a>
                        <ul id="exampledropdownDropdown5" class="collapse list-unstyled {{ Request::routeIs('change-password') ? 'show' : '' }}{{request()->is('admin-profile-page') ? 'show' : ""}} {{request()->is('change-password') ? 'show' : ""}}{{request()->is('change-password') ? 'show' : ""}}{{request()->is('change-password') ? 'show' : ""}}">
                            <li class="{{ Request::routeIs('change-password') ? 'active' : '' }}">
                                <a href="{{ route('change-password') }}" class=" ">
                                    <span>Reset Password</span>
                                </a>
                            </li>
                            <li class="{{ Request::routeIs('admin-profile-page') ? 'active' : '' }}">
                                <a href="{{ route('admin-profile-page') }}" class=" ">
                                    <span>My Profile</span>
                                </a>
                            </li>
                        </ul>
                    </li>
            @endif
            
            @include('panels._expances_nav')
            
            </ul>
        </div>
    </div>
</nav>

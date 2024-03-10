<?php

use App\User;
use App\Module;
use App\Permission;
use App\Role;

$user = auth()->user();

$user_role_name = App\Http\Controllers\UserProfileController::find_user_role($user['id']);


$modules = Module::all();
$custom_classes = '';

?>
<nav class="side-navbar">
    <div class="side-navbar-wrapper">
        <!-- Sidebar Header    -->
        <div class="sidenav-header d-flex align-items-center justify-content-center">
            <!-- User Info-->
            <a href="{{url('/')}}">
                <div class="sidenav-header-inner text-center"><img src="{{asset('img/user-icon.png')}}" alt="person" class="img-fluid rounded-circle">
                    <h2 class="h5">{{$user->name}}</h2><span>{{$user_role_name[0]->user_role}}</span>
                </div>
            </a>

            <!-- Small Brand information, appears on minimized sidebar-->
            <div class="sidenav-header-logo"><a href="{{url('/')}}" class="brand-small text-center"> <strong>B</strong><strong class="text-primary">D</strong></a></div>
        </div>

        <!-- Sidebar Navigation Menus-->

<div class="main-menu">
    <ul id="side-main-menu" class="side-menu list-unstyled">

        @can('Access Role')
            <li class="">
                <a href="{{ route('roles.index') }}" class=" ">
                    <i class="material-icons"></i>
                    <span>Role Management</span>
                </a>
            </li>
        @endcan
        @can('Access Module')
            <li class="">
                <a href="{{ route('module.index') }}" class=" ">
                    <i class="material-icons"></i>
                    <span>Manage Module</span>
                </a>
            </li>
        @endcan
        @can('Access User')
            <li class="">
                <a href="{{ url('/users') }}" class=" ">
                    <i class="material-icons"></i>
                    <span>User Management</span>
                </a>
            </li>
        @endcan

        <li class=" " text='Reports'>
            <a href="#exampledropdownDropdown" aria-expanded="false" data-toggle="collapse"> <i class="icon-interface-windows"></i>Reports </a>
                <ul id="exampledropdownDropdown" class="collapse list-unstyled ">
                    <li>
                        <a href="/employee-wise" class=" ">
                            <i class="material-icons"></i>
                            <span data-i18n="Analytics">Employee wise items </span>
                        </a>
                    </li>
                    <li>
                        <a href="/date-wise" class=" ">
                            <i class="material-icons"></i>
                            <span data-i18n="Analytics">Date wise item receiving </span>
                        </a>

                    <li>
                    <li>
                        <a href="/item-wise" class=" ">
                            <i class="material-icons"></i>
                            <span data-i18n="Analytics">Item wise stock</span>
                        </a>

                    <li>
                    <li>
                        <a href="/department-wise" class=" ">
                            <i class="material-icons"></i>
                            <span data-i18n="Analytics">Department wise stock</span>
                        </a>

                    <li>
                    <li>
                        <a href="/allocation-wise" class=" ">
                            <i class="material-icons"></i>
                            <span data-i18n="Analytics">Item allocation report</span>
                        </a>

                    <li>
                    <li>
                        <a href="/warranty-wise" class=" ">
                            <i class="material-icons"></i>
                            <span data-i18n="Analytics">Warranty report</span>
                        </a>

                    <li>
                    <li>
                        <a href="/trash-wise" class=" ">
                            <i class="material-icons"></i>
                            <span data-i18n="Analytics">Trash/Scrap report</span>
                        </a>

                    <li>
                </ul>

        </li>
        {{--             @can('Access Assign-Maintanance-To-Asset')--}}
        {{--            <li class="">--}}
        {{--                <a href="{{ route('maintanance') }}" class=" ">--}}
        {{--                    <i class="material-icons"></i>--}}
        {{--                    <span>Assign Maintanance</span>--}}
        {{--                </a>--}}
        {{--            </li>--}}
        {{--            @endcan --}}
        {{--             @can('Access Assign-Employee-To-Asset')--}}
        {{--            <li class="">--}}
        {{--                <a href="{{ route('assignasset') }}" class=" ">--}}
        {{--                    <i class="material-icons"></i>--}}
        {{--                    <span>Assign Assets</span>--}}
        {{--                </a>--}}
        {{--            </li>--}}
        {{--            @endcan --}}
        {{--             @can('Access Assign-Asset-To-Category')--}}
        {{--            <li class="">--}}
        {{--                <a href="{{ route('assignasset-to-category') }}" class=" ">--}}
        {{--                    <i class="material-icons"></i>--}}
        {{--                    <span>Assign Assets To Category</span>--}}
        {{--                </a>--}}
        {{--            </li>--}}
        {{--            @endcan --}}
        {{--             @can('Access Work-Order')--}}
        {{--            <li class="">--}}
        {{--                <a href="{{ route('workorder') }}" class=" ">--}}
        {{--                    <i class="material-icons"></i>--}}
        {{--                    <span>Work Order</span>--}}
        {{--                </a>--}}
        {{--            </li>--}}
        {{--            @endcan --}}
        {{--             @can('Access Assets')--}}
        {{--            <li class="">--}}
        {{--                <a href="{{ route('qrcode') }}" class=" ">--}}
        {{--                    <i class="material-icons"></i>--}}
        {{--                    <span>Assign Qr-Code</span>--}}
        {{--                </a>--}}
        {{--            </li>--}}
        {{--            @endcan --}}
        @can('Access Category')
            <li class="">
                <a href="{{ route('category') }}" class=" ">
                    <i class="material-icons"></i>
                    <span>Category</span>
                </a>
            </li>
        @endcan
        @can('Access Sub-Category')
            <li class="">
                <a href="{{ route('sub-category') }}" class=" ">
                    <i class="material-icons"></i>
                    <span>Sub-Category</span>
                </a>
            </li>
        @endcan
        @can('Access Sub-Sub-Category')
            <li class="">
                <a href="{{ route('sub-subcategory') }}" class=" ">
                    <i class="material-icons"></i>
                    <span>Sub Sub-Category</span>
                </a>
            </li>
        @endcan
        @can('Access Manage-Asset')
            {{--            <li class="">--}}
            {{--                <a href="{{ route('manageasset') }}" class=" ">--}}
            {{--                    <i class="material-icons"></i>--}}
            {{--                    <span>Manage Asset</span>--}}
            {{--                </a>--}}
            {{--            </li>--}}
        @endcan
        <li class="">
            <a href="{{ route('list-qrcodes') }}" class=" ">
                <i class="material-icons"></i>
                <span>Match Items</span>
            </a>
        </li>
        <li class="">
            <a href="{{ route('qr-scanner') }}" class=" ">
                <i class="material-icons"></i>
                <span>Scanner</span>
            </a>
        </li>
            <li class="">
            <a href="{{ url('/summary') }}" class=" ">
                <i class="material-icons"></i>
                <span>Summary</span>
            </a>
        </li>
{{--        <li class="">--}}
{{--            <a href="{{ route('charts') }}" class=" ">--}}
{{--                <i class="material-icons"></i>--}}
{{--                <span>Charts</span>--}}
{{--            </a>--}}
{{--        </li>--}}


        @foreach($modules as $module)
            @can('Access '.$module->name)

                <li>
                    <a href="/modules/module/{{ $module->name }}" class="{{$custom_classes}} {{ (request()->segment(2) == 'shift') ? 'active '.$configData['activeMenuColor'] : ''}}">
                        <i class="material-icons"></i>
                        <span data-i18n="Analytics">{{ucfirst($module->name)}}
                    </span>
                    </a>

                <li>

            @endcan
            @if($module->name == 'Assets')
                @can('Access Manage-Asset')
                    <li class="">
                        <a href="{{ route('manageasset') }}" class=" ">
                            <i class="material-icons"></i>
                            <span>Manage Asset</span>
                        </a>
                    </li>
                @endcan
            @endif
        @endforeach
    </ul>

</div>
    </div>
</nav>

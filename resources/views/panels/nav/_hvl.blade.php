{{--@foreach($modules as $module)--}}

{{--@can('Access '.$module->name)--}}
{{--<li>--}}
{{--    <a href="/modules/module/{{ $module->name }}" class="{{$custom_classes}}" >--}}
{{--        <i class="material-icons">radio_button_unchecked</i>--}}
{{--        <span data-i18n="Analytics">{{ucfirst($module->name)}}</span>--}}
{{--    </a>--}}
{{--<li>--}}

{{--    @endcan--}}
{{--    @endforeach--}}


@can('Access Activity')
    <li class="no-padding">
        <ul class="collapsible collapsible-accordion">
            <li>
                <a class="collapsible-header">Activity Management<i class="material-icons">arrow_drop_down</i></a>
                <div class="collapsible-body">
                    <ul>
                        <li class="">
                            <a href="{{ route('activity.index') }}" class=" ">
                                <i class="material-icons">radio_button_unchecked</i>
                                <span>Activity's</span>
                            </a>
                        </li>
                        @foreach($modules as $module)
                            @if($module->name == 'activitystatus')
                                @can('Access '.$module->name)
                                    <li>
                                        <a href="/modules/module/{{ $module->name }}" >
                                            <i class="material-icons">radio_button_unchecked</i>
                                            <span >{{ucfirst(trim( chunk_split($module->name, 8, ' ')))}}</span>
                                        </a>
                                    <li>
                                @endcan
                            @endif
                            @if($module->name == 'activitytype')
                                @can('Access '.$module->name)
                                    <li>
                                        <a href="/modules/module/{{ $module->name }}" >
                                            <i class="material-icons">radio_button_unchecked</i>
                                            <span >{{ucfirst(trim( chunk_split($module->name, 8, ' ') ))}}</span>
                                        </a>
                                    <li>
                                @endcan
                            @endif
                        @endforeach
                    </ul>
                </div>
            </li>
        </ul>
    </li>

@endcan

@can('Access Customer')
    <li class="no-padding">
        <ul class="collapsible collapsible-accordion">
            <li>
                <a class="collapsible-header">Customers Management<i class="material-icons">arrow_drop_down</i></a>
                <div class="collapsible-body">
                    <ul>
                        @foreach($modules as $module)
                            @if($module->name == 'Branch')
                                @can('Access '.$module->name)
                                    <li>
                                        <a href="/modules/module/{{ $module->name }}" >
                                            <i class="material-icons">radio_button_unchecked</i>
                                            <span >{{ucfirst($module->name)}}</span>
                                        </a>
                                    <li>
                                @endcan
                            @endif
                        @endforeach
                        <li class="">
                            <a href="{{ route('customer.index') }}" class=" ">
                                <i class="material-icons">radio_button_unchecked</i>
                                <span>Customers</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
        </ul>
    </li>

@endcan



<li class="no-padding">
    <ul class="collapsible collapsible-accordion">
        <li>
            <a class="collapsible-header">Employee Management<i class="material-icons">arrow_drop_down</i></a>
            <div class="collapsible-body">
                <ul>

                    @can('Access City')
                        <li class="">
                            <a href="{{ route('city.index') }}" class=" ">
                                <i class="material-icons">radio_button_unchecked</i>
                                <span>City Management</span>
                            </a>
                        </li>
                    @endcan
                    @foreach($modules as $module)
                        @if($module->name == 'departments')
                            @can('Access '.$module->name)
                                <li>
                                    <a href="/modules/module/{{ $module->name }}" >
                                        <i class="material-icons">radio_button_unchecked</i>
                                        <span >{{ucfirst($module->name)}}</span>
                                    </a>
                                <li>
                            @endcan
                        @endif
                        @if($module->name == 'designations')
                            @can('Access '.$module->name)
                                <li>
                                    <a href="/modules/module/{{ $module->name }}" >
                                        <i class="material-icons">radio_button_unchecked</i>
                                        <span >{{ucfirst($module->name)}}</span>
                                    </a>
                                <li>
                            @endcan
                        @endif
                        @if($module->name == 'employees')
                            @can('Access '.$module->name)
                                <li>
                                    <a href="/modules/module/{{ $module->name }}" >
                                        <i class="material-icons">radio_button_unchecked</i>
                                        <span >{{ucfirst($module->name)}}</span>
                                    </a>
                                <li>
                            @endcan
                        @endif
                        @endforeach
                        @can('Access State')
                            <li class="">
                                <a href="{{ route('state.index') }}" class=" ">
                                    <i class="material-icons">radio_button_unchecked</i>
                                    <span>State Management</span>
                                </a>
                            </li>
                        @endcan
                        @foreach($modules as $module)
                        @if($module->name == 'teams')
                            @can('Access '.$module->name)
                                <li>
                                    <a href="/modules/module/{{ $module->name }}" >
                                        <i class="material-icons">radio_button_unchecked</i>
                                        <span >{{ucfirst($module->name)}}</span>
                                    </a>
                                <li>
                            @endcan
                        @endif
                    @endforeach

                    @can('Access User')
                    <li class="">
                        <a href="/users" class=" ">
                            <i class="material-icons">radio_button_unchecked</i>
                            <span>User Management</span>
                        </a>
                    </li>
                    @endcan
                </ul>
            </div>
        </li>
    </ul>
</li>

@can('Access leads')

<li class="no-padding">
    <ul class="collapsible collapsible-accordion">
        <li>
            <a class="collapsible-header">Leads Management<i class="material-icons">arrow_drop_down</i></a>
            <div class="collapsible-body">
                <ul>
                    <li class="">
                        <a href="{{ route('lead.index') }}" class=" ">
                            <i class="material-icons">radio_button_unchecked</i>
                            <span>Leads</span>
                        </a>
                    </li>
                    @foreach($modules as $module)
                        @if($module->name == 'Rating')
                            @can('Access '.$module->name)
                                <li>
                                    <a href="/modules/module/{{ $module->name }}" >
                                        <i class="material-icons">radio_button_unchecked</i>
                                        <span >{{ucfirst($module->name)}}</span>
                                    </a>
                                <li>
                            @endcan
                        @endif
                            @if($module->name == 'Industry')
                            @can('Access '.$module->name)
                                <li>
                                    <a href="/modules/module/{{ $module->name }}" >
                                        <i class="material-icons">radio_button_unchecked</i>
                                        <span >{{ucfirst($module->name)}}</span>
                                    </a>
                                <li>
                            @endcan
                        @endif
                            @if($module->name == 'LeadSource')
                            @can('Access '.$module->name)
                                <li>
                                    <a href="/modules/module/{{ $module->name }}" >
                                        <i class="material-icons">radio_button_unchecked</i>
                                        <span >{{ucfirst(substr_replace( $module->name, ' ', 4, 0 )) }}</span>
                                    </a>
                                <li>
                            @endcan
                        @endif
                            @if($module->name == 'LeadStatus')
                            @can('Access '.$module->name)
                                <li>
                                    <a href="/modules/module/{{ $module->name }}" >
                                        <i class="material-icons">radio_button_unchecked</i>
                                        <span >{{ucfirst(substr_replace( $module->name, ' ', 4, 0 )) }}</span>
                                    </a>
                                <li>
                            @endcan
                        @endif
                    @endforeach
                </ul>
            </div>
        </li>
    </ul>
</li>
@endcan




<br>

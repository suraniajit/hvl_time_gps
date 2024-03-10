@include('panels.nav._header')

<li class=" {{(request()->is('/crm/'.'*')) ? 'active' : '' }}" text='CRM'>

    <?php
    $path = 'CRM';
    $crm_roles_ids = array();
    foreach ($user_role_name as $roles) {
        $crm_roles_ids[] = $roles->roles_id;
    }
    $getCountRolesByRoleid = app('App\Http\Controllers\UserProfileController')->getCountDetailsRoleID($crm_roles_ids, $path);
    if (count($getCountRolesByRoleid) > 0) {
        ?>
        <a class="collapsible-header" href="javascript:void(0);">
            <i class="material-icons">dvr</i>
            <span class="menu-title">CRM</span>
        </a>
        <?php
    }
    ?>


    <div class="collapsible-body" style="">
        <ul class="collapsible collapsible-sub" data-collapsible="accordion">

            @foreach($modules as $module)

            @can('Access '.$module->name)
            @if($module->path === 'CRM')
            <li>
                <a href="/modules/module/{{ $module->name }}" class="{{$custom_classes}} {{ (request()->segment(2) == 'shift') ? 'active '.$configData['activeMenuColor'] : ''}}">
                    <i class="material-icons">radio_button_unchecked</i>
                    <span data-i18n="Analytics">{{ucfirst($module->name)}}</span>
                </a>
            <li>
                @endif
                @endcan
                @endforeach 

<!--            <li>
                <a href="{{route('emailtemplate.index')}}" >
                    <i class="material-icons">color_lens</i>
                    <span class="menu-title" data-i18n="Chat">Email Template</span>
                </a>
            </li>-->
        </ul>
    </div>                    
</li>


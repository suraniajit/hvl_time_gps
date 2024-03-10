@can('Access Job')
<li>
    <a href="/recruitment/jobs/" class="{{$custom_classes}} {{ (request()->segment(2) == 'jobs') ? 'active '.$configData['activeMenuColor'] : ''}}">
        <i class="material-icons">radio_button_unchecked</i>
        <span data-i18n="Analytics">Jobs Management</span>
    </a>
</li>
@endcan

@can('Access Candidate')
<li>
    <a href="/recruitment/candidate">
        <i class="material-icons">color_lens</i>
        <span class="menu-title" data-i18n="Chat">Candidate</span>
    </a>
</li>
@endcan


@can('Access Interview type')
<li>
    <a href="/recruitment/interviewtype">
        <i class="material-icons">color_lens</i>
        <span class="menu-title" data-i18n="Chat">Interview Type</span>
    </a>
</li>
@endcan

@can('Access Status')
<li>
    <a href="/recruitment/status">
        <i class="material-icons">color_lens</i>
        <span class="menu-title" data-i18n="Chat">Interview Status</span>
    </a>
</li>
@endcan


@can('Access Programs')
<li>
    <a href="/recruitment/programs">
        <i class="material-icons">color_lens</i>
        <span class="menu-title" data-i18n="Chat">Programs</span>
    </a>
</li>
@endcan

@can('Access Schedules')
<li>
    <a href="/recruitment/schedules">
        <i class="material-icons">color_lens</i>
        <span class="menu-title" data-i18n="Chat">Schedule</span>
    </a>
</li>
@endcan
@can('Access Assignments')
<li>
    <a href="/recruitment/assignments">
        <i class="material-icons">color_lens</i>
        <span class="menu-title" data-i18n="Chat">Assignments</span>
    </a>
</li>
@endcan
@can('Access Marital Status')
<li>
    <a href="/recruitment/maritalstatus/">
        <i class="material-icons">color_lens</i>
        <span class="menu-title" data-i18n="Chat">Marital Status</span>
    </a>
</li>
@endcan
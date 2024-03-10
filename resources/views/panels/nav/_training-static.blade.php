 

@can('Access Category')
<li>
    <a href="/training/category/" class="{{$custom_classes}} {{ (request()->segment(2) == 'category') ? 'active '.$configData['activeMenuColor'] : ''}}">
        <i class="material-icons">radio_button_unchecked</i>
        <span data-i18n="Analytics">Category Management</span>
    </a>
</li>
@endcan


@can('Access Course')
<li>
    <a href="/training/course/" class="{{$custom_classes}} {{ (request()->segment(2) == 'course') ? 'active '.$configData['activeMenuColor'] : ''}}">
        <i class="material-icons">radio_button_unchecked</i>
        <span data-i18n="Analytics">Course Management</span>
    </a>
</li>
@endcan


@can('Access Questionnaire')
<li>
    <a href="/training/questionnaire/" class="{{$custom_classes}} {{ (request()->segment(2) == 'questionnaire') ? 'active '.$configData['activeMenuColor'] : ''}}">
        <i class="material-icons">radio_button_unchecked</i>
        <span data-i18n="Analytics">Questionnaire Manag</span>
    </a>
</li>
@endcan


@can('Access Simulation Course')
<li>
    <a href="/training/simulate_course/" class="{{$custom_classes}} {{ (request()->segment(2) == 'simulate_course') ? 'active '.$configData['activeMenuColor'] : ''}}">
        <i class="material-icons">radio_button_unchecked</i>
        <span data-i18n="Analytics">Simulate Course</span>
    </a>
</li>
@endcan
@can('Access Simulation Questionnaires')
<li>
    <a href="/training/simulation_questionnaire/" class="{{$custom_classes}} {{ (request()->segment(2) == 'simulation_questionnaire') ? 'active '.$configData['activeMenuColor'] : ''}}">
        <i class="material-icons">radio_button_unchecked</i>
        <span data-i18n="Analytics">Simulation Ques.</span>
    </a>
</li>
@endcan

@if(!empty($component_result))
<option value="2d" {{ $component_result->chart_design=='2d' ? ' selected="" ' : '' }} data-icon="">2D</option>
<option value="3d" {{ $component_result->chart_design=='3d' ? ' selected="" ' : '' }} data-icon="">3D</option>
@else
<option value="2d" selected data-icon="">2D</option>
<option value="3d"  data-icon="">3D</option>
@endif
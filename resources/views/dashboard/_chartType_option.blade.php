
@if(!empty($component_result))
<option value="column" {{ $component_result->chart_type=='column' ? ' selected="" ' : '' }} data-icon="https://t4.ftcdn.net/jpg/02/15/74/57/500_F_215745775_7TZ1yaryLsSKX41fF4KZuD7xABdkx1tv.jpg" class="left">Column Chart</option>
<option value="pie" {{ $component_result->chart_type=='pie' ? ' selected="" ' : '' }} data-icon="https://cdn1.iconfinder.com/data/icons/charts-and-diagrams-1-1/512/piechart-512.png" class="left">Pie Chart</option>
<option value="bar" {{ $component_result->chart_type=='bar' ? ' selected="" ' : '' }} data-icon="https://cdn0.iconfinder.com/data/icons/data-charts/110/BarRandom-512.png" class="left">Bar Chart</option>
<option value="doughnut" {{ $component_result->chart_type=='doughnut' ? ' selected="" ' : '' }} data-icon="https://cdn0.iconfinder.com/data/icons/data-charts/110/BarRandom-512.png" class="left">Doughnut Chart</option>
<option value="funnel" {{ $component_result->chart_type=='funnel' ? ' selected="" ' : '' }} data-icon="https://cdn0.iconfinder.com/data/icons/data-charts/110/BarRandom-512.png" class="left">Funnel Chart</option>
<option value="line" {{ $component_result->chart_type=='line' ? ' selected="" ' : '' }} data-icon="https://cdn0.iconfinder.com/data/icons/data-charts/110/BarRandom-512.png" class="left">Line Chart</option>

@else
<option value="column" data-icon="https://t4.ftcdn.net/jpg/02/15/74/57/500_F_215745775_7TZ1yaryLsSKX41fF4KZuD7xABdkx1tv.jpg" class="left">Column Chart</option>
<option value="pie" data-icon="https://cdn1.iconfinder.com/data/icons/charts-and-diagrams-1-1/512/piechart-512.png" class="left">Pie Chart</option>
<option value="bar"  data-icon="https://cdn0.iconfinder.com/data/icons/data-charts/110/BarRandom-512.png" class="left">Bar Chart</option>
<option value="doughnut" data-icon="https://cdn0.iconfinder.com/data/icons/data-charts/110/BarRandom-512.png" class="left">Doughnut Chart</option>
<option value="funnel" data-icon="https://cdn0.iconfinder.com/data/icons/data-charts/110/BarRandom-512.png" class="left">Funnel Chart</option>
<option value="line" data-icon="https://cdn0.iconfinder.com/data/icons/data-charts/110/BarRandom-512.png" class="left">Line Chart</option>
@endif



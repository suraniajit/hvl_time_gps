<?php

use App\ComponentResult;
use App\Module;

include(app_path() . '/includes/fusioncharts.php');
?>
{{-- layout extend --}}
@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title','HRMS Dashboard ')

@include('dashboard._header')


{{-- page content --}}
@section('content')



<a class="btn-color waves-light btn modal-trigger" href="#dynimicModal">
    <i class='material-icons left'>add</i>Create Dashboard</a>
<!-- Modal Trigger -->
<!-- Modal Structure -->
<div id="dynimicModal" class="modal">
    <div class="modal-content">
        <h4>Create Dashboard</h4>
<!--        <p>A bunch of text</p>-->
        @include('dashboard._partial')
    </div>
</div>

<div class="section">
    <div class="row">
        <?php
        $modules = Module::orderBy('id', 'asc')->get();
        $ComponentResults = ComponentResult::where('is_active', '=', '0')
                        ->Where('path', '=', 'HRMS')
                        ->orderBy('id', 'desc')->get();
        if (count($ComponentResults) > 0) {
            ?>
            @foreach ($ComponentResults as $key => $component_result)
            <?php $no = $key + 1;
            ?>
            <div class="col s6">
                <div class="card horizontal">
                    <div class="card-stacked">
                        <div class="card-content">
                            <?php
                            if ($component_result->is_filter == '1') {
//                                        echo 'it is filter<br>';
                                ?>
                                <input type="hidden" name="component_id" id="component_id" value="{{$component_result->id}}" />
                                <input type="hidden" name="module_grouping" class="module_grouping" value="{{$component_result->module_grouping}}" />
                                <input type="hidden" name="primary_module_id" class="primary_module_id" value="{{$component_result->primary_module_id}}" />
                                <input type="hidden" name="title" id="title" data-name="{{$component_result->component_name}}" value="{{$component_result->component_name}}" />

                                <div class="input-field row">
                                    <div class="input-field col s8">
                                        {{$component_result->component_name}}
                                    </div>
                                    <div class="input-field col s4" style="text-align: right;">
                                        <a href="javascript: void(0)" class="delete_chart" data-id="{{$component_result->id}}">Delete</a>
                                        |<a href="{{route('FusionChart.edit',['id'=>$component_result->id])}}" class="edit_chart" data-id="{{$component_result->id}}">Edit</a>
                                    </div>
                                </div>
                                <div class="input-field">
                                    <select id="select_filter" name="select_filter[]" class="icons" data-error=".errorTxt7">
                                        <option disabled>Select Filter by Chart Type</option>
                                        @include('dashboard._chartType_option')
                                    </select>
                                    <label for="name">Filter by Chart Type</label>
                                </div>


                                <?php $primary_module_filter_result = App\Http\Controllers\FusionChart::getfirstLevelFilter($component_result->primary_module_id, $component_result->module_grouping); ?>

                                <div class="input-field">
                                    @php $values = explode(',', $component_result->secondary_module_filter_save) @endphp
                                    <select class="select2" multiple="multiple" id="select_filter_primary" name="select_filter_primary">
                                        <optgroup label="select {{ucfirst($component_result->primary_module_id)}} filter- {{ucfirst($fitleby=$component_result->module_grouping)}}">
                                            @foreach($primary_module_filter_result as $result_filter)
                                            <option value="{{ $result_filter->$fitleby }}"  
                                                    @foreach($values as $value)
                                                    @if($result_filter->$fitleby === $value) selected @endif
                                                @endforeach
                                                data-id="{{ $result_filter->$fitleby }}">{{$result_filter->$fitleby}}</option>
                                            @endforeach
                                        </optgroup>
                                    </select>
                                    <label for="name">Select {{ucfirst($component_result->primary_module_id)}} Filter</label>
                                </div>

                                <?php
                            }
//                                    echo '000' . $component_result->chart_type;
                            ?>
                            <?php
                            $chartType = $component_result->chart_type . '' . $component_result->chart_design;
                            $chartNo = 'chart_' . $no;
                            $chartContainer = 'chart_container_' . $no;
                            $chartHight = '100%';
                            $chartWidth = '500';
                            $i = new FusionCharts($chartType, $chartNo, $chartHight, $chartWidth, $chartContainer, "json", $component_result->chartData);
                            $i->render();
                            ?>
                        </div>
                        <div class="card-action">
                            <div id="{{$chartContainer}}">Chart will render here!</div>
                        </div>
                        <div class="card-action">
                            <?php
                            //$secChart = new FusionCharts("pie2d", "chartTwo", '600', '400', "chart-2", "json", $component_result->secondChartData);
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        <?php } else { ?>
            <div class="row">
                <div class="animate fadeLeft">
                    <div class="dashboard-revenue-wrapper center padding-0 ">
                        <h5>Records is not found..</h5>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>
</div>

@endsection

{{-- page scripts --}}
@section('page-script')
<script>
    $(document).ready(function () {
        $('.modal').modal();
    });
</script>
@endsection


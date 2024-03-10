@php
    if($user->hasPermissionTo('generate audit')){
        @php
            $generate_audit = true;
        @endphp
    }
    $model = $audit_list;
    $index_start = $audit_list->perPage() * ($audit_list->currentPage() - 1);
@endphp
<table id="page-length-option" class="table table-striped table-hover multiselect">
    <thead>
        <tr>
            <th class="sorting_disabled" width="5%">
                <label>
                    <input type="checkbox" class="select-all m-1"/>
                    <span></span>
                </label>
            </th>
            <th width='5%'>ID</th>
            <th width='15%'>Action</th>
            @if($generate_audit)
                <th width='15%'>Generated</th>
            @endif
            <th width='15%'>Audit Type</th>
            <th width='15%'>Branch</th>
            <th width='15%'>Customer Code</th>
            <th width='15%'>Customer</th>
            <th width='25%'>Schedule At</th>
        </tr>
    </thead>
    <tbody>
        @foreach($audit_list as $key => $data)
        <tr>
            <td>
                @if($data->generated == 'no')
                <label>
                    <input type="checkbox" data-id="{{ $data->id }}"
                            name="selected_row"/>
                    <span></span>
                </label>
                @endif
            </td>
            <td>{{$index_start + $key+1}}</td>
            <td>
                @if($read_audit == true)
                <a href="{{ route('admin.audit.view', $data->id) }}"
                    class="tooltipped mr-10"
                    data-position="top"
                    data-tooltip="View"
                    target="_blank">
                    <span class="fa fa-eye"></span>
                </a>
                @endif
                @if($data->generated == 'no')
                    @if($edit_audit == true)
                        <a href="{{ route('admin.audit.edit', $data->id) }}"
                        class="tooltipped mr-10"
                        data-position="top"
                        data-tooltip="Edit"
                        target="_blank">
                            <span class="fa fa-edit"></span>
                        </a>
                    @endif
                    @if($delete_audit)
                        <a href="" class="button" data-id="{{$data->id}}"><span class="fa fa-trash"></span></a>
                    @endif
                @endif
            </td>
            @if($generate_audit)    
                <td>
                    <a href="{{route('admin.audit_generate.index',$data->id)}}" class="btn btn-primary mr-2" type="submit" target="_blank" >
                        <i class="fa fa-save"></i>
                        {{($data->generated == 'no')?'Generate':'Generated'}}
                    </a>
                </td>
            @endif
            <td  width='5%'>{{$data->getAuditTypeText($data->audit_type)}}</td>
            <td  width='5%'>{{$data->branch}}</td>
            <td  width='5%'>{{$data->customer_code}}</td>
            <td  width='5%'>{{$data->customer_name}}</td>
            <td  width='5%'>{{$data->schedule_date}}</td>
        </tr>
        @endforeach
    </tbody>
</table>
<form method="POST" id="pagination_form" >
    @csrf
    @foreach($search_param as $key=>$values)
        @if($key == 'customers_id')
            @foreach($values as $value)
                <input type="hidden" name="{{$key}}[]" value="{{$value}}">
            @endforeach
        @else
            <input type="hidden" name="{{$key}}" value="{{$values}}">
        @endif
    @endforeach
    @php 
        $helper = new Helper();
    @endphp
    <?=$helper->paginateLink($model)?>
</form>
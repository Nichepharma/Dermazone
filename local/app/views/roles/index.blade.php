@extends('layout.main')

@section('head')
    <h3 class="inline-block">{{ translate('main.'.$data['modules']) }}</h3>
    <input id="filter" type="text" class="form-control top-search-box marginleft25" placeholder="{{translate('main.search')}}" />
    {{ link_to_route(''.$data['modules'].'.create',translate('main.add').' '.translate('main.'.$data['module']), null, array('class' => 'btn btn-success pull-right')) }}
@stop

@section('main')

	<div class="col-md-12">
	@if ($data['model']->count())
			{{Form::open(['id'=>'form_datalist','route'=>$data['modules'].'.multiaction'])}}
			<table class="table table-striped table-condensed table_datalist" data-filter="#filter" data-filter-timeout="5">
			<thead>
				<tr>
					<th data-sort-ignore="true">*</th>
                    <th>{{translate('main.name')}}</th>
					<th>{{translate('main.level')}}</th>
					<th>{{translate('main.description')}}</th>
					<th>{{translate('main.active')}}</th>
                    <th data-sort-ignore="true">{{translate('main.actions')}}</th>
				</tr>
			</thead>

			<tbody>
				@foreach ($data['model'] as $record)
					<tr>
						<td>{{Form::checkbox('rows['.$record->id.']', 1, false, ['class'=>'row-checkbox'])}}</td>
						<td>{{ $record->name }}</td>
						<td>{{ $record->level }}</td>
						<td>{{ str_limit($record->description, 100, $end = '...') }}</td>
						<td class="activation">

                            @if($record->id==1)
                                <a title="{{translate('main.can\'t be changed')}}" data-toggle="tooltip" class="btn btn-sm btn-success fa fa-toggle-on"></a>
                            @else
                                <a title="{{translate('main.change status')}}" data-toggle="tooltip" class="status_doaction btn btn-sm btn-{{ getEqual('status_class',$record->active) }} fa fa-toggle-{{ getEqual('status_toggle',$record->active) }}" model="{{$data['modules']}}" id="{{$data['module']}}-{{ $record->id }}" ></a>
                            @endif

						</td>
						<td>
							<a href="#" class="btn btn-warning btn-sm" data-toggle="tooltip" title="" data-original-title="{{{ record_info($record) }}}"><i class="fa fa-info"></i></a>

                            <a @if($record->id==1)
                                title="{{translate('main.can\'t be changed')}}"
                                @else
                                href="{{url($data['modules'].'/'.$record->id.'/edit')}}" title="{{translate('main.edit')}}"
                                @endif
                                data-toggle="tooltip" class="btn btn-sm btn-info fa fa-edit"></a>

                            <a @if($record->id==1)
                                title="{{translate('main.can\'t be changed')}}"
                                @else
                                title="{{translate('main.delete')}}" onclick="confirmDeleteRow( '{{$record->name}}' , '{{ url($data['modules'].'/'.$record->id) }}' )"
                                @endif

                                data-toggle="tooltip" class="btn btn-danger btn-sm fa fa-trash-o"></a>


	                    </td>
					</tr>
				@endforeach
			</tbody>
            <tfoot class="hide-if-no-paging">
                <tr>
                    <td colspan="8">
                        <div class="pagination pagination-centered"></div>
                    </td>
                </tr>
            </tfoot>
		</table>
			<div class="well well-sm form-inline">
                @include('layout.table_footer_links')
			</div>
			{{Form::close()}}

		@else
		<p class="alert alert-danger">No {{ $data['modules'] }}</p>
	@endif
	</div>

@stop
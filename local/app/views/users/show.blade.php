<div class="modal-header modal-header-primary">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	<h3 class="modal-title">{{getEqual('title',$user->title).' '.$user->username}}</h3>
</div>
<div class="modal-body">


    <table class="table table-striped table-hover">
		<tr>
			<th class="text-capitalize">{{translate('main.email')}}:</th>
			<td>{{ $user->email }}</td>
		</tr>
		<tr>
			<th class="text-capitalize">{{translate('main.mobile')}}:</th>
			<td>{{ $user->mobile }}</td>
		</tr>
		<tr>
			<th class="text-capitalize">{{translate('main.department')}}:</th>
			<td>{{ @$user->department->name }}</td>
		</tr>
        <tr>
            <th class="text-capitalize">{{translate('main.image')}}:</th>
            <td>{{ display_img('users', $user->image) }}</td>
        </tr>

    </table>

    {{record_info2($user)}}


</div>
<div class="modal-footer">
    <a class="btn btn-primary fa fa-edit" href="{{url('users/'.$user->id.'/edit')}}"> {{translate('main.edit')}}</a>
	{{ Form::button(translate('main.close'), ['data-dismiss' => 'modal', 'class' => 'btn btn-default']) }}
</div>

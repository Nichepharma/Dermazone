@extends('layout.main')

@section('content')
    <div class="col-md-12">
        <div class="col-sm-5"><h2>Users</h2></div>
        <div class="col-sm-7">
            <a href="{{url('users/create')}}" class="btn btn-default pull-right" style="margin-top: 10px;">Create User</a>
        </div>
        <hr>
        @if (!empty($data['users']))
            <table class="table">
                <thead>
                <tr>
                    <th>*</th>
                    <th>User Name</th>
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th></th>
                </tr>
                </thead>

                <tbody>
                <?php $i = 0 ?>
                @foreach ($data['users'] as $user)
                    <?php $i++; ?>
                    <tr>
                        <td>{{ $i }}</td>
                        <td>{{ $user->username }}</td>
                        <td>{{ $user->fullname }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            @if(!empty($user->roles))
                                @foreach($user->roles as $user_role)
                                    {{$user_role->name}} &nbsp;
                                @endforeach
                            @endif
                        </td>
                        <td>
                            <a class="btn btn-sm btn-primary" href="{{url($data['modules'].'/'.$user->id.'/edit')}}">Edit</a>
                            <a class="btn btn-sm btn-danger" @if($user->id>1) onclick="confirmDeleteRow( '{{$user->username}}' , '{{ url('users/'.$user->id) }}' )" @endif>Delete</a>

                        </td>
                    </tr>
                @endforeach
                </tbody>
                <tfoot class="hide-if-no-paging">
                <tr>
                    <td colspan="10">
                        <div class="pagination pagination-centered"></div>
                    </td>
                </tr>
                </tfoot>
            </table>
        @else
            <p>No Users</p>
        @endif
    </div>

@stop

@section('footer_inc')
    <div class="modal fade" id="modal-confirmDelete" tabindex="-1" role="dialog" aria-labelledby="confirmDelete" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header modal-header-danger">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h3 class="modal-title">{{translate('main.delete')}}</h3>
                </div>
                <div class="modal-body">
                    <p>
                        <strong>{{translate('main.are you sure you want to remove the following record')}}?</strong>
                    </p>
                    <p id="deletePageName" class="alert alert-danger"></p>
                </div>
                <div class="modal-footer">
                    {{ Form::open(array('id' => 'deleteForm', 'method' => 'delete')) }}
                    {{ Form::button(translate('main.cancel'), array(
                        'data-dismiss' => 'modal',
                        'class' => 'btn btn-default',
                    )) }}
                    {{ Form::submit(translate('main.delete'), array(
                        'class' => 'btn btn-danger',
                    )) }}
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
@stop
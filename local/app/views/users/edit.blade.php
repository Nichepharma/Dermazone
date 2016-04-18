@extends('layout.main')

@section('content')

    <div class="col-md-12">
        <h2>Edit User</h2>

        {{ Form::model($data['theUser'], array('class' => 'form-horizontal validate', 'method' => 'PATCH', 'route' => array('users.update', $data['theUser']->id), 'files'=>true)) }}

        <div class="row">

            <div class="col-md-6 form-left-side">
                <div class="form-group">
                    {{ Form::label('username', 'username', array('class'=>'control-label col-md-2')) }}
                    <div class="col-md-8">
                        {{ Form::text('username', $data['theUser']->username, array('class'=>'form-control username', 'placeholder'=>'name','required')) }}
                    </div>
                </div>
                <div class="form-group">
                    {{ Form::label('fullname', 'full name', array('class'=>'control-label col-md-2')) }}
                    <div class="col-md-8">
                        {{ Form::text('fullname', $data['theUser']->fullname, array('class'=>'form-control fullname', 'placeholder'=>'name','required')) }}
                    </div>
                </div>
                <div class="form-group">
                    {{ Form::label('email', 'email', array('class'=>'control-label col-md-2')) }}
                    <div class="col-md-8">
                        {{ Form::email('email', $data['theUser']->email, array('class'=>'form-control', 'placeholder'=>'email','required')) }}
                    </div>
                </div>
                <div class="form-group">
                    {{ Form::label('phone', 'phone', array('class'=>'control-label col-md-2')) }}
                    <div class="col-md-8">
                        {{ Form::text('phone', $data['theUser']->phone, array('class'=>'form-control', 'placeholder'=>'phone','required','minlength'=>10,'number')) }}
                    </div>
                </div>
                <div class="form-group">
                    {{ Form::label('password', 'password', array('class'=>'control-label col-md-2')) }}
                    <div class="col-md-8">
                        <a href="#" class="btn btn-info" data-toggle="modal" data-target="#chPassword_Modal">change password</a>
                    </div>
                </div>
                <div class="form-group">
                    {{ Form::label('province_id', 'province', ['class'=>'control-label col-md-2']) }}
                    <div class="col-md-8">
                        {{ Form::select('province_id',$data['provinces'],$data['theUser']->province_id,['class'=>'form-control chosen ','data-placeholder'=>'choose province']) }}
                    </div>
                </div>
                <div class="form-group">
                    {{ Form::label('city_id', 'city', ['class'=>'control-label col-md-2']) }}
                    <div class="col-md-8">
                        {{ Form::select('city_id',$data['cities'],$data['theUser']->city_id,['class'=>'form-control chosen ','data-placeholder'=>'choose city']) }}
                    </div>
                </div>

                <div class="form-group">
                    {{ Form::label('area_id', 'area', ['class'=>'control-label col-md-2']) }}
                    <div class="col-md-8">
                        {{ Form::select('area_id',$data['areas'],$data['theUser']->area_id,['class'=>'form-control chosen','data-placeholder'=>'choose area']) }}
                    </div>
                </div>
                <div class="form-group">
                    {{ Form::label('status', 'active', array('class'=>'control-label col-md-2')) }}
                    <div class="col-md-8" style="padding-top: 5px;">
                        <input name="disabled" type="checkbox" @if($data['theUser']->disabled==0)
                        checked="checked" @endif />
                    </div>
                </div>
                <div class="form-group">
                    {{ Form::label('status', 'user role', array('class'=>'control-label col-md-2')) }}
                    <div class="col-sm-8">
                        @foreach ($data['roles'] as $role)
                            <?php
                            $checked = false;
                            if (!empty($data['theUserRole']->id) && $role->id == $data['theUserRole']->id) {
                                $checked = true;
                            }
                            ?>
                            <div class="col-md-12">
                                {{ Form::radio('roles', $role->id, $checked, ['id'=>'id_'.$role->name]) }}
                                {{ Form::label('id_'.$role->name, $role->name,['class'=>'control-label']) }}
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="col-md-6 form-right-side">
                <div class="form-group">
                    {{ Form::label('supervisors', 'supervisor', ['class'=>'control-label col-md-2']) }}
                    <div class="col-md-8">
                        {{ Form::select('supervisors[]',$data['allUsers'],$data['supervisors'],
                            ['class'=>'form-control chosen','data-placeholder'=>'choose supervisor','multiple'=>'multiple']) }}
                    </div>
                </div>
                <div class="form-group">
                    {{ Form::label('subUsers', 'sub Users', ['class'=>'control-label col-md-2']) }}
                    <div class="col-md-8">
                        {{ Form::select('subUsers[]',$data['allUsers'],$data['subUsers'],
                            ['class'=>'form-control chosen','data-placeholder'=>'choose sub users','multiple'=>'multiple']) }}
                    </div>
                </div>
                <div class="form-group maxH300">
                    {{ Form::label('userDoctors', 'user Doctors', ['class'=>'control-label col-md-2']) }}
                    <div class="col-md-8">
                        {{ Form::select('userDoctors[]',$data['allDoctors'],$data['userCustomers'],
                            ['class'=>'form-control chosen','data-placeholder'=>'choose Doctors','multiple'=>'multiple']) }}
                    </div>
                </div>
                <div class="form-group maxH300">
                    {{ Form::label('userPharmacies', 'user Pharmacies', ['class'=>'control-label col-md-2']) }}
                    <div class="col-md-8">
                        {{ Form::select('userPharmacies[]',$data['allPharmacies'],$data['userCustomers'], ['class'=>'form-control chosen','data-placeholder'=>'choose Pharmacies','multiple'=>'multiple']) }}
                    </div>

                </div>
            </div>

        </div>

        <div class="clearfix">
            <hr>
        </div>
        <div class="row">
            <div class="col-sm-6">

            </div>
        </div>

        <div class="form-group">
            <div class="col-md-8 col-md-offset-2">
                {{ Form::submit('save', ['class' => 'btn btn-primary']) }}
                {{ link_to_route('users.index','cancel', $data['theUser']->id, ['class' => 'btn btn-default']) }}
            </div>
        </div>

    </div>
    {{ Form::close() }}
@stop

@section('footer_inc')

    <div class="modal fade" id="chPassword_Modal">
        <div class="modal-dialog">
            {{ Form::open(['url'=>'users/change-password','id'=>'frm_status_model','class'=>'form-horizontal']) }}
            <div class="modal-content">
                <div class="modal-header modal-header-primary">
                    <button type="button" class="close" data-dismiss="modal"><span
                                aria-hidden="true">&times;</span><span
                                class="sr-only">close</span></button>
                    <h4 class="modal-title">change password</h4>
                </div>
                <div class="modal-body">
                    {{ Form::hidden('user_id',$data['theUser']->id,['class'=>'user_id_modal']) }}
                    <div class="form-group">
                        <div class="col-sm-10 col-sm-offset-1">
                            {{ Form::label('password', 'new password', array('class'=>'control-label')) }}
                            {{ Form::password('new_password',array('class'=>'form-control', 'placeholder'=>'new_password','required')) }}
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default"
                            data-dismiss="modal">close</button>
                    <button type="submit" class="btn btn-success status_btn">save</button>
                </div>
            </div>
            {{ Form::close() }}
        </div>
    </div>

    {{ HTML::style('assets/css/chosen.min.css') }}
    {{HTML::script('assets/js/chosen.jquery.min.js')}}
    {{ HTML::script('assets/js/jquery.validate.js') }}
    {{ HTML::style('assets/needim-noty/animate.css') }}
    {{ HTML::script('assets/needim-noty/jquery.noty.packaged.min.js') }}

@stop

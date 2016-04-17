@extends('layout.main')

@section('content')
    <div class="col-md-12">
        <h2>Create User</h2>

        {{ Form::open(array('route' => 'users.store', 'class' => 'form-horizontal validate')) }}
        <div class="row">
            <div class="col-md-8">
                <div class="box box-primary form_wrapper">

                    <div class="form-group">
                        {{ Form::label('username', translate('main.username'), array('class'=>'control-label col-md-2')) }}
                        <div class="col-md-8">
                            {{ Form::text('username', '', array('class'=>'form-control username', 'placeholder'=>translate('main.name'), 'required')) }}
                        </div>
                    </div>
                    <div class="form-group">
                        {{ Form::label('fullname', translate('main.full name'), array('class'=>'control-label col-md-2')) }}
                        <div class="col-md-8">
                            {{ Form::text('fullname', '', array('class'=>'form-control fullname', 'placeholder'=>translate('main.name'), 'required')) }}
                        </div>
                    </div>
                    <div class="form-group">
                        {{ Form::label('email', translate('main.email'), array('class'=>'control-label col-md-2')) }}
                        <div class="col-md-8">
                            {{ Form::email('email', '', array('class'=>'form-control', 'placeholder'=>translate('main.email'),'required')) }}
                        </div>
                    </div>
                    <div class="form-group">
                        {{ Form::label('phone', translate('main.phone'), array('class'=>'control-label col-md-2')) }}
                        <div class="col-md-8">
                            {{ Form::text('phone', '', array('class'=>'form-control', 'placeholder'=>translate('main.phone'),'required','number')) }}
                        </div>
                    </div>
                    <div class="form-group">
                        {{ Form::label('password', translate('main.password'), array('class'=>'control-label col-md-2')) }}
                        <div class="col-md-8">
                            {{ Form::password('pass', array('class'=>'form-control', 'placeholder'=>translate('main.password'))) }}
                        </div>
                    </div>
                    <div class="form-group">
                        {{ Form::label('province_id', translate('main.province'), ['class'=>'control-label col-md-2']) }}
                        <div class="col-md-8">
                            {{ Form::select('province_id',$data['provinces'],'',['class'=>'form-control chosen '.translate('main.chosen'),'data-placeholder'=>translate("main.choose province")]) }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">


                <div class="box clearfix box-primary form_wrapper">
                    <div class="col-md-12">
                        <span class="text-primary">{{translate('main.user role')}}</span>

                        <div class="row">
                            @foreach ($data['roles'] as $role)
                                <div class="col-md-12">
                                    {{ Form::radio('roles', $role->id, false, ['id'=>'id_'.$role->name]) }}
                                    {{ Form::label('id_'.$role->name, $role->name,['class'=>'control-label']) }}
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-8">
                {{ Form::submit(trans('main.create'), array('class' => 'btn btn-primary')) }}
                {{ link_to_route('users.index',trans('main.cancel'), '', array('class' => 'btn btn-default')) }}
            </div>
        </div>

        {{ Form::close() }}
    </div>
@stop

@section('footer_inc')
    {{ HTML::style('assets/css/chosen.min.css') }}
    {{HTML::script('assets/js/chosen.jquery.min.js')}}
    {{ HTML::script('assets/js/jquery.validate.js') }}
    {{ HTML::style('assets/needim-noty/animate.css') }}
    {{ HTML::script('assets/needim-noty/jquery.noty.packaged.min.js') }}
@stop

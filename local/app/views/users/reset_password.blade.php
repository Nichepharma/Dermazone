@extends('users.head')

@section('content')

    <body class="login-page">
    <div class="login-box">
        <div class="login-logo">
            <a><b>Reset Password</b></a>
        </div><!-- /.login-logo -->

        @if(Session::has('message'))
            <div class="alert alert-{{Session::get('alert')}} progress-bar-striped">
                {{ Session::get('message') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <button type="button" class="close" data-dismiss="alert">
                    <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
                </button>
                <ul>
                    {{ implode('', $errors->all('<li class="error">:message</li>')) }}
                </ul>
            </div>
        @endif


        <div class="login-box-body">
            <p class="login-box-msg">Enter your email to reset your password</p>

            {{ Form::open(['route'=>'reset_password','class'=>'content-box']) }}
            <div class="form-group has-feedback">
                {{ Form::text('email', Input::old('email'), array('class'=>'form-control', 'placeholder'=>'Email Address ...')) }}
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                    <button type="submit" class="btn btn-primary btn-block btn-flat" data-loading-text="{{translate('loading') }}...">Send Email</button>
            </div>
            {{ Form::close() }}

            {{--<a href="{{ url('login') }}">Back to Login</a>--}}

        </div><!-- /.login-box-body -->
    </div><!-- /.login-box -->

@stop
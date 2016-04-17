@extends('users.head')

@section('content')

	<body class="login-page">
	<div class="login-box">
		<div class="login-logo">
			<a><b>Register to CRM</b></a>
		</div><!-- /.login-logo -->

		<div class="row">
			<div class="col-md-12">
				@if ($errors->any())
					<div class="alert alert-danger">
						<button type="button" class="close" data-dismiss="alert">
							<span aria-hidden="true">&times;</span><span class="sr-only">{{ trans('close') }}</span>
						</button>
						<ul>
							{{ implode('', $errors->all('<li class="error">:message</li>')) }}
						</ul>
					</div>
				@endif
			</div>
		</div>


		<div class="register-box-body">
			<p class="login-box-msg">Register a new membership</p>
			{{ Form::open(array('route' => 'signup', 'class' => 'validate')) }}
				<div class="form-group has-feedback">

                    {{ Form::label('username', translate('main.username')) }}
                    {{ Form::text('username', '', array('class'=>'form-control', 'placeholder'=>'Name','required')) }}
					<span class="glyphicon glyphicon-user form-control-feedback"></span>
				</div>
				<div class="form-group has-feedback">
                    {{ Form::label('email', translate('main.email')) }}
					{{ Form::email('email', '', array('class'=>'form-control', 'placeholder'=>'Email','required')) }}
					<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
				</div>
				<div class="form-group has-feedback">
                    {{ Form::label('mobile', translate('main.mobile')) }}
					{{ Form::text('mobile', '', array('class'=>'form-control', 'placeholder'=>'Mobile','required','number')) }}
					<span class="glyphicon glyphicon-mobile form-control-feedback"></span>
				</div>
				<div class="form-group has-feedback">
                    {{ Form::label('password', translate('main.password')) }}
					{{ Form::text('password', Input::old('password'), array('class'=>'form-control', 'placeholder'=>'Password')) }}
					<span class="glyphicon glyphicon-lock form-control-feedback"></span>
				</div>
				<div class="row">
					<div class="col-xs-8">
						<div class="checkbox icheck">
                            <a href="{{url('login')}}" class="text-center">I already have a membership</a>
						</div>
					</div><!-- /.col -->
					<div class="col-xs-4">
						<button type="submit" class="btn btn-primary btn-block btn-flat" data-loading-text="{{translate('loading') }}...">Register</button>
					</div><!-- /.col -->
				</div>
			</form>

		</div><!-- /.form-box -->
	</div><!-- /.login-box -->

	</body>


@stop
<!DOCTYPE html>
<html class="full" lang="en">

<head>

	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="">
	<meta name="author" content="">
	<link rel="shortcut icon" href="favicon.ico"/>
	<title>Tacit</title>

	<!-- Bootstrap Core CSS -->
	{{ HTML::style('assets/css/bootstrap.min.css')}}
	{{ HTML::style('assets/css/bootstrap-datetimepicker.min.css')}}
	{{ HTML::style('assets/css/mediaqueries.css')}}
	{{ HTML::style('assets/css/mediaqueries2.css')}}
	{{ HTML::style('assets/Menu/tinydropdown.css')}}
	{{ HTML::style('assets/css/custom.css')}}


	<!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <!--[endif]-->

	@yield('head_inc')


</head>
<body class="fulllogin">

<div class="container page-login">
	@yield('content')
</div><!-- ./Forget Password Part -->



{{ HTML::script('assets/js/jquery-1.11.0.js') }}
{{ HTML::script('assets/js/bootstrap.min.js') }}
<script type="text/javascript">


	$(document).ready(function(){

		$("#forgetpart").css({'display':'none'});

		$("#forgeturpass").click(function(){
			$("#forgetpart").fadeIn();
			$("#loginpart").css({'display':'none'});
		});

	});


</script>
@yield('footer_inc')
<div class="loader"></div>
</body>
</html>
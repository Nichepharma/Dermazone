<!DOCTYPE html>
<html class="full" lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="{{asset('assets/images/favicon.png')}}"/>
    <title>Tacit @if(!empty($data['page_title'])) | {{$data['page_title']}}@endif</title>

    <!-- Bootstrap Core CSS -->
    {{ HTML::style('assets/css/bootstrap.min.css')}}
    {{ HTML::style('assets/css/bootstrap-datetimepicker.min.css')}}
    {{ HTML::style('assets/css/mediaqueries.css')}}
    {{ HTML::style('assets/css/mediaqueries2.css')}}
    {{ HTML::style('assets/Menu/tinydropdown.css')}}
    {{ HTML::style('assets/css/custom.css')}}
    <link rel="stylesheet" href="{{asset('assets/css/print.css')}}" type="text/css" media="print" />


    <!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<!--[endif]-->

    {{ HTML::script('assets/Menu/tinydropdown.js') }}


    @yield('head_inc')


</head>
<body ng-app="myApp" ng-controller="gridCtrl">

<!-- Header -->
<header class="page-head" role="header">
    <div class="row">

        <div class="col-md-8 col-xs-12">
            @include('layout.menu')
        </div>

        <div class="col-md-4 col-xs-12 topuserpart">

            <div class="dropdown top-user-menu">
                <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                    <i class="glyphicon glyphicon-user blue"></i> {{str_limit($data['user']->fullname,25)}}
                    <span class="caret"></span>
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                    <li><a href="{{url('logout')}}"><i class="glyphicon glyphicon-remove-circle blue"></i> Log out</a></li>
                </ul>
            </div>
            <img src="{{url('assets/images/logo-inner.png')}}" border="0" alt=""/>
        </div>
    </div>
    <!-- /.container -->
    <div class="container-fluid subMenu">
        @if(Session::has('startDate') && Session::has('endDate'))
            <div class="col-sm-2">
                <b>From:</b> {{$data['startDate']}}<br>
                <b>To:</b> {{$data['endDate']}}
            </div>
            <div class="col-sm-9">
                @yield('subMenu')
            </div>
        @endif
    </div>
</header>

<div class="container-fluid @if(isset($data['page']) && $data['page']=='home') page-content @else page-content1 @endif">
    <div class="row">
        @if(Session::has('message'))
            <div class="alert alert-{{Session::get('alert')}} progress-bar-striped">
                {{ Session::get('message') }}
            </div>
        @endif

        @yield('content')
    </div>
</div>


{{ HTML::script('assets/js/jquery-1.11.0.js') }}
{{ HTML::script('assets/js/bootstrap.min.js') }}
{{ HTML::script('assets/js/moment.min.js') }}
{{ HTML::script('assets/js/bootstrap-datetimepicker.js') }}
{{ HTML::script('assets/js/custom.js') }}

@include('layout.scripts')

@yield('footer_inc')
<div class="loader-modal"></div>
</body>
</html>
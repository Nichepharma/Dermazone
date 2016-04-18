<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Tacit {{@$data['page_title']}}</title>
    <link rel="shortcut icon" href="{{ asset('assets/css/images/fav.png') }}">
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    {{HTML::style('assets/css/font-awesome.min.css')}}
    {{HTML::style('framework/dist/css/AdminLTE.min.css')}}
    {{HTML::style('framework/dist/css/skins/_all-skins.min.css')}}
    {{HTML::style('framework/plugins/iCheck/flat/blue.css')}}
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->

    {{HTML::style('assets/css/bootstrap.min.css')}}
    {{ HTML::style('assets/css/custom.css') }}
    {{ HTML::style('assets/css/footable.core.min.css') }}
    {{ HTML::style('assets/css/footable.metro.min.css') }}
    {{ HTML::style('assets/css/cmxformTemplate.css') }}
    {{ HTML::style('assets/css/cmxform.css') }}
    {{ HTML::style('assets/css/magnific-popup.css') }}
    {{ HTML::style('assets/css/jquery.tagsinput.css') }}
    {{ HTML::style('assets/css/chosen.min.css') }}
</head>

        <div class="error-page" style="margin-top: 15%;">
            <h2 class="headline text-yellow"> 404</h2>
            <div class="error-content" style="padding-top: 25px;">
                <h3><i class="fa fa-warning text-yellow"></i> Oops! Page not found.</h3>
                <p>
                    We could not find the page you were looking for.
                    Meanwhile, you may <a href='{{url('home')}}'>Return to Dashboard</a>.
                </p>
            </div><!-- /.error-content -->
        </div><!-- /.error-page -->

    </body>
    </html>




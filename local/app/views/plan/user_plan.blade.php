@extends('layout.main')

@section('content')
    <div class="container-fluid page-content1">

        @include('others.print_buttons')

        <h2><i class="glyphicon glyphicon-user"></i> {{$data['user']->fullname}}</h2>

        <div class="col-sm-12" id="planTable">
        </div>

    </div>
@stop

@section('footer_inc')
    <script>
        function getPlan(weekStart) {
            $.get('{{url('plan/user-plan/'.$data['user']->id)}}',
                    { from: weekStart }
                    , function( data ) {
                $( "#planTable" ).html( data );
            });
        }

        getPlan('{{date('Y-m-d', strtotime("last Saturday"))}}');

    </script>
@stop
@extends('layout.main')

@section('subMenu')
    <a href="{{url('insights/products')}}" class="submenubuttons active">PRODUCT</a>
    <a href="{{url('insights/provinces')}}" class="submenubuttons">province</a>
    <a href="{{url('insights/accumulative')}}" class="submenubuttons">ACCUMULATIVE</a>
    <a href="{{url('insights/interval')}}" class="submenubuttons">INTERVAL</a>
@stop

@section('content')
    <div class="page-content1">

        @include('layout.inner_left_menu',[
        'items'=>$data['products'],
        'url'=>'insights/user-product/'.$data['theUser']->id,
        'title'=>'Products',
        ])
        <div class='col-md-10 col-xs-12'>
            @include('others.print_buttons')

            <div class="graphContainer">
                <h2 class="graphTitle"> Calls per Product for Rep. ({{$data['theUser']->fullname}}) - {{$data['countCalls']}} </h2>
                <div id="chart_div"></div>
            </div>

        </div>
    </div>
@stop

@section('footer_inc')
    <script type="text/javascript" src="http://www.google.com/jsapi"></script>
    <script type='text/javascript'>
        function LoadGoogle() {
            if (typeof google != 'undefined' && google && google.load) {
                google.load("visualization", "1", {packages: ["corechart"]});
                google.setOnLoadCallback(drawChart);
            }
            else {
                // Retry later...
                setTimeout(LoadGoogle, 30);
            }
        }

        LoadGoogle();


        function drawChart() {
            var data = google.visualization.arrayToDataTable([
                ['Medical Reps', @foreach($data['products'] as $product) '{{$product}}', @endforeach ],
                ['', @foreach($data['calls'] as $callsCount) {{$callsCount}}, @endforeach ],
            ]);

            var options = {
                title: "",
                hAxis: {title: '', titleTextStyle: {color: 'red'}}
            };

            var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));

            chart.draw(data, options);
        }
    </script>
@stop
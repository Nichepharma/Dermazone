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
        'url'=>'insights/product',
        'active'=>$data['productId'],
        'title'=>'Products',
        ])

        <div class='col-md-10 col-xs-12'>
            @include('others.print_buttons')

            <div class="container">
                @if($data['specialities'])
                    <div class="col-md-11">
                    @foreach($data['specialities'] as $speciality)
                        <div class="col-md-2 col-xs-6">
                            <a class="buttonallsite3">{{$speciality['title']}}</a>
                        </div>
                    @endforeach
                        </div>
                @endif
            </div>

            <div class="graphContainer">
                <h2 class="graphTitle"> Calls per segment for - {{$data['countCalls']}} </h2>
                <div id="chart_div"></div>
            </div>

            <div class="graphContainer">
                <h2 class="graphTitle">Call Slide Analysis for {{$data['productName']}} </h2>
                <div id="chart_div2"></div>
            </div>


        </div>
    </div>
@stop

@section('footer_inc')
    <script type="text/javascript" src="http://www.google.com/jsapi"></script>
    <script type='text/javascript'>
        LoadGoogle();

        function LoadGoogle() {
            if (typeof google != 'undefined' && google && google.load) {
                google.load("visualization", "1", {packages: ["corechart"]});
                google.setOnLoadCallback(drawChart);
                google.setOnLoadCallback(drawChart2);

            }
            else {
                // Retry later...
                setTimeout(LoadGoogle, 30);
            }
        }
        function drawChart() {
            var data = google.visualization.arrayToDataTable([
                ['Medical Reps',
                    @if($data['specialities'])
                        @foreach($data['specialities'] as $speciality)
                            '{{$speciality['title']}}',
                        @endforeach
                    @endif
                ], ['',
                    @if($data['specialities'])
                        @foreach($data['specialities'] as $speciality)
                            {{$speciality['visits']}},
                        @endforeach
                    @endif
                ],
            ]);

            var options = {
                title: "",
                hAxis: {title: '', titleTextStyle: {color: 'red'}}
            };

            var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));

            chart.draw(data, options);
        }


        function drawChart2() {

            @if(isset($data['slides']))
            // Create the data table.
            var data = new google.visualization.DataTable();
            data.addColumn('string', 'Page');
            data.addColumn('number', 'Seconds');
            data.addRows([
                    @foreach($data['slides'] as $slideName=>$slideCalls)
                ['{{$slideName}}', {{$slideCalls}}],
                @endforeach
            ]);
            @endif

            // Set chart options
            var options = {
                'title': '',
                'width': 800,
                'height': 450
            };

            // Instantiate and draw our chart, passing in some options.
            var chart = new google.visualization.PieChart(document.getElementById('chart_div2'));
            chart.draw(data, options);
        }

    </script>
@stop
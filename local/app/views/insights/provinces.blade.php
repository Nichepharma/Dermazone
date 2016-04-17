@extends('layout.main')

@section('subMenu')
    <a href="{{url('insights/products')}}" class="submenubuttons">PRODUCT</a>
    <a href="{{url('insights/provinces')}}" class="submenubuttons active">province</a>
    <a href="{{url('insights/accumulative')}}" class="submenubuttons">ACCUMULATIVE</a>
    <a href="{{url('insights/interval')}}" class="submenubuttons">INTERVAL</a>
@stop

@section('content')
    <div class="page-content1">

        @include('layout.inner_left_menu',[
        'items'=>$data['provinces_menu'],
        'url'=>'insights/province',
        'title'=>'Provinces',
        ])
        <div class='col-md-10 col-xs-12'>
            @include('others.print_buttons')

            <h2 class="graphTitle"> Calls per Product - {{$data['countCalls']}} </h2>
            <?php $provincesSectionCount = count( $data['provinces'] ); ?>
            @for($x=1; $x<=$provincesSectionCount; $x++)
                <div class="graphContainer">
                    <div id="chart_div_{{$x}}"></div>
                </div>
            @endfor

        </div>
    </div>
@stop

@section('footer_inc')
    <script type="text/javascript" src="http://www.google.com/jsapi"></script>
    <script type="text/javascript">
        google.load("visualization", "1", {packages: ["corechart"]});

        google.setOnLoadCallback(drawChart);
        function drawChart() {
            var options = {
                title: "",
                hAxis: {title: '', titleTextStyle: {color: 'red'}}
            };

                    <?php $x = 0; ?>
                    @foreach($data['provinces'] as $provincesSection)
                    <?php $x ++; ?>

            var data_{{$x}} = google.visualization.arrayToDataTable([
                        ['Medical Reps', @foreach($provincesSection as $provinceName=>$callCount) '{{$provinceName}}', @endforeach ],
                        ['', @foreach($provincesSection as $provinceName=>$callCount) {{$callCount}}, @endforeach ],
                    ]);

            var chart_{{$x}} = new google.visualization.ColumnChart(document.getElementById('chart_div_{{$x}}'));
            chart_{{$x}}.draw(data_{{$x}}, options);

            @endforeach



        }

    </script>
@stop
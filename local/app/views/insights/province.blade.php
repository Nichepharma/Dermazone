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
        'active'=>$data['provinceId'],
        'url'=>'insights/province',
        'title'=>'Cities',
        ])
        <div class='col-md-10 col-xs-12'>
            @include('others.print_buttons')

            <div class="inner-links">
                @if($data['cities_menu'])
                    @foreach($data['cities_menu'] as $id=>$name)
                        <div class="col-md-2 col-xs-6">
                            <a class="buttonallsite3" href="{{url('insights/city/'.$data['provinceId'].'/'.$id)}}">{{$name}}</a>
                        </div>
                    @endforeach
                @endif
            </div>
            <h2 class="graphTitle"> Calls per Product - {{$data['countCalls']}} </h2>
            <?php $citiesSectionCount = count($data['cities']); ?>
            @for($x=1; $x<=$citiesSectionCount; $x++)
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
            @if($data['cities'])
                @foreach($data['cities'] as $citiesSection)
                    <?php $x++; ?>

            var data_{{$x}} = google.visualization.arrayToDataTable([
                        ['Medical Reps', @foreach($citiesSection as $areaName=>$callCount) '{{$areaName}}', @endforeach ],
                        ['', @foreach($citiesSection as $areaName=>$callCount) {{$callCount}}, @endforeach ],
                    ]);

            var chart_{{$x}} = new google.visualization.ColumnChart(document.getElementById('chart_div_{{$x}}'));
            chart_{{$x}}.draw(data_{{$x}}, options);

                @endforeach
            @endif


        }
    </script>
@stop
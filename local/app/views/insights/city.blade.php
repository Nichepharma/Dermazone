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
        'items'=>$data['cities_menu'],
        'active'=>$data['cityId'],
        'headUrl'=>'insights/province/'.$data['provinceId'],
        'url'=>'insights/city/'.$data['provinceId'],
        'title'=>'Cities',
        ])
        <div class='col-md-10 col-xs-12'>
            @include('others.print_buttons')

            {{--
                        <div class="inner-links">
                            @foreach($data['cities_menu'] as $id=>$name)
                                <div class="col-sm-2"><a class="buttonallsite3" href="{{url('insights/city/'.$id)}}">{{$name}}</a></div>
                            @endforeach
                        </div>
            --}}
            <h2 class="graphTitle"> Calls per Product - {{$data['countCalls']}} </h2>
            <?php $areasSectionCount = count($data['areas']); ?>
            @for($x=1; $x<=$areasSectionCount; $x++)
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

                    @if($data['areas'])
                    @foreach($data['areas'] as $areasSection)
                    <?php $x++; ?>

            var data_{{$x}} = google.visualization.arrayToDataTable([
                        ['Medical Reps', @foreach($areasSection as $areaName=>$callCount) '{{$areaName}}', @endforeach ],
                        ['', @foreach($areasSection as $areaName=>$callCount) {{$callCount}}, @endforeach ],
                    ]);

            var chart_{{$x}} = new google.visualization.ColumnChart(document.getElementById('chart_div_{{$x}}'));
            chart_{{$x}}.draw(data_{{$x}}, options);

            @endforeach
            @endif


        }
    </script>
@stop
@extends('layout.main')

@section('subMenu')
    <a href="{{url('insights/products')}}" class="submenubuttons">PRODUCT</a>
    <a href="{{url('insights/provinces')}}" class="submenubuttons">province</a>
    <a href="{{url('insights/accumulative')}}" class="submenubuttons">ACCUMULATIVE</a>
    <a href="{{url('insights/interval')}}" class="submenubuttons active">INTERVAL</a>
@stop

@section('content')
    <div class="@if($data['provinceId'] == null) page-content @else page-content1 @endif">

        @include('layout.inner_left_menu',[
        'items'=>$data['provinces'],
        'url'=>'insights/interval',
        'active'=>$data['provinceId'],
        'title'=>'Provinces',
        ])
        <div class='col-md-10 col-xs-12'>
            @include('others.print_buttons')
            <h2> Total Number Of Visited Private : {{$data['totalDoctorsVisit']}}</h2>
            <div id="doctorsVisit" style="width: 900px; height: 500px;"></div>

            {{--
                        <h2> Total Number Of Visited Hospitals : {{$data['totalHospitalsVisit']}}</h2>
                        <div id="hospitalsVisit" style="width: 900px; height: 500px;"></div>
            --}}
        </div>
        @stop

        @section('footer_inc')

            <script type="text/javascript"
                    src="https://www.google.com/jsapi?autoload={'modules':[{'name':'visualization','version':'1.1','packages':['annotationchart']}]}"></script>
            <link href="https://www.google.com/uds/api/visualization/1.0/d90be93871e947a274f6a5157bd75fb0/ui+en,table+en,controls+en,annotationchart+en.css"
                  type="text/css" rel="stylesheet">
            <script src="https://www.google.com/uds/api/visualization/1.0/d90be93871e947a274f6a5157bd75fb0/format+en,default+en,ui+en,table+en,controls+en,corechart+en,annotationchart+en.I.js"
                    type="text/javascript"></script>
            <script type='text/javascript'>
                google.load('visualization', '1', {'packages': ['annotationchart']});
                google.setOnLoadCallback(drawChart);
                function drawChart() {
                    @if(isset($data['doctors_visit']))
                    var data = new google.visualization.DataTable();
                    data.addColumn('date', 'Date');
                    data.addColumn('number', 'Number Of Visited Private');
                    data.addColumn('string', 'visits');
                    data.addRows([
                            @foreach($data['doctors_visit'] as $date=>$visits)
                        [parseDate('{{ date("Y-m-d", strtotime($date))}}'), {{$visits}}, '{{$visits}} Visits'],
                        @endforeach
                    ]);

                    var chart = new google.visualization.AnnotationChart(document.getElementById('doctorsVisit'));

                    var options = {

                        displayAnnotations: true
                    };
                    chart.draw(data, options);
                    @endif

                    //                    $("#doctorsVisit_AnnotationChart_zoomControlContainer_1-hour").remove();
                    //
                    //                    $("#doctorsVisit_AnnotationChart_zoomControlContainer_5-days").remove();
                    //                    $("#doctorsVisit_AnnotationChart_zoomControlContainer_3-months").remove();
                    //                    $("#doctorsVisit_AnnotationChart_zoomControlContainer_6-months").remove();
                    //                    $("#doctorsVisit_AnnotationChart_zoomControlContainer_1-year").remove();

                }
            </script>


            <script type="text/javascript"
                    src="https://www.google.com/jsapi?autoload={'modules':[{'name':'visualization','version':'1.1','packages':['annotationchart']}]}"></script>
            <script type='text/javascript'>
                google.load('visualization', '1', {'packages': ['annotationchart']});
                google.setOnLoadCallback(drawChart);
                function drawChart() {
                    var data = new google.visualization.DataTable();
                    data.addColumn('date', 'Date');
                    data.addColumn('number', 'Number Of Visited Hospitals');
                    data.addColumn('string', 'visits');
                    data.addRows([
                        [new Date(2016, 02, 01), 8, '8 Visits'],
                        [new Date(2016, 02, 02), 8, '8 Visits'],

                    ]);

                    var chart = new google.visualization.AnnotationChart(document.getElementById('hospitalsVisit'));

                    var options = {

                        displayAnnotations: true

                    };

                    chart.draw(data, options);

//                    $("#hospitalsVisit_AnnotationChart_zoomControlContainer_1-hour").remove();
//                    $("#hospitalsVisit_AnnotationChart_zoomControlContainer_5-days").remove();
//                    $("#hospitalsVisit_AnnotationChart_zoomControlContainer_3-months").remove();
//                    $("#hospitalsVisit_AnnotationChart_zoomControlContainer_6-months").remove();
//                    $("#hospitalsVisit_AnnotationChart_zoomControlContainer_1-year").remove();
//
//                    $("#piecharta_AnnotationChart_legendContainer.legend").remove();

                }
            </script>

@stop
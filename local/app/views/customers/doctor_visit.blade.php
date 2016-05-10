@extends('layout.main')

@section('content')
    <div class="container-fluid page-content1">

        @include('others.print_buttons')


        <div class="col-sm-6">
            <div class="graphContainer">
                <h2 class="graphTitle"> Call Slides</h2>
                <div id="chart_div"></div>
            </div>
        </div>

        <div class="col-sm-5">
            <h2 class="graphTitle"> Call Details</h2>
            <div class="callspart2" style="width: 100%;margin: 0px;">

                <div class="row toppart">
                    <div class="col-xs-6 cell">Doctor</div>
                    <div class="col-xs-6 callspart2cell2"> {{$data['doctor']->name}}</div>
                </div>
                <div class="row toppart">
                    <div class="col-xs-6 cell">Speciality</div>
                    <div class="col-xs-6 callspart2cell2"> {{$data['doctor']->speciality}}</div>
                </div>
                <div class="row toppart">
                    <div class="col-xs-6 cell">Center</div>
                    <div class="col-xs-6 callspart2cell2"> {{$data['record']->center}}</div>
                </div>
                <div class="row toppart">
                    <div class="col-xs-6 cell">Product</div>
                    <div class="col-xs-6 callspart2cell2"> {{$data['visitProduct']->name}}</div>
                </div>
                <div class="row toppart">
                    <div class="col-xs-6 cell">Address</div>
                    <div class="col-xs-6 callspart2cell2"> {{$data['doctor']->address}}</div>
                </div>
                <div class="row toppart">
                    <div class="col-xs-6 cell">Visit Time</div>
                    <div class="col-xs-6 callspart2cell2"> {{date4($data['visit']->date)}}</div>
                </div>
                <div class="row toppart">
                    <div class="col-xs-6 cell">Visit duration</div>
                    <div class="col-xs-6 callspart2cell2"> {{gmdate("H:i:s", $data['visit']->duration)}}</div>
                </div>
                <div class="row toppart">
                    <div class="col-xs-6 cell">Rep</div>
                    <div class="col-xs-6 callspart2cell2"> {{$data['visitRep']->fullname}}</div>
                </div>
                <div class="row toppart">
                    <div class="col-xs-6 cell">Samples Droped</div>
                    <div class="col-xs-6 callspart2cell2"> {{$data['visit']->samples}}</div>
                </div>
                <div class="row toppart">
                    <div class="col-xs-6 cell">Samples Type</div>
                    <div class="col-xs-6 callspart2cell2"> {{$data['visit']->samples_type}}</div>
                </div>
                <div class="row toppart">
                    <div class="col-xs-6 cell">Visit Type</div>
                    <div class="col-xs-6 callspart2cell2"> {{ str_replace("2","Double", str_replace("1", "Single", $data['visit']->visit_type)) }}</div>
                </div>
                <div class="row toppart">
                    <div class="col-xs-6 cell">Comment</div>
                    <div class="col-xs-6 callspart2cell2"> {{$data['visit']->comment}}</div>
                </div>
            </div>
        </div>
    </div>

    </div>
@stop

@section('footer_inc')
    <script type="text/javascript" src="http://www.google.com/jsapi"></script>
    <script type="text/javascript">

        LoadGoogle();

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


        // Callback that creates and populates a data table,
        // instantiates the pie chart, passes in the data and
        // draws it.
        function drawChart() {

            // Create the data table.
            var data = new google.visualization.DataTable();
            data.addColumn('string', 'Page');
            data.addColumn('number', 'Seconds');
            data.addRows([
                    //@if($data['visitSlides'])
                    //    @foreach($data['visitSlides'] as $slide)
                    //        ['{{$slide->slide_data->name}}', {{$slide->time}}],
                    //    @endforeach
                    //@endif
                    @foreach($data['slides'] as $slideName=>$slideCalls)
                    ['{{$slideName}}', {{$slideCalls}}],
                    @endforeach
            ]);
            // Set chart options
            var options = {
                'title': '',
                'width': 550,
                'height': 450
            };

            // Instantiate and draw our chart, passing in some options.
            var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
            chart.draw(data, options);
        }
    </script>
@stop

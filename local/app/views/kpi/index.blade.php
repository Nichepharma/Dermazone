@extends('layout.main')

@section('content')
    <div class="container-fluid page-content1">

        <div class='col-md-10 col-xs-12'>
            @include('others.print_buttons')

            <div class="col-sm-12">
                <form action="" id="filterForm">
                    <div class="col-md-3 col-xs-6 selectContainer">
                        <div class="form-group">
                            {{Form::select('province',[''=>'- All -']+$data['provinces'],$data['provinceId'],['class'=>'form-control buttonallsite3 provinceSelect'])}}
                        </div>
                    </div>
                    <div class="col-md-3 col-xs-6 selectContainer">
                        <div class="form-group">
                            {{Form::select('rep',[''=>'- All -']+$data['reps'],$data['userId'],['class'=>'form-control buttonallsite3 repSelect'])}}
                        </div>
                    </div>
                </form>
            </div>
            <div class="clearfix"><br></div>

            <div class="col-sm-12">
                <h2>Private Market</h2>
                <div class="col-md-2 col-xs-6"><input type="button" class="buttonallsite3" onclick="DrawAllDoctors()" value="All"></div>
                <div class="col-md-2 col-xs-6"><input type="button" class="buttonallsite3" onclick="DrawDoctorsByGrade()" value="By Class"></div>
                <div class="col-md-2 col-xs-6"><input type="button" class="buttonallsite3" onclick="DrawDoctorsBySpeciality()" value="By Speciality"></div>
            </div>


            <div class="col-sm-12 graphContainer">
                <div id="chart_div"></div>
            </div>

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
                google.setOnLoadCallback(DrawAllDoctors);

            }
            else {
                // Retry later...
                setTimeout(LoadGoogle, 30);
            }
        }
        $('#filterForm select').change(function () {
            if ($(this).hasClass('provinceSelect')) {
                $('.repSelect').val('');
            }
            $('#filterForm').submit();
        });

        function DrawAllDoctors() {

            var data = new google.visualization.DataTable();


            data.addColumn('string', 'years');
            data.addColumn('number', 'sales');

            data.addRow(['Covered : {{$data['coveredDoctors']}}', {{$data['coveredDoctors']}}]);
            data.addRow(['Uncovered : {{$data['unCoveredDoctors']}}', {{$data['unCoveredDoctors']}}]);

            //alert(allDrs[0]);
            var options = {

                pieHole: 0.4,
                title: 'Covered/Uncovered [Doctors or Pharmacies]'
            };
            //var chartdata = new google.visualization.arrayToDataTable(data);
            var chart = new google.visualization.PieChart(document.getElementById('chart_div'));

            chart.draw(data, options);
        }

        function DrawDoctorsByGrade() {

            var data = new google.visualization.DataTable();


            data.addColumn('string', 'Element');
            data.addColumn('number', 'class');

            @foreach($data['coveredDoctorsByGrade'] as $grade=>$num)
                data.addRow(['{{$grade}} : {{$num}}', {{$num}}]);
            @endforeach

            //alert(allDrs[0]);
            var options = {

                pieHole: 0.4,
                title: 'Covered / unCovered Doctors'
            };
            //var chartdata = new google.visualization.arrayToDataTable(data);
            var chart = new google.visualization.PieChart(document.getElementById('chart_div'));

            chart.draw(data, options);
        }

        function DrawDoctorsBySpeciality() {

            var data = new google.visualization.DataTable();


            data.addColumn('string', 'Element');
            data.addColumn('number', 'class');

            @foreach($data['coveredDoctorsBySpeciality'] as $speciality=>$num)
                data.addRow(['{{$speciality}} : {{$num}}', {{$num}}]);
            @endforeach

            //alert(allDrs[0]);
            var options = {

                pieHole: 0.4,
                title: 'Covered / unCovered Doctors'
            };
            //var chartdata = new google.visualization.arrayToDataTable(data);
            var chart = new google.visualization.PieChart(document.getElementById('chart_div'));

            chart.draw(data, options);
        }

    </script>
@stop

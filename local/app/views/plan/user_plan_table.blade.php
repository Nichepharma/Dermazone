<?php
$weekDays = array(
        'saturday' => $data['from'],
        'sunday' => addDaytoDate($data['from'], 1),
        'monday' => addDaytoDate($data['from'], 2),
        'tuesday' => addDaytoDate($data['from'], 3),
        'wednesday' => addDaytoDate($data['from'], 4)
);


$previousWeek = addDaytoDate($data['from'], -7);
$nextWeek = addDaytoDate($data['from'], 7);


if(isset($data['plan'][1]))
$doctorsPlan = arrayGroupBy($data['plan'][1],'date');

if(isset($data['plan'][2]))
$pharmaciesPlan = arrayGroupBy($data['plan'][2],'date');

if(isset($data['plan'][3]))
$hospitalsPlan = arrayGroupBy($data['plan'][3],'date');

if(isset($data['visits'][1]))
$doctorsVisit = arrayGroupBy($data['visits'][1],'date');

if(isset($data['visits'][2]))
$pharmaciesVisit = arrayGroupBy($data['visits'][2],'date');

if(isset($data['visits'][3]))
$hospitalsVisit = arrayGroupBy($data['visits'][3],'date');


//pr($previousWeek);
?>
<button class="btn btn-default pull-left glyphicon glyphicon-arrow-left" onclick="getPlan('{{$previousWeek}}')"></button>
<button class="btn btn-default pull-right glyphicon glyphicon-arrow-right" onclick="getPlan('{{$nextWeek}}')"></button>
<br>
<br>
<table class="table myTable" border="1">
    <thead>
    <tr>
        <th class="plantableheadclass">Types</th>
        @foreach($weekDays as $day)
            <th class="plantableheadclass">{{date7($day)}}</th>
        @endforeach
    </tr>
    </thead>
    <tbody>
    <tr>
        <th class="planlefttd">Doctors</th>
        @foreach($weekDays as $day)
            <td>
                @if(isset($doctorsPlan[$day]))
                    <ol class="customers_plan">
                        @foreach($doctorsPlan[$day] as $doctor)
                            <li class="alert alert-{{getEqual('visitCaseClass', $doctor->visited)}}">{{$doctor->name}}
                                ({{$doctor->speciality}})
                            </li>
                        @endforeach
                    </ol>
                @endif

                @if(isset($doctorsVisit[$day]))
                    <ol class="customers_plan">
                        @foreach($doctorsVisit[$day] as $doctor)
                            <li class="alert alert-info">{{$doctor->name}}
                                ({{$doctor->speciality}})
                            </li>
                        @endforeach
                    </ol>
                @endif

            </td>
        @endforeach
    </tr>
    <tr>
        <th class="planlefttd">Pharmacies</th>
        @foreach($weekDays as $day)
            <td>
                @if(isset($pharmaciesPlan[$day]))
                    <ol class="customers_plan">
                        @foreach($pharmaciesPlan[$day] as $pharmacy)
                            <li class="alert alert-{{getEqual('visitCaseClass', $pharmacy->visited)}}">{{$pharmacy->name}}
                                ({{$pharmacy->speciality}})
                            </li>
                        @endforeach
                    </ol>
                @endif

                @if(isset($pharmaciesVisit[$day]))
                    <ol class="customers_plan">
                        @foreach($pharmaciesVisit[$day] as $pharmacy)
                            <li class="alert alert-info">{{$pharmacy->name}}
                                {{$pharmacy->speciality}})
                            </li>
                        @endforeach
                    </ol>
                @endif

            </td>
        @endforeach
    </tr>
<?php
/*
    <tr>

        <th class="planlefttd">Hospitals</th>
        @foreach($weekDays as $day)
            <td>
                @if(isset($hospitalsPlan[$day]))
                    <ol class="customers_plan">
                        @foreach($hospitalsPlan[$day] as $hospital)
                            <li class="alert alert-{{getEqual('visitCaseClass', $hospital->visited)}}">{{$hospital->name}}
                                ({{$hospital->speciality}})
                            </li>
                        @endforeach
                    </ol>
                @endif

                @if(isset($hospitalsVisit[$day]))
                    <ol class="customers_plan">
                        @foreach($hospitalsVisit[$day] as $hospital)
                            <li class="alert alert-info">{{$hospital->name}}
                                ({{$hospital->speciality}})
                            </li>
                        @endforeach
                    </ol>
                @endif

            </td>
        @endforeach
    </tr>
*/
?>

    </tbody>
</table>

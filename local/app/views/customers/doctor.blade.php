@extends('layout.main')

@section('subMenu')
    {{--<a href="#" class="submenubuttons showDoctors" ng-class="{'active': activeTab=='doctors'}" ng-click="showDoctors()">Doctors</a>--}}
    {{--<a href="#" class="submenubuttons showHospitals" ng-class="{'active': activeTab=='hospitals'}" ng-click="showHospitals()">Hospitals</a>--}}
    {{--<a href="#" class="submenubuttons showPharmacies" ng-class="{'active': activeTab=='pharmacies'}" ng-click="showPharmacies()">Pharmacies</a>--}}
@stop

@section('content')
    <div class="container-fluid page-content1">

        @include('others.print_buttons')

        <center>

            @if($data['customerVisits'])
                <div class="callspart">
                    @foreach($data['customerVisits'] as $month=>$visits)
                        <?php $dt = DateTime::createFromFormat('!m', $month); ?>
                        <div class="row toppart">
                            <div class="col-xs-6">{{$dt->format('F')}}</div>
                            <div class="col-xs-6">Duration</div>
                        </div>
                        @foreach($visits as $visit)
                            <div class="row middpart">
                                <div class="col-xs-6"><a href="{{url('customers/visit/'.$visit->id)}}">{{date4($visit->date)}}</a></div>
                                <div class="col-xs-6">{{gmdate("H:i:s", $visit->duration)}}</div>
                            </div>
                        @endforeach
                    @endforeach
                </div>
            @endif


            <h2 id="big"> Doctor: {{$data['record']->name}}</h2>
            <div class="callspart2">
                <div class="row toppart">
                    <div class="col-xs-6 cell">Center</div>
                    <div class="col-xs-6 callspart2cell2"> {{$data['record']->center}}</div>
                </div>

                <div class="row toppart">
                    <div class="col-xs-6 cell">Speciality</div>
                    <div class="col-xs-6 callspart2cell2"> {{$data['record']->speciality}}</div>
                </div>

                <div class="row toppart">
                    <div class="col-xs-6 cell">Province</div>
                    <div class="col-xs-6 callspart2cell2">{{$data['recordProvince']}}</div>
                </div>
                <div class="row toppart">
                    <div class="col-xs-6 cell">City</div>
                    <div class="col-xs-6 callspart2cell2">{{$data['recordCity']}}</div>
                </div>
                <div class="row toppart">
                    <div class="col-xs-6 cell">Area</div>
                    <div class="col-xs-6 callspart2cell2">{{$data['recordArea']}}</div>
                </div>
                <div class="row toppart">
                    <div class="col-xs-6 cell">Address</div>
                    <div class="col-xs-6 callspart2cell2">{{$data['record']->address}}</div>
                </div>
                <div class="row toppart">
                    <div class="col-xs-6 cell">Phone</div>
                    <div class="col-xs-6 callspart2cell2">{{$data['record']->phone}}</div>
                </div>
                <div class="row toppart">
                    <div class="col-xs-6 cell">Best Time to visit</div>
                    <div class="col-xs-6 callspart2cell2">{{$data['record']->best_time}}</div>
                </div>
                <div class="row toppart">
                    <div class="col-xs-6 cell">General Class</div>
                    <div class="col-xs-6 callspart2cell2">{{$data['record']->grade}}</div>
                </div>

                {{record_info3($data['record'])}}

            </div>

        </center>
    </div>

    </div>
@stop


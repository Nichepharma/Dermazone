@extends('layout.main')

@section('subMenu')
    <a href="{{url('insights/products')}}" class="submenubuttons">PRODUCT</a>
    <a href="{{url('insights/provinces')}}" class="submenubuttons">province</a>
    <a href="{{url('insights/accumulative')}}" class="submenubuttons active">ACCUMULATIVE</a>
    <a href="{{url('insights/interval')}}" class="submenubuttons">INTERVAL</a>
@stop

@section('content')
    <div class="page-content1">

        @include('others.print_buttons')

        <h2><i class="glyphicon glyphicon-user"></i> {{$data['userData']->fullname}}</h2>
        <div class='row'>
            <div class="col-md-2 col-xs-6">
                <button class="buttonallsite3" ng-class="{'active': activeTab=='doctors'}" ng-click="showDoctors()">Private Market</button>
            </div>
            {{--
                        <div class="col-md-2 col-xs-6">
                            <button class="buttonallsite3" ng-class="{'active': activeTab=='hospitals'}" ng-click="showHospitals()">HOSPITALS</button>
                        </div>
            --}}
            <div class="col-md-2 col-xs-6">
                <button class="buttonallsite3" ng-class="{'active': activeTab=='pharms'}" ng-click="showPharms()">Pharmacies</button>
            </div>
        </div>

        <div class="col-sm-12">
            <table st-safe-src="doctorsCollection" st-table="displayDoctorsCollection" class="table table-striped table-bordered" id="doctorsTable">
                <thead>
                <tr>
                    <th st-sort="name">name</th>
                    <th st-sort="speciality">speciality</th>
                    <th st-sort="grade">Class</th>
                    <th st-sort="area">area</th>
                    @foreach($data['months'] as $month)
                        <th colspan="5">{{$month}}</th>
                    @endforeach
                </tr>
                <tr>
                    <th><input st-search="name" placeholder="Search for Name" class="input-sm form-control" type="search"/></th>
                    <th>
                        <select st-search="speciality" class="form-control">
                            <option value="">- All -</option>
                            <option ng-repeat="row in doctorsCollection | unique:'speciality'" value="[[row.speciality]]">[[row.speciality]]</option>
                        </select>
                    </th>
                    <th>
                        <select st-search="grade" class="form-control">
                            <option value="">- All -</option>
                            <option ng-repeat="row in doctorsCollection | unique:'grade'" value="[[row.grade]]">[[row.grade]]</option>
                        </select>
                    </th>
                    <th>
                        <input st-search="area" placeholder="search for area" class="input-sm form-control" type="search"/>
                    </th>
                    @foreach($data['months'] as $month)
                        <th>W1</th>
                        <th>W2</th>
                        <th>W3</th>
                        <th>W4</th>
                        <th>W5</th>
                    @endforeach
                </tr>
                </thead>
                <tbody>
                <tr ng-repeat="row in displayDoctorsCollection">
                    <td><a href="{{url('customers/doctor')}}/[[row.customer_id]]" target="_blank">[[$index+1]]. [[row.name]]</a></td>
                    <td>[[row.speciality]]</td>
                    <td>[[row.grade]]</td>
                    <td ng-init="row.area = areas[row.area_id]">[[ row.area ]]</td>
                    @foreach($data['months'] as $monthNum=>$month)
                        <td>
                            <div ng-repeat="visit in row.visits">
                                <span ng-show="visit.month=={{$monthNum}} && visit.week==1">[[visit.day]]</span>
                            </div>
                        </td>
                        <td>
                            <div ng-repeat="visit in row.visits">
                                <span ng-show="visit.month=={{$monthNum}} && visit.week==2">[[visit.day]]</span>
                            </div>
                        </td>
                        <td>
                            <div ng-repeat="visit in row.visits">
                                <span ng-show="visit.month=={{$monthNum}} && visit.week==3">[[visit.day]]</span>
                            </div>
                        </td>
                        <td>
                            <div ng-repeat="visit in row.visits">
                                <span ng-show="visit.month=={{$monthNum}} && visit.week==4">[[visit.day]]</span>
                            </div>
                        </td>
                        <td>
                            <div ng-repeat="visit in row.visits">
                                <span ng-show="visit.month=={{$monthNum}} && visit.week==5">[[visit.day]]</span>
                            </div>
                        </td>
                    @endforeach

                </tr>
                </tbody>
            </table>

            <table st-safe-src="hospitalsCollection" st-table="displayHospitalsCollection" class="table table-striped table-bordered"
                   id="hospitalsTable">
                <thead>
                <tr>
                    <th st-sort="name">name</th>
                    <th st-sort="grade">Class</th>
                    <th st-sort="area">area</th>
                    @foreach($data['months'] as $month)
                        <th colspan="5">{{$month}}</th>
                    @endforeach
                </tr>
                <tr>
                    <th><input st-search="name" placeholder="Search for Name" class="input-sm form-control" type="search"/></th>
                    <th>
                        <select st-search="grade" class="form-control">
                            <option value="">- All -</option>
                            <option ng-repeat="row in hospitalsCollection | unique:'grade'" value="[[row.grade]]">[[row.grade]]</option>
                        </select>
                    </th>
                    <th>
                        <input st-search="area" placeholder="search for area" class="input-sm form-control" type="search"/>
                    </th>
                    @foreach($data['months'] as $month)
                        <th>W1</th>
                        <th>W2</th>
                        <th>W3</th>
                        <th>W4</th>
                        <th>W5</th>
                    @endforeach
                </tr>
                </thead>
                <tbody>
                <tr ng-repeat="row in displayHospitalsCollection">
                    <td><a href="{{url('customers/hospital')}}/[[row.customer_id]]" target="_blank">[[$index+1]]. [[row.name]]</a></td>
                    <td>[[row.grade]]</td>
                    <td ng-init="row.area = areas[row.area_id]">[[ row.area ]]</td>
                    @foreach($data['months'] as $monthNum=>$month)
                        <td>
                            <div ng-repeat="visit in row.visits">
                                <span ng-show="visit.month=={{$monthNum}} && visit.week==1">[[visit.day]]</span>
                            </div>
                        </td>
                        <td>
                            <div ng-repeat="visit in row.visits">
                                <span ng-show="visit.month=={{$monthNum}} && visit.week==2">[[visit.day]]</span>
                            </div>
                        </td>
                        <td>
                            <div ng-repeat="visit in row.visits">
                                <span ng-show="visit.month=={{$monthNum}} && visit.week==3">[[visit.day]]</span>
                            </div>
                        </td>
                        <td>
                            <div ng-repeat="visit in row.visits">
                                <span ng-show="visit.month=={{$monthNum}} && visit.week==4">[[visit.day]]</span>
                            </div>
                        </td>
                        <td>
                            <div ng-repeat="visit in row.visits">
                                <span ng-show="visit.month=={{$monthNum}} && visit.week==5">[[visit.day]]</span>
                            </div>
                        </td>
                    @endforeach

                </tr>
                </tbody>
            </table>

            <table st-safe-src="pharmsCollection" st-table="displayPharmsCollection" class="table table-striped table-bordered"
                   id="pharmsTable">
                <thead>
                <tr>
                    <th st-sort="name">name</th>
                    <th st-sort="class">Class</th>
                    <th st-sort="area">area</th>
                    @foreach($data['months'] as $month)
                        <th colspan="5">{{$month}}</th>
                    @endforeach
                </tr>
                <tr>
                    <th><input st-search="name" placeholder="Search for Name" class="input-sm form-control" type="search"/></th>
                    <th>
                        <select st-search="class" class="form-control">
                            <option value="">- All -</option>
                            <option ng-repeat="row in pharmsCollection | unique:'class'" value="[[row.class]]">[[row.class]]</option>
                        </select>
                    </th>
                    <th>
                        <input st-search="area" placeholder="search for area" class="input-sm form-control" type="search"/>
                    </th>
                    @foreach($data['months'] as $month)
                        <th>W1</th>
                        <th>W2</th>
                        <th>W3</th>
                        <th>W4</th>
                        <th>W5</th>
                    @endforeach
                </tr>
                </thead>
                <tbody>
                <tr ng-repeat="row in displayPharmsCollection">
                    <td><a href="{{url('customers/pharmacy')}}/[[row.customer_id]]" target="_blank">[[$index+1]]. [[row.name]]</a></td>
                    <td>[[row.class]]</td>
                    <td ng-init="row.area = areas[row.area_id]">[[ row.area ]]</td>
                    @foreach($data['months'] as $monthNum=>$month)
                        <td>
                            <div ng-repeat="visit in row.visits">
                                <span ng-show="visit.month=={{$monthNum}} && visit.week==1">[[visit.day]]</span>
                            </div>
                        </td>
                        <td>
                            <div ng-repeat="visit in row.visits">
                                <span ng-show="visit.month=={{$monthNum}} && visit.week==2">[[visit.day]]</span>
                            </div>
                        </td>
                        <td>
                            <div ng-repeat="visit in row.visits">
                                <span ng-show="visit.month=={{$monthNum}} && visit.week==3">[[visit.day]]</span>
                            </div>
                        </td>
                        <td>
                            <div ng-repeat="visit in row.visits">
                                <span ng-show="visit.month=={{$monthNum}} && visit.week==4">[[visit.day]]</span>
                            </div>
                        </td>
                        <td>
                            <div ng-repeat="visit in row.visits">
                                <span ng-show="visit.month=={{$monthNum}} && visit.week==5">[[visit.day]]</span>
                            </div>
                        </td>
                    @endforeach

                </tr>
                </tbody>
            </table>
        </div>

    </div>
@stop

@section('head_inc')
    {{ HTML::script('assets/js/angular.min.js') }}
    {{ HTML::script('assets/js/ui-bootstrap.min.js') }}
    {{ HTML::script('assets/js/ui-bootstrap-tpls.min.js') }}
    {{ HTML::script('assets/js/smart-table.js') }}
    <style>
        .table {
            display: none;
        }
    </style>
    <script>
        var app = angular.module('myApp', ['ui.bootstrap', 'smart-table']);
        app.config(function ($interpolateProvider) {
            $interpolateProvider.startSymbol('[[');
            $interpolateProvider.endSymbol(']]');
        });
        function toArray(inputObj) {
            var output = [];
            for (var key in inputObj) {
                // must create a temp object to set the key using a variable
                var tempObj = {};
                tempObj[key] = inputObj[key];
                output.push(tempObj);
            }
            return output;
        }

        app.controller('gridCtrl', ['$scope', '$filter', '$http', function (scope, filter, $http) {

            scope.activeTab = 'doctors';
            scope.showDoctors = function () {
                $('.table').hide();
                scope.activeTab = 'doctors';
                if (typeof (scope.doctorsCollection) === 'undefined') {
                    $http.get('{{url('insights/accumulative-details/'.$data['userData']->id.'?type=doctors')}}')
                            .then(function (response) {
                                scope.doctorsCollection = response.data.doctors;
                                scope.displayDoctorsCollection = [].concat(scope.doctorsCollection);
                                scope.areas = angular.fromJson(response.data.areas);
                                $('#doctorsTable').fadeIn();
                            });
                } else {
                    $('#doctorsTable').fadeIn();
                }

//                console.log(scope.doctorsCollection);
            };

            scope.showHospitals = function () {
                $('.table').hide();
                scope.activeTab = 'hospitals';
                if (typeof (scope.hospitalsCollection) === 'undefined') {
                    $http.get('{{url('insights/accumulative-details/'.$data['userData']->id.'?type=hospitals')}}')
                            .then(function (response) {
                                scope.hospitalsCollection = response.data.hospitals;
                                scope.displayHospitalsCollection = [].concat(scope.hospitalsCollection);
                                scope.areas = angular.fromJson(response.data.areas);
                                $('#hospitalsTable').fadeIn();
                            });
                } else {
                    $('#hospitalsTable').fadeIn();
                }
            };

            scope.showPharms = function () {
                $('.table').hide();
                scope.activeTab = 'pharms';
                if (typeof (scope.pharmsCollection) === 'undefined') {
                    $http.get('{{url('insights/accumulative-details/'.$data['userData']->id.'?type=pharms')}}')
                            .then(function (response) {
                                scope.pharmsCollection = response.data.pharms;
                                scope.displayPharmsCollection = [].concat(scope.pharmsCollection);
                                scope.areas = angular.fromJson(response.data.areas);
                                $('#pharmsTable').fadeIn();
                            });
                } else {
                    $('#pharmsTable').fadeIn();
                }
            };

            scope.showDoctors();

        }]);

        app.filter('myStrictFilter', function ($filter) {
            return function (input, predicate) {
                return $filter('filter')(input, predicate, true);
            }
        });

        app.filter('unique', function () {
            return function (arr, field) {
                if (typeof (arr) === 'undefined') {
                    return '';
                }
                var o = {}, i, l = arr.length, r = [];
                for (i = 0; i < l; i += 1) {
                    o[arr[i][field]] = arr[i];
                }
                for (i in o) {
                    r.push(o[i]);
                }
                return r;
            };
        });


    </script>
@stop
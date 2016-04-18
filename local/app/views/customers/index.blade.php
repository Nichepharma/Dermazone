@extends('layout.main')

@section('subMenu')
    <a href="#" class="submenubuttons showDoctors" ng-class="{'active': activeTab=='doctors'}" ng-click="showDoctors()">Doctors</a>
    {{--<a href="#" class="submenubuttons showHospitals" ng-class="{'active': activeTab=='hospitals'}" ng-click="showHospitals()">Hospitals</a>--}}
    <a href="#" class="submenubuttons showPharmacies" ng-class="{'active': activeTab=='pharmacies'}" ng-click="showPharmacies()">Pharmacies</a>
@stop

@section('content')
    <div class="container-fluid page-content1">

        @include('others.print_buttons',['moreLinks'=>'<a class="btn bg-primary btn-sm" data-toggle="modal" data-target="#myModal">import</a>'])

        <div class="col-sm-12">
            <table st-safe-src="doctorsCollection" st-table="displayDoctorsCollection" class="table table-striped table-bordered" id="doctorsTable">
                <thead>
                <tr>
                    <th st-sort="name">name</th>
                    <th st-sort="speciality">speciality</th>
                    <th st-sort="grade">Class</th>
                    <th>Visits</th>
                </tr>
                <tr class="filtration">
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
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <tr ng-repeat="row in displayDoctorsCollection" id="doctor-[[row.customer_id]]">
                    <td><a href="{{url('customers/doctor')}}/[[row.customer_id]]" target="_blank">[[row.name]]</a></td>
                    <td>[[row.speciality]]</td>
                    <td>[[row.grade]]</td>
                    <td class="visits">0</td>
                </tr>
                </tbody>
            </table>

            {{--
                        <table st-safe-src="hospitalsCollection" st-table="displayHospitalsCollection" class="table table-striped table-bordered"
                               id="hospitalsTable">
                            <thead>
                            <tr>
                                <th st-sort="name">name</th>
                                <th st-sort="grade">Class</th>
                            </tr>
                            <tr class="filtration">
                                <th><input st-search="name" placeholder="Search for Name" class="input-sm form-control" type="search"/></th>
                                <th>
                                    <select st-search="grade" class="form-control">
                                        <option value="">- All -</option>
                                        <option ng-repeat="row in hospitalsCollection | unique:'grade'" value="[[row.grade]]">[[row.grade]]</option>
                                    </select>
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr ng-repeat="row in displayHospitalsCollection">
                                <td>[[row.name]]</td>
                                <td>[[row.grade]]</td>
                            </tr>
                            </tbody>
                        </table>
            --}}

            <table st-safe-src="pharmaciesCollection" st-table="displaypharmaciesCollection" class="table table-striped table-bordered" id="pharmaciesTable">
                <thead>
                <tr>
                    <th st-sort="name">name</th>
                    <th st-sort="class">Class</th>
                    <th>Visits</th>
                </tr>
                <tr class="filtration">
                    <th><input st-search="name" placeholder="Search for Name" class="input-sm form-control" type="search"/></th>
                    <th>
                        <select st-search="class" class="form-control">
                            <option value="">- All -</option>
                            <option ng-repeat="row in pharmaciesCollection | unique:'class'" value="[[row.class]]">[[row.class]]</option>
                        </select>
                    </th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <tr ng-repeat="row in displaypharmaciesCollection" id="pharmacy-[[row.customer_id]]">
                    <td><a href="{{url('customers/pharmacy')}}/[[row.customer_id]]" target="_blank">[[row.name]]</a></td>
                    <td>[[row.class]]</td>
                    <td class="visits">0</td>
                </tr>
                </tbody>
            </table>
        </div>

    </div>
@stop

@section('footer_inc')
    <div id="myModal" class="modal fade" role="dialog">
        <form action="{{url('customers/import')}}" method="post" enctype="multipart/form-data">
            <input type="hidden" name="type" value="[[activeTab]]">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <div class="col-xs-12 selectContainer">
                                <div class="form-group">
                                    {{ Form::file('file',['class'=>'form-control']) }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-default buttonallsite2" style="margin-top:20px;">Import</button>
                    </div>
                </div>
            </div>
        </form>
    </div>


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

            scope.showDoctors = function () {
                $('.table').hide();
                scope.activeTab = 'doctors';
                if (typeof (scope.doctorsCollection) === 'undefined') {
                    loader();

                    $http.get('{{url('customers/index?type=doctors')}}')
                            .then(function (response) {
                                scope.doctorsCollection = response.data.doctors;
                                stopLoader();

                                scope.displayDoctorsCollection = [].concat(scope.doctorsCollection);
                                $('#doctorsTable').fadeIn();

                                $http.get('{{url('customers/customers-visits')}}').then(function (response) {

                                    angular.forEach(response.data.visits, function (doctor) {
                                        $('#doctor-' + doctor.customer_id).find('.visits').html(doctor.visits);
                                    });

                                });
                            });
                } else {
                    $('#doctorsTable').fadeIn();
                }
            };

            /*
             scope.showHospitals = function () {
             $('.table').hide();
             scope.activeTab = 'hospitals';
             if (typeof (scope.hospitalsCollection) === 'undefined') {
             $http.get('{{url('customers/index?type=hospitals')}}')
             .then(function (response) {
             scope.hospitalsCollection = response.data.hospitals;
             scope.displayHospitalsCollection = [].concat(scope.hospitalsCollection);
             $('#hospitalsTable').fadeIn();
             });
             }else{
             $('#hospitalsTable').fadeIn();
             }
             };
             */

            scope.showPharmacies = function () {
                $('.table').hide();
                scope.activeTab = 'pharmacies';
                if (typeof (scope.pharmaciesCollection) === 'undefined') {
                    $http.get('{{url('customers/index?type=pharmacies')}}')
                            .then(function (response) {
                                scope.pharmaciesCollection = response.data.pharmacies;
                                scope.displaypharmaciesCollection = [].concat(scope.pharmaciesCollection);
                                scope.areas = angular.fromJson(response.data.areas);
                                $('#pharmaciesTable').fadeIn();

                                $http.get('{{url('customers/customers-visits')}}').then(function (response) {

                                    angular.forEach(response.data.visits, function (pharmacy) {
                                        $('#pharmacy-' + pharmacy.customer_id).find('.visits').html(pharmacy.visits);
                                    });

                                });

                            });
                } else {
                    $('#pharmaciesTable').fadeIn();
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
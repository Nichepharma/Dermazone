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

          @if($data['IsPromoter'] == true)
            <div class="col-md-2 col-xs-6">
                <button class="buttonallsite3" ng-class="{'active': activeTab=='promoters'}" ng-click="showPromoters()">Sales In Details</button>
            </div>
          @elseif($data['IsAdmin'] == true)
            <div class="col-md-2 col-xs-6">
                <button class="buttonallsite3" ng-class="{'active': activeTab=='overyearpromoters'}" ng-click="showOverYearPromoters()">Over Year Achievement</button>
            </div>
          @else
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

            <div class="col-md-2 col-xs-6">
                <button class="buttonallsite3" ng-class="{'active': activeTab=='workshops'}" ng-click="showWorkshops()">Workshops</button>
            </div>

            <div class="col-md-2 col-xs-6">
                <button class="buttonallsite3" ng-class="{'active': activeTab=='sumreport'}" ng-click="showSumReport()">Summary Report</button>
            </div>

          @endif
        </div>

        <div class="col-sm-12">
            <table st-safe-src="doctorsCollection" st-table="displayDoctorsCollection" class="table table-striped table-bordered" id="doctorsTable">
                <thead>
                <tr>
                    <th st-sort="name">name</th>
                    <th st-sort="name">Customer Status</th>
                    <th st-sort="speciality">speciality</th>
                    <th st-sort="grade">Class</th>
                    <th st-sort="area">area</th>
                    <th st-sort="n_visits">Visits Rate</th>
                    @foreach($data['months'] as $month)
                        <th colspan="5">{{$month}}</th>
                    @endforeach
                </tr>
                <tr>
                  <th><input st-search="name" placeholder="Search for Name" class="input-sm form-control" type="search"/></th>
                  <th></th>
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
                    <th>

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
                  <td>[[row.status]]</td>
                    <td>[[row.speciality]]</td>
                    <td>[[row.grade]]</td>
                    <td ng-init="row.area = areas[row.area_id]">[[ row.area ]]</td>
                    <td>[[row.n_visits]]</td>
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
                    <th st-sort="n_visits">Visits Rate</th>
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
                    <th>

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
                    <td>[[row.n_visits]]</td>
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

            <table st-safe-src="workshopsCollection" st-table="displayworkshopsCollection" class="table table-striped table-bordered"
                   id="workshopsTable">
                <thead>
                <tr>
                    <th st-sort="test">Customer</th>
                    <th st-sort="test">Date</th>
                    <th st-sort="test">Samples</th>
                    <th st-sort="test">Product Category</th>
                    <th st-sort="test">Sub Category</th>
                    <th st-sort="test">Comments & Notes</th>

                </tr>

                </thead>
                <tbody>
                <tr ng-repeat="row in displayworkshopsCollection">
                    <td>[[$index+1]]. [[row.doctor_name]]</td>
                    <td>[[row.workshop_date]]</td>
                    <td>[[row.samples]]</td>
                    <td>[[row.product_name]]</td>
                    <td>[[row.subcat]]</td>
                    <td>[[row.comment]]</td>
                </tr>
                </tbody>
            </table>

            <table st-safe-src="promotersCollection" st-table="displaypromotersCollection" class="table table-striped table-bordered"
                   id="promotersTable">
                <thead>
                <tr>
                    <th st-sort="test">#</th>
                    <th st-sort="date">Date</th>
                    <th st-sort="cat">Category</th>
                    <th st-sort="product_name">Product</th>
                    <th st-sort="test">Price</th>
                    <th st-sort="test">Quantity</th>
                    <th st-sort="test">Total</th>
                </tr>
                <tr>
                  <th></th>
                  <th>
                      <select st-search="date" class="form-control">
                          <option value="">- All -</option>
                          <option ng-repeat="row in promotersCollection | unique:'date'" value="[[row.date]]">[[row.date]]</option>
                      </select>
                  </th>
                  <th>
                      <select st-search="cat" class="form-control">
                          <option value="">- All -</option>
                          <option ng-repeat="row in promotersCollection | unique:'cat'" value="[[row.cat]]">[[row.cat]]</option>
                      </select>
                  </th>
                  <th>
                      <select st-search="product_name" class="form-control">
                          <option value="">- All -</option>
                          <option ng-repeat="row in promotersCollection | unique:'product_name'" value="[[row.product_name]]">[[row.product_name]]</option>
                      </select>
                  </th>
                  <th></th>
                  <th></th>
                  <th></th>
                </tr>

                </thead>
                <tbody>
                <tr ng-repeat="row in displaypromotersCollection">
                    <td>[[$index+1]]</td>
                    <td>[[row.date]]</td>
                    <td>[[row.cat]]</td>
                    <td>[[row.product_name]]</td>
                    <td>[[row.price]]</td>
                    <td>[[row.qnt]]</td>
                    <td>[[row.qnt * row.price]]</td>
                </tr>
                </tbody>
                <tfoot>
                <tr>
                    <th st-sort="test"></th>
                    <th st-sort="test"></th>
                    <th st-sort="test"></th>
                    <th st-sort="test"></th>
                    <th st-sort="test"></th>
                    <th st-sort="test">[[getPromotersUnitsTotal()]]</th>
                    <th st-sort="test">[[getPromotersTotal()]]</th>
                </tr>
              </tfoot>
            </table>

            <table st-safe-src="overyearpromotersCollection" st-table="displayoveryearpromotersCollection" class="table table-striped table-bordered"
                   id="overyearpromotersTable">
                <thead>
                <tr>
                    <th st-sort="test">#</th>
                    <th st-sort="date">Promoter Name</th>
                    <th st-sort="test" ng-repeat="n in [1,2,3,4,5,6,7,8,9,10,11,12]">[[getMonth(n)]]</th>
                    <th st-sort="test">Total</th>
                </tr>

                </thead>
                <tbody>
                <tr ng-repeat="row in displayoveryearpromotersCollection">
                    <td>[[$index+1]]</td>
                    <td><a href="http://tacitapp.com/dermazone/insights/accumulative-details/[[row.id]]">[[row.fullname]]</a></td>
                    <td>[[row.m1]]</td>
                    <td>[[row.m2]]</td>
                    <td>[[row.m3]]</td>
                    <td>[[row.m4]]</td>
                    <td>[[row.m5]]</td>
                    <td>[[row.m6]]</td>
                    <td>[[row.m7]]</td>
                    <td>[[row.m8]]</td>
                    <td>[[row.m9]]</td>
                    <td>[[row.m10]]</td>
                    <td>[[row.m11]]</td>
                    <td>[[row.m12]]</td>
                    <td>[[row.total]]</td>
                </tr>
                </tbody>
                <tfoot>
                <tr>
                  <th st-sort="test"></th>
                  <th st-sort="test"></th>
                    <th st-sort="test">[[getOverYearPromotersTotal(1)]]</th>
                    <th st-sort="test">[[getOverYearPromotersTotal(2)]]</th>
                    <th st-sort="test">[[getOverYearPromotersTotal(3)]]</th>
                    <th st-sort="test">[[getOverYearPromotersTotal(4)]]</th>
                    <th st-sort="test">[[getOverYearPromotersTotal(5)]]</th>
                    <th st-sort="test">[[getOverYearPromotersTotal(6)]]</th>
                    <th st-sort="test">[[getOverYearPromotersTotal(7)]]</th>
                    <th st-sort="test">[[getOverYearPromotersTotal(8)]]</th>
                    <th st-sort="test">[[getOverYearPromotersTotal(9)]]</th>
                    <th st-sort="test">[[getOverYearPromotersTotal(10)]]</th>
                    <th st-sort="test">[[getOverYearPromotersTotal(11)]]</th>
                    <th st-sort="test">[[getOverYearPromotersTotal(12)]]</th>
                    <th st-sort="test">[[getOverYearPromotersTotal("total")]]</th>
                </tr>
              </tfoot>
            </table>

            <table st-safe-src="sumreportCollection" st-table="displaysumreportCollection" class="table table-striped table-bordered"
                   id="sumreportTable_overall">
                <thead>
                <tr>
                    <th st-sort="test">Private Market</th>
                    <th st-sort="test">Pharmacies</th>
                    <th st-sort="test">Workshops</th>
                </tr>

                </thead>
                <tbody>
                <tr ng-repeat="row in displaysumreportCollectionOverall">
                    <td>[[row.doctors]]</td>
                    <td>[[row.phs]]</td>
                    <td>[[row.workshops]]</td>
                </tr>
                </tbody>
            </table>
            <table st-safe-src="sumreportCollection" st-table="displaysumreportCollection" class="table table-striped table-bordered"
                   id="sumreportTable_spec">
                <thead>
                <tr>
                    <th st-sort="test">Speciality</th>
                    <th st-sort="test">Number Of Doctors</th>
                </tr>

                </thead>
                <tbody>
                <tr ng-repeat="row in displaysumreportCollection">
                    <td>[[$index+1]]. [[row.spec]]</td>
                    <td>[[row.num]]</td>
                </tr>
                </tbody>
                <tfoot>
                  <tr ng-repeat="row in displaysumreportCollectionTotal">
                    <th st-sort="test">Total</th>
                    <th st-sort="test">[[row.total]]</th>
                  </tr>
              </tfoot>
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

            scope.showWorkshops = function () {
                $('.table').hide();
                scope.activeTab = 'workshops';
                if (typeof (scope.workshopsCollection) === 'undefined') {
                    $http.get('{{url('insights/accumulative-details/'.$data['userData']->id.'?type=workshops')}}')
                            .then(function (response) {
                                scope.workshopsCollection = response.data.workshops;
                                scope.displayworkshopsCollection = [].concat(scope.workshopssCollection);
                                //scope.areas = angular.fromJson(response.data.areas);
                                $('#workshopsTable').fadeIn();
                            });
                } else {
                    $('#workshopsTable').fadeIn();
                }
            };

            scope.showSumReport = function () {
                $('.table').hide();
                scope.activeTab = 'sumreport';
                if (typeof (scope.sumreportCollection) === 'undefined') {
                    $http.get('{{url('insights/accumulative-details/'.$data['userData']->id.'?type=sumreport')}}')
                            .then(function (response) {
                                scope.sumreportCollection = response.data.sumreport;
                                scope.displaysumreportCollection = [].concat(scope.sumreportCollection);
                                scope.sumreportCollectionTotal = response.data.sumreportTotal;
                                scope.displaysumreportCollectionTotal = [].concat(scope.sumreportCollectionTotal);
                                scope.sumreportCollectionOverall = response.data.sumreportOverall;
                                scope.displaysumreportCollectionOverall = [].concat(scope.sumreportCollectionOverall);
                                //scope.areas = angular.fromJson(response.data.areas);
                                $('#sumreportTable_overall').fadeIn();
                                if (scope.sumreportCollectionTotal[0]['total'] != 0){
                                  $('#sumreportTable_spec').fadeIn();
                                }

                            });
                } else {
                    $('#sumreportTable_overall').fadeIn();
                    if (scope.sumreportCollectionTotal[0]['total'] != 0){
                      $('#sumreportTable_spec').fadeIn();
                    }

                }
            };

            scope.showPromoters = function () {
                $('.table').hide();
                scope.activeTab = 'promoters';
                if (typeof (scope.promotersCollection) === 'undefined') {
                    $http.get('{{url('insights/accumulative-details/'.$data['userData']->id.'?type=promoters')}}')
                            .then(function (response) {
                                scope.promotersCollection = response.data.promoters;
                                scope.displaypromotersCollection = [].concat(scope.promotersCollection);
                                //scope.areas = angular.fromJson(response.data.areas);
                                $('#promotersTable').fadeIn();
                            });
                } else {
                    $('#promotersTable').fadeIn();
                }
            };

            scope.showOverYearPromoters = function () {
                $('.table').hide();
                scope.activeTab = 'overyearpromoters';
                if (typeof (scope.overyearpromotersCollection) === 'undefined') {
                    $http.get('{{url('insights/accumulative-details/'.$data['userData']->id.'?type=overyearpromoters')}}')
                            .then(function (response) {
                                scope.overyearpromotersCollection = response.data.overyearpromoters;
                                scope.displayoveryearpromotersCollection = [].concat(scope.overyearpromotersCollection);
                                //scope.areas = angular.fromJson(response.data.areas);
                                $('#overyearpromotersTable').fadeIn();
                            });
                } else {
                    $('#overyearpromotersTable').fadeIn();
                }
            };


            scope.getPromotersTotal = function(){
                var total = 0;
                for(var i = 0; i < scope.displaypromotersCollection.length; i++){
                    var product = scope.displaypromotersCollection[i];
                    total += (product.price * product.qnt);;
                }
                return total;
            }

            scope.getPromotersUnitsTotal = function(){
                var total = 0;
                for(var i = 0; i < scope.displaypromotersCollection.length; i++){
                    var product = scope.displaypromotersCollection[i];
                    total +=  (product.qnt * 1.0);
                }
                return total;
            }

            //for over all promoters report
            scope.getMonth = function(index){
              var monthNames = ["January", "February", "March", "April", "May", "June",
                "July", "August", "September", "October", "November", "December"
              ];
                return monthNames[index-1];
            }

            scope.getOverYearPromotersTotal = function(index){
                var total = 0;
                for(var i = 0; i < scope.displayoveryearpromotersCollection.length; i++){
                    var row = scope.displayoveryearpromotersCollection[i];
                    if(index == 1){total +=  row["m1"] * 1;}
                    else if(index == 2){total +=  row["m2"] * 1;}
                    else if(index == 3){total +=  row["m3"] * 1;}
                    else if(index == 4){total +=  row["m4"] * 1;}
                    else if(index == 5){total +=  row["m5"] * 1;}
                    else if(index == 6){total +=  row["m6"] * 1;}
                    else if(index == 7){total +=  row["m7"] * 1;}
                    else if(index == 8){total +=  row["m8"] * 1;}
                    else if(index == 9){total +=  row["m9"] * 1;}
                    else if(index == 10){total +=  row["m10"] * 1;}
                    else if(index == 11){total +=  row["m11"] * 1;}
                    else if(index == 12){total +=  row["m12"] * 1;}
                    else if(index == 'total'){total +=  row["total"] * 1;}
                }
                //alert(row["m11"]);
                return total;
            }

            @if($data['IsPromoter'] == true)
            scope.showPromoters();
            @elseif($data['IsAdmin'] == true)
            scope.showOverYearPromoters();
            @else
            scope.showDoctors();
            @endif

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

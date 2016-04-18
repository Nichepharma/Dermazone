@extends('layout.main')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class='col-sm-6 col-xs-12 slogintxt'>
            </div>
            <div class='col-sm-6 col-xs-12 text-right buttons2top'>
                <div class="pull-right"><img src="{{url('assets/images/support-btn.png')}}" id="support" border="0" alt=""/>
                    <div id="supportmenu">
                        <a href="javascript:;" data-toggle="modal" data-target="#myModal">Contact Us</a>
                        <!-- <a href="javascript:;" class="last">FAQ</a>-->
                    </div>
                </div>
                <div class="pull-right" style="margin-right: 10px"><img src="{{url('assets/images/notifications_btn.png')}}" id="notification" border="0" alt=""/>
                    <div id="notificationmenu">
                        @if(empty($data['messages']))
                            <p>0 Notifications<p>
                        @else
                            @foreach($data['messages'] as $message)
                                <a href="javascript:;"><span style="float:left">{{$message->message}}</span><span style="float:right">{{date3($message->date)}}</span></a><br>
                            @endforeach
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>

    <br><br>
    <div class="container" id="submenuDate">
        <div class="row">
            {{ Form::open(['url'=>'home','method'=>'post']) }}
            <div class='col-md-4'>
                From
                <div class="form-group">

                    <div class="daybg" id="dayfrom">SAT</div>
                    <div class='input-group date' id='datetimepicker6'>
                        <input type='text' id="datefrom" class="form-control" name="startDate" value="{{$data['startDate']}}"/>
                                    <span class="input-group-addon newbg">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                    </div>
                </div>
            </div>
            <div class='col-md-4'>
                to
                <div class="form-group">

                    <div class="daybg" id="dayto">SAT</div>
                    <div class='input-group date' id='datetimepicker7'>
                        <input type='text' id="dateto" class="form-control" name="endDate" value="{{$data['endDate']}}"/>
                                    <span class="input-group-addon newbg">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                    </div>
                </div>
            </div>
            <div class='col-md-4'>
                <br/>
                <input class="lgnbtn buttonnews" type="submit" value="Show insights"/>
            </div>
            {{Form::close()}}
        </div>
    </div>
    @stop

    @section('footer_inc')
            <!-- Modal -->
    <div id="myModal" class="modal fade" role="dialog">
        <form action="{{url('home/contact')}}" method="post" enctype="multipart/form-data">
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
                                    <select id="disabledSelect" name="disabledSelect" class="form-control">
                                        <option>Type of problem</option>
                                        <option>Installing</option>
                                        <option>Login</option>
                                        <option>During Call</option>
                                        <option>Compatibility of customers list</option>
                                        <option>Feedback</option>
                                        <option>Synchronization</option>
                                        <option>Appearance on tacitapp.com</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-12 selectContainer">
                                <textarea class="form-control" rows="10" name="message" id="message"></textarea>
                                <p id="comments" style='height:30px;color:white;'></p>

                                Your Photo: <input name="image" type="file" id="image"/>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-default buttonallsite2" style="margin-top:20px;">Send</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

@stop

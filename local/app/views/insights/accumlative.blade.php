@extends('layout.main')

@section('subMenu')
    <a href="{{url('insights/products')}}" class="submenubuttons">PRODUCT</a>
    <a href="{{url('insights/provinces')}}" class="submenubuttons">province</a>
    <a href="{{url('insights/accumulative')}}" class="submenubuttons active">ACCUMULATIVE</a>
    <a href="{{url('insights/interval')}}" class="submenubuttons">INTERVAL</a>
@stop

@section('content')
    <div class="@if($data['provinceId'] == null) page-content @else page-content1 @endif">

        @include('layout.inner_left_menu',[
        'items'=>$data['provinces'],
        'url'=>'insights/accumulative',
        'active'=>$data['provinceId'],
        'headUrl'=>'insights/accumulative',
        'title'=>'Provinces',
        ])
        <div class='col-md-10 col-xs-12'>
            @if($data['provinceId'] != null)
                @include('others.print_buttons')


                <h2>Accumlative Insights</h2>
                <table class="table">
                    <thead>
                    <tr>
                        <th><i class="glyphicon glyphicon-user blue"></i> Reps</th>
                        <th>Product Insights</th>
                        <th>Calls</th>
                        <th>Visits</th>
                        <th>Comments</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $i = 0; ?>
                    @foreach($data['reps'] as $rep)
                        <?php $i++; ?>

                        <tr id="rep-{{$rep->id}}">
                            <th scope='row'>
                                <a href='{{url('insights/accumulative-details/'.$rep->id)}}'>{{$i}}. {{$rep->fullname}}</a>
                            </th>
                            <td><a href='{{url('insights/user-products/'.$rep->id)}}'>Products</a></td>
                            <td class="callsCount">0</td>
                            <td class="visitsCount">0</td>
                            <td>
                                <a href="javascript:;" onmousedown="openCommentForm({{$rep->id}});">
                                    <i class="glyphicon	glyphicon-plus"></i>
                                </a> &nbsp; &nbsp; &nbsp;
                                <a href="javascript:;" onmousedown="getUserComments({{$rep->id}});" class="rep-comments hidden">
                                    <i class="glyphicon glyphicon-comment"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>




            @endif

        </div>
    </div>
@stop

@section('footer_inc')

    <div id="myModal2" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">

                    <div class="form-group">
                        <div class="col-xs-12 selectContainer">
                            <h3>Comments</h3>
                            <textarea class="form-control" rows="8" id="comment" placeholder="Add comment here.."></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-12">
                            <input id="datetimepicker12" class="form-control"/>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-default buttonallsite2" id="commentsend" onclick="addComment();">Send</button>
                </div>
            </div>

        </div>
    </div>

    <div id="myModal3" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">

                    <div class="col-xs-12 selectContainer">
                        <h3>Comments</h3>
                        <div id="userComments" class="well">Searching for Comments...</div>
                    </div>


                </div>
                <div class="modal-footer">
                </div>

            </div>

        </div>
    </div>




    @if($data['provinceId'] != null)

        <script>

            $.get("{{url('insights/accumulative/1?getRepsDetails=1')}}", function (response) {

                if (typeof(response.comments) !== 'undefined') {
                    $.each(response.comments, function (index, value) {
                        $('#rep-' + value.user_id).find('.rep-comments').removeClass('hidden');
                    });
                }

                if (typeof(response.repsData) !== 'undefined') {
                    $.each(response.repsData, function (userId, userData) {
                        $('#rep-' + userId).find('.visitsCount').html(userData.visits);
                        $('#rep-' + userId).find('.callsCount').html(userData.calls);
                    });
                }
            });
            var userId = 0;

            function openCommentForm(id) {
                userId = id;
                $('#myModal2').modal('show');
            }

            // send comment to the ajax to save it
            function addComment() {
                $.post("{{url('insights/submit-comment')}}", {
                    date: $("#datetimepicker12").val(),
                    comment: $('#comment').val(),
                    user_id: userId,
                    type: 1
                }, function (response) {
                    $('#rep-' + userId).find('.rep-comments').removeClass('hidden');
                    $('#myModal2').modal('hide');
                });

            }

            function getUserComments(userId) {

                $.get("{{url('insights/accumulative/1?getUserComments=')}}" + userId, function (response) {
                    $('#userComments').html(response);
                    $('#myModal3').modal('show');
                });
            }


            $(function () {
                $('#datetimepicker12').datetimepicker({
                    inline: true,
                    sideBySide: false,
                    format: 'YYYY-MM-DD'
                });
            });

        </script>
    @endif

@stop
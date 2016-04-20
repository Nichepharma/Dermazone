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
            @if($data['provinceId'] != null)
                @include('others.print_buttons')


                <h2>Interval Insights</h2>
                <table class="table myTable">
                    <thead>
                    <tr>
                        <th><i class="glyphicon glyphicon-user blue"></i> Rep.</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $i = 0; ?>
                    @foreach($data['reps'] as $repId=>$repData)
                        <?php $i ++; ?>

                        <tr>
                            <th scope='row'>
                                <a href='{{url('insights/interval/'.$data['provinceId'].'/'.$repData['id'])}}'>{{$i}}. {{$repData['fullname']}}</a>
                            </th>
                        </tr>
                    @endforeach
                    </tbody>
                </table>




            @endif

        </div>
    </div>
@stop

@section('footer_inc')
@stop

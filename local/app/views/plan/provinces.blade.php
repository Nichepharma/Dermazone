@extends('layout.main')

@section('content')
    <div class="@if($data['provinceId'] == null) page-content @else page-content1 @endif">

        @include('layout.inner_left_menu',[
        'items'=>$data['provinces'],
        'url'=>'plan/index',
        'headUrl'=>'plan',
        'active'=>$data['provinceId'],
        'title'=>'Provinces',
        ])
        <div class='col-md-10 col-xs-12'>
            @if($data['provinceId'] != null)
                @include('others.print_buttons')


                <h2>Reps Plan</h2>
                <table class="table myTable">
                    <thead>
                    <tr>
                        <th><i class="glyphicon glyphicon-user blue"></i> Rep.</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $i = 0; ?>
                    @foreach($data['reps'] as $repId=>$repName)
                        <?php $i ++; ?>

                        <tr>
                            <th scope='row'>
                                <a href='{{url('plan/user-plan/'.$repId)}}'>{{$i}}. {{$repName}}</a>
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
@extends('layout.main')

@section('head')
    <h3>Create {{ $data['module'] }}</h3>
@stop

@section('main')
    {{ Form::open(array('route' => ''.$data['modules'].'.store', 'class' => 'form-horizontal validate', 'files' => true)) }}

    <div class="row">
        <div class="col-md-8">
            <div class="box box-primary form_wrapper">
                <span class="text-primary">{{ translate('main.user roles') }}</span>

                <div class="clearfix">
                    @foreach (all_routs() as $route)
                        <div class="row">
                            <h4 class="cursor-pointer marginleft15"><i class="check-permissions fa fa-check-square-o"> {{ translate('main.'.$route) }}</i></h4>
                            @foreach (all_actions() as $action_title=>$action_name)
                                <div class="col-sm-6" style="overflow: hidden">
                                    {{ Form::checkbox('permissions['.$data['permissions'][$route.'.'.$action_name].']', $data['permissions'][$route.'.'.$action_name], '', ['class'=>'permission-checkbox '.$route,'id'=>'id_'.$action_name.$route]) }}
                                    {{ Form::label('id_'.$action_name.$route, translate('main.'.$action_name).' '.translate('main.'.$route),['class'=>'control-label']) }}
                                </div>
                            @endforeach
                        </div>
                        <hr>
                    @endforeach

                    @foreach (other_routes() as $module=>$actions)
                        <div class="row">
                            <h4 class="cursor-pointer marginleft15"><i class="check-permissions fa fa-check-square-o"
                                                                       id="{{$module}}"> {{ translate('main.'.$module) }}</i>
                            </h4>
                            @foreach ($actions as $action_name)
                                <div class="col-md-6" style="overflow: hidden">
                                    {{ Form::checkbox('permissions['.$data['permissions'][$module.'.'.$action_name].']', $data['permissions'][$module.'.'.$action_name], false, ['class'=>'permission-checkbox '.$module,'id'=>'id_'.$action_name.$module]) }}
                                    {{ Form::label('id_'.$action_name.$module, translate('main.'.$action_name).' '.translate('main.'.$module),['class'=>'control-label']) }}
                                </div>
                            @endforeach
                        </div>
                        <hr>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="box clearfix box-primary form_wrapper">
                <div class="col-md-12">
                    <div class="form-group">
                        {{ Form::label('name', 'Name:', array('class'=>'control-label')) }}
                        {{ Form::text('name','',['class'=>'form-control','placeholder'=>'Name','required']) }}
                    </div>
                    <div class="form-group">
                        {{ Form::label('level', translate('main.level'), array('class'=>'control-label')) }}
                        <select name="level" class="form-control">
                            @for($i=1;$i<11; $i++)
                                <option value="{{$i}}">{{$i}}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="form-group">
                        {{ Form::label('description', 'Description:', array('class'=>'control-label')) }}
                        {{ Form::textarea('description','',['class'=>'form-control','placeholder'=>'Description']) }}
                    </div>
                    <div class="form-group">
                        {{ Form::label('active', translate('main.active'), array('class'=>'col-md-3 control-label')) }}
                        <div class="col-md-9" style="padding-top: 5px;">
                            <input name="active" type="checkbox" checked="checked"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-9 col-md-offset-3">
                            {{ Form::submit('Save', array('class' => 'btn btn-primary')) }}
                            {{ link_to_route(''.$data['modules'].'.index','cancel','', array('class' => 'btn btn-default')) }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{ Form::close() }}

    <script>
        $(document).on('click', '.check-permissions', function () {

            $(this).parent().parent().find('.iCheck-helper').click()

        });

    </script>
@stop

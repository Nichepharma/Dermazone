{{--{{pr2($data['permissions'])}}--}}
@extends('layout.main')

@section('head')
    <h3>{{translate('main.edit').' '.translate('main.'.$data['module'])}}</h3>
@stop

@section('main')

    {{ Form::model($data['model'], array('class' => 'form-horizontal validate', 'method' => 'PATCH', 'enctype' => 'multipart/form-data', 'route' => array(''.$data['modules'].'.update', $data['model']->id))) }}
    <div class="row">
        <div class="col-md-8">
            <div class="box box-primary form_wrapper">
                <span class="text-primary">{{ translate('main.user roles') }}</span>

                <div class="clearfix">
                    <?php
                    $role = new Toddish\Verify\Models\Role;
                    $role->id = $data['model']->id;
                    ?>
                    @foreach (all_routs() as $route)
                        <div class="row">
                            <h4 class="cursor-pointer marginleft15"><i
                                        class="check-permissions fa fa-check-square-o"> {{ translate('main.'.$route) }}</i>
                            </h4>
                            @foreach (all_actions() as $action_title=>$action_name)
                                <?php if ($role->has(array($route . '.' . $action_name))) $checked = true; else $checked = false; ?>

                                <div class="col-sm-6" style="overflow: hidden">
                                    {{ Form::checkbox('permissions['.$data['permissions'][$route.'.'.$action_name].']', $data['permissions'][$route.'.'.$action_name], $checked, ['class'=>'permission-checkbox '.$route,'id'=>'id_'.$action_name.$route]) }}
                                    {{ Form::label('id_'.$action_name.$route, translate('main.'.$action_name).' '.translate('main.'.$route),['class'=>'control-label']) }}
                                </div>
                            @endforeach
                        </div>
                        <hr>
                    @endforeach

                    <h2>{{translate('main.advanced permissions')}}</h2>
                    @foreach (other_routes() as $module=>$actions)
                        <div class="row">
                            <h4 class="cursor-pointer marginleft15"><i class="check-permissions fa fa-check-square-o"
                                                                       id="{{$module}}"> {{ translate('main.'.$module) }}</i>
                            </h4>
                            @foreach ($actions as $action_name)
                                <?php
                                if ($role->has(array($module . '.' . $action_name))) $checked = true; else $checked = false;
                                ?>
                                <div class="col-sm-6" style="overflow: hidden">
                                    {{ Form::checkbox('permissions['.$data['permissions'][$module.'.'.$action_name].']', $data['permissions'][$module.'.'.$action_name], $checked, ['class'=>'permission-checkbox '.$module,'id'=>'id_'.$action_name.$module]) }}
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
                        {{ Form::label('name', translate('main.name'), array('class'=>'control-label')) }}
                        {{ Form::text('name',$data['model']->name,['class'=>'form-control','placeholder'=>'Name','required']) }}
                    </div>

                    <div class="form-group">
                        {{ Form::label('level', translate('main.level'), array('class'=>'control-label')) }}

                        @if($data['model']->id==1)
                            10
                        @else
                            <select name="level" class="form-control">
                                @for($i=1;$i<11; $i++)
                                    <option value="{{$i}}" {{ ($data['model']->level==$i ? 'selected="selected"':'') }}>{{$i}}</option>
                                @endfor
                            </select>
                        @endif
                    </div>

                    <div class="form-group">
                        {{ Form::label('description', translate('main.description'), array('class'=>'control-label')) }}
                        {{ Form::textarea('description',$data['model']->description,['class'=>'form-control','placeholder'=>'Description']) }}
                    </div>

                    @if($data['model']->id>1)
                        <div class="form-group">
                            {{ Form::label('active', translate('main.active'), array('class'=>'col-md-3 control-label')) }}
                            <div class="col-sm-9" style="padding-top: 5px;">
                                <input name="active" type="checkbox"
                                       @if($data['model']->active==1) checked="checked" @endif />
                            </div>
                        </div>
                    @endif

                    <div class="form-group">

                        {{ Form::submit(translate('main.save'), array('class' => 'btn btn-primary')) }}
                        {{ link_to_route(''.$data['modules'].'.index',translate('main.cancel'),'', array('class' => 'btn btn-default')) }}

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

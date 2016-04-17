<div class="modal-header modal-header-primary">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3 class="modal-title">{{ $data['user']->name }} {{translate('main.files')}}</h3>

</div>
<div class="modal-body">
    {{ Form::open(array('class' => 'form-horizontal add_files','route'=>'users.add_files', 'method' => 'post', 'files' => 'true')) }}
        <input type="hidden" value="{{$data['user']->id}}" name="user_id">

    <div class="row">
            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">

                    <div class="panel panel-primary" id="note-panel-images">
                        <div class="panel-heading" role="tab" id="headingimages">
                            <h4 class="panel-title" style="display: inline-block;">
                                <a data-toggle="collapse" data-parent="#accordion" href="#collapseimages" aria-expanded="true" aria-controls="collapseimages"><i class="fa fa-file-image-o"></i> {{translate('main.images')}}</a>
                            </h4>
                        </div>
                        <div id="collapseimages" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingimages">
                            <div class="panel-body">
                                @if(!empty($data['images']))
                                    @foreach($data['images'] as $key=>$image)
                                        <div class="file-div text-center" id="file-div-{{ $key }}">
                                            {{ display_img($data['modules'], $image['name'], $image['title'], $key) }}
                                        </div>
                                    @endforeach
                                @else
                                    {{translate('main.'.'no').' '.translate('main.images')}}
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="panel panel-primary" id="note-panel-files">
                        <div class="panel-heading" role="tab" id="headingfiles">
                            <h4 class="panel-title" style="display: inline-block;">
                                <a data-toggle="collapse" data-parent="#accordion" href="#collapsefiles" aria-expanded="true" aria-controls="collapsefiles"><i class="fa fa-file-word-o"></i> {{translate('main.documents')}}</a>
                            </h4>
                        </div>
                        <div id="collapsefiles" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingfiles">
                            <div class="panel-body">
                                @if(!empty($data['files']))
                                    @foreach($data['files'] as $key=>$file)
                                            <div class="file-div text-center" id="file-div-{{ $key }}">
                                                {{ display_document($data['modules'], $file['name'], $file['title'], $key) }}
                                            </div>
                                    @endforeach
                                @else
                                    {{translate('main.'.'no').' '.translate('main.documents')}}
                                @endif
                            </div>
                        </div>
                    </div>

            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">

                <div class="form-group more-user-files">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="btn btn-default btn-file btn-block">
                                <i class="fa fa-paperclip"></i> {{translate('main.upload')}} {{ Form::file('files[1]',['class'=>'form-control margin_bottom_8 client_file']) }}
                            </div>
                        </div>
                        <div class="col-sm-5">
                            {{ Form::text('file_names[1]','',['class'=>'form-control margin_bottom_8','placeholder'=>translate('main.file name')]) }}
                        </div>
                        <div class="col-sm-1">
                            <a class="btn btn-sm btn-success add-file" data-toggle="tooltip" title="{{translate('main.more')}}"><i class="fa fa-plus"></i></a>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-sm btn-success" title="Add Files"><i class="fa fa-save"></i> {{translate('main.save')}}</button>
            </div>
        </div>
    {{ Form::close() }}
</div>

<div class="modal-footer">
    {{ Form::button(translate('main.close'), array(
        'data-dismiss' => 'modal',
        'class' => 'btn btn-default',
    )) }}
</div>

<script>
    $(document).ready(function() {
        $("a[data-toggle='tooltip']").tooltip({'placement': 'top', 'z-index': '3000'});
    });
</script>
@extends('profilelayout')
@section('content')
    <div class="page-header">
        <h3>Upload</h3>
    </div>
    <div class="row row-upload">
        <div class="col-md-6" style="white-space: nowrap; padding: 0px;">
            <div class="form-group">
                <label for="interpret" class="col-sm-2 control-label">Artist</label>
                <div class="col-sm-10">
                    {!! Form::text('interpret', null, ['id' => 'interpret', 'class' => 'form-control', 'placeholder' => 'Artist']) !!}
                </div>
            </div>
            <div class="form-group">
                <label for="songtitle" class="col-sm-2 control-label">Song Title</label>
                <div class="col-sm-10">
                    {!! Form::text('songtitle', null, ['id' => 'songtitle', 'class' => 'form-control', 'placeholder' => 'Songtitle']) !!}
                </div>
            </div>
            <div class="form-group">
                <label for="imgsource" class="col-sm-2 control-label">Video source</label>
                <div class="col-sm-10">
                    {!! Form::text('imgsource', null, ['id' => 'imgsource', 'class' => 'form-control', 'placeholder' => 'Video Source (This is not for links!)']) !!}
                </div>
            </div>
            <div class="form-group">
                <label for="category" class="col-sm-2 control-label">Category</label>
                <div class="col-sm-10">
                    <?php
                        $categories = [];
                        foreach(App\Models\Category::all() as $cat)
                            $categories[$cat->id] = $cat->name;
                    ?>
                    {!! Form::select('category', $categories, 8, ['id' => 'category', 'class' => 'form-control']) !!}
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button id="btn-upload" type="button" style="width: 100%; height: 40px;" class="btn btn-default">Upload</button>
                    <p style="text-align:center; padding-top: 5px;">Before you click upload make sure you have read the <a href="/rules">Rules</a></p>
                </div>
            </div>
        </div>
        <div id="dragndrop" class="form-group col-md-3" data-uploadlimit="{{ isset($user) ? ($user->can('break_max_filesize') ? 'false' : 'true') : 'true' }}">
            <a id="dragndrop-link" href="#">
                <span style="display: table; width: 100%; height: 100%;">
                    <span id="dragndrop-text">
                        <i class="fa fa-cloud-upload"></i><br>
                        Drop file or click!
                    </span>
                </span>
            </a>
        </div>
        <input name="file" type="file" class="hidden" accept=".webm"></input>
        <div class="col-md-3">
            <div class="panel panel-primary rulez">
                <div class="panel-heading"><b><i>Da Rules</i></b></div>
                <ol class="list-group">
                    <li class="list-group-item"><b>1.</b> WebMs need to have sound!</li>
                    <li class="list-group-item list-group-item-danger"><b>2.</b> No child pornography!</li>
                    <li class="list-group-item"><b>3.</b> Ask yourself: Does it fit in here?</li>
                    <li class="list-group-item"><b>4.</b> Never upload things you don't feel good about!</li>
                </ol>
                <div class="panel-body">If you need help creating WebMs, check <a href="/webm">this</a> out.</div>
                <div class="panel-body"><b>Current Limits:</b> <br> <b>10</b> <i>uploads every 12 hours</i> <br><i>Maximum filesize:</i> <b>30MB</b> <br><i>Only</i> <b>.webm</b> <i>allowed</i></div>
            </div>
        </div>
    </div>
@endsection

@extends('layout')
@section('content')
    <div class="page-header">
        <h1>Upload</h1>
    </div>
    <div class="row">
        <div class="col-md-9">
            <div class="row">
                <form class="form-horizontal" method="post" action="upload" enctype="multipart/form-data">
                    {!! csrf_field() !!}
                    <div class="form-group">
                        <label for="interpret" class="col-sm-2 control-label">Interpret</label>
                        <div class="col-sm-10">
                            {!! Form::text('interpret', null, ['class' => 'form-control', 'placeholder' => 'Interpret']) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="songtitle" class="col-sm-2 control-label">Song title</label>
                        <div class="col-sm-10">
                            {!! Form::text('songtitle', null, ['class' => 'form-control', 'placeholder' => 'Song Title']) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="imgsource" class="col-sm-2 control-label">Video source</label>
                        <div class="col-sm-10">
                            {!! Form::text('imgsource', null, ['class' => 'form-control', 'placeholder' => 'Video Source']) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="category" class="col-sm-2 control-label">Category</label>
                        <div class="col-sm-10">
                            <?php
                                $categories = [];
                                foreach(App\Models\Category::all() as $cat) {
                                    $categories[$cat->id] = $cat->name;
                                }
                            ?>
                            {!! Form::select('category', $categories, 8, ['class' => 'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="file" class="col-sm-2 control-label">File</label>
                        <div class="col-sm-10">
                            {!! Form::file('file', ['class' => 'form-control', 'placeholder' => 'Select file']) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-default">Shitpost</button> Before you shitpost make sure to read the <a href="/about">ToS</a> .
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-md-3">
            <div class="panel panel-primary rulez">
                <div class="panel-heading"><b><i>Da Rules</i></b></div>
                <ol class="list-group">
                    <li class="list-group-item"><b>1.</b> WebMs need to have sound!</li>
                    <li class="list-group-item list-group-item-danger"><b>2.</b> No child pornography!</li>
                    <li class="list-group-item"><b>3.</b> Upload only videos you think others will like!</li>
                    <li class="list-group-item"><b>4.</b> Don't be a faggot.</li>
                </ol>
                <div class="panel-body">If you need help creating WebMs, check <a href="/webm">this</a> out.</div>
                <div class="panel-body"><b>Current Limits:</b> <br> <b>10</b> <i>uploads every 12 hours</i> <br><i>Maximum filesize:</i> <b>30MB</b> <br><i>Only</i> <b>.webm</b> <i>allowed</i></div>
            </div>
        </div>
    </div>
@endsection

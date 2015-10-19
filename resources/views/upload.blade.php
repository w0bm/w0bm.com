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
                            {!! Form::select('category', $categories, null, ['class' => 'form-control']) !!}
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
                            <button type="submit" class="btn btn-default">Upload</button> Maximum filesize is 30MB | Allowed filetypes: .webm | 20 Uploads every 24h 
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-md-3">
            <div class="panel panel-primary">
                <div class="panel-heading">Rules</div>
                <ul class="list-group">
                    <li class="list-group-item">WebMs must have sound</li>
                    <li class="list-group-item list-group-item-danger">Do not upload child pornography!</li>
                    <li class="list-group-item list-group-item-danger"">Do not upload Loli videos!</li>
	            <li class="list-group-item">Uploads must be listed in the correct category.</li>
		   <li class="list-group-item">No refugee Videos of any kind!</li>
		    <li class="list-group-item">No videos of beastiality, gore or very disturbing porn.</li>
                </ul>
                <div class="panel-body">Please follow these rules to have a great time here at w0bm!</div>
            </div>
        </div>
    </div>
@endsection

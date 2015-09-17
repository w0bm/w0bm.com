@extends('layout')
@section('content')
    <div class="page-header">
        <h1>Upload</h1>
    </div>
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
            <label for="imgsrc" class="col-sm-2 control-label">Image source</label>
            <div class="col-sm-10">
                {!! Form::text('imgsrc', null, ['class' => 'form-control', 'placeholder' => 'Image Source']) !!}
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
                <button type="submit" class="btn btn-default">Upload</button>
		<br><p><h2>Rules:</h2>
		<ul>
			<li>WebMs must have sound!</li>
			<li>Do not upload child pornography!</li>
			<li>Uploads must be listed in the correct category.</li>
			<br><p>Please follow these rules to have a great time here at w0bm!
		</ul>
            </div>
        </div>
    </form>
</div>
@endsection
@extends('layout');
@section('content')
<div class="row">
    <form class="form-horizontal" method="post" action="upload" enctype="multipart/form-data">
        {!! csrf_field() !!}
        <div class="form-group">
            <label for="interpret" class="col-sm-2 control-label">Interpret</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="interpret" placeholder="Interpret">
            </div>
        </div>
        <div class="form-group">
            <label for="songtitle" class="col-sm-2 control-label">Song title</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="songtitle" placeholder="Song title">
            </div>
        </div>
        <div class="form-group">
            <label for="imgsrc" class="col-sm-2 control-label">Image source</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="imgsrc" placeholder="Image source">
            </div>
        </div>
        <div class="form-group">
            <label for="category" class="col-sm-2 control-label">Category</label>
            <div class="col-sm-10">
                <select name="category" id="category" class="form-control">
                    @foreach(App\Models\Category::all() as $category)
                        <option value="{{ $category->id }}">{{$category->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group">
            <label for="file" class="col-sm-2 control-label">File</label>
            <div class="col-sm-10">
                <input type="file" name="file" class="form-control" id="file" placeholder="Select file">
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-default">Upload</button>
            </div>
        </div>
    </form>
</div>
@endsection
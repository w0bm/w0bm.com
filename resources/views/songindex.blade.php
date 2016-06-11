@extends('profilelayout')
@section('content')
    <div class="page-header">
	<h1>Songindex</h1>
        
        <form method="get">
            {!! Form::text('q', null, ['class' => 'suchleiste', 'placeholder' => 'Search']) !!}
            <button type="submit" class="suchbutton"><i style="color:white;" class="fa fa-search"></i></button>
        </form>
    </div>
    <table class="table table-hover table-condensed">
        <thead>
        <tr>
            <th>ID</th>
            <th>Interpret</th>
            <th>Songtitle</th>
            <th>Video Source</th>
            <th>Category</th>
        </tr>
        </thead>
        <tbody>
        @foreach($videos as $video)
            <?php
                $thumb = str_replace(".webm","",$video->file);
            ?>
            <tr data-thumb="{{$thumb}}" class="indexedit" data-vid="{{$video->id}}">
                <td>
                    @if($edit = auth()->check() && auth()->user()->can('edit_video'))
                        <form action="/songindex/{{$video->id}}" method="post" id="edit_{{$video->id}}" class="indexform"></form>
                    @endif
                    <span class="vinfo vid"><a href="{{url($video->id)}}">{{$video->id}}</a></span>
                    @if($edit)
                        <input type="submit" class="btn btn-primary" value="Save" form="edit_{{$video->id}}">
                    @endif
                </td>
                <td>
                    <span class="vinfo vinterpret">{{$video->interpret or ''}}</span>
                    @if($edit)
                        <input class="form-control" type="text" name="interpret" value="{{$video->interpret or ''}}" form="edit_{{$video->id}}">
                    @endif
                </td>
                <td>
                    <span class="vinfo vsongtitle">{{$video->songtitle or ''}}</span>
                    @if($edit)
                        <input class="form-control" type="text" name="songtitle" value="{{$video->songtitle or ''}}" form="edit_{{$video->id}}">
                    @endif
                </td>
                <td>
                    <span class="vinfo vimgsource">{{$video->imgsource or ''}}</span>
                    @if($edit)
                        <input class="form-control" type="text" name="imgsource" value="{{$video->imgsource or ''}}" form="edit_{{$video->id}}">
                    @endif
                </td>
                <td>
                    <span class="vinfo vcategory"><a href="{{url($video->category->shortname)}}">{{$video->category->name}}</a></span>
                    @if($edit)
                        <select class="form-control" name="category" form="edit_{{$video->id}}">
                            @foreach($categories as $cat)
                                <option value="{{$cat->id}}" @if($cat->shortname === $video->category->shortname) selected @endif>{{$cat->name}}</option>
                            @endforeach
                        </select>
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <div class="pull-right">
        {!! $videos->render() !!}
    </div>
@endsection

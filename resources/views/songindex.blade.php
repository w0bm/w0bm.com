@extends('layout')
@section('content')
    <div class="page-header">
        <h1>Songindex</h1>
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
            <tr>
                <td><a href="{{url($video->id)}}">{{$video->id}}</a></td>
                <td>{{$video->interpret or ''}}</td>
                <td>{{$video->songtitle or ''}}</td>
                <td>{{$video->imgsource or ''}}</td>
                <td><a href="{{url($video->category->shortname)}}">{{$video->category->name}}</a></td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <div class="pull-right">
        {!! $videos->render() !!}
    </div>
@endsection

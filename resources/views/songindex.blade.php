@extends('layout')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <table class="table table-hover table-condensed table-striped">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Interpret</th>
                    <th>Songtitle</th>
                    <th>Image Source</th>
                    <th>Category</th>
                </tr>
                </thead>
                <tbody>
                @foreach($videos as $video)
                    <tr>
                        <td><a href="{{$video->id}}">{{$video->id}}</a></td>
                        <td>{{$video->interpret or ''}}</td>
                        <td>{{$video->songittle or ''}}</td>
                        <td>{{$video->imgsource or ''}}</td>
                        <td><a href="category/{{$video->category->id}}">{{$video->category->name}}</a></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 text-right">
            {!! $videos->render() !!}
        </div>
    </div>
@endsection
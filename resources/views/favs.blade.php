@extends('profilelayout')
@section('content')
@include('partials.profileheader')
	    <h3>Favorites</h3>
            <table class="table table-hover table-condensed">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Artist</th>
                    <th>Songtitle</th>
                    <th>Video Source</th>
                    <th>Category</th>
                </tr>
                </thead>
                <tbody>
                @foreach($videos as $video)
                    <?php $thumb = str_replace(".webm","",$video->file); ?>
                    <tr data-thumb="{{$thumb}}">
                        <td><a href="{{url($video->id)}}">{{$video->id}}</a></td>
                        <td>{{$video->interpret or ''}}</td>
                        <td>{{$video->songtitle or ''}}</td>
                        <td>{{$video->imgsource or ''}}</td>
                        <td><a href="{{url($video->category->shortname)}}">{{$video->category->name}}</a></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {!! $videos->render() !!}
@endsection

@extends('profilelayout')
@section('content')
@include('partials.profileheader')
	    <h3>{{ $title }}</h3>
            <table class="table table-hover table-condensed">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Artist</th>
                    <th>Songtitle</th>
                    <th class="hidden-xs">Video Source</th>
                    <th>Category</th>
                </tr>
                </thead>
                <tbody>
                @foreach($videos as $video)
                    <?php
                        $thumb = str_replace(".webm","",$video->file);
                    ?>
                    <tr data-thumb="{{$thumb}}">
                        <td><a href="/{{$user->baseurl()}}/{{$video->id}}">{{$video->id}}</a></td>
                        <td>{{$video->interpret or ''}}</td>
                        <td>{{$video->songtitle or ''}}</td>
                        <td class="hidden-xs">{{$video->imgsource or ''}}</td>
                        <td><a href="{{url($video->category->shortname)}}">{{$video->category->name}}</a></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {!! $videos->render() !!}
@endsection

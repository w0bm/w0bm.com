@extends('layout')
@section('content')

    <div class="page-header">
        <h1>{{$user->username}} <small><i class="fa fa-cloud-upload"></i> {{ $user->videos()->count() }} Uploads <i class="fa fa-commenting"></i> {{ $user->comments()->count() }} Comments</small>@if($user->is('Moderator')) <span class="pull-right" style="
    color: #1FB2B0;
"><i class="fa fa-bolt"></i></span> @endif</h1>
    </div>
    <div class="row">
        <div class="col-md-6">
            <h2>Uploads</h2>
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
                @foreach($user->videos as $video)
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
        </div>
        <div class="col-md-6">
            <h2>Favorites</h2>
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
                @foreach($user->favs as $video)
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
        </div>

    </div>



@endsection

@extends('layout')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="embed-responsive embed-responsive-16by9">
            <video id="video" controls loop src="b/{{$video->file}}"></video>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12 text-center">
        @if(($prev = $video->getPrev()) === null)
            <a href="#" style="visibility: hidden;">Prev</a> |
        @else
            <a href="{{$prev->id}}">Prev</a> |
        @endif
        <a href="/">random</a>
        @if(($next = $video->getNext()) === null)
            | <a href="#" style="visibility: hidden;">Next</a>
        @else
            | <a href="{{$next->id}}">Next</a>
        @endif
    </div>
</div>
@endsection

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
            <a id="prev" href="#" style="visibility: hidden;">Prev</a> |
        @else
            <a id="prev" href="{{$prev->id}}">Prev</a> |
        @endif
        <a href="/">random</a>
        @if(($next = $video->getNext()) === null)
            | <a id="next" href="#" style="visibility: hidden;">Next</a>
        @else
            | <a id="next" href="{{$next->id}}">Next</a>
        @endif
    </div>
</div>
@endsection
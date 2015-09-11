@extends('layout')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="embed-responsive embed-responsive-16by9">
            <video controls loop src="b/{{$video->file}}"></video>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12 text-center">
        @if(($prev = $video->getPrev()) === null)
            <a href="#" style="visibility: hidden;">Prev</a> |
        @else
            <a href="{{$prev->id}}">Next</a> |
        @endif
        <a href="/">random</a>
        @if(($next = $video->getNext()) === null)
            <a href="#" style="visibility: hidden;">Next</a>
        @else
            &nbsp;| <a href="{{$next->id}}">Next</a>
        @endif
    </div>
</div>
@endsection
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
        <a href="prev">prev</a> | <a href="random">random</a> | <a href="next">next</a>
    </div>
</div>
@endsection
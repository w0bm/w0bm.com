@extends('profilelayout')
@section('content')
	<div class="page-header">
        <h1>Messages</h1>
    </div>
	@foreach(auth()->user()->messagesRecv->reverse() as $message)
        <div class="message panel panel-default">
            <div class="panel-heading">{!! str_replace('</h3>', '</h3><span data-toggle="tooltip" data-container=".tooltip-container" data-placement="top" title="'.$message->created_at->format("d.m.Y H:i").'">'.$message->created_at->diffForHumans().'</span></div><div class="panel-body">',$message->content) !!}</div>
        </div>
        <div class="tooltip-container"></div>
        <br>
	@endforeach
@endsection

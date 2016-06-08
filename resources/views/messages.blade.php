@extends('layout')
@section('content')
	<div class="page-header">
        <h1>Messages</h1>
    </div>
	<table class="table table-hover table-condensed">
		@foreach(auth()->user()->messagesRecv->reverse() as $message)
		<tr>
			{!! $message->content !!}
			<a href="#" title="{{ $message->created_at->format('d.m.Y H:i') }}">{{ $message->created_at->diffForHumans() }}</a>
		</tr>
		<hr>
		@endforeach
	</table>
@endsection
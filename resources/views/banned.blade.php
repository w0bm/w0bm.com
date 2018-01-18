@extends('profilelayout')
@section('content')
<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">YOU ARE BANNED!</h3>
  </div>

  <div class="panel-body">
    <div style="border:0;" class="panel panel-default">
      <div class="panel-body">
        @if($perm)
        <p>Your ban is permanent fool and will <b>NOT</b> expire!</p>
        <video class="banwidth" autoplay loop src="https://b.w0bm.com/1515965864.webm">You are banned</video>
        @else
        <p class="banned">Reason: {{ $user->banreason }}</p>
        <p class="banned">Your ban will expire in {{ $user->banend->diffForHumans(null, true) }}</p>
        <img class="banwidth" src="otter-ban.png">
        @endif
      </div>
    </div>
    <p>If you think you were banned by accident or dindu nuffin to deserve the ban contact an administrator in the <a href="/irc">IRC</a></p>
  </div>
</div>
@endsection

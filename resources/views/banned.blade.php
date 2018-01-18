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
        <p>You ban is permanent and will <b>NOT</b> expire!</p>
        @else
        <p>Reason: {{ $user->banreason }}</p>
        <p>Your ban will expire in {{ $user->banend->diffForHumans(null, true) }}</p>
        <img class="" src="/otter-ban.png">
        @endif
      </div>
    </div>
    <p>If you think you were banned by accident or dindu nuffin to deserve the ban contact an administrator in the <a href="/irc">IRC</a></p>
  </div>
</div>
@endsection

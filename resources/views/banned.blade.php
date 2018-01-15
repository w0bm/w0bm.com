@extends('profilelayout')
@section('content')
<div class="panel pn-black">
  <h1 id="b4nned">YOU ARE BANNED!</h1>
  <video class="banvideo" src="https://b.w0bm.com/1515965864.webm" autoplay loop></video>
    <div class="bannedomg">
        @if($perm)
            <span id="bantime">Silence you furry fool, you are finished here!</span><br>
        @else
            <span id="bantime">Your ban will expire in {{ $user->banend->diffForHumans(null, true) }}</span><br>
        @endif
            <span id="banreason">Reason: {{ $user->banreason }}</span><br>
    </div>
</div>
@endsection

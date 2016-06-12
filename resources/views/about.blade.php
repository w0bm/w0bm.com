@extends('layout')
@section('content')
<?php $comment = config('comments'); ?>
<div class="page-header">
        <h1>About</h1>
</div>
<h4>Following shortcuts are available:</h4>
<ul>
   <li>Press: <strong style="color:#1FB2B0">r</strong> for random</li>
   <li>Press: <strong style="color:#1FB2B0">→</strong> for next</li>
   <li>Press: <strong style="color:#1FB2B0">←</strong> for prev</li>
   <li>Press: <strong style="color:#1FB2B0">f</strong> for fav</li>
   <li>Scroll with your mouse up and down to trigger next or prev</li>
   <li>Press: <strong style="color:#1FB2B0">c</strong> to toggle the comment section</li>
</ul>

<h4>Allowed sources for image parsing in the comment section</h4>
<p><code>Filetypes: [jpg,png,gif] - Only secure connections allowed</code></p>
<ul>
  @foreach($comment['allowedHosters'] as $hoster)
    <li>https://{{$hoster}}/</li>
  @endforeach
</ul>

<h4>The ToS</h4>
 <ol>
  <li>I try not to change w0bm, instead I try let w0bm change me.</li>
  <li>Using w0bm is not a right, it's a privilege we might revoke if you are a faggot</li>
  <li>I do not upload child porn.</li>
</ol> 
<br>
<br>
<br>
<nav class="navbar navbar-default navbar-fixed-bottom">
  <div class="container" style="text-align: center">
    <a href="/contact">Contact</a> | <a href="/privacy">Privacy Policy</a> | <a href="/donate">Donate</a>
<p>Inspired by <a href="http://z0r.de">z0r.de</a></p>
  </div>
</nav>
@endsection


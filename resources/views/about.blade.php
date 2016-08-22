@extends('profilelayout')
@section('content')
<?php $comment = config('comments'); ?>
<div class="page-header">
        <h3>About</h3>
</div>
<h4>What is w0bm.com about?</h4>
<ul>
<li>w0bm.com is a modern open source WebM sharing platform.</li>
<li>We collect random videos from the internet.</li>
<li>We have a public GitHub repository, you are free to fork, clone and whatever you want, it's your choice. <a href="https://github.com/w0bm/">Fork Me!</a>
</ul>

<h4>Following shortcuts are available:</h4>
<ul class="strong-colored">
   <li>Press: <strong>R</strong> for random</li>
   <li>Press: <strong>→</strong>, <strong>D</strong> or <strong>L</strong> for next</li>
   <li>Press: <strong>←</strong>, <strong>A</strong> or <strong>H</strong> for prev</li>
   <li>Press: <strong>↑</strong> or <strong>W</strong> for volume up</li>
   <li>Press: <strong>↓</strong> or <strong>S</strong> for volume down</li>
   <li>Press: <strong>F</strong> for fav</li>
   <li>Scroll with your mouse up and down to trigger next or prev</li>
   <li>Press: <strong>C</strong> to toggle the comment section</li>
</ul>
<h4>Allowed sources for image parsing in the comment section</h4>
<p><code>Filetypes: [jpg,png,gif,webp] - Only secure connections allowed</code></p>
<ul>
  @foreach($comment['allowedHosters'] as $hoster)
    <li>https://{{$hoster}}/</li>
  @endforeach
</ul>
@include('footer')
@endsection


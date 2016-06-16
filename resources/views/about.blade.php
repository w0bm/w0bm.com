@extends('layout')
@section('content')
<?php $comment = config('comments'); ?>
<div class="page-header">
        <h1>About</h1>
</div>
<h4>What is w0bm.com?</h4>
<ul>
<li>w0bm.com is a modern open source WebM sharing platform, free to use for anybody in the world, more details below.</li>
<li>We stand for freedom of speech and are professionals in not giving any fucks.</li>
<li>The mission was/is to be better than the already existing things, this is why we are here, we are here to provide people with awesome content without being a cucked shithole.</li>
<li>We have a public GitHub repository, you are free to fork, clone and whatever you want, it's your choice. <a href="https://github.com/w0bm/">Fork Me!</a>
</ul>

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
  <li>I am at least 18 years old!</li>
</ol> 
@include('footer')
@endsection


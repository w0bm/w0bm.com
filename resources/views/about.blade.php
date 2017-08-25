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
   <li>Press: <strong>SPACE</strong> to pause/unpause the video</li>
</ul>

<h4 class="filtersettings">Filter settings</h4>
<p style="color:red; font-weight:bold;">Filter is now global and not logged in users will only see sfw videos</p>
<p>You can also set your own custom filters by clicking on Filter and then inserting the tags you don't want to see while browsing.</p>
<p>Example:</p>
<span class="tag label label-info">gachimuchi</span> <span class="tag label label-info">gay</span>

<h4 class="mods">Need one of our professionals?</h4>
<p>Our Mods work 24/7/365 for free and are basically just here to delete your reposts</p>
<p>Contact them if you need them:</p>
<ul class="mötter">
<li><a href="/user/belst">belst</a></li>
<li><a href="/user/BKA">BKA</a></li>
<li><a href="/user/gz">gz</a></li>
<li><a href="/user/Flummi">Flummi</a></li>
<li><a href="/user/jkhsjdhjs">jkhsjdhjs</a></li>
<li><a href="/user/Czar">Czar</a></li>
</ul>

<h4 id="format">Comment formatting</h4>
<ul>
   <li>>mfw w0bm is nice :3 will become: <span style="color:#80FF00;">>mfw w0bm is nice :3</span></li>
   <li><s>!Pantsu Pantsu Pantsu! will become: <span class="reich">Pantsu Pantsu Pantsu</span></s> <b style="color:red;">[ Currently disabled ]</b></li>
   <li>%KREBS KREBS KREBS KREBS% will become: <span class="anim">KREBS KREBS KREBS KREBS</span></li>
   <li>*gg* or _gg_ will become: <em>gg</em></li>
   <li>**gg** or __gg__ will become: <strong>gg</strong></li>
   <li>~~nope~~ will become: <del>nope</del></li>
   <li>`code` will become: <code>code</code></li>
</ul>
<h4>Allowed sources for image parsing in the comment section</h4>
<p><code>Filetypes: [{{ join(',', $comment['allowedImageFileExtensions']) }}] - Only secure connections allowed</code></p>
<ul>
  @foreach($comment['allowedHosters'] as $hoster)
    <li>https://{{$hoster}}/</li>
  @endforeach
</ul>
<div class="alusexy">
<h4 id="friends">Friends</h4>
<ul>
<li><a href="https://safe.moe">safe.moe</a></li>
</ul>
<p>safe.moe is owned by <a href="/user/Alucard">Alucard</a> he hosts many of the images you can see while browsing through w0bm, he is a cool american guy, I can recommend to check out safe.moe, it's a fast and stable file hoster with no bullshit, upload and share, that's it.</p>
</div>
<b>We are 100% non profit, we don't get money for displaying the "ads" on the page, nor do we acceppt any kind of donations, we don't make money!</b>
@include('footer')
@endsection


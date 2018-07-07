@extends('profilelayout')
@section('content')
<?php $comment = config('comments'); ?>
<div class="page-header">
        <h3>About</h3>
</div>
<div class="box">
<h4>What is w0bm.com about?</h4>
<ul>
<li>w0bm.com is a modern open source WebM sharing platform.</li>
<li>We collect random videos from the internet.</li>
<li>w0bm loves PRs! You can find the <a href="https://github.com/w0bm/">source code</a> on GitHub!</li>
</ul>
</div>

<div class="box">
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
</div>

<div class="box">
<h4 class="filtersettings">Filter settings</h4>
<p style="color:red;">Filter is now global and not logged in users will only see sfw videos</p>
<p>You can also set your own custom filters by clicking on Filter and then inserting the tags you don't want to see while browsing.</p>
<p>Example:</p>
<div class="about-tags">
<span class="tag label label-info">anime</span> <span class="tag label label-info">asians</span> <span class="tag label label-info">Crayon Pop</span> <span class="tag label label-info">gay</span>
</div>
<p>You will see that our videos are tagged with either <span class="label label-default" style="color:#23ff00">sfw</span> or <span class="label label-default" style="color:red">nsfw</span> these labels mean in nearly 99% of the case at least for uploads tagged with nsfw that they are nsfw, but the sfw tag isn't always sfw and you shouldn't think that we really care about this, there is probably a lot of content which is not tagged as nsfw but still is nsfw.</p>
<p>Always take care and when you are not sure if you can browse w0bm at work, don't do it, we don't guarantee that everything is properly tagged and you will encounter something that can get you in trouble.</p>
</div>

<div class="box">
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
<li><a href="/user/flinny">flinny</a></li>
</ul>
<p>Mods can be contacted either via <code>@$modname</code> in the comments or via <a href="/community">IRC/Discord</a></p>
</div>

<div class="box">
<h4 id="format">Comment formatting</h4>
<ul>
   <li>>mfw w0bm is nice :3 will become: <span style="color:#80FF00;">>mfw w0bm is nice :3</span></li>
   <li>[reich]Pantsu Pantsu Pantsu[/reich] will become: <span class="reich">Pantsu Pantsu Pantsu</span></li>
   <li>[krebs]KREBS KREBS KREBS KREBS[/krebs] will become: <span class="anim">KREBS KREBS KREBS KREBS</span></li>
   <li>[rb]JA GEIL SCHNITZEL MHM JA!!!![/rb] will become: <span class="rainbow">JA GEIL SCHNITZEL MHM JA!!!!</span></li>
   <li>*gg* or _gg_ will become: <em>gg</em></li>
   <li>**gg** or __gg__ will become: <strong>gg</strong></li>
   <li>~~nope~~ will become: <del>nope</del></li>
   <li>`code` will become: <code>code</code></li>
   <li>--- will insert a line<hr>to seperate</li>
</ul>
<p>This cannot be stacked, don't do it.</p>
<p>If you want to answer someone, simply use <code>^</code> as often as you need to point to the comment you want to answer to.</p>
<p>If you want to ping someone directly in a comment use <code>@$user</code></p>
</div>

<div class="box">
<h4>Allowed sources for image parsing in the comment section</h4>
<p>Filetypes: {{ join(',', $comment['allowedImageFileExtensions']) }} - only secure https links will work!</p>
<ul>
  @foreach(array_keys($comment['allowedHosters']) as $hoster)
    @if($hoster != '')
      <li><a href="https://{{$hoster}}">{{$hoster}}</a></li>
    @endif
  @endforeach
</ul>
</div>

<div class="box">
<h4>FAQ</h4>
<p>Q: w0bm is laggy for me and I don't know why.</p>
<p>A: It's mostly because of the background. It's very resource heavy and can cause lag on some computers, if you experience this, you should click the yellow lightbulb on the video page to turn it off <i style="color:#fff200;" class="fa fa-lightbulb-o"></i></p>
<p>Q: I don't know how to create WebMs</p>
<p>A: Check out our <a href="/webm">WebM support</a> page and pick the solution you like the most!</p>
<p>Q: Can you allow mp4s to be uploaded?</p>
<p>A: Why do you think this website is called w0bm?</p>
<p>Q: I want to give you guys some feedback and maybe some suggestions, where should I go?</p>
<p>A: You can open a issue on our <a href="https://github.com/w0bm/">Github repository</a> and write down what you want to have as a feature and maybe it will happen some day, there is no guarantee since we are all lazy as fuck, or you can come directly to the <a href="/community">IRC/Discord</a> and tell us instantly!</p>
</div>
<div class="box">
<h4>Compability</h4>
<p>If you are experiencing issues with the connection you may want to try out our ipv4 only domain.</p>
<a href="https://v4.w0bm.com">v4.w0bm.com</a>
</div>
@include('footer')
@endsection


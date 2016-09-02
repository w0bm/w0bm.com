@extends('profilelayout')
@section('content')
<div class="page-header">
        <h1>How to WebM</h1>
</div>
<h4>Useful tools for creating WebMs</h4>
<p>There is a good documentation with various ffmpeg tools on github, you should definetly check it out and pick the one you like the most!</p>
<ul>
   <li><a href="https://github.com/Kagami/webm.py/wiki/Related-links">List of tools and information</a></li>
</ul>
<h4>Some information about ffmpeg</h4>
<p>If you want to learn more about FFmpeg check out <a href="https://de.wikipedia.org/wiki/FFmpeg">FFmpeg Wiki</a> and <a href="https://ffmpeg.org/">ffmpeg.org</a></p>
<p>ffmpeg is able to convert your .mkv and/or .mp4 files in to .webm for example and it is really easy, you just need to type in one line of commands</p>
<h5>vp8 sample line</h5>
<code style="font-family: monospace;">ffmpeg -i yourfile.mp4 -c:v libvpx -vf scale 1280:-1 -b:v 800K yourfresh.webm</code>
<h5>vp9 sample line</h5>
<code style="font-family: monospace;">ffmpeg -i scatporn.mp4 -c:v libvpx-vp9 kittens.webm</code>
<h5>If your uploads fails and you see this: Erroneous File Encoding! Try reencoding it</h5>
<code>ffmpeg -i problem.webm -map 0:0 -map 0:1 -c:v copy solved.webm</code>
<br>
<h5>How to do it in Wandaws?????</h5>
<p>WHAT THE FUCK ARE THESE FUCKING COMMANDS YOU FUCKING NIGGER? DO I LOOK LIKE A FUCKING NERD?</p>
<p>In case you are one of those faggots who don't know anything about command line tools and how to use ffmpeg we also have something for you.</p>
<p>Please use <a href="https://gitgud.io/nixx/WebMConverter">WebMConverter</a> by nixx, it has all the things you need and don't forget to click the vp9 button, vp9 is awesome!</p>
@endsection

@extends('layout')
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
<code style="font-family: monospace;">ffmpeg -i yourfile.mp4 -c:v libvpx -b:v 1000K yourwebmfile.webm</code>
<h5>vp9 sample line generated with webm.py tool</h5>
<code style="font-family: monospace;">ffmpeg -hide_banner -i INPUTDATEI.mp4 -pass 2 -passlogfile /tmp/tmpr3a1apey -sn -c:v libvpx-vp9 -speed 1 -tile-columns 6 -frame-parallel 0 -b:v 808.3k -threads 4 -auto-alt-ref 1 -lag-in-frames 25 -pix_fmt +yuv420p -ac 2 -c:a libopus -b:a 64k -f webm -y OUTPUTDATEI.webm</code>
<br>
<h5>How to do it in Wandaws?????</h5>
<p>WHAT THE FUCK ARE THESE FUCKING COMMANDS YOU FUCKING NIGGER? DO I LOOK LIKE A FUCKING NERD?</p>
<p>In case you are one of those faggots who don't know anything about command line tools and how to use ffmpeg we also have something for you.</p>
<p>Please use <a href="https://gitgud.io/nixx/WebMConverter">WebMConverter</a> by nixx, it has all the things you need and don't forget to click the vp9 button, vp9 is awesome!</p>
@endsection

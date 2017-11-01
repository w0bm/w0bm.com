@extends('profilelayout')
@section('content')
<h3>WebM</h3>
<p>On this page you will find anything related to WebMs</p>
<h4>Useful tools for creating WebMs</h4>
<p>There is a good documentation with various ffmpeg tools on github, you should definetly check it out and pick the one you like the most!</p>
<ul>
   <li><a href="https://github.com/Kagami/webm.py/wiki/Related-links">List of tools and information</a></li>
   <li><a href="https://github.com/Kagami/boram">Boram by Kagami</a> Cross Platform Gui application for cutting, cropping and converting videos into WebM format, has integrated youtube-dl option, so you can directly download from any site that is supported by youtube-dl. Definetly the best choice if you want to have it quick and easy with a nice looking result!</li>
   <li><a href="https://github.com/Kagami/webm.py">webm.py by Kagami</a> If you are more the CLI fan like me, this is something for you, it's a very easy cli tool and basically the best fucking tool if you want to create a WebM real quick by only using your shell.</li>
</ul>
   <p>Sample lines for webm.py <code>python webm.py -i your.mp4 your.webm</code> will convert your mp4 into a vp9 webm with max filesize of 8MB! <code>python webm.py -l 4 -vp8 -i your.mp4|webm yourwebmfor4chan.webm</code> will set the maximum filesize to 4MB and convert it using the VP8 codec and vorbis audio codec.</p>
<h4>coub.com Download</h4>
<p>Requirements: youtube-dl, BASH, ffmpeg</p>
<p>Get this <a href="https://p.sicp.me/fVtn6.sh">script</a> and save it as whatever.sh and type into your shell <code>bash whatever.sh</code> and enjoy your downloaded coub video, after downloading you will see a file with a name like this in the folder you ran the script in 347224d4-169e-484f-b27e-d2781a0381d3.mp4. You can now cut, crop and/or convert it to webm and enjoy the great loop you just downloaded! Credits for this script go to <a href="https://github.com/rg3/youtube-dl/issues/13754#issuecomment-336673153">Kagami</a></p>
<h4>Some information about ffmpeg</h4>
<p>If you want to learn more about FFmpeg check out <a href="https://de.wikipedia.org/wiki/FFmpeg">FFmpeg Wiki</a> and <a href="https://ffmpeg.org/">ffmpeg.org</a></p>
<p>ffmpeg is able to convert your .mkv and/or .mp4 files in to .webm for example and it is really easy, you just need to type in one line of commands</p>
<h5>If your uploads fails and you see this: Erroneous File Encoding! Try reencoding it</h5>
<code><s>ffmpeg -i problem.webm -map 0:0 -map 0:1 -c:v copy solved.webm</s> <b>(PATCHED)</b></code>
<br>
<h5>How to do it in Wandaws?????</h5>
<p>WHAT THE FUCK ARE THESE FUCKING COMMANDS YOU FUCKING NIGGER? DO I LOOK LIKE A FUCKING NERD?</p>
<p>In case you are one of those faggots who don't know anything about command line tools and how to use ffmpeg we also have something for you.</p>
<p>Please use <a href="https://gitgud.io/nixx/WebMConverter">WebMConverter</a> by nixx, it has all the things you need and don't forget to click the vp9 button, vp9 is awesome!</p>
@endsection

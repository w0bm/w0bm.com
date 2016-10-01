<h3>A moderator deleted your video.</h3>
<p>A moderator deleted your video with the ID {{$video->id}}</p>
<span style="font-weight:bold;">Video Info:</span>
<ul>
    @if(isset($videoinfo['artist'])) <li><span style="font-weight:bold;">Artist:</span> {{ $videoinfo['artist'] }}</li> @endif
    @if(isset($videoinfo['songtitle'])) <li><span style="font-weight:bold;">Songtitle:</span> {{ $videoinfo['songtitle'] }}</li> @endif
    @if(isset($videoinfo['video_source'])) <li><span style="font-weight:bold;">Video Source:</span> {{ $videoinfo['video_source'] }}</li> @endif
    <li><span style="font-weight:bold;">Category:</span> {{ $videoinfo['category'] }}</li>
</ul>
<p><span style="font-weight:bold;">Reason:</span> {{$reason}}</p>
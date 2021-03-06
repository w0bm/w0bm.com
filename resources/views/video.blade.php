@extends('layout')
@section('content')
<?php $related = $related ?? null; ?>
    <div class="vertical-align">
        <div class="wrapper">
            <div class="embed-responsive embed-responsive-16by9">
                <video id="video" loop controls preload="auto" crossorigin="anonymous">
			<source src="@if(env('APP_DEBUG')){{"/b"}}@else{{"//" . (substr($_SERVER["HTTP_HOST"], 0, 3) === "v4." ? "v4." : "") . "b.w0bm.com"}}@endif{{ "/" . $video->file }}">
			<source src="//fapple.w0bm.com/{{str_replace(".webm","",$video->file)}}.mp4">
		</video>
		    	@if($video->category->name === 'Anime' || $video->category->name === 'Otomad')
		    	<div class="anime-thumb-opener hidden-xs"><i title="Generate Anime Thumbnail!" class="fa fa-file-image-o"></i></div>
				<div style="display: none;" class="anime-thumb">
				<span>Anime Thumbnail Generator v1.0 Alpha</span><br>
				<img id="thumbnail_img" alt="Pause video to create thumb!"/><br>
				<span>Right click <code>Copy Image</code> and paste it on <a href="https://whatanime.ga">whatanime.ga</a></span>
				<canvas height="540" width="960" style="display: none;" id="thecanvas"></canvas>
				<script src="/js/animethumbnailer.js"></script>
			</div>
		@endif
	    </div>
            	<?php
			//$shortfile = str_replace(".webm", "" ,$video->file);
			//$mp4 = shell_exec("curl https://fapple.w0bm.com/api/v1/{{$shortfile}} | jq -r .size");
		?>
			<div class="text-center" style="position: unset;">
				@if($related)
					@if(($prev = $video->getPrev($related)) === null)
						<a class="first" href="#" style="visibility: hidden;">← first</a>
						<a id="prev" href="#" style="visibility: hidden;">← prev</a> |
					@else
						<a class="first" href="{{url($related->baseurl(), $video->getFirstId($related))}}">← first</a>
						<a id="prev" href="{{url($related->baseurl(), [$prev->id])}}">← prev</a> |
					@endif
					<a href="{{url($related->baseurl())}}">{!!$related->displayName()!!}</a>
					@if(($next = $video->getNext($related)) === null)
						| <a id="next" href="#" style="visibility: hidden;">next →</a>
						<a class="last" href="#" style="visibility: hidden;">last →</a>
					@else
						| <a id="next" href="{{url($related->baseurl(), [$next->id])}}">next →</a>
						<a class="last" href="{{url($related->baseurl(), $video->getLastId($related))}}">last →</a>
					@endif
				@else
					@if(($prev = $video->getPrev()) === null)
						<a class="first" href="#" style="visibility: hidden;">← first</a>
						<a id="prev" href="#" style="visibility: hidden;">← prev</a> |
					@else
						<a class="first" href="{{url($video->getFirstId())}}">← first</a>
						<a id="prev" href="{{url($prev->id)}}">← prev</a> |
					@endif
					<a href="{{url('/')}}">random</a>
					@if(($next = $video->getNext()) === null)
						| <a id="next" href="#" style="visibility: hidden;">next →</a>
						<a class="last" href="#" style="visibility: hidden;">last →</a>
					@else
						| <a id="next" href="{{url($next->id)}}">next →</a>
						<a class="last" href="{{url($video->getLastId())}}">last →</a>
					@endif
				@endif
			</div>
			<div class="vidinfo">
				<span class="videoinfo">
						<button title="Toggle comments" class="hidden-xs toggle-comments" id="toggle"><i class="fa fa-comments"></i></button>	
						<button title="Toggle Background" class="hidden-xs bg-toggle" id="togglebg"><i style="color:#fff200;" class="fa fa-adjust"></i></button>
						<button class="copylink" data-clipboard-text="{{url($video->id)}}" title="Copy URL!"><i class="fa fa-link"></i></button>
						<div class="dropdown">
							<button class="fa fa-download"
								id="dlbutton"
                                style="cursor: pointer"
                                data-toggle="popover"
                                data-placement="top"
								data-trigger="hover"
								data-html="true"
                                title="Download Video"
								data-content="
									<div class='downloadvid'>
									<ul class='downloadlist'>
									<li><a class='file_size' href='@if(env('APP_DEBUG')){{'/b'}}@else{{'//' . (substr($_SERVER['HTTP_HOST'], 0, 3) === 'v4.' ? 'v4.' : '') . 'b.w0bm.com'}}@endif{{ '/' . $video->file }}' download>WebM</a> <span class='filesize'>({{ 		HumanReadable::bytesToHuman($video->filesize()) }})</span></li>
									<li><a class='file_size' href='//fapple.w0bm.com/{{str_replace('.webm','',$video->file)}}.mp4' download>MP4</a></a>
									</ul>
									</div>"
							</button>
						</div>

						<div class="favbutton">
						@if(auth()->check())
							@if(auth()->user()->hasFaved($video->id))
								<a id="fav" href="{{url($video->id . '/fav')}}"><i style="color:#ff0094;" class="fa fa-heart"></i></a>
							@else
								<a id="fav" href="{{url($video->id . '/fav')}}"><i style="color:#ff0094;" class="fa fa-heart-o"></i></a>
							@endif
						@else
							<a href="{{url($video->id . '/fav')}}"><i class="fa fa-heart-o"></i></a>
						@endif
						</div>
						<button class="fa fa-info-circle"
							id="infobox"
							style="cursor: pointer"
							data-toggle="popover"
							data-placement="top"
							data-trigger="hover"
							title="Information"
							data-content="	<div style='word-break: break-word;'>@if($video->interpret) <strong>Artist:</strong> {{$video->interpret}}<br>@endif
											@if($video->songtitle) <strong>Songtitle:</strong> {{$video->songtitle}}<br>@endif
											@if($video->imgsource) <strong>Video Source:</strong> {{$video->imgsource}}<br>
											@endif
											<strong>Category:</strong> {{$video->category->name}}</div>">
						</button>
						<span id="uploader">uploaded by <a style="color: white" href="{{ url('user/' . $video->user->username) }}">{!! $video->user->displayName() !!}</a></span> <time class="timeago" data-toggle="tooltip" data-placement="top" datetime="{{$video->created_at->toIso8601String()}}" title="{{$video->created_at->toIso8601String()}}"></time>@if(auth()->check() && (auth()->user()->can('edit_video') || auth()->user()->id == $video->user_id)) <a class="edit_video" href="#" data-toggle="modal" data-target="#webmeditmodal">[edit]</a>@endif @if(auth()->check() && auth()->user()->can('delete_video'))<a class="delete_video" href="#">[del]</a>@endif 
				</span>
			</div>
		</div>
	</div>
@endsection

@section('aside')
    <aside id="sidebar" class="aside panel hidden-xs">
    	@include('partials.flash')
    	@include('partials.comments')
		@include('partials.tags')
	</aside>
@endsection

@extends('layout')
@section('content')
<?php $related = $related ?? null; ?>
    <div class="vertical-align">
        <div class="wrapper">
            <div class="embed-responsive embed-responsive-16by9">
                <video id="video" loop controls preload="auto">
			<source src="@if(env('APP_DEBUG')){{"/b"}}@else{{"//" . (substr($_SERVER["HTTP_HOST"], 0, 3) === "v4." ? "v4." : "") . "b.w0bm.com"}}@endif{{ "/" . $video->file }}">
			<source src="//fapple.w0bm.com/{{str_replace(".webm","",$video->file)}}.mp4">
		</video>

            </div>
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
				<br>
				<span class="videoinfo">
						<a href="#" class="hidden-xs" id="toggle"><i class="fa fa-comments"></i></a>	
						<a href="#" class="hidden-xs" id="togglebg"><i style="color:#fff200;" class="fa fa-lightbulb-o"></i></a>

						<div class="dropdown">
							<!--<a id="dlbutton" class="fa fa-download"></a>
							<div class="dropdown-content">
							<a href="@if(env('APP_DEBUG')){{"/b"}}@else{{"//" . (substr($_SERVER["HTTP_HOST"], 0, 3) === "v4." ? "v4." : "") . "b.w0bm.com"}}@endif{{ "/" . $video->file }}" download>Download WebM</a>
							</div>-->
						<span   class="fa fa-download"
                                                        style="cursor: pointer"
                                                        data-toggle="popover"
                                                        data-placement="top"
							data-trigger="hover"
							data-html="true"
                                                        title="Download Video"
							data-content="
							<div class='downloadvid'>
							<ul class='downloadlist'>
							<li><a href='@if(env('APP_DEBUG')){{'/b'}}@else{{'//' . (substr($_SERVER['HTTP_HOST'], 0, 3) === 'v4.' ? 'v4.' : '') . 'b.w0bm.com'}}@endif{{ '/' . $video->file }}' download>WebM</a> <span class='filesize'>({{ HumanReadable::bytesToHuman($filesize) }})</span></li>
							<li><a href='//fapple.w0bm.com/{{str_replace('.webm','',$video->file)}}.mp4' download>MP4</a> <span class='filesize'>({{ HumanReadable::bytesToHuman($filesize) }})</span></li>
							</ul>
							</div>							
							"
						</span>
						</div>

						@if(auth()->check())
							@if(auth()->user()->hasFaved($video->id))
								<a id="fav" href="{{url($video->id . '/fav')}}"><i style="color:#ff0094;" class="fa fa-heart"></i></a>
							@else
								<a id="fav" href="{{url($video->id . '/fav')}}"><i style="color:#ff0094;" class="fa fa-heart-o"></i></a>
							@endif
						@else
							<a href="{{url($video->id . '/fav')}}"><i class="fa fa-heart-o"></i></a>
						@endif
						<span 	class="fa fa-info-circle"
							style="cursor: pointer"
							data-toggle="popover"
							data-placement="top"
							data-trigger="hover"
							title="Information"
							data-content="	<div style='word-break: break-all;'>@if($video->interpret) <strong>Artist:</strong> {{$video->interpret}}<br>@endif
											@if($video->songtitle) <strong>Songtitle:</strong> {{$video->songtitle}}<br>@endif
											@if($video->imgsource) <strong>Video Source:</strong> {{$video->imgsource}}<br>
											@endif
											<strong>Category:</strong> {{$video->category->name}}</div>"></span>
						uploaded by <span style="color: rgb(233, 233, 233);"><a href="{{ url('user/' . $video->user->username) }}">{!! $video->user->displayName() !!}</a></span> <time class="timeago" data-toggle="tooltip" data-placement="bottom" datetime="{{$video->created_at->toIso8601String()}}" title="{{$video->created_at->toIso8601String()}}"></time>@if(auth()->check() && auth()->user()->can('delete_video')) <a id="delete_video" href="#"><i style="color:red;" class="fa fa-times" aria-hidden="true"></i></a>@endif @if(auth()->check() && (auth()->user()->can('edit_video') || auth()->user()->id == $video->user_id))<a href="#" data-toggle="modal" data-target="#webmeditmodal"><i style="color:#2ada19;" class="fa fa-pencil-square"></i></a>@endif
				</span>
			</div>
		</div>
	</div>
@endsection

@section('aside')
    <aside id="sidebar" class="aside panel hidden-xs">
    	@include('partials.comments')
		@include('partials.tags')
	</aside>
@endsection

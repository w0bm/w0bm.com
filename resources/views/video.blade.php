@extends('layout')
@section('content')
    <?php $category = isset($category) ? $category : false ?>
    <div class="vertical-align">
        <div class="wrapper">
            <div class="embed-responsive embed-responsive-16by9">
                <video id="video" loop autoplay controls preload="auto" src="/b/{{ $video->file }}"></video>
            </div>
			<div class="text-center" style="position: unset;">
				@if($category)
					@if(($prev = $video->getPrev(true)) === null)
						<a class="first" href="#" style="visibility: hidden;">← first</a>
						<a id="prev" href="#" style="visibility: hidden;">← prev</a> |
					@else
						<a class="first" href="{{url($video->category->shortname, $video->getFirstId(true))}}">← first</a>
						<a id="prev" href="{{url($video->category->shortname, [$prev->id])}}">← prev</a> |
					@endif
					<a href="{{url($video->category->shortname)}}">{{$video->category->name}}</a>
					@if(($next = $video->getNext(true)) === null)
						| <a id="next" href="#" style="visibility: hidden;">next →</a>
						<a class="last" href="#" style="visibility: hidden;">last →</a>
					@else
						| <a id="next" href="{{url($video->category->shortname, [$next->id])}}">next →</a>
						<a class="last" href="{{url($video->category->shortname, $video->getLastId(true))}}">last →</a>
					@endif
				@else
					@if(($prev = $video->getPrev()) === null)
						<a class="first" href="#" style="visibility: hidden;">← first</a>
						<a id="prev" href="#" style="visibility: hidden;">← prev</a> |
					@else
						<a class="first" href="{{url($video->getFirstId(false))}}">← first</a>
						<a id="prev" href="{{url($prev->id)}}">← prev</a> |
					@endif
					<a href="{{url('/')}}">random</a>
					@if(($next = $video->getNext()) === null)
						| <a id="next" href="#" style="visibility: hidden;">next →</a>
						<a class="last" href="#" style="visibility: hidden;">last →</a>
					@else
						| <a id="next" href="{{url($next->id)}}">next →</a>
						<a class="last" href="{{url($video->getLastId(false))}}">last →</a>
					@endif
				@endif
				<br>
				<span class="videoinfo">
						<a href="#togglecomments" id="toggle"><i class="fa fa-comments"></i></a>	
						<a href="#togglebg" id="togglebg"><i style="color:#fff200;" class="fa fa-lightbulb-o"></i></a>
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
							data-content="	@if($video->interpret) <strong>Artist:</strong> {{$video->interpret}}<br>@endif
											@if($video->songtitle) <strong>Songtitle:</strong> {{$video->songtitle}}<br>@endif
											@if($video->imgsource) <strong>Video Source:</strong> {{$video->imgsource}}<br>
											@endif
											<strong>Category:</strong> {{$video->category->name}}"></span>
						uploaded by <span style="color: rgb(233, 233, 233);"><a href="{{ url('user/' . $video->user->username) }}">{{ $video->user->username }} @if($video->user->is('Moderator'))<span class="fa fa-bolt anim"></span>@elseif($video->user->is('Editor'))<span class="fa fa-shield anim"></span>@elseif($video->user->is('flinny'))<img class="flinnysmall" src="{{ asset('wizard.png') }}"></img>@elseif($video->user->is('brown'))<img class="rainsmall" src="{{ asset('watermelon.png') }}"></img>@elseif($video->user->is('dank')) <img class="danksmall" src="{{ asset('weed.png') }}"></img>@elseif($video->user->is('gay'))<img class="gaysmall" src="{{ asset('gaypride.svg') }}"></img>@elseif($video->user->is('duke'))<img class="dukesmall" src="{{ asset('duke.png') }}"></img>@elseif($video->user->is('alugay'))<img class="americagaysmall" src="{{ asset('RainbowAmerica.svg') }}"></img>@elseif($video->user->is('reis')) <img class="onigiri" src="{{ asset('onigiri.gif') }}"></img>@elseif($video->user->is('bio')) <img class="biosmall" src="{{ asset('bio.png') }}"></img>@elseif($video->user->is('patoy')) <img class="patoyklein" src={{asset('patoy.png')}}></img>@endif</a></span> <time class="timeago" data-toggle="tooltip" data-placement="bottom" datetime="{{$video->created_at}}+0000" title="{{$video->created_at}}+0000"></time>@if(auth()->check() && auth()->user()->can('delete_video')) <a data-confirm="Do you really want to delete this video?" class="" href="{{url($video->id . '/delete')}}"><i style="color:red;" class="fa fa-times" aria-hidden="true"></i></a>@endif @if(auth()->check() && (auth()->user()->can('edit_video') || auth()->user()->id == $video->user_id))<a href="#" data-toggle="modal" data-target="#webmeditmodal"><i style="color:#2ada19;" class="fa fa-pencil-square"></i></a>@endif
				</span>
			</div>
		</div>
	</div>
@endsection

@section('aside')
    <div style="float: left" class="aside">
    @include('partials.comments')
	@include('partials.tags')
    </div>
@endsection

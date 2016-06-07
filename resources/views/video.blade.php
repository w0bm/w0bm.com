@extends('layout')
@section('content')
    <?php $category = isset($category) ? $category : false ?>
    <div class="vertical-align">
        <div class="wrapper">
            <div class="embed-responsive embed-responsive-16by9">
                <video id="video" controls loop autoplay src="/b/{{ $video->file }}"></video>
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
					<div id=".comments"></div>
						<a href="#" id="toggle"><i class="fa fa-comments"></i></a>	
						<a href="{{url('togglebackground')}}" id="togglebg"><i style="color:#fff200;" class="fa fa-lightbulb-o"></i></a>
						@if(auth()->check())
							@if(auth()->user()->hasFaved($video->id))
								<a id="fav" href="{{url($video->id . '/fav')}}"><i style="color:#ff0094;" class="fa fa-heart"></i></a>
							@else
								<a id="fav" href="{{url($video->id . '/fav')}}"><i style="color:#ff0094;" class="fa fa-heart-o"></i></a>
							@endif
						@else
							<a href="{{url($video->id . '/fav')}}"><i class="fa fa-heart-o"></i></a>
						@endif
						<i 	class="fa fa-info-circle"
							style="cursor: pointer"
							data-toggle="popover"
							data-placement="top"
							data-trigger="hover"
							title="Information"
							data-content="	@if($video->interpret) <em>Interpret:</em> {{$video->interpret}}<br>@endif
											@if($video->songtitle) <em>Songtitle:</em> {{$video->songtitle}}<br>@endif
											@if($video->imgsource) <em>Video Source:</em> {{$video->imgsource}}<br>
											@endif
											<em>Category:</em> {{$video->category->name}}"></i>
						uploaded by <i style="color: rgb(233, 233, 233);"><a href="{{ url('user/' . $video->user->username) }}">{{ $video->user->username }}@if($video->user->is('Moderator')) <i class="fa fa-bolt anim"></i>@endif</a></i>&nbsp {{ $video->created_at->diffForHumans() }}@if(auth()->check() && auth()->user()->can('delete_video')) <a data-confirm="Do you really want to delete this video?" class="" href="{{url($video->id . '/delete')}}"><i style="color:red;" class="fa fa-times" aria-hidden="true"></i></a>@endif @if(auth()->check() && auth()->user()->can('edit_video'))<a href="#" data-toggle="modal" data-target="#webmeditmodal"><i style="color:#2ada19;" class="fa fa-pencil-square"></i></a>@endif
					</div>
				</span>
			</div>
		</div>
	</div>
@endsection

@section('aside')
    @include('partials.comments')
@endsection

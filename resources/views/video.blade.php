@extends('layout')
@section('content')
    <?php $category = isset($category) ? $category : false ?>
    <div class="vertical-align">
        <div class="wrapper">
            <div class="embed-responsive embed-responsive-16by9">
                <video id="video" controls loop src="{{asset('b/' . $video->file)}}"></video>
            </div>
            @if($category)
                <div class="text-center">
                    @if(($prev = $video->getPrev(true)) === null)
                        <a id="prev" href="#" style="visibility: hidden;">Prev</a> |
                    @else
                        <a id="prev" href="{{url($video->category->shortname, [$prev->id])}}">Prev</a> |
                    @endif
                    <a href="{{url($video->category->shortname)}}">{{$video->category->name}}</a>
                    @if(($next = $video->getNext(true)) === null)
                        | <a id="next" href="#" style="visibility: hidden;">Next</a>
                    @else
                        | <a id="next" href="{{url($video->category->shortname, [$next->id])}}">Next</a>
                    @endif
                </div>
            @else
                <div class="text-center">
                    @if(($prev = $video->getPrev()) === null)
                        <a class="first" href="#" style="visibility: hidden;">← first</a>
                        <a id="prev" href="#" style="visibility: hidden;">← prev</a> |
                    @else
                        <a class="first" href="{{url($video->first()->id)}}">← first</a>
                        <a id="prev" href="{{url($prev->id)}}">← prev</a> |
                    @endif
                    <a href="{{url('/')}}">random</a>
                    @if(($next = $video->getNext()) === null)
                        | <a id="next" href="#" style="visibility: hidden;">next →</a>
                        <a class="last" href="#" style="visibility: hidden;">last →</a>
                    @else
                        | <a id="next" href="{{url($next->id)}}">next →</a>
                        <a class="last" href="{{url($video->max('id'))}}">last →</a>
                    @endif
                    <br><span class="videoinfo">uploaded by <i style="color: rgb(233, 233, 233);"><a href="{{ url('user/' . $video->user->username) }}">{{ $video->user->username }}</a> </i>&nbsp {{ $video->created_at->diffForHumans() }}@if(auth()->check() && auth()->user()->can('delete_video')) <a data-confirm="Do you really want to delete this video?" class="btn btn-danger" href="{{url($video->id . '/delete')}}">Delete</a>@endif</span>

                </div>
            @endif
        </div>
    </div>
@endsection

@section('aside')
    @include('partials.comments')
@endsection

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
                        <a id="prev" href="#" style="visibility: hidden;">Prev</a> |
                    @else
                        <a id="prev" href="{{url($prev->id)}}">Prev</a> |
                    @endif
                    <a href="{{url('/')}}">Random</a>
                    @if(($next = $video->getNext()) === null)
                        | <a id="next" href="#" style="visibility: hidden;">Next</a>
                    @else
                        | <a id="next" href="{{url($next->id)}}">Next</a>
                    @endif
                </div>
            @endif
        </div>
    </div>
@endsection

@section('aside')
    @include('partials.comments')
@endsection
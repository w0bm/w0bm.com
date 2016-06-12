<aside class="tags hidden-xs">
    @if(Auth::check())
        <form class="form-inline" method="POST" action="/{{$video->id}}/tag" id="tagform">
            {!! csrf_field() !!}
            <div class="input-group">
                <select multiple name="tags[]" data-role="tagsinput" class="form-control"></select>
                {{--<input type="text" class="form-control" placeholder="Input tags…" name="tags" data-role="tagsinput">--}}
                <span class="input-group-btn">
                    <input type="submit" class="form-control">
                </span>
            </div>
        </form>
    @endif
    <div class="panel panel-default">
        <div class="panel-body">
            @foreach($video->tags as $tag)
                <a href="/songindex?q={{$tag->normalized}}"><span class="label label-default">{{$tag->name}}</span></a>
            @endforeach
        </div>
    </div>
</aside>
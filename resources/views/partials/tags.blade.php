<aside class="tags hidden-xs">
    @if(Auth::check())
        <div class="input-group" style="margin-top: 2px;">
            {{--<select multiple name="tags[]" data-role="tagsinput" class="form-control"></select>--}}
            <input id="tags" type="text" class="form-control" placeholder="Input tags…" name="tags" data-role="tagsinput">
            <span class="input-group-btn">
                <button href="/{{$video->id}}/tag" id="submittags" type="submit" class="form-control btn-primary">Submit</button>
            </span>
        </div>
    @endif
    <div class="panel panel-default" style="margin-top: 5px;">
        <div id="tag-display" class="panel-body">
            @if(count($video->tags))
                @foreach($video->tags as $tag)
                    <a href="/songindex?q={{$tag->normalized}}"><span class="label label-default">{{$tag->name}}</span></a>
                @endforeach
            @else
                No tags yet ...
            @endif
        </div>
    </div>
</aside>
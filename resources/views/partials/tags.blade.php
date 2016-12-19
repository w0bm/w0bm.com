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
    <div class="toggo tag-panel-body" style="">
        <div id="tag-display" class="tag-panel-body">
            @if(count($video->tags))
                @foreach($video->tags as $tag)
                    <span class="label label-default"><a href="/index?q={{$tag->normalized}}" class="default-link">{{$tag->name}}</a>@if(Auth::check() && Auth::user()->can('edit_video')) <a class="delete-tag default-link" href="#"><i class="fa fa-times"></i></a>@endif</span>
                @endforeach
            @else
                No tags yet ...
            @endif
        </div>
    </div>
</aside>

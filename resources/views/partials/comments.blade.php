
<div id="motd" class="panel panel-info hidden-xs">
    @if(null === $banner)
        <div class="panel-body motd">
            <span>If you want to advertise something, check <a href="/advertise">Advertise</a>. It is 100% free and just for the lulz</span>
        </div>
    @else
        <a href="{{ $banner->url }}" target="_blank" rel="noopener">
            <div style="height: 50px; background-image:url('{{ $banner->image }}')" class="panel-body motd">
            </div>
        </a>
    @endif
</div>


@if(Auth::check())
    @include('partials.commentform')
@endif

<div class="comments hidden-xs">
    <div class="commentwrapper">
        <?php
            if($mod = (Auth::check() && Auth::user()->can('delete_comment'))) $comments = $video->comments()->withTrashed()->get();
            else $comments = $video->comments;
        ?>
        @if(count($comments) > 0)
            @foreach($comments as $comment)
                @include('partials.comment', ['comment' => $comment, 'mod' => $mod])
            @endforeach
        @else
            <div class="panel panel-default nocomments">
                <div class="panel-body">
                    No comments yet …<br />
                </div>
            </div>
        @endif
    </div>
</div>

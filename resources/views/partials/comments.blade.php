<aside class="comments">
    @if(Auth::check())
        @include('partials.commentform')
    @endif
    <div class="commentwrapper">
        @if(count($comments  = $video->comments) > 0)
            @foreach($comments as $comment)
                @include('partials.comment', ['comment' => $comment])
            @endforeach
        @else
            <div class="panel panel-default nocomments">
                <div class="panel-body">
                    No comments yet.
                </div>
            </div>
        @endif
    </div>
</aside>
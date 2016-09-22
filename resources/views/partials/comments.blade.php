<aside class="comments hidden-xs">

	<div style="border: 3px solid #1fb2b0;margin-bottom:1px;" class="panel panel-info">
	    <div class="panel-body">
		<div style="text-align:center;">Tomorrow first birthday.</div>
	   </div>
	</div>


    @if(Auth::check())
        @include('partials.commentform')
    @endif
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
                    No comments yet...
                </div>
            </div>
        @endif
    </div>
</aside>

<aside class="comments hidden-xs">

	<div style="border-color:rgb(31, 178, 176);" class="panel panel-info">
	    <div style="text-align:center;" class="panel-body">
	     <u class="anim"><a class="anim" href="/980">WHAT IS THE NAME OF THIS SONG?</a></u>
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
                    No shitposts yet...
                </div>
            </div>
        @endif
    </div>
</aside>

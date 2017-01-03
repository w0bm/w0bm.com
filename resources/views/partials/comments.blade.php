
<div id="motd" class="panel panel-info hidden-xs">
    <div class="panel-body motd">
        <!-- <span>If you want to advertise something, just send me an <a href="mailto:admin@w0bm.com">email</a>. It is 100% free and just for the lulz</span> -->

	<span>
Join the new, fesche Website based around funny things.

Join 9GAG.com!
</span>	

    </div>
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

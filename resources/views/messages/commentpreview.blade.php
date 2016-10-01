<div class="panel panel-default">
    <div class="panel-body">
        @simplemd($comment->content)
    </div>
    <div class="panel-footer">by <a href="/user/{{$comment->user->username}}">{{$comment->user->username}} {!! $comment->user->activeIcon() !!}</a> <small><time class="timeago" data-toggle="tooltip" data-placement="right" datetime="{{$comment->created_at}}+0000" title="{{$comment->created_at}}+0000"></time></small></div>
</div>

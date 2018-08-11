<div class="panel @if($del = !is_null($comment->deleted_at)) panel-danger @else panel-default @endif" data-id="{{$comment->id}}">
    <div class="panel-body">
        @simplemd($comment->content)
    </div>
    <div class="panel-footer">by <a href="/user/{{$comment->user->username}}">{!! $comment->user->displayName() !!}</a> <small><time class="timeago" data-toggle="tooltip" data-placement="top" datetime="{{$comment->created_at}}+0000" title="{{$comment->created_at}}+0000"></time></small>
        @if($mod)
            @if($del)
                <a href="#" onclick="restoreComment($(this))"><i style="color:green"; class="fa fa-refresh" aria-hidden="true"></i></a>
            @else
                <a id="delete_comment" href="#" onclick="deleteComment($(this))">[del]</a>
                <a id="edit_comment" href="#" onclick="editComment($(this))">[edit]</a>
            @endif
        @endif
    </div>
</div>

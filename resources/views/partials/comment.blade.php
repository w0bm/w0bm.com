<div class="panel panel-default">
    <div class="panel-body">
        @simplemd($comment->content)
    </div>
    <div class="panel-footer">by <a href="/user/{{$comment->user->username}}">{{$comment->user->username}}</a> <small>{{$comment->created_at->diffForHumans()}}</small>
        @if(auth()->check())
            @if(auth()->user()->can('delete_comment'))
                <a data-confirm="Do you really want to delete that comment?" class="btn btn-danger" href="{{url('comment/' . $comment->id . '/delete')}}">Delete</a>
            @endif
        @endif
    </div>
</div>
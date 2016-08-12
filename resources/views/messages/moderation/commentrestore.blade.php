<h3><a href="{{url('user/' . $user->username)}}">{{$user->username}}</a> restored your comment.</h3>
<p><a href="{{url('user/' . $user->username)}}">{{$user->username}}</a> restored your comment on the following video: <a href="{{url($video->id)}}">/{{$video->id}}</a></p>
<p><span style="font-weight:bold;">Reason:</span> {{$reason}}</p>
<span style="font-weight:bold;">Comment:</span>
<div class="panel panel-default">
    <div class="panel-body">
        @simplemd($comment->content)
    </div>
    <div class="panel-footer">by <a href="/user/{{$comment->user->username}}">{{$comment->user->username}}</a> <small><time class="timeago" data-toggle="tooltip" data-placement="right" datetime="{{$comment->created_at}}+0000" title="{{$comment->created_at}} UTC">{{ $comment->created_at->diffForHumans()}}</time></small></div>
</div>
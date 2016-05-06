<div class="panel @if($del = !is_null($comment->deleted_at)) panel-danger @else panel-default @endif">
    <div class="panel-body">
       @simplemd($comment->content)
    </div>
    <div class="panel-footer">by <a href="/user/{{$comment->user->username}}">{{$comment->user->username}}</a> <small>{{$comment->created_at->diffForHumans()}}</small>
        @if($mod)
           @if($del)
                <a href="{{url('comment/' . $comment->id . '/restore')}}" class=""><i style="color:green"; class="fa fa-refresh" aria-hidden="true"></i></a>
            @else
                <a class="" href="{{url('comment/' . $comment->id . '/delete')}}"><i style="color:red"; class="fa fa-times" aria-hidden="true"></i></a>
                <!--<a class="" href="#" onclick="comment_edit($(this),{{$comment->id}})"><i style="color:cyan;" class="fa fa-pencil" aria-hidden="true"></i></a>-->
            @endif
        @endif
    </div>
</div>

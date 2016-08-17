<div class="panel @if($del = !is_null($comment->deleted_at)) panel-danger @else panel-default @endif" data-id="{{$comment->id}}">
    <div class="panel-body">
        @simplemd($comment->content)
    </div>
    <div class="panel-footer">by <a href="/user/{{$comment->user->username}}">{{$comment->user->username}} @if($comment->user->is('Moderator'))<span class="fa fa-bolt anim"></span>@elseif($comment->user->is('Editor'))<span class="fa fa-shield anim"></span>@elseif($comment->user->is('flinny'))<img class="flinnysmall" src="{{ asset('wizard.png') }}"></img>@elseif($comment->user->is('brown'))<img class="rainsmall" src="{{ asset('watermelon.png') }}"></img>@elseif($comment->user->is('dank')) <img class="danksmall" src="{{ asset('weed.png') }}"></img>@elseif($comment->user->is('gay'))<img class="gaysmall" src="{{ asset('gaypride.svg') }}"></img>@elseif($comment->user->is('duke'))<img class="dukesmall" src="{{ asset('duke.png') }}"></img>@elseif($comment->user->is('reis')) <img class="onigiri" src="{{ asset('onigiri.gif') }}"></img>@elseif($comment->user->is('bio')) <img class="biosmall" src="{{ asset('bio.png') }}"></img>@elseif($comment->user->is('patoy')) <img class="patoyklein" src={{asset('patoy.png')}}></img>@endif</a> <small><time class="timeago" data-toggle="tooltip" data-placement="right" datetime="{{$comment->created_at}}+0000" title="{{$comment->created_at}} UTC">{{ $comment->created_at->diffForHumans()}}</time></small>
        @if($mod)
            @if($del)
                <a href="#" onclick="restoreComment($(this))"><i style="color:green"; class="fa fa-refresh" aria-hidden="true"></i></a>
            @else
                <a href="#" onclick="deleteComment($(this))"><i style="color:red"; class="fa fa-times" aria-hidden="true"></i></a>
                <a href="#" onclick="editComment($(this))"><i style="color:cyan;" class="fa fa-pencil-square" aria-hidden="true"></i></a>
            @endif
        @endif
    </div>
</div>

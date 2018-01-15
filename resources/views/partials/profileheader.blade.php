<div class="page-header">
    <h3>{!! rtrim(e($user->username) . ' ' . $user->activeIcon()) !!}&nbsp;@if(auth()->check() && auth()->user()->can('edit_user'))<a href="#" data-toggle="modal" data-target="#banmenumodal"><i style="color:red;" class="fa fa-gavel"></i></a>@endif @if($user->disabled && isset($user->banend) && (Carbon\Carbon::now() <= $user->banend || 1 >= $user->banend->timestamp))<span style="color: grey; font-size: 15px;">(@if(Carbon\Carbon::now() <= $user->banend)Ban expires in <time class="timeago" data-toggle="tooltip" title="{{ $user->banend }}+0000" datetime="{{ $user->banend }}+0000"></time>@else permanently banned @endif)</span>@endif</h3>

    <span id="jointime">Joined: <time class="timeago" datetime="{{ $user->created_at }}+0000" title="{{ $user->created_at }}+0000" data-toggle="tooltip"></time></span>
<div class="profile-info">
    <span id="count-upload"> <a href="/user/{{$user->username}}"> <i class="fa fa-cloud-upload"></i> {{ $user->uploads()->countScoped()->count() }} Uploads</a></span>

    <span id="comments-user"> <a href="/user/{{$user->username}}/comments"><i class="fa fa-commenting"></i> {{ $user->comments()->count() }} Comments</a></span>

    <span id="favs-user"><a href="/user/{{$user->username}}/favs/index"><i class="fa fa-heart"></i> {{ $user->favs()->countScoped()->count() }} Favorites</a></span>
</div>
</div>

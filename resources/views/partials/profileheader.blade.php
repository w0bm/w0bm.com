<div class="page-header">
    <h3>{{$user->username}}@if($user->is('Moderator')) <span style="color: #1FB2B0;"><i class="fa fa-bolt anim"></i></span>@elseif($user->is('Editor'))  <span class="" style="color: #1FB2B0;"><i class="fa fa-shield anim"></i></span>@elseif($user->is('flinny')) <img class="flinny" src="{{ asset('wizard.png') }}"></img>@elseif($user->is('brown')) <img class="rain" src="{{ asset('watermelon.png') }}"></img>@elseif($user->is('dank')) <img class="dank" src="{{ asset('weed.png') }}"></img>@elseif($user->is('gay')) <img class="gay" src="{{ asset('gaypride.svg') }}"></img>@elseif($user->is('duke')) <img class="duke" src="{{ asset ('duke.png') }}"></img>@elseif($user->is('alugay'))<img class="americagay" src="{{ asset('RainbowAmerica.svg') }}"></img>@elseif($user->is('reis')) <img class="onigiri" src="{{ asset('onigiri.gif') }}"></img>@elseif($user->is('bio')) <img class="bio" src="{{ asset('bio.png') }}"></img>@elseif($user->is('patoy')) <img class="patoy" src={{asset('patoy.png')}}></img>@endif @if(auth()->check() && auth()->user()->can('edit_user'))<a href="#" data-toggle="modal" data-target="#banmenumodal"><i style="color:red;" class="fa fa-lock"></i></a>@endif @if($user->disabled && isset($user->banend))<span style="color: grey; font-size: 15px;">(@if(Carbon\Carbon::now() <= $user->banend)Ban expires in <time class="timeago" data-toggle="tooltip" title="{{ $user->banend }}+0000" datetime="{{ $user->banend }}+0000"></time>@elseif($user->banend <= 0)permanently banned @endif)</span>@endif<h3>
    <h6><span class="pull-right">Joined: <time class="timeago" datetime="{{ $user->created_at }}+0000" title="{{ $user->created_at }}+0000" data-toggle="tooltip"></time></span></h6>
    <h5><a style="color:#1FB2B0;" href="/user/{{$user->username}}"><i class="fa fa-cloud-upload"></i> {{ $user->videos()->count() }} Uploads</a> <span> <a style="color:white;" href="/user/{{$user->username}}/comments"><i class="fa fa-commenting"></i> {{ $user->comments()->count() }} Comments</span> <span><a style="color:#CE107C;" href="/user/{{$user->username}}/favs"><i class="fa fa-heart"></i> {{ $user->favs()->count() }} Favorites</a></span></h5>
</div>

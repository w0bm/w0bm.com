@extends('profilelayout')
@section('content')
<div class="page-header">
        <h3>Stats</h3>
</div>
<div class="box">
	<p class="user_count">Total amount of registered users: <amount>{{$user_count}}</amount></p>
	<p class="upload_count">Total amount of uploads: <amount>{{$upload_count}}</amount></p>
	<p class="comment_count">Total amount of comments: <amount>{{$comment_count}}</amount></p>
	<p class="latest-video">Latest video <a href="/{{$latest_video}}">/{{$latest_video}}</a></p>
	<p class="newest_user">Newest user <a href="/user/{{$newest_user}}">/user/{{$newest_user}}</a></p>


</div>
@include('footer')
@endsection

<div id="commentForm" class="hidden-xs">
<form action="{{action('CommentController@store', ['id' => $video->id])}}" method="post">
    {!! csrf_field() !!}
    <div class="panel panel-default">
        <div class="panel-body">
            {!! Form::textarea('comment', null, ['placeholder' => 'Write something', 'id' => 'cinput', 'class' => 'form-control', 'required' => 'required']) !!}
        </div>
    <div class="panel-footer"><button type="submit" class="btn btn-primary btn-sm">Post</button>
	<a style="font-size: 14px;" class="rainbow" href="javascript:;" onclick="formatText ('rb');">[rb]</a>
	<a style="font-size: 14px;" class="reich" href="javascript:;" onclick="formatText ('reich');">[reich]</a>
	<a style="font-size: 14px;" class="anim" href="javascript:;" onclick="formatText ('krebs');">[krebs]</a>
	<a style="font-size: 14px; color: white;" class="spoiler" href="javascript:;" onclick="formatText ('spoiler');">[spoiler]</a>
        <div tabindex="0" class="onclick-menu">
            <ul class="onclick-menu-content">
                <li>Protips:</li>
                <li>Do not stack them like this <code>[rb][reich]I am funny ;)))[/reich][/rb]</code></li>
                <li>This will look like shit and also it wont work.</li>
                <li>Hit Enter 2x to make a normal paragraph. (Yes we are retarded)</li>
                <li>See <a href="/about#format">/about</a> for additional formatting options</li>
            </ul>
        </div>
    </div>
    </div>
</form>
</div>

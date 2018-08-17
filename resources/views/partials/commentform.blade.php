<div id="commentForm" class="hidden-xs">
<form action="{{action('CommentController@store', ['id' => $video->id])}}" method="post">
    {!! csrf_field() !!}
    <div class="panel panel-default">
        <div class="panel-body">
            {!! Form::textarea('comment', null, ['placeholder' => 'Write something', 'id' => 'cinput', 'class' => 'form-control', 'required' => 'required']) !!}
        </div>
    <div class="panel-footer"><button type="submit" class="btn btn-primary btn-sm">Post</button>
	   <a style="font-size: 14px; margin-left: 7px;" class="rainbow" href="javascript:;" onclick="formatText ('rb');">[rb]</a>
	   <a style="font-size: 14px;" class="reich" href="javascript:;" onclick="formatText ('reich');">[reich]</a>
	   <a style="font-size: 14px;" class="anim" href="javascript:;" onclick="formatText ('krebs');">[krebs]</a>
	   <a style="font-size: 14px; color: white;" class="spoiler" href="javascript:;" onclick="formatText ('spoiler');">[spoiler]</a>
        <div tabindex="0" class="onclick-menu">
            <ul class="onclick-menu-content">
                <li>Protips:</li>
                <li>Do not stack them like this <code>[rb][reich]I am funny ;)))[/reich][/rb]</code></li>
                <li>This will look like shit and also it wont work.</li>
                <li>Hit Enter 2x to make a normal paragraph. (Yes we are retarded)</li>
                <li>Link to a video on w0bm.com is easy but 99% of you do it wrong! <br> <code>Blah Blah Blah /1337</code> this will not resolve the full link, just paste the full link in there like this: <code>Blah Blah Blah https://w0bm.com/1337</code> and this will result in the following: <p>Blah Blah Blah <a href="https://w0bm.com/1337">/1337</a></li>
                <li>See <a href="/about#format">/about</a> for additional formatting options</li>
            </ul>
          </div>
    <div class="emoji-shit">
    <div class="header"><span>😂</span></div>
    </div>
    </div>
    <div style="display: none;" id="parent" class="emojis-box">
        <div data-simplebar data-simplebar-auto-hide="false" id="child" class="emojis">
            <a title=":weini:" href="javascript:;" onclick="formatTextEmoji ('weini');"><img class="comment_emoji_small" src="/images/comments/weini.png"></a>
            <a title=":uwe:" href="javascript:;" onclick="formatTextEmoji ('uwe');"><img class="comment_emoji_small" src="/images/comments/uwe.gif"></a>
            <a title=":tux:" href="javascript:;" onclick="formatTextEmoji ('tux');"><img class="comment_emoji_small" src="/images/comments/tux.png"></a>
            <a title=":tfwfat:" href="javascript:;" onclick="formatTextEmoji ('tfwfat');"><img class="comment_emoji_small" src="/images/comments/tfwfat.png"></a>
            <a title=":sadpepe:" href="javascript:;" onclick="formatTextEmoji ('sadpepe');"><img class="comment_emoji_small" src="/images/comments/sadpepe.png"></a>
            <a title=":retard:" href="javascript:;" onclick="formatTextEmoji ('retard');"><img class="comment_emoji_small" src="/images/comments/retard.png"></a>
            <a title=":knebel:" href="javascript:;" onclick="formatTextEmoji ('knebel');"><img class="comment_emoji_small" src="/images/comments/knebel.png"></a>
            <a title=":hans:" href="javascript:;" onclick="formatTextEmoji ('hans');"><img class="comment_emoji_small" src="/images/comments/hans.png"></a>
            <a title=":gnu:" href="javascript:;" onclick="formatTextEmoji ('gnu');"><img class="comment_emoji_small" src="/images/comments/gnu.gif"></a>
            <a title=":gimp:" href="javascript:;" onclick="formatTextEmoji ('gimp');"><img class="comment_emoji_small" src="/images/comments/gimp.png"></a>
            <a title=":geil:" href="javascript:;" onclick="formatTextEmoji ('geil');"><img class="comment_emoji_small" src="/images/comments/geil.png"></a>
            <a title=":coolpepe:" href="javascript:;" onclick="formatTextEmoji ('coolpepe');"><img class="comment_emoji_small" src="/images/comments/coolpepe.png"></a>
            <a title=":wednesday" href="javascript:;"onclick="formatTextEmoji ('wednesday');"><img class="comment_emoji_small" src="/images/comments/wednesday.png"></a>
        </div>
    </div>
    </div>
</form>
</div>

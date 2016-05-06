<form id="commentForm" action="{{action('VideoController@storeComment', ['id' => $video->id])}}" method="post">
    {!! csrf_field() !!}
    <div class="panel panel-default">
        <div class="panel-body">
            {!! Form::textarea('comment', null, ['placeholder' => 'Write something', 'class' => 'form-control', 'required' => 'required']) !!}
        </div>
    <div class="panel-footer"><button type="submit" class="btn btn-primary btn-sm">Post</button></div>
    </div>
</form>

<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Message;
use App\Models\ModeratorLog;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(!$request->has('username')) return JsonResponse::create('Not found', '304');
        $user = User::whereUsername(urldecode($request->get('username')))->first();
        if(!$user) return JsonResponse::create('Not found', '304');
        return $user->comments()->orderBy('id', 'desc')->paginate(10);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {
        $user = auth()->check() ? auth()->user() : null;
        $xhr = $request->ajax();

        if(is_null($user)) return $xhr ? "Not logged in" : redirect()->back()->with('error', 'Not logged in');
        if(!$request->has('comment')) return $xhr ? "You need to enter a comment" : redirect()->back()->with('error', 'You need to enter a comment');
        if(mb_strlen(trim($request->get('comment'))) > 1000 ) return $xhr ? "Comment to long" : redirect()->back()->with('error', 'Comment to long');

        $video = Video::findOrFail($id);

        $com = new Comment();
        $com->content = trim($request->get('comment'));
        $com->user()->associate($user);
        $com->video()->associate($video);
        $com->save();

        $sent = [];
        foreach($com->getMentioned() as $mentioned) {
            Message::send($user->id, $mentioned->id, $user->username . ' mentioned you in a comment', view('messages.commentmention', ['video' => $video, 'user' => $user]));
            $sent[] = $mentioned;
        }

        foreach($com->answered() as $answered) {
            if(array_search($answered, $sent) !== false)
                continue;
            Message::send($user->id, $answered->id, $user->username . ' answered on your comment', view('messages.commentanswer', ['video' => $video, 'user' => $user]));
            $sent[] = $answered;
        }

        if($user->id != $video->user->id)
            if(array_search($video->user, $sent) === false)
                Message::send($user->id, $video->user->id, $user->username . ' commented on your video', view('messages.videocomment', ['video' => $video, 'user' => $user]));

        return $xhr ? view('partials.comment', ['comment' => $com, 'mod' => $user->can('delete_comment')]) : redirect()->back()->with('success', 'Comment successfully saved');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $comment = Comment::whereId($id)->first();
        if(!is_null($comment)) {
            return JsonResponse::create(array(
                'error' => 'null',
                'comment' => Comment::whereId($id)->first()->content)
            );
        }
        return JsonResponse::create(array(
            'error' => 'comment_not_found'
        ));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if(!($request->has('comment')))
            return JsonResponse::create(array('error' => 'invalid_request'));

        $user = auth()->check() ? auth()->user() : null;
        if(is_null($user))
            return JsonResponse::create(array('error' => 'not_logged_in'));

        if(!$user->can('edit_comment'))
            return JsonResponse::create(array('error' => 'insufficient_permissions'));

        if(is_null($comment = Comment::whereId($id)->first()))
            return JsonResponse::create(array('error' => 'comment_not_found'));

        $comment->content = e(trim($request->get('comment')));
        $comment->save();

        $log = new ModeratorLog();
        $log->user()->associate($user);
        $log->type = 'edit';
        $log->target_type = 'comment';
        $log->target_id = $id;
        $log->save();

        return JsonResponse::create(array(
            'error' => 'null',
            'rendered_comment' => Comment::simplemd($comment->content)
        ));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        if(!$request->has('reason'))
            return 'invalid_request';

        $reason = $request->get('reason');
        if($reason == '')
            return 'invalid_request';

        $user = auth()->check() ? auth()->user() : null;
        if(is_null($user))
            return 'not_logged_in';

        if(!$user->can('delete_comment'))
            return 'insufficient_permissions';

        $comment = Comment::whereId($id)->first();
        if(is_null($comment))
            return 'comment_not_found';

        $receiver = $comment->user;
        $video = $comment->video;
        Comment::destroy($id);

        if($user->id != $receiver->id)
            Message::send($user->id, $receiver->id, $user->username . ' deleted your comment', view('messages.moderation.commentdelete', ['video' => $video, 'user' => $user, 'comment' => $comment, 'reason' => $reason]));

        $log = new ModeratorLog();
        $log->user()->associate($user);
        $log->type = 'delete';
        $log->target_type = 'comment';
        $log->target_id = $id;
        $log->save();

        return 'success';
    }
    
    public function restore(Request $request, $id)
    {
        if(!$request->has('reason'))
            return 'invalid_request';

        $reason = $request->get('reason');
        if($reason == '')
            return 'invalid_request';

        $user = auth()->check() ? auth()->user() : null;
        if(is_null($user))
            return 'not_logged_in';

        if(!$user->can('delete_comment'))
            return 'insufficient_permissions';

        $comment = Comment::withTrashed()->whereId($id)->first();
        if(is_null($comment))
            return 'comment_not_found';

        if(!$comment->trashed())
            return 'comment_not_deleted';

        $receiver = $comment->user;
        $video = $comment->video;
        $comment->restore();

        if($user->id != $receiver->id)
            Message::send($user->id, $receiver->id, $user->username . ' restored your comment', view('messages.moderation.commentrestore', ['video' => $video, 'user' => $user, 'comment' => $comment, 'reason' => $reason]));

        $log = new ModeratorLog();
        $log->user()->associate($user);
        $log->type = 'delete';
        $log->target_type = 'comment';
        $log->target_id = $id;
        $log->save();

        return 'success';
    }
}

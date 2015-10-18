<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Message;
use App\Models\ModeratorLog;
use App\Models\Video;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class VideoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return view('songindex', ['videos' => Video::orderBy('id', 'ASC')->paginate(20)]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
       return view('upload');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        $user = auth()->check() ? auth()->user() : null;
        if(is_null($user)) return redirect('/')->with('error', 'You need to be logged in');
        
        if(!$user->can('break_upload_limit') && $user->videos()->newlyups()->count() >= 100)
            return redirect()->back()->with('error', 'Uploadlimit reached')->withInput();
            
        
        if(!$request->hasFile('file'))
            return redirect()->back()->with('error', 'No file')->withInput();

        $file = $request->file('file');

        if(!$file->isValid()
        || $file->getClientOriginalExtension() != 'webm'
        || $file->getMimeType() != 'video/webm') return redirect()->back()->with('error', 'Invalid file');
        
        if(!$user->can('break_max_filesize') && $file->getSize() > 3e+7)
            return redirect()->back()->with('error', 'File to big. Max 30MB')->withInput();

        if(($v = Video::withTrashed()->where('hash', '=', sha1_file($file->getRealPath()))->first()) !== null)
            return redirect($v->id)->with('error', 'Video already exists');

        $file = $file->move(public_path() . '/b/', time() . '.webm');
        $hash = sha1_file($file->getRealPath());


        $video = new Video();
        $video->file = basename($file->getRealPath());
        $video->interpret = $request->get('interpret', null);
        $video->songtitle = $request->get('songtitle', null);
        $video->imgsource = $request->get('imgsource', null);
        $video->user()->associate($user);
        $video->category()->associate(Category::findOrFail($request->get('category')));
        $video->hash = $hash;
        $video->save();

        return redirect($video->id)->with('success', 'Upload successful');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $video = Video::find($id);
        if(is_null($video)) return redirect()->back()->with('error', 'No video with that ID found');

        return view('video', ['video' => $video]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Response
     */
    public function destroy($id)
    {
        $user = auth()->check() ? auth()->user() : null;

        if(is_null($user)) return redirect()->back()->with('error', 'Not logged in');

        if($user->can('delete_video')) {
            $vid = Video::find($id);
            foreach($vid->comments as $comment) {
                $comment->delete(); // delete associated comments
            }
            $vid->faved()->detach();
            if(!\File::move(public_path() . '/b/' . $vid->file, storage_path() . '/deleted/' . $vid->file))
                \Session::flash('warning', 'Could not move file');

            $vid->delete();

            $log = new ModeratorLog();
            $log->user()->associate($user);
            $log->type = 'delete';
            $log->target_type = 'video';
            $log->target_id = $id;
            $log->save();

            return redirect('/')->with('success', 'Video deleted');
        }
        return redirect()->back()->with('error', 'Insufficient permissions');
    }

    public function storeComment(Request $request, $id) {

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

        foreach($com->getMentioned() as $mentioned) {
            Message::send($user->id, $mentioned->id, $user->username . ' mentioned you in a comment', view('messages.commentmention', [$video, $user]));
        }

        Message::send($user->id, $video->user->id, $user->username . ' commented on your video', view('messages.videocomment', [$video, $user]));

        return $xhr ? view('partials.comment', ['comment' => $com, 'mod' => $user->can('delete_comment')]) : redirect()->back()->with('success', 'Comment successfully saved');
    }

    public function destroyComment($id) {
        $user = auth()->check() ? auth()->user() : null;
        if(is_null($user)) return redirect()->back()->with('error', 'Not logged in');

        if($user->can('delete_comment')) {
            Comment::destroy($id);

            $log = new ModeratorLog();
            $log->user()->associate($user);
            $log->type = 'delete';
            $log->target_type = 'comment';
            $log->target_id = $id;
            $log->save();

            return redirect()->back()->with('success', 'Comment deleted');
        }
        return redirect()->back()->with('error', 'Insufficient permissions');
    }

    public function restoreComment($id) {
        $user = auth()->check() ? auth()->user() : null;
        if(is_null($user)) return redirect()->back()->with('error', 'Not logged in');

        if($user->can('delete_comment')) {
            Comment::withTrashed()->whereId($id)->restore();

            $log = new ModeratorLog();
            $log->user()->associate($user);
            $log->type = 'restore';
            $log->target_type = 'comment';
            $log->target_id = $id;
            $log->save();

            return redirect()->back()->with('success', 'Comment restored');
        }
        return redirect()->back()->with('error', 'Insufficient permissions');
    }

    public function favorite($id) {
        $user = auth()->check() ? auth()->user() : null;
        $xhr = \Request::ajax();

        if(is_null($user)) return $xhr ? "Not logged in" : redirect()->back()->with('error', 'Not logged in');


        if($user->hasFaved($id)) {
            $user->favs()->detach($id);
            return $xhr ? "Video removed from favorites" : redirect()->back()->with('success', 'Video removed from favorites');
        } else {
            $user->favs()->attach($id);
            return $xhr ? "Video favorised" : redirect()->back()->with('success', 'Video favorised');
        }


    }
}

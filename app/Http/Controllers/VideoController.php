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
    public function index(Request $request)
    {
        if($request->has('q')){
            $needle = '%' . $request->input('q') .'%';
            return view('songindex', [
                'videos' => Video::where('interpret', 'LIKE', $needle)
                        ->orWhere('songtitle', 'LIKE', $needle)
                        ->orWhere('imgsource', 'LIKE', $needle)
                        //->orderBy('id', 'ASC')
                        ->orderByRaw("((interpret like '$needle') +
                            (songtitle like '$needle') +
                            (imgsource like '$needle')) desc")
                        ->paginate(20)->appends(['q' => trim($needle, '%')]),
                'categories' => Category::all()
            ]);

        }
        return view('songindex', [
            'videos' => Video::orderBy('id', 'ASC')->paginate(20),
            'categories' => Category::all()
        ]);
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

        if(!$user->can('break_upload_limit') && $user->videos()->newlyups()->count() >= 10)
            return redirect()->back()->with('error', 'Uploadlimit reached')->withInput();


        if(!$request->hasFile('file'))
            return redirect()->back()->with('error', 'No file')->withInput();

        $file = $request->file('file');

        if(!$file->isValid()
        || $file->getClientOriginalExtension() != 'webm'
        || $file->getMimeType() != 'video/webm') return redirect()->back()->with('error', 'Invalid file');

        if(!$user->can('break_max_filesize') && $file->getSize() > 31457280)
        return redirect()->back()->with('error', 'File too big. Max 30MB')->withInput();

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

        $this->createThumbnail(basename($file->getRealPath()));

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
        // GZ's kläglicher versuch:
        //if(!auth()->check()) return redirect('/irc')->with('error', 'You need to be logged in to view our content');

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
        if(!auth()->check())
            return response('Not logged in', 403);
        

        if(!$request->ajax())
            return response('Invalid request', 400);

        $v = Video::findOrFail($id);
        
        if(!auth()->user()->can('edit_video') && auth()->user()->id != $v->user_id)
            return response('Not enough permissions', 403);
        
        if($request->has('interpret'))
            $v->interpret = $request->input('interpret');
        if($request->has('songtitle'))
            $v->songtitle = $request->input('songtitle');
        if($request->has('imgsource'))
            $v->imgsource = $request->input('imgsource');
        if($request->has('category'))
            $v->category()
                ->associate(Category::findOrFail($request->input('category')));

        $v->save();

        return $v;
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
            Message::send($user->id, $mentioned->id, $user->username . ' mentioned you in a comment', view('messages.commentmention', ['video' => $video, 'user' => $user]));
        }

        if($user->id != $video->user->id)
            Message::send($user->id, $video->user->id, $user->username . ' commented on your video', view('messages.videocomment', ['video' => $video, 'user' => $user]));

        return $xhr ? view('partials.comment', ['comment' => $com, 'mod' => $user->can('delete_comment')]) : redirect()->back()->with('success', 'Comment successfully saved');
    }

    public function editComment($id) {

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
            return $xhr ? "Video added to favorites" : redirect()->back()->with('success', 'Video favorised');
        }


    }

    private function createThumbnail($dat) {
      $in = "/var/www/w0bm.com/public/b"; // webm-input
      $out = "/var/www/w0bm.com/public/thumbs"; // thumb-output
      $tmpdir = "/var/www/w0bm.com/app/Http/Controllers/tmp"; // tempdir

      $name = explode(".", $dat);
      array_pop($name);
      $name = join(".", $name);
      if(!file_exists("{$out}/{$name}.gif")) {
        $length = round(shell_exec("ffprobe -i {$in}/{$dat} -show_format -v quiet | sed -n 's/duration=//p'"));
        for($i=1;$i<10;$i++) {
          $act = ($i*10) * ($length / 100);
          $ffmpeg = shell_exec("ffmpeg -ss {$act} -i {$in}/{$dat} -vf \"scale='if(gt(a,4/3),206,-1)':'if(gt(a,4/3),-1,116)'\" -vframes 1 {$tmpdir}/{$name}_{$i}.png 2>&1");
        }
        $tmp = shell_exec("convert -delay 27 -loop 0 {$tmpdir}/{$name}_*.png {$out}/{$name}.gif 2>&1");
        if(@filesize("{$out}/{$name}.gif") < 2000)
          @unlink("{$out}/{$name}.gif");
        array_map('unlink', glob("{$tmpdir}/{$name}*.png"));
      }
    }
}

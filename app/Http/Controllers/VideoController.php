<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Message;
use App\Models\ModeratorLog;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class VideoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request) {
        if($request->has('q')){
            $needle = trim($request->input('q'));
            return view('index', [
                // TODO: add ordering
                'videos' => Video::withAllTags($needle)
                    ->paginate(20)->appends(['q' => $needle]),
                'categories' => Category::all(),
                'q' => $needle
            ]);

            // $pdo = \DB::connection()->getPdo();
            // $needle = '%' . trim($request->input('q')) .'%';
            // `songindex` will need to be changed due to the view name being changed to index.
            // return view('songindex', [
            //     'videos' => Video::where(function($query) use($needle) {
            //         $query->where('interpret', 'LIKE', $needle)
            //             ->orWhere('songtitle', 'LIKE', $needle)
            //             ->orWhere('imgsource', 'LIKE', $needle);
            //     })
            //             //->orderBy('id', 'ASC')
            //             ->orderByRaw("((interpret like " . $pdo->quote($needle) . ") +
            //                 (songtitle like " . $pdo->quote($needle) . ") +
            //                 (imgsource like " . $pdo->quote($needle) . ")) desc")
            //             ->paginate(20)->appends(['q' => trim($needle, '%')]),
            //     'categories' => Category::all()
            // ]);

        }
        return view('index', [
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
        $user = auth()->check() ? auth()->user() : null;
        return view('upload', ['user' => $user]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        if(!$request->hasFile('file') || !$request->has('category') || !$request->has('tags'))
            return new JsonResponse(['error' => 'invalid_request']);

        $tags = $request->get('tags');
        if(mb_strpos($tags, 'sfw') === false && mb_strpos($tags, 'nsfw') === false)
            return new JsonResponse(['error' => 'invalid_request']);

        $user = auth()->check() ? auth()->user() : null;
        if(is_null($user))
            return new JsonResponse(['error' => 'not_logged_in']);

        if(!$user->can('break_upload_limit') && $user->videos()->newlyups()->count() >= 35)
            return new JsonResponse(['error' => 'uploadlimit_reached']);

        $file = $request->file('file');

        if(!$file->isValid()
        || mb_strtolower($file->getClientOriginalExtension()) !== 'webm'
        || mb_strtolower($file->getMimeType()) !== 'video/webm')
            return new JsonResponse(['error' => 'invalid_file']);

        if(!$user->can('break_max_filesize') && $file->getSize() > 31457280)
            return new JsonResponse(['error' => 'file_too_big']);

        if(($v = Video::withTrashed()->where('hash', '=', sha1_file($file->getRealPath()))->first()) !== null) {
            if($v->trashed())
                return new JsonResponse(['error' => 'already_exists']);
            return new JsonResponse([
                'error' => 'already_exists',
                'video_id' => $v->id
            ]);
        }

        $file = $file->move(public_path() . '/b/', time() . '.webm');
        if(!$this->checkFileEncoding(basename($file->getRealPath()))) {
            unlink($file->getRealPath());
            return new JsonResponse(['error' => 'erroneous_file_encoding']);
        }

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

        $video->tag($tags);
        $video->tag($video->interpret);
        $video->tag($video->songtitle);
        $video->tag($video->imgsource);
        $video->tag($video->category->shortname);
        $video->tag($video->category->name);

        $this->createThumbnail(basename($file->getRealPath()));

        return new JsonResponse([
            'error' => 'null',
            'video_id' => $video->id
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id) {
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
    public function update(Request $request, $id) {
        if(!auth()->check())
            return response('Not logged in', 403);
        $user = auth()->user();

        if(!$request->ajax())
            return response('Invalid request', 400);

        $v = Video::findOrFail($id);
        
        if(!$user->can('edit_video') && $user->id != $v->user_id)
            return response('Not enough permissions', 403);
        
        if($request->has('interpret')) {
            $v->interpret = $request->input('interpret');
            $v->tag($request->input('interpret'));
        }
        if($request->has('songtitle')) {
            $v->songtitle = $request->input('songtitle');
            $v->tag($request->input('songtitle'));
        }
        if($request->has('imgsource')) {
            $v->imgsource = $request->input('imgsource');
            $v->tag($request->input('imgsource'));
        }
        if($request->has('category')) {
            $cat = Category::findOrFail($request->input('category'));
            $v->category()->associate($cat);
            $v->tag($cat->name);
            $v->tag($cat->shortname);
        }

        $v->save();

        $log = new ModeratorLog();
        $log->user()->associate($user);
        $log->type = 'edit';
        $log->target_type = 'video';
        $log->target_id = $v->id;
        $log->save();

        return $v;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Response
     */
    public function destroy(Request $request, $id)
    {
        $user = auth()->check() ? auth()->user() : null;

        if(is_null($user)) return new JsonResponse(['error' => 'not_logged_in']);

        if(!$request->has('reason') || trim($request->get('reason')) == '') return new JsonResponse(['error' => 'invalid_request']);

        $reason = trim($request->get('reason'));

        if($user->can('delete_video')) {
            $warnings = [];
            $vid = Video::find($id);
            if(!$vid)
                return new JsonResponse(['error' => 'video_not_found']);

            foreach($vid->comments as $comment) {
                $comment->delete(); // delete associated comments
            }
            $vid->faved()->detach();
            if(!\File::move(public_path() . '/b/' . $vid->file, storage_path() . '/deleted/' . $vid->file))
                $warnings[] = 'Could not move file';

            $vid->delete();
            $receiver = $vid->user;
            if($user->id != $receiver->id)
                Message::send(1, $receiver->id, 'A moderator deleted your video', view('messages.moderation.videodelete', ['video' => $vid, 'reason' => $reason, 'videoinfo' => ['artist' => $vid->interpret, 'songtitle' => $vid->songtitle, 'video_source' => $vid->imgsource, 'category' => $vid->category->name]]));

            $log = new ModeratorLog();
            $log->user()->associate($user);
            $log->type = 'delete';
            $log->target_type = 'video';
            $log->target_id = $id;
            $log->reason = $reason;
            $log->save();

            return new JsonResponse(['error' => 'null', 'warnings' => $warnings]);
        }
        return new JsonResponse(['error' => 'insufficient_permissions']);
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
            return $xhr ? "Video added to favorites" : redirect()->back()->with('success', 'Video added to favorites');
        }
    }

    /**
     * @param Request $request
     * @return Video | Bool
     */
    public function tag(Request $request, $id) {
        if(!$request->has('tags')) return new JsonResponse(["error" => "invalid_request"]);
        $tags = $request->get('tags');
        if(!count($tags)) return new JsonResponse(["error" => "no_tags_specified"]);
        $v = Video::findOrFail($id);
        if(is_null($v)) return new JsonResponse(["error" => "video_not_found"]);
        $v->tag($tags);
        $v['error'] = 'null';
        $v['can_edit_video'] = auth()->check() ? auth()->user()->can('edit_video') : false;
        return $v;
    }
    
    public function untag(Request $request, $id) {
        if(!$request->has('tag') || trim($request->get('tag')) == "") return new JsonResponse(["error" => "invalid_request"]);
        $user = auth()->check() ? auth()->user() : null;
        if(is_null($user)) return new JsonResponse(["error" => "not_logged_in"]);
        if(!$user->can('edit_video')) return new JsonResponse(["error" => "insufficient_permissions"]);
        $tag = trim($request->get('tag'));
        $v = Video::findOrFail($id);
        if(is_null($v)) return new JsonResponse(["error" => "video_not_found"]);
        $v = $v->untag($tag);
        $v['error'] = 'null';
        return $v;
    }

    private function checkFileEncoding($dat) {
        $in = "/var/www/w0bm.com/public/b"; // webm-input
        $tmpdir = "/var/www/w0bm.com/app/Http/Controllers/tmp"; // tempdir
        $name = explode(".", $dat);
        array_pop($name);
        $name = join(".", $name);
        $ret = shell_exec("ffmpeg -y -ss 0 -i {$in}/{$dat} -vframes 1 {$tmpdir}/test.png 2>&1");
        if(strpos($ret, "nothing was encoded") !== false) {
            return false;
        }
        return true;
    }

    /**
     * Creates a .gif thumbnail to a given video file
     *
     * @param string $dat File of the video
     */
    private function createThumbnail($dat) {
        $in = "/var/www/w0bm.com/public/b"; // webm-input
        $out = "/var/www/w0bm.com/public/thumbs"; // thumb-output
        $tmpdir = "/var/www/w0bm.com/app/Http/Controllers/tmp"; // tempdir

        $name = explode(".", $dat);
        array_pop($name);
        $name = join(".", $name);
        if(!file_exists("{$out}/{$name}.gif")) {
            $length = round(shell_exec("ffprobe -i {$in}/{$dat} -show_format -v quiet | sed -n 's/duration=//p'"));
            for ($i = 1; $i < 10; $i++) {
                $act = ($i * 10) * ($length / 100);
                $ffmpeg = shell_exec("ffmpeg -ss {$act} -i {$in}/{$dat} -vf \"scale='if(gt(a,4/3),206,-1)':'if(gt(a,4/3),-1,116)'\" -vframes 1 {$tmpdir}/{$name}_{$i}.png 2>&1");
            }
            $tmp = shell_exec("convert -delay 27 -loop 0 {$tmpdir}/{$name}_*.png {$out}/{$name}.gif 2>&1");
            if(@filesize("{$out}/{$name}.gif") < 2000)
                @unlink("{$out}/{$name}.gif");
            array_map('unlink', glob("{$tmpdir}/{$name}*.png"));
        }
    }
}

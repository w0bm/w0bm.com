<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Comment;
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
        if(!$request->hasFile('file'))
            return redirect()->back()->with('error', 'No file')->withInput();

        $file = $request->file('file');

        if(!$file->isValid()
        || $file->getClientOriginalExtension() != 'webm'
        || $file->getMimeType() != 'video/webm') return redirect()->back()->with('error', 'Invalid file');

        if(($v = Video::where('hash', '=', sha1_file($file->getRealPath()))->first()) !== null)
            return redirect($v->id)->with('error', 'Video already exists');

        $file = $file->move(public_path() . '/b/', time() . '.webm');
        $hash = sha1_file($file->getRealPath());


        $video = new Video();
        $video->file = basename($file->getRealPath());
        $video->interpret = $request->get('interpret', null);
        $video->songtitle = $request->get('songtitle', null);
        $video->imgsource = $request->get('imgsource', null);
        $video->user()->associate(auth()->user());
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
        if(is_null($video)) return redirect()->back(404)->with('error', 'No video with that ID found');

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
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

    public function storeComment(Request $request, $id) {

        $user = auth()->check() ? auth()->user() : null;

        if(is_null($user)) return redirect()->back()->with('error', 'Not logged in');
        if(!$request->has('comment')) return redirect()->back()->with('error', 'You need to enter a comment');
        if(mb_strlen(trim($request->get('comment'))) > 1000 ) return redirect()->back()->with('error', 'Comment to long');

        $video = Video::findOrFail($id);

        $com = new Comment();
        $com->content = trim($request->get('comment'));
        $com->user()->associate($user);
        $com->video()->associate($video);
        $com->save();

        return redirect()->back()->with('success', 'Comment successfully saved');
    }

    public function destroyComment($id) {
        $user = auth()->check() ? auth()->user() : null;
        if(is_null($user)) return redirect()->back()->with('error', 'Not logged in');

        if($user->can('delete_comment')) {
            Comment::destroy($id);
            return redirect()->back()->with('success', 'Comment deleted');
        }
        return redirect()->back()->with('error', 'Insufficient permissions');
    }
}

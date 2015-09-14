<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Video;
use Illuminate\Http\Request;

use App\Http\Requests;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Response
     */
    public function index()
    {
        return view('categories', ['categories' => Category::all()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return \Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $shortname
     * @param int $id
     * @return \Response
     */
    public function showVideo($shortname, $id = null)
    {
        $category = Category::whereShortname($shortname)->first();
        if(is_null($category)) return redirect()->back()->with('error', 'Category not found');
        if(is_null($id)) {
            $id = Video::whereCategoryId($category->id)->count();
            $id = rand(0, $id);
            $video = Video::whereCategoryId($category->id)->skip($id)->first();
            return redirect($shortname . '/' . $video->id);
        } else {
            $video = Video::whereCategoryId($category->id)->find($id);
        }
        if(is_null($video)) return redirect()->back()->with('error', 'No videos found.');

        return view('video', ['video' => $video, 'category' => true]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Response
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
     * @return \Response
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
        //
    }
}

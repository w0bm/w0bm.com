<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\ModeratorLog;

class ModerationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('moderation', ['logs' => ModeratorLog::all()]);
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function getModeratorLogs(Request $request) {
        $paginate = $request->get("paginate");
        if(isset($paginate) && is_numeric($paginate) && $paginate <= 100) {
            return ModeratorLog::orderBy('id', 'desc')->paginate($paginate);
        }
        return new JsonResponse(["error" => "invalid_request"]);
    }

    public function getUsers(Request $request) {
        $paginate = $request->get("paginate");
        $filter = $request->get("filter");
        if(isset($paginate) && is_numeric($paginate) && $paginate <= 100) {
            if(isset($filter) && is_array($filter)) {
                try {
                    return User::where($filter)->orderBy('id', 'desc')->paginate($paginate);
                }
                catch(QueryException $e) {
                    return new JsonResponse(["error" => "invalid_request"]);
                }
            }
            return User::orderBy('id', 'desc')->paginate($paginate);
        }
        return new JsonResponse(["error" => "invalid_request"]);
    }
}

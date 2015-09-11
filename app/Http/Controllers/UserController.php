<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Toddish\Verify\Helpers\Verify;

class UserController extends Controller
{

    public function login()
    {
        if(\Request::has('identifier') && \Request::has('password')) {
           switch(\Auth::verify([
                'identifier' => \Request::input('identifier'),
                'password' => \Request::input('password')
            ], \Request::has('remember')))
           {
               case Verify::SUCCESS:
                   return redirect('/')->with('success', 'Login successful');
               case Verify::INVALID_CREDENTIALS:
                   return redirect()->back()->with('error', 'Invalid credentials');
               case Verify::DISABLED:
                   return redirect()->back()->with('error', 'Account is disabled');
               case Verify::UNVERIFIED:
                   return redirect()->back()->with('error', 'Please verify your account');
           }
        }
    }
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return View('user.register');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $user = \App\Models\User::findOrFail($id);

        return View('user.profile', ['user' => $user]);
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
}

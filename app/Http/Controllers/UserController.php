<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

use Toddish\Verify\Helpers\Verify;

class UserController extends Controller
{
    /**
     * @param Request $request
     * @return \Response
     */
    public function login(Request $request)
    {
        if($request->has('identifier') && $request->has('password')) {
           switch(\Auth::verify([
                'identifier' => $request->get('identifier'),
                'password' => $request->get('password')
            ], $request->has('remember')))
           {
               case Verify::SUCCESS:
                   return redirect()->back()->with('success', 'Login successful');
               case Verify::INVALID_CREDENTIALS:
                   return redirect()->back()->with('error', 'Invalid credentials');
               case Verify::DISABLED:
                   return redirect()->back()->with('error', 'You are banned.');
               case Verify::UNVERIFIED:
                   return redirect()->back()->with('error', 'Please verify your account');
           }
        }
        return redirect()->back()->with('error', 'Missing credentials');
    }

    public function logout()
    {
        if(!auth()->check()) return redirect()->back()->with('warning', 'You are not logged in');

        auth()->logout();
        return redirect('/')->with('success', 'Logout successfull');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Response
     */
    public function create()
    {
        return view('register');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return \Response
     */
    public function store(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'username' => 'required|unique:users|min:3|max:25|alpha_num',
            'email' => 'required|email|unique:users|confirmed',
            'password' => 'required|min:6|confirmed'
        ]);

        if($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())
                ->withInput($request->except(['password', 'password_confirmation']));
        }

        $activation_token = str_random(8) . md5($request->get('email')) . str_random(10);

        $user = new User();
        $user->username = $request->get('username');
        $user->email = $request->get('email');
        $user->password = $request->get('password');
        $user->activation_token = $activation_token;
        $user->disabled = 0;
        $user->verified = 0;
        if($user->save()) {
            $data = [
                'username' => $user->username,
                'activation_token' => $activation_token
            ];

            // Send Mail

            \Mail::queue('emails.activation', $data, function($message) use ($user) {
                $message->to($user->email, $user->username)->subject('Welcome to w0bm. Activate your account');
            });

            return redirect('/')->with('info', 'Please activate your account to finish registration');
        } else {
            return redirect()->back()->with('error', 'Account could not be created')->withInput($request->except(['password', 'password_confirmation']));
        }
    }

    public function activate($token)
    {
        $user = User::where('activation_token', '=', $token)->first();
        if(!$user) {
            return redirect('/')->with('error', 'Account already activate or no account found');
        }
        $user->verified = 1;
        $user->activation_token = null;
        $user->save();
        auth()->login($user);
        return redirect('/')->with('success', 'Successfully activate and logged in.');
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $username
     * @return \Response
     */
    public function show($username)
    {
        $user = User::where('username', '=', $username)->first();

        if(!$user) {
            return redirect()->back()->with('error', 'Unknown username');
        }

        return view('profile', ['user' => $user]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  string  $username
     * @return \Response
     */
    public function edit($username)
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

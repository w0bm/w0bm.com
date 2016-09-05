<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\ModeratorLog;

use Symfony\Component\HttpFoundation\Response;
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
                   \Session::put('background', auth()->user()->background);
                   return redirect()->back()->with('success', 'Login successful');
               case Verify::INVALID_CREDENTIALS:
                   return redirect()->back()->with('error', 'Invalid credentials');
               case Verify::DISABLED:
                   $user = User::whereUsername($request->get('identifier'))
                           ->orWhere('email', $request->get('identifier'))
                           ->first();
                   if($user->banend->eq(Carbon::create(0,0,0,0,0,0))) {
                       return redirect()->back()->with('error', 'You are permanently banned for \'' . $user->banreason . '\'.');
                   }
                   // if ban expired unban and relogin.
                   if($user->banend->lt(Carbon::now())) {
                       $user->banend = null;
                       $user->disabled = 0;
                       $user->banreason = null;
                       $user->save();
                       return $this->login($request);
                   }
                   return redirect()->back()->with('error', 'You are banned for another ' .  $user->banend->diffForHumans(null, true) . '. Reason: \''. $user->banreason .'\'');
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

    public function filter(Request $request) {
        //dd($request->get('categories'));
        if(!auth()->check())
            return Response::create("Not logged in", 401);
        if(!$request->has('categories') || empty($request->get('categories')))
            return Response::create("Need to select at least 1 category", 500);

        $allcats = Category::lists('id')->toArray();
        sort($allcats);
        $categories = $request->get('categories');
        sort($categories);
        foreach($categories as $cat) {
            if(!in_array($cat, $allcats))
                return Response::create("Invalid Category id: " . $cat, 500);
        }

        auth()->user()->categories = $categories;
        auth()->user()->save();

        if(!$request->ajax())
            return redirect()->back()->with('success', 'Filter settings saved');


        return Response::create($categories);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Response
     */
    public function create()
    {
        if(auth()->check()) {
            \Session::reflash();
            \Session::flash('info', 'Cannot register when logged in');
            return redirect('/');
        }
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
        if(auth()->check()) return redirect()->back()->with('info', 'Cannot register when logged in');
        $validator = \Validator::make($request->all(), [
            'username' => 'required|unique:users|min:3|max:25|alpha_num',
            'email' => 'required|email|unique:users|confirmed',
            'password' => 'required|min:6|confirmed',
            'g-recaptcha-response' => 'required|recaptcha'
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
        $user->categories = Category::lists('id');
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

	public function show_favs($username)
	{
    	$user = User::where('username', '=', $username)->first();

    	if(!$user) {
            return redirect()->back()->with('error', 'Unknown username');
    	}

    	return view('favs', ['user' => $user]);
	}

    public function show_comments($username)
	{
    	$user = User::where('username', '=', $username)->first();

    	if(!$user) {
            return redirect()->back()->with('error', 'Unknown username');
    	}

    	return view('comments', ['user' => $user]);
	}

    public function ban(Request $request, $username)
    {
        if(!($request->has('reason') && $request->has('duration')))
            return redirect()->back()->with('error', 'Invalid Request');

        if(trim($reason = $request->get('reason')) == '')
            return redirect()->back()->with('error', 'You need to specify a ban reason');

        $user = auth()->check() ? auth()->user() : null;
        if(is_null($user))
            return redirect()->back()->with('error', 'Not logged in');

        if(!$user->can('edit_user'))
            return redirect()->back()->with('error', 'Insufficient permissions');
        
        $perm = false;
        if(($duration = $request->get('duration')) == '-1') {
            $duration = Carbon::create(0,0,0,0,0,0);
            $perm = true;
        } else {
            preg_match('/^(\d+[yYaA])?\s*(\d+M)?\s*(\d+[wW])?\s*(\d+[dD])?\s*(\d+[Hh])?\s*(\d+[m])?\s*(\d+[sS])?$/m', $duration, $duration);
            array_shift($duration);
            $duration = array_map(function($elem) {
                return intval(mb_substr($elem, 0, -1));
            }, $duration);
            $duration = Carbon::now()
                ->addYears($duration[0] ?? 0)
                ->addMonths($duration[1] ?? 0)
                ->addWeeks($duration[2] ?? 0)
                ->addDays($duration[3] ?? 0)
                ->addHours($duration[4] ?? 0)
                ->addMinutes($duration[5] ?? 0)
                ->addSeconds($duration[6] ?? 0);
        }

        $userToBan = User::whereUsername($username)->first();
        if(is_null($user))
            return redirect()->back()->with('error', 'User not found');

        $userToBan->disabled = 1;
        $userToBan->banreason = $reason;
        $userToBan->banend = $duration;
        $userToBan->save();

        $log = new ModeratorLog();
        $log->user()->associate($user);
        $log->type = 'ban';
        $log->target_type = 'user';
        $log->target_id = $userToBan->id;
        $log->save();

        if($perm)
            return redirect()->back()->with('success', 'User ' . $userToBan->username . ' has been permanently banned');
        else
            return redirect()->back()->with('success', 'User ' . $userToBan->username . ' has been banned until ' . $userToBan->banend->format('d.m.Y H:i:s') . ' UTC');
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

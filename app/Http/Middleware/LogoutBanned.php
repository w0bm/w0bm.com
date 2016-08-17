<?php

namespace App\Http\Middleware;

use Closure;

class LogoutBanned
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = auth()->user();
        if($user && $user->isBanned()) {
            auth()->logout();
            return redirect()->back()->with('error', 'You are banned');
        }
        return $next($request);
    }
}

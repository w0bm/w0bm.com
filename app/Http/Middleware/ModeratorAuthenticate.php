<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\JsonResponse;

class ModeratorAuthenticate
{
    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;

    /**
     * Create a new filter instance.
     *
     * @param  Guard  $auth
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!$this->auth->check() || !$this->auth->user()->is('Moderator') && !$this->auth->user()->is('Super Admin')) {
            if ($request->ajax()) {
                return new JsonResponse(['message' => 'Forbidden', 'code' => 403]);
            } else {
                return response('Forbidden', 403);
            }
        }
        return $next($request);
    }
}

<?php

namespace App\Http\Middleware;

use Closure;

class Jsonp {
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);
        
        if ($response->headers->get('content-type') == 'application/json'
            && $request->has('callback'))
        {
            // TODO fix stripping headers
            $response = response()->json($response->original)->setCallback($request->input('callback'));
        }

        return $response;
    }
}
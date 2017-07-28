<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;

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
            if (get_class($response) == JsonResponse::class) {
                return $response->setCallback($request->input('callback'));
            }
            // TODO fix stripping headers
            return response()->json($response->original)->setCallback($request->input('callback'));
        }

        return $response;
    }
}
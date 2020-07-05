<?php

namespace App\Http\Middleware;

use Closure;

class RiderMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = 'rider')
    {
        if(!auth()->guard($guard)->check()) {
            return response()->json(['Unauthenticated']);
        }

         return $next($request);
    }
}

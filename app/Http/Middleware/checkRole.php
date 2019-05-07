<?php

namespace App\Http\Middleware;

use Closure;

class checkRole
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
//        return $next($request);
        if (!$request->user()->premium_user) {
            // Redirect...
            return response()->json(['status' => 'Unauthorised service only for premium users'], 401);

        }
        return $next($request);
    }
}

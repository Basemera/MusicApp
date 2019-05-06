<?php

namespace App\Http\Middleware;
use Closure;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use App\Models\User1;


class AuthMiddleware
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

        $token = $request->header('Authorization');
        if (!$token) {
            return response()->json([
                'error' => 'Token not provided.'
            ], 401);
        }
        try {
            $credentials = JWT::decode($token, env('JWT_SECRET'), ['HS256']);
        } catch (ExpiredException $e) {
            return response()->json([
                'error' => 'Provided token is expired.'
            ], 400);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'An error while decoding token.'
            ], 400);
        }
        $user = User1::find($credentials->sub);
        if (($request->route()[2]['id']) == $user->id) {
            $request->auth = $user;
            return $next($request);
        }
        else{
        return response()->json([
                'error' => 'Unauthorized access'
            ], 400);
    }
    }

}

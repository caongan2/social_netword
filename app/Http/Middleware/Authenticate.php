<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;
class Authenticate
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    // protected function redirectTo($request)
    // {
    //     if (! $request->expectsJson()) {
    //         return route('login');
    //     }
    // }

    public function handle(Request $request, Closure $next)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
        } catch (JWTException $e) {
            if($e instanceof TokenExpiredException) {
                return response()->json([
                    'error_code' => 1,
                    'message' => 'token het han',
                    'data' => []
                ]);
            }else if ($e instanceof TokenInvalidException) {
                return response()->json([
                    'error_code' => 2,
                    'message' => 'token ko dung',
                    'data' => []
                ]);
            }else{
                return response()->json([
                    'error_code' => 3,
                    'message' => 'token ko co',
                    'data' => []
                ]);
            }
        }
        return $next($request);
    }
}

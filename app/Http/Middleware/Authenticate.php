<?php

namespace App\Http\Middleware;

use App\Http\Controllers\Utils\ResponseCodes;
use App\Http\Controllers\Utils\ResponseKeys;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Str;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if($request->expectsJson()) {
            return route('login');
        }

//        $url = $request->getRequestUri();
//        if(Str::contains($url, "exam") && !$request->expectsJson()) {
//            return route('login');
//        }
//
//        if (Str::contains($url, "api") && !$request->expectsJson()) {
//            return response()->json([
//                ResponseKeys::CODE => ResponseCodes::CODE_UNAUTHORIZED,
//                ResponseKeys::MESSAGE => "Oturum açmanız gerekli!"
//            ]);
//        }
    }
}

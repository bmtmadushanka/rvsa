<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckVerifiedMiddleware
{
    public function handle($request, Closure $next)
    {
        if (Auth::user()->is_verified) {
            return $next($request);
        }

        return redirect()->route('verify_mobile.prompt');
    }
}

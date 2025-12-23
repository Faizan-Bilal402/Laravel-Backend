<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle($request, Closure $next)
    {
        if (!Auth::guard('web')->check() || Auth::guard('web')->user()->is_admin != 1) {
            return redirect('/login');
        }

        return $next($request);
    }
}

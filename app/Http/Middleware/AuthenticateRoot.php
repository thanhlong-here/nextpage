<?php

namespace App\Http\Middleware;

use Closure;

class AuthenticateRoot
{
    public function handle($request, Closure $next)
    {
        return auth()->user()->is_root ? $next($request) : abort(401);
    }
}

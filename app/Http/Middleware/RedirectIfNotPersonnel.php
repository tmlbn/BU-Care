<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfNotPersonnel
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next, $guard="employee")
    {
        if(!auth()->guard('employee')->check()) {
            return redirect()->route('home')->with('fail', 'Invalid user type. Please login as Personnel.');
        }
        return $next($request);
    }
}

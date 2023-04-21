<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAnyAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        if(!auth()->check() &&
           !auth()->guard('employee')->check() &&
           !auth()->guard('admin')->check()) {
            return redirect()->route('home')->with('fail', 'Please login.');
        }
        return $next($request);
    }
}

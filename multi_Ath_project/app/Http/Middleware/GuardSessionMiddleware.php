<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use Config;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class GuardSessionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if($request->is('admin/*')){
            Config::set('session.cookie', 'admin_session');
        }elseif (Auth::guard('web')->check()){
            Config::set('session.cookie', 'user_session');
        }
        return $next($request);
    }
}

<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticatedMiddleware
{
    protected $guard;
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */

    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        
        // dd($guards);
        foreach ($guards as $key => $guard) {
            if(Auth::guard($guard)->check()){
                if($guard == 'admin'){
                    return redirect('admin/dashboard');
                }
                return redirect('user/dashboard');
            }
        }
        
        return $next($request);
    }
}

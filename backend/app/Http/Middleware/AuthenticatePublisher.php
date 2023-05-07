<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticatePublisher
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle($request, Closure $next, $guard = 'publisher')
    {
     
        if (!Auth::guard($guard)->check()) {
            if ($request->ajax()) {
                // $error['message'] = ['Authorization failed'];
                return response()->json([], 401);
            }
        
            return redirect()->route('publisher.login');
        }
        
        // return     Auth::guard('publisher')->user();
        return $next($request);
    }
}

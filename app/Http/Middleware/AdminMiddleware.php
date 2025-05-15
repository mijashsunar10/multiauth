<?php

namespace App\Http\Middleware;

use App\Enums\UserRole;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(auth()->user()->role != UserRole::Admin)
        {
            return redirect()->route('dashboard');
        }
        //if user is not admin then return back to the dashboard 
        //MIddleware is the fileter or gatekeeper for the HTTP request in laravel.It checks or modifies the request before it reach to the controller
        // It checks if the logged-in user's role is not Admin.If they’re not an Admin, they get redirected to a generic user dashboard.Otherwise, the request continues to the next step (e.g., the controller).
        return $next($request);
    }
}

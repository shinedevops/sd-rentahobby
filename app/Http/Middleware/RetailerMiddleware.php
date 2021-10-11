<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Auth;

class RetailerMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // dd([Auth::user(), Auth::user()->role, Auth::user()->role->name]);
        if (Auth::user()->role->name != 'retailer' && Auth::user()->role->name != 'individual') {
            abort(403, 'Unauthorized');
        }

        return $next($request);
    }
}

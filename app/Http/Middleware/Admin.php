<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Admin
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
        if (auth()->check() && !auth()->user()->is_admin == 1) {
            if ($request->wantsJson()) {
                return response()->json(['Message', 'You can not access this Area.'], 403);
            }
            abort(403, 'You can not access this Area.');
        }
        return $next($request);
    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class CheckRoll
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::user()->role == 2) {
            return redirect('customer/home');
        }
        return $next($request);
    }
}

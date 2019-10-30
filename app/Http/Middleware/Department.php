<?php

namespace App\Http\Middleware;

use Closure;

class Department
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
        if(auth()->user()->u_type == 3 OR auth()->user()->u_type == 4 OR auth()->user()->u_type == 5 AND auth()->user()->u_status == 1 ){
        return $next($request);
    }
        return redirect('login')->with('error','You do not have access');
    }
}

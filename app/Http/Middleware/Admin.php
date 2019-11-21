<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Session\Store;
use Illuminate\Support\Facades\Auth;

class Admin
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
        
        if(Auth::check())
        {
           if(auth()->user()->u_status == 1)
            {  
                if(auth()->user()->u_type == 1 OR auth()->user()->u_type == 2 )
                {
                    return $next($request);
                }
            }
            else
            {
                return redirect('home')->with('error','You do not have access');
            }
            
        }
        return redirect('login')->with('error','You do not have access');
    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Auth;

class AccountSuspend
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if ( Auth::check())
        {   
            if(Auth::user()->status ==3)
            {
                return redirect('/404');
            }
            else if(Auth::user()->status ==1)
            {
                return redirect('/profile');
            }
            else{
                return $next($request);
            }
            
        }
        else{

              return redirect()->route('sign-up');
        }
    }
}

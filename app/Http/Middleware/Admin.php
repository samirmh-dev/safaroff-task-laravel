<?php

namespace App\Http\Middleware;

use Closure;
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
    	//hazirki istifadecinin sisteme daxil oldugunu ve admin statusuna
	    //sahib olugunu yoxlayir
	    //
	    //eger deyilse esas sehifeye yonlendirir
	    if ( Auth::check() && Auth::user()->isadmin() )
	    {
		    return $next($request);
	    }

	    return redirect('/');
    }
}

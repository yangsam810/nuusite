<?php

namespace App\Http\Middleware;

use Closure;

class AuthUserMiddleware
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
		$isAllowAccess = false;
		if(session()->get('userLogin'))
		{
			$isAllowAccess = true;
		}
		
		if(!$isAllowAccess)
		{
			return redirect('/site/'.$request->unit.'/login');
		}
		
        return $next($request);
    }
}

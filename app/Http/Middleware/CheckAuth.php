<?php

namespace App\Http\Middleware;

use Closure;
use Session;
use Sangria\JSONResponse;

class CheckAuth
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
        if(Session::has('user_id'))
            return $next($request);
        else{
            return redirect('/login');
        }
        
    }
}

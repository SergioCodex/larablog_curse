<?php

namespace App\Http\Middleware;

use Closure;

class CheckAdminRol
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

        if(auth()->user()->rol->key == 'admin'){
            return $next($request);
        }

        return redirect('/');
    }
}

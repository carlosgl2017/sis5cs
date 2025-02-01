<?php

namespace sis5cs\Http\Middleware;

use Closure;

class OperacionesMiddleware
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
        if(!(auth()->user()->id_rol==9))
        {
            return redirect('operaciones/dashboard/');
        }
        return $next($request);
    }
}

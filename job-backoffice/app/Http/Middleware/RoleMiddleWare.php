<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleWare
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next , ...$roles): Response
    {
        // check has no role
        if(auth()->check())
        {
            $role = auth()->user()->role;
            $hasRole = in_array($role, $roles);

            if(!$hasRole)
            {
                abort(403, 'Unauthorized action.');
            }
        }
        
        //  has access
        return $next($request);
    }
}

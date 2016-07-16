<?php

namespace App\Http\Middleware;

use Gate;
use Closure;
use Illuminate\Auth\Access\AuthorizationException;

class Authorized
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @param $ability
     * @param $resource
     *
     * @return mixed
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function handle($request, Closure $next, $ability, $resource = null)
    {
        if (Gate::denies($ability, $request->{$resource})) {
            throw new AuthorizationException;
        }
        return $next($request);
    }
}

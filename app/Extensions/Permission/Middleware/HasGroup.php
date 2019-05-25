<?php

namespace App\Extensions\Permission\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Extensions\Permission\Group;

class HasGroup
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $groupKey = 'default')
    {
        if (!Auth::guest()) {
            if (isset(Group::getInstances()[strtoupper($groupKey)])) {
                if (Auth::user()->hasGroup(Group::getInstances())) {
                    return $next($request);
                }
            }
        }

        abort(403);
    }
}

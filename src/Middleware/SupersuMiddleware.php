<?php

namespace Rakshitbharat\Supersu\Middleware;

use Auth;
use Closure;

class SupersuMiddleware
{
    /**
     * Run the request filter.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        return $next($request);
    }
}

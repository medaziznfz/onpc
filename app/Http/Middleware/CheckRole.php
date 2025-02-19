<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  mixed  ...$roles
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // Check if the authenticated user's role is in the provided roles.
        if (!$request->user() || ! in_array($request->user()->role, $roles)) {
            // Optionally, you can redirect or abort with a 403 error.
            abort(403, 'Unauthorized action.');
        }

        return $next($request);
    }
}
<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // Split roles by '|' and check if the user's role matches any of them
        $roles = explode('|', $role);

        if (Auth::check() && in_array(Auth::user()->role, $roles)) {
            return $next($request);
        }

        // Redirect or abort if the user doesn't have access
        return response('Unauthorized access.', 403);
    }
}

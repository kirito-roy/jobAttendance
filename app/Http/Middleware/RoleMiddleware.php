<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request   $request
     * @param  \Closure                   $next
     * @param  string                     $roles (pipe-separated, e.g. "admin|manager")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next, string $roles): Response
    {
        if (!Auth::check()) {
            return response('Unauthorized: Not logged in.', 403);
        }

        $user = Auth::user();
        $allowedRoles = explode('|', $roles);

        // Ensure roles relationship is loaded
        if ($user->roles->pluck('role')->intersect($allowedRoles)->isNotEmpty()) {
            return $next($request);
        }

        return response('Unauthorized: Insufficient role.', 403);
    }
}

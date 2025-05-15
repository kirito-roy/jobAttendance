<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{

    public function handle(Request $request, Closure $next, string $role): Response
    {
        $roles = explode('|', $role);

        if (Auth::check() && in_array(Auth::user()->role, $roles)) {
            return $next($request);
        }

        return response('Unauthorized access.', 403);
    }
}

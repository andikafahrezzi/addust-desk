<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(
        Request $request,
        Closure $next,
        ...$roles
    ): Response {

        $user = Auth::user();

        if (!$user) {
            abort(403);
        }

        $userRole = strtoupper($user->role->name);

        if (!in_array($userRole, $roles)) {
            abort(403);
        }

        return $next($request);
    }
}
<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $user = Auth::user();

        if (! $user || ! in_array($user->role, $roles, true)) {
            if ($user && $user->role === 'pelanggan') {
                return redirect()->route('pelanggan.dashboard');
            }

            if ($user && $user->role === 'owner') {
                return redirect()->route('dashboard');
            }

            abort(403);
        }

        return $next($request);
    }
}
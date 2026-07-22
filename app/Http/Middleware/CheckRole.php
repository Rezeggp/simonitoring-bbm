<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // 1. Cek apakah user sudah login
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        // 2. Cek apakah role user saat ini ada di dalam list role yang diizinkan
        if (!in_array($request->user()->role, $roles)) {
            abort(403, 'User does not have the right roles.');
        }

        return $next($request);
    }
}
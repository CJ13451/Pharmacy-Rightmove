<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LoginWall
{
    /**
     * Routes that are accessible without authentication.
     */
    protected array $publicRoutes = [
        '/',
        'login',
        'register',
        'forgot-password',
        'reset-password/*',
        'verify-email/*',
        'email/verification-notification',
        'terms',
        'privacy',
        'seed-db',
        'stripe/webhook',
        'admin',
        'admin/*',
        'livewire/*',
    ];

    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Allow authenticated users through
        if (auth()->check()) {
            return $next($request);
        }

        // Check if current path matches any public route
        $path = $request->path();

        // Always allow Filament admin paths (it has its own auth)
        if (str_starts_with($path, 'admin') || str_starts_with($path, 'filament')) {
            return $next($request);
        }

        foreach ($this->publicRoutes as $pattern) {
            if ($this->pathMatches($path, $pattern)) {
                return $next($request);
            }
        }

        // Redirect unauthenticated users to login
        if ($request->expectsJson()) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }

        return redirect()->route('login')->with('message', 'Please sign in to access this content.');
    }

    /**
     * Check if path matches the given pattern.
     */
    protected function pathMatches(string $path, string $pattern): bool
    {
        // Exact match
        if ($path === $pattern) {
            return true;
        }

        // Wildcard match
        if (str_ends_with($pattern, '/*')) {
            $prefix = substr($pattern, 0, -2);
            return str_starts_with($path, $prefix);
        }

        return false;
    }
}

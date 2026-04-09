<?php

use App\Http\Middleware\LoginWall;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Apply login wall to web routes
        $middleware->web(append: [
            LoginWall::class,
        ]);

        // Alias for route middleware
        $middleware->alias([
            'login.wall' => LoginWall::class,
        ]);

        // Exclude Stripe webhook from CSRF verification
        $middleware->validateCsrfTokens(except: [
            'stripe/webhook',
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();

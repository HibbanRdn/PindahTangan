<?php

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
        // Trust Cloudflare Tunnel proxy
        $middleware->trustProxies(at: '*');

        // Daftarkan alias middleware 'role'
        $middleware->alias([
            'role' => \App\Http\Middleware\RoleMiddleware::class,
        ]);

        // Kecualikan webhook dari CSRF verification
        $middleware->validateCsrfTokens(except: [
            'webhook/sakurupiah',
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
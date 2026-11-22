<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    
    ->withMiddleware(function (Middleware $middleware): void {

    $middleware->alias([
        'role' => \App\Http\Middleware\CheckRole::class,
    ]);

    // Redirect pengguna yang belum login
    $middleware->redirectGuestsTo(function (Request $request) {

        // Halaman khusus pembeli
        if (
            $request->is('checkout') ||
            $request->is('user/account') ||
            $request->is('user/logout')
        ) {
            return route('login');
        }

        // Halaman admin
        return route('login');
    });

    })
        
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*') || $request->expectsJson(),
        );
    })->create();

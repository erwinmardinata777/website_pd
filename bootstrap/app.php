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
        // ✅ Hanya apply TrackVisitor, bukan IdentifyTenant secara global
        $middleware->web(append: [
            \App\Http\Middleware\TrackVisitor::class,
        ]);

        // ✅ JANGAN tambahkan IdentifyTenant di sini!
        // Kita akan apply via routes/web.php saja
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();

<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'permission' => \App\Http\Middleware\CheckPermission::class,
        ]);
        $middleware->redirectGuestsTo(function ($request) {
            if (!$request->expectsJson()) {
                if (in_array('auth:admin', $request->route()->middleware())) {
                    if (!auth('admin')->check()) {
                        return route('admin.templates.index');
                    }
                }
            }
        });
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();

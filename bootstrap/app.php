<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Http\Request;

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
        $middleware->api(prepend: [
            \App\Http\Middleware\JsonResponseMiddleware::class,
        ]);
        $middleware->redirectGuestsTo(function ($request) {
            if (!$request->expectsJson()) {
                if (in_array('auth:admin', $request->route()->middleware())) {
                    if (!auth('admin')->check()) {
                        return route('admin.dashboard.index');
                    }
                }
            }
        });
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (NotFoundHttpException $e, Request $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'message' => 'Page not found.'
                ], 404);
            }
        });
    })->create();

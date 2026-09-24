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
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'admin.auth' => \App\Http\Middleware\AdminAuth::class,
            'super_or_co_admin' => \App\Http\Middleware\SuperOrCoSuperAdmin::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (\Illuminate\Http\Exceptions\PostTooLargeException $e, \Illuminate\Http\Request $request) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Ukuran file yang diunggah terlalu besar melebihi batas konfigurasi server.'
                ], 413);
            }
            return back()->with('error', 'Ukuran file yang Anda unggah terlalu besar dan melebihi batas kapasitas server (POST data too large). Harap unggah file foto maks. 10MB atau video maks. 150MB.');
        });
    })->create();

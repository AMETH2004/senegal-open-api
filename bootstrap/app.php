<?php

use App\Http\Middleware\VerifierCleApi;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'cle-api' => VerifierCleApi::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // API pure : toute réponse d'erreur est en JSON, y compris les 404
        // de route inconnue (pas de vues Blade à rendre ici).
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*') || $request->expectsJson(),
        );
    })->create();

<?php

use App\Http\Middleware\ClientMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\CheckUserRole;



// return Application::configure(basePath: dirname(__DIR__))
//     ->withRouting(
//         web: __DIR__ . '/../routes/web.php',
//         commands: __DIR__ . '/../routes/console.php',
//         health: '/up',
//     )
//     ->withMiddleware(function (Middleware $middleware) {
//         $middleware->alias(['ownerLogin' => CheckUserRole::class]);
//     })
//     ->withMiddleware(function (Middleware $middleware) {

//         $middleware->alias(['clientLogin' => ClientMiddleware::class]);
//     })
//     ->withExceptions(function (Exceptions $exceptions) {
//         //
//     })->create();


return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Register the middleware aliases
        $middleware->alias([
            'ownerLogin' => \App\Http\Middleware\CheckUserRole::class,
            'clientLogin' => \App\Http\Middleware\ClientMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();

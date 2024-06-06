<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Symfony\Component\Routing\Alias;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'role' => \App\Http\Middleware\CheckUserRole::class,
            'accountant' => \App\Http\Middleware\CheckAccountantRole::class,
            'seller' => \App\Http\Middleware\CheckSellerRole::class,
            'manager' => \App\Http\Middleware\CheckManagerRole::class,
            'warehouse' => \App\Http\Middleware\CheckWarehouseStaffRole::class,
            'customer-service' => \App\Http\Middleware\CheckCustomerServiceRole::class,
            'checklaptop' => \App\Http\Middleware\CheckLaptop::class
        ]);
        $middleware->validateCsrfTokens(except: [
            'stripe/',
            'http://example.com/foo/bar/',
            'http://example.com/foo/',
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();

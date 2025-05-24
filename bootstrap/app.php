<?php

use App\Http\Middleware\allTeamApprove;
use App\Http\Middleware\CheckProgressAcceptAccess;
use App\Http\Middleware\RegisDeadline;
use Fruitcake\Cors\CorsService;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Middleware\HandleCors;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'auth' => Illuminate\Auth\Middleware\Authenticate::class,
            'guest' => Illuminate\Auth\Middleware\RedirectIfAuthenticated::class,
            'role' => \Spatie\Permission\Middleware\RoleMiddleware::class,
            'permission' => \Spatie\Permission\Middleware\PermissionMiddleware::class,
            'role_or_permission' => \Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class,
            'checkProgressAccess' => \App\Http\Middleware\CheckProgressAccess::class,
            'checkProgressAcceptAccess' => CheckProgressAcceptAccess::class,
            'allTeamApprove' => allTeamApprove::class,
            'RegisDeadline' => RegisDeadline::class,
            
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();

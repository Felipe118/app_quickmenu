<?php

use App\Exceptions\SistemException;
use App\Http\Middleware\ForceJsonResponse;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful;
use Spatie\Permission\Exceptions\UnauthorizedException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->group('api', [
            EnsureFrontendRequestsAreStateful::class,
            ForceJsonResponse::class,
        ]);

        $middleware->alias([
            'role' => \Spatie\Permission\Middleware\RoleMiddleware::class,
            'permission' => \Spatie\Permission\Middleware\PermissionMiddleware::class,
            'role_or_permission' => \Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class,
        ]);
      
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->renderable(
            function (SistemException $e, $request) {
                return response()->json([
                    'message' => $e->getMessage(),
                ], $e->getCode());
            }
        );
        $exceptions->renderable(
            function (UnauthorizedException $e, $request ) {
                return response()->json([
                    'message' => 'Você não tem permissão para acessar este recurso.',
                ], 403);
            }
        );
            
    })->create();